<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Responses;

use Illuminate\Http\Client\Response as HttpResponse;
use Outl1ne\NovaOpenAI\Models\OpenAIRequest;

class Response
{
    use AppendsMeta;

    public ?Usage $usage;
    public ?RateLimit $rateLimit;
    public OpenAIRequest $request;

    public readonly array $data;
    public readonly array $headers;
    public ?string $model = null;

    public function __construct(
        public readonly HttpResponse $response,
    ) {
        $this->data = $response->json();
        $this->headers = $response->headers();

        $this->usage = $this->createUsage();
        $this->rateLimit = $this->createRateLimit();
    }

    protected function createUsage()
    {
        $promptTokens = $this->data['usage']['prompt_tokens'] ?? null;
        $completionTokens = $this->data['usage']['completion_tokens'] ?? null;
        $totalTokens = $this->data['usage']['total_tokens'] ?? null;

        if ($totalTokens === null) return null;

        return new Usage(
            $promptTokens,
            $completionTokens,
            $totalTokens,
        );
    }

    protected function createRateLimit()
    {
        $limitRequests = $headers['x-ratelimit-limit-requests'][0] ?? null;

        if ($limitRequests === null) return null;

        return new RateLimit(
            limitRequests: $headers['x-ratelimit-limit-requests'][0] ?? null,
            limitTokens: $headers['x-ratelimit-limit-tokens'][0] ?? null,
            remainingRequests: $headers['x-ratelimit-remaining-requests'][0] ?? null,
            remainingTokens: $headers['x-ratelimit-remaining-tokens'][0] ?? null,
            resetRequests: $headers['x-ratelimit-reset-requests'][0] ?? null,
            resetTokens: $headers['x-ratelimit-reset-tokens'][0] ?? null,
        );
    }
}
