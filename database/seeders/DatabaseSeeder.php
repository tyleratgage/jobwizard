<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run the legacy data migration seeder
        // This will import jobs and tasks from the legacy database
        // Make sure LEGACY_DB_* environment variables are set before running
        $this->call([
            LegacyDataSeeder::class,
        ]);
    }
}
