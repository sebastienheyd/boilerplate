<?php

namespace Sebastienheyd\Boilerplate\Ai;

class AiProvidersRepository
{
    protected array $providers = [];

    public function registerAiProvider(string ...$classes): static
    {
        foreach ($classes as $class) {
            if (! is_subclass_of($class, AiProvider::class)) {
                continue;
            }
            $provider = new $class;
            $this->providers[$provider->getSlug()] = $provider;
        }

        return $this;
    }

    public function getProvider(string $slug): ?AiProvider
    {
        return $this->providers[$slug] ?? null;
    }

    public function getActiveProvider(): ?AiProvider
    {
        $slug = config('boilerplate.app.ai.default', 'openai');
        $provider = $this->providers[$slug] ?? null;

        return ($provider && $provider->isConfigured()) ? $provider : null;
    }

    public function hasConfiguredProvider(): bool
    {
        return $this->getActiveProvider() !== null;
    }
}
