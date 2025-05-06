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
        $this->request->appendArgument('model', $model);
        $this->request->appendArgument('n', $n);
        $this->request->appendArgument('size', $size);
        $this->request->appendArgument('response_format', $responseFormat);
        $this->request->appendArgument('user', $user);

        $this->pending();

        try {
            $multipart = [
                [
                    'name' => 'image',
                    'contents' => $image,
                ],
            ];

            foreach ($this->request->arguments as $key => $value) {
                if ($value !== null && $key !== 'image') {
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
