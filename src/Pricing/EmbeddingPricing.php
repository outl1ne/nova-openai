<?php

namespace Outl1ne\NovaOpenAI\Pricing;

class EmbeddingPricing
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

    public function calculate(int $inputTokens)
    {
        if (!$this->basePricing->pricing) return null;
        return $this->basePricing->pricing->embedding->{$this->model} * $inputTokens / 1000;
    }
}
