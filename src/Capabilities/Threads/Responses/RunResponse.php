<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads\Responses;

use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;

class RunResponse extends Response
{
    public string $id;
    public string $status;

    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);

        $this->id = $this->data['id'];
        $this->model = $this->data['model'];
        $this->status = $this->data['status'];
        $this->appendMeta('id', $this->data['id']);
        $this->appendMeta('object', $this->data['object']);
        $this->appendMeta('created_at', $this->data['created_at']);
        $this->appendMeta('assistant_id', $this->data['assistant_id']);
        $this->appendMeta('thread_id', $this->data['thread_id']);
        $this->appendMeta('status', $this->data['status']);
        $this->appendMeta('started_at', $this->data['started_at']);
        $this->appendMeta('expires_at', $this->data['expires_at']);
        $this->appendMeta('cancelled_at', $this->data['cancelled_at']);
        $this->appendMeta('failed_at', $this->data['failed_at']);
        $this->appendMeta('completed_at', $this->data['completed_at']);
        $this->appendMeta('last_error', $this->data['last_error']);
        $this->appendMeta('model', $this->data['model']);
        $this->appendMeta('instructions', $this->data['instructions']);
        $this->appendMeta('tools', $this->data['tools']);
        $this->appendMeta('metadata', $this->data['metadata']);
    }
}
