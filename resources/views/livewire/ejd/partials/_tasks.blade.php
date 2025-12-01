{{-- Section 4: Tasks --}}
<div class="bg-white shadow-sm rounded-lg overflow-hidden {{ count($jobTitle) === 0 ? 'opacity-60' : '' }}" wire:key="tasks-{{ implode('-', $jobTitle) }}">
    <div class="bg-slate-200 px-6 py-4">
        <h2 class="text-xl font-semibold text-slate-800 flex items-center">
            <span class="bg-white text-slate-600 rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3 shadow-sm">4</span>
            Tasks
        </h2>
        <p class="text-slate-600 text-sm mt-1">Check or uncheck tasks as needed</p>
    </div>

    <div class="p-6">
        @if(count($jobTitle) === 0)
            {{-- Placeholder when no job selected --}}
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                <p class="mt-2 text-gray-500">Select a job title above to see available tasks</p>
            </div>
        @elseif($this->availableTasks->isEmpty())
            <p class="text-gray-500 text-center py-4">No tasks available for the selected job(s).</p>
        @else
            {{-- Select All / Clear All buttons --}}
            <div class="flex gap-3 mb-4">
                <button type="button"
                        wire:click="selectAllTasks"
                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ejd-400">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Select All
                </button>
                <button type="button"
                        wire:click="clearAllTasks"
                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ejd-400">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Clear All
                </button>
            </div>

            @error('tasks')
                <p class="mb-4 text-sm text-red-600">{{ $message }}</p>
            @enderror

            {{-- Tasks Grid --}}
            @php
                $availableTasks = $this->availableTasks;
                $half = ceil($availableTasks->count() / 2);
                $leftTasks = $availableTasks->take($half);
                $rightTasks = $availableTasks->skip($half);
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                {{-- Left Column --}}
                <div class="space-y-2">
                    @foreach($leftTasks as $task)
                        <label class="flex items-start p-3 border rounded-lg cursor-pointer transition-colors
                                      {{ in_array($task->id, $tasks) ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <input type="checkbox"
                                   value="{{ $task->id }}"
                                   wire:model.live="tasks"
                                   class="h-4 w-4 mt-0.5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <span class="ml-3">
                                <span class="block text-sm font-medium text-gray-700">{{ $task->name }}</span>
                                <span class="block text-xs text-gray-500">{{ $task->code }}</span>
                            </span>
                        </label>
                    @endforeach
                </div>

                {{-- Right Column --}}
                <div class="space-y-2">
                    @foreach($rightTasks as $task)
                        <label class="flex items-start p-3 border rounded-lg cursor-pointer transition-colors
                                      {{ in_array($task->id, $tasks) ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <input type="checkbox"
                                   value="{{ $task->id }}"
                                   wire:model.live="tasks"
                                   class="h-4 w-4 mt-0.5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                            <span class="ml-3">
                                <span class="block text-sm font-medium text-gray-700">{{ $task->name }}</span>
                                <span class="block text-xs text-gray-500">{{ $task->code }}</span>
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Additional Task --}}
            <div class="border-t pt-6">
                <label for="newTask" class="block text-sm font-medium text-gray-700">
                    Additional Task Name
                    <span class="text-gray-500 font-normal">(optional)</span>
                </label>
                <input type="text"
                       id="newTask"
                       wire:model="newTask"
                       placeholder="Enter a custom task if needed"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-ejd-400 focus:ring-ejd-400">
            </div>

            {{-- Equipment & Tools --}}
            <div class="mt-6">
                <label for="toolsEquipment" class="block text-sm font-medium text-gray-700">
                    Necessary machinery, tools, equipment and personal protective equipment
                    <span class="text-red-500">*</span>
                </label>
                <p class="text-xs text-gray-500 mb-2">Click in the box to add or delete.</p>
                <textarea id="toolsEquipment"
                          wire:model="toolsEquipment"
                          rows="4"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-ejd-400 focus:ring-ejd-400 @error('toolsEquipment') border-red-500 @enderror"></textarea>
                @error('toolsEquipment')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        @endif
    </div>
</div>
