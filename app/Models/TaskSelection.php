<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Task selection analytics model.
 *
 * @property int $id
 * @property int $task_id
 * @property int|null $job_id
 * @property \Illuminate\Support\Carbon $selected_at
 * @property-read Task $task
 * @property-read Job|null $job
 */
class TaskSelection extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'ejd_task_selections';

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'task_id',
        'job_id',
        'selected_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'selected_at' => 'datetime',
        ];
    }

    /**
     * The task that was selected.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    /**
     * The job context for this task selection.
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    /**
     * Record a task selection.
     */
    public static function record(Task|int $task, Job|int|null $job = null): self
    {
        $taskId = $task instanceof Task ? $task->id : $task;
        $jobId = $job instanceof Job ? $job->id : $job;

        return self::create([
            'task_id' => $taskId,
            'job_id' => $jobId,
            'selected_at' => now(),
        ]);
    }
}
