<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Responses;

class StreamChunk
{
    use AppendsMeta;

    public ?Usage $usage;

    public ?string $model = null;

    public function __construct(
        protected readonly array $data,
    ) {

        $this->usage = $this->createUsage();
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
}
