<?php

namespace Outl1ne\NovaOpenAI;

use Closure;
use Illuminate\Support\Facades\Http;
use Outl1ne\NovaOpenAI\Pricing\Pricing;
use Illuminate\Http\Client\PendingRequest;
use Outl1ne\NovaOpenAI\Capabilities\Assistants\Assistants;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Chat;
use Outl1ne\NovaOpenAI\Capabilities\Embeddings\Embeddings;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Threads;

class OpenAI
{
    public readonly Closure $http;
    public readonly Pricing $pricing;

    public function __construct(
        protected readonly string $baseUrl,
        protected readonly array $headers,
        ?object $pricing = null,
    ) {
        $this->pricing = new Pricing($pricing);
    }

    public function embeddings(): Embeddings
    {
        return new Embeddings($this);
    }

    public function chat(): Chat
    {
        return new Chat($this);
    }

    public function assistants(): Assistants
    {
        return new Assistants($this);
    }

    public function threads(): Threads
    {
        return new Threads($this);
    }

    public function http(): PendingRequest
    {
        return clone Http::baseUrl($this->baseUrl)->withHeaders($this->headers);
    }
}
