{{-- Section 1: Basic Information --}}
<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="section-header bg-slate-200 px-6 py-4">
        <h2 class="text-xl font-semibold text-slate-800 flex items-center">
            <span class="bg-white text-slate-600 rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3 shadow-sm">1</span>
            Basic Information
        </h2>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
            {{-- Row 1: Company Name | Worker Name --}}
            <div>
                <label for="employer" class="block text-sm font-medium text-gray-700">
                    Company Name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="employer"
                       wire:model="employer"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-ejd-400 focus:ring-ejd-400 @error('employer') border-red-500 @enderror"
                       required>
                @error('employer')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="workerName" class="block text-sm font-medium text-gray-700">
                    Worker Name <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="workerName"
                       wire:model="workerName"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-ejd-400 focus:ring-ejd-400 @error('workerName') border-red-500 @enderror"
                       required>
                @error('workerName')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Row 2: Phone # | Claim # --}}
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">
                    Phone # <span class="text-red-500">*</span>
                </label>
                <input type="tel"
                       id="phone"
                       wire:model.live.debounce.300ms="phone"
                       placeholder="xxx-xxx-xxxx"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-ejd-400 focus:ring-ejd-400 @error('phone') border-red-500 @enderror"
                       required>
                @error('phone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="claimNo" class="block text-sm font-medium text-gray-700">
                    Claim #
                </label>
                <input type="text"
                       id="claimNo"
                       wire:model="claimNo"
                       placeholder="If known"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-ejd-400 focus:ring-ejd-400">
            </div>

            {{-- Row 3: Return Fax # | Date --}}
            <div>
                <label for="fax" class="block text-sm font-medium text-gray-700">
                    Return Fax #
                </label>
                <input type="tel"
                       id="fax"
                       wire:model.live.debounce.300ms="fax"
                       placeholder="xxx-xxx-xxxx"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-ejd-400 focus:ring-ejd-400 @error('fax') border-red-500 @enderror">
                <p class="mt-1 text-xs text-gray-500">For provider to send completed form</p>
                @error('fax')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="date" class="block text-sm font-medium text-gray-700">
                    Date <span class="text-red-500">*</span>
                </label>
                <input type="date"
                       id="date"
                       wire:model="date"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-ejd-400 focus:ring-ejd-400 @error('date') border-red-500 @enderror"
                       required>
                @error('date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Row 4: Completed By | Title --}}
            <div>
                <label for="completedBy" class="block text-sm font-medium text-gray-700">
                    Completed By <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="completedBy"
                       wire:model="completedBy"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-ejd-400 focus:ring-ejd-400 @error('completedBy') border-red-500 @enderror"
                       required>
                @error('completedBy')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">
                    Title <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       id="title"
                       wire:model="title"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-ejd-400 focus:ring-ejd-400 @error('title') border-red-500 @enderror"
                       required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</div>
