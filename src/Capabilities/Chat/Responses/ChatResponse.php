<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Chat\Responses;

use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;

class ChatResponse extends Response
{
    public array $choices;

    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);

        $this->model = $this->data['model'];
        $this->choices = $this->data['choices'];
        $this->appendMeta('id', $this->data['id']);
        $this->appendMeta('created', $this->data['created']);
        $this->appendMeta('system_fingerprint', $this->data['system_fingerprint']);
        $this->appendMeta('object', $this->data['object']);
    }

    public function json(): ?object
    {
        return json_decode($this->choices[0]['message']['content']);
    }
}
