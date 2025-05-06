<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Images;

use Outl1ne\NovaOpenAI\Capabilities\Capability;

class Images extends Capability
{
    public function generate(
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
    ) {
        return (new GenerateImage($this))->makeRequest(
            $prompt,
            $model,
            $n,
            $size,
            $quality,
            $responseFormat,
            $style,
            $user,
            $background,
            $moderation,
            $outputCompression,
            $outputFormat,
        );
    }

    public function edit(
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
    ) {
        return (new EditImage($this))->makeRequest(
            $image,
            $prompt,
            $mask,
            $model,
            $n,
            $size,
            $quality,
            $responseFormat,
            $user,
            $background,
        );
    }

    public function createVariation(
        string $image,
        ?string $model = null,
        ?int $n = null,
        ?string $size = null,
        ?string $responseFormat = null,
        ?string $user = null,
    ) {
        return (new CreateVariation($this))->makeRequest(
            $image,
            $model,
            $n,
            $size,
            $responseFormat,
            $user,
        );
    }

    /**
     * Edit multiple images at once
     * 
     * @param array<string> $imagePaths Array of image file paths
     * @param string $prompt The prompt for the edit
     * @param array $options Additional options for the edit
     * @return \Outl1ne\NovaOpenAI\Capabilities\Images\Responses\ImageResponse
     */
    public function editMultiple(
        array $imagePaths,
        string $prompt,
        array $options = []
    ) {
        $images = array_map(function ($path) {
            return [
                'contents' => file_get_contents($path),
                'filename' => basename($path),
                'type' => mime_content_type($path),
            ];
        }, $imagePaths);

        return $this->edit(
            image: $images,
            prompt: $prompt,
            model: $options['model'] ?? null,
            n: $options['n'] ?? null,
            size: $options['size'] ?? null,
            quality: $options['quality'] ?? null,
            responseFormat: $options['response_format'] ?? 'b64_json',
            user: $options['user'] ?? null,
            background: $options['background'] ?? null,
        );
    }
} 