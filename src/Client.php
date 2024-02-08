<?php

namespace Outl1ne\NovaOpenAI;

use Outl1ne\NovaOpenAI\Resources\Embeddings\Embeddings;

class Client
{
    /**
     * Creates a Client instance with the given API token.
     */
    public function __construct(protected readonly Http $http)
    {
        // ..
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
