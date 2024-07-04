<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Responses;

use GuzzleHttp\Psr7\Response;
use Outl1ne\NovaOpenAI\Models\OpenAIRequest;

class StreamResponse
{
    use AppendsMeta;

    public ?Usage $usage;
    public OpenAIRequest $request;

    public ?string $model = null;
    public array $streamChunks;

    public function __construct(
        public readonly Response $response,
        StreamChunk ...$streamChunks,
    ) {
        $this->streamChunks = $streamChunks;
        $this->usage = $this->createUsage();
    }

    protected function createUsage()
    {
        $lastChunk = end($this->streamChunks);

        return $lastChunk->usage;
    }
}
