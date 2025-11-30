<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * EJD form submission model for record keeping.
 *
 * @property int $id
 * @property string|null $session_id
 * @property int|null $job_id
 * @property array $form_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Job|null $job
 */
class EjdSubmission extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'ejd_submissions';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'session_id',
        'job_id',
        'form_data',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'form_data' => 'array',
        ];
    }

    /**
     * The job associated with this submission.
     */
    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
