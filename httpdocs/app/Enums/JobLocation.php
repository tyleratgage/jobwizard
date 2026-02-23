<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Job location types.
 *
 * Maps to legacy job.j_location values.
 */
enum JobLocation: string
{
    case OFFICE = 'office';
    case YARD = 'yard';
    case JOB = 'job';

    /**
     * Get the human-readable label for this location.
     */
    public function label(): string
    {
        return match ($this) {
            self::OFFICE => 'Office',
            self::YARD => 'Yard',
            self::JOB => 'Job Site',
        };
    }

    /**
     * Get all locations as an array for form selects.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_map(fn (self $case) => $case->label(), self::cases())
        );
    }
}
