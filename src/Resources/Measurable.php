<?php

namespace Outl1ne\NovaOpenAI\Resources;

use Outl1ne\NovaOpenAI\Http;

trait Measurable
{
    protected $measureStart;

    protected function startMeasuring()
    {
        $this->measureStart = microtime(true);
    }

    protected function measure(): float
    {
        return microtime(true) - $this->measureStart;
    }
}
