<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Responses;

class RateLimit
{
    public function __construct(
        public readonly ?int $limitRequests,
        public readonly ?int $limitTokens,
        public readonly ?int $remainingRequests,
        public readonly ?int $remainingTokens,
        public readonly ?string $resetRequests,
        public readonly ?string $resetTokens,
    ) {
    }
}
