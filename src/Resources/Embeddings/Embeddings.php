<?php

namespace Outl1ne\NovaOpenAI\Resources\Embeddings;

use Outl1ne\NovaOpenAI\Resources\Resource;

class Embeddings extends Resource
{
    public function create(string $model, string $input)
    {
        return (new CreateEmbedding($this->http))->makeRequest($model, $input);
    }
}
