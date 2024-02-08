<?php

namespace Outl1ne\NovaOpenAI\Resources\Embeddings\Responses;

use Illuminate\Http\Client\Response;
use Outl1ne\NovaOpenAI\Resources\Responses\Usage;
use Outl1ne\NovaOpenAI\Resources\Responses\RateLimit;

class EmbeddingsResponse
{
    public string $object;
    public string $model;
    public string $modelUsed;
    public Usage $usage;
    public RateLimit $rateLimit;
    public array $embeddings;

    public function __construct(
        protected readonly Response $response,
    ) {
        $data = $response->json();
        $headers = $response->headers();

        $this->object = $data['object'];
        $this->model = $data['model'];
        $this->modelUsed = $headers['openai-model'][0];
        $this->usage = new Usage($data['usage']['prompt_tokens'], null, $data['usage']['total_tokens']);
        $this->rateLimit = new RateLimit(
            $headers['x-ratelimit-limit-requests'][0],
            $headers['x-ratelimit-limit-tokens'][0],
            $headers['x-ratelimit-remaining-requests'][0],
            $headers['x-ratelimit-remaining-tokens'][0],
            $headers['x-ratelimit-reset-requests'][0],
            $headers['x-ratelimit-reset-tokens'][0],
        );

        foreach ($data['data'] as $embedding) {
            $this->embeddings[] = new Embedding($embedding);
        }
    }

    public function response()
    {
        return $this->response;
    }
}
