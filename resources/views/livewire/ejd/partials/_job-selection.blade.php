{{-- Section 3: Job Selection --}}
<div class="bg-white shadow-sm rounded-lg overflow-hidden {{ !$location ? 'opacity-60' : '' }}" wire:key="job-selection-{{ $location }}">
    <div class="bg-slate-200 px-6 py-4">
        <h2 class="text-xl font-semibold text-slate-800 flex items-center">
            <span class="bg-white text-slate-600 rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3 shadow-sm">3</span>
            Choose Job Title
        </h2>
    </div>

    <div class="p-6">
        @if(!$location)
            {{-- Placeholder when no location selected --}}
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <p class="mt-2 text-gray-500">Select a location above to see available job titles</p>
            </div>
        @elseif($this->availableJobs->isEmpty())
            <p class="text-gray-500 text-center py-4">No jobs available for the selected location.</p>
        @else
            <p class="text-sm text-gray-600 mb-4">
                Select one or more job titles. Hold Ctrl/Cmd to select multiple.
            </p>

            @error('jobTitle')
                <p class="mb-4 text-sm text-red-600">{{ $message }}</p>
            @enderror

            {{-- Split jobs into two columns --}}
            @php
                $jobs = $this->availableJobs;
                $half = ceil($jobs->count() / 2);
                $leftJobs = $jobs->take($half);
                $rightJobs = $jobs->skip($half);
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Left Column --}}
                <div class="space-y-2">
                    @foreach($leftJobs as $job)
                        <label class="flex items-start p-3 border rounded-lg cursor-pointer transition-colors
                                      {{ in_array($job->id, $jobTitle) ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <input type="checkbox"
                                   value="{{ $job->id }}"
                                   wire:model.live="jobTitle"
                                   class="h-4 w-4 mt-0.5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <span class="ml-3 text-sm font-medium text-gray-700">{{ $job->name }}</span>
                        </label>
                    @endforeach
                </div>

                {{-- Right Column --}}
                <div class="space-y-2">
                    @foreach($rightJobs as $job)
                        <label class="flex items-start p-3 border rounded-lg cursor-pointer transition-colors
                                      {{ in_array($job->id, $jobTitle) ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <input type="checkbox"
                                   value="{{ $job->id }}"
                                   wire:model.live="jobTitle"
                                   class="h-4 w-4 mt-0.5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <span class="ml-3 text-sm font-medium text-gray-700">{{ $job->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            @if(count($jobTitle) > 0)
                <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <label for="customJobTitle" class="block text-sm font-medium text-green-800 mb-2">
                        Job Title for Output <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="customJobTitle"
                           wire:model="customJobTitle"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 @error('customJobTitle') border-red-500 @enderror"
                           placeholder="Edit job title as needed for the form output">
                    <p class="mt-1 text-xs text-green-600">Prepopulated from selected jobs. Edit as needed.</p>
                    @error('customJobTitle')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            @endif
        @endif
    </div>
</div>
