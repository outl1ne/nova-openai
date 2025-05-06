<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Images\Responses;

class ImageData
{
    public function __construct(
        public readonly ?string $url = null,
        public readonly ?string $b64_json = null,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            url: $data['url'] ?? null,
            b64_json: $data['b64_json'] ?? null,
        );
    }
} 