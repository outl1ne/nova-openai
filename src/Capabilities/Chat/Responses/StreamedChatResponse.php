<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Chat\Responses;

use GuzzleHttp\Psr7\Response;
use Outl1ne\NovaOpenAI\Capabilities\Responses\StreamChunk;
use Outl1ne\NovaOpenAI\Capabilities\Responses\StreamResponse;

class StreamedChatResponse extends StreamResponse
{
    public array $choices;

    public function __construct(Response $response, StreamChunk ...$streamChunks)
    {
        parent::__construct($response, ...$streamChunks);

        $lastChunk = end($this->streamChunks);
        $this->model = $lastChunk->model;
        $this->appendMeta('id', $lastChunk->meta['id']);
        $this->appendMeta('object', $lastChunk->meta['object']);
        $this->appendMeta('system_fingerprint', $lastChunk->meta['system_fingerprint'] ?? null);

        $this->choices = $this->createChoices();
    }

    protected function createChoices(): array
    {
        $choices = [];

        foreach ($this->streamChunks as $chunk) {
            foreach ($chunk->choices as $choice) {
                $choices[$choice['index']]['index'] = $choice['index'];
                $choices[$choice['index']]['message']['role'] = $this->handleDelta($choices[$choice['index']]['message']['role'] ?? null, $choice['delta']['role'] ?? null);
                $choices[$choice['index']]['message']['content'] = $this->handleDelta($choices[$choice['index']]['message']['content'] ?? null, $choice['delta']['content'] ?? null);
                $choices[$choice['index']]['logprobs'] = $choice['logprobs'] ?? null;
                $choices[$choice['index']]['finish_reason'] = $choice['finish_reason'];
            }
        }

        return $choices;
    }

    protected function handleDelta($carry, $chunk): ?string
    {
        if ($carry === null && $chunk === null) {
            return null;
        }

        if ($carry === null) {
            return $chunk;
        }

        return $carry . $chunk;
    }
}
