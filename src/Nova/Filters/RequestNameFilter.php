<?php

namespace Outl1ne\NovaOpenAI\Nova\Filters;

use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaOpenAI\Models\OpenAIRequest;

class RequestNameFilter extends Filter
{
   public function apply(NovaRequest $request, $query, $value)
   {
      return $query->where('name', $value);
   }

   public function options(NovaRequest $request)
   {
      return OpenAIRequest::select('name')
         ->distinct()
         ->whereNotNull('name')
         ->get()
         ->pluck('name', 'name')
         ->toArray();
   }
}
