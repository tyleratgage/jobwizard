<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Job selection analytics model.
 *
 * @property int $id
 * @property int $job_id
 * @property \Illuminate\Support\Carbon $selected_at
 * @property-read Job $job
 */
class JobSelection extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'ejd_job_selections';

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
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
     * The job that was selected.
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    /**
     * Record a job selection.
     */
    public static function record(Job|int $job): self
    {
        $jobId = $job instanceof Job ? $job->id : $job;

        return self::create([
            'job_id' => $jobId,
            'selected_at' => now(),
        ]);
    }
}
