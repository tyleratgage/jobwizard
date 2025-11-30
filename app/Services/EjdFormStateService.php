<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Session;

/**
 * Service for managing EJD form state across wizard steps.
 *
 * Handles session-based persistence of form data throughout the multi-step
 * wizard process.
 */
class EjdFormStateService
{
    /**
     * Session key for storing form state.
     */
    private const SESSION_KEY = 'ejd_form_state';

    /**
     * Default form state structure.
     */
    private const DEFAULT_STATE = [
        'current_step' => 1,
        'employer' => [
            'company_name' => '',
            'address' => '',
            'city' => '',
            'state' => '',
            'zip' => '',
            'contact_name' => '',
            'contact_phone' => '',
            'contact_email' => '',
        ],
        'worker' => [
            'first_name' => '',
            'last_name' => '',
            'address' => '',
            'city' => '',
            'state' => '',
            'zip' => '',
            'claim_number' => '',
            'injury_date' => '',
            'return_to_work_date' => '',
        ],
        'job_id' => null,
        'task_ids' => [],
        'completed_steps' => [],
    ];

    /**
     * Get the current form state from session.
     *
     * @return array<string, mixed>
     */
    public function getState(): array
    {
        return Session::get(self::SESSION_KEY, self::DEFAULT_STATE);
    }

    /**
     * Update form state in session.
     *
     * @param  array<string, mixed>  $data
     */
    public function updateState(array $data): void
    {
        $state = $this->getState();
        $state = array_merge($state, $data);
        Session::put(self::SESSION_KEY, $state);
    }

    /**
     * Update a specific section of the form state.
     *
     * @param  array<string, mixed>  $data
     */
    public function updateSection(string $section, array $data): void
    {
        $state = $this->getState();

        if (isset($state[$section]) && is_array($state[$section])) {
            $state[$section] = array_merge($state[$section], $data);
        } else {
            $state[$section] = $data;
        }

        Session::put(self::SESSION_KEY, $state);
    }

    /**
     * Get a specific value from form state.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $state = $this->getState();

        return data_get($state, $key, $default);
    }

    /**
     * Set a specific value in form state.
     */
    public function set(string $key, mixed $value): void
    {
        $state = $this->getState();
        data_set($state, $key, $value);
        Session::put(self::SESSION_KEY, $state);
    }

    /**
     * Get the current step number.
     */
    public function getCurrentStep(): int
    {
        return (int) $this->get('current_step', 1);
    }

    /**
     * Set the current step number.
     */
    public function setCurrentStep(int $step): void
    {
        $this->set('current_step', $step);
    }

    /**
     * Mark a step as completed.
     */
    public function markStepCompleted(int $step): void
    {
        $completedSteps = $this->get('completed_steps', []);

        if (! in_array($step, $completedSteps)) {
            $completedSteps[] = $step;
            sort($completedSteps);
            $this->set('completed_steps', $completedSteps);
        }
    }

    /**
     * Check if a step has been completed.
     */
    public function isStepCompleted(int $step): bool
    {
        $completedSteps = $this->get('completed_steps', []);

        return in_array($step, $completedSteps);
    }

    /**
     * Get the highest completed step.
     */
    public function getHighestCompletedStep(): int
    {
        $completedSteps = $this->get('completed_steps', []);

        return empty($completedSteps) ? 0 : max($completedSteps);
    }

    /**
     * Check if a step is accessible (user can navigate to it).
     */
    public function isStepAccessible(int $step): bool
    {
        if ($step === 1) {
            return true;
        }

        // Can access any completed step or the next step after completed ones
        return $step <= $this->getHighestCompletedStep() + 1;
    }

    /**
     * Get selected job ID.
     */
    public function getJobId(): ?int
    {
        $jobId = $this->get('job_id');

        return $jobId !== null ? (int) $jobId : null;
    }

    /**
     * Set selected job ID.
     */
    public function setJobId(?int $jobId): void
    {
        $this->set('job_id', $jobId);

        // Clear task selections when job changes
        if ($jobId !== null) {
            $currentJobId = $this->get('job_id');
            if ($currentJobId !== $jobId) {
                $this->set('task_ids', []);
            }
        }
    }

    /**
     * Get selected task IDs.
     *
     * @return array<int>
     */
    public function getTaskIds(): array
    {
        return (array) $this->get('task_ids', []);
    }

    /**
     * Set selected task IDs.
     *
     * @param  array<int>  $taskIds
     */
    public function setTaskIds(array $taskIds): void
    {
        $this->set('task_ids', array_map('intval', $taskIds));
    }

    /**
     * Clear all form state.
     */
    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    /**
     * Reset form to initial state.
     */
    public function reset(): void
    {
        Session::put(self::SESSION_KEY, self::DEFAULT_STATE);
    }

    /**
     * Check if the form has any data entered.
     */
    public function hasData(): bool
    {
        $state = $this->getState();

        // Check if employer has any data
        foreach ($state['employer'] as $value) {
            if (! empty($value)) {
                return true;
            }
        }

        // Check if worker has any data
        foreach ($state['worker'] as $value) {
            if (! empty($value)) {
                return true;
            }
        }

        // Check if job or tasks selected
        if (! empty($state['job_id']) || ! empty($state['task_ids'])) {
            return true;
        }

        return false;
    }
}
