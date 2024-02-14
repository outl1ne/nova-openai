<?php

namespace Outl1ne\NovaOpenAI\Exceptions;

use InvalidArgumentException;

class OrganizationInvalidException extends InvalidArgumentException
{
    /**
     * Create a new exception instance.
     */
    public static function create(): self
    {
        return new self(
            'The OpenAI API Organization is in invalid format.'
        );
    }
}
