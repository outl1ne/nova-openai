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

            // Handle multiple images
            if (is_array($image) && isset($image[0])) {
                foreach ($image as $index => $img) {
                    if (is_string($img)) {
                        $multipart[] = [
                            'name' => "image[]",
                            'contents' => fopen($img, 'r'),
                            'type' => mime_content_type($img),
                        ];
                    } else {
                        $multipart[] = [
                            'name' => "image[]",
                            'contents' => $img['contents'],
                            'filename' => $img['filename'] ?? "image_{$index}.png",
                            'type' => $img['type'] ?? 'image/png',
                        ];
                    }
                }
            } else {
                // Handle single image
                if (is_string($image)) {
                    $multipart[] = [
                        'name' => 'image',
                        'contents' => fopen($image, 'r'),
                        'type' => mime_content_type($image),
                    ];
                } else {
                    $multipart[] = [
                        'name' => 'image',
                        'contents' => $image['contents'],
                        'filename' => $image['filename'] ?? 'image.png',
                        'type' => $image['type'] ?? 'image/png',
                    ];
                }
            }

            // Add mask file if provided
            if ($mask) {
                $multipart[] = [
                    'name' => 'mask',
                    'contents' => fopen($mask, 'r'),
                    'type' => mime_content_type($mask),
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
