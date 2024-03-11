<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Assistants\Responses;

use Illuminate\Http\Client\Response;
use Outl1ne\NovaOpenAI\Capabilities\Responses\AppendsMeta;

class AssistantResponse
{
    use AppendsMeta;

    public string $id;
    public string $model;

    public function __construct(
        protected readonly Response $response,
    ) {
        $data = $response->json();

        $this->id = $data['id'];
        $this->model = $data['model'];
        $this->appendMeta('id', $data['id']);
        $this->appendMeta('object', $data['object']);
        $this->appendMeta('created_at', $data['created_at']);
        $this->appendMeta('name', $data['name']);
        $this->appendMeta('description', $data['description']);
        $this->appendMeta('model', $data['model']);
        $this->appendMeta('instructions', $data['instructions']);
        $this->appendMeta('tools', $data['tools']);
        $this->appendMeta('file_ids', $data['file_ids']);
        $this->appendMeta('metadata', $data['metadata']);
    }

    public function response()
    {
        return $this->response;
    }
}
