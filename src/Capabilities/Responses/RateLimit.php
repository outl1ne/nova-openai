<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Responses;

class RateLimit
{
    public function __construct(
        public readonly int|null $limitRequests,
        public readonly int|null $limitTokens,
        public readonly int|null $remainingRequests,
        public readonly int|null $remainingTokens,
        public readonly string|null $resetRequests,
        public readonly string|null $resetTokens,
    ) {
    }
}
