<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Chat\Parameters;

class Messages
{
    public array $messages = [];

    public function system(string|array $content, ?string $name = null): self
    {
        $message = [
            'role' => 'system',
            'content' => $content,
        ];

        $message = $this->addOptionalProperty($message, 'name', $name);

        $this->messages[] = $message;

        return $this;
    }

    public function user(string|array $content, ?string $name = null): self
    {
        $message = [
            'role' => 'user',
            'content' => $content,
        ];

        $message = $this->addOptionalProperty($message, 'name', $name);

        $this->messages[] = $message;

        return $this;
    }

    public function assistant(string|array|null $content = null, ?string $name = null, ?array $toolCalls = null): self
    {
        $message = [
            'role' => 'assistant',
        ];

        $message = $this->addOptionalProperty($message, 'content', $content);
        $message = $this->addOptionalProperty($message, 'name', $name);
        $message = $this->addOptionalProperty($message, 'tool_calls', $toolCalls);

        $this->messages[] = $message;

        return $this;
    }

    public function tool(string|array $content, string $toolCallId): self
    {
        $message = [
            'role' => 'system',
            'content' => $content,
            'tool_call_id' => $toolCallId,
        ];

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
