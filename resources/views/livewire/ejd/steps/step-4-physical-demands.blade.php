{{-- Step 4: Physical Demand Assessment --}}
@php
    use App\Models\Task;
    use App\Enums\PhysicalDemandFrequency;
@endphp

<div class="space-y-6">
    <p class="text-gray-600">
        Based on the selected tasks, the following physical demand requirements have been calculated.
        The highest frequency for each category is shown.
    </p>

    @if (empty($selectedTaskIds))
        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
            <p class="text-yellow-800">Please select at least one task in Step 3 to see physical demands.</p>
        </div>
    @else
        {{-- Legend --}}
        <div class="bg-gray-50 rounded-lg p-4">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Frequency Scale</h3>
            <div class="flex flex-wrap gap-3 text-xs">
                @foreach (PhysicalDemandFrequency::cases() as $freq)
                    <div class="flex items-center">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-white text-xs font-medium mr-2
                            {{ match($freq->value) {
                                0 => 'bg-gray-400',
                                1 => 'bg-blue-400',
                                2 => 'bg-yellow-500',
                                3 => 'bg-orange-500',
                                4 => 'bg-red-500',
                            } }}">
                            {{ $freq->value }}
                        </span>
                        <span class="text-gray-600">{{ $freq->shortLabel() }} ({{ $freq->percentage() }})</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Physical Demands Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Physical Demand
                        </th>
                        <th scope="col" class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Frequency
                        </th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            Level
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($this->physicalDemands as $demand => $value)
                        @php
                            $frequency = PhysicalDemandFrequency::from($value);
                        @endphp
                        <tr class="{{ $loop->even ? 'bg-gray-50' : '' }}">
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ Task::getPhysicalDemandLabel($demand) }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-white text-sm font-medium
                                    {{ match($value) {
                                        0 => 'bg-gray-400',
                                        1 => 'bg-blue-400',
                                        2 => 'bg-yellow-500',
                                        3 => 'bg-orange-500',
                                        4 => 'bg-red-500',
                                        default => 'bg-gray-400',
                                    } }}">
                                    {{ $value }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ $frequency->shortLabel() }}
                                <span class="text-gray-400">({{ $frequency->percentage() }})</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Summary Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
            @php
                $demandCounts = array_count_values($this->physicalDemands);
            @endphp
            @foreach ([4 => 'Constant', 3 => 'Frequent', 2 => 'Occasional', 1 => 'Seldom'] as $level => $label)
                <div class="bg-white border border-gray-200 rounded-lg p-3 text-center">
                    <div class="text-2xl font-bold {{ match($level) {
                        4 => 'text-red-600',
                        3 => 'text-orange-600',
                        2 => 'text-yellow-600',
                        1 => 'text-blue-600',
                    } }}">
                        {{ $demandCounts[$level] ?? 0 }}
                    </div>
                    <div class="text-xs text-gray-500">{{ $label }}</div>
                </div>
            @endforeach
        </div>
    @endif
</div>
