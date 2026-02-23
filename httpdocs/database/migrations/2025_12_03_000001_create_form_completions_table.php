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
        Schema::create('form_completions', function (Blueprint $table) {
            $table->id();
            $table->string('form_type', 50); // 'ejd' or 'offer-letter'
            $table->string('language', 20)->default('english');
            $table->timestamp('created_at');

            $table->index(['form_type', 'language']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_completions');
    }
};
