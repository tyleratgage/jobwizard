<x-layouts.app>
    <x-slot name="title">Privacy Policy</x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-sm rounded-lg p-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Privacy Policy</h1>

            <p class="text-sm text-gray-500 mb-6">Last updated: {{ date('F j, Y') }}</p>

            <div class="space-y-6 text-gray-700">
                <section>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">About This Service</h2>
                    <p>This Return to Work Form Wizard is a free courtesy service provided by <a href="https://www.smartwa.org/" target="_blank" rel="noopener" class="text-blue-600 hover:underline">SMART Association</a>, a trade association committed to helping employers maintain the highest standards of safety and compliance in workplaces throughout Washington State. This service is provided in cooperation with GRIP and MBA. Funding and support has been provided by the State of Washington, Department of Labor and Industries, Safety and Health Investment Projects.</p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Information We Collect</h2>
                    <p>We collect minimal data to understand how this service is being used. When you generate a PDF form, we record only:</p>
                    <ul class="list-disc list-inside mt-2 ml-4 space-y-1">
                        <li>The type of form completed (Job Description or Offer Letter)</li>
                        <li>The language selected</li>
                        <li>The date and time of completion</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Information We Do Not Collect</h2>
                    <p>We do not store, save, or retain any of the personal or business information you enter into the forms, including:</p>
                    <ul class="list-disc list-inside mt-2 ml-4 space-y-1">
                        <li>Names, addresses, or contact information</li>
                        <li>Employer or worker details</li>
                        <li>Claim numbers or medical information</li>
                        <li>Job descriptions or physical demand data</li>
                    </ul>
                    <p class="mt-2">All form data exists only in your browser while you complete the form. Once you download your PDF or leave the page, that information is not retained by our servers.</p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Saved Presets</h2>
                    <p>If you choose to save a form preset using the "Save Preset" feature, the form data you entered is stored on our server and associated with a unique link. This is entirely optional and at your discretion. You can share this link with others or use it to return to your form later. We do not access or use this saved data for any purpose other than restoring your form when you visit the link.</p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Cookies</h2>
                    <p>This site uses only essential cookies required for the forms to function properly. We do not use tracking cookies or third-party analytics services.</p>
                </section>

                <section>
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Contact</h2>
                    <p>If you have questions about this privacy policy or the service, please contact SMART Association through their <a href="https://www.smartwa.org/" target="_blank" rel="noopener" class="text-blue-600 hover:underline">official website</a>.</p>
                </section>
            </div>
        </div>
    </div>
</x-layouts.app>
