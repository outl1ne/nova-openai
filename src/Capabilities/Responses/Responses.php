<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Responses;

use Outl1ne\NovaOpenAI\Capabilities\Capability;

class Responses extends Capability
{
    public function create(
        string $model,
        string|array $input,
        ?string $instructions = null,
        ?string $previousResponseId = null,
        ?array $tools = null,
        ?string $toolChoice = null,
        ?float $temperature = null,
        ?float $topP = null,
        ?int $maxOutputTokens = null,
        ?bool $parallelToolCalls = null,
        ?string $user = null,
        ?array $metadata = null,
        ?bool $store = null,
        ?bool $background = null,
        ?string $reasoningEffort = null,
        ?array $reasoning = null,
        ?array $text = null,
        ?string $truncation = null,
        ?array $include = null,
        ?bool $stream = null,
        ?string $requestName = null
    ) {
        return (new CreateResponse($this))->makeRequest(
            $model,
            $input,
            $instructions,
            $previousResponseId,
            $tools,
            $toolChoice,
            $temperature,
            $topP,
            $maxOutputTokens,
            $parallelToolCalls,
            $user,
            $metadata,
            $store,
            $background,
            $reasoningEffort,
            $reasoning,
            $text,
            $truncation,
            $include,
            $stream,
            $requestName
        );
    }

    public function retrieve(string $responseId)
    {
        return (new RetrieveResponse($this))->makeRequest($responseId);
    }

    public function delete(string $responseId)
    {
        return (new DeleteResponse($this))->makeRequest($responseId);
    }

    public function cancel(string $responseId)
    {
        return (new CancelResponse($this))->makeRequest($responseId);
    }
} 