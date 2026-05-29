<?php

namespace Sebastienheyd\Boilerplate\Ai\Providers;

use Sebastienheyd\Boilerplate\Ai\AiProvider;

class AnthropicProvider extends AiProvider
{
    protected string $slug = 'anthropic';

    protected string $label = 'Anthropic Claude';

    public function isConfigured(): bool
    {
        return ! empty(config('boilerplate.app.ai.providers.anthropic.key'));
    }

    public function endpoint(): string
    {
        return 'https://api.anthropic.com/v1/messages';
    }

    public function headers(): array
    {
        return [
            'Content-Type: application/json',
            'x-api-key: '.config('boilerplate.app.ai.providers.anthropic.key'),
            'anthropic-version: 2023-06-01',
        ];
    }

    public function body(string $prompt): array
    {
        return [
            'model'      => config('boilerplate.app.ai.providers.anthropic.model', 'claude-3-5-haiku-20241022'),
            'max_tokens' => 1024,
            'stream'     => true,
            'messages'   => [['role' => 'user', 'content' => $prompt]],
        ];
    }

    public function parseChunk(string $raw): ?string
    {
        $obj = json_decode($raw);

        if (! $obj) {
            return null;
        }

        if (($obj->type ?? '') === 'message_stop') {
            return '[DONE]';
        }

        if (($obj->type ?? '') === 'content_block_delta'
            && ($obj->delta->type ?? '') === 'text_delta') {
            return $obj->delta->text ?? null;
        }

        return null;
    }
}
