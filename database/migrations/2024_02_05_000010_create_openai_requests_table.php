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
            $table->unsignedDecimal('time', 10, 4)->nullable()->index();
            $table->string('model_requested')->nullable()->index();
            $table->string('model_used')->nullable()->index();
            $table->json('input')->nullable();
            $table->json('output')->nullable();
            $table->string('response_id')->nullable()->index();
            $table->string('response_object')->nullable()->index();
            $table->unsignedBigInteger('response_created')->nullable()->index();
            $table->string('response_system_fingerprint')->nullable();
            $table->unsignedBigInteger('usage_prompt_tokens')->nullable()->index();
            $table->unsignedBigInteger('usage_completion_tokens')->nullable()->index();
            $table->unsignedBigInteger('usage_total_tokens')->nullable()->index();
            $table->string('voice')->nullable()->index();
            $table->string('response_format')->nullable()->index();
            $table->string('media_speed')->nullable()->index();
            $table->string('language')->nullable()->index();
            $table->decimal('temperature', 11, 10)->nullable()->index();
            $table->string('error')->nullable()->index();

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
