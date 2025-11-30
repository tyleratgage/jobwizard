<?php

declare(strict_types=1);

namespace App\Livewire\Ejd;

use App\Models\Job;
use App\Models\Task;
use App\Services\EjdFormStateService;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * EJD Multi-Step Form Wizard Component.
 *
 * Manages the 5-step wizard for creating Essential Job Descriptions:
 * 1. Employer & Worker Information
 * 2. Job Selection
 * 3. Task Selection
 * 4. Physical Demand Assessment
 * 5. Preview & Generate
 */
#[Layout('components.layouts.app')]
#[Title('Essential Job Description Form')]
class EjdWizard extends Component
{
    /**
     * Step configuration.
     */
    public const STEPS = [
        1 => [
            'title' => 'Employer & Worker Info',
            'description' => 'Enter employer and worker details',
            'icon' => 'user',
        ],
        2 => [
            'title' => 'Select Job',
            'description' => 'Choose a job position',
            'icon' => 'briefcase',
        ],
        3 => [
            'title' => 'Select Tasks',
            'description' => 'Choose applicable tasks',
            'icon' => 'clipboard-list',
        ],
        4 => [
            'title' => 'Physical Demands',
            'description' => 'Review physical requirements',
            'icon' => 'activity',
        ],
        5 => [
            'title' => 'Preview & Generate',
            'description' => 'Review and generate document',
            'icon' => 'file-text',
        ],
    ];

    /**
     * Total number of steps.
     */
    public const TOTAL_STEPS = 5;

    /**
     * Current wizard step.
     */
    public int $currentStep = 1;

    /**
     * Completed steps.
     *
     * @var array<int>
     */
    public array $completedSteps = [];

    /**
     * Step 1: Employer Information.
     */
    public string $employerCompanyName = '';

    public string $employerAddress = '';

    public string $employerCity = '';

    public string $employerState = '';

    public string $employerZip = '';

    public string $employerContactName = '';

    public string $employerContactPhone = '';

    public string $employerContactEmail = '';

    /**
     * Step 1: Worker Information.
     */
    public string $workerFirstName = '';

    public string $workerLastName = '';

    public string $workerAddress = '';

    public string $workerCity = '';

    public string $workerState = '';

    public string $workerZip = '';

    public string $workerClaimNumber = '';

    public string $workerInjuryDate = '';

    public string $workerReturnToWorkDate = '';

    /**
     * Step 2: Selected Job.
     */
    public ?int $selectedJobId = null;

    /**
     * Step 3: Selected Tasks.
     *
     * @var array<int>
     */
    public array $selectedTaskIds = [];

    /**
     * Honeypot field for spam protection.
     */
    public string $honeypot = '';

    /**
     * Form state service instance.
     */
    protected EjdFormStateService $formStateService;

    /**
     * Boot the component.
     */
    public function boot(EjdFormStateService $formStateService): void
    {
        $this->formStateService = $formStateService;
    }

    /**
     * Mount the component and restore state from session.
     */
    public function mount(): void
    {
        $this->restoreFromSession();
    }

    /**
     * Restore form state from session.
     */
    protected function restoreFromSession(): void
    {
        $state = $this->formStateService->getState();

        $this->currentStep = $state['current_step'];
        $this->completedSteps = $state['completed_steps'];

        // Employer data
        $this->employerCompanyName = $state['employer']['company_name'];
        $this->employerAddress = $state['employer']['address'];
        $this->employerCity = $state['employer']['city'];
        $this->employerState = $state['employer']['state'];
        $this->employerZip = $state['employer']['zip'];
        $this->employerContactName = $state['employer']['contact_name'];
        $this->employerContactPhone = $state['employer']['contact_phone'];
        $this->employerContactEmail = $state['employer']['contact_email'];

        // Worker data
        $this->workerFirstName = $state['worker']['first_name'];
        $this->workerLastName = $state['worker']['last_name'];
        $this->workerAddress = $state['worker']['address'];
        $this->workerCity = $state['worker']['city'];
        $this->workerState = $state['worker']['state'];
        $this->workerZip = $state['worker']['zip'];
        $this->workerClaimNumber = $state['worker']['claim_number'];
        $this->workerInjuryDate = $state['worker']['injury_date'];
        $this->workerReturnToWorkDate = $state['worker']['return_to_work_date'];

        // Job and Task selections
        $this->selectedJobId = $state['job_id'];
        $this->selectedTaskIds = $state['task_ids'];
    }

