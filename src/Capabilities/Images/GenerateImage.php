<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Images;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Images\Responses\ImageResponse;

class GenerateImage extends CapabilityClient
{
    protected string $method = 'POST';

    protected string $path = '/v1/images/generations';

    public function makeRequest(
        string $prompt,
        ?string $model = null,
        ?int $n = null,
        ?string $size = null,
        ?string $quality = null,
        ?string $responseFormat = null,
        ?string $style = null,
        ?string $user = null,
        ?string $background = null,
        ?string $moderation = null,
        ?int $outputCompression = null,
        ?string $outputFormat = null,
    ): ImageResponse {
        $this->request->model_requested = $model;
        $this->request->input = $prompt;
        $this->request->appendArgument('prompt', $prompt);
        $this->request->appendArgument('model', $model);
        $this->request->appendArgument('n', $n);
        $this->request->appendArgument('size', $size);
        $this->request->appendArgument('quality', $quality);
        $this->request->appendArgument('response_format', $responseFormat);
        $this->request->appendArgument('style', $style);
        $this->request->appendArgument('user', $user);
        $this->request->appendArgument('background', $background);
        $this->request->appendArgument('moderation', $moderation);
        $this->request->appendArgument('output_compression', $outputCompression);
        $this->request->appendArgument('output_format', $outputFormat);

        $this->pending();

        try {
            $response = $this->openAI->http()->post($this->path, [
                'json' => $this->request->arguments,
            ]);

            return $this->handleResponse(new ImageResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
