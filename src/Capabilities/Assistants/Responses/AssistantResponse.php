<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Assistants\Responses;

use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;

class AssistantResponse extends Response
{
    public string $id;

    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);

        $this->id = $this->data['id'];
        $this->model = $this->data['model'];
        $this->appendMeta('id', $this->data['id']);
        $this->appendMeta('object', $this->data['object']);
        $this->appendMeta('created_at', $this->data['created_at']);
        $this->appendMeta('name', $this->data['name']);
        $this->appendMeta('description', $this->data['description']);
        $this->appendMeta('model', $this->data['model']);
        $this->appendMeta('instructions', $this->data['instructions']);
        $this->appendMeta('tools', $this->data['tools']);
        $this->appendMeta('tool_resources', $this->data['tool_resources']);
        $this->appendMeta('metadata', $this->data['metadata']);
        $this->appendMeta('temperature', $this->data['temperature']);
        $this->appendMeta('top_p', $this->data['top_p']);
        $this->appendMeta('response_format', $this->data['response_format']);
    }
}
