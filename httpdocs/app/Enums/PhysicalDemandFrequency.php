<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Physical Demand Frequency levels for job tasks.
 *
 * Maps to legacy pd_freq table values (0-4).
 */
enum PhysicalDemandFrequency: int
{
    case NEVER = 0;
    case SELDOM = 1;
    case OCCASIONAL = 2;
    case FREQUENT = 3;
    case CONSTANT = 4;

    /**
     * Get the human-readable label for this frequency.
     */
    public function label(): string
    {
        return match ($this) {
            self::NEVER => 'Never (not at all)',
            self::SELDOM => 'Seldom (1-10% of the time)',
            self::OCCASIONAL => 'Occasional (11-33% of the time)',
            self::FREQUENT => 'Frequent (34-66% of the time)',
            self::CONSTANT => 'Constant (67-100% of the time)',
        };
    }

    /**
     * Get the short label for this frequency.
     */
    public function shortLabel(): string
    {
        return match ($this) {
            self::NEVER => 'Never',
            self::SELDOM => 'Seldom',
            self::OCCASIONAL => 'Occasional',
            self::FREQUENT => 'Frequent',
            self::CONSTANT => 'Constant',
        };
    }

    /**
     * Get the percentage range for this frequency.
     */
    public function percentage(): string
    {
        return match ($this) {
            self::NEVER => '0%',
            self::SELDOM => '1-10%',
            self::OCCASIONAL => '11-33%',
            self::FREQUENT => '34-66%',
            self::CONSTANT => '67-100%',
        };
    }

    /**
     * Get all frequencies as an array for form selects.
     *
     * @return array<int, string>
     */
    public static function options(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_map(fn (self $case) => $case->label(), self::cases())
        );
    }
}
