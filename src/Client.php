<?php

namespace Outl1ne\NovaOpenAI;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Outl1ne\NovaOpenAI\Resources\Embeddings\Embeddings;

class Client
{
    public readonly PendingRequest $http;

    /**
     * Creates a Client instance with the given API token.
     */
    public function __construct(
        protected readonly string $baseUrl,
        protected readonly array $headers,
    ) {
        $this->http = Http::baseUrl($this->baseUrl)->withHeaders($this->headers);
    }

    /**
     * Get a vector representation of a given input that can be easily consumed by machine learning models and algorithms.
     *
     * @see https://platform.openai.com/docs/api-reference/embeddings
     */
    public function embeddings(): Embeddings
    {
        return new Embeddings($this->http);
    }
}
