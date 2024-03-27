<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Files\Responses;

use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;

class FileResponse extends Response
{
    public string $id;

    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);

        $this->id = $this->data['id'];
        $this->appendMeta('object', $this->data['object']);
        $this->appendMeta('id', $this->data['id']);
        $this->appendMeta('purpose', $this->data['purpose']);
        $this->appendMeta('filename', $this->data['filename']);
        $this->appendMeta('bytes', $this->data['bytes']);
        $this->appendMeta('created_at', $this->data['created_at']);
        $this->appendMeta('status', $this->data['status']);
        $this->appendMeta('status_details', $this->data['status_details']);
    }
}
