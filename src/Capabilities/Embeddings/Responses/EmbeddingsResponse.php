<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Embeddings\Responses;

use Illuminate\Http\Client\Response;
use Outl1ne\NovaOpenAI\Capabilities\Responses\Usage;
use Outl1ne\NovaOpenAI\Capabilities\Responses\RateLimit;
use Outl1ne\NovaOpenAI\Capabilities\Responses\AppendsMeta;

class EmbeddingsResponse
{
    use AppendsMeta;

    public string $object;
    public string $model;
    public string $modelUsed;
    public Usage $usage;
    public RateLimit $rateLimit;
    public Embedding $embedding;

    public function __construct(
        protected readonly Response $response,
    ) {
        $data = $response->json();
        $headers = $response->headers();

        $this->model = $data['model'];
        $this->appendMeta('object', $data['object']);
        $this->usage = new Usage(
            promptTokens: $data['usage']['prompt_tokens'],
            completionTokens: null,
            totalTokens: $data['usage']['total_tokens'],
        );
        $this->rateLimit = new RateLimit(
            limitRequests: $headers['x-ratelimit-limit-requests'][0] ?? null,
            limitTokens: $headers['x-ratelimit-limit-tokens'][0] ?? null,
            remainingRequests: $headers['x-ratelimit-remaining-requests'][0] ?? null,
            remainingTokens: $headers['x-ratelimit-remaining-tokens'][0] ?? null,
            resetRequests: $headers['x-ratelimit-reset-requests'][0] ?? null,
            resetTokens: $headers['x-ratelimit-reset-tokens'][0] ?? null,
        );
        $this->embedding = new Embedding($data['data'][0]);
    }

    public function response()
    {
        return $this->response;
    }
}
