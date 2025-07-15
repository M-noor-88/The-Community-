<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }"
     class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 shadow-sm">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">

        {{-- Brand + Primary links (desktop) --}}
        <div class="flex items-center gap-8">


            {{-- Primary nav (desktop) --}}
            <div class="hidden sm:flex gap-6">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('الصفحة الرئيسية') }}
                </x-nav-link>
                {{-- Add more links here --}}
            </div>
        </div>

        {{-- Utilities: dark‑mode toggle + profile dropdown (desktop) --}}
        <div class="hidden sm:flex items-center gap-6">
            {{-- Dark‑mode toggle --}}
            <button
                onclick="
                    document.documentElement.classList.toggle('dark');
                    localStorage.setItem('theme',
                        document.documentElement.classList.contains('dark') ? 'dark' : 'light');"
                class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-500 dark:text-gray-300 transition">
                {{-- simple sun/moon icon swap with currentColor --}}
                <svg x-show="!document.documentElement.classList.contains('dark')" xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 18.354a6.354 6.354 0 100-12.708 6.354 6.354 0 000 12.708z"/>
                </svg>
                <svg x-show="document.documentElement.classList.contains('dark')" xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z"/>
                </svg>
            </button>

            {{-- Profile dropdown --}}
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button
                        class="flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-gray-300 focus:outline-none">
                        <span x-data="{ name: @js(auth()->user()->name) }"
                              x-text="name" x-on:profile-updated.window="name = $event.detail.name"></span>
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M5.23 7.21a.75.75 0 011.06.02L10 11.178l3.71-3.95a.75.75 0 111.08 1.04l-4.25 4.53a.75.75 0 01-1.08 0l-4.25-4.53a.75.75 0 01.02-1.06z"
                                  clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile')" wire:navigate>
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <button wire:click="logout" class="w-full text-start">
                        <x-dropdown-link>{{ __('Log Out') }}</x-dropdown-link>
                    </button>
                </x-slot>
            </x-dropdown>
        </div>

        {{-- Hamburger (mobile) --}}
        <button @click="open = !open"
                class="sm:hidden p-2 rounded-md text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{ 'hidden': open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{ 'hidden': !open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" x-transition class="sm:hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            {{-- extra mobile links if needed --}}
        </div>

        <div class="border-t border-gray-200 dark:border-gray-700 pt-4 pb-1">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200" x-data="{ n: @js(auth()->user()->name) }" x-text="n"></div>
                <div class="font-medium text-sm text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>{{ __('Log Out') }}</x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>

