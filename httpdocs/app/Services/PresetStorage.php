<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Database-backed storage for form presets.
 *
 * Stores presets in the form_presets table with JSON data column.
 */
class PresetStorage
{
    protected string $table = 'form_presets';

    /**
     * Generate a unique 8-character token.
     */
    protected function generateToken(): string
    {
        do {
            $token = Str::lower(Str::random(8));
        } while ($this->exists($token));

        return $token;
    }

    /**
     * Check if a token exists.
     */
    public function exists(string $token): bool
    {
        return DB::table($this->table)->where('token', $token)->exists();
    }

    /**
     * Save a preset (create new or update existing).
     *
     * @param string $type Form type ('ejd' or 'offer-letter')
     * @param array $data Form data to save
     * @param string|null $token Existing token to update, or null to create new
     * @return string The token for this preset
     */
    public function save(string $type, array $data, ?string $token = null): string
    {
        $now = now();

        if ($token && $this->exists($token)) {
            // Update existing
            DB::table($this->table)
                ->where('token', $token)
                ->update([
                    'type' => $type,
                    'data' => json_encode($data),
                    'updated_at' => $now,
                ]);
        } else {
            // Create new
            $token = $this->generateToken();

            DB::table($this->table)->insert([
                'token' => $token,
                'type' => $type,
                'data' => json_encode($data),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        return $token;
    }

    /**
     * Load a preset by token.
     *
     * @param string $token
     * @return array|null The preset data, or null if not found
     */
    public function load(string $token): ?array
    {
        $preset = DB::table($this->table)
            ->where('token', $token)
            ->first();

        if (!$preset) {
            return null;
        }

        return [
            'type' => $preset->type,
            'created' => $preset->created_at,
            'updated' => $preset->updated_at,
            'data' => json_decode($preset->data, true),
        ];
    }

    /**
     * Delete a preset by token.
     */
    public function delete(string $token): bool
    {
        $deleted = DB::table($this->table)
            ->where('token', $token)
            ->delete();

        return $deleted > 0;
    }

    /**
     * Get all presets of a specific type.
     */
    public function getAllByType(string $type): array
    {
        $presets = DB::table($this->table)
            ->where('type', $type)
            ->get();

        $result = [];
        foreach ($presets as $preset) {
            $result[$preset->token] = [
                'type' => $preset->type,
                'created' => $preset->created_at,
                'updated' => $preset->updated_at,
                'data' => json_decode($preset->data, true),
            ];
        }

        return $result;
    }
}
