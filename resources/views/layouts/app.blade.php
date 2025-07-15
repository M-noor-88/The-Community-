<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    <script>
        // Persist dark mode preference
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark')
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 transition-colors duration-300">
<div class="min-h-screen flex flex-col">

    <!-- Header / Navigation -->
    <header class="bg-white dark:bg-gray-800 shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <div class="flex items-center gap-3">
{{--                <img src="/logo.svg" alt="Logo" class="h-8 w-auto">--}}
                <span class="font-semibold text-xl text-indigo-700 dark:text-indigo-400">{{ "The Community" }}</span>
            </div>

            <div class="flex items-center gap-4">
                <!-- Dark Mode Toggle -->
                <button onclick="document.documentElement.classList.toggle('dark'); localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');"
                        class="text-gray-500 dark:text-gray-300 hover:text-indigo-500 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 3v1m0 16v1m8.66-9h-1M4.34 12H3m15.07 6.07l-.71-.71M6.34 6.34l-.71-.71m0 12.02l.71-.71m12.02-12.02l.71-.71" />
                    </svg>
                </button>

                <!-- Navigation Component -->
                <livewire:layout.navigation />
            </div>
        </div>
    </header>

    <!-- Page Header -->
    @if (isset($header))
        <div class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 shadow-sm">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-xl font-semibold text-gray-700 dark:text-gray-200 animate-fade-in">
                {{ $header }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 animate-fade-in-up">
            {{ $slot }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 border-t dark:border-gray-700 py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-500 dark:text-gray-400">
            &copy; {{ now()->year }} {{ "The Community" }}. All rights reserved.
        </div>
    </footer>
</div>

@livewireScripts
</body>
</html>
