<div class="min-h-screen bg-gray-50 py-8"
     x-data="{
         showPresetModal: false,
         presetUrl: '',
         copied: false,
         copyUrl() {
             navigator.clipboard.writeText(this.presetUrl);
             this.copied = true;
             setTimeout(() => this.copied = false, 2000);
         }
     }"
     @preset-saved.window="presetUrl = $event.detail.url; showPresetModal = true">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Preset Modal --}}
        <div x-show="showPresetModal"
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto"
             aria-labelledby="modal-title"
             role="dialog"
             aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="showPresetModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                     @click="showPresetModal = false"></div>

                <div x-show="showPresetModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full sm:p-6">
                    <div>
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-5">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Preset Saved
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Use this link to reload the form with these values:
                                </p>
                            </div>
                            <div class="mt-4">
                                <div class="flex rounded-md shadow-sm">
                                    <input type="text"
                                           readonly
                                           x-model="presetUrl"
                                           class="flex-1 min-w-0 block w-full px-3 py-2 rounded-l-md border border-gray-300 bg-gray-50 text-sm text-gray-700 focus:outline-none">
                                    <button type="button"
                                            @click="copyUrl()"
                                            class="inline-flex items-center px-4 py-2 border border-l-0 border-gray-300 rounded-r-md bg-gray-50 text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ejd-500">
                                        <span x-show="!copied">Copy</span>
                                        <span x-show="copied" class="text-green-600">Copied!</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-6">
                        <button type="button"
                                @click="showPresetModal = false"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-ejd-600 text-base font-medium text-white hover:bg-ejd-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ejd-500 sm:text-sm">
                            Done
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @if($showPreview)
            @include('livewire.ejd.partials._preview')
        @else
            <form wire:submit="generateForm" class="space-y-8">

                {{-- Preset Actions (subtle, for power users) --}}
                <div class="flex justify-end items-center gap-4 text-sm">
                    @if($hasActivePreset)
                        <span class="text-gray-500 text-xs">
                            Preset: {{ $presetToken }}
                        </span>
                    @endif
                    <button type="button"
                            wire:click="savePreset"
                            class="text-gray-500 hover:text-ejd-600 transition-colors flex items-center gap-1 cursor-pointer"
                            title="Save form as shareable preset">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        {{ $hasActivePreset ? 'Update Preset' : 'Save Preset' }}
                    </button>
                    @if($employer || $workerName || count($jobTitle) > 0)
                        <button type="button"
                                wire:click="clearForm"
                                wire:confirm="Clear all form fields?"
                                class="text-gray-400 hover:text-red-500 transition-colors flex items-center gap-1 cursor-pointer"
                                title="Clear form">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Clear
                        </button>
                    @endif
                </div>

                {{-- Honeypot --}}
                <div class="hidden" aria-hidden="true">
                    <label for="mycompany">Company</label>
                    <input type="text" name="mycompany" id="mycompany" wire:model="mycompany" autocomplete="off" tabindex="-1">
                </div>

                {{-- Section 1: Basic Information --}}
                @include('livewire.ejd.partials._basic-info')

                {{-- Section 2: Job Details --}}
                @include('livewire.ejd.partials._job-details')

                {{-- Section 3: Job Selection --}}
                @include('livewire.ejd.partials._job-selection')

                {{-- Section 4: Tasks --}}
                @include('livewire.ejd.partials._tasks')

                {{-- Section 5: Physical Demands --}}
                @include('livewire.ejd.partials._physical-demands')

                {{-- Submit Button --}}
                @if(count($tasks) > 0)
                    <div class="flex justify-center pt-6">
                        <button type="submit"
                                class="inline-flex items-center px-8 py-3 border border-transparent text-lg font-medium rounded-md shadow-sm text-white bg-ejd-600 hover:bg-ejd-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-ejd-600 transition-colors cursor-pointer">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Generate Form
                        </button>
                    </div>
                @endif

                {{-- Validation Errors Summary --}}
                @if($errors->any())
                    <div class="rounded-md bg-red-50 p-4 mt-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </form>
        @endif
    </div>
</div>
