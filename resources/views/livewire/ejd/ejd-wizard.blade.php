<div class="max-w-4xl mx-auto">
    {{-- Page Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">
            Essential Job Description Form
        </h1>
        <p class="mt-2 text-gray-600">
            Complete all steps to generate your Essential Job Description document.
        </p>
    </div>

    {{-- Progress Indicator --}}
    <div class="mb-8">
        @include('livewire.ejd.partials.progress-indicator')
    </div>

    {{-- Step Content Card --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        {{-- Step Header --}}
        <div class="bg-primary-50 border-b border-primary-100 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-primary-900">
                        Step {{ $currentStep }}: {{ $this->currentStepInfo['title'] }}
                    </h2>
                    <p class="text-sm text-primary-700 mt-1">
                        {{ $this->currentStepInfo['description'] }}
                    </p>
                </div>
                <div class="text-sm text-primary-600">
                    {{ $currentStep }} of {{ self::TOTAL_STEPS }}
                </div>
            </div>
        </div>

        {{-- Step Content --}}
        <div class="p-6">
            {{-- Validation Errors Summary --}}
            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4" role="alert" aria-live="polite">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Step Content Based on Current Step --}}
            @switch($currentStep)
                @case(1)
                    @include('livewire.ejd.steps.step-1-employer-worker')
                    @break
                @case(2)
                    @include('livewire.ejd.steps.step-2-job-selection')
                    @break
                @case(3)
                    @include('livewire.ejd.steps.step-3-task-selection')
                    @break
                @case(4)
                    @include('livewire.ejd.steps.step-4-physical-demands')
                    @break
                @case(5)
                    @include('livewire.ejd.steps.step-5-preview')
                    @break
            @endswitch
        </div>

        {{-- Navigation Footer --}}
        <div class="bg-gray-50 border-t border-gray-200 px-6 py-4">
            <div class="flex items-center justify-between">
                {{-- Back Button --}}
                <div>
                    @if ($currentStep > 1)
                        <button
                            type="button"
                            wire:click="previousStep"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors"
                        >
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Previous
                        </button>
                    @else
                        <span></span>
                    @endif
                </div>

                {{-- Next/Submit Button --}}
                <div class="flex items-center space-x-3">
                    @if ($currentStep < self::TOTAL_STEPS)
                        <button
                            type="button"
                            wire:click="nextStep"
                            wire:loading.attr="disabled"
                            wire:loading.class="opacity-75 cursor-wait"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors disabled:opacity-50"
                        >
                            <span wire:loading.remove wire:target="nextStep">Continue</span>
                            <span wire:loading wire:target="nextStep">Processing...</span>
                            <svg wire:loading.remove wire:target="nextStep" class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                            <svg wire:loading wire:target="nextStep" class="animate-spin w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    @else
                        {{-- Final step buttons will be in the step-5 view --}}
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Reset Form Link --}}
    <div class="mt-6 text-center">
        <button
            type="button"
            wire:click="resetWizard"
            wire:confirm="Are you sure you want to reset the form? All entered data will be lost."
            class="text-sm text-gray-500 hover:text-gray-700 underline"
        >
            Start Over
        </button>
    </div>
</div>
