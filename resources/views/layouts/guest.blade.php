<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Stockify') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-indigo-50 via-white to-blue-50">

    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-8">
        {{-- 🔹 Logo --}}
        <div class="flex flex-col items-center mb-4">
            <a href="/">
                <x-application-logo class="w-16 h-16 text-indigo-600" />
            </a>
            <h1 class="mt-3 text-lg font-semibold text-gray-700">Stockify</h1>
        </div>

        {{-- 🔹 Kartu utama --}}
        <div class="w-full sm:max-w-md bg-white shadow-md rounded-xl px-8 py-6 border border-gray-100">
            {{ $slot }}
        </div>

        {{-- 🔹 Footer kecil --}}
        <p class="text-xs text-gray-500 mt-6">© {{ date('Y') }} Stockify. All rights reserved.</p>
    </div>

</body>
</html>
