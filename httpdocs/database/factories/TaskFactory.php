<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $counter = 0;
        $counter++;

        return [
            'code' => 't'.str_pad((string) $counter, 2, '0', STR_PAD_LEFT),
            'name' => 'Test Task '.$counter,
            'equipment' => rand(0, 1) ? 'Test equipment' : null,
            'sort_order' => rand(10, 1000),
            'sitting' => rand(0, 4),
            'standing' => rand(0, 4),
            'walking' => rand(0, 4),
            'foot_driving' => rand(0, 4),
            'lifting' => rand(0, 4),
            'carrying' => rand(0, 4),
            'pushing_pulling' => rand(0, 4),
            'climbing' => rand(0, 4),
            'bending' => rand(0, 4),
            'twisting' => rand(0, 4),
            'kneeling' => rand(0, 4),
            'crouching' => rand(0, 4),
            'crawling' => rand(0, 4),
            'squatting' => rand(0, 4),
            'reaching_overhead' => rand(0, 4),
            'reaching_outward' => rand(0, 4),
            'repetitive_motions' => rand(0, 4),
            'handling' => rand(0, 4),
            'fine_manipulation' => rand(0, 4),
            'talk_hear_see' => rand(0, 4),
            'vibratory' => rand(0, 4),
            'other' => rand(0, 4),
        ];
    }

    /**
     * Create a task with all physical demands set to zero.
     */
    public function sedentary(): static
    {
        return $this->state(fn (array $attributes) => [
            'sitting' => 4,
            'standing' => 0,
            'walking' => 0,
            'lifting' => 0,
            'carrying' => 0,
        ]);
    }

    /**
     * Create a task with high physical demands.
     */
    public function physical(): static
    {
        return $this->state(fn (array $attributes) => [
            'sitting' => 1,
            'standing' => 4,
            'walking' => 3,
            'lifting' => 4,
            'carrying' => 3,
            'pushing_pulling' => 3,
        ]);
    }
}
