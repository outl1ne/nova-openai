<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Files\Responses;

use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;

class FileListResponse extends Response
{
    public array $files;
    public bool $hasMore;

    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);

        $this->files = $this->data['data'];
        $this->hasMore = $this->data['has_more'];
        $this->appendMeta('object', $this->data['object']);
        $this->appendMeta('data', $this->data['data']);
        $this->appendMeta('has_more', $this->data['has_more']);
    }
}
