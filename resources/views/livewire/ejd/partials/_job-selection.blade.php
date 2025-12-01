{{-- Section 3: Job Selection --}}
<div class="bg-white shadow-sm rounded-lg overflow-hidden" wire:key="job-selection-{{ $location }}">
    <div class="bg-blue-600 px-6 py-4">
        <h2 class="text-xl font-semibold text-white flex items-center">
            <span class="bg-white text-blue-600 rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3">3</span>
            Choose Job Title
        </h2>
    </div>

    <div class="p-6">
        @if($this->availableJobs->isEmpty())
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
                                      {{ in_array($job->id, $jobTitle) ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <input type="checkbox"
                                   value="{{ $job->id }}"
                                   wire:model.live="jobTitle"
                                   class="h-4 w-4 mt-0.5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-3">
                                <span class="block text-sm font-medium text-gray-700">{{ $job->name }}</span>
                                <span class="block text-xs text-gray-500">{{ $job->code }}</span>
                            </span>
                        </label>
                    @endforeach
                </div>

                {{-- Right Column --}}
                <div class="space-y-2">
                    @foreach($rightJobs as $job)
                        <label class="flex items-start p-3 border rounded-lg cursor-pointer transition-colors
                                      {{ in_array($job->id, $jobTitle) ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <input type="checkbox"
                                   value="{{ $job->id }}"
                                   wire:model.live="jobTitle"
                                   class="h-4 w-4 mt-0.5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-3">
                                <span class="block text-sm font-medium text-gray-700">{{ $job->name }}</span>
                                <span class="block text-xs text-gray-500">{{ $job->code }}</span>
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            @if(count($jobTitle) > 0)
                <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                    <p class="text-sm text-blue-800">
                        <strong>Selected:</strong> {{ $this->selectedJobs->pluck('name')->implode(', ') }}
                    </p>
                </div>
            @endif
        @endif
    </div>
</div>
