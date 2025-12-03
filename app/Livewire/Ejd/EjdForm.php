<?php

declare(strict_types=1);

namespace App\Livewire\Ejd;

use App\Enums\JobLocation;
use App\Models\Job;
use App\Models\Task;
use App\Services\EjdPdfService;
use App\Services\PresetStorage;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Single-page EJD Form Component.
 *
 * Replaces the multi-step wizard with a reactive single-page form
 * that matches the legacy application field structure exactly.
 */
#[Layout('components.layouts.app')]
#[Title('Essential Job Description Form')]
class EjdForm extends Component
{
    /**
     * Physical demand categories matching legacy system.
     * Maps legacy keys to display names.
     */
    public const PHYSICAL_DEMANDS = [
        'sit' => 'Sitting',
        'stand' => 'Standing',
        'walk' => 'Walking',
        'climb' => 'Climbing Ladders/Stairs',
        'twist' => 'Twisting at the Waist',
        'bend' => 'Bending/Stooping',
        'knee' => 'Squatting/Kneeling',
        'crawl' => 'Crawling',
        'reachOut' => 'Reaching Out',
        'aboveShoulders' => 'Working above Shoulders',
        'handle' => 'Handling/Grasping',
        'manipulation' => 'Fine Finger Manipulation',
        'footDrive' => 'Foot Controls/Driving',
        'repetitive' => 'Repetitive Motion',
        'talkHearSee' => 'Talking/Hearing/Seeing',
        'vibratory' => 'Vibratory Tasks',
        'other' => 'Comments/Other',
    ];

    /**
     * Lifting/Pushing categories with weight fields.
     */
    public const LIFTING_DEMANDS = [
        'lift' => 'Lifting',
        'carry' => 'Carrying',
        'push' => 'Pushing/Pulling',
    ];

    /**
     * Maps legacy physical demand keys to Task model column names.
     */
    public const DEMAND_COLUMN_MAP = [
        'sit' => 'sitting',
        'stand' => 'standing',
        'walk' => 'walking',
        'climb' => 'climbing',
        'twist' => 'twisting',
        'bend' => 'bending',
        'knee' => 'kneeling',
        'crawl' => 'crawling',
        'reachOut' => 'reaching_outward',
        'aboveShoulders' => 'reaching_overhead',
        'handle' => 'handling',
        'manipulation' => 'fine_manipulation',
        'footDrive' => 'foot_driving',
        'repetitive' => 'repetitive_motions',
        'talkHearSee' => 'talk_hear_see',
        'vibratory' => 'vibratory',
        'other' => 'other',
        'lift' => 'lifting',
        'carry' => 'carrying',
        'push' => 'pushing_pulling',
    ];

    /**
     * Frequency options (1-5 maps to N/S/O/F/C).
     */
    public const FREQUENCY_OPTIONS = [
        1 => 'N',
        2 => 'S',
        3 => 'O',
        4 => 'F',
        5 => 'C',
    ];

    public const FREQUENCY_LABELS = [
        1 => 'Never (not at all)',
        2 => 'Seldom (1-10%)',
        3 => 'Occasional (11-33%)',
        4 => 'Frequent (34-66%)',
        5 => 'Constant (67-100%)',
    ];

    // Section 1: Basic Information
    public string $employer = '';

    public string $phone = '';

    public string $title = '';

    public string $workerName = '';

    public string $claimNo = '';

    public string $date = '';

    // Section 2: Job Details
    public string $location = '';

    public int $hrPerDay = 0;

    public int $daysWkPerShift = 0;

    // Section 3: Job Selection (multi-select)
    public array $jobTitle = [];

    // Section 4: Tasks
    public array $tasks = [];

    public string $newTask = '';

    public string $toolsEquipment = '';

    // Section 5: Physical Demands
    // Frequencies keyed by demand name (1-5)
    public array $frequencies = [];

    // Descriptions keyed by demand name
    public array $descriptions = [];

    // Lifting/Pushing with lbs
    public string $lbsLift = '';

