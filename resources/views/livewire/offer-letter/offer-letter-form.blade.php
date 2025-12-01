<div class="space-y-6">
    {{-- Page Header --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h1 class="text-2xl font-bold text-gray-900">Return to Work Offer Letter</h1>
        <p class="mt-2 text-gray-600">Generate an offer letter for an injured worker returning to work. Available in English, Spanish, and Russian.</p>
    </div>

    @if($showPreview)
        {{-- Letter Preview --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Letter Preview</h2>
                <div class="flex gap-3">
                    <button
                        type="button"
                        wire:click="backToForm"
                        class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                    >
                        Edit Form
                    </button>
                    <button
                        type="button"
                        onclick="window.print()"
                        class="px-4 py-2 text-white bg-primary-600 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                    >
                        Print Letter
                    </button>
                </div>
            </div>

            {{-- Print Notice --}}
            <div class="mb-4 p-3 bg-amber-50 border border-amber-200 rounded-md text-amber-800 text-sm print:hidden">
                <strong>Note:</strong> A legal offer requires personal or certified mail delivery.
            </div>

            {{-- Letter Content --}}
            <div class="prose max-w-none border border-gray-200 rounded-lg p-8 bg-white print:border-none print:p-0">
                @include($this->templateName, $this->templateData)
            </div>
        </div>
    @else
        {{-- Form --}}
        <form wire:submit="generatePreview" class="space-y-6">
            {{-- Honeypot --}}
            <div class="hidden" aria-hidden="true">
                <input type="text" name="honeypot" wire:model="honeypot" tabindex="-1" autocomplete="off">
            </div>

            {{-- Letter Type & Language Selection --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Letter Options</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Job Type --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="text-red-500">*</span> Job Type
                        </label>
                        <div class="space-y-2">
                            @foreach(self::JOB_TYPES as $value => $label)
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <input
                                        type="radio"
                                        name="jobType"
                                        value="{{ $value }}"
                                        wire:model="jobType"
                                        class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500"
                                    >
                                    <span class="text-gray-900">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Language --}}
                    <div>
                        <label for="language" class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="text-red-500">*</span> Letter Language
                        </label>
                        <select
                            id="language"
                            wire:model="language"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                        >
                            @foreach(self::LANGUAGES as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Worker Information --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Injured Worker's Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- First Name --}}
                    <div>
                        <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> First Name
                        </label>
                        <input
                            type="text"
                            id="firstName"
                            wire:model="firstName"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('firstName') border-red-500 @enderror"
                        >
                        @error('firstName')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Last Name --}}
                    <div>
                        <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> Last Name
                        </label>
                        <input
                            type="text"
                            id="lastName"
                            wire:model="lastName"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('lastName') border-red-500 @enderror"
                        >
                        @error('lastName')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- L&I Claim Number --}}
                    <div>
                        <label for="claimNo" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> L & I Claim #
                        </label>
                        <input
                            type="text"
                            id="claimNo"
                            wire:model="claimNo"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('claimNo') border-red-500 @enderror"
                        >
                        @error('claimNo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Address 1 --}}
                    <div>
                        <label for="addressOne" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> Address 1
                        </label>
                        <input
                            type="text"
                            id="addressOne"
                            wire:model="addressOne"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('addressOne') border-red-500 @enderror"
                        >
                        @error('addressOne')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Address 2 --}}
                    <div>
                        <label for="addressTwo" class="block text-sm font-medium text-gray-700 mb-1">
                            Address 2
                        </label>
                        <input
                            type="text"
                            id="addressTwo"
                            wire:model="addressTwo"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                        >
                    </div>

                    {{-- City --}}
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> City
                        </label>
                        <input
                            type="text"
                            id="city"
                            wire:model="city"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('city') border-red-500 @enderror"
                        >
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- State --}}
                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> State
                        </label>
                        <select
                            id="state"
                            wire:model="state"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('state') border-red-500 @enderror"
                        >
                            <option value="">Select State</option>
                            @foreach(self::STATES as $abbr => $name)
                                <option value="{{ $abbr }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('state')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ZIP --}}
                    <div>
                        <label for="zip" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> ZIP Code
                        </label>
                        <input
                            type="text"
                            id="zip"
                            wire:model="zip"
                            maxlength="10"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('zip') border-red-500 @enderror"
                        >
                        @error('zip')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Dates --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Dates</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Doctor's Approval Date --}}
                    <div>
                        <label for="drApprovalDate" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> Doctor's Approval Date
                        </label>
                        <input
                            type="date"
                            id="drApprovalDate"
                            wire:model="drApprovalDate"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('drApprovalDate') border-red-500 @enderror"
                        >
                        @error('drApprovalDate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Report to Work Date --}}
                    <div>
                        <label for="workDate" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> Report to Work Date
                        </label>
                        <input
                            type="date"
                            id="workDate"
                            wire:model="workDate"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('workDate') border-red-500 @enderror"
                        >
                        @error('workDate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Working Hours and Days --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Working Hours and Days</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Start Time --}}
                    <div>
                        <label for="startTime" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> Start Time
                        </label>
                        <input
                            type="time"
                            id="startTime"
                            wire:model="startTime"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('startTime') border-red-500 @enderror"
                        >
                        @error('startTime')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- End Time --}}
                    <div>
                        <label for="endTime" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> End Time
                        </label>
                        <input
                            type="time"
                            id="endTime"
                            wire:model="endTime"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('endTime') border-red-500 @enderror"
                        >
                        @error('endTime')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Hours Per Week --}}
                    <div>
                        <label for="hoursPerWeek" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> Hours Per Week
                        </label>
                        <input
                            type="number"
                            id="hoursPerWeek"
                            wire:model="hoursPerWeek"
                            min="1"
                            max="168"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('hoursPerWeek') border-red-500 @enderror"
                        >
                        @error('hoursPerWeek')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Days of the Week --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <span class="text-red-500">*</span> Days of the Week
                        </label>
                        <div class="flex flex-wrap gap-4">
                            @foreach(self::DAYS_OF_WEEK as $day)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        value="{{ $day }}"
                                        wire:model="daysOfTheWeek"
                                        class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                                    >
                                    <span class="text-gray-900">{{ $day }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('daysOfTheWeek')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Wages --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Wages</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Dollar Amount --}}
                    <div>
                        <label for="wage" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> Dollar Amount
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">$</span>
                            <input
                                type="text"
                                id="wage"
                                wire:model="wage"
                                placeholder="0.00"
                                class="w-full pl-8 rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('wage') border-red-500 @enderror"
                            >
                        </div>
                        @error('wage')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Per --}}
                    <div>
                        <label for="wageDuration" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> Per
                        </label>
                        <select
                            id="wageDuration"
                            wire:model="wageDuration"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                        >
                            @foreach(self::WAGE_DURATIONS as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Work Location --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Work Location</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Location Address --}}
                    <div>
                        <label for="locationAddress" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> Location Address
                        </label>
                        <input
                            type="text"
                            id="locationAddress"
                            wire:model="locationAddress"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('locationAddress') border-red-500 @enderror"
                        >
                        @error('locationAddress')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Location City --}}
                    <div>
                        <label for="locationCity" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> Location City
                        </label>
                        <input
                            type="text"
                            id="locationCity"
                            wire:model="locationCity"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('locationCity') border-red-500 @enderror"
                        >
                        @error('locationCity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Location State --}}
                    <div>
                        <label for="locationState" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> Location State
                        </label>
                        <select
                            id="locationState"
                            wire:model="locationState"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('locationState') border-red-500 @enderror"
                        >
                            <option value="">Select State</option>
                            @foreach(self::STATES as $abbr => $name)
                                <option value="{{ $abbr }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('locationState')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Location ZIP --}}
                    <div>
                        <label for="locationZip" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> Location ZIP Code
                        </label>
                        <input
                            type="text"
                            id="locationZip"
                            wire:model="locationZip"
                            maxlength="10"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('locationZip') border-red-500 @enderror"
                        >
                        @error('locationZip')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Supervisor/Contact Information --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Supervisor & Contact Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Supervisor Name --}}
                    <div>
                        <label for="supervisorName" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> Supervisor Name
                        </label>
                        <input
                            type="text"
                            id="supervisorName"
                            wire:model="supervisorName"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('supervisorName') border-red-500 @enderror"
                        >
                        @error('supervisorName')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Supervisor Phone --}}
                    <div>
                        <label for="supervisorPhone" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> Supervisor Phone #
                        </label>
                        <input
                            type="tel"
                            id="supervisorPhone"
                            wire:model="supervisorPhone"
                            placeholder="(xxx) xxx-xxxx"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('supervisorPhone') border-red-500 @enderror"
                        >
                        @error('supervisorPhone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Contact Phone --}}
                    <div>
                        <label for="contactPhone" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> Contact Phone #
                        </label>
                        <input
                            type="tel"
                            id="contactPhone"
                            wire:model="contactPhone"
                            placeholder="(xxx) xxx-xxxx"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('contactPhone') border-red-500 @enderror"
                        >
                        @error('contactPhone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Your Name (Valediction) --}}
                    <div>
                        <label for="valediction" class="block text-sm font-medium text-gray-700 mb-1">
                            <span class="text-red-500">*</span> Your Name (for signature)
                        </label>
                        <input
                            type="text"
                            id="valediction"
                            wire:model="valediction"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('valediction') border-red-500 @enderror"
                        >
                        @error('valediction')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- CC Recipients --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Cc (Optional)</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- CC Line 1 --}}
                    <div>
                        <label for="ccLine1" class="block text-sm font-medium text-gray-700 mb-1">
                            Cc Line 1
                        </label>
                        <input
                            type="text"
                            id="ccLine1"
                            wire:model="ccLine1"
                            placeholder="Claim's Manager w/encl."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                        >
                    </div>

                    {{-- CC Line 2 --}}
                    <div>
                        <label for="ccLine2" class="block text-sm font-medium text-gray-700 mb-1">
                            Cc Line 2
                        </label>
                        <input
                            type="text"
                            id="ccLine2"
                            wire:model="ccLine2"
                            placeholder="Physician w/encl."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                        >
                    </div>

                    {{-- CC Line 3 --}}
                    <div>
                        <label for="ccLine3" class="block text-sm font-medium text-gray-700 mb-1">
                            Cc Line 3
                        </label>
                        <input
                            type="text"
                            id="ccLine3"
                            wire:model="ccLine3"
                            placeholder="Additional cc"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                        >
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex justify-end gap-4">
                <button
                    type="button"
                    wire:click="resetForm"
                    class="px-6 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                >
                    Reset Form
                </button>
                <button
                    type="submit"
                    class="px-6 py-2 text-white bg-primary-600 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                >
                    Generate Letter
                </button>
            </div>
        </form>
    @endif

    {{-- Print Styles --}}
    <style>
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
</div>
