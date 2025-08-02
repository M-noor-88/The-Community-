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

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />


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
<div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <div :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }"
         class="fixed inset-y-0 left-0 z-30 w-64 transform backdrop-blur-lg bg-white/80 dark:bg-gray-900/80 border-r border-gray-200 dark:border-gray-700 shadow-xl transition duration-300 ease-in-out md:translate-x-0 md:static md:inset-0">

        <!-- Brand Header -->
        <div class="p-6 flex items-center gap-3">
            <div class="w-10 h-10 bg-indigo-500 text-white rounded-full flex items-center justify-center font-bold shadow-md">C</div>
            <span class="text-xl font-semibold text-gray-800 dark:text-white">The Community</span>
        </div>

        <!-- Navigation -->
        <nav class="px-4 space-y-4">
            <a href="#"
               class="flex items-center gap-3 px-4 py-2 rounded-xl text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-700 transition-all duration-200">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 12h18M3 6h18M3 18h18" />
                </svg>
                <span>Dashboard</span>
            </a>

            <div class="hidden sm:flex flex-col gap-2">
                <x-nav-link :href="route('initiatives.index')" :active="request()->routeIs('initiatives.index')" wire:navigate
                            class="flex items-center gap-3 px-4 py-2 rounded-xl text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-700 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m2.25 12l8.954-8.955a1.126 1.126 0 0 1 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                    <span>{{ __(' المبادرات المجتمعية') }}</span>
                </x-nav-link>

                <x-nav-link :href="route('campaigns.index')" :active="request()->routeIs('campaigns.index')" wire:navigate
                            class="flex items-center gap-3 px-4 py-2 rounded-xl text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-700 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122"/></svg>
                    <span>{{ __('الحملات الرسمية') }}</span>
                </x-nav-link>

                <x-nav-link :href="route('complaints.index')" :active="request()->routeIs('complaints.index')" wire:navigate
                            class="flex items-center gap-3 px-4 py-2 rounded-xl text-gray-700 dark:text-gray-200 hover:bg-indigo-100 dark:hover:bg-indigo-700 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 18a2 2 0 1 0-4 0a2 2 0 0 0 4 0zM8 18a2 2 0 1 0-4 0a2 2 0 0 0 4 0zM8 6a2 2 0 1 0-4 0a2 2 0 0 0 4 0zm12 0a2 2 0 1 0-4 0a2 2 0 0 0 4 0zm-6 6a2 2 0 1 0-4 0a2 2 0 0 0 4 0zM7.5 7.5l3 3M6 8v8m12 0V8M8 6h8m0 12H8"/></svg>
                    <span>{{ __('ادارة الشكاوي ') }}</span>
                </x-nav-link>
            </div>
        </nav>
    </div>


    <!-- Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="bg-white dark:bg-gray-800 shadow flex items-center justify-between px-4 h-16 md:h-auto md:justify-end">
            <!-- Sidebar Toggle Button -->
            <button @click="sidebarOpen = !sidebarOpen"
                    class="text-gray-500 dark:text-gray-300 md:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

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

                <!-- Navigation -->
                <livewire:layout.navigation />
            </div>
        </header>

        <!-- Page Header -->
        @if (isset($header))
            <div class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 shadow-sm">
                <div class="py-6 px-4 sm:px-6 lg:px-8 text-xl font-semibold text-gray-700 dark:text-gray-200 animate-fade-in">
                    {{ $header }}
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6 sm:p-8 bg-white/50 dark:bg-gray-900/60 backdrop-blur-xl transition-all duration-300">
            <div class="max-w-7xl mx-auto space-y-6">
                <!-- You can wrap page sections in cards for clarity -->
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-xl p-6 transition hover:shadow-2xl">
                    {{ $slot }}
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 border-t dark:border-gray-700 py-1  text-center text-sm text-gray-500 dark:text-gray-400">
            &copy; {{ now()->year }} {{ "The Community" }}. All rights reserved.
        </footer>
    </div>
</div>


@livewireScripts
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

</body>

</html>
