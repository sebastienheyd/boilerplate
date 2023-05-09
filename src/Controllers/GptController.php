<?php

namespace Sebastienheyd\Boilerplate\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class GptController
{
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
     * Process OpenAI API request.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function process(Request $request): JsonResponse
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

        try {
            $response = Http::withoutVerifying()
                ->retry(2, 60)
                ->withHeaders($this->buildHeaders())
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model'       => config('boilerplate.app.openai.model', 'gpt-3.5-turbo'),
                    'messages' => [['role' => 'user', 'content' => $this->buildPrompt($request)]],
                    'temperature' => 0.6,
                    'max_tokens' => 500,
                    'frequency_penalty' => 0.52,
                    'presence_penalty' => 0.5,
                ]);
        } catch (\Throwable $e) {
            return $this->gptError($e->getMessage(), $request);
        }

        $json = $response->json();

        if (isset($json['error'])) {
            return $this->gptError($json['error']['message'], $request);
        }

        if (! isset($json['choices'][0]['message']['content'])) {
            return $this->gptError('No response from OpenAI', $request);
        }

        return response()->json([
            'success' => true,
            'content' => nl2br(trim($json['choices'][0]['message']['content'])),
        ]);
    }

    /**
     * Build cURL headers for OpenAI API.
     *
     * @return string[]
     */
    private function buildHeaders(): array
    {
        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer '.config('boilerplate.app.openai.key'),
        ];

        if ($organization = config('boilerplate.app.openai.organization')) {
            $headers['OpenAI-Organization'] = $organization;
        }

        return $headers;
    }

    /**
     * Build prompt to send to the API.
     *
     * @param  Request  $request
     * @return string
     */
    private function buildPrompt(Request $request): string
    {
        $prompt = 'Write '.$request->input('type').' with ';
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

        return $prompt;
    }

    /**
     * Show error from the API.
     *
     * @param  string  $error
     * @param  Request  $request
     * @return JsonResponse
     */
    private function gptError(string $error, Request $request): JsonResponse
    {
        $request->flash();

        return response()->json([
            'success' => false,
            'html' => (string) view('boilerplate::gpt.form')->with('gpterror', $error),
        ]);
    }
}
