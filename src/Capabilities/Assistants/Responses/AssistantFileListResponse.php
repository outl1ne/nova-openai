<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Assistants\Responses;

use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;

class AssistantFileListResponse extends Response
{
    public array $files;
    public bool $hasMore;

    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);

        $this->files = $this->data['data'];
        $this->hasMore = $this->data['has_more'];
        $this->appendMeta('object', $this->data['object']);
        $this->appendMeta('first_id', $this->data['first_id']);
        $this->appendMeta('last_id', $this->data['last_id']);
        $this->appendMeta('has_more', $this->data['has_more']);
    }
}
