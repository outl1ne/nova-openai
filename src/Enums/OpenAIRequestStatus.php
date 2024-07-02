<?php

namespace Outl1ne\NovaOpenAI\Enums;

use Outl1ne\NovaOpenAI\Traits\EnumOptions;

enum OpenAIRequestStatus: string
{
    use EnumOptions;

    case PENDING = 'pending';
    case SUCCESS = 'success';
    case ERROR = 'error';
    case CACHE = 'cache';
    case STREAMING = 'streaming';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::SUCCESS => 'Success',
            self::ERROR => 'Error',
            self::STREAMING => 'Streaming',
        };
    }
}