    public string $lbsCarry = '';

    public string $lbsPush = '';

    // Honeypot for spam protection
    public string $mycompany = '';

    // Form state
    public bool $showPreview = false;

    // Preset token (from URL query param)
    #[Url(as: 'preset')]
    public string $presetToken = '';

    // Track if we're working with an existing preset
    public bool $hasActivePreset = false;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->date = now()->format('Y-m-d');
        $this->initializeFrequencies();

        // Load preset if token provided in URL
        if ($this->presetToken) {
            $this->loadPresetFromToken($this->presetToken);
        }
    }

    /**
     * Load a preset from token.
     */
    protected function loadPresetFromToken(string $token): void
    {
        $storage = new PresetStorage();
        $preset = $storage->load($token);

        if (!$preset || $preset['type'] !== 'ejd') {
            $this->presetToken = '';
            return;
        }

        $this->hydrateFromPreset($preset['data']);
        $this->hasActivePreset = true;
    }

    /**
     * Hydrate form fields from preset data.
     */
    protected function hydrateFromPreset(array $data): void
    {
        $this->employer = $data['employer'] ?? '';
        $this->phone = $data['phone'] ?? '';
        $this->title = $data['title'] ?? '';
        $this->workerName = $data['workerName'] ?? '';
        $this->claimNo = $data['claimNo'] ?? '';
        $this->date = $data['date'] ?? now()->format('Y-m-d');
        $this->location = $data['location'] ?? '';
        $this->hrPerDay = $data['hrPerDay'] ?? 0;
        $this->daysWkPerShift = $data['daysWkPerShift'] ?? 0;
        $this->jobTitle = $data['jobTitle'] ?? [];
        $this->tasks = $data['tasks'] ?? [];
        $this->newTask = $data['newTask'] ?? '';
        $this->toolsEquipment = $data['toolsEquipment'] ?? '';
        $this->frequencies = $data['frequencies'] ?? [];
        $this->descriptions = $data['descriptions'] ?? [];
        $this->lbsLift = $data['lbsLift'] ?? '';
        $this->lbsCarry = $data['lbsCarry'] ?? '';
        $this->lbsPush = $data['lbsPush'] ?? '';

        // Re-initialize any missing frequency keys
        foreach (array_keys(self::PHYSICAL_DEMANDS) as $demand) {
            if (!isset($this->frequencies[$demand])) {
                $this->frequencies[$demand] = 1;
            }
            if (!isset($this->descriptions[$demand])) {
                $this->descriptions[$demand] = '';
            }
        }
        foreach (array_keys(self::LIFTING_DEMANDS) as $demand) {
            if (!isset($this->frequencies[$demand])) {
                $this->frequencies[$demand] = 1;
            }
            if (!isset($this->descriptions[$demand])) {
                $this->descriptions[$demand] = '';
            }
        }
    }

    /**
     * Get current form data as array for saving.
     */
    protected function getFormDataForPreset(): array
    {
        return [
            'employer' => $this->employer,
            'phone' => $this->phone,
            'title' => $this->title,
            'workerName' => $this->workerName,
            'claimNo' => $this->claimNo,
            'date' => $this->date,
            'location' => $this->location,
            'hrPerDay' => $this->hrPerDay,
            'daysWkPerShift' => $this->daysWkPerShift,
            'jobTitle' => $this->jobTitle,
            'tasks' => $this->tasks,
            'newTask' => $this->newTask,
            'toolsEquipment' => $this->toolsEquipment,
            'frequencies' => $this->frequencies,
            'descriptions' => $this->descriptions,
            'lbsLift' => $this->lbsLift,
            'lbsCarry' => $this->lbsCarry,
            'lbsPush' => $this->lbsPush,
        ];
    }

    /**
     * Save current form as a preset.
     * Returns the URL with the preset token.
     */
    public function savePreset(): void
    {
        $storage = new PresetStorage();

        // If we have an active preset, update it; otherwise create new
        $token = $this->hasActivePreset ? $this->presetToken : null;

        $this->presetToken = $storage->save('ejd', $this->getFormDataForPreset(), $token);
        $this->hasActivePreset = true;

        // Dispatch browser event to show the shareable URL
        $this->dispatch('preset-saved', url: url('/ejd?preset=' . $this->presetToken));
    }

    /**
     * Clear form and start fresh (removes preset association).
     */
    public function clearForm(): void
    {
        $this->reset([
            'employer', 'phone', 'title', 'workerName', 'claimNo',
            'location', 'hrPerDay', 'daysWkPerShift', 'jobTitle',
            'tasks', 'newTask', 'toolsEquipment', 'lbsLift', 'lbsCarry', 'lbsPush',
            'presetToken', 'hasActivePreset', 'showPreview',
        ]);
        $this->date = now()->format('Y-m-d');
        $this->initializeFrequencies();
    }

    /**
     * Initialize all frequency and description arrays.
     */
    protected function initializeFrequencies(): void
    {
        foreach (array_keys(self::PHYSICAL_DEMANDS) as $demand) {
            $this->frequencies[$demand] = 1; // Default to Never
            $this->descriptions[$demand] = '';
        }
        foreach (array_keys(self::LIFTING_DEMANDS) as $demand) {
            $this->frequencies[$demand] = 1;
            $this->descriptions[$demand] = '';
        }
        // For newTask
        $this->frequencies['newTask'] = 1;
        $this->descriptions['newTask'] = '';
    }

    /**
     * Get location options for radio buttons.
     */
    #[Computed]
    public function locationOptions(): array
    {
        return JobLocation::options();
    }

    /**
     * Get hours per day options.
     */
    #[Computed]
    public function hoursOptions(): array
    {
        return range(0, 10);
    }

    /**
     * Get days per week options.
     */
    #[Computed]
    public function daysOptions(): array
    {
        return range(0, 5);
    }

    /**
     * Get available jobs filtered by selected location.
     */
    #[Computed]
    public function availableJobs(): Collection
    {
        if (empty($this->location)) {
            return collect();
        }

        return Job::atLocation(JobLocation::from($this->location))
            ->ordered()
            ->get();
    }

    /**
     * Get available tasks filtered by selected job(s).
     */
    #[Computed]
    public function availableTasks(): Collection
    {
        if (empty($this->jobTitle)) {
            return collect();
        }

        // Get all tasks related to any of the selected jobs
        return Task::whereHas('jobs', function ($query) {
            $query->whereIn('ejd_jobs.id', $this->jobTitle);
        })
            ->ordered()
            ->get()
            ->unique('id');
    }

    /**
     * Get the selected jobs.
     */
    #[Computed]
    public function selectedJobs(): Collection
    {
        if (empty($this->jobTitle)) {
            return collect();
        }

        return Job::whereIn('id', $this->jobTitle)->ordered()->get();
    }

    /**
     * Get the selected tasks.
     */
    #[Computed]
    public function selectedTasks(): Collection
    {
        if (empty($this->tasks)) {
            return collect();
        }

        return Task::whereIn('id', $this->tasks)->ordered()->get();
    }

    /**
     * Handle location change - reset dependent fields.
     */
    public function updatedLocation(): void
    {
        $this->jobTitle = [];
        $this->tasks = [];
        $this->toolsEquipment = '';
        $this->initializeFrequencies();
    }

    /**
     * Handle job selection change - reset tasks and recalculate.
     */
    public function updatedJobTitle(): void
    {
        $this->tasks = [];
        $this->toolsEquipment = '';
        $this->initializeFrequencies();
    }

    /**
     * Handle task selection change - update equipment and calculate demands.
     */
    public function updatedTasks(): void
    {
        $this->updateEquipmentFromTasks();
        $this->calculatePhysicalDemands();
    }

    /**
     * Update equipment textarea from selected tasks.
     */
    protected function updateEquipmentFromTasks(): void
    {
        $tasks = $this->selectedTasks;

        if ($tasks->isEmpty()) {
            $this->toolsEquipment = '';

            return;
        }

        // Collect unique equipment from all selected tasks
        $equipment = $tasks
            ->pluck('equipment')
            ->filter()
            ->flatMap(fn ($eq) => array_map('trim', explode(',', $eq)))
            ->filter()
            ->unique()
            ->sort()
            ->implode(', ');

        $this->toolsEquipment = $equipment;
    }

    /**
     * Calculate physical demand averages from selected tasks.
     * Uses ceiling of average, matching legacy behavior.
     */
    protected function calculatePhysicalDemands(): void
    {
        $tasks = $this->selectedTasks;

        if ($tasks->isEmpty()) {
            $this->initializeFrequencies();

            return;
        }

        $count = $tasks->count();

        // Calculate average for each physical demand
        foreach (self::DEMAND_COLUMN_MAP as $legacyKey => $columnName) {
            $sum = $tasks->sum($columnName);
            // Legacy uses ceil of average, then adds 1 for 1-based radio
            // But our columns are already 0-4 (matching frequency values 0-4)
            // We need to map to 1-5 for the radio buttons
            $avg = (int) ceil($sum / $count);
            $this->frequencies[$legacyKey] = min(5, max(1, $avg + 1));
        }
    }

    /**
     * Select all available tasks.
     */
    public function selectAllTasks(): void
    {
        $this->tasks = $this->availableTasks->pluck('id')->toArray();
        $this->updatedTasks();
    }

    /**
     * Clear all task selections.
     */
    public function clearAllTasks(): void
    {
        $this->tasks = [];
        $this->updatedTasks();
    }

    /**
     * Format phone number as user types.
     */
    public function updatedPhone(): void
    {
        // Remove all non-digits
        $digits = preg_replace('/\D/', '', $this->phone);

        // Format as xxx-xxx-xxxx
        if (strlen($digits) >= 10) {
            $digits = substr($digits, 0, 10);
            $this->phone = substr($digits, 0, 3).'-'.substr($digits, 3, 3).'-'.substr($digits, 6, 4);
        } elseif (strlen($digits) >= 6) {
            $this->phone = substr($digits, 0, 3).'-'.substr($digits, 3, 3).'-'.substr($digits, 6);
        } elseif (strlen($digits) >= 3) {
            $this->phone = substr($digits, 0, 3).'-'.substr($digits, 3);
        } else {
            $this->phone = $digits;
        }
    }

    /**
     * Get validation rules.
     */
    protected function rules(): array
    {
        return [
            'mycompany' => 'size:0',
            'employer' => 'required|string|max:255',
            'phone' => ['required', 'regex:/^\d{3}-\d{3}-\d{4}$/'],
            'title' => 'required|string|max:255',
            'workerName' => 'required|string|max:255',
            'claimNo' => 'nullable|string|max:50',
            'date' => 'required|date',
            'location' => 'required|in:office,yard,job',
            'hrPerDay' => 'required|integer|min:1|max:10',
            'daysWkPerShift' => 'required|integer|min:1|max:5',
            'jobTitle' => 'required|array|min:1',
            'jobTitle.*' => 'integer|exists:ejd_jobs,id',
            'tasks' => 'required|array|min:1',
            'tasks.*' => 'integer|exists:ejd_tasks,id',
            'toolsEquipment' => 'required|string',
            'frequencies.*' => 'required|integer|min:1|max:5',
            'lbsLift' => 'required_unless:frequencies.lift,1|nullable|numeric|min:0',
            'lbsCarry' => 'required_unless:frequencies.carry,1|nullable|numeric|min:0',
            'lbsPush' => 'required_unless:frequencies.push,1|nullable|numeric|min:0',
        ];
    }

    /**
     * Get validation messages.
     */
    protected function messages(): array
    {
        return [
            'mycompany.size' => 'Spam detected.',
            'employer.required' => 'Employer name is required.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Phone must be in format xxx-xxx-xxxx.',
            'title.required' => 'Title is required.',
            'workerName.required' => 'Worker name is required.',
            'date.required' => 'Date is required.',
            'location.required' => 'Please select a location.',
            'hrPerDay.required' => 'Hours per day is required.',
            'hrPerDay.min' => 'Hours per day must be at least 1.',
            'daysWkPerShift.required' => 'Days per week is required.',
            'daysWkPerShift.min' => 'Days per week must be at least 1.',
            'jobTitle.required' => 'Please select at least one job title.',
            'jobTitle.min' => 'Please select at least one job title.',
            'tasks.required' => 'Please select at least one task.',
            'tasks.min' => 'Please select at least one task.',
            'toolsEquipment.required' => 'Equipment and tools is required.',
            'lbsLift.required_unless' => 'Please enter weight for Lifting.',
            'lbsCarry.required_unless' => 'Please enter weight for Carrying.',
            'lbsPush.required_unless' => 'Please enter weight for Pushing/Pulling.',
        ];
    }

    /**
     * Generate the form / show preview.
     */
    public function generateForm(): void
    {
        $this->validate();

        $this->showPreview = true;
    }

    /**
     * Go back to editing.
     */
    public function editForm(): void
    {
        $this->showPreview = false;
    }

    /**
     * Get job title string for display.
     */
    #[Computed]
    public function jobTitleDisplay(): string
    {
        return $this->selectedJobs->pluck('name')->implode(', ');
    }

    /**
     * Get tasks string for display.
     */
    #[Computed]
    public function tasksDisplay(): string
    {
        $taskNames = $this->selectedTasks->pluck('name')->toArray();

        if ($this->newTask) {
            $taskNames[] = $this->newTask;
        }

        if (empty($taskNames)) {
            return '';
        }

        // First task capitalized, rest lowercase
        $first = array_shift($taskNames);
        $rest = array_map('lcfirst', $taskNames);

        return $first.(empty($rest) ? '' : ', '.implode(', ', $rest)).'.';
    }

    /**
     * Get frequency letter for display.
     */
    public function getFrequencyLetter(int $value): string
    {
        return self::FREQUENCY_OPTIONS[$value] ?? 'N';
    }

    /**
     * Download the form as PDF.
     */
    public function downloadPdf(): StreamedResponse
    {
        $this->validate();

        // Build frequency letters array
        $frequencyLetters = [];
        foreach ($this->frequencies as $key => $value) {
            $frequencyLetters[$key] = $this->getFrequencyLetter($value);
        }

        $data = [
            'workerName' => $this->workerName,
            'claimNo' => $this->claimNo,
            'employer' => $this->employer,
            'jobTitleDisplay' => $this->jobTitleDisplay,
            'phone' => $this->phone,
            'hrPerDay' => $this->hrPerDay,
            'daysWkPerShift' => $this->daysWkPerShift,
            'title' => $this->title,
            'date' => $this->date,
            'tasksDisplay' => $this->tasksDisplay,
            'toolsEquipment' => $this->toolsEquipment,
            'newTask' => $this->newTask,
            'physicalDemands' => self::PHYSICAL_DEMANDS,
            'liftingDemands' => self::LIFTING_DEMANDS,
            'frequencies' => $this->frequencies,
            'frequencyLetters' => $frequencyLetters,
            'descriptions' => $this->descriptions,
            'lbsValues' => [
                'lift' => $this->lbsLift,
                'carry' => $this->lbsCarry,
                'push' => $this->lbsPush,
            ],
        ];

        $pdfService = new EjdPdfService();
        $pdfContent = $pdfService->generate($data);

        // Log form completion
        DB::table('form_completions')->insert([
            'form_type' => 'ejd',
            'language' => 'english',
            'created_at' => now(),
        ]);

        $filename = 'EJD_'.str_replace(' ', '_', $this->workerName).'_'.date('Y-m-d').'.pdf';

        return response()->streamDownload(
            fn () => print($pdfContent),
            $filename,
            [
                'Content-Type' => 'application/pdf',
            ]
        );
    }

    /**
     * Render the component.
     */
    public function render(): View
    {
        return view('livewire.ejd.ejd-form');
    }
}
