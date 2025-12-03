<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Str;

/**
 * Simple JSON file-based storage for form presets.
 *
 * Stores presets outside web root in a single JSON file.
 * Designed for low-volume usage (dozens of presets, light traffic).
 */
class PresetStorage
{
    protected string $storagePath;

    public function __construct()
    {
        // Store outside web root, one level up from the Laravel app
        $this->storagePath = dirname(base_path()) . '/ejd-storage';
    }

    /**
     * Get the full path to the presets JSON file.
     */
    protected function getFilePath(): string
    {
        return $this->storagePath . '/form-presets.json';
    }

    /**
     * Ensure storage directory and file exist.
     */
    protected function ensureStorageExists(): void
    {
        if (!is_dir($this->storagePath)) {
            mkdir($this->storagePath, 0755, true);
        }

        if (!file_exists($this->getFilePath())) {
            file_put_contents($this->getFilePath(), '{}');
        }
    }

    /**
     * Load all presets from file.
     */
    protected function loadAll(): array
    {
        $this->ensureStorageExists();

        $content = file_get_contents($this->getFilePath());
        return json_decode($content, true) ?: [];
    }

    /**
     * Save all presets to file.
     */
    protected function saveAll(array $presets): void
    {
        $this->ensureStorageExists();

        file_put_contents(
            $this->getFilePath(),
            json_encode($presets, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }

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
        $presets = $this->loadAll();
        return isset($presets[$token]);
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
        $presets = $this->loadAll();

        // Use existing token or generate new one
        if ($token && isset($presets[$token])) {
            // Update existing
        } else {
            $token = $this->generateToken();
        }

        $presets[$token] = [
            'type' => $type,
            'created' => now()->toIso8601String(),
            'updated' => now()->toIso8601String(),
            'data' => $data,
        ];

        $this->saveAll($presets);

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
        $presets = $this->loadAll();

        if (!isset($presets[$token])) {
            return null;
        }

        return $presets[$token];
    }

    /**
     * Delete a preset by token.
     */
    public function delete(string $token): bool
    {
        $presets = $this->loadAll();

        if (!isset($presets[$token])) {
            return false;
        }

        unset($presets[$token]);
        $this->saveAll($presets);

        return true;
    }

    /**
     * Get all presets of a specific type.
     */
    public function getAllByType(string $type): array
    {
        $presets = $this->loadAll();

        return array_filter($presets, fn($preset) => $preset['type'] === $type);
    }
}
