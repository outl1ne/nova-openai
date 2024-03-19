<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Chat\Responses;

use Illuminate\Http\Client\Response as HttpResponse;
use Outl1ne\NovaOpenAI\Capabilities\Responses\Response as Response;

class ChatResponse extends Response
{
    public array $choices;

    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);

        $this->model = $this->data['model'];
        $this->choices = $this->data['choices'];
        $this->appendMeta('id', $this->data['id']);
        $this->appendMeta('object', $this->data['object']);
        $this->appendMeta('system_fingerprint', $this->data['system_fingerprint']);
    }
}
