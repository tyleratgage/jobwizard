<?php

declare(strict_types=1);

namespace App\Livewire\OfferLetter;

use App\Services\OfferLetterPdfService;
use App\Services\PresetStorage;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Offer Letter Form Component.
 *
 * Generates return-to-work offer letters in multiple languages
 * for injured workers. Supports English, Spanish, and Russian
 * in both Permanent and Temporary/Transitional job types.
 */
#[Layout('components.layouts.app')]
#[Title('Offer Letter Generator')]
class OfferLetterForm extends Component
{
    /**
     * Available languages.
     */
    public const LANGUAGES = [
        'english' => 'English',
        'spanish' => 'Spanish (Español)',
        'russian' => 'Russian (Русский)',
    ];

    /**
     * Available job types.
     */
    public const JOB_TYPES = [
        'permanent' => 'Permanent Job',
        'temporary' => 'Temporary/Transitional Job',
    ];

    /**
     * Available wage duration options.
     */
    public const WAGE_DURATIONS = [
        'hour' => 'Hour',
        'day' => 'Day',
        'week' => 'Week',
    ];

    /**
     * Days of the week.
     */
    public const DAYS_OF_WEEK = [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday',
    ];

    /**
     * US States list.
     */
    public const STATES = [
        'AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas',
        'CA' => 'California', 'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware',
        'FL' => 'Florida', 'GA' => 'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho',
        'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas',
        'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland',
        'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi',
        'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada',
        'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico', 'NY' => 'New York',
        'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma',
        'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina',
        'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah',
        'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West Virginia',
        'WI' => 'Wisconsin', 'WY' => 'Wyoming',
    ];

    // Letter Type & Language
    public string $jobType = 'permanent';
    public string $language = 'english';

    // Worker Information
    #[Validate('required|string|max:100')]
    public string $firstName = '';

    #[Validate('required|string|max:100')]
    public string $lastName = '';

    #[Validate('required|string|max:255')]
    public string $addressOne = '';

    #[Validate('nullable|string|max:255')]
    public string $addressTwo = '';

    #[Validate('required|string|max:100')]
    public string $city = '';

    #[Validate('required|string|size:2')]
    public string $state = 'WA';

    #[Validate('required|string|max:10')]
    public string $zip = '';

    #[Validate('required|string|max:50')]
    public string $claimNo = '';

    // Dates
    #[Validate('required|date')]
    public string $drApprovalDate = '';

    #[Validate('required|date')]
    public string $workDate = '';

    // Schedule
    #[Validate('required|string|max:20')]
    public string $startTime = '';

    #[Validate('required|string|max:20')]
    public string $endTime = '';

    #[Validate('required|integer|min:1|max:168')]
    public int $hoursPerWeek = 40;

    /** @var array<string> */
    #[Validate('required|array|min:1')]
    public array $daysOfTheWeek = [];

    // Wages
    #[Validate('required|numeric|min:0')]
    public string $wage = '';

    #[Validate('required|in:hour,day,week')]
    public string $wageDuration = 'hour';

    // Work Location
    #[Validate('required|string|max:255')]
    public string $locationAddress = '';

    #[Validate('required|string|max:100')]
    public string $locationCity = '';

    #[Validate('required|string|size:2')]
    public string $locationState = 'WA';

    #[Validate('required|string|max:10')]
    public string $locationZip = '';

    // Supervisor/Contact Information
    #[Validate('required|string|max:255')]
    public string $supervisorName = '';

    #[Validate('required|string|max:30')]
    public string $supervisorPhone = '';

    #[Validate('required|string|max:30')]
    public string $contactPhone = '';

    #[Validate('required|string|max:255')]
    public string $valediction = '';

    // CC Recipients
    #[Validate('nullable|string|max:255')]
    public string $ccLine1 = '';

    #[Validate('nullable|string|max:255')]
    public string $ccLine2 = '';

    #[Validate('nullable|string|max:255')]
    public string $ccLine3 = '';

    // Honeypot for spam protection
    #[Validate('size:0')]
    public string $honeypot = '';

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
        // Set default CC placeholders
        $this->ccLine1 = "Claim's Manager w/encl.";
        $this->ccLine2 = 'Physician w/encl.';

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

