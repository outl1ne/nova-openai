<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads\Responses;

use Illuminate\Http\Client\Response;
use Outl1ne\NovaOpenAI\Capabilities\Responses\Usage;
use Outl1ne\NovaOpenAI\Capabilities\Responses\AppendsMeta;

class RunResponse
{
    use AppendsMeta;

    public string $model;
    public ?Usage $usage;

    public function __construct(
        protected readonly Response $response,
    ) {
        $data = $response->json();

        $this->model = $data['model'];
        $this->appendMeta('id', $data['id']);
        $this->appendMeta('object', $data['object']);
        $this->appendMeta('created_at', $data['created_at']);
        $this->appendMeta('assistant_id', $data['assistant_id']);
        $this->appendMeta('thread_id', $data['thread_id']);
        $this->appendMeta('status', $data['status']);
        $this->appendMeta('started_at', $data['started_at']);
        $this->appendMeta('expires_at', $data['expires_at']);
        $this->appendMeta('cancelled_at', $data['cancelled_at']);
        $this->appendMeta('failed_at', $data['failed_at']);
        $this->appendMeta('completed_at', $data['completed_at']);
        $this->appendMeta('last_error', $data['last_error']);
        $this->appendMeta('model', $data['model']);
        $this->appendMeta('instructions', $data['instructions']);
        $this->appendMeta('tools', $data['tools']);
        $this->appendMeta('file_ids', $data['file_ids']);
        $this->appendMeta('metadata', $data['metadata']);
        $this->usage = $data['usage'] ? new Usage(
            promptTokens: $data['usage']['prompt_tokens'],
            completionTokens: $data['usage']['completion_tokens'],
            totalTokens: $data['usage']['total_tokens'],
        ) : null;
    }

    public function response()
    {
        return $this->response;
    }
}
