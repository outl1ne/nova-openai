<?php

namespace Outl1ne\NovaOpenAI\Pricing;

abstract class Calculator
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

    abstract public function calculate(int $inputTokens, int $outputTokens = null): ?float;
}
