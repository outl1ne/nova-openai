<?php

namespace Outl1ne\NovaOpenAI\Resources\Embeddings\Responses;

use Illuminate\Http\Client\Response;
use Outl1ne\NovaOpenAI\Resources\Usage;

class EmbeddingsResponse
{
    public string $object;
    public string $model;
    public Usage $usage;
    public array $embeddings;

    public function __construct(
        protected readonly Response $response,
    ) {
        $data = $response->json();

        $this->object = $data['object'];
        $this->model = $data['object'];
        $this->usage = new Usage($data['usage']['prompt_tokens'], null, $data['usage']['total_tokens']);

        foreach ($data['data'] as $embedding) {
            $this->embeddings[] = new Embedding($embedding);
        }
    }

    public function response()
    {
        return $this->response;
    }
}
