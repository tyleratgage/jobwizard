<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Offer letter submission model for record keeping.
 *
 * @property int $id
 * @property string|null $session_id
 * @property string $template_type
 * @property string $language
 * @property array $form_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class OfferLetterSubmission extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'ejd_offer_letter_submissions';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'session_id',
        'template_type',
        'language',
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
}
