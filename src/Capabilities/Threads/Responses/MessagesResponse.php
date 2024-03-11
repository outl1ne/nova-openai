<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads\Responses;

use Illuminate\Http\Client\Response;
use Outl1ne\NovaOpenAI\Capabilities\Responses\AppendsMeta;

class MessagesResponse
{
    use AppendsMeta;

    public array $messages;

    public function __construct(
        protected readonly Response $response,
    ) {
        $data = $response->json();

        $this->appendMeta('object', $data['object']);
        $this->appendMeta('first_id', $data['first_id']);
        $this->appendMeta('last_id', $data['last_id']);
        $this->appendMeta('has_more', $data['has_more']);
        $this->messages = $data['data'];
    }

    public function response()
    {
        return $this->response;
    }
}
