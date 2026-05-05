<?php

namespace Sebastienheyd\Boilerplate\Ai;

abstract class AiProvider
{
    protected string $slug;

    protected string $label;

    abstract public function isConfigured(): bool;

    abstract public function endpoint(): string;

    abstract public function headers(): array;

    abstract public function body(string $prompt): array;

    /**
     * Parse a raw SSE data chunk.
     * Returns text delta, null to skip, or '[DONE]' to signal end-of-stream.
     */
    abstract public function parseChunk(string $raw): ?string;

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getLabel(): string
    {
        return $this->label;
    }
}
