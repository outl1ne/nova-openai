<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads\Parameters;

use Outl1ne\NovaOpenAI\Traits\StaticMake;

class Messages
{
    use StaticMake;

    public array $messages = [];

    public function user(string $content, ?array $attachments = null, ?array $metadata = null): self
    {
        $message = [
            'role' => 'user',
            'content' => $content,
        ];

        $message = $this->addOptionalProperty($message, 'attachments', $attachments);
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
