<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Responses\Responses;

use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;

class ResponsesResponse extends Response
{
    public string $id;

    public array $output;

    public string $status;

    public ?string $outputText;

    public ?array $reasoning;

    public ?array $incompleteDetails;

    public ?string $instructions;

    public ?string $previousResponseId;

    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);

        $this->id = $this->data['id'];
        $this->model = $this->data['model'];
        $this->output = $this->data['output'];
        $this->status = $this->data['status'];
        $this->outputText = $this->data['output_text'] ?? null;
        $this->reasoning = $this->data['reasoning'] ?? null;
        $this->incompleteDetails = $this->data['incomplete_details'] ?? null;
        $this->instructions = $this->data['instructions'] ?? null;
        $this->previousResponseId = $this->data['previous_response_id'] ?? null;

        $this->appendMeta('created_at', $this->data['created_at']);
        $this->appendMeta('object', $this->data['object']);
        $this->appendMeta('temperature', $this->data['temperature'] ?? null);
        $this->appendMeta('top_p', $this->data['top_p'] ?? null);
        $this->appendMeta('max_output_tokens', $this->data['max_output_tokens'] ?? null);
        $this->appendMeta('parallel_tool_calls', $this->data['parallel_tool_calls'] ?? null);
        $this->appendMeta('tool_choice', $this->data['tool_choice'] ?? null);
        $this->appendMeta('tools', $this->data['tools'] ?? null);
        $this->appendMeta('text', $this->data['text'] ?? null);
        $this->appendMeta('truncation', $this->data['truncation'] ?? null);
        $this->appendMeta('user', $this->data['user'] ?? null);
        $this->appendMeta('metadata', $this->data['metadata'] ?? null);
        $this->appendMeta('error', $this->data['error'] ?? null);

        if (isset($this->data['usage'])) {
            $this->usage = $this->createUsage(
                $this->data['usage']['input_tokens'] ?? null,
                $this->data['usage']['output_tokens'] ?? null,
                $this->data['usage']['total_tokens'] ?? null
            );
        }
    }
}
