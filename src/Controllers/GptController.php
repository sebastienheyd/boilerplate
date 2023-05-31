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
use Orhanerday\OpenAi\OpenAi;

class GptController
{
    /**
     * Show "Generate text with GPT" form.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        if (class_exists(\Barryvdh\Debugbar\Facades\Debugbar::class)) {
            \Barryvdh\Debugbar\Facades\Debugbar::disable();
        }

        return view('boilerplate::gpt.layout');
    }

    /**
     * Generate the prompt to pass to the OpenAI API.
     *
     * @param Request $request
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

    private function processRewrite($request)
    {
        $validator = Validator::make($request->post(), [
            'original-content'  => 'required',
        ], [], [
            'original-content' => __('boilerplate::gpt.form.pov.form.rewrite.original'),
        ]);

        if ($validator->fails()) {
            $request->flash();
            $view = view('boilerplate::gpt.rewrite')->withErrors($validator->errors());
            View::share('errors', $view->errors);

            return response()->json(['success' => false, 'tab' => 'gpt-rewrite', 'html' => $view->render()]);
        }

        $key = 'gpt-' . Str::random();
        Cache::put($key, $this->buildRewritePrompt($request), 90);

        return response()->json(['success' => true, 'prepend' => $request->post('type') === 'title', 'id' => $key]);
    }

    private function processGenerator($request)
    {
        $validator = Validator::make($request->post(), [
            'topic'  => 'required',
        ], [], [
            'topic' => __('boilerplate::gpt.form.topic'),
        ]);

        if ($validator->fails()) {
            $request->flash();
            $view = view('boilerplate::gpt.generator')->withErrors($validator->errors());
            View::share('errors', $view->errors);

            return response()->json(['success' => false, 'tab' => 'gpt-generator', 'html' => $view->render()]);
        }

        $key = 'gpt-' . Str::random();
        Cache::put($key, $this->buildPrompt($request), 90);

        return response()->json(['success' => true, 'prepend' => true,  'id' => $key]);
    }

    private function processPrompt($request)
    {
        $validator = Validator::make($request->post(), [
            'prompt'  => 'required',
        ], [], [
            'prompt' => __('boilerplate::gpt.form.prompt'),
        ]);

        if ($validator->fails()) {
            $request->flash();
            $view = view('boilerplate::gpt.prompt')->withErrors($validator->errors());
            View::share('errors', $view->errors);

            return response()->json(['success' => false, 'tab' => 'gpt-prompt', 'html' => $view->render()]);
        }

        $key = 'gpt-' . Str::random();
        Cache::put($key, $request->post('prompt'), 90);

        return response()->json(['success' => true, 'prepend' => true, 'id' => $key]);
    }

    /**
     * Stream the result from OpenAI API.
     *
     * @param Request $request
     * @return void
     * @throws \Exception
     */
    public function stream(Request $request)
    {
        $prompt = Cache::pull($request->get('id'));

        if ($prompt === null) {
            abort(404);
        }

        $openAi = new OpenAi(env('OPENAI_API_KEY'));

        if ($organization = config('boilerplate.app.openai.organization')) {
            $openAi->setORG($organization);
        }

        $opts = [
            'model'             => config('boilerplate.app.openai.model', 'gpt-3.5-turbo'),
            'messages'          => [['role' => 'user', 'content' => $prompt]],
            'temperature'       => 0.6,
            "frequency_penalty" => 0.52,
            "presence_penalty"  => 0.5,
            "max_tokens"        => 1000,
            'stream'            => true,
        ];

        header('Content-type: text/event-stream');
        header('Cache-Control: no-cache');

        $openAi->chat($opts, function ($curl, $data) {
            $obj = json_decode($data);

            if ($obj && ! empty($obj->error->message)) {
                die('[ERROR] ' . $obj->error->message);
            } else {
                echo $data;
            }

            echo PHP_EOL;
            ob_flush();
            flush();
            return strlen($data);
        });
    }

    /**
     * Build prompt to send to the API.
     *
     * @param Request $request
     * @return string
     */
    private function buildPrompt(Request $request)
    {
        $prompt = 'Language: "' . $request->post('language') . '".';

        if (! empty($request->post('pov'))) {
            $prompt .= 'Point of view: "' . $request->post('pov') . '".';
        }

        if (! empty($request->post('tone'))) {
            $prompt .= 'Tone: "' . $request->post('tone') . '".';
        }

        if (! empty($request->post('actas'))) {
            $prompt .= 'Act as "' . $request->post('actas') . '".';
        }

        $prompt .= 'Write ' . $request->post('type') . ' about "'.$request->post('topic').'"';

        return $prompt;
    }

    /**
     * Build prompt for text rewriting.
     *
     * @param Request $request
     * @return string
     */
    private function buildRewritePrompt(Request $request)
    {
        if ($request->post('type') !== 'translate') {
            $prompt = 'Act as '.(empty($request->post('actas')) ? 'the writer of the text.' : '"'.$request->post('actas').'"');

            if (! empty($request->post('pov'))) {
                $prompt .= 'Point of view: ' . $request->post('pov') . '.';
            }

            if (! empty($request->post('tone'))) {
                $prompt .= 'Tone: ' . $request->post('tone') . '.';
            }
        } else {
            $prompt = 'Act as a professionnal translator.';
        }

        switch ($request->post('type')) {
            case 'rewrite':
                $prompt .= 'Rewrite the following text in "'.$request->post('language').'": "'.$request->post('original-content').'".';
                break;

            case 'summary':
                $prompt .= 'Summarize the following text in "'.$request->post('language').'": "'.$request->post('original-content').'".';
                break;

            case 'title':
                $prompt .= 'Write a title for the following text in "'.$request->post('language').'": "'.$request->post('original-content').'".';
                break;

            case 'translate':
                $prompt .= 'Translate the following text in "'.$request->post('language').'": "'.$request->post('original-content').'".';
                break;
        }


        return $prompt;
    }
}
