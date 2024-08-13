<?php

namespace Outl1ne\NovaOpenAI\Exceptions;

use RuntimeException;

class ThreadRunStatusFailedException extends RuntimeException
{
    protected $message = 'The OpenAI API responded with failed status for running the thread.';
}
