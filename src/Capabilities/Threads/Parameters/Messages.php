<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads\Parameters;

class Messages
{
    public array $messages = [];
    public array $fileIds = [];
    public ?array $metadata = [];

    public function user(string $content, array $fileIds = [], ?array $metadata = null): self
    {
        $message = [
            'role' => 'user',
            'content' => $content,
        ];

        $message['file_ids'] = $fileIds;
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
