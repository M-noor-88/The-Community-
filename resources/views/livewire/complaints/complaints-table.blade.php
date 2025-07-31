<div class="space-y-8" dir="rtl">
    <!-- Filters -->
    <!-- Modern Filters Section -->
    <div class="relative bg-gradient-to-br from-white via-gray-50 to-blue-50/30 dark:from-gray-900 dark:via-gray-850 dark:to-gray-800 rounded-3xl shadow-xl border border-gray-200/50 dark:border-gray-700/50 p-8 backdrop-blur-sm overflow-hidden">

        <!-- Decorative Background Elements -->
        <div class="absolute -top-6 -right-6 w-32 h-32 bg-gradient-to-br from-blue-400/10 via-purple-400/10 to-pink-400/10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-6 -left-6 w-40 h-40 bg-gradient-to-tr from-green-400/10 via-blue-400/10 to-purple-400/10 rounded-full blur-2xl"></div>

        <!-- Header -->
        <div class="flex items-center gap-3 mb-8 relative z-10">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold bg-gradient-to-r from-gray-800 via-gray-900 to-gray-800 dark:from-white dark:via-gray-100 dark:to-white bg-clip-text text-transparent">فلترة النتائج</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">اختر المعايير للبحث المتقدم</p>
            </div>
        </div>

        <!-- Filters Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 relative z-10">

            <!-- Status Filter -->
            <div class="group relative" >
                <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                    <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                    الحالة
                </label>
                <div class="relative">
                    <select wire:model.lazy="status"
                            class=" text-center w-full px-4 py-3.5 bg-white/80 dark:bg-gray-800/80 border-2 border-gray-200/50 dark:border-gray-600/50 rounded-2xl text-gray-700 dark:text-gray-200 font-medium shadow-sm backdrop-blur-sm transition-all duration-300 hover:border-blue-400 dark:hover:border-blue-500 focus:border-blue-500 dark:focus:border-blue-400 focus:ring-4 focus:ring-blue-500/20 focus:outline-none appearance-none cursor-pointer "
                            >
                        <option value="" >كل الحالات</option>
                        @foreach($statuses as $s)
                            <option value="{{ $s }}">{{ $s }}</option>
                        @endforeach
                    </select>
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    <!-- Animated underline -->
                    <div class="absolute bottom-0 left-0 h-0.5 bg-gradient-to-r from-blue-500 to-purple-500 w-0 group-hover:w-full transition-all duration-500 rounded-full"></div>
                </div>
            </div>

            <!-- Category Filter -->
            <div class="group relative">
                <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse" style="animation-delay: 0.2s"></div>
                    القسم
                </label>
                <div class="relative">
                    <select wire:model.lazy="categoryId"
                            class="text-center w-full px-4 py-3.5 bg-white/80 dark:bg-gray-800/80 border-2 border-gray-200/50 dark:border-gray-600/50 rounded-2xl text-gray-700 dark:text-gray-200 font-medium shadow-sm backdrop-blur-sm transition-all duration-300 hover:border-green-400 dark:hover:border-green-500 focus:border-green-500 dark:focus:border-green-400 focus:ring-4 focus:ring-green-500/20 focus:outline-none appearance-none cursor-pointer">
                        <option value="">كل الأقسام</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-green-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    <!-- Animated underline -->
                    <div class="absolute bottom-0 left-0 h-0.5 bg-gradient-to-r from-green-500 to-teal-500 w-0 group-hover:w-full transition-all duration-500 rounded-full"></div>
                </div>
            </div>

            <!-- Region Search -->
            <div class="group relative">
                <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                    <div class="w-2 h-2 bg-purple-500 rounded-full animate-pulse" style="animation-delay: 0.4s"></div>
                    بحث بالمنطقة
                </label>
                <div class="relative">
                    <input wire:model.debounce.500ms="region"
                           type="text"
                           placeholder="مثال: الميدان"
                           class="w-full px-4 py-3.5 pr-12 bg-white/80 dark:bg-gray-800/80 border-2 border-gray-200/50 dark:border-gray-600/50 rounded-2xl text-gray-700 dark:text-gray-200 font-medium shadow-sm backdrop-blur-sm transition-all duration-300 hover:border-purple-400 dark:hover:border-purple-500 focus:border-purple-500 dark:focus:border-purple-400 focus:ring-4 focus:ring-purple-500/20 focus:outline-none placeholder-gray-400 dark:placeholder-gray-500">
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-500 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <!-- Animated underline -->
                    <div class="absolute bottom-0 left-0 h-0.5 bg-gradient-to-r from-purple-500 to-pink-500 w-0 group-hover:w-full transition-all duration-500 rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200/50 dark:border-gray-700/50 relative z-10">
            <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <span>البحث تلقائي</span>
            </div>

            <button type="button"
                    wire:click="resetFilters"
                    class="group inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 hover:from-gray-200 hover:to-gray-300 dark:hover:from-gray-600 dark:hover:to-gray-500 text-gray-700 dark:text-gray-200 font-semibold rounded-xl shadow-sm transition-all duration-300 hover:shadow-md hover:scale-105">
                <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                <span>إعادة تعيين</span>
            </button>
        </div>

        <!-- Loading Indicator -->
        <div wire:loading.flex class="absolute inset-0 bg-white/50 dark:bg-gray-900/50 backdrop-blur-sm rounded-3xl items-center justify-center z-50">
            <div class="flex items-center gap-3 bg-white dark:bg-gray-800 px-6 py-3 rounded-2xl shadow-lg">
                <svg class="w-5 h-5 text-blue-500 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Complaint Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($complaints as $complaint)
            <a href="{{ route('complaints.show', $complaint['id']) }}">

            <div class="relative flex flex-col w-full bg-white dark:bg-gray-800 shadow-sm border border-slate-200 dark:border-gray-700 rounded-lg overflow-hidden">
                <!-- Image Section -->
                <div class="relative p-2.5 w-full h-48 shrink-0 overflow-hidden">
                    @if($complaint->complaintImages()->first()->image_url)
                        <img
                            src="{{ $complaint->complaintImages()->first()->image_url }}"
                            alt="صورة الشكوى"
                            class="h-full w-full rounded-md object-cover"
                        />
                    @else
                        <div class="h-full w-full bg-gray-100 dark:bg-gray-700 rounded-md flex items-center justify-center text-gray-400 dark:text-gray-500">
                            لا توجد صورة
                        </div>
                    @endif
                </div>

                <!-- Content Section -->
                <div class="p-5 space-y-4">
                    <!-- Status Badge -->
                    @php
                        $statusConfig = [
                            'انتظار' => 'bg-blue-500 text-white',
                            'يتم التنفيذ' => 'bg-amber-500 text-white',
                            'منجزة' => 'bg-green-500 text-white',
                            'مغلقة' => 'bg-green-900 text-white',
                        ];
                        $colorClass = $statusConfig[$complaint->status] ?? 'bg-red-500 text-white';
                    @endphp

                    <div class="inline-flex items-center gap-2 {{ $colorClass }} px-3 py-1.5 rounded-lg text-sm font-medium transition-all duration-300 hover:scale-105 hover:shadow-lg">
                        @if($complaint->status == 'انتظار')
                            <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        @elseif($complaint->status == 'يتم التنفيذ')
                            <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        @elseif($complaint->status == 'مغلقة')
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        @else
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10m4-6V7a2 2 0 00-2-2H8a2 2 0 00-2 2v4"></path>
                            </svg>
                        @endif
                        {{ $complaint->status }}
                    </div>

                    <!-- Title -->
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white leading-snug">
                        {{ $complaint->title }}
                    </h4>

                    <!-- Details List -->
                    <div class="space-y-3">
                        <!-- Category -->
                        <div class="flex items-center gap-3 text-gray-600 dark:text-gray-300 group transition-colors duration-200 hover:text-blue-600 dark:hover:text-blue-400">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center group-hover:bg-blue-200 dark:group-hover:bg-blue-800/50 transition-colors duration-200">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="text-sm font-medium">القسم:</span>
                                <span class="mr-2 font-semibold">{{ $complaint->category->name ?? '-' }}</span>
                            </div>
                        </div>

                        <!-- Region -->
                        <div class="flex items-center gap-3 text-gray-600 dark:text-gray-300 group transition-colors duration-200 hover:text-green-600 dark:hover:text-green-400">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center group-hover:bg-green-200 dark:group-hover:bg-green-800/50 transition-colors duration-200">
                                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="text-sm font-medium">المنطقة:</span>
                                <span class="mr-2 font-semibold">{{ $complaint->region }}</span>
                            </div>
                        </div>

                        <!-- Priority -->
                        <div class="flex items-center gap-3 text-gray-600 dark:text-gray-300 group transition-colors duration-200">
                            @php
                                $priorityClass = $complaint->priority_points > 7 ? 'text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300' :
                                               ($complaint->priority_points > 3 ? 'text-amber-600 dark:text-amber-400 hover:text-amber-700 dark:hover:text-amber-300' :
                                               'text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300');
                                $priorityBg = $complaint->priority_points > 7 ? 'bg-red-100 dark:bg-red-900/30 group-hover:bg-red-200 dark:group-hover:bg-red-800/50' :
                                            ($complaint->priority_points > 3 ? 'bg-amber-100 dark:bg-amber-900/30 group-hover:bg-amber-200 dark:group-hover:bg-amber-800/50' :
                                            'bg-green-100 dark:bg-green-900/30 group-hover:bg-green-200 dark:group-hover:bg-green-800/50');
                                $priorityText = $complaint->priority_points > 7 ? 'عالي' : ($complaint->priority_points > 3 ? 'متوسط' : 'منخفض');
                            @endphp

                            <div class="flex-shrink-0 w-8 h-8 {{ $priorityBg }} rounded-lg flex items-center justify-center transition-colors duration-200 {{ $priorityClass }}">
                                @if($complaint->priority_points > 7)
                                    <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                @elseif($complaint->priority_points > 3)
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div class="{{ $priorityClass }}">
                                <span class="text-sm font-medium">الأولوية:</span>
                                <span class="mr-2 font-semibold">{{ $priorityText }}</span>
                                <div class="flex gap-1 mt-1">
                                    @for($i = 0; $i < min($complaint->priority_points, 10); $i++)
                                        <div class="w-1.5 h-1.5 rounded-full {{ $complaint->priority_points > 7 ? 'bg-red-400' : ($complaint->priority_points > 3 ? 'bg-amber-400' : 'bg-green-400') }} animate-pulse" style="animation-delay: {{ $i * 0.1 }}s"></div>
                                    @endfor
                                </div>
                            </div>
                        </div>

                        <!-- User -->
                        <div class="flex items-center gap-3 text-gray-600 dark:text-gray-300 group transition-colors duration-200 hover:text-purple-600 dark:hover:text-purple-400">
                            <div class="flex-shrink-0 w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center group-hover:bg-purple-200 dark:group-hover:bg-purple-800/50 transition-colors duration-200">
                                <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <span class="text-sm font-medium">المستخدم:</span>
                                <span class="mr-2 font-semibold">{{ $complaint->user->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center text-gray-500 dark:text-gray-400 py-8">
                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="mt-4 text-lg">لا توجد شكاوى متاحة</p>
            </div>
            </a>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pt-4">
        {{ $complaints->links('pagination::tailwind') }}
    </div>
</div>
