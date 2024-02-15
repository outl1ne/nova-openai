<?php

namespace Outl1ne\NovaOpenAI\Capabilities;

trait Measurable
{
    protected $measureStart = null;

    /**
     * Measures time passed from initial measure() call and returns
     * time pass in seconds.
     *
     * @return float|null
     */
    protected function measure(): float|null
    {
        $measuringStarted = !!$this->measureStart;

        if ($this->measureStart === null) {
            $this->measureStart = microtime(true);
        }

        if (!$measuringStarted) {
            return null;
        }

        return microtime(true) - $this->measureStart;
    }

    protected function clearMeasure(): void
    {
        $this->measureStart = null;
    }
}
