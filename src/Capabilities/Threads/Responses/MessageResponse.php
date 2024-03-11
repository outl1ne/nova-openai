<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads\Responses;

use Illuminate\Http\Client\Response;
use Outl1ne\NovaOpenAI\Capabilities\Responses\AppendsMeta;

class MessageResponse
{
    use AppendsMeta;

    public string $threadId;
    public string $messageId;
    public array $content;

    public function __construct(
        protected readonly Response $response,
    ) {
        $data = $response->json();

        $this->messageId = $data['id'];
        $this->threadId = $data['thread_id'];
        $this->appendMeta('id', $data['id']);
        $this->appendMeta('object', $data['object']);
        $this->appendMeta('created_at', $data['created_at']);
        $this->appendMeta('assistant_id', $data['assistant_id']);
        $this->appendMeta('thread_id', $data['thread_id']);
        $this->appendMeta('run_id', $data['run_id']);
        $this->appendMeta('role', $data['role']);
        $this->appendMeta('file_ids', $data['file_ids']);
        $this->appendMeta('metadata', $data['metadata']);
        $this->content = $data['content'];
    }

    public function response()
    {
        return $this->response;
    }
}
