<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads\Responses;

use Illuminate\Http\Client\Response;
use Outl1ne\NovaOpenAI\Capabilities\Responses\AppendsMeta;

class ThreadResponse
{
    use AppendsMeta;

    public string $threadId;

    public function __construct(
        protected readonly Response $response,
    ) {
        $data = $response->json();

        $this->threadId = $data['id'];
        $this->appendMeta('id', $data['id']);
        $this->appendMeta('object', $data['object']);
        $this->appendMeta('created_at', $data['created_at']);
        $this->appendMeta('metadata', $data['metadata']);
    }

    public function response()
    {
        return $this->response;
    }
}
