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
        Schema::create('form_presets', function (Blueprint $table) {
            $table->id();
            $table->string('token', 8)->unique();
            $table->string('type', 50); // 'ejd' or 'offer-letter'
            $table->json('data');
            $table->timestamps();

            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_presets');
    }
};
