<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads\Responses;

use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;

class MessageFileResponse extends Response
{
    public array $files;

    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);

        $this->appendMeta('id', $this->data['id']);
        $this->appendMeta('object', $this->data['object']);
        $this->appendMeta('created_at', $this->data['created_at']);
        $this->appendMeta('message_id', $this->data['message_id']);
    }
}
