<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads;

use Exception;
use Outl1ne\NovaOpenAI\OpenAI;
use Outl1ne\NovaOpenAI\Models\OpenAIRequest;
use Outl1ne\NovaOpenAI\Capabilities\Measurable;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Parameters\Messages;
use Outl1ne\NovaOpenAI\Capabilities\Threads\Responses\ThreadResponse;

class CreateThread
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
        ?Messages $messages,
        ?array $metadata,
    ): ThreadResponse {
        $this->request->input = $messages->messages ?? null;
        $this->request->appendArgument('metadata', $metadata);

        $this->pending();

        try {
            $response = $this->openAI->http()->withHeader('Content-Type', 'application/json')->post('threads', [
                'messages' => $messages->messages ?? null,
                ...$this->request->arguments,
            ]);
            $response->throw();

            return $this->handleResponse(new ThreadResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    protected function handleResponse(ThreadResponse $response)
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
