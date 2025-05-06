<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Images;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Images\Responses\ImageResponse;

class CreateVariation extends CapabilityClient
{
    protected string $method = 'POST';

    protected string $path = '/v1/images/variations';

    public function makeRequest(
        string $image,
        ?string $model = null,
        ?int $n = null,
        ?string $size = null,
        ?string $responseFormat = null,
        ?string $user = null,
    ): ImageResponse {
        $this->request->model_requested = $model;
        $this->request->input = $image;
        $this->request->appendArgument('image', $image);
        $this->request->appendArgument('model', $model);
        $this->request->appendArgument('n', $n);
        $this->request->appendArgument('size', $size);
        $this->request->appendArgument('response_format', $responseFormat);
        $this->request->appendArgument('user', $user);

        $this->pending();

        try {
            $response = $this->openAI->http()->post($this->path, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($this->request->arguments),
            ]);

            return $this->handleResponse(new ImageResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
