<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads\Responses;

use Illuminate\Http\Client\Response;
use Outl1ne\NovaOpenAI\Capabilities\Responses\AppendsMeta;

class MessageFilesResponse
{
    use AppendsMeta;

    public array $files;

    public function __construct(
        protected readonly Response $response,
    ) {
        $data = $response->json();

        $this->appendMeta('object', $data['object']);
        $this->appendMeta('first_id', $data['first_id']);
        $this->appendMeta('last_id', $data['last_id']);
        $this->appendMeta('has_more', $data['has_more']);
        $this->files = $data['data'];
    }

    public function response()
    {
        return $this->response;
    }
}
