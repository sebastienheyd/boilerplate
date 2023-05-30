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
     * Process OpenAI API request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function process(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'topic'  => 'required',
            'length' => 'nullable|integer|between:5,300',
        ], [], [
            'topic' => __('boilerplate::gpt.form.topic'),
        ]);

        if ($validator->fails()) {
            $request->flash();
            $view = view('boilerplate::gpt.form')->withErrors($validator->errors());
            View::share('errors', $view->errors);

            return response()->json(['success' => false, 'html' => $view->render()]);
        }

        $key = 'gpt-' . Str::random();
        Cache::put($key, $this->buildPrompt($request), 90);

        return response()->json(['success' => true, 'id' => $key]);
    }

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
            "max_tokens"        => 500,
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
        $prompt = 'write ' . $request->input('type') . ' with ';
        $prompt .= 'topic: "' . $request->input('topic') . '",';
        $prompt .= 'language: ' . $request->input('language') . ',';

        if (! empty($request->input('author'))) {
            $prompt .= 'author: "' . $request->input('pov') . '",';
        }

        if (! empty($request->input('actas'))) {
            $prompt .= 'act as: "' . $request->input('actas') . '",';
        }

        if (! empty($request->input('pov'))) {
            $prompt .= 'point of view: "' . $request->input('pov') . '",';
        }

        if (! empty($request->input('tone'))) {
            $prompt .= 'tone: "' . $request->input('tone') . '",';
        }

        if ($request->input('length') > 0) {
            $prompt .= 'number of words: ' . $request->input('length');
        }

        if (! empty($request->input('keywords'))) {
            $prompt .= 'keywords: "' . $request->input('length') . '"';
        }

        return $prompt;
    }
}
