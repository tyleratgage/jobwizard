{{-- Section 2: Job Details --}}
<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="bg-ejd-400 px-6 py-4">
        <h2 class="text-xl font-semibold text-white text-shadow-dark flex items-center">
            <span class="bg-white text-ejd-600 rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold mr-3">2</span>
            Essential Task Description
        </h2>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Left Column: Location --}}
            <div>
                <fieldset>
                    <legend class="block text-sm font-medium text-gray-700 mb-3">
                        Location <span class="text-red-500">*</span>
                        <span class="block text-xs text-gray-500 font-normal mt-1">Choose one</span>
                    </legend>
                    <div class="space-y-2">
                        @foreach($this->locationOptions as $value => $label)
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer transition-colors
                                          {{ $location === $value ? 'border-ejd-400 bg-ejd-50' : 'border-gray-200 hover:border-gray-300' }}">
                                <input type="radio"
                                       name="location"
                                       value="{{ $value }}"
                                       wire:model.live="location"
                                       class="h-4 w-4 text-ejd-400 border-gray-300 focus:ring-ejd-400">
                                <span class="ml-3 text-sm font-medium text-gray-700">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('location')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </fieldset>
            </div>

            {{-- Right Column: Hours and Days --}}
            <div class="space-y-4">
                {{-- Hours per day --}}
                <div>
                    <label for="hrPerDay" class="block text-sm font-medium text-gray-700">
                        Hours per day <span class="text-red-500">*</span>
                    </label>
                    <select id="hrPerDay"
                            wire:model="hrPerDay"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-ejd-400 focus:ring-ejd-400 @error('hrPerDay') border-red-500 @enderror">
                        @foreach($this->hoursOptions as $hour)
                            <option value="{{ $hour }}">{{ $hour }}</option>
                        @endforeach
                    </select>
                    @error('hrPerDay')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Days per week --}}
                <div>
                    <label for="daysWkPerShift" class="block text-sm font-medium text-gray-700">
                        Days a week/shift <span class="text-red-500">*</span>
                    </label>
                    <select id="daysWkPerShift"
                            wire:model="daysWkPerShift"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-ejd-400 focus:ring-ejd-400 @error('daysWkPerShift') border-red-500 @enderror">
                        @foreach($this->daysOptions as $day)
                            <option value="{{ $day }}">{{ $day }}</option>
                        @endforeach
                    </select>
                    @error('daysWkPerShift')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
