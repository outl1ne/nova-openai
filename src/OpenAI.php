<?php

namespace Outl1ne\NovaOpenAI;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Chat;
use Outl1ne\NovaOpenAI\Capabilities\Embeddings\Embeddings;

class OpenAI
{
    public readonly PendingRequest $http;

    public function __construct(
        protected readonly string $baseUrl,
        protected readonly array $headers,
    ) {
        $this->http = Http::baseUrl($this->baseUrl)->withHeaders($this->headers);
    }

    public function embeddings(): Embeddings
    {
        return new Embeddings($this->http);
    }

    public function chat(): Chat
    {
        return new Chat($this->http);
    }
}
