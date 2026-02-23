<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates the ejd_jobs table for storing job titles/positions.
     * Migrated from legacy 'job' table.
     */
    public function up(): void
    {
        Schema::create('ejd_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique()->comment('Job code (e.g., oc1, yb1, jf1)');
            $table->string('name', 255)->comment('Full job title');
            $table->string('location', 20)->comment('Work location: office, yard, or job');
            $table->unsignedInteger('sort_order')->default(0)->comment('Display sequence');
            $table->timestamps();

            $table->index('location');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ejd_jobs');
    }
};
