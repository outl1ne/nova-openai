<?php

namespace Outl1ne\NovaOpenAI\Nova\Filters;

use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaOpenAI\Models\OpenAIRequest;

class RequestStatusFilter extends Filter
{
   public function apply(NovaRequest $request, $query, $value)
   {
      return $query->where('status', $value);
   }

   public function options(NovaRequest $request)
   {
      return OpenAIRequest::select('status')
         ->distinct()
         ->whereNotNull('status')
         ->get()
         ->pluck('status', 'status')
         ->toArray();
   }
}