    /**
     * Persist current form state to session.
     */
    protected function persistToSession(): void
    {
        $this->formStateService->updateState([
            'current_step' => $this->currentStep,
            'completed_steps' => $this->completedSteps,
            'employer' => [
                'company_name' => $this->employerCompanyName,
                'address' => $this->employerAddress,
                'city' => $this->employerCity,
                'state' => $this->employerState,
                'zip' => $this->employerZip,
                'contact_name' => $this->employerContactName,
                'contact_phone' => $this->employerContactPhone,
                'contact_email' => $this->employerContactEmail,
            ],
            'worker' => [
                'first_name' => $this->workerFirstName,
                'last_name' => $this->workerLastName,
                'address' => $this->workerAddress,
                'city' => $this->workerCity,
                'state' => $this->workerState,
                'zip' => $this->workerZip,
                'claim_number' => $this->workerClaimNumber,
                'injury_date' => $this->workerInjuryDate,
                'return_to_work_date' => $this->workerReturnToWorkDate,
            ],
            'job_id' => $this->selectedJobId,
            'task_ids' => $this->selectedTaskIds,
        ]);
    }

    /**
     * Get validation rules for the current step.
     *
     * @return array<string, mixed>
     */
    protected function getStepValidationRules(): array
    {
        return match ($this->currentStep) {
            1 => $this->getStep1Rules(),
            2 => $this->getStep2Rules(),
            3 => $this->getStep3Rules(),
            4 => [], // No validation needed for review step
            5 => [], // No validation needed for preview step
            default => [],
        };
    }

    /**
     * Step 1 validation rules.
     *
     * @return array<string, mixed>
     */
    protected function getStep1Rules(): array
    {
        return [
            'honeypot' => 'size:0',
            'employerCompanyName' => 'required|string|max:255',
            'employerAddress' => 'required|string|max:255',
            'employerCity' => 'required|string|max:100',
            'employerState' => 'required|string|size:2',
            'employerZip' => 'required|string|max:10',
            'employerContactName' => 'required|string|max:255',
            'employerContactPhone' => 'required|string|max:20',
            'employerContactEmail' => 'required|email|max:255',
            'workerFirstName' => 'required|string|max:100',
            'workerLastName' => 'required|string|max:100',
            'workerAddress' => 'required|string|max:255',
            'workerCity' => 'required|string|max:100',
            'workerState' => 'required|string|size:2',
            'workerZip' => 'required|string|max:10',
            'workerClaimNumber' => 'nullable|string|max:50',
            'workerInjuryDate' => 'nullable|date',
            'workerReturnToWorkDate' => 'nullable|date|after_or_equal:workerInjuryDate',
        ];
    }

    /**
     * Step 2 validation rules.
     *
     * @return array<string, mixed>
     */
    protected function getStep2Rules(): array
    {
        return [
            'selectedJobId' => 'required|integer|exists:ejd_jobs,id',
        ];
    }

    /**
     * Step 3 validation rules.
     *
     * @return array<string, mixed>
     */
    protected function getStep3Rules(): array
    {
        return [
            'selectedTaskIds' => 'required|array|min:1',
            'selectedTaskIds.*' => 'integer|exists:ejd_tasks,id',
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    protected function getValidationMessages(): array
    {
        return [
            'honeypot.size' => 'Spam detected.',
            'employerCompanyName.required' => 'Company name is required.',
            'employerAddress.required' => 'Employer address is required.',
            'employerCity.required' => 'City is required.',
            'employerState.required' => 'State is required.',
            'employerState.size' => 'State must be a 2-letter code.',
            'employerZip.required' => 'ZIP code is required.',
            'employerContactName.required' => 'Contact name is required.',
            'employerContactPhone.required' => 'Contact phone is required.',
            'employerContactEmail.required' => 'Contact email is required.',
            'employerContactEmail.email' => 'Please enter a valid email address.',
            'workerFirstName.required' => 'Worker first name is required.',
            'workerLastName.required' => 'Worker last name is required.',
            'workerAddress.required' => 'Worker address is required.',
            'workerCity.required' => 'City is required.',
            'workerState.required' => 'State is required.',
            'workerState.size' => 'State must be a 2-letter code.',
            'workerZip.required' => 'ZIP code is required.',
            'workerReturnToWorkDate.after_or_equal' => 'Return to work date must be after injury date.',
            'selectedJobId.required' => 'Please select a job position.',
            'selectedJobId.exists' => 'Selected job is invalid.',
            'selectedTaskIds.required' => 'Please select at least one task.',
            'selectedTaskIds.min' => 'Please select at least one task.',
        ];
    }

    /**
     * Get custom validation attribute names.
     *
     * @return array<string, string>
     */
    protected function getValidationAttributes(): array
    {
        return [
            'employerCompanyName' => 'company name',
            'employerAddress' => 'address',
            'employerCity' => 'city',
            'employerState' => 'state',
            'employerZip' => 'ZIP code',
            'employerContactName' => 'contact name',
            'employerContactPhone' => 'phone',
            'employerContactEmail' => 'email',
            'workerFirstName' => 'first name',
            'workerLastName' => 'last name',
            'workerAddress' => 'address',
            'workerCity' => 'city',
            'workerState' => 'state',
            'workerZip' => 'ZIP code',
            'workerClaimNumber' => 'claim number',
            'workerInjuryDate' => 'injury date',
            'workerReturnToWorkDate' => 'return to work date',
            'selectedJobId' => 'job',
            'selectedTaskIds' => 'tasks',
        ];
    }

    /**
     * Validate the current step.
     *
     * @throws ValidationException
     */
    protected function validateCurrentStep(): void
    {
        $rules = $this->getStepValidationRules();

        if (! empty($rules)) {
            $this->validate(
                $rules,
                $this->getValidationMessages(),
                $this->getValidationAttributes()
            );
        }
    }

    /**
     * Navigate to the next step.
     */
    public function nextStep(): void
    {
        $this->validateCurrentStep();

        // Mark current step as completed
        if (! in_array($this->currentStep, $this->completedSteps)) {
            $this->completedSteps[] = $this->currentStep;
            sort($this->completedSteps);
        }

        if ($this->currentStep < self::TOTAL_STEPS) {
            $this->currentStep++;
        }

        $this->persistToSession();

        // Dispatch event for accessibility
        $this->dispatch('step-changed', step: $this->currentStep);
    }

    /**
     * Navigate to the previous step.
     */
    public function previousStep(): void
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
            $this->persistToSession();
            $this->dispatch('step-changed', step: $this->currentStep);
        }
    }

