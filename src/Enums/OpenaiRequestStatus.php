<?php

namespace Outl1ne\NovaOpenAI\Enums;

enum OpenaiRequestStatus: string
{
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case ERROR = 'error';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::SUCCESS => 'Success',
            self::ERROR => 'Error',
        };
    }

    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }

        return $options;
    }
}
