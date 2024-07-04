<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Files;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Files\Responses\FileContentResponse;

class RetrieveFileContent extends CapabilityClient
{
    protected string $method = 'files';

    public function makeRequest(
        string $assistantId,
        ?string $model = null,
        ?string $name = null,
        ?string $description = null,
        ?string $instructions = null,
        ?array $tools = null,
        ?array $fileIds = null,
        ?array $metadata = null,
    ): FileContentResponse {
        $this->request->appendArgument('model', $model);
        $this->request->appendArgument('name', $name);
        $this->request->appendArgument('description', $description);
        $this->request->appendArgument('instructions', $instructions);
        $this->request->appendArgument('tools', $tools);
        $this->request->appendArgument('file_ids', $fileIds);
        $this->request->appendArgument('metadata', $metadata);

        $this->pending();

        try {
            $response = $this->openAI->http()->get("files/{$assistantId}/content", [
                'query' => [
                    ...$this->request->arguments,
                ],
            ]);

            return $this->handleResponse(new FileContentResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
