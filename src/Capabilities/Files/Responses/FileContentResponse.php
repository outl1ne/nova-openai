<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Files\Responses;

use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;

class FileContentResponse extends Response
{
    public $content;

    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);

        $this->content = $this->data;
    }
}
