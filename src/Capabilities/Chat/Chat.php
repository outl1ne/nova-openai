<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Chat;

use Outl1ne\NovaOpenAI\Capabilities\Capability;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\Messages;
use Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters\ResponseFormat;

class Chat extends Capability
{
    public function create(
        string $model,
        Messages $messages,
        ?ResponseFormat $responseFormat = null,
        ?string $user = null,
        ?float $frequencyPenalty = null,
        ?array $logitBias = null,
        ?bool $logprobs = null,
        ?int $topLogprobs = null,
        ?int $maxTokens = null,
        ?int $n = null,
        ?float $presencePenalty = null,
        ?int $seed = null,
        null|string|array $stop = null,
        ?float $temperature = null,
        ?float $topP = null,
        ?array $tools = null,
        null|string|array $toolChoice = null,
    ) {
        return (new CreateChat($this->http, $this->pricing))->makeRequest(
            $model,
            $messages,
            $responseFormat,
            $user,
            $frequencyPenalty,
            $logitBias,
            $logprobs,
            $topLogprobs,
            $maxTokens,
            $n,
            $presencePenalty,
            $seed,
            $stop,
            $temperature,
            $topP,
            $tools,
            $toolChoice,
        );
    }
}
