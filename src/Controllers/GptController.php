<?php

namespace Sebastienheyd\Boilerplate\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Orhanerday\OpenAi\OpenAi;

class GptController
{
    public function __construct()
    {
        if (class_exists(\Barryvdh\Debugbar\Facades\Debugbar::class)) {
            \Barryvdh\Debugbar\Facades\Debugbar::disable();
        }
    }

    /**
     * Show "Generate text with GPT" form.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
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
            'original-content' => 'required',
            'language'         => 'required',
        ], [], [
            'original-content' => __('boilerplate::gpt.form.rewrite.original'),
            'language'         => __('boilerplate::gpt.form.language'),
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

        $key = 'gpt-' . Str::random();
        Cache::put($key, $this->buildPrompt($request), 90);

        return response()->json(['success' => true, 'prepend' => true, 'id' => $key]);
    }

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

        $key = 'gpt-' . Str::random();
        Cache::put($key, $request->post('prompt'), 90);

        return response()->json(['success' => true, 'prepend' => true, 'id' => $key]);
    }

    /**
     * Stream the result from OpenAI API.
     *
     * @param Request $request
     * @return void
     */
    public function stream(Request $request)
    {
        $prompt = Cache::pull($request->get('id'));

        if ($prompt === null) {
            abort(404);
        }

        if(connection_aborted()) exit();

        ini_set('max_execution_time', 90);

        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');

        $result = $this->sendRequest($prompt, function ($curl, $data) {
            $obj = json_decode($data);

            if ($obj && ! empty($obj->error)) {
                $message = 'OpenAI API Error : ' . $obj->error->message . ' ' . $obj->error->code . ' (' . $obj->error->type . ')';
                Log::error($message);
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
     * @param $prompt
     * @param $callback
     * @return bool|string
     */
    private function sendRequest($prompt, $callback)
    {
        $curl = curl_init();

        $data = [
            'model'             => config('boilerplate.app.openai.model', 'gpt-3.5-turbo'),
            'messages'          => [['role' => 'user', 'content' => $prompt]],
            'temperature'       => 0.6,
            'frequency_penalty' => 0.52,
            'presence_penalty'  => 0.5,
            'max_tokens'        => 500,
            'stream'            => true,
        ];

        $headers = [
            "Content-Type: application/json",
            "Authorization: Bearer ".config('boilerplate.app.openai.key')
        ];

        curl_setopt_array($curl, [
            CURLOPT_URL            => "https://api.openai.com/v1/chat/completions",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => json_encode($data),
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_WRITEFUNCTION  => $callback,
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            Log::error('OpenAI API Curl error : '.$err);
            return 'OpenAI API Curl error : '.$err;
        } else {
            return $response;
        }
    }

    /**
     * Build prompt to send to the API.
     *
     * @param Request $request
     * @return string
     */
    private function buildPrompt(Request $request)
    {
        $prompt = '';

        if (! empty($request->post('actas'))) {
            $prompt .= 'Act as "' . $request->post('actas') . '". ';
        }

        if (! empty($request->post('pov'))) {
            $prompt .= 'Point of view: "' . $request->post('pov') . '". ';
        }

        if (! empty($request->post('tone'))) {
            $prompt .= 'Tone: "' . $request->post('tone') . '". ';
        }

        $prompt .= 'Write ' . $request->post('type') . ' in "' . $request->post('language') . '" language about "' . $request->post('topic') . '"';

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
            $prompt = 'Act as ' . (empty($request->post('actas')) ? 'the writer of the text. ' : '"' . $request->post('actas') . '". ');

            if (! empty($request->post('pov'))) {
                $prompt .= 'Point of view: ' . $request->post('pov') . '. ';
            }

            if (! empty($request->post('tone'))) {
                $prompt .= 'Tone: ' . $request->post('tone') . '. ';
            }
        } else {
            $prompt = 'Act as a professionnal translator. ';
        }

        switch ($request->post('type')) {
            case 'rewrite':
                $prompt .= 'Rewrite the following text in "' . $request->post('language') . '" language: "' . $request->post('original-content') . '"';
                break;

            case 'summary':
                $prompt .= 'Summarize the following text in "' . $request->post('language') . '" language: "' . $request->post('original-content') . '"';
                break;

            case 'title':
                $prompt .= 'Write a title for the following text in "' . $request->post('language') . '" language: "' . $request->post('original-content') . '"';
                break;

            case 'translate':
                $prompt .= 'Translate the following text in "' . $request->post('language') . '" language: "' . $request->post('original-content') . '"';
                break;
        }

        return $prompt;
    }
}
