<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Embeddings;

use Outl1ne\NovaOpenAI\Capabilities\Capability;


class Embeddings extends Capability
{
    public function create(string $model, string $input)
    {
        return (new CreateEmbedding($this->http))->makeRequest($model, $input);
    }
}
