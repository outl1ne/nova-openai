<?php

namespace Outl1ne\NovaOpenAI\Nova;

use Laravel\Nova\Nova;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaOpenAI\Models\OpenAIRequest;

class CostMetrics extends Trend
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $result = $this->sumByDays($request, OpenAIRequest::class, 'cost');

        // Iterate over each day to format with 2 decimal places
        $formattedTrend = collect($result->trend)->map(function ($value) {
            return number_format($value, 2, '.', '');
        });

        // Sum the formatted values
        $sum = $formattedTrend->sum();

        return $result->trend($formattedTrend->toArray())
            ->result($sum)
            ->format([
                'mantissa' => 2, // Ensure the result is formatted with 2 decimal places
            ])->prefix('$');
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            30 => Nova::__('30 Days'),
            60 => Nova::__('60 Days'),
            90 => Nova::__('90 Days'),
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        return now()->addMinutes(1);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'cost-metrics';
    }
}
