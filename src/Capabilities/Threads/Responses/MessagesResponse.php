<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads\Responses;

use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;

class MessagesResponse extends Response
{
    public array $messages;

    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);

        $this->appendMeta('object', $this->data['object']);
        $this->appendMeta('first_id', $this->data['first_id']);
        $this->appendMeta('last_id', $this->data['last_id']);
        $this->appendMeta('has_more', $this->data['has_more']);
        $this->messages = $this->data['data'];
    }
}
