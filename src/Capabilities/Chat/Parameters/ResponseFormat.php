<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters;

class ResponseFormat
{
    public ?array $responseFormat = null;

    public function text(): self
    {
        $this->responseFormat = [
            'type' => 'text',
        ];
        return $this;
    }

    public function json(): self
    {
        $this->responseFormat = [
            'type' => 'json_object',
        ];
        return $this;
    }
}
