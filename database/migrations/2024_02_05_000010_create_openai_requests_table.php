<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('openai_requests', function (Blueprint $table) {
            $table->id();

            $table->enum('method', ['completions', 'chat', 'embeddings', 'audio', 'edits', 'files', 'models', 'fineTuning', 'fineTunes', 'moderations', 'images', 'assistants', 'threads'])->nullable()->index();
            $table->enum('status', ['pending', 'success', 'error'])->index();
            $table->unsignedDecimal('time', 10, 4)->nullable();
            $table->string('model_requested')->nullable();
            $table->string('model_used')->nullable();
            $table->jsonb('input')->nullable();
            $table->jsonb('output')->nullable();
            $table->string('response_id')->nullable();
            $table->string('response_object')->nullable();
            $table->unsignedBigInteger('response_created')->nullable();
            $table->string('response_system_fingerprint')->nullable();
            $table->unsignedBigInteger('usage_prompt_tokens')->nullable();
            $table->unsignedBigInteger('usage_completion_tokens')->nullable();
            $table->unsignedBigInteger('usage_total_tokens')->nullable();
            $table->string('voice')->nullable();
            $table->string('response_format')->nullable();
            $table->string('media_speed')->nullable();
            $table->string('language')->nullable();
            $table->decimal('temperature', 11, 10)->nullable();
            $table->string('error')->nullable();
            $table->unsignedBigInteger('ratelimit_limit_requests')->nullable();
            $table->unsignedBigInteger('ratelimit_limit_tokens')->nullable();
            $table->unsignedBigInteger('ratelimit_remaining_requests')->nullable();
            $table->unsignedBigInteger('ratelimit_remaining_tokens')->nullable();
            $table->string('ratelimit_reset_requests')->nullable();
            $table->string('ratelimit_reset_tokens')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('openai_requests');
    }
};
