<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Chat\Responses;

use Outl1ne\NovaOpenAI\Capabilities\Responses\StreamChunk;


class StreamedChatChunk extends StreamChunk
{
    public array $choices;

    public function __construct($data)
    {
        parent::__construct($data);

        $this->model = $this->data['model'];
        $this->choices = $this->data['choices'];
        $this->appendMeta('id', $this->data['id']);
        $this->appendMeta('object', $this->data['object']);
        $this->appendMeta('created', $this->data['created']);
        $this->appendMeta('system_fingerprint', $this->data['system_fingerprint']);
    }
}
