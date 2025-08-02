<div>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
        <div class="mx-auto max-w-7xl px-4 py-8" dir="rtl">

            <div class="flex flex-col-2 gap-2">

                {{-- Hero Header Section --}}
                <div class="text-center mb-10 w-1/2">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl mb-6 shadow-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h1 class="text-4xl font-extrabold bg-gradient-to-r from-gray-900 via-blue-800 to-purple-800 bg-clip-text text-transparent mb-4">
                        مبادرات مُلهمة
                    </h1>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        اكتشف وادعم المبادرات التي تصنع الفرق في مجتمعنا
                    </p>

                    {{-- Enhanced Top Votes Feature --}}
                    <div class="mt-8 flex justify-center">
                        <div class="relative">
                            <div class="absolute -inset-1 bg-gradient-to-r from-amber-400 via-orange-500 to-red-500 rounded-2xl blur opacity-25"></div>
                            <div class="relative bg-white rounded-2xl p-6 shadow-2xl border border-amber-100">
                                <div class="flex items-center justify-between gap-6">
                                    <div class="flex items-center gap-4">
                                        <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-r from-amber-400 to-orange-500 rounded-xl shadow-lg">
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-900">الأعلى تصويتاً</h3>
                                            <p class="text-sm text-gray-600">اعرض المبادرات الأكثر شعبية أولاً</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" wire:model="sortByTopVotes" class="sr-only peer">
                                        <div class="relative w-14 h-8 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-6 peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-7 after:w-7 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-amber-400 peer-checked:to-orange-500 shadow-lg"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                {{-- Modern Filter Controls --}}
                <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-xl border border-white/20 p-6 mb-8   z-30">


                    {{-- Category Filters --}}
                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.99 1.99 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            التصنيفات
                        </h4>

                        <div class="flex flex-wrap gap-3">
                            {{-- All Categories --}}
                            <button wire:click="$set('categoryFilter', '')"
                                    class="group flex items-center gap-3 px-5 py-3 rounded-2xl font-medium transition-all duration-300 transform hover:scale-105
                                       {{ $categoryFilter === ''
                                           ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg shadow-indigo-200'
                                           : 'bg-gray-100 text-gray-700 hover:bg-gray-200 hover:shadow-md' }}">
                                <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ $categoryFilter === '' ? 'bg-white/20' : 'bg-white' }}">
                                    <svg class="w-4 h-4 {{ $categoryFilter === '' ? 'text-white' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                                <span>جميع المبادرات</span>
                            </button>

                            @foreach ($categories as $category)
                                @php
                                    $categoryIcons = [
                                        'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', // Target/Goal
                                        'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', // Package/Project
                                        'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', // Health/Care
                                        'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707', // Environment
                                        'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z', // Innovation
                                        'M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z', // Fire/Trending
                                        'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', // Education
                                        'M13 10V3L4 14h7v7l9-11h-7z', // Energy/Power
                                        'M7 4V2a1 1 0 011-1h4a1 1 0 011 1v2h4a1 1 0 110 2h-1v10a2 2 0 01-2 2H6a2 2 0 01-2-2V6H3a1 1 0 010-2h4z' // Technology
                                    ];
                                    $iconPath = $categoryIcons[$loop->index % count($categoryIcons)];
                                @endphp
                                <button wire:click="$set('categoryFilter', {{ $category['id'] }})"
                                        class="group flex items-center gap-3 px-5 py-3 rounded-2xl font-medium transition-all duration-300 transform hover:scale-105
                                           {{ $categoryFilter == $category['id']
                                               ? 'bg-gradient-to-r from-indigo-500 to-purple-600 text-white shadow-lg shadow-indigo-200'
                                               : 'bg-gray-100 text-gray-700 hover:bg-gray-200 hover:shadow-md' }}">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-lg {{ $categoryFilter == $category['id'] ? 'bg-white/20' : 'bg-white' }}">
                                        <svg class="w-4 h-4 {{ $categoryFilter == $category['id'] ? 'text-white' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"/>
                                        </svg>
                                    </div>
                                    <span>{{ $category['name'] }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Status Filters --}}
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            حالة المبادرة
                        </h4>

                        <div class="flex flex-wrap gap-3">
                            @foreach ($statuses as $status)
                                @php
                                    $statusStyles = [
                                        'نشطة' => 'from-emerald-500 to-green-600',
                                        'منجزة' => 'from-blue-500 to-indigo-600',
                                        'ملغية' => 'from-red-500 to-pink-600',
                                        'قيد التنفيذ' => 'from-amber-500 to-orange-600'
                                    ];
                                    $gradient = $statusStyles[$status] ?? 'from-gray-500 to-gray-600';
                                @endphp
                                <button wire:click="$set('statusFilter', '{{ $status }}')"
                                        class="px-6 py-3 rounded-2xl font-medium text-sm transition-all duration-300 transform hover:scale-105
                                           {{ $statusFilter === $status
                                                ? 'bg-gradient-to-r ' . $gradient . ' text-white shadow-lg'
                                                : 'bg-gray-100 text-gray-700 hover:bg-gray-200 hover:shadow-md' }}">
                                    {{ $status }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

            {{-- Beautiful Initiatives Grid --}}
            <div class="grid gap-8">
                @forelse ($initiatives as $project)
                    <div class="group bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100 transform hover:-translate-y-2">
                        <div class="flex flex-col lg:flex-row">

                            {{-- Image Section with Overlays --}}
                            <div class="lg:w-80 h-64 lg:h-72 relative overflow-hidden">
                                <img src="{{ $project['image_url'] }}"
                                     alt="{{ $project['title'] }}"
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />

                                {{-- Gradient Overlay --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

                                {{-- Status Badge --}}
                                <div class="absolute top-4 right-4">
                                    @php
                                        $statusConfig = [
                                            'نشطة' => ['bg' => 'from-emerald-400 to-green-500', 'icon' => 'M5 13l4 4L19 7'],
                                            'منجزة' => ['bg' => 'from-blue-400 to-indigo-500', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                                            'ملغية' => ['bg' => 'from-red-400 to-pink-500', 'icon' => 'M6 18L18 6M6 6l12 12']
                                        ];
                                        $config = $statusConfig[$project['status']] ?? ['bg' => 'from-gray-400 to-gray-500', 'icon' => 'M12 8v4m0 4h.01'];
                                    @endphp
                                    <div class="flex items-center gap-2 bg-gradient-to-r {{ $config['bg'] }} text-white px-4 py-2 rounded-2xl backdrop-blur-sm shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}"/>
                                        </svg>
                                        <span class="text-sm font-medium">{{ $project['status'] }}</span>
                                    </div>
                                </div>

                                {{-- Vote Count Badge --}}
                                @if($project['votes_count'] > 0)
                                    <div class="absolute bottom-4 right-4">
                                        <div class="flex items-center gap-2 bg-gradient-to-r from-amber-400 to-orange-500 text-white px-4 py-2 rounded-2xl backdrop-blur-sm shadow-lg">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            <span class="text-sm font-bold">{{ $project['votes_count'] }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- Content Section --}}
                            <div class="flex-1 p-8 lg:p-10 space-y-6">
                                <div>
                                    <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-4 group-hover:text-indigo-600 transition-colors leading-tight">
                                        {{ $project['title'] }}
                                    </h2>
                                    <p class="text-gray-600 leading-relaxed text-lg">
                                        {{ Str::limit($project['description'], 150) }}
                                    </p>
                                </div>

                                {{-- Meta Information Grid --}}
                                <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">
                                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-4 border border-blue-100">
                                        <div class="flex items-center gap-3 mb-2">
                                            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.99 1.99 0 013 12V7a4 4 0 014-4z"/>
                                                </svg>
                                            </div>
                                            <span class="text-xs font-medium text-blue-600">التصنيف</span>
                                        </div>
                                        <p class="text-sm font-semibold text-blue-900">{{ $project['category'] }}</p>
                                    </div>

                                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-4 border border-green-100">
                                        <div class="flex items-center gap-3 mb-2">
                                            <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                            </div>
                                            <span class="text-xs font-medium text-green-600">الموقع</span>
                                        </div>
                                        <p class="text-sm font-semibold text-green-900">{{ $project['location']['name'] }}</p>
                                    </div>

                                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-4 border border-purple-100">
                                        <div class="flex items-center gap-3 mb-2">
                                            <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <span class="text-xs font-medium text-purple-600">التاريخ</span>
                                        </div>
                                        <p class="text-sm font-semibold text-purple-900">{{ $project['created_at'] }}</p>
                                    </div>
                                </div>

                                {{-- Engagement Stats --}}
                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <div class="flex items-center gap-6">
                                        <div class="flex items-center gap-2 text-emerald-600">
                                            <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                                            <span class="text-sm font-medium">{{ $project['likes'] }} إعجاب</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-red-500">
                                            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                            <span class="text-sm font-medium">{{ $project['dislikes'] }} عدم إعجاب</span>
                                        </div>
                                    </div>

                                    <button class="group flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white px-6 py-3 rounded-2xl font-medium transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                        <span>استكشف المزيد</span>
                                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20">
                        <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-r from-gray-100 to-gray-200 rounded-3xl mb-6">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-700 mb-4">لا توجد مبادرات متاحة</h3>
                        <p class="text-gray-500 text-lg max-w-md mx-auto">
                            جرب تعديل المرشحات أو ابحث عن مبادرات أخرى
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
