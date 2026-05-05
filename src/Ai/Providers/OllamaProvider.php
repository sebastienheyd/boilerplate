<?php

namespace Sebastienheyd\Boilerplate\Ai\Providers;

use Sebastienheyd\Boilerplate\Ai\AiProvider;

class OllamaProvider extends AiProvider
{
    protected string $slug = 'ollama';

    protected string $label = 'Ollama';

    public function isConfigured(): bool
    {
        return ! empty(config('boilerplate.app.ai.providers.ollama.model'));
    }

    public function endpoint(): string
    {
        $base = rtrim(config('boilerplate.app.ai.providers.ollama.endpoint', 'http://localhost:11434'), '/');

        return $base.'/api/generate';
    }

    public function headers(): array
    {
        return ['Content-Type: application/json'];
    }

    public function body(string $prompt): array
    {
        return [
            'model'  => config('boilerplate.app.ai.providers.ollama.model'),
            'prompt' => $prompt,
            'stream' => true,
        ];
    }

    public function parseChunk(string $raw): ?string
    {
        $obj = json_decode($raw);

        if (! $obj) {
            return null;
        }

        if (! empty($obj->done)) {
            return '[DONE]';
        }

        return $obj->response ?? null;
    }
}
