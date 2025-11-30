<?php

namespace Database\Factories;

use App\Enums\JobLocation;
use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    protected $model = Job::class;

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
            'code' => 'j'.str_pad((string) $counter, 2, '0', STR_PAD_LEFT),
            'name' => 'Test Job '.$counter,
            'location' => JobLocation::cases()[array_rand(JobLocation::cases())],
            'sort_order' => rand(10, 1000),
        ];
    }

    /**
     * Create a job at the office location.
     */
    public function office(): static
    {
        return $this->state(fn (array $attributes) => [
            'location' => JobLocation::OFFICE,
        ]);
    }

    /**
     * Create a job at the yard location.
     */
    public function yard(): static
    {
        return $this->state(fn (array $attributes) => [
            'location' => JobLocation::YARD,
        ]);
    }

    /**
     * Create a job at a job site.
     */
    public function jobSite(): static
    {
        return $this->state(fn (array $attributes) => [
            'location' => JobLocation::JOB,
        ]);
    }
}
