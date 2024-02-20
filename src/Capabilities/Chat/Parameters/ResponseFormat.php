<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters;

class ResponseFormat
{
    public ?array $responseFormat = null;

    public function text(): void
    {
        $this->responseFormat = [
            'type' => 'text',
        ];
    }

    public function json(): void
    {
        $this->responseFormat = [
            'type' => 'json_object',
        ];
    }
}
