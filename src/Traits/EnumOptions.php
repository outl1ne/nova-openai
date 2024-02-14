<?php

namespace Outl1ne\NovaOpenAI\Traits;

trait EnumOptions
{
    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }

        return $options;
    }
}