    /**
     * Navigate to a specific step (only if accessible).
     */
    public function goToStep(int $step): void
    {
        if ($step < 1 || $step > self::TOTAL_STEPS) {
            return;
        }

        // Can only go to completed steps or the next available step
        if ($this->isStepAccessible($step)) {
            $this->currentStep = $step;
            $this->persistToSession();
            $this->dispatch('step-changed', step: $this->currentStep);
        }
    }

    /**
     * Check if a step is accessible.
     */
    public function isStepAccessible(int $step): bool
    {
        if ($step === 1) {
            return true;
        }

        // Can access completed steps or the next step after the highest completed
        $highestCompleted = empty($this->completedSteps) ? 0 : max($this->completedSteps);

        return $step <= $highestCompleted + 1;
    }

    /**
     * Check if a step is completed.
     */
    public function isStepCompleted(int $step): bool
    {
        return in_array($step, $this->completedSteps);
    }

    /**
     * Get progress percentage.
     */
    #[Computed]
    public function progressPercentage(): int
    {
        return (int) (($this->currentStep - 1) / (self::TOTAL_STEPS - 1) * 100);
    }

    /**
     * Get the selected job model.
     */
    #[Computed]
    public function selectedJob(): ?Job
    {
        if (! $this->selectedJobId) {
            return null;
        }

        return Job::find($this->selectedJobId);
    }

    /**
     * Get the selected task models.
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, Task>
     */
    #[Computed]
    public function selectedTasks()
    {
        if (empty($this->selectedTaskIds)) {
            return collect();
        }

        return Task::whereIn('id', $this->selectedTaskIds)->ordered()->get();
    }

    /**
     * Get calculated physical demands from selected tasks.
     *
     * @return array<string, int>
     */
    #[Computed]
    public function physicalDemands(): array
    {
        if (empty($this->selectedTaskIds)) {
            return array_fill_keys(Task::PHYSICAL_DEMANDS, 0);
        }

        return Task::calculateHighestFrequencies($this->selectedTasks);
    }

    /**
     * Reset the entire wizard.
     */
    public function resetWizard(): void
    {
        $this->formStateService->reset();
        $this->restoreFromSession();
        $this->dispatch('wizard-reset');
    }

    /**
     * Handle job selection change (clears task selections).
     */
    public function updatedSelectedJobId(): void
    {
        // Clear task selections when job changes
        $this->selectedTaskIds = [];
        $this->persistToSession();
    }

    /**
     * Get all step definitions.
     *
     * @return array<int, array<string, string>>
     */
    public function getSteps(): array
    {
        return self::STEPS;
    }

    /**
     * Get current step info.
     *
     * @return array<string, string>
     */
    #[Computed]
    public function currentStepInfo(): array
    {
        return self::STEPS[$this->currentStep];
    }

    /**
     * Render the component.
     */
    public function render(): View
    {
        return view('livewire.ejd.ejd-wizard');
    }
}
