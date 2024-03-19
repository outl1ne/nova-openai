<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads\Responses;

use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;

class ThreadDeletionStatusResponse extends Response
{
    public string $threadId;

    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);

        $this->threadId = $this->data['id'];
        $this->appendMeta('id', $this->data['id']);
        $this->appendMeta('object', $this->data['object']);
        $this->appendMeta('deleted', $this->data['deleted']);
    }
}
