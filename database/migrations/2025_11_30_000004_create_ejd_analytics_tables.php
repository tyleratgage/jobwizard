<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates analytics tracking tables for form submissions and selection statistics.
     */
    public function up(): void
    {
        // EJD form submissions (for record keeping)
        Schema::create('ejd_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 255)->nullable()->index();
            $table->foreignId('job_id')->nullable()->constrained('ejd_jobs')->nullOnDelete();
            $table->json('form_data')->comment('Complete form submission data');
            $table->timestamps();

            $table->index('created_at');
        });

        // Offer letter submissions (for record keeping)
        Schema::create('ejd_offer_letter_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 255)->nullable()->index();
            $table->string('template_type', 50)->comment('permanent or temporary');
            $table->string('language', 10)->comment('en, es, or ru');
            $table->json('form_data')->comment('Complete form submission data');
            $table->timestamps();

            $table->index('created_at');
        });

        // Job selection analytics
        Schema::create('ejd_job_selections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('ejd_jobs')->cascadeOnDelete();
            $table->timestamp('selected_at')->useCurrent();

            $table->index('job_id');
            $table->index('selected_at');
        });

        // Task selection analytics
        Schema::create('ejd_task_selections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('ejd_tasks')->cascadeOnDelete();
            $table->foreignId('job_id')->nullable()->constrained('ejd_jobs')->nullOnDelete();
            $table->timestamp('selected_at')->useCurrent();

            $table->index('task_id');
            $table->index('job_id');
            $table->index('selected_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ejd_task_selections');
        Schema::dropIfExists('ejd_job_selections');
        Schema::dropIfExists('ejd_offer_letter_submissions');
        Schema::dropIfExists('ejd_submissions');
    }
};
