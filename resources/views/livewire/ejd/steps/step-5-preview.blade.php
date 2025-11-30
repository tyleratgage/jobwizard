{{-- Step 5: Preview & Generate --}}
@php
    use App\Models\Task;
    use App\Enums\PhysicalDemandFrequency;
@endphp

<div class="space-y-6">
    <p class="text-gray-600">
        Review all information before generating the Essential Job Description document.
    </p>

    {{-- Preview Card --}}
    <div class="border border-gray-200 rounded-lg overflow-hidden" id="ejd-preview">
        {{-- Document Header --}}
        <div class="bg-primary-700 text-white px-6 py-4">
            <h2 class="text-xl font-bold">Essential Job Description</h2>
            <p class="text-primary-100 text-sm mt-1">Generated on {{ now()->format('F j, Y') }}</p>
        </div>

        {{-- Document Content --}}
        <div class="p-6 space-y-6">
            {{-- Employer Information --}}
            <section>
                <h3 class="text-lg font-semibold text-gray-900 mb-3 pb-2 border-b border-gray-200 flex items-center justify-between">
                    Employer Information
                    <button type="button" wire:click="goToStep(1)" class="text-sm text-primary-600 hover:text-primary-800 font-normal">
                        Edit
                    </button>
                </h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Company</dt>
                        <dd class="text-sm text-gray-900">{{ $employerCompanyName }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Contact</dt>
                        <dd class="text-sm text-gray-900">{{ $employerContactName }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Address</dt>
                        <dd class="text-sm text-gray-900">
                            {{ $employerAddress }}<br>
                            {{ $employerCity }}, {{ $employerState }} {{ $employerZip }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Contact Info</dt>
                        <dd class="text-sm text-gray-900">
                            {{ $employerContactPhone }}<br>
                            {{ $employerContactEmail }}
                        </dd>
                    </div>
                </dl>
            </section>

            {{-- Worker Information --}}
            <section>
                <h3 class="text-lg font-semibold text-gray-900 mb-3 pb-2 border-b border-gray-200 flex items-center justify-between">
                    Worker Information
                    <button type="button" wire:click="goToStep(1)" class="text-sm text-primary-600 hover:text-primary-800 font-normal">
                        Edit
                    </button>
                </h3>
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                        <dd class="text-sm text-gray-900">{{ $workerFirstName }} {{ $workerLastName }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Claim Number</dt>
                        <dd class="text-sm text-gray-900">{{ $workerClaimNumber ?: 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Address</dt>
                        <dd class="text-sm text-gray-900">
                            {{ $workerAddress }}<br>
                            {{ $workerCity }}, {{ $workerState }} {{ $workerZip }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Dates</dt>
                        <dd class="text-sm text-gray-900">
                            @if ($workerInjuryDate)
                                Injury: {{ \Carbon\Carbon::parse($workerInjuryDate)->format('M j, Y') }}<br>
                            @endif
                            @if ($workerReturnToWorkDate)
                                Return to Work: {{ \Carbon\Carbon::parse($workerReturnToWorkDate)->format('M j, Y') }}
                            @endif
                            @if (!$workerInjuryDate && !$workerReturnToWorkDate)
                                N/A
                            @endif
                        </dd>
                    </div>
                </dl>
            </section>

            {{-- Job Information --}}
            <section>
                <h3 class="text-lg font-semibold text-gray-900 mb-3 pb-2 border-b border-gray-200 flex items-center justify-between">
                    Job Position
                    <button type="button" wire:click="goToStep(2)" class="text-sm text-primary-600 hover:text-primary-800 font-normal">
                        Edit
                    </button>
                </h3>
                @if ($this->selectedJob)
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Job Title</dt>
                            <dd class="text-sm text-gray-900">{{ $this->selectedJob->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Job Code</dt>
                            <dd class="text-sm text-gray-900">{{ $this->selectedJob->code }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Location</dt>
                            <dd class="text-sm text-gray-900">{{ $this->selectedJob->location->label() }}</dd>
                        </div>
                    </dl>
                @endif
            </section>

            {{-- Selected Tasks --}}
            <section>
                <h3 class="text-lg font-semibold text-gray-900 mb-3 pb-2 border-b border-gray-200 flex items-center justify-between">
                    Selected Tasks ({{ $this->selectedTasks->count() }})
                    <button type="button" wire:click="goToStep(3)" class="text-sm text-primary-600 hover:text-primary-800 font-normal">
                        Edit
                    </button>
                </h3>
                <ul class="space-y-2">
                    @forelse ($this->selectedTasks as $task)
                        <li class="text-sm text-gray-900 flex items-start">
                            <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>
                                <strong>{{ $task->code }}</strong> - {{ $task->name }}
                                @if ($task->equipment)
                                    <span class="text-gray-500 text-xs block ml-6">Equipment: {{ $task->equipment }}</span>
                                @endif
                            </span>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500 italic">No tasks selected</li>
                    @endforelse
                </ul>
            </section>

            {{-- Physical Demands Summary --}}
            <section>
                <h3 class="text-lg font-semibold text-gray-900 mb-3 pb-2 border-b border-gray-200 flex items-center justify-between">
                    Physical Demands Assessment
                    <button type="button" wire:click="goToStep(4)" class="text-sm text-primary-600 hover:text-primary-800 font-normal">
                        Review
                    </button>
                </h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-2 font-medium text-gray-600">Demand</th>
                                <th class="text-center py-2 font-medium text-gray-600">Level</th>
                                <th class="text-left py-2 font-medium text-gray-600">Demand</th>
                                <th class="text-center py-2 font-medium text-gray-600">Level</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $demands = $this->physicalDemands;
                                $demandKeys = array_keys($demands);
                                $halfCount = ceil(count($demandKeys) / 2);
                            @endphp
                            @for ($i = 0; $i < $halfCount; $i++)
                                <tr class="border-b border-gray-100">
                                    {{-- Left Column --}}
                                    <td class="py-2 text-gray-900">{{ Task::getPhysicalDemandLabel($demandKeys[$i]) }}</td>
                                    <td class="py-2 text-center">
                                        <span class="inline-block w-6 h-6 rounded-full text-white text-xs leading-6
                                            {{ match($demands[$demandKeys[$i]]) {
                                                0 => 'bg-gray-400',
                                                1 => 'bg-blue-400',
                                                2 => 'bg-yellow-500',
                                                3 => 'bg-orange-500',
                                                4 => 'bg-red-500',
                                                default => 'bg-gray-400',
                                            } }}">
                                            {{ $demands[$demandKeys[$i]] }}
                                        </span>
                                    </td>

                                    {{-- Right Column --}}
                                    @if (isset($demandKeys[$i + $halfCount]))
                                        <td class="py-2 text-gray-900">{{ Task::getPhysicalDemandLabel($demandKeys[$i + $halfCount]) }}</td>
                                        <td class="py-2 text-center">
                                            <span class="inline-block w-6 h-6 rounded-full text-white text-xs leading-6
                                                {{ match($demands[$demandKeys[$i + $halfCount]]) {
                                                    0 => 'bg-gray-400',
                                                    1 => 'bg-blue-400',
                                                    2 => 'bg-yellow-500',
                                                    3 => 'bg-orange-500',
                                                    4 => 'bg-red-500',
                                                    default => 'bg-gray-400',
                                                } }}">
                                                {{ $demands[$demandKeys[$i + $halfCount]] }}
                                            </span>
                                        </td>
                                    @else
                                        <td></td><td></td>
                                    @endif
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex flex-col sm:flex-row gap-4 justify-center pt-4">
        <button
            type="button"
            onclick="window.print()"
            class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
        >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Print Document
        </button>

        <button
            type="button"
            disabled
            class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 disabled:opacity-50 disabled:cursor-not-allowed"
            title="PDF generation will be available after Browsershot is installed"
        >
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Download PDF (Coming Soon)
        </button>
    </div>

    {{-- Note about PDF --}}
    <p class="text-center text-sm text-gray-500">
        PDF generation requires Browsershot installation (Task 1.2.7). Use browser print for now.
    </p>
</div>

{{-- Print Styles --}}
@push('styles')
<style>
    @media print {
        /* Hide everything except the preview */
        body * {
            visibility: hidden;
        }
        #ejd-preview, #ejd-preview * {
            visibility: visible;
        }
        #ejd-preview {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        /* Hide edit buttons in print */
        #ejd-preview button {
            display: none !important;
        }
    }
</style>
@endpush
