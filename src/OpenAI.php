<?php

namespace Outl1ne\NovaOpenAI;

use Illuminate\Support\Facades\Http;
use Outl1ne\NovaOpenAI\Pricing\Pricing;
use Illuminate\Http\Client\PendingRequest;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Chat;
use Outl1ne\NovaOpenAI\Capabilities\Embeddings\Embeddings;

class OpenAI
{
    public readonly PendingRequest $http;
    public readonly Pricing $pricing;

    public function __construct(
        protected readonly string $baseUrl,
        protected readonly array $headers,
        ?object $pricing = null,
    ) {
        $this->http = Http::baseUrl($this->baseUrl)->withHeaders([
            ...$this->headers,
            'Content-Type' => 'application/json',
        ]);
        $this->pricing = new Pricing($pricing);
    }

    public function embeddings(): Embeddings
    {
        return new Embeddings($this->http, $this->pricing);
    }

    public function chat(): Chat
    {
        return new Chat($this->http, $this->pricing);
    }
}
