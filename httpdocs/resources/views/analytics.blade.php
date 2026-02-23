<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Analytics — {{ config('app.name') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-gray-50 antialiased">
    <header class="bg-header text-white shadow-lg border-b-3 border-accent-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ url('/') }}" class="text-xl font-bold">{{ config('app.name') }}</a>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-300">Analytics</span>
                    <a href="{{ url('/analytics?logout=1') }}" class="text-sm text-red-300 hover:text-red-100">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm font-medium text-gray-500">EJD Submissions</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($ejdTotal) }}</p>
                <p class="text-sm text-gray-400 mt-1">Last 30 days: {{ number_format($ejdLast30) }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm font-medium text-gray-500">Offer Letters</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($offerTotal) }}</p>
                <p class="text-sm text-gray-400 mt-1">Last 30 days: {{ number_format($offerLast30) }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm font-medium text-gray-500">Job Selections</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($jobSelTotal) }}</p>
                <p class="text-sm text-gray-400 mt-1">Last 30 days: {{ number_format($jobSelLast30) }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-sm font-medium text-gray-500">Task Selections</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($taskSelTotal) }}</p>
                <p class="text-sm text-gray-400 mt-1">Last 30 days: {{ number_format($taskSelLast30) }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Top Jobs --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Top 10 Selected Jobs</h2>
                @if($topJobs->isEmpty())
                    <p class="text-gray-400 text-sm">No data yet.</p>
                @else
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-2 text-gray-500 font-medium">Job</th>
                                <th class="text-right py-2 text-gray-500 font-medium">Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topJobs as $row)
                                <tr class="border-b border-gray-100">
                                    <td class="py-2 text-gray-700">{{ $row->title ?? "Job #{$row->job_id}" }}</td>
                                    <td class="py-2 text-right font-medium text-gray-900">{{ number_format($row->total) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            {{-- Top Tasks --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Top 10 Selected Tasks</h2>
                @if($topTasks->isEmpty())
                    <p class="text-gray-400 text-sm">No data yet.</p>
                @else
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-2 text-gray-500 font-medium">Task</th>
                                <th class="text-right py-2 text-gray-500 font-medium">Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topTasks as $row)
                                <tr class="border-b border-gray-100">
                                    <td class="py-2 text-gray-700">{{ $row->name ?? "Task #{$row->task_id}" }}</td>
                                    <td class="py-2 text-right font-medium text-gray-900">{{ number_format($row->total) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            {{-- Offer Letters by Type --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Offer Letters by Type</h2>
                @if($offerByType->isEmpty())
                    <p class="text-gray-400 text-sm">No data yet.</p>
                @else
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-2 text-gray-500 font-medium">Type</th>
                                <th class="text-left py-2 text-gray-500 font-medium">Language</th>
                                <th class="text-right py-2 text-gray-500 font-medium">Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($offerByType as $row)
                                <tr class="border-b border-gray-100">
                                    <td class="py-2 text-gray-700 capitalize">{{ $row->template_type }}</td>
                                    <td class="py-2 text-gray-700 uppercase">{{ $row->language }}</td>
                                    <td class="py-2 text-right font-medium text-gray-900">{{ number_format($row->total) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            {{-- Recent EJD Submissions --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent EJD Submissions</h2>
                @if($recentEjd->isEmpty())
                    <p class="text-gray-400 text-sm">No data yet.</p>
                @else
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-2 text-gray-500 font-medium">Date</th>
                                <th class="text-left py-2 text-gray-500 font-medium">Employer</th>
                                <th class="text-left py-2 text-gray-500 font-medium">Worker</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentEjd as $sub)
                                <tr class="border-b border-gray-100">
                                    <td class="py-2 text-gray-500">{{ $sub->created_at->format('M j, g:ia') }}</td>
                                    <td class="py-2 text-gray-700">{{ $sub->form_data['employer_name'] ?? '—' }}</td>
                                    <td class="py-2 text-gray-700">{{ $sub->form_data['worker_name'] ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </main>
</body>
</html>
