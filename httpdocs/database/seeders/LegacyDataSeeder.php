<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Seeds the new EJD database from legacy data.
 *
 * This seeder connects to the legacy database (smaejd_db) and migrates
 * jobs and tasks to the new normalized schema.
 *
 * Legacy database location: /var/www/vhosts/smartwa.org/ejd.smartwa.org
 * Legacy database: smaejd_db
 */
class LegacyDataSeeder extends Seeder
{
    /**
     * Legacy database connection name.
     */
    protected string $legacyConnection = 'legacy';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting legacy data migration...');

        // Check if legacy connection is configured
        if (! config('database.connections.legacy')) {
            $this->command->error('Legacy database connection not configured. Please add it to config/database.php');

            return;
        }

        DB::beginTransaction();

        try {
            $this->migrateJobs();
            $this->migrateTasks();
            $this->migrateJobTaskRelationships();

            DB::commit();
            $this->command->info('Legacy data migration completed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Migration failed: '.$e->getMessage());
            Log::error('Legacy data migration failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    /**
     * Migrate jobs from legacy 'job' table to 'ejd_jobs'.
     */
    protected function migrateJobs(): void
    {
        $this->command->info('Migrating jobs...');

        $legacyJobs = DB::connection($this->legacyConnection)
            ->table('job')
            ->orderBy('j_seq')
            ->get();

        $count = 0;
        foreach ($legacyJobs as $job) {
            DB::table('ejd_jobs')->insert([
                'code' => $job->j_code,
                'name' => $job->j_name,
                'location' => $job->j_location ?? 'office',
                'sort_order' => $job->j_seq ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $count++;
        }

        $this->command->info("Migrated {$count} jobs.");
    }

    /**
     * Migrate tasks from legacy 'task' table to 'ejd_tasks'.
     */
    protected function migrateTasks(): void
    {
        $this->command->info('Migrating tasks...');

        $legacyTasks = DB::connection($this->legacyConnection)
            ->table('task')
            ->orderBy('t_seq')
            ->get();

        $count = 0;
        foreach ($legacyTasks as $task) {
            DB::table('ejd_tasks')->insert([
                'code' => $task->t_code,
                'name' => $task->t_name,
                'equipment' => $task->t_equipment,
                'sort_order' => $task->t_seq ?? 0,
                'sitting' => $task->t_sit ?? 0,
                'standing' => $task->t_stand ?? 0,
                'walking' => $task->t_walk ?? 0,
                'foot_driving' => $task->t_footDrive ?? 0,
                'lifting' => $task->t_lift ?? 0,
                'carrying' => $task->t_carry ?? 0,
                'pushing_pulling' => $task->t_push ?? 0,
                'climbing' => $task->t_climb ?? 0,
                'bending' => $task->t_bend ?? 0,
                'twisting' => $task->t_twist ?? 0,
                'kneeling' => $task->t_knee ?? 0,
                'crouching' => $task->t_crouch ?? 0,
                'crawling' => $task->t_crawl ?? 0,
                'squatting' => $task->t_squat ?? 0,
                'reaching_overhead' => $task->t_aboveShoulders ?? 0,
                'reaching_outward' => $task->t_reachOut ?? 0,
                'repetitive_motions' => $task->t_repetitive ?? 0,
                'handling' => $task->t_handle ?? 0,
                'fine_manipulation' => $task->t_manipulation ?? 0,
                'talk_hear_see' => $task->t_talkHearSee ?? 0,
                'vibratory' => $task->t_vibratory ?? 0,
                'other' => $task->t_other ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $count++;
        }

        $this->command->info("Migrated {$count} tasks.");
    }

    /**
     * Migrate job-task relationships from serialized t_jobs arrays to pivot table.
     */
    protected function migrateJobTaskRelationships(): void
    {
        $this->command->info('Migrating job-task relationships...');

        // Build job code to ID lookup from new database
        $jobCodeToId = DB::table('ejd_jobs')
            ->pluck('id', 'code')
            ->toArray();

        // Build task code to ID lookup from new database
        $taskCodeToId = DB::table('ejd_tasks')
            ->pluck('id', 'code')
            ->toArray();

        // Get legacy tasks with their serialized job arrays
        $legacyTasks = DB::connection($this->legacyConnection)
            ->table('task')
            ->select('t_code', 't_jobs')
            ->get();

        $relationshipCount = 0;
        $errorCount = 0;

        foreach ($legacyTasks as $task) {
            if (empty($task->t_jobs)) {
                continue;
            }

            // Deserialize the PHP array
            $jobCodes = @unserialize($task->t_jobs);

            if (! is_array($jobCodes)) {
                $this->command->warn("Could not deserialize t_jobs for task {$task->t_code}");
                $errorCount++;

                continue;
            }

            $taskId = $taskCodeToId[$task->t_code] ?? null;
            if (! $taskId) {
                $this->command->warn("Task code not found in new database: {$task->t_code}");
                $errorCount++;

                continue;
            }

            foreach ($jobCodes as $jobCode) {
                $jobId = $jobCodeToId[$jobCode] ?? null;

                if (! $jobId) {
                    // Job code might not exist, skip silently
                    continue;
                }

                // Check if relationship already exists
                $exists = DB::table('ejd_job_task')
                    ->where('job_id', $jobId)
                    ->where('task_id', $taskId)
                    ->exists();

                if (! $exists) {
                    DB::table('ejd_job_task')->insert([
                        'job_id' => $jobId,
                        'task_id' => $taskId,
                    ]);
                    $relationshipCount++;
                }
            }
        }

        $this->command->info("Created {$relationshipCount} job-task relationships.");
        if ($errorCount > 0) {
            $this->command->warn("{$errorCount} errors encountered during relationship migration.");
        }
    }
}
