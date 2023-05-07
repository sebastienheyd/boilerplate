<?php

namespace Sebastienheyd\Boilerplate\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class GptController
{
    public function index()
    {
        return view('boilerplate::gpt.layout');
    }

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
            return response()->json([
                'success' => false,
                'html' => $view->render()
            ]);
        }

        $prompt  = 'Write '.$request->input('type').' with ';
        $prompt .= 'topic: "'.$request->input('topic').'",';
        $prompt .= 'language: '.$request->input('language').',';

        if (! empty($request->input('pov'))) {
            $prompt .= 'point of view: "'.$request->input('pov').'",';
        }

        if (! empty($request->input('tone'))) {
            $prompt .= 'tone: "'.$request->input('tone').'",';
        }

        if ($request->input('length') > 0) {
            $prompt .= 'number of words: '.$request->input('length');
        }

        if (! empty($request->input('keywords'))) {
            $prompt .= 'keywords: "'.$request->input('length').'"';
        }

        try {
            $response = Http::withoutVerifying()
                ->retry(2, 60)
                ->withHeaders([
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Bearer ' . config('boilerplate.app.openai.key'),
                ])->post('https://api.openai.com/v1/chat/completions', [
                    "messages" => [
                        [
                            "role"        => 'user',
                            "content"     => $prompt,
                        ],
                    ],
                    "model"       => 'gpt-3.5-turbo',
                    'temperature' => 0.6,
                    "max_tokens" => 500,
                    "top_p" => 1.0,
                    "frequency_penalty" => 0.52,
                    "presence_penalty" => 0.5,
                ]);
        } catch (\Throwable $e) {
            $request->flash();
            return response()->json([
                'success' => false,
                'html' => (string) view('boilerplate::gpt.form')->with('gpterror', $e->getMessage())
            ]);
        }

        $json = $response->json();

        if (isset($json['error'])) {
            $request->flash();
            return response()->json([
                'success' => false,
                'html' => (string) view('boilerplate::gpt.form')->with('gpterror', $json['error']['message'])
            ]);
        }

        if (isset($json['choices'][0]['message']['content'])) {
            return response()->json([
                'success' => true,
                'content' => nl2br(trim($json['choices'][0]['message']['content'])),
            ]);
        }

        $request->flash();
        return response()->json([
            'success' => false,
            'html' => (string) view('boilerplate::gpt.form')->with('gpterror', 'No response from openai')
        ]);
    }
}
