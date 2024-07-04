<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Embeddings;

use Outl1ne\NovaOpenAI\Cache\EmbeddingsCache;
use Outl1ne\NovaOpenAI\Capabilities\Capability;

class Embeddings extends Capability
{
    public function create(string $model, string $input, ?string $encodingFormat = null, ?int $dimensions = null, ?string $user = null)
    {
        return (new CreateEmbedding($this))->makeRequest($model, $input, $encodingFormat, $dimensions, $user);
    }

    public function setCache(EmbeddingsCache $cache)
    {
        $this->cache = $cache;
    }
}
