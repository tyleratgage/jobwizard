<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($showPreview)
            @include('livewire.ejd.partials._preview')
        @else
            <form wire:submit="generateForm" class="space-y-8">

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
