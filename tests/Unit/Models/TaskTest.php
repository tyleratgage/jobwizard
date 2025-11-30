<?php

use App\Models\Task;

test('task has correct table name', function () {
    $task = new Task;
    expect($task->getTable())->toBe('ejd_tasks');
});

test('task has physical demand constants', function () {
    expect(Task::PHYSICAL_DEMANDS)->toBeArray();
    expect(Task::PHYSICAL_DEMANDS)->toContain('sitting');
    expect(Task::PHYSICAL_DEMANDS)->toContain('standing');
    expect(Task::PHYSICAL_DEMANDS)->toContain('lifting');
    expect(Task::PHYSICAL_DEMANDS)->toHaveCount(22);
});

test('task has physical demand labels', function () {
    expect(Task::PHYSICAL_DEMAND_LABELS)->toBeArray();
    expect(Task::getPhysicalDemandLabel('sitting'))->toBe('Sitting');
    expect(Task::getPhysicalDemandLabel('pushing_pulling'))->toBe('Pushing/Pulling');
    expect(Task::getPhysicalDemandLabel('talk_hear_see'))->toBe('Talk/Hear/See');
});
