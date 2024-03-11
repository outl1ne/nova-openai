<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Embeddings;

use Closure;
use Exception;
use Outl1ne\NovaOpenAI\Pricing\Pricing;
use Outl1ne\NovaOpenAI\Models\OpenAIRequest;
use Outl1ne\NovaOpenAI\Capabilities\Measurable;
use Outl1ne\NovaOpenAI\Capabilities\Embeddings\Responses\EmbeddingsResponse;
use Outl1ne\NovaOpenAI\OpenAI;

class CreateEmbedding
{
    use Measurable;

    protected OpenAIRequest $request;

    public function __construct(
        protected OpenAI $openAI,
    ) {
        $this->request = new OpenAIRequest;
        $this->request->method = 'embeddings';
        $this->request->arguments = [];
    }

    public function pending()
    {
        $this->measure();

        $this->request->status = 'pending';
        $this->request->save();

        return $this->request;
    }

    public function makeRequest(string $model, string $input, ?string $encodingFormat = null, ?int $dimensions = null, ?string $user = null): EmbeddingsResponse
    {
        $this->request->model_requested = $model;
        $this->request->input = $input;
        $this->request->appendArgument('encoding_format', $encodingFormat);
        $this->request->appendArgument('dimensions', $dimensions);
        $this->request->appendArgument('user', $user);

        $this->pending();

        try {
            $response = $this->openAI->http()->withHeader('Content-Type', 'application/json')->post('embeddings', [
                'model' => $model,
                'input' => $input,
                ...$this->request->arguments,
            ]);
            $response->throw();

            return $this->handleResponse(new EmbeddingsResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    protected function handleResponse(EmbeddingsResponse $response)
    {
        $this->request->cost = $this->openAI->pricing->embedding()->model($response->model)->calculate($response->usage->promptTokens);
        $this->request->time_sec = $this->measure();
        $this->request->status = 'success';
        $this->request->meta = $response->meta;
        $this->request->model_used = $response->model;
        $this->request->output = $response->embedding;
        $this->request->usage_prompt_tokens = $response->usage->promptTokens;
        $this->request->usage_total_tokens = $response->usage->totalTokens;
        $this->request->save();

        $response->request = $this->request;

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
