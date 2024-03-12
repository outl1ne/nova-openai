<?php

namespace Outl1ne\NovaOpenAI\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Outl1ne\NovaOpenAI\Models\OpenAIRequest;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OpenAIRequest>
 */
class OpenAIRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = OpenAIRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'method' => null,
            'status' => 'success',
            'cost' => null,
            'time_sec' => null,
            'model_requested' => null,
            'model_used' => null,
            'input' => null,
            'output' => null,
            'arguments' => null,
            'meta' => null,
            'usage_prompt_tokens' => null,
            'usage_completion_tokens' => null,
            'usage_total_tokens' => null,
            'error' => null,
            'created_at' => null,
            'updated_at' => null,
        ];
    }
}