        if (!$preset || $preset['type'] !== 'offer-letter') {
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
        $this->jobType = $data['jobType'] ?? 'permanent';
        $this->language = $data['language'] ?? 'english';
        $this->firstName = $data['firstName'] ?? '';
        $this->lastName = $data['lastName'] ?? '';
        $this->addressOne = $data['addressOne'] ?? '';
        $this->addressTwo = $data['addressTwo'] ?? '';
        $this->city = $data['city'] ?? '';
        $this->state = $data['state'] ?? 'WA';
        $this->zip = $data['zip'] ?? '';
        $this->claimNo = $data['claimNo'] ?? '';
        $this->drApprovalDate = $data['drApprovalDate'] ?? '';
        $this->workDate = $data['workDate'] ?? '';
        $this->startTime = $data['startTime'] ?? '';
        $this->endTime = $data['endTime'] ?? '';
        $this->hoursPerWeek = $data['hoursPerWeek'] ?? 40;
        $this->daysOfTheWeek = $data['daysOfTheWeek'] ?? [];
        $this->wage = $data['wage'] ?? '';
        $this->wageDuration = $data['wageDuration'] ?? 'hour';
        $this->locationAddress = $data['locationAddress'] ?? '';
        $this->locationCity = $data['locationCity'] ?? '';
        $this->locationState = $data['locationState'] ?? 'WA';
        $this->locationZip = $data['locationZip'] ?? '';
        $this->supervisorName = $data['supervisorName'] ?? '';
        $this->supervisorPhone = $data['supervisorPhone'] ?? '';
        $this->contactPhone = $data['contactPhone'] ?? '';
        $this->valediction = $data['valediction'] ?? '';
        $this->ccLine1 = $data['ccLine1'] ?? "Claim's Manager w/encl.";
        $this->ccLine2 = $data['ccLine2'] ?? 'Physician w/encl.';
        $this->ccLine3 = $data['ccLine3'] ?? '';
    }

    /**
     * Get current form data as array for saving.
     */
    protected function getFormDataForPreset(): array
    {
        return [
            'jobType' => $this->jobType,
            'language' => $this->language,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'addressOne' => $this->addressOne,
            'addressTwo' => $this->addressTwo,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'claimNo' => $this->claimNo,
            'drApprovalDate' => $this->drApprovalDate,
            'workDate' => $this->workDate,
            'startTime' => $this->startTime,
            'endTime' => $this->endTime,
            'hoursPerWeek' => $this->hoursPerWeek,
            'daysOfTheWeek' => $this->daysOfTheWeek,
            'wage' => $this->wage,
            'wageDuration' => $this->wageDuration,
            'locationAddress' => $this->locationAddress,
            'locationCity' => $this->locationCity,
            'locationState' => $this->locationState,
            'locationZip' => $this->locationZip,
            'supervisorName' => $this->supervisorName,
            'supervisorPhone' => $this->supervisorPhone,
            'contactPhone' => $this->contactPhone,
            'valediction' => $this->valediction,
            'ccLine1' => $this->ccLine1,
            'ccLine2' => $this->ccLine2,
            'ccLine3' => $this->ccLine3,
        ];
    }

    /**
     * Save current form as a preset.
     */
    public function savePreset(): void
    {
        $storage = new PresetStorage();

        // If we have an active preset, update it; otherwise create new
        $token = $this->hasActivePreset ? $this->presetToken : null;

        $this->presetToken = $storage->save('offer-letter', $this->getFormDataForPreset(), $token);
        $this->hasActivePreset = true;

        // Dispatch browser event to show the shareable URL
        $this->dispatch('preset-saved', url: url('/offer-letter?preset=' . $this->presetToken));
    }

    /**
     * Clear form and start fresh (removes preset association).
     */
    public function clearForm(): void
    {
        $this->reset();
        $this->mount();
        $this->presetToken = '';
        $this->hasActivePreset = false;
    }

    /**
     * Get the current date formatted.
     */
    #[Computed]
    public function formattedDate(): string
    {
        return Carbon::now()->format('F j, Y');
    }

    /**
     * Get formatted days of the week string.
     */
    #[Computed]
    public function formattedDaysOfWeek(): string
    {
        if (empty($this->daysOfTheWeek)) {
            return '';
        }

        $days = $this->daysOfTheWeek;
        $count = count($days);

        if ($count === 1) {
            return $days[0];
        }

        if ($count === 2) {
            return implode(' and ', $days);
        }

        // Check for consecutive days like Monday-Friday
        $dayOrder = array_flip(self::DAYS_OF_WEEK);
        $indices = array_map(fn ($d) => $dayOrder[$d] ?? 99, $days);
        sort($indices);

        $isConsecutive = true;
        for ($i = 1; $i < count($indices); $i++) {
            if ($indices[$i] !== $indices[$i - 1] + 1) {
                $isConsecutive = false;
                break;
            }
        }

        if ($isConsecutive && $count >= 3) {
            return self::DAYS_OF_WEEK[$indices[0]].' through '.self::DAYS_OF_WEEK[$indices[count($indices) - 1]];
        }

        $last = array_pop($days);

        return implode(', ', $days).' and '.$last;
    }

