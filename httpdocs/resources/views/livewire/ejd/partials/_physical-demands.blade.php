{{-- Section 5: Physical Demands --}}
<div class="bg-white shadow-sm rounded-lg overflow-hidden {{ count($tasks) === 0 ? 'opacity-60' : '' }}" wire:key="physical-demands-{{ implode('-', $tasks) }}">
    <div class="section-header bg-slate-200 px-6 py-4">
        <h2 class="text-xl font-semibold text-slate-800 flex items-center">
            <span class="bg-white text-slate-600 rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3 shadow-sm">5</span>
            Physical Demands
        </h2>
    </div>

    <div class="p-6">
        @if(count($tasks) === 0)
            {{-- Placeholder when no tasks selected --}}
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <p class="mt-2 text-gray-500">Select tasks above to calculate physical demands</p>
            </div>
        @else
        {{-- Frequency Legend --}}
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-2 text-sm">
                <div><strong>N:</strong> Never (not at all)</div>
                <div><strong>S:</strong> Seldom (1-10%)</div>
                <div><strong>O:</strong> Occasional (11-33%)</div>
                <div><strong>F:</strong> Frequent (34-66%)</div>
                <div><strong>C:</strong> Constant (67-100%)</div>
            </div>
        </div>

        {{-- Physical Demands Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">
                            Physical Demand
                        </th>
                        <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Frequency
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">
                            Description
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach(\App\Livewire\Ejd\EjdForm::PHYSICAL_DEMANDS as $key => $label)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                {{ $label }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-center space-x-2">
                                    @foreach(\App\Livewire\Ejd\EjdForm::FREQUENCY_OPTIONS as $value => $letter)
                                        <label class="inline-flex flex-col items-center cursor-pointer px-2 py-1 rounded transition-colors hover:bg-gray-100">
                                            <input type="radio"
                                                   name="freq_{{ $key }}"
                                                   value="{{ $value }}"
                                                   wire:model.live="frequencies.{{ $key }}"
                                                   class="h-4 w-4 text-ejd-600 border-gray-400 focus:ring-ejd-600 checked:bg-ejd-600">
                                            <span class="text-xs mt-1 text-gray-500">{{ $letter }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <input type="text"
                                       wire:model="descriptions.{{ $key }}"
                                       placeholder="Description (optional)"
                                       class="block w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-ejd-400 focus:ring-ejd-400">
                            </td>
                        </tr>
                    @endforeach

                    {{-- Additional Task Row (if newTask is provided) --}}
                    @if($newTask)
                        <tr class="hover:bg-gray-50 bg-yellow-50">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                {{ $newTask }}
                                <span class="text-xs text-yellow-600">(custom)</span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-center space-x-2">
                                    @foreach(\App\Livewire\Ejd\EjdForm::FREQUENCY_OPTIONS as $value => $letter)
                                        <label class="inline-flex flex-col items-center cursor-pointer px-2 py-1 rounded transition-colors hover:bg-yellow-100">
                                            <input type="radio"
                                                   name="freq_newTask"
                                                   value="{{ $value }}"
                                                   wire:model.live="frequencies.newTask"
                                                   class="h-4 w-4 text-ejd-600 border-gray-400 focus:ring-ejd-600 checked:bg-ejd-600">
                                            <span class="text-xs mt-1 text-gray-500">{{ $letter }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <input type="text"
                                       wire:model="descriptions.newTask"
                                       placeholder="Description (optional)"
                                       class="block w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-ejd-600 focus:ring-ejd-600">
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Lifting/Pushing Section --}}
        <div class="mt-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Lifting / Pushing</h3>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">
                                Activity
                            </th>
                            <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Frequency
                            </th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">
                                Description
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach(\App\Livewire\Ejd\EjdForm::LIFTING_DEMANDS as $key => $label)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm font-medium text-gray-900">{{ $label }}</span>
                                        <div class="flex items-center">
                                            <input type="number"
                                                   wire:model="lbs{{ ucfirst($key) }}"
                                                   placeholder="lbs"
                                                   min="0"
                                                   class="w-16 text-sm border-gray-300 rounded-md shadow-sm focus:border-ejd-400 focus:ring-ejd-400 @error('lbs'.ucfirst($key)) border-red-500 @enderror">
                                            <span class="ml-1 text-sm text-gray-500">lbs</span>
                                        </div>
                                    </div>
                                    @error('lbs'.ucfirst($key))
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center space-x-2">
                                        @foreach(\App\Livewire\Ejd\EjdForm::FREQUENCY_OPTIONS as $value => $letter)
                                            <label class="inline-flex flex-col items-center cursor-pointer px-2 py-1 rounded transition-colors hover:bg-gray-100">
                                                <input type="radio"
                                                       name="freq_{{ $key }}"
                                                       value="{{ $value }}"
                                                       wire:model.live="frequencies.{{ $key }}"
                                                       class="h-4 w-4 text-ejd-600 border-gray-400 focus:ring-ejd-600 checked:bg-ejd-600">
                                                <span class="text-xs mt-1 text-gray-500">{{ $letter }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <input type="text"
                                           wire:model="descriptions.{{ $key }}"
                                           placeholder="Description (optional)"
                                           class="block w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-ejd-600 focus:ring-ejd-600">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
