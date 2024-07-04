<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Files\Responses;

use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;

class FileContentResponse extends Response
{
    public readonly string $content;

    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);

        $this->content = $arguments[0]->getBody()->getContents();
    }
}
