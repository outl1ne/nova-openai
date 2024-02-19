<?php

namespace Outl1ne\NovaOpenAI\Exceptions;

use InvalidArgumentException;

class OrganizationInvalidException extends InvalidArgumentException
{
    protected $message = 'The OpenAI API Organization is in invalid format.';
}
