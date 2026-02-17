<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Analytics Login — {{ config('app.name') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-gray-50 antialiased flex items-center justify-center">
    <div class="w-full max-w-sm bg-white rounded-lg shadow p-8">
        <h1 class="text-xl font-bold text-gray-900 mb-6 text-center">Analytics Login</h1>
        @if($error)
            <p class="text-red-600 text-sm mb-4 text-center">{{ $error }}</p>
        @endif
        <form method="POST" action="/analytics">
            @csrf
            <div class="mb-4">
                <label for="user" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" name="user" id="user" required autofocus
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
            </div>
            <div class="mb-6">
                <label for="pass" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="pass" id="pass" required
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
            </div>
            <button type="submit"
                    class="w-full bg-primary-600 text-white py-2 px-4 rounded-md hover:bg-primary-700 font-medium transition-colors">
                Sign In
            </button>
        </form>
    </div>
</body>
</html>
