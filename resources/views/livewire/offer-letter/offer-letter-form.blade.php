<div class="space-y-6"
     x-data="{
         showPresetModal: false,
         presetUrl: '',
         copied: false,
         copyUrl() {
             navigator.clipboard.writeText(this.presetUrl);
             this.copied = true;
             setTimeout(() => this.copied = false, 2000);
         }
     }"
     @preset-saved.window="presetUrl = $event.detail.url; showPresetModal = true">

    {{-- Preset Modal --}}
    <div x-show="showPresetModal"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         aria-labelledby="preset-modal-title"
         role="dialog"
         aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showPresetModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                 @click="showPresetModal = false"></div>

            <div x-show="showPresetModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full sm:p-6">
                <div>
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="preset-modal-title">
                            Preset Saved
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Use this link to reload the form with these values:
                            </p>
                        </div>
                        <div class="mt-4">
                            <div class="flex rounded-md shadow-sm">
                                <input type="text"
                                       readonly
                                       x-model="presetUrl"
                                       class="flex-1 min-w-0 block w-full px-3 py-2 rounded-l-md border border-gray-300 bg-gray-50 text-sm text-gray-700 focus:outline-none">
                                <button type="button"
                                        @click="copyUrl()"
                                        class="inline-flex items-center px-4 py-2 border border-l-0 border-gray-300 rounded-r-md bg-gray-50 text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                    <span x-show="!copied">Copy</span>
                                    <span x-show="copied" class="text-green-600">Copied!</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6">
                    <button type="button"
                            @click="showPresetModal = false"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:text-sm">
                        Done
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Skip Link for Keyboard Users --}}
    <a
        href="#main-form"
        class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:px-4 focus:py-2 focus:bg-primary-600 focus:text-white focus:rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
    >
        Skip to main form
    </a>

    {{-- Live Region for Screen Reader Announcements --}}
    <div
        id="form-announcements"
        class="sr-only"
        role="status"
        aria-live="polite"
        aria-atomic="true"
    ></div>

    {{-- Page Header --}}
    <header class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Return to Work Offer Letter</h1>
                <p class="mt-2 text-gray-600">Generate an offer letter for an injured worker returning to work. Available in English, Spanish, and Russian.</p>
                <p class="mt-1 text-sm text-gray-500">
                    <span class="text-red-500" aria-hidden="true">*</span>
                    <span class="sr-only">Asterisk</span> indicates required field
                </p>
            </div>
            {{-- Preset Actions (subtle, for power users) --}}
            <div class="flex items-center gap-4 text-sm print:hidden">
                @if($hasActivePreset)
                    <span class="text-gray-500 text-xs">
                        Preset: {{ $presetToken }}
                    </span>
                @endif
                <button type="button"
                        wire:click="savePreset"
                        class="text-gray-500 hover:text-primary-600 transition-colors flex items-center gap-1 cursor-pointer"
                        title="Save form as shareable preset">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    {{ $hasActivePreset ? 'Update Preset' : 'Save Preset' }}
                </button>
                @if($firstName || $lastName || $locationAddress)
                    <button type="button"
                            wire:click="clearForm"
                            wire:confirm="Clear all form fields?"
                            class="text-gray-400 hover:text-red-500 transition-colors flex items-center gap-1 cursor-pointer"
                            title="Clear form">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Clear
                    </button>
                @endif
            </div>
        </div>
    </header>

    @if($showPreview)
        {{-- Letter Preview --}}
        <main id="main-form" role="main" aria-label="Letter preview" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Letter Preview</h2>
                <div class="flex gap-3" role="group" aria-label="Preview actions">
                    <button
                        type="button"
                        wire:click="backToForm"
                        class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                    >
                        <span aria-hidden="true">&larr;</span> Edit Form
                    </button>
                    <button
                        type="button"
                        wire:click="downloadPdf"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center px-4 py-2 text-white bg-primary-600 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:opacity-50"
                    >
                        <svg class="w-4 h-4 mr-2" wire:loading.remove wire:target="downloadPdf" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <svg class="w-4 h-4 mr-2 animate-spin" wire:loading wire:target="downloadPdf" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="downloadPdf">Download PDF</span>
                        <span wire:loading wire:target="downloadPdf">Generating...</span>
                    </button>
                    <button
                        type="button"
                        onclick="window.print()"
                        class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                    >
                        Print
                    </button>
                </div>
            </div>

            {{-- Print Notice --}}
            <div role="alert" class="mb-4 p-3 bg-amber-50 border border-amber-200 rounded-md text-amber-800 text-sm print:hidden">
                <strong>Note:</strong> A legal offer requires personal or certified mail delivery.
            </div>

            {{-- Letter Content --}}
            <article class="prose max-w-none border border-gray-200 rounded-lg p-8 bg-white print:border-none print:p-0" aria-label="Generated offer letter">
                @include($this->templateName, $this->templateData)
            </article>
        </main>
    @else
        {{-- Form --}}
        <form
            wire:submit="generatePreview"
            id="main-form"
            role="form"
            aria-label="Return to Work Offer Letter form"
            class="space-y-6"
            novalidate
        >
            {{-- Error Summary (appears when there are validation errors) --}}
            @if($errors->any())
                <div
                    role="alert"
                    aria-labelledby="error-summary-heading"
                    class="bg-red-50 border border-red-200 rounded-lg p-4"
                >
                    <h2 id="error-summary-heading" class="text-red-800 font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        Please correct the following errors:
                    </h2>
                    <ul class="mt-2 list-disc list-inside text-sm text-red-700 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Honeypot --}}
            <div class="hidden" aria-hidden="true">
                <input type="text" name="honeypot" wire:model="honeypot" tabindex="-1" autocomplete="off">
            </div>

            {{-- Letter Type & Language Selection --}}
            <section class="bg-white rounded-lg shadow-sm border border-gray-200 p-6" aria-labelledby="letter-options-heading">
                <h2 id="letter-options-heading" class="text-lg font-semibold text-gray-900 mb-4">Letter Options</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Job Type --}}
                    <fieldset>
                        <legend class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> Job Type
                        </legend>
                        <div class="space-y-2" role="radiogroup" aria-required="true">
                            @foreach(self::JOB_TYPES as $value => $label)
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input
                                        type="radio"
                                        name="jobType"
                                        id="jobType-{{ $value }}"
                                        value="{{ $value }}"
                                        wire:model="jobType"
                                        class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500 focus:ring-2"
                                    >
                                    <span class="text-gray-900">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>

                    {{-- Language --}}
                    <div>
                        <label for="language" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> Letter Language
                        </label>
                        <select
                            id="language"
                            wire:model="language"
                            aria-required="true"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2"
                        >
                            @foreach(self::LANGUAGES as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>

            {{-- Worker Information --}}
            <section class="bg-white rounded-lg shadow-sm border border-gray-200 p-6" aria-labelledby="worker-info-heading">
                <h2 id="worker-info-heading" class="text-lg font-semibold text-gray-900 mb-4">Injured Worker's Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- First Name --}}
                    <div>
                        <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> First Name
                        </label>
                        <input
                            type="text"
                            id="firstName"
                            wire:model="firstName"
                            autocomplete="given-name"
                            aria-required="true"
                            aria-invalid="{{ $errors->has('firstName') ? 'true' : 'false' }}"
                            @if($errors->has('firstName')) aria-describedby="firstName-error" @endif
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2 @error('firstName') border-red-500 @enderror"
                        >
                        @error('firstName')
                            <p id="firstName-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Last Name --}}
                    <div>
                        <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> Last Name
                        </label>
                        <input
                            type="text"
                            id="lastName"
                            wire:model="lastName"
                            autocomplete="family-name"
                            aria-required="true"
                            aria-invalid="{{ $errors->has('lastName') ? 'true' : 'false' }}"
                            @if($errors->has('lastName')) aria-describedby="lastName-error" @endif
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2 @error('lastName') border-red-500 @enderror"
                        >
                        @error('lastName')
                            <p id="lastName-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- L&I Claim Number --}}
                    <div>
                        <label for="claimNo" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> L & I Claim #
                        </label>
                        <input
                            type="text"
                            id="claimNo"
                            wire:model="claimNo"
                            aria-required="true"
                            aria-invalid="{{ $errors->has('claimNo') ? 'true' : 'false' }}"
                            @if($errors->has('claimNo')) aria-describedby="claimNo-error" @endif
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2 @error('claimNo') border-red-500 @enderror"
                        >
                        @error('claimNo')
                            <p id="claimNo-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Address 1 --}}
                    <div>
                        <label for="addressOne" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> Address 1
                        </label>
                        <input
                            type="text"
                            id="addressOne"
                            wire:model="addressOne"
                            autocomplete="address-line1"
                            aria-required="true"
                            aria-invalid="{{ $errors->has('addressOne') ? 'true' : 'false' }}"
                            @if($errors->has('addressOne')) aria-describedby="addressOne-error" @endif
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2 @error('addressOne') border-red-500 @enderror"
                        >
                        @error('addressOne')
                            <p id="addressOne-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Address 2 --}}
                    <div>
                        <label for="addressTwo" class="block text-sm font-medium text-gray-700 mb-1">
                            Address 2 <span class="text-gray-500">(optional)</span>
                        </label>
                        <input
                            type="text"
                            id="addressTwo"
                            wire:model="addressTwo"
                            autocomplete="address-line2"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2"
                        >
                    </div>

                    {{-- City --}}
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> City
                        </label>
                        <input
                            type="text"
                            id="city"
                            wire:model="city"
                            autocomplete="address-level2"
                            aria-required="true"
                            aria-invalid="{{ $errors->has('city') ? 'true' : 'false' }}"
                            @if($errors->has('city')) aria-describedby="city-error" @endif
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2 @error('city') border-red-500 @enderror"
                        >
                        @error('city')
                            <p id="city-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- State --}}
                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> State
                        </label>
                        <select
                            id="state"
                            wire:model="state"
                            autocomplete="address-level1"
                            aria-required="true"
                            aria-invalid="{{ $errors->has('state') ? 'true' : 'false' }}"
                            @if($errors->has('state')) aria-describedby="state-error" @endif
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2 @error('state') border-red-500 @enderror"
                        >
                            <option value="">Select State</option>
                            @foreach(self::STATES as $abbr => $name)
                                <option value="{{ $abbr }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('state')
                            <p id="state-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ZIP --}}
                    <div>
                        <label for="zip" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> ZIP Code
                        </label>
                        <input
                            type="text"
                            id="zip"
                            wire:model="zip"
                            maxlength="10"
                            autocomplete="postal-code"
                            inputmode="numeric"
                            aria-required="true"
                            aria-invalid="{{ $errors->has('zip') ? 'true' : 'false' }}"
                            @if($errors->has('zip')) aria-describedby="zip-error" @endif
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2 @error('zip') border-red-500 @enderror"
                        >
                        @error('zip')
                            <p id="zip-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Dates --}}
            <section class="bg-white rounded-lg shadow-sm border border-gray-200 p-6" aria-labelledby="dates-heading">
                <h2 id="dates-heading" class="text-lg font-semibold text-gray-900 mb-4">Dates</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Doctor's Approval Date --}}
                    <div>
                        <label for="drApprovalDate" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> Doctor's Approval Date
                        </label>
                        <input
                            type="date"
                            id="drApprovalDate"
                            wire:model="drApprovalDate"
                            aria-required="true"
                            aria-invalid="{{ $errors->has('drApprovalDate') ? 'true' : 'false' }}"
                            @if($errors->has('drApprovalDate')) aria-describedby="drApprovalDate-error" @endif
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2 @error('drApprovalDate') border-red-500 @enderror"
                        >
                        @error('drApprovalDate')
                            <p id="drApprovalDate-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Report to Work Date --}}
                    <div>
                        <label for="workDate" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> Report to Work Date
                        </label>
                        <input
                            type="date"
                            id="workDate"
                            wire:model="workDate"
                            aria-required="true"
                            aria-invalid="{{ $errors->has('workDate') ? 'true' : 'false' }}"
                            @if($errors->has('workDate')) aria-describedby="workDate-error" @endif
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2 @error('workDate') border-red-500 @enderror"
                        >
                        @error('workDate')
                            <p id="workDate-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Working Hours and Days --}}
            <section class="bg-white rounded-lg shadow-sm border border-gray-200 p-6" aria-labelledby="hours-days-heading">
                <h2 id="hours-days-heading" class="text-lg font-semibold text-gray-900 mb-4">Working Hours and Days</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Start Time --}}
                    <div>
                        <label for="startTime" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> Start Time
                        </label>
                        <input
                            type="time"
                            id="startTime"
                            wire:model="startTime"
                            aria-required="true"
                            aria-invalid="{{ $errors->has('startTime') ? 'true' : 'false' }}"
                            @if($errors->has('startTime')) aria-describedby="startTime-error" @endif
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2 @error('startTime') border-red-500 @enderror"
                        >
                        @error('startTime')
                            <p id="startTime-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- End Time --}}
                    <div>
                        <label for="endTime" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> End Time
                        </label>
                        <input
                            type="time"
                            id="endTime"
                            wire:model="endTime"
                            aria-required="true"
                            aria-invalid="{{ $errors->has('endTime') ? 'true' : 'false' }}"
                            @if($errors->has('endTime')) aria-describedby="endTime-error" @endif
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2 @error('endTime') border-red-500 @enderror"
                        >
                        @error('endTime')
                            <p id="endTime-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Hours Per Week --}}
                    <div>
                        <label for="hoursPerWeek" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> Hours Per Week
                        </label>
                        <input
                            type="number"
                            id="hoursPerWeek"
                            wire:model="hoursPerWeek"
                            min="1"
                            max="168"
                            inputmode="numeric"
                            aria-required="true"
                            aria-invalid="{{ $errors->has('hoursPerWeek') ? 'true' : 'false' }}"
                            @if($errors->has('hoursPerWeek')) aria-describedby="hoursPerWeek-error" @endif
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2 @error('hoursPerWeek') border-red-500 @enderror"
                        >
                        @error('hoursPerWeek')
                            <p id="hoursPerWeek-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Days of the Week --}}
                    <fieldset class="md:col-span-2">
                        <legend class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> Days of the Week
                            <span class="sr-only">(select at least one)</span>
                        </legend>
                        <div class="flex flex-wrap gap-4" role="group" aria-required="true">
                            @foreach(self::DAYS_OF_WEEK as $day)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        id="day-{{ Str::slug($day) }}"
                                        value="{{ $day }}"
                                        wire:model="daysOfTheWeek"
                                        class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500 focus:ring-2"
                                    >
                                    <span class="text-gray-900">{{ $day }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('daysOfTheWeek')
                            <p id="daysOfTheWeek-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </fieldset>
                </div>
            </section>

            {{-- Wages --}}
            <section class="bg-white rounded-lg shadow-sm border border-gray-200 p-6" aria-labelledby="wages-heading">
                <h2 id="wages-heading" class="text-lg font-semibold text-gray-900 mb-4">Wages</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Dollar Amount --}}
                    <div>
                        <label for="wage" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> Dollar Amount
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500" aria-hidden="true">$</span>
                            <input
                                type="text"
                                id="wage"
                                wire:model="wage"
                                placeholder="0.00"
                                inputmode="decimal"
                                aria-required="true"
                                aria-invalid="{{ $errors->has('wage') ? 'true' : 'false' }}"
                                aria-describedby="wage-prefix{{ $errors->has('wage') ? ' wage-error' : '' }}"
                                class="w-full pl-8 rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2 @error('wage') border-red-500 @enderror"
                                x-on:blur="if ($el.value && !isNaN(parseFloat($el.value))) $el.value = parseFloat($el.value).toFixed(2)"
                            >
                            <span id="wage-prefix" class="sr-only">Dollar amount in USD</span>
                        </div>
                        @error('wage')
                            <p id="wage-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Per --}}
                    <div>
                        <label for="wageDuration" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> Per
                        </label>
                        <select
                            id="wageDuration"
                            wire:model="wageDuration"
                            aria-required="true"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2"
                        >
                            @foreach(self::WAGE_DURATIONS as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>

            {{-- Work Location --}}
            <section class="bg-white rounded-lg shadow-sm border border-gray-200 p-6" aria-labelledby="work-location-heading">
                <h2 id="work-location-heading" class="text-lg font-semibold text-gray-900 mb-4">Work Location</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Location Address --}}
                    <div>
                        <label for="locationAddress" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> Location Address
                        </label>
                        <input
                            type="text"
                            id="locationAddress"
                            wire:model="locationAddress"
                            aria-required="true"
                            aria-invalid="{{ $errors->has('locationAddress') ? 'true' : 'false' }}"
                            @if($errors->has('locationAddress')) aria-describedby="locationAddress-error" @endif
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2 @error('locationAddress') border-red-500 @enderror"
                        >
                        @error('locationAddress')
                            <p id="locationAddress-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Location City --}}
                    <div>
                        <label for="locationCity" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> Location City
                        </label>
                        <input
                            type="text"
                            id="locationCity"
                            wire:model="locationCity"
                            aria-required="true"
                            aria-invalid="{{ $errors->has('locationCity') ? 'true' : 'false' }}"
                            @if($errors->has('locationCity')) aria-describedby="locationCity-error" @endif
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2 @error('locationCity') border-red-500 @enderror"
                        >
                        @error('locationCity')
                            <p id="locationCity-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Location State --}}
                    <div>
                        <label for="locationState" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> Location State
                        </label>
                        <select
                            id="locationState"
                            wire:model="locationState"
                            aria-required="true"
                            aria-invalid="{{ $errors->has('locationState') ? 'true' : 'false' }}"
                            @if($errors->has('locationState')) aria-describedby="locationState-error" @endif
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2 @error('locationState') border-red-500 @enderror"
                        >
                            <option value="">Select State</option>
                            @foreach(self::STATES as $abbr => $name)
                                <option value="{{ $abbr }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('locationState')
                            <p id="locationState-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Location ZIP --}}
                    <div>
                        <label for="locationZip" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> Location ZIP Code
                        </label>
                        <input
                            type="text"
                            id="locationZip"
                            wire:model="locationZip"
                            maxlength="10"
                            inputmode="numeric"
                            aria-required="true"
                            aria-invalid="{{ $errors->has('locationZip') ? 'true' : 'false' }}"
                            @if($errors->has('locationZip')) aria-describedby="locationZip-error" @endif
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2 @error('locationZip') border-red-500 @enderror"
                        >
                        @error('locationZip')
                            <p id="locationZip-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- Supervisor/Contact Information --}}
            <section class="bg-white rounded-lg shadow-sm border border-gray-200 p-6" aria-labelledby="supervisor-heading">
                <h2 id="supervisor-heading" class="text-lg font-semibold text-gray-900 mb-4">Supervisor & Contact Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Supervisor Name --}}
                    <div>
                        <label for="supervisorName" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> Supervisor Name
                        </label>
                        <input
                            type="text"
                            id="supervisorName"
                            wire:model="supervisorName"
                            autocomplete="name"
                            aria-required="true"
                            aria-invalid="{{ $errors->has('supervisorName') ? 'true' : 'false' }}"
                            @if($errors->has('supervisorName')) aria-describedby="supervisorName-error" @endif
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2 @error('supervisorName') border-red-500 @enderror"
                        >
                        @error('supervisorName')
                            <p id="supervisorName-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Supervisor Phone --}}
                    <div
                        x-data="phoneInput('{{ $supervisorPhone }}')"
                        x-init="$watch('phone', value => $wire.set('supervisorPhone', value))"
                    >
                        <label for="supervisorPhone" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> Supervisor Phone #
                        </label>
                        <input
                            type="tel"
                            id="supervisorPhone"
                            x-model="phone"
                            x-on:input="format($event)"
                            placeholder="(555) 555-5555"
                            autocomplete="tel"
                            aria-required="true"
                            aria-invalid="{{ $errors->has('supervisorPhone') ? 'true' : 'false' }}"
                            aria-describedby="supervisorPhone-hint{{ $errors->has('supervisorPhone') ? ' supervisorPhone-error' : '' }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2 @error('supervisorPhone') border-red-500 @enderror"
                        >
                        <p id="supervisorPhone-hint" class="mt-1 text-xs text-gray-500">Format: (555) 555-5555</p>
                        @error('supervisorPhone')
                            <p id="supervisorPhone-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Contact Phone --}}
                    <div
                        x-data="phoneInput('{{ $contactPhone }}')"
                        x-init="$watch('phone', value => $wire.set('contactPhone', value))"
                    >
                        <label for="contactPhone" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> Contact Phone #
                        </label>
                        <input
                            type="tel"
                            id="contactPhone"
                            x-model="phone"
                            x-on:input="format($event)"
                            placeholder="(555) 555-5555"
                            autocomplete="tel"
                            aria-required="true"
                            aria-invalid="{{ $errors->has('contactPhone') ? 'true' : 'false' }}"
                            aria-describedby="contactPhone-hint{{ $errors->has('contactPhone') ? ' contactPhone-error' : '' }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2 @error('contactPhone') border-red-500 @enderror"
                        >
                        <p id="contactPhone-hint" class="mt-1 text-xs text-gray-500">Format: (555) 555-5555</p>
                        @error('contactPhone')
                            <p id="contactPhone-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Your Name (Valediction) --}}
                    <div>
                        <label for="valediction" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500" aria-hidden="true">*</span>
                            <span class="sr-only">Required:</span> Your Name (for signature)
                        </label>
                        <input
                            type="text"
                            id="valediction"
                            wire:model="valediction"
                            autocomplete="name"
                            aria-required="true"
                            aria-invalid="{{ $errors->has('valediction') ? 'true' : 'false' }}"
                            @if($errors->has('valediction')) aria-describedby="valediction-error" @endif
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2 @error('valediction') border-red-500 @enderror"
                        >
                        @error('valediction')
                            <p id="valediction-error" class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            {{-- CC Recipients --}}
            <section class="bg-white rounded-lg shadow-sm border border-gray-200 p-6" aria-labelledby="cc-heading">
                <h2 id="cc-heading" class="text-lg font-semibold text-gray-900 mb-4">Cc (Optional)</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- CC Line 1 --}}
                    <div>
                        <label for="ccLine1" class="block text-sm font-medium text-gray-700 mb-1">
                            Cc Line 1 <span class="text-gray-500">(optional)</span>
                        </label>
                        <input
                            type="text"
                            id="ccLine1"
                            wire:model="ccLine1"
                            placeholder="Claim's Manager w/encl."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2"
                        >
                    </div>

                    {{-- CC Line 2 --}}
                    <div>
                        <label for="ccLine2" class="block text-sm font-medium text-gray-700 mb-1">
                            Cc Line 2 <span class="text-gray-500">(optional)</span>
                        </label>
                        <input
                            type="text"
                            id="ccLine2"
                            wire:model="ccLine2"
                            placeholder="Physician w/encl."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2"
                        >
                    </div>

                    {{-- CC Line 3 --}}
                    <div>
                        <label for="ccLine3" class="block text-sm font-medium text-gray-700 mb-1">
                            Cc Line 3 <span class="text-gray-500">(optional)</span>
                        </label>
                        <input
                            type="text"
                            id="ccLine3"
                            wire:model="ccLine3"
                            placeholder="Additional cc"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 focus:ring-2"
                        >
                    </div>
                </div>
            </section>

            {{-- Form Actions --}}
            <div class="flex justify-end gap-4" role="group" aria-label="Form actions">
                <button
                    type="button"
                    wire:click="resetForm"
                    class="px-6 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors"
                >
                    Reset Form
                </button>
                <button
                    type="submit"
                    class="px-6 py-2 text-white bg-primary-600 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors"
                >
                    Generate Letter
                </button>
            </div>
        </form>
    @endif

    {{-- Print Styles and Accessibility Enhancements --}}
    <style>
        /* Enhanced focus styles for accessibility */
        input:focus-visible,
        select:focus-visible,
        button:focus-visible,
        [type="checkbox"]:focus-visible,
        [type="radio"]:focus-visible {
            outline: 2px solid #3b82f6;
            outline-offset: 2px;
        }

        /* High contrast focus for checkboxes and radios */
        [type="checkbox"]:focus-visible + span,
        [type="radio"]:focus-visible + span {
            text-decoration: underline;
        }

        /* Reduce motion for users who prefer it */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* Print styles */
        @media print {
            header, footer, .print\:hidden {
                display: none !important;
            }
            body {
                background: white !important;
            }
            .prose {
                max-width: none !important;
            }
            .page-break-after {
                page-break-after: always;
            }
            .print-only {
                display: block !important;
            }
        }
        @media screen {
            .print-only {
                display: none !important;
            }
        }
        .cc-list {
            list-style: none;
            padding-left: 0;
        }
    </style>

    {{-- Phone Input Formatting Component --}}
    <script>
        /**
         * Alpine.js component for US phone number formatting
         * Formats input as (555) 555-5555 while preserving cursor position
         */
        document.addEventListener('alpine:init', () => {
            Alpine.data('phoneInput', (initialValue = '') => ({
                phone: initialValue,

                /**
                 * Format phone number as user types
                 * Handles cursor position intelligently
                 */
                format(event) {
                    const input = event.target;
                    const cursorPosition = input.selectionStart;
                    const previousLength = this.phone.length;

                    // Strip all non-digits
                    let digits = input.value.replace(/\D/g, '');

                    // Limit to 10 digits (US phone number)
                    digits = digits.substring(0, 10);

                    // Format the number
                    let formatted = '';
                    if (digits.length > 0) {
                        formatted = '(' + digits.substring(0, 3);
                    }
                    if (digits.length >= 3) {
                        formatted += ') ' + digits.substring(3, 6);
                    }
                    if (digits.length >= 6) {
                        formatted += '-' + digits.substring(6, 10);
                    }

                    this.phone = formatted;

                    // Adjust cursor position after formatting
                    this.$nextTick(() => {
                        const newLength = formatted.length;
                        const lengthDiff = newLength - previousLength;

                        // Calculate new cursor position
                        let newCursor = cursorPosition + lengthDiff;

                        // Handle special positions (after formatting characters)
                        if (cursorPosition === 1 && lengthDiff > 0) {
                            newCursor = 2; // After opening paren
                        } else if (cursorPosition === 4 && digits.length >= 3) {
                            newCursor = 6; // After ") "
                        } else if (cursorPosition === 9 && digits.length >= 6) {
                            newCursor = 10; // After "-"
                        }

                        // Ensure cursor stays within bounds
                        newCursor = Math.max(0, Math.min(newCursor, newLength));

                        input.setSelectionRange(newCursor, newCursor);
                    });
                }
            }));
        });
    </script>

    {{-- Keyboard Navigation Enhancement Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Announce errors to screen readers when form is submitted
            const form = document.getElementById('main-form');
            if (form) {
                form.addEventListener('submit', function() {
                    setTimeout(function() {
                        const errorSummary = document.querySelector('[role="alert"]');
                        if (errorSummary) {
                            const announcements = document.getElementById('form-announcements');
                            if (announcements) {
                                const errorCount = document.querySelectorAll('[role="alert"]').length;
                                announcements.textContent = 'Form has ' + errorCount + ' error(s). Please review and correct.';
                            }
                            // Focus on first error field
                            const firstError = document.querySelector('[aria-invalid="true"]');
                            if (firstError) {
                                firstError.focus();
                            }
                        }
                    }, 100);
                });
            }

            // Escape key to close preview and return to form
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const backButton = document.querySelector('[wire\\:click="backToForm"]');
                    if (backButton) {
                        backButton.click();
                    }
                }
            });
        });
    </script>
</div>
