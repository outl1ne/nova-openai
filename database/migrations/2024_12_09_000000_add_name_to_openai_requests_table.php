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
      Schema::table('openai_requests', function (Blueprint $table) {
         $table->string('name')->nullable();
      });

      Schema::table('openai_requests', function (Blueprint $table) {
         $table->index('name');
      });
   }

   /**
    * Reverse the migrations.
    */
   public function down(): void
   {
      Schema::table('openai_requests', function (Blueprint $table) {
         $table->dropIndex(['name']);
         $table->dropColumn('name');
      });
   }
};
