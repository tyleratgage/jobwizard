{{-- Preview / Print Layout --}}
<div class="print-container">
    {{-- Action Buttons (hidden when printing) --}}
    <div class="mb-6 flex justify-center gap-4 print:hidden">
        <button type="button"
                wire:click="editForm"
                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ejd-400 cursor-pointer transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
            </svg>
            Edit Form
        </button>
        <button type="button"
                wire:click="downloadPdf"
                wire:loading.attr="disabled"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-ejd-400 hover:bg-ejd-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ejd-400 disabled:opacity-50 cursor-pointer transition-colors">
            <svg class="w-4 h-4 mr-2" wire:loading.remove wire:target="downloadPdf" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <svg class="w-4 h-4 mr-2 animate-spin" wire:loading wire:target="downloadPdf" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span wire:loading.remove wire:target="downloadPdf">Download PDF</span>
            <span wire:loading wire:target="downloadPdf">Generating...</span>
        </button>
        <button type="button"
                onclick="window.print()"
                class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ejd-400 cursor-pointer transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Print
        </button>
    </div>

    {{-- Printable Form --}}
    <div class="bg-white shadow-lg print:shadow-none mx-auto" style="max-width: 8.5in;">
        <div class="p-6 print:p-4" style="font-family: Arial, sans-serif; font-size: 11pt;">

            {{-- Header --}}
            <div class="flex justify-between items-start border-b-2 border-black pb-4 mb-4" style="position: relative;">
                <img src="{{ asset('images/wa_seal.png') }}" style="position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 75px; height: 75px;" alt="Washington State Seal">
                <div class="text-xs leading-tight">
                    <div>Department of Labor and Industries</div>
                    <div class="font-bold">Physician Billing codes</div>
                    <div class="font-bold">Review of Job Analysis and Job Description</div>
                    <div>1038M-Limit one per day</div>
                    <div>1028M-Each additional review, up to five per worker per day</div>
                </div>
                <div class="text-right">
                    <div class="font-bold text-sm mb-2">EMPLOYER'S JOB DESCRIPTION</div>
                    <div class="text-xs space-y-1">
                        <div>[&nbsp;&nbsp;&nbsp;&nbsp;] Job of Injury</div>
                        <div>[&nbsp;&nbsp;&nbsp;&nbsp;] Permanent Modified Job</div>
                        <div>[&nbsp;X&nbsp;] Light duty/Transitional</div>
                    </div>
                </div>
            </div>

            {{-- General Information Grid --}}
            <div class="border border-black mb-0">
                {{-- Row 1: Worker / Claim # --}}
                <div class="flex border-b border-black">
                    <div class="w-1/2 p-2 border-r border-black">
                        <span class="text-xs font-bold">Worker:</span>
                        <span class="text-sm ml-2">{{ $workerName }}</span>
                    </div>
                    <div class="w-1/2 p-2">
                        <span class="text-xs font-bold">Claim #:</span>
                        <span class="text-sm ml-2">{{ $claimNo ?: 'Unknown' }}</span>
                    </div>
                </div>

                {{-- Row 2: Company / Job Title --}}
                <div class="flex border-b border-black">
                    <div class="w-1/2 p-2 border-r border-black">
                        <span class="text-xs font-bold">Company:</span>
                        <span class="text-sm ml-2">{{ $employer }}</span>
                    </div>
                    <div class="w-1/2 p-2">
                        <span class="text-xs font-bold">Job Title:</span>
                        <span class="text-sm ml-2">{{ $this->jobTitleDisplay }}</span>
                    </div>
                </div>

                {{-- Row 3: Phone / Hours & Days --}}
                <div class="flex border-b border-black">
                    <div class="w-1/2 p-2 border-r border-black">
                        <span class="text-xs font-bold">Phone #:</span>
                        <span class="text-sm ml-2">{{ $phone }}</span>
                    </div>
                    <div class="w-1/2 p-2 flex">
                        <div class="w-1/2">
                            <span class="text-xs font-bold">Hours per day:</span>
                            <span class="text-sm ml-1">{{ $hrPerDay }}</span>
                        </div>
                        <div class="w-1/2">
                            <span class="text-xs font-bold">Days per week:</span>
                            <span class="text-sm ml-1">{{ $daysWkPerShift }}</span>
                        </div>
                    </div>
                </div>

                {{-- Row 4: Employer Name (Please print) / Title --}}
                <div class="flex border-b border-black">
                    <div class="w-1/2 p-2 border-r border-black">
                        <span class="text-xs font-bold">Employer Name (Please print):</span>
                        <div class="border-b border-gray-400 mt-4 h-4"></div>
                    </div>
                    <div class="w-1/2 p-2">
                        <span class="text-xs font-bold">Title:</span>
                        <span class="text-sm ml-2">{{ $title }}</span>
                    </div>
                </div>

                {{-- Row 5: Employer Signature / Date --}}
                <div class="flex">
                    <div class="w-1/2 p-2 border-r border-black">
                        <span class="text-xs font-bold">Employer Signature:</span>
                        <div class="border-b border-gray-400 mt-4 h-4"></div>
                    </div>
                    <div class="w-1/2 p-2">
                        <span class="text-xs font-bold">Date:</span>
                        <span class="text-sm ml-2">{{ \Carbon\Carbon::parse($date)->format('m/d/Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Essential Job Duties --}}
            <div class="border border-t-0 border-black p-3">
                <div class="font-bold text-xs mb-1">Essential Job Duties</div>
                <div class="text-sm">{{ $this->tasksDisplay }}</div>
            </div>

            {{-- Equipment --}}
            <div class="border border-t-0 border-black p-3">
                <div class="font-bold text-xs mb-1">Machinery, tools, equipment and personal protective equipment. (Please submit MSDS if appropriate.)</div>
                <div class="text-sm">{{ $toolsEquipment }}</div>
            </div>

            {{-- Frequency Guidelines --}}
            <div class="border border-t-0 border-black p-2">
                <div class="flex flex-wrap text-xs">
                    <div class="w-1/3 font-bold">Frequency Guidelines</div>
                    <div class="w-1/3"><strong>N:</strong> Never (not at all)</div>
                    <div class="w-1/3"><strong>S:</strong> Seldom (1-10% of the time)</div>
                    <div class="w-1/3"><strong>O:</strong> Occasional (11-33% of the time)</div>
                    <div class="w-1/3"><strong>F:</strong> Frequent (34%-66% of the time)</div>
                    <div class="w-1/3"><strong>C:</strong> Constant (67%-100% of the time)</div>
                </div>
            </div>

            {{-- Physical Demands Table --}}
            <table class="w-full border-collapse text-xs">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-black p-1 text-left w-1/4">Physical Demands</th>
                        <th class="border border-black p-1 text-center w-16">Frequency</th>
                        <th class="border border-black p-1 text-left">Description of Task <span class="font-normal italic">(Please limit to 80 characters)</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Livewire\Ejd\EjdForm::PHYSICAL_DEMANDS as $key => $label)
                        {{-- Insert custom task before Comments/Other --}}
                        @if($key === 'other' && $newTask)
                            <tr>
                                <td class="border border-black p-1">{{ $newTask }}</td>
                                <td class="border border-black p-1 text-center font-bold">{{ $this->getFrequencyLetter($frequencies['newTask'] ?? 1) }}</td>
                                <td class="border border-black p-1">{{ $descriptions['newTask'] ?? '' }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td class="border border-black p-1">{{ $label }}</td>
                            <td class="border border-black p-1 text-center font-bold">{{ $this->getFrequencyLetter($frequencies[$key] ?? 1) }}</td>
                            <td class="border border-black p-1">{{ $descriptions[$key] ?? '' }}</td>
                        </tr>
                    @endforeach

                    {{-- Lifting/Pushing Section --}}
                    @foreach(\App\Livewire\Ejd\EjdForm::LIFTING_DEMANDS as $key => $label)
                        <tr>
                            <td class="border border-black p-1">
                                {{ $label }}
                                @php $lbsField = 'lbs' . ucfirst($key); @endphp
                                @if($$lbsField)
                                    ({{ $$lbsField }}) lbs
                                @else
                                    (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;) lbs
                                @endif
                            </td>
                            <td class="border border-black p-1 text-center font-bold">{{ $this->getFrequencyLetter($frequencies[$key] ?? 1) }}</td>
                            <td class="border border-black p-1">{{ $descriptions[$key] ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- For Health Provider's Use Only --}}
            <div class="border border-t-0 border-black">
                <div class="bg-gray-200 p-2 font-bold text-center text-sm border-b border-black">
                    FOR HEALTH PROVIDER'S USE ONLY
                </div>
                <div class="p-3">
                    <div class="flex">
                        <div class="w-1/2">
                            <div class="font-bold text-xs mb-2">Provider Approval</div>
                            <div class="text-xs space-y-1">
                                <div>[&nbsp;&nbsp;&nbsp;&nbsp;] Yes</div>
                                <div>[&nbsp;&nbsp;&nbsp;&nbsp;] No</div>
                            </div>
                        </div>
                        <div class="w-1/2 text-xs space-y-1">
                            <div><strong>Hours per day</strong> ______</div>
                            <div><strong>Days per week</strong> ______</div>
                            <div><strong>Effective date</strong> ____________</div>
                        </div>
                    </div>
                    <div class="mt-3 text-xs">
                        If no, please provide objective medical documentation to support your decision:
                    </div>
                    <div class="border-b border-gray-400 mt-2 h-8"></div>
                </div>
            </div>

            {{-- Signature Section --}}
            <div class="border border-t-0 border-black p-3">
                <div class="flex">
                    <div class="w-1/3">
                        <div class="text-xs mb-1">Provider Signature</div>
                        <div class="border-b border-black h-6"></div>
                    </div>
                    <div class="w-1/3 px-4">
                        <div class="text-xs mb-1">Provider Name <span class="italic">(Please print)</span></div>
                        <div class="border-b border-black h-6"></div>
                    </div>
                    <div class="w-1/3">
                        <div class="text-xs mb-1">Date</div>
                        <div class="border-b border-black h-6"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Print Styles --}}
<style>
    @media print {
        body {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .print-container {
            width: 100%;
            max-width: none;
        }

        /* Hide non-printable elements */
        .print\\:hidden {
            display: none !important;
        }

        /* Remove shadows for print */
        .print\\:shadow-none {
            box-shadow: none !important;
        }

        /* Ensure tables don't break across pages */
        table {
            page-break-inside: avoid;
        }

        tr {
            page-break-inside: avoid;
        }
    }
</style>
