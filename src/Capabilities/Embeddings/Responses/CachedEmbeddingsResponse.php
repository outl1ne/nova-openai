<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Embeddings\Responses;

use Outl1ne\NovaOpenAI\Capabilities\Responses\CachedResponse;

class CachedEmbeddingsResponse extends CachedResponse
{
    public function __construct(public Embedding $embedding)
    {
    }
}
