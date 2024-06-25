<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Embeddings\Responses;

class Embedding
{
    public ?string $object;
    public ?int $index;
    public array $vector;

    public function __construct($data)
    {
        $this->object = $data['object'];
        $this->index = $data['index'];
        $this->vector = $data['embedding'];
    }
}
