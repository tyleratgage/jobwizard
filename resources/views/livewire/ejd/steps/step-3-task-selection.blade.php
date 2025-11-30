{{-- Step 3: Task Selection (Placeholder) --}}
@php
    use App\Models\Task;

    $availableTasks = $selectedJobId
        ? Task::forJob($selectedJobId)->ordered()->get()
        : collect();
@endphp

<div class="space-y-6">
    @if (!$selectedJobId)
        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
            <p class="text-yellow-800">Please select a job in Step 2 first.</p>
        </div>
    @elseif ($availableTasks->isEmpty())
        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
            <p class="text-yellow-800">No tasks are associated with the selected job.</p>
        </div>
    @else
        <div class="flex items-center justify-between">
            <p class="text-gray-600">
                Select the tasks that apply to this worker's position. You can select multiple tasks.
            </p>
            <span class="text-sm text-gray-500">
                {{ count($selectedTaskIds) }} of {{ $availableTasks->count() }} selected
            </span>
        </div>

        @error('selectedTaskIds')
            <div class="p-3 bg-red-50 border border-red-200 rounded-md">
                <p class="text-sm text-red-600">{{ $message }}</p>
            </div>
        @enderror

        {{-- Select All / Clear All --}}
        <div class="flex items-center space-x-4 pb-4 border-b border-gray-200">
            <button
                type="button"
                wire:click="$set('selectedTaskIds', {{ $availableTasks->pluck('id')->toJson() }})"
                class="text-sm text-primary-600 hover:text-primary-800 font-medium"
            >
                Select All
            </button>
            <span class="text-gray-300">|</span>
            <button
                type="button"
                wire:click="$set('selectedTaskIds', [])"
                class="text-sm text-gray-600 hover:text-gray-800 font-medium"
            >
                Clear All
            </button>
        </div>

        {{-- Task List --}}
        <fieldset>
            <legend class="sr-only">Select tasks</legend>

            <div class="space-y-3 max-h-96 overflow-y-auto pr-2">
                @foreach ($availableTasks as $task)
                    <label
                        class="relative flex items-start p-4 rounded-lg border-2 cursor-pointer transition-all hover:bg-gray-50
                            {{ in_array($task->id, $selectedTaskIds)
                                ? 'border-primary-500 bg-primary-50'
                                : 'border-gray-200'
                            }}"
                    >
                        <input
                            type="checkbox"
                            wire:model.live="selectedTaskIds"
                            value="{{ $task->id }}"
                            class="h-4 w-4 mt-0.5 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                        >
                        <div class="ml-3 flex-1">
                            <span class="block text-sm font-medium text-gray-900">
                                {{ $task->name }}
                            </span>
                            <span class="block text-xs text-gray-500 mt-0.5">
                                Code: {{ $task->code }}
                            </span>
                            @if ($task->equipment)
                                <span class="block text-xs text-gray-600 mt-1">
                                    <span class="font-medium">Equipment:</span> {{ $task->equipment }}
                                </span>
                            @endif
                        </div>
                    </label>
                @endforeach
            </div>
        </fieldset>

        {{-- Selected Tasks Summary --}}
        @if (count($selectedTaskIds) > 0)
            <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium text-green-800">{{ count($selectedTaskIds) }} task(s) selected</span>
                </div>
            </div>
        @endif
    @endif
</div>
