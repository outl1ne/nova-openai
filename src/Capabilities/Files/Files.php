<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Files;

use Outl1ne\NovaOpenAI\Capabilities\Capability;

class Files extends Capability
{
    public function upload(
        $file,
        string $filename,
        string $purpose,
    ) {
        return (new UploadFile($this))->makeRequest(
            $file,
            $filename,
            $purpose,
        );
    }

    public function list(
        ?string $purpose = null,
    ) {
        return (new ListFiles($this))->makeRequest(
            $purpose,
        );
    }

    public function retrieve(
        string $fileId,
    ) {
        return (new RetrieveFile($this))->makeRequest(
            $fileId,
        );
    }

    public function retrieveContent(
        string $fileId,
    ) {
        return (new RetrieveFileContent($this))->makeRequest(
            $fileId,
        );
    }

    public function delete(
        string $fileId,
    ) {
        return (new DeleteFile($this))->makeRequest(
            $fileId,
        );
    }
}
