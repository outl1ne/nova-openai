<?php

namespace Outl1ne\NovaOpenAI\Capabilities;

use Closure;
use Outl1ne\NovaOpenAI\OpenAI;

class Capability
{
    public Closure $shouldStorePendingCallback;
    public Closure $shouldStoreCallback;
    public Closure $shouldStoreErrorsCallback;

    public function __construct(
        public readonly OpenAI $openAI,
    ) {
        $this->shouldStorePending(fn () => true);
        $this->shouldStore(fn () => true);
        $this->shouldStoreErrors(fn () => true);
    }

    public function shouldStorePending(Closure $callback): self
    {
        $this->shouldStorePendingCallback = $callback;
        return $this;
    }

    public function shouldStore(Closure $callback): self
    {
        $this->shouldStoreCallback = $callback;
        return $this;
    }

    public function shouldStoreErrors(Closure $callback): self
    {
        $this->shouldStoreErrorsCallback = $callback;
        return $this;
    }
}
