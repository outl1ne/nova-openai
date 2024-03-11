<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads\Parameters;

class Message
{
    public function __construct(
        public readonly string $role,
        public readonly string $content,
        public readonly array $fileIds = [],
        public readonly ?array $metadata = null,
    ) {
    }

    static public function user(string $content, array $fileIds = [], ?array $metadata = null): self
    {
        return new self(
            'user',
            $content,
            $fileIds,
            $metadata,
        );
    }
}
