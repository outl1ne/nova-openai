<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Embeddings\Responses;

use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;

class EmbeddingsResponse extends Response
{
    public Embedding $embedding;

    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);

        $this->model = $this->data['model'];
        $this->appendMeta('object', $this->data['object']);
        $this->embedding = new Embedding($this->data['data'][0]);
    }
}
