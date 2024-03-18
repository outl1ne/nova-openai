<?php

namespace Outl1ne\NovaOpenAI\Pricing;

class ModelPricing
{
    protected string $model;

    protected array $modelMap = [
        'gpt-3.5-turbo' => 'gpt-3.5-turbo-0125',
    ];

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

        $model = $this->modelMap[$this->model] ?? $this->model;
        return $this->basePricing->pricing->models->{$model}->input * $inputTokens / 1000
            + $this->basePricing->pricing->models->{$model}->output * $outputTokens / 1000;
    }
}
