<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Assistants;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\Assistants\Responses\AssistantFileListResponse;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Assistants\Responses\AssistantFileResponse;

class ListAssistantFiles extends CapabilityClient
{
    protected string $method = 'assistants';

    public function makeRequest(
        string $assistantId,
        ?int $limit = null,
        ?string $order = null,
        ?string $after = null,
        ?string $before = null,
    ): AssistantFileListResponse {
        $this->request->appendArgument('limit', $limit);
        $this->request->appendArgument('order', $order);
        $this->request->appendArgument('after', $after);
        $this->request->appendArgument('before', $before);

        $this->pending();

        try {
            $response = $this->openAI->http()->get("assistants/{$assistantId}/files", [
                'query' => [
                    ...$this->request->arguments,
                ],
            ]);

            return $this->handleResponse(new AssistantFileListResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
