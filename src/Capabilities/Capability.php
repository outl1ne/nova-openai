<?php

namespace Outl1ne\NovaOpenAI\Capabilities;

use Closure;
use Outl1ne\NovaOpenAI\OpenAI;

class Capability
{
    public Closure $shouldStorePendingCallback;
    public Closure $shouldStoreCallback;
    public Closure $shouldStoreErrorsCallback;
    public Closure $storingCallback;
    public ?Closure $streamCallback = null;

    public function __construct(
        public readonly OpenAI $openAI,
    ) {
        $this->shouldStorePending(fn () => true);
        $this->shouldStore(fn () => true);
        $this->shouldStoreErrors(fn () => true);
        $this->storing(fn ($model) => $model);
    }

    public function shouldStorePending(Closure $callback): static
    {
        $this->shouldStorePendingCallback = $callback;
        return $this;
    }

    public function shouldStore(Closure $callback): static
    {
        $this->shouldStoreCallback = $callback;
        return $this;
    }

    public function shouldStoreErrors(Closure $callback): static
    {
        $this->shouldStoreErrorsCallback = $callback;
        return $this;
    }

    public function storing(Closure $callback): static
    {
        $this->storingCallback = $callback;
        return $this;
    }

    public function stream(Closure $callback): static
    {
        $this->streamCallback = $callback;
        return $this;
    }
}
