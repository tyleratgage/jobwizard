<?php

use App\Enums\JobLocation;

test('job location has correct values', function () {
    expect(JobLocation::OFFICE->value)->toBe('office');
    expect(JobLocation::YARD->value)->toBe('yard');
    expect(JobLocation::JOB->value)->toBe('job');
});

test('job location has labels', function () {
    expect(JobLocation::OFFICE->label())->toBe('Office');
    expect(JobLocation::YARD->label())->toBe('Yard');
    expect(JobLocation::JOB->label())->toBe('Job Site');
});

test('job location can generate options array', function () {
    $options = JobLocation::options();

    expect($options)->toBeArray();
    expect($options)->toHaveCount(3);
    expect($options['office'])->toBe('Office');
    expect($options['yard'])->toBe('Yard');
    expect($options['job'])->toBe('Job Site');
});

test('job location can be created from string', function () {
    $location = JobLocation::from('yard');

    expect($location)->toBe(JobLocation::YARD);
});
