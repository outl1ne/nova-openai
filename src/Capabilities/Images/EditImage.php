<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Images;

use Exception;
use Outl1ne\NovaOpenAI\Capabilities\CapabilityClient;
use Outl1ne\NovaOpenAI\Capabilities\Images\Responses\ImageResponse;

class EditImage extends CapabilityClient
{
    protected string $method = 'POST';

    protected string $path = '/v1/images/edits';

    public function makeRequest(
        string|array $image,
        string $prompt,
        ?string $mask = null,
        ?string $model = null,
        ?int $n = null,
        ?string $size = null,
        ?string $quality = null,
        ?string $responseFormat = null,
        ?string $user = null,
        ?string $background = null,
    ): ImageResponse {
        $this->request->model_requested = $model;
        $this->request->input = $prompt;
        $this->request->appendArgument('prompt', $prompt);
        $this->request->appendArgument('model', $model);
        $this->request->appendArgument('n', $n);
        $this->request->appendArgument('size', $size);
        $this->request->appendArgument('quality', $quality);
        $this->request->appendArgument('response_format', $responseFormat);
        $this->request->appendArgument('user', $user);
        $this->request->appendArgument('background', $background);

        $this->pending();

        try {
            $multipart = [];
            $images = is_string($image) ? [$image] : $image;

            // Add images
            foreach ($images as $contents) {
                $multipart[] = [
                    'name' => 'image[]',
                    'contents' => $contents,
                ];
            }

            // Add mask file if provided
            if ($mask) {
                $multipart[] = [
                    'name' => 'mask',
                    'contents' => $mask,
                ];
            }

            // Add other parameters
            foreach ($this->request->arguments as $key => $value) {
                if ($value !== null && $key !== 'image' && $key !== 'mask') {
                    $multipart[] = [
                        'name' => $key,
                        'contents' => $value,
                    ];
                }
            }

            $response = $this->openAI->http()->post($this->path, [
                'multipart' => $multipart,
            ]);

            return $this->handleResponse(new ImageResponse($response));
        } catch (Exception $e) {
            $this->handleException($e);
        }
    }
}
