<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads\Responses;

use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;

class ThreadResponse extends Response
{
    public string $id;

    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);

        $this->id = $this->data['id'];
        $this->appendMeta('id', $this->data['id']);
        $this->appendMeta('object', $this->data['object']);
        $this->appendMeta('created_at', $this->data['created_at']);
        $this->appendMeta('metadata', $this->data['metadata']);
    }
}
