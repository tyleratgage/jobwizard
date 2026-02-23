<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PhysicalDemandFrequency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Task model with physical demand frequencies.
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string|null $equipment
 * @property int $sort_order
 * @property int $sitting
 * @property int $standing
 * @property int $walking
 * @property int $foot_driving
 * @property int $lifting
 * @property int $carrying
 * @property int $pushing_pulling
 * @property int $climbing
 * @property int $bending
 * @property int $twisting
 * @property int $kneeling
 * @property int $crouching
 * @property int $crawling
 * @property int $squatting
 * @property int $reaching_overhead
 * @property int $reaching_outward
 * @property int $repetitive_motions
 * @property int $handling
 * @property int $fine_manipulation
 * @property int $talk_hear_see
 * @property int $vibratory
 * @property int $other
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Job> $jobs
 */
class Task extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'ejd_tasks';

    /**
     * Physical demand column names.
     */
    public const PHYSICAL_DEMANDS = [
        'sitting',
        'standing',
        'walking',
        'foot_driving',
        'lifting',
        'carrying',
        'pushing_pulling',
        'climbing',
        'bending',
        'twisting',
        'kneeling',
        'crouching',
        'crawling',
        'squatting',
        'reaching_overhead',
        'reaching_outward',
        'repetitive_motions',
        'handling',
        'fine_manipulation',
        'talk_hear_see',
        'vibratory',
        'other',
    ];

    /**
     * Human-readable labels for physical demands.
     */
    public const PHYSICAL_DEMAND_LABELS = [
        'sitting' => 'Sitting',
        'standing' => 'Standing',
        'walking' => 'Walking',
        'foot_driving' => 'Foot Driving',
        'lifting' => 'Lifting',
        'carrying' => 'Carrying',
        'pushing_pulling' => 'Pushing/Pulling',
        'climbing' => 'Climbing',
        'bending' => 'Bending',
        'twisting' => 'Twisting',
        'kneeling' => 'Kneeling',
        'crouching' => 'Crouching',
        'crawling' => 'Crawling',
        'squatting' => 'Squatting',
        'reaching_overhead' => 'Reaching Overhead',
        'reaching_outward' => 'Reaching Outward',
        'repetitive_motions' => 'Repetitive Motions',
        'handling' => 'Handling',
        'fine_manipulation' => 'Fine Manipulation',
        'talk_hear_see' => 'Talk/Hear/See',
        'vibratory' => 'Vibratory',
        'other' => 'Other',
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'code',
        'name',
        'equipment',
        'sort_order',
        'sitting',
        'standing',
        'walking',
        'foot_driving',
        'lifting',
        'carrying',
        'pushing_pulling',
        'climbing',
        'bending',
        'twisting',
        'kneeling',
        'crouching',
        'crawling',
        'squatting',
        'reaching_overhead',
        'reaching_outward',
        'repetitive_motions',
        'handling',
        'fine_manipulation',
        'talk_hear_see',
        'vibratory',
        'other',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'sitting' => 'integer',
            'standing' => 'integer',
            'walking' => 'integer',
            'foot_driving' => 'integer',
            'lifting' => 'integer',
            'carrying' => 'integer',
            'pushing_pulling' => 'integer',
            'climbing' => 'integer',
            'bending' => 'integer',
            'twisting' => 'integer',
            'kneeling' => 'integer',
            'crouching' => 'integer',
            'crawling' => 'integer',
            'squatting' => 'integer',
            'reaching_overhead' => 'integer',
            'reaching_outward' => 'integer',
            'repetitive_motions' => 'integer',
            'handling' => 'integer',
            'fine_manipulation' => 'integer',
            'talk_hear_see' => 'integer',
            'vibratory' => 'integer',
            'other' => 'integer',
        ];
    }

    /**
     * The jobs that can perform this task.
     */
    public function jobs(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'ejd_job_task', 'task_id', 'job_id');
    }

    /**
     * Task selections for analytics.
     */
    public function selections(): HasMany
    {
        return $this->hasMany(TaskSelection::class, 'task_id');
    }

    /**
     * Scope a query to order by sort_order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Scope to get tasks for a specific job.
     */
    public function scopeForJob($query, Job|int $job)
    {
        $jobId = $job instanceof Job ? $job->id : $job;

        return $query->whereHas('jobs', function ($q) use ($jobId) {
            $q->where('ejd_jobs.id', $jobId);
        });
    }

    /**
     * Get all physical demand values as an array.
     *
     * @return array<string, int>
     */
    public function getPhysicalDemands(): array
    {
        $demands = [];
        foreach (self::PHYSICAL_DEMANDS as $demand) {
            $demands[$demand] = $this->{$demand};
        }

        return $demands;
    }

    /**
     * Get physical demand frequencies as enums.
     *
     * @return array<string, PhysicalDemandFrequency>
     */
    public function getPhysicalDemandFrequencies(): array
    {
        $frequencies = [];
        foreach (self::PHYSICAL_DEMANDS as $demand) {
            $frequencies[$demand] = PhysicalDemandFrequency::from($this->{$demand});
        }

        return $frequencies;
    }

    /**
     * Get the label for a physical demand.
     */
    public static function getPhysicalDemandLabel(string $demand): string
    {
        return self::PHYSICAL_DEMAND_LABELS[$demand] ?? ucfirst(str_replace('_', ' ', $demand));
    }

    /**
     * Calculate the highest frequency for each physical demand from a collection of tasks.
     *
     * @param  \Illuminate\Database\Eloquent\Collection<int, Task>  $tasks
     * @return array<string, int>
     */
    public static function calculateHighestFrequencies($tasks): array
    {
        $highest = array_fill_keys(self::PHYSICAL_DEMANDS, 0);

        foreach ($tasks as $task) {
            foreach (self::PHYSICAL_DEMANDS as $demand) {
                if ($task->{$demand} > $highest[$demand]) {
                    $highest[$demand] = $task->{$demand};
                }
            }
        }

        return $highest;
    }
}
