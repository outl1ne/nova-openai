<?php

namespace Outl1ne\NovaOpenAI\Capabilities;

use Exception;
use Outl1ne\NovaOpenAI\OpenAI;
use Outl1ne\NovaOpenAI\Models\OpenAIRequest;

class CapabilityClient
{
    use Measurable;

    public readonly OpenAI $openAI;
    protected OpenAIRequest $request;
    protected string $method;

    public function __construct(
        public readonly Capability $capability,
    ) {
        $this->openAI = $capability->openAI;
        $this->request = new OpenAIRequest;
        $this->request->method = $this->method;
        $this->request->arguments = [];
    }

    public function pending()
    {
        $this->measure();

        $this->request->status = 'pending';
        if (($this->capability->shouldStoreCallback)() && ($this->capability->shouldStorePendingCallback)()) {
            $this->request->save();
        }

        return $this->request;
    }

    public function store($response = null)
    {
        if (($this->capability->shouldStoreCallback)($response)) {
            $this->request->save();
        }
    }

    public function handleException(Exception $e)
    {
        $this->request->time_sec = $this->measure();
        $this->request->status = 'error';
        $this->request->error = $e->getMessage();
        if (($this->capability->shouldStoreCallback)() && ($this->capability->shouldStoreErrorsCallback)($e)) {
            $this->request->save();
        }

        throw $e;
    }
}
