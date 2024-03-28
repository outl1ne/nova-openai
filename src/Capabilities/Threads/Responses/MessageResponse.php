<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads\Responses;

use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;

class MessageResponse extends Response
{
    public string $id;
    public string $threadId;
    public array $content;

    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);

        $this->id = $this->data['id'];
        $this->threadId = $this->data['thread_id'];
        $this->appendMeta('id', $this->data['id']);
        $this->appendMeta('object', $this->data['object']);
        $this->appendMeta('created_at', $this->data['created_at']);
        $this->appendMeta('assistant_id', $this->data['assistant_id']);
        $this->appendMeta('thread_id', $this->data['thread_id']);
        $this->appendMeta('run_id', $this->data['run_id']);
        $this->appendMeta('role', $this->data['role']);
        $this->appendMeta('file_ids', $this->data['file_ids']);
        $this->appendMeta('metadata', $this->data['metadata']);
        $this->content = $this->data['content'];
    }
}
