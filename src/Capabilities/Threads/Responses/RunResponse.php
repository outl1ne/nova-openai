<?php

namespace Outl1ne\NovaOpenAI\Capabilities\Threads\Responses;

use Outl1ne\NovaOpenAI\Facades\OpenAI;
use Outl1ne\NovaOpenAI\Capabilities\Responses\Response;
use Outl1ne\NovaOpenAI\Exceptions\ThreadRunStatusFailedException;

class RunResponse extends Response
{
    public string $id;
    public string $status;

    public function __construct(...$arguments)
    {
        parent::__construct(...$arguments);

        $this->id = $this->data['id'];
        $this->model = $this->data['model'];
        $this->status = $this->data['status'];
        $this->appendMeta('id', $this->data['id']);
        $this->appendMeta('object', $this->data['object']);
        $this->appendMeta('created_at', $this->data['created_at']);
        $this->appendMeta('assistant_id', $this->data['assistant_id']);
        $this->appendMeta('thread_id', $this->data['thread_id']);
        $this->appendMeta('status', $this->data['status']);
        $this->appendMeta('started_at', $this->data['started_at']);
        $this->appendMeta('expires_at', $this->data['expires_at']);
        $this->appendMeta('cancelled_at', $this->data['cancelled_at']);
        $this->appendMeta('failed_at', $this->data['failed_at']);
        $this->appendMeta('completed_at', $this->data['completed_at']);
        $this->appendMeta('last_error', $this->data['last_error']);
        $this->appendMeta('model', $this->data['model']);
        $this->appendMeta('instructions', $this->data['instructions']);
        $this->appendMeta('tools', $this->data['tools']);
        $this->appendMeta('metadata', $this->data['metadata']);
        $this->appendMeta('incomplete_details', $this->data['incomplete_details']);
        $this->appendMeta('temperature', $this->data['temperature']);
        $this->appendMeta('top_p', $this->data['top_p']);
        $this->appendMeta('truncation_strategy', $this->data['truncation_strategy']);
        $this->appendMeta('response_format', $this->data['response_format']);
        $this->appendMeta('tool_choice', $this->data['tool_choice']);
        $this->appendMeta('parallel_tool_calls', $this->data['parallel_tool_calls']);
        $this->appendMeta('required_action', $this->data['required_action']);
    }

    public function wait(?callable $errorCallback = null): RunResponse
    {
        $status = null;
        while ($status !== 'completed') {
            $runStatus = OpenAI::threads()->run()->retrieve($this->data['thread_id'], $this->data['id']);
            if ($runStatus->status === 'failed') {
                if (is_callable($errorCallback)) {
                    $errorCallback();
                } else {
                    throw new ThreadRunStatusFailedException;
                }
            } else if ($runStatus->status === 'completed') {
                $status = 'completed';
            }
            // sleep for 100ms
            usleep(100_000);
        }
        return $runStatus;
    }
}
