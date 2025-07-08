<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Responses\Responses;

use Outl1ne\NovaOpenAI\Capabilities\Responses\StreamChunk;

class StreamedResponsesChunk extends StreamChunk
{
    public array $output;

    public function __construct($data)
    {
        parent::__construct($data);

        $this->model = $this->data['model'] ?? null;
        $this->output = $this->data['output'] ?? [];
        $this->appendMeta('id', $this->data['id'] ?? null);
        $this->appendMeta('object', $this->data['object'] ?? null);
        $this->appendMeta('created_at', $this->data['created_at'] ?? null);
    }
} 