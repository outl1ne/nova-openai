<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Responses;

use GuzzleHttp\Psr7\Response as HttpResponse;
use Outl1ne\NovaOpenAI\Models\OpenAIRequest;

class Response
{
    use AppendsMeta;

    public ?Usage $usage;
    public ?RateLimit $rateLimit;
    public OpenAIRequest $request;

    public readonly ?array $data;
    public readonly array $headers;
    public ?string $model = null;

    public function __construct(
        public readonly HttpResponse $response,
    ) {
        $this->data = json_decode($response->getBody(), true);
        $this->headers = $response->getHeaders();

        $this->usage = $this->createUsage();
        $this->rateLimit = $this->createRateLimit();
    }

    protected function createUsage()
    {
        $promptTokens = $this->data['usage']['prompt_tokens'] ?? null;
        $completionTokens = $this->data['usage']['completion_tokens'] ?? null;
        $totalTokens = $this->data['usage']['total_tokens'] ?? null;

        if ($promptTokens === null || $totalTokens === null) return null;

        return new Usage(
            $promptTokens,
            $completionTokens,
            $totalTokens,
        );
    }

    protected function createRateLimit()
    {
        $limitRequests = $this->headers['x-ratelimit-limit-requests'][0] ?? null;

        if ($limitRequests === null) return null;

        return new RateLimit(
            limitRequests: $this->headers['x-ratelimit-limit-requests'][0] ?? null,
            limitTokens: $this->headers['x-ratelimit-limit-tokens'][0] ?? null,
            remainingRequests: $this->headers['x-ratelimit-remaining-requests'][0] ?? null,
            remainingTokens: $this->headers['x-ratelimit-remaining-tokens'][0] ?? null,
            resetRequests: $this->headers['x-ratelimit-reset-requests'][0] ?? null,
            resetTokens: $this->headers['x-ratelimit-reset-tokens'][0] ?? null,
        );
    }
}
