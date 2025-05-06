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
}
