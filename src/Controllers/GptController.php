<?php

namespace Sebastienheyd\Boilerplate\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Sebastienheyd\Boilerplate\Ai\AiStreamer;

class GptController
{
    /**
     * Show "Generate text with GPT" form.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        return view('boilerplate::gpt.layout', ['selected' => $request->get('selected') === '1']);
    }

    /**
     * Generate the prompt to pass to the OpenAI API.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function process(Request $request)
    {
        if ($request->post('tab') === 'generator') {
            return $this->processGenerator($request);
        }

        if ($request->post('tab') === 'prompt') {
            return $this->processPrompt($request);
        }

        if ($request->post('tab') === 'rewrite') {
            return $this->processRewrite($request);
        }

        abort(404);
    }

    /**
     * Process rewrite / summarize / ...
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    private function processRewrite(Request $request)
    {
        $validator = Validator::make($request->post(), [
            'original-content' => 'required',
            'language'         => 'required_if:type,translate',
        ], [], [
            'original-content' => __('boilerplate::gpt.form.rewrite.original'),
            'language'         => __('boilerplate::gpt.form.language'),
            'translate'        => __('boilerplate::gpt.form.translate'),
        ]);

        if ($validator->fails()) {
            $request->flash();
            $view = view('boilerplate::gpt.rewrite')->withErrors($validator->errors());
            View::share('errors', $view->errors);

            return response()->json(['success' => false, 'tab' => 'gpt-rewrite', 'html' => $view->render()]);
        }

        $key = 'gpt-'.Str::random();
        Cache::put($key, $this->buildRewritePrompt($request), 90);

        $json = ['success' => true, 'id' => $key];

        if (in_array($request->post('type'), ['question', 'title'])) {
            $json['prepend'] = true;
        }

        if (in_array($request->post('type'), ['conclusion', 'counterargument'])) {
            $json['append'] = true;
        }

        return response()->json($json);
    }

    /**
     * Process wizard.
     *
     * @param  $request
     * @return JsonResponse
     */
    private function processGenerator($request)
    {
        $validator = Validator::make($request->post(), [
            'topic'    => 'required',
            'language' => 'required',
            'type'     => 'required',
        ], [], [
            'topic'    => __('boilerplate::gpt.form.topic'),
            'type'     => __('boilerplate::gpt.form.type.label'),
            'language' => __('boilerplate::gpt.form.language'),
        ]);

        if ($validator->fails()) {
            $request->flash();
            $view = view('boilerplate::gpt.generator')->withErrors($validator->errors());
            View::share('errors', $view->errors);

            return response()->json(['success' => false, 'tab' => 'gpt-generator', 'html' => $view->render()]);
        }

        $key = 'gpt-'.Str::random();
        Cache::put($key, $this->buildPrompt($request), 90);

        return response()->json(['success' => true, 'id' => $key]);
    }

    /**
     * Process raw prompt.
     *
     * @param  $request
     * @return JsonResponse
     */
    private function processPrompt($request)
    {
        $validator = Validator::make($request->post(), [
            'prompt' => 'required',
        ], [], [
            'prompt' => __('boilerplate::gpt.form.prompt'),
        ]);

        if ($validator->fails()) {
            $request->flash();
            $view = view('boilerplate::gpt.prompt')->withErrors($validator->errors());
            View::share('errors', $view->errors);

            return response()->json(['success' => false, 'tab' => 'gpt-prompt', 'html' => $view->render()]);
        }

        $key = 'gpt-'.Str::random();
        Cache::put($key, $request->post('prompt'), 90);

        return response()->json(['success' => true, 'id' => $key]);
    }

    /**
     * Stream the AI provider response as Server-Sent Events.
     *
     * @param  Request  $request
     * @return void
     *
     * @codeCoverageIgnore
     */
    public function stream(Request $request)
    {
        $prompt = Cache::pull($request->get('id'));

        if ($prompt === null) {
            abort(404);
        }

        if (connection_aborted()) {
            exit;
        }

        $provider = app('boilerplate.ai.providers')->getActiveProvider();

        if (! $provider) {
            abort(503);
        }

        ini_set('max_execution_time', 90);

        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');

        app(AiStreamer::class)->stream($provider, $prompt);
    }

    /**
     * Build prompt to send to the API.
     *
     * @param  Request  $request
     * @return string
     */
    private function buildPrompt(Request $request)
    {
        $prompt = '';

        if (! empty($request->post('actas'))) {
            $prompt .= 'Act as "'.$request->post('actas').'". ';
        }

        if (! empty($request->post('pov'))) {
            $prompt .= 'Point of view: "'.$request->post('pov').'". ';
        }

        if (! empty($request->post('tone'))) {
            $prompt .= 'Tone: "'.$request->post('tone').'". ';
        }

        $prompt .= 'Write '.$request->post('type').' in "'.$request->post('language').'" language about "'.$request->post('topic').'"';

        return $prompt;
    }

    /**
     * Build prompt for text rewriting.
     *
     * @param  Request  $request
     * @return string
     */
    private function buildRewritePrompt(Request $request)
    {
        switch ($request->post('type')) {
            case 'rewrite':
                $prompt = '';

                if (! empty($request->post('actas'))) {
                    $prompt = 'Act as: "'.$request->post('actas').'". ';
                }

                if (! empty($request->post('pov'))) {
                    $prompt .= 'Point of view: '.$request->post('pov').'. ';
                }

                if (! empty($request->post('tone'))) {
                    $prompt .= 'Tone: '.$request->post('tone').'. ';
                }

                $prompt .= 'Rewrite';
                break;

            case 'summarize':
            case 'expand':
            case 'paraphrase':
                $prompt = ucfirst($request->post('type'));
                break;

            case 'question':
            case 'conclusion':
            case 'title':
            case 'counterargument':
                $prompt = 'Suggest a '.$request->post('type').' for';
                break;

            case 'grammar':
                $prompt = 'Correct grammar and spelling of';
                break;

            case 'translate':
                $prompt = 'Act as a professionnal translator. Translate';
                break;
        }

        $prompt .= ' the following text';

        if (! empty($request->post('language'))) {
            $prompt .= ' in "'.$request->post('language').'" language';
        }

        $prompt .= ': "'.$request->post('original-content').'"';

        return $prompt;
    }
}
