<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Responses\Responses;

use GuzzleHttp\Psr7\Response;
use Outl1ne\NovaOpenAI\Capabilities\Responses\StreamChunk;
use Outl1ne\NovaOpenAI\Capabilities\Responses\StreamResponse;

class StreamedResponsesResponse extends StreamResponse
{
    public array $output;

    public function __construct(Response $response, StreamChunk ...$streamChunks)
    {
        parent::__construct($response, ...$streamChunks);

        $lastChunk = end($this->streamChunks);
        $this->model = $lastChunk->model;
        $this->appendMeta('id', $lastChunk->meta['id']);
        $this->appendMeta('object', $lastChunk->meta['object']);
        $this->appendMeta('created_at', $lastChunk->meta['created_at'] ?? null);

        $this->output = $this->createOutput();
    }

    protected function createOutput(): array
    {
        $output = [];

        foreach ($this->streamChunks as $chunk) {
            // Accumulate output from stream chunks
            if (isset($chunk->output)) {
                foreach ($chunk->output as $outputItem) {
                    $output[] = $outputItem;
                }
            }
        }

        return $output;
    }
} 