    /**
     * Get template data for rendering.
     *
     * @return array<string, mixed>
     */
    #[Computed]
    public function templateData(): array
    {
        return [
            'date' => $this->formattedDate,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'address_one' => $this->addressOne,
            'address_two' => $this->addressTwo,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'claim_no' => $this->claimNo,
            'work_date' => $this->workDate ? Carbon::parse($this->workDate)->format('F j, Y') : '',
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'hours_per_week' => $this->hoursPerWeek,
            'days_of_the_week' => $this->formattedDaysOfWeek,
            'wage' => $this->wage,
            'wage_duration' => $this->wageDuration,
            'location_address' => $this->locationAddress,
            'location_city' => $this->locationCity,
            'supervisor_name' => $this->supervisorName,
            'supervisor_phone' => $this->supervisorPhone,
            'contact_phone' => $this->contactPhone,
            'valediction' => $this->valediction,
            'cc_line_1' => $this->ccLine1,
            'cc_line_2' => $this->ccLine2,
            'cc_line_3' => $this->ccLine3,
        ];
    }

    /**
     * Get the template view name based on language and job type.
     */
    #[Computed]
    public function templateName(): string
    {
        return "offer-letter.templates.{$this->language}-{$this->jobType}";
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'honeypot.size' => 'Spam detected.',
            'firstName.required' => 'First name is required.',
            'lastName.required' => 'Last name is required.',
            'addressOne.required' => 'Address is required.',
            'city.required' => 'City is required.',
            'state.required' => 'State is required.',
            'state.size' => 'State must be a 2-letter code.',
            'zip.required' => 'ZIP code is required.',
            'claimNo.required' => 'L&I Claim number is required.',
            'drApprovalDate.required' => "Doctor's approval date is required.",
            'workDate.required' => 'Report to work date is required.',
            'startTime.required' => 'Start time is required.',
            'endTime.required' => 'End time is required.',
            'hoursPerWeek.required' => 'Hours per week is required.',
            'hoursPerWeek.min' => 'Hours per week must be at least 1.',
            'hoursPerWeek.max' => 'Hours per week cannot exceed 168.',
            'daysOfTheWeek.required' => 'Please select at least one work day.',
            'daysOfTheWeek.min' => 'Please select at least one work day.',
            'wage.required' => 'Wage amount is required.',
            'wage.numeric' => 'Wage must be a number.',
            'wageDuration.required' => 'Wage duration is required.',
            'locationAddress.required' => 'Work location address is required.',
            'locationCity.required' => 'Work location city is required.',
            'locationState.required' => 'Work location state is required.',
            'locationZip.required' => 'Work location ZIP is required.',
            'supervisorName.required' => 'Supervisor name is required.',
            'supervisorPhone.required' => 'Supervisor phone is required.',
            'contactPhone.required' => 'Contact phone is required.',
            'valediction.required' => 'Your name is required for the signature.',
        ];
    }

    /**
     * Generate the letter preview.
     */
    public function generatePreview(): void
    {
        $this->validate();
        $this->showPreview = true;
    }

    /**
     * Go back to the form from preview.
     */
    public function backToForm(): void
    {
        $this->showPreview = false;
    }

    /**
     * Reset the form to defaults.
     */
    public function resetForm(): void
    {
        $this->reset();
        $this->mount();
        $this->showPreview = false;
    }

    /**
     * Download the letter as PDF.
     */
    public function downloadPdf(): StreamedResponse
    {
        $this->validate();

        $templateName = "{$this->language}-{$this->jobType}";

        $pdfService = new OfferLetterPdfService();
        $pdfContent = $pdfService->generate($templateName, $this->templateData);

        // Log form completion
        DB::table('form_completions')->insert([
            'form_type' => 'offer-letter',
            'language' => $this->language,
            'created_at' => now(),
        ]);

        $filename = 'OfferLetter_'.str_replace(' ', '_', $this->lastName).'_'.date('Y-m-d').'.pdf';

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
        return view('livewire.offer-letter.offer-letter-form');
    }
}
