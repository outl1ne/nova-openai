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
            $table->jsonb('meta')->nullable();
            $table->unsignedBigInteger('usage_prompt_tokens')->nullable();
            $table->unsignedBigInteger('usage_completion_tokens')->nullable();
            $table->unsignedBigInteger('usage_total_tokens')->nullable();
            $table->string('error')->nullable();

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
