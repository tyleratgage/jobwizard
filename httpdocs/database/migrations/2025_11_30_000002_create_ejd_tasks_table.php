<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates the ejd_tasks table for storing job tasks with physical demand frequencies.
     * Migrated from legacy 'task' table.
     *
     * Physical demand columns use 0-4 scale:
     * 0 = Never (not at all)
     * 1 = Seldom (1-10% of the time)
     * 2 = Occasional (11-33% of the time)
     * 3 = Frequent (34-66% of the time)
     * 4 = Constant (67-100% of the time)
     */
    public function up(): void
    {
        Schema::create('ejd_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique()->comment('Task code (e.g., mkc, anp)');
            $table->string('name', 255)->comment('Task description');
            $table->text('equipment')->nullable()->comment('Equipment/tools used for this task');
            $table->unsignedInteger('sort_order')->default(0)->comment('Display sequence');

            // Physical demand frequency columns (0-4 scale)
            $table->unsignedTinyInteger('sitting')->default(0);
            $table->unsignedTinyInteger('standing')->default(0);
            $table->unsignedTinyInteger('walking')->default(0);
            $table->unsignedTinyInteger('foot_driving')->default(0);
            $table->unsignedTinyInteger('lifting')->default(0);
            $table->unsignedTinyInteger('carrying')->default(0);
            $table->unsignedTinyInteger('pushing_pulling')->default(0);
            $table->unsignedTinyInteger('climbing')->default(0);
            $table->unsignedTinyInteger('bending')->default(0);
            $table->unsignedTinyInteger('twisting')->default(0);
            $table->unsignedTinyInteger('kneeling')->default(0);
            $table->unsignedTinyInteger('crouching')->default(0);
            $table->unsignedTinyInteger('crawling')->default(0);
            $table->unsignedTinyInteger('squatting')->default(0);
            $table->unsignedTinyInteger('reaching_overhead')->default(0);
            $table->unsignedTinyInteger('reaching_outward')->default(0);
            $table->unsignedTinyInteger('repetitive_motions')->default(0);
            $table->unsignedTinyInteger('handling')->default(0);
            $table->unsignedTinyInteger('fine_manipulation')->default(0);
            $table->unsignedTinyInteger('talk_hear_see')->default(0);
            $table->unsignedTinyInteger('vibratory')->default(0);
            $table->unsignedTinyInteger('other')->default(0);

            $table->timestamps();

            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ejd_tasks');
    }
};
