<?php

use App\Models\Job;

test('job has correct table name', function () {
    $job = new Job;
    expect($job->getTable())->toBe('ejd_jobs');
});
