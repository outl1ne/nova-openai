<?php

namespace Outl1ne\NovaOpenAI\Exceptions;

use InvalidArgumentException;

class ApiKeyMissingException extends InvalidArgumentException
{
    protected $message = 'The OpenAI API Key is missing.';
}
