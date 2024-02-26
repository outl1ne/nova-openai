<?php

namespace Outl1ne\NovaOpenAI\Pricing;

class Pricing
{
    public function __construct(public readonly ?object $pricing = null)
    {
        //
    }

    public function models(): ModelPricing
    {
        return new ModelPricing($this);
    }

    public function embedding(): EmbeddingPricing
    {
        return new EmbeddingPricing($this);
    }
}
