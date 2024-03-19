<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Embeddings;

use Exception;
use Outl1ne\NovaOpenAI\Pricing\Calculator;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Embeddings\Responses\EmbeddingsResponse;

class CreateEmbedding extends CapabilityClient
{
    protected string $method = 'embeddings';

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

            return $this->handleResponse(new EmbeddingsResponse($response), [$this, 'response']);
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    protected function response(EmbeddingsResponse $response)
    {
        $this->request->output = $response->embedding;
    }

    protected function pricing(): Calculator
    {
        return $this->openAI->pricing->embedding();
    }
}
