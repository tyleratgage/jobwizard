<?php

use App\Enums\PhysicalDemandFrequency;
use App\Models\Job;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('task belongs to many jobs', function () {
    $task = Task::factory()->create();
    $jobs = Job::factory()->count(2)->create();

    $task->jobs()->attach($jobs);

    expect($task->jobs)->toHaveCount(2);
    expect($task->jobs->first())->toBeInstanceOf(Job::class);
});

test('task can be ordered by sort_order', function () {
    Task::factory()->create(['sort_order' => 30]);
    Task::factory()->create(['sort_order' => 10]);
    Task::factory()->create(['sort_order' => 20]);

    $orderedTasks = Task::ordered()->pluck('sort_order')->toArray();

    expect($orderedTasks)->toBe([10, 20, 30]);
});

test('task can be scoped for specific job', function () {
    $job1 = Job::factory()->create();
    $job2 = Job::factory()->create();

    $task1 = Task::factory()->create();
    $task2 = Task::factory()->create();
    $task3 = Task::factory()->create();

    $task1->jobs()->attach($job1);
    $task2->jobs()->attach([$job1->id, $job2->id]);
    $task3->jobs()->attach($job2);

    $job1Tasks = Task::forJob($job1)->get();

    expect($job1Tasks)->toHaveCount(2);
    expect($job1Tasks->pluck('id')->toArray())->toContain($task1->id, $task2->id);
});

test('task returns physical demands as array', function () {
    $task = Task::factory()->create([
        'sitting' => 3,
        'standing' => 2,
        'walking' => 1,
    ]);

    $demands = $task->getPhysicalDemands();

    expect($demands)->toBeArray();
    expect($demands['sitting'])->toBe(3);
    expect($demands['standing'])->toBe(2);
    expect($demands['walking'])->toBe(1);
});

test('task returns physical demands as enums', function () {
    $task = Task::factory()->create([
        'sitting' => 3,
        'standing' => 0,
    ]);

    $frequencies = $task->getPhysicalDemandFrequencies();

    expect($frequencies['sitting'])->toBeInstanceOf(PhysicalDemandFrequency::class);
    expect($frequencies['sitting'])->toBe(PhysicalDemandFrequency::FREQUENT);
    expect($frequencies['standing'])->toBe(PhysicalDemandFrequency::NEVER);
});

test('calculate highest frequencies from multiple tasks', function () {
    $task1 = Task::factory()->create([
        'sitting' => 2,
        'standing' => 3,
        'walking' => 1,
    ]);

    $task2 = Task::factory()->create([
        'sitting' => 4,
        'standing' => 1,
        'walking' => 2,
    ]);

    $tasks = collect([$task1, $task2]);
    $highest = Task::calculateHighestFrequencies($tasks);

    expect($highest['sitting'])->toBe(4);
    expect($highest['standing'])->toBe(3);
    expect($highest['walking'])->toBe(2);
});
