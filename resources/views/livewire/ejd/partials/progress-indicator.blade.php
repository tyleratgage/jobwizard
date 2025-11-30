{{-- Progress Indicator Component --}}
<nav aria-label="Form progress" class="relative">
    {{-- Progress Bar Background --}}
    <div class="hidden sm:block absolute top-5 left-0 right-0 h-0.5 bg-gray-200" aria-hidden="true">
        <div
            class="h-full bg-primary-600 transition-all duration-500 ease-out"
            style="width: {{ $this->progressPercentage }}%"
        ></div>
    </div>

    {{-- Steps List --}}
    <ol class="relative flex flex-col sm:flex-row sm:justify-between">
        @foreach ($this->getSteps() as $stepNumber => $stepInfo)
            @php
                $isCompleted = $this->isStepCompleted($stepNumber);
                $isCurrent = $currentStep === $stepNumber;
                $isAccessible = $this->isStepAccessible($stepNumber);
            @endphp
            <li class="flex sm:flex-col items-center sm:flex-1 mb-4 sm:mb-0">
                {{-- Step Button --}}
                <button
                    type="button"
                    wire:click="goToStep({{ $stepNumber }})"
                    @if (!$isAccessible) disabled @endif
                    class="group flex items-center sm:flex-col relative focus:outline-none {{ $isAccessible ? 'cursor-pointer' : 'cursor-not-allowed' }}"
                    aria-current="{{ $isCurrent ? 'step' : 'false' }}"
                    aria-label="Step {{ $stepNumber }}: {{ $stepInfo['title'] }}{{ $isCompleted ? ' (completed)' : ($isCurrent ? ' (current)' : '') }}"
                >
                    {{-- Step Circle --}}
                    <span class="
                        relative z-10 flex items-center justify-center w-10 h-10 rounded-full border-2 transition-all duration-200
                        {{ $isCompleted
                            ? 'bg-primary-600 border-primary-600 text-white'
                            : ($isCurrent
                                ? 'bg-white border-primary-600 text-primary-600'
                                : ($isAccessible
                                    ? 'bg-white border-gray-300 text-gray-500 group-hover:border-gray-400'
                                    : 'bg-gray-100 border-gray-200 text-gray-400'))
                        }}
                    ">
                        @if ($isCompleted)
                            {{-- Checkmark Icon --}}
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            <span class="text-sm font-semibold">{{ $stepNumber }}</span>
                        @endif
                    </span>

                    {{-- Step Label (Desktop) --}}
                    <span class="hidden sm:block mt-2 text-center">
                        <span class="
                            block text-xs font-medium transition-colors
                            {{ $isCurrent ? 'text-primary-600' : ($isCompleted ? 'text-primary-600' : 'text-gray-500') }}
                        ">
                            {{ $stepInfo['title'] }}
                        </span>
                    </span>

                    {{-- Step Label (Mobile) --}}
                    <span class="sm:hidden ml-4">
                        <span class="
                            block text-sm font-medium
                            {{ $isCurrent ? 'text-primary-600' : ($isCompleted ? 'text-primary-600' : 'text-gray-500') }}
                        ">
                            {{ $stepInfo['title'] }}
                        </span>
                        <span class="text-xs text-gray-400">
                            {{ $stepInfo['description'] }}
                        </span>
                    </span>
                </button>

                {{-- Connector Line (Mobile) --}}
                @if ($stepNumber < count($this->getSteps()))
                    <div class="hidden sm:hidden absolute left-5 top-10 h-full w-0.5 -ml-px {{ $isCompleted ? 'bg-primary-600' : 'bg-gray-200' }}" aria-hidden="true"></div>
                @endif
            </li>
        @endforeach
    </ol>
</nav>

{{-- Screen Reader Progress Announcement --}}
<div class="sr-only" aria-live="polite" aria-atomic="true">
    Step {{ $currentStep }} of {{ count($this->getSteps()) }}: {{ $this->getSteps()[$currentStep]['title'] }}
</div>
