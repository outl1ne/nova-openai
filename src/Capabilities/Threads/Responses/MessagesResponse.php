<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads\Responses;

use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;

class MessagesResponse extends Response
{
    public array $messages;

    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);

        $this->appendMeta('object', $this->data['object']);
        $this->appendMeta('first_id', $this->data['first_id']);
        $this->appendMeta('last_id', $this->data['last_id']);
        $this->appendMeta('has_more', $this->data['has_more']);
        $this->messages = $this->data['data'];
    }

    public function json(): ?object
    {
        return json_decode($this->messages[0]['content'][0]['text']['value']);
    }

    public function thread(): ?array
    {
        return collect($this->messages)->map(function ($message) {
            $messageValue = $message['content'][0]['text']['value'];
            return [
                'role' => $message['role'],
                'message' => json_validate($messageValue) ? json_decode($messageValue) : $messageValue,
            ];
        })->toArray();
    }
}
