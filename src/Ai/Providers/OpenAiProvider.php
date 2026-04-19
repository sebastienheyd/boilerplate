<?php

namespace Sebastienheyd\Boilerplate\Ai\Providers;

use Sebastienheyd\Boilerplate\Ai\AiProvider;

class OpenAiProvider extends AiProvider
{
    protected string $slug = 'openai';

    protected string $label = 'OpenAI';

    public function isConfigured(): bool
    {
        return ! empty(config('boilerplate.app.ai.providers.openai.key'))
            || ! empty(config('boilerplate.app.openai.key'));
    }

    public function endpoint(): string
    {
        return 'https://api.openai.com/v1/chat/completions';
    }

    public function headers(): array
    {
        $key = config('boilerplate.app.ai.providers.openai.key')
            ?: config('boilerplate.app.openai.key');

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer '.$key,
        ];

        $org = config('boilerplate.app.ai.providers.openai.organization')
            ?: config('boilerplate.app.openai.organization');

        if ($org) {
            $headers[] = 'OpenAI-Organization: '.$org;
        }

        return $headers;
    }

    public function body(string $prompt): array
    {
        $model = config('boilerplate.app.ai.providers.openai.model')
            ?: config('boilerplate.app.openai.model', 'gpt-4o-mini');

        return [
            'model'             => $model,
            'messages'          => [['role' => 'user', 'content' => $prompt]],
            'temperature'       => 0.6,
            'frequency_penalty' => 0.52,
            'presence_penalty'  => 0.5,
            'max_tokens'        => 500,
            'stream'            => true,
        ];
    }

    public function parseChunk(string $raw): ?string
    {
        $obj = json_decode($raw);

        if (! $obj) {
            return null;
        }

        if (! empty($obj->error)) {
            return null;
        }

        return $obj->choices[0]->delta->content ?? null;
    }
}
