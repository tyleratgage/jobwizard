{{-- Step 2: Job Selection (Placeholder) --}}
@php
    use App\Models\Job;
    use App\Enums\JobLocation;

    $jobs = Job::ordered()->get()->groupBy('location');
@endphp

<div class="space-y-6">
    <p class="text-gray-600">
        Select the job position for this Essential Job Description. Jobs are organized by work location.
    </p>

    {{-- Job Selection --}}
    <fieldset>
        <legend class="sr-only">Select a job position</legend>

        @error('selectedJobId')
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-md">
                <p class="text-sm text-red-600">{{ $message }}</p>
            </div>
        @enderror

        <div class="space-y-6">
            @foreach (JobLocation::cases() as $location)
                @if (isset($jobs[$location->value]) && $jobs[$location->value]->count() > 0)
                    <div>
                        <h3 class="text-md font-semibold text-gray-800 mb-3 flex items-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary-100 text-primary-700 mr-2">
                                @switch($location->value)
                                    @case('office')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        @break
                                    @case('yard')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                        </svg>
                                        @break
                                    @case('job')
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        @break
                                @endswitch
                            </span>
                            {{ $location->label() }}
                            <span class="ml-2 text-sm font-normal text-gray-500">({{ $jobs[$location->value]->count() }} positions)</span>
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach ($jobs[$location->value] as $job)
                                <label
                                    class="relative flex items-start p-4 rounded-lg border-2 cursor-pointer transition-all hover:bg-gray-50
                                        {{ $selectedJobId === $job->id
                                            ? 'border-primary-500 bg-primary-50 ring-2 ring-primary-200'
                                            : 'border-gray-200'
                                        }}"
                                >
                                    <input
                                        type="radio"
                                        wire:model.live="selectedJobId"
                                        name="selectedJobId"
                                        value="{{ $job->id }}"
                                        class="h-4 w-4 mt-0.5 text-primary-600 border-gray-300 focus:ring-primary-500"
                                        aria-describedby="job-{{ $job->id }}-description"
                                    >
                                    <div class="ml-3">
                                        <span class="block text-sm font-medium text-gray-900">
                                            {{ $job->name }}
                                        </span>
                                        <span id="job-{{ $job->id }}-description" class="block text-xs text-gray-500 mt-0.5">
                                            Code: {{ $job->code }}
                                        </span>
                                    </div>

                                    {{-- Selected Indicator --}}
                                    @if ($selectedJobId === $job->id)
                                        <span class="absolute top-2 right-2">
                                            <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </span>
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </fieldset>

    {{-- Selected Job Summary --}}
    @if ($selectedJobId && $this->selectedJob)
        <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium text-green-800">Selected:</span>
                <span class="ml-2 text-green-700">{{ $this->selectedJob->display_name }}</span>
            </div>
        </div>
    @endif
</div>
