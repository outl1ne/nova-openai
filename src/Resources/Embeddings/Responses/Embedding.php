<?php

namespace Outl1ne\NovaOpenAI\Resources\Embeddings\Responses;

class Embedding
{
    public string $object;
    public int $index;
    public array $embedding;

    public function __construct($data) {
        $this->object = $data['object'];
        $this->index = $data['index'];
        $this->embedding = $data['embedding'];
    }
}
