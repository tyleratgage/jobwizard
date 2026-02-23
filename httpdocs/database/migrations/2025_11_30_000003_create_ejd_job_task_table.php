<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates the pivot table for the many-to-many relationship between jobs and tasks.
     * Replaces the legacy serialized PHP array in task.t_jobs column.
     */
    public function up(): void
    {
        Schema::create('ejd_job_task', function (Blueprint $table) {
            $table->foreignId('job_id')->constrained('ejd_jobs')->cascadeOnDelete();
            $table->foreignId('task_id')->constrained('ejd_tasks')->cascadeOnDelete();

            $table->primary(['job_id', 'task_id']);
            $table->index('job_id');
            $table->index('task_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ejd_job_task');
    }
};
