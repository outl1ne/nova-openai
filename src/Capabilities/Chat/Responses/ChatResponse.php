<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Chat\Responses;

use Illuminate\Http\Client\Response;
use Outl1ne\NovaOpenAI\Capabilities\Responses\AppendsMeta;
use Outl1ne\NovaOpenAI\Capabilities\Responses\Usage;
use Outl1ne\NovaOpenAI\Capabilities\Responses\RateLimit;

class ChatResponse
{
    use AppendsMeta;

    public string $object;
    public string $model;
    public array $choices;
    public Usage $usage;
    public RateLimit $rateLimit;

    public function __construct(
        protected readonly Response $response,
    ) {
        $data = $response->json();
        $headers = $response->headers();

        $this->model = $data['model'];
        $this->choices = $data['choices'];
        $this->appendMeta('id', $data['id']);
        $this->appendMeta('object', $data['object']);
        $this->appendMeta('system_fingerprint', $data['system_fingerprint']);
        $this->usage = new Usage(
            promptTokens: $data['usage']['prompt_tokens'],
            completionTokens: $data['usage']['completion_tokens'],
            totalTokens: $data['usage']['total_tokens'],
        );
        $this->rateLimit = new RateLimit(
            limitRequests: $headers['x-ratelimit-limit-requests'][0],
            limitTokens: $headers['x-ratelimit-limit-tokens'][0],
            remainingRequests: $headers['x-ratelimit-remaining-requests'][0],
            remainingTokens: $headers['x-ratelimit-remaining-tokens'][0],
            resetRequests: $headers['x-ratelimit-reset-requests'][0],
            resetTokens: $headers['x-ratelimit-reset-tokens'][0],
        );
    }

    public function response()
    {
        return $this->response;
    }
}