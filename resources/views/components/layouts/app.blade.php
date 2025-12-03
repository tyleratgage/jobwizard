<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>
<body class="min-h-screen bg-gray-50 antialiased">
    <!-- Skip to main content link for accessibility -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-50 focus:bg-primary-600 focus:text-white focus:px-4 focus:py-2 focus:rounded-md">
        Skip to main content
    </a>

    <!-- Header -->
    <header class="bg-header text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="text-xl font-bold">
                        {{ config('app.name') }}
                    </a>
                </div>
                <nav class="hidden md:flex space-x-8" aria-label="Main navigation">
                    <a href="{{ url('/ejd') }}" class="text-header-light hover:text-white transition-colors {{ request()->is('ejd*') ? 'text-white font-semibold' : '' }}">
                        Job Description
                    </a>
                    <a href="{{ url('/offer-letter') }}" class="text-header-light hover:text-white transition-colors {{ request()->is('offer-letter*') ? 'text-white font-semibold' : '' }}">
                        Offer Letter
                    </a>
                </nav>
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button type="button" class="text-header-light hover:text-white" aria-label="Open menu">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main id="main-content" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="mt-auto print:hidden">
        <!-- Logos Row - White Background -->
        <div class="bg-white py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center text-center">
                    <div>
                        <p class="text-sm text-gray-500 mb-2">A service of</p>
                        <img src="{{ asset('images/SmartLogo.png') }}" alt="SMART Logo" class="h-10 mx-auto">
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-2">In cooperation with</p>
                        <img src="{{ asset('images/GRIPLogo.png') }}" alt="GRIP Logo" class="h-10 mx-auto">
                    </div>
                    <div>
                        <img src="{{ asset('images/MBALogo.png') }}" alt="MBA Logo" class="h-10 mx-auto">
                    </div>
                </div>
            </div>
        </div>
        <!-- Funding Text - Dark Background -->
        <div class="bg-footer py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-gray-400">Funding and support for the SMART / MBA Return to Work grant has been provided by the State of Washington, Department of Labor and Industries, Safety and Health Investments Project.</p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
