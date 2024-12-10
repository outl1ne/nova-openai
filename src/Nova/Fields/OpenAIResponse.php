<?php

namespace Outl1ne\NovaOpenAI\Nova\Fields;

use Laravel\Nova\Fields\Field;

class OpenAIResponse extends Field
{
   /**
    * The field's component.
    *
    * @var string
    */
   public $component = 'openai-response-field';

   /**
    * Format the field's value for display.
    *
    * @param  mixed  $value
    * @return string
    */
   protected function formatContent($value)
   {
      if (empty($value)) return 'No content available';

      try {
         // in case of raw input
         if (!is_array($value)) {
            if (is_string($value) && (str_starts_with(trim($value), '{') || str_starts_with(trim($value), '['))) {
               $value = json_decode($value, true);
            }
         }

         // input format
         if (isset($value[0]['role']) && isset($value[0]['content'])) {
            return collect($value)->map(function ($msg) {
               return sprintf(
                  '<div class="message">
                      <div class="role">%s</div>
                      <div class="content">%s</div>
                  </div>',
                  ucfirst($msg['role']),
                  nl2br(htmlspecialchars($msg['content']))
               );
            })->join("\n");
         }

         // output format
         if (isset($value[0]['message']['content'])) {
            return collect($value)->map(function ($item) {
               $content = $item['message']['content'];
               // pretty print if it's JSON
               if (str_starts_with(trim($content), '{')) {
                  try {
                     $decoded = json_decode($content, true);
                     return sprintf(
                        '<pre>%s</pre>',
                        json_encode($decoded, JSON_PRETTY_PRINT)
                     );
                  } catch (\Throwable $e) {
                     return nl2br(htmlspecialchars($content));
                  }
               }
               return nl2br(htmlspecialchars($content));
            })->join("\n<hr>\n");
         }

         // default to json
         return sprintf(
            '<pre>%s</pre>',
            json_encode($value, JSON_PRETTY_PRINT)
         );
      } catch (\Throwable $e) {
         return "Error parsing content: " . $e->getMessage();
      }
   }

   // fetch from meta and resolve for display
   public function resolveForDisplay($resource, $attribute = null)
   {
      $attribute = $attribute ?? $this->meta['attribute'] ?? $this->attribute;
      $value = $resource->{$attribute};

      return $this->withMeta([
         'displayValue' => $this->formatContent($value)
      ]);
   }
}
