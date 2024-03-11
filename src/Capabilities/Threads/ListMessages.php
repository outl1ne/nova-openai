<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads;

use Exception;
use Outl1ne\NovaOpenAI\OpenAI;
use Outl1ne\NovaOpenAI\Models\OpenAIRequest;
use Outl1ne\NovaOpenAI\Capabilities\Measurable;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Responses\MessagesResponse;

class ListMessages
{
    use Measurable;

    protected OpenAIRequest $request;

    public function __construct(
        protected OpenAI $openAI,
    ) {
        $this->request = new OpenAIRequest;
        $this->request->method = 'threads';
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
        string $threadId,
        ?int $limit = null,
        ?string $order = null,
        ?string $after = null,
        ?string $before = null,
    ): MessagesResponse {
        $this->request->appendArgument('limit', $limit);
        $this->request->appendArgument('order', $order);
        $this->request->appendArgument('after', $after);
        $this->request->appendArgument('before', $before);

        $this->pending();

        try {
            $response = $this->openAI->http()->withHeader('Content-Type', 'application/json')->get("threads/{$threadId}/messages", [
                ...$this->request->arguments,
            ]);
            $response->throw();

            return $this->handleResponse(new MessagesResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    protected function handleResponse(MessagesResponse $response)
    {
        $this->request->time_sec = $this->measure();
        $this->request->status = 'success';
        $this->request->output = $response->messages;
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
