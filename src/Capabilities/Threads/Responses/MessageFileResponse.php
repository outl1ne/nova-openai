<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads\Responses;

use Illuminate\Http\Client\Response;
use Outl1ne\NovaOpenAI\Capabilities\Responses\AppendsMeta;

class MessageFileResponse
{
    use AppendsMeta;

    public array $files;

    public function __construct(
        protected readonly Response $response,
    ) {
        $data = $response->json();

        $this->appendMeta('id', $data['id']);
        $this->appendMeta('object', $data['object']);
        $this->appendMeta('created_at', $data['created_at']);
        $this->appendMeta('message_id', $data['message_id']);
    }

    public function response()
    {
        return $this->response;
    }
}
