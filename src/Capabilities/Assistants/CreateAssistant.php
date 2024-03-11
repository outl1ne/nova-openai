<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Assistants;

use Exception;
use Outl1ne\NovaOpenAI\OpenAI;
use Outl1ne\NovaOpenAI\Models\OpenAIRequest;
use Outl1ne\NovaOpenAI\Capabilities\Measurable;
use Outl1ne\NovaOpenAI\Capabilities\Assistants\Responses\AssistantResponse;

class CreateAssistant
{
    use Measurable;

    protected OpenAIRequest $request;

    public function __construct(
        protected OpenAI $openAI,
    ) {
        $this->request = new OpenAIRequest;
        $this->request->method = 'assistants';
        $this->request->arguments = [];
    }

    public function pending()
    {
        $this->measure();

        $this->request->status = 'pending';
        $this->request->save();

        return $this->request;
    }

    public function makeRequest(
        string $model,
        ?string $name = null,
        ?string $description = null,
        ?string $instructions = null,
        ?array $tools = null,
        ?array $fileIds = null,
        ?array $metadata = null,
    ): AssistantResponse {
        $this->request->appendArgument('model', $model);
        $this->request->appendArgument('name', $name);
        $this->request->appendArgument('description', $description);
        $this->request->appendArgument('instructions', $instructions);
        $this->request->appendArgument('tools', $tools);
        $this->request->appendArgument('file_ids', $fileIds);
        $this->request->appendArgument('metadata', $metadata);

        $this->pending();

        try {
            $response = $this->openAI->http()->withHeader('Content-Type', 'application/json')->post("assistants", [
                ...$this->request->arguments,
            ]);
            $response->throw();

            return $this->handleResponse(new AssistantResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    protected function handleResponse(AssistantResponse $response)
    {
        $this->request->time_sec = $this->measure();
        $this->request->status = 'success';
        $this->request->meta = $response->meta;
        $this->request->save();

        return $response;
    }

    public function handleException(Exception $e)
    {
        $this->request->time_sec = $this->measure();
        $this->request->status = 'error';
        $this->request->error = $e->getMessage();
        $this->request->save();

        throw $e;
    }
}
