<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Responses;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Responses\Responses\ResponsesResponse;

class RetrieveResponse extends CapabilityClient
{
    protected string $method = 'responses';

    public function makeRequest(string $responseId)
    {
        $this->request->input = $responseId;

        $this->pending();

        try {
            $response = $this->openAI->http()->get("responses/{$responseId}");

            return $this->handleResponse(new ResponsesResponse($response), [$this, 'response']);
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }

    protected function response(ResponsesResponse $response)
    {
        $this->request->output = $response->output;
    }
} 