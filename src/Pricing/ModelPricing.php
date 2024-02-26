<?php

namespace Outl1ne\NovaOpenAI\Pricing;

class ModelPricing
{
    protected string $model;

    public function __construct(protected readonly Pricing $basePricing)
    {
        //
    }

    public function model(string $model): self
    {
        $this->model = $model;
        return $this;
    }

    public function calculate(int $inputTokens, int $outputTokens)
    {
        if (!$this->basePricing->pricing) return null;

        return $this->basePricing->pricing->models->{$this->model}->input * $inputTokens / 1000
            + $this->basePricing->pricing->models->{$this->model}->output * $outputTokens / 1000;
    }
}
