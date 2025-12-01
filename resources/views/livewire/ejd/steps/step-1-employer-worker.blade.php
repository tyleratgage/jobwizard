{{-- Step 1: Employer & Worker Information --}}
<div class="space-y-8">
    {{-- Honeypot Field (hidden, for spam protection) --}}
    <div class="hidden" aria-hidden="true">
        <label for="honeypot">Leave this field empty</label>
        <input type="text" id="honeypot" name="honeypot" wire:model="honeypot" tabindex="-1" autocomplete="off">
    </div>

    {{-- Employer Information Section --}}
    <fieldset>
        <legend class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">
            Employer Information
        </legend>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Company Name --}}
            <div class="md:col-span-2">
                <label for="employerCompanyName" class="block text-sm font-medium text-gray-700 mb-1">
                    Company Name <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="employerCompanyName"
                    wire:model="employerCompanyName"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('employerCompanyName') border-red-300 @enderror"
                    placeholder="Enter company name"
                    required
                    aria-describedby="employerCompanyName-error"
                >
                @error('employerCompanyName')
                    <p id="employerCompanyName-error" class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Address --}}
            <div class="md:col-span-2">
                <label for="employerAddress" class="block text-sm font-medium text-gray-700 mb-1">
                    Address <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="employerAddress"
                    wire:model="employerAddress"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('employerAddress') border-red-300 @enderror"
                    placeholder="Street address"
                    required
                >
                @error('employerAddress')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- City --}}
            <div>
                <label for="employerCity" class="block text-sm font-medium text-gray-700 mb-1">
                    City <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="employerCity"
                    wire:model="employerCity"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('employerCity') border-red-300 @enderror"
                    placeholder="City"
                    required
                >
                @error('employerCity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- State --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="employerState" class="block text-sm font-medium text-gray-700 mb-1">
                        State <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="employerState"
                        wire:model="employerState"
                        maxlength="2"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 uppercase @error('employerState') border-red-300 @enderror"
                        placeholder="WA"
                        required
                    >
                    @error('employerState')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ZIP --}}
                <div>
                    <label for="employerZip" class="block text-sm font-medium text-gray-700 mb-1">
                        ZIP Code <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="employerZip"
                        wire:model="employerZip"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('employerZip') border-red-300 @enderror"
                        placeholder="98101"
                        required
                    >
                    @error('employerZip')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Contact Name --}}
            <div>
                <label for="employerContactName" class="block text-sm font-medium text-gray-700 mb-1">
                    Contact Name <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="employerContactName"
                    wire:model="employerContactName"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('employerContactName') border-red-300 @enderror"
                    placeholder="Contact person's name"
                    required
                >
                @error('employerContactName')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Contact Phone --}}
            <div
                x-data="phoneInput('{{ $employerContactPhone }}')"
                x-init="$watch('phone', value => $wire.set('employerContactPhone', value))"
            >
                <label for="employerContactPhone" class="block text-sm font-medium text-gray-700 mb-1">
                    Contact Phone <span class="text-red-500">*</span>
                </label>
                <input
                    type="tel"
                    id="employerContactPhone"
                    x-model="phone"
                    x-on:input="format($event)"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('employerContactPhone') border-red-300 @enderror"
                    placeholder="(555) 555-5555"
                    required
                >
                <p class="mt-1 text-xs text-gray-500">Format: (555) 555-5555</p>
                @error('employerContactPhone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Contact Email --}}
            <div class="md:col-span-2">
                <label for="employerContactEmail" class="block text-sm font-medium text-gray-700 mb-1">
                    Contact Email <span class="text-red-500">*</span>
                </label>
                <input
                    type="email"
                    id="employerContactEmail"
                    wire:model="employerContactEmail"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('employerContactEmail') border-red-300 @enderror"
                    placeholder="contact@company.com"
                    required
                >
                @error('employerContactEmail')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </fieldset>

    {{-- Worker Information Section --}}
    <fieldset>
        <legend class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b border-gray-200">
            Worker Information
        </legend>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- First Name --}}
            <div>
                <label for="workerFirstName" class="block text-sm font-medium text-gray-700 mb-1">
                    First Name <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="workerFirstName"
                    wire:model="workerFirstName"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('workerFirstName') border-red-300 @enderror"
                    placeholder="First name"
                    required
                >
                @error('workerFirstName')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Last Name --}}
            <div>
                <label for="workerLastName" class="block text-sm font-medium text-gray-700 mb-1">
                    Last Name <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="workerLastName"
                    wire:model="workerLastName"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('workerLastName') border-red-300 @enderror"
                    placeholder="Last name"
                    required
                >
                @error('workerLastName')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Address --}}
            <div class="md:col-span-2">
                <label for="workerAddress" class="block text-sm font-medium text-gray-700 mb-1">
                    Address <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="workerAddress"
                    wire:model="workerAddress"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('workerAddress') border-red-300 @enderror"
                    placeholder="Street address"
                    required
                >
                @error('workerAddress')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- City --}}
            <div>
                <label for="workerCity" class="block text-sm font-medium text-gray-700 mb-1">
                    City <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="workerCity"
                    wire:model="workerCity"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('workerCity') border-red-300 @enderror"
                    placeholder="City"
                    required
                >
                @error('workerCity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- State & ZIP --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="workerState" class="block text-sm font-medium text-gray-700 mb-1">
                        State <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="workerState"
                        wire:model="workerState"
                        maxlength="2"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 uppercase @error('workerState') border-red-300 @enderror"
                        placeholder="WA"
                        required
                    >
                    @error('workerState')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="workerZip" class="block text-sm font-medium text-gray-700 mb-1">
                        ZIP Code <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="workerZip"
                        wire:model="workerZip"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('workerZip') border-red-300 @enderror"
                        placeholder="98101"
                        required
                    >
                    @error('workerZip')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Claim Number --}}
            <div>
                <label for="workerClaimNumber" class="block text-sm font-medium text-gray-700 mb-1">
                    Claim Number
                </label>
                <input
                    type="text"
                    id="workerClaimNumber"
                    wire:model="workerClaimNumber"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('workerClaimNumber') border-red-300 @enderror"
                    placeholder="Optional"
                >
                @error('workerClaimNumber')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Injury Date --}}
            <div>
                <label for="workerInjuryDate" class="block text-sm font-medium text-gray-700 mb-1">
                    Date of Injury
                </label>
                <input
                    type="date"
                    id="workerInjuryDate"
                    wire:model="workerInjuryDate"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('workerInjuryDate') border-red-300 @enderror"
                >
                @error('workerInjuryDate')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Return to Work Date --}}
            <div>
                <label for="workerReturnToWorkDate" class="block text-sm font-medium text-gray-700 mb-1">
                    Return to Work Date
                </label>
                <input
                    type="date"
                    id="workerReturnToWorkDate"
                    wire:model="workerReturnToWorkDate"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 @error('workerReturnToWorkDate') border-red-300 @enderror"
                >
                @error('workerReturnToWorkDate')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </fieldset>

    {{-- Required Fields Note --}}
    <p class="text-sm text-gray-500">
        <span class="text-red-500">*</span> Required fields
    </p>
</div>
