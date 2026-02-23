<?php

use App\Enums\JobLocation;
use App\Models\Job;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('job location is cast to enum', function () {
    $job = Job::factory()->create(['location' => 'office']);

    expect($job->location)->toBeInstanceOf(JobLocation::class);
    expect($job->location)->toBe(JobLocation::OFFICE);
});

test('job has many tasks through pivot', function () {
    $job = Job::factory()->create();
    $tasks = Task::factory()->count(3)->create();

    $job->tasks()->attach($tasks);

    expect($job->tasks)->toHaveCount(3);
    expect($job->tasks->first())->toBeInstanceOf(Task::class);
});

test('job can be scoped by location', function () {
    Job::factory()->create(['location' => 'office']);
    Job::factory()->create(['location' => 'yard']);
    Job::factory()->create(['location' => 'job']);

    $officeJobs = Job::atLocation(JobLocation::OFFICE)->get();

    expect($officeJobs)->toHaveCount(1);
    expect($officeJobs->first()->location)->toBe(JobLocation::OFFICE);
});

test('job can be ordered by sort_order', function () {
    Job::factory()->create(['sort_order' => 30]);
    Job::factory()->create(['sort_order' => 10]);
    Job::factory()->create(['sort_order' => 20]);

    $orderedJobs = Job::ordered()->pluck('sort_order')->toArray();

    expect($orderedJobs)->toBe([10, 20, 30]);
});

test('job display name includes code and name', function () {
    $job = Job::factory()->create([
        'code' => 'oc1',
        'name' => 'Test Job',
    ]);

    expect($job->displayName)->toBe('oc1 - Test Job');
});
