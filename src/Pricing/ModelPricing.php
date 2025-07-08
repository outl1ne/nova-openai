<?php

namespace Outl1ne\NovaOpenAI\Pricing;

class ModelPricing extends Calculator
{
    protected array $modelMap = [
        'gpt-3.5-turbo' => 'gpt-3.5-turbo-0125',
        'gpt-4-turbo-preview' => 'gpt-4-0125-preview',
        'gpt-4o-2024-08-06' => 'gpt-4o',
        'gpt-4o-mini-2024-07-18' => 'gpt-4o-mini',
        'o4-mini-2025-04-16' => 'o4-mini',
        'gpt-4.1-mini-2025-04-14' => 'gpt-4.1-mini',
        'gpt-4.1-2025-04-14' => 'gpt-4.1',
        'o3-2025-04-16' => 'o3',
    ];

    public function calculate(int $inputTokens, int $outputTokens = null): ?float
    {
        if (!$this->basePricing->pricing) return null;

        $model = $this->modelMap[$this->model] ?? $this->model;
        $pricing = $this->basePricing->pricing->models->{$model} ?? null;

        if ($pricing === null) return null;
        return $this->basePricing->pricing->models->{$model}->input * $inputTokens / 1_000_000
            + $this->basePricing->pricing->models->{$model}->output * $outputTokens / 1_000_000;
    }
}
