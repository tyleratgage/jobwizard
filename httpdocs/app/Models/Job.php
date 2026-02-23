<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\JobLocation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Job title/position model.
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property JobLocation $location
 * @property int $sort_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Task> $tasks
 */
class Job extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'ejd_jobs';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'code',
        'name',
        'location',
        'sort_order',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'location' => JobLocation::class,
            'sort_order' => 'integer',
        ];
    }

    /**
     * The tasks that can be performed in this job.
     */
    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'ejd_job_task', 'job_id', 'task_id');
    }

    /**
     * Job selections for analytics.
     */
    public function selections(): HasMany
    {
        return $this->hasMany(JobSelection::class, 'job_id');
    }

    /**
     * EJD form submissions for this job.
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(EjdSubmission::class, 'job_id');
    }

    /**
     * Scope a query to only include jobs at a specific location.
     */
    public function scopeAtLocation($query, JobLocation $location)
    {
        return $query->where('location', $location);
    }

    /**
     * Scope a query to order by sort_order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Get the display name with code.
     */
    public function getDisplayNameAttribute(): string
    {
        return "{$this->code} - {$this->name}";
    }
}
