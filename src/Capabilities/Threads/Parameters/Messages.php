<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads\Parameters;

class Messages
{
    public array $messages = [];

    public function user(string $content, ?array $fileIds = null, ?array $metadata = null): self
    {
        $message = [
            'role' => 'user',
            'content' => $content,
        ];

        $message = $this->addOptionalProperty($message, 'file_ids', $fileIds);
        $message = $this->addOptionalProperty($message, 'metadata', $metadata);

        $this->messages[] = $message;

        return $this;
    }

    protected function addOptionalProperty(array $message, string $name, ?string $value): array
    {
        if ($value !== null) {
            $message[$name] = $value;
        }

        return $message;
    }
}
