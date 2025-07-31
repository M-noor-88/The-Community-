<div dir="rtl">
    <div class="max-w-5xl mx-auto p-6 space-y-8">

        {{-- Complaint Info --}}
{{--        <div class="bg-white p-6 rounded-xl shadow border space-y-4">--}}
{{--            <h2 class="text-2xl font-bold text-gray-900">الشكوى: {{ $complaint->title }}</h2>--}}

{{--            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 text-sm text-gray-700">--}}
{{--                <div><strong>القسم:</strong> {{ $complaint->category->name ?? '-' }}</div>--}}
{{--                <div><strong>الحالة:</strong> {{ $complaint->status }}</div>--}}
{{--                <div><strong>النقاط:</strong> {{ $complaint->priority_points }}</div>--}}
{{--                <div><strong>المنطقة:</strong> {{ $complaint->region }}</div>--}}
{{--                <div><strong>المستخدم:</strong> {{ $complaint->user->name }}</div>--}}
{{--                <div><strong>تم الإسناد إلى:</strong> {{ $complaint->assignedAgent->name ?? '-' }}</div>--}}
{{--                <div><strong>تاريخ الإنشاء:</strong> {{ $createdAt }}</div>--}}
{{--                <div><strong>آخر تحديث:</strong> {{ $updatedAt }}</div>--}}
{{--                <div><strong>تاريخ آخر تغيير حالة:</strong> {{ $lastStatusChangedAt }}</div>--}}

{{--            </div>--}}

{{--            <p class="mt-4 text-gray-600 text-sm leading-relaxed">{{ $complaint->description }}</p>--}}
{{--        </div>--}}


{{--        --------------------}}



        {{-- Modern Complaint Info Card --}}
        <div class="relative bg-gradient-to-br from-white via-gray-50 to-blue-50/30 dark:from-gray-900 dark:via-gray-850 dark:to-gray-800 rounded-3xl shadow-2xl border border-gray-200/50 dark:border-gray-700/50 overflow-hidden group hover:shadow-3xl transition-all duration-500 transform hover:-translate-y-1 ">

            <!-- Animated Background Elements -->
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-gradient-to-br from-blue-400/10 via-purple-400/10 to-pink-400/10 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-700"></div>
            <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-gradient-to-tr from-green-400/10 via-blue-400/10 to-purple-400/10 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-700"></div>

            <!-- Status Badge Overlay -->
            @php
                $statusConfig = [
                    'انتظار' => ['bg' => 'from-blue-500 to-blue-600', 'icon' => '⏳', 'pulse' => 'bg-blue-400'],
                    'يتم التنفيذ' => ['bg' => 'from-amber-500 to-orange-600', 'icon' => '⚡', 'pulse' => 'bg-amber-400'],
                    'منجزة' => ['bg' => 'from-green-500 to-emerald-600', 'icon' => '✅', 'pulse' => 'bg-green-400'],
                    'مغلقة' => ['bg' => 'from-red-500 to-rose-600', 'icon' => '🔒', 'pulse' => 'bg-red-400'],
                ];
                $status = $statusConfig[$complaint->status] ?? ['bg' => 'from-gray-500 to-gray-600', 'icon' => '📋', 'pulse' => 'bg-gray-400'];
            @endphp

            <div class="absolute top-6 left-6 z-10">
                <div class="relative inline-flex items-center gap-2 bg-gradient-to-r {{ $status['bg'] }} text-white px-4 py-2 rounded-full shadow-lg">
                    <span class="text-sm">{{ $status['icon'] }}</span>
                    <span class="font-bold text-sm">{{ $complaint->status }}</span>
                    <div class="absolute -inset-1 {{ $status['bg'] }} rounded-full opacity-30 animate-ping"></div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="relative z-10 p-4">

                <!-- Header Section -->
                <div class="mb-4">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-2xl font-black bg-gradient-to-r from-gray-800 via-gray-900 to-indigo-600 dark:from-white dark:via-gray-100 dark:to-blue-400 bg-clip-text text-transparent leading-tight">
                                {{ $complaint->title }}
                            </h2>
                            <div class="w-24 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full mt-2"></div>
                        </div>
                    </div>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                    <!-- Category -->
                    <div class="group/item relative bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded-2xl p-4 border border-gray-200/30 dark:border-gray-700/30 hover:bg-white/80 dark:hover:bg-gray-800/80 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md group-hover/item:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">القسم</p>
                                <p class="font-bold text-gray-800 dark:text-white">{{ $complaint->category->name ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Priority Points -->
                    <div class="group/item relative bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded-2xl p-4 border border-gray-200/30 dark:border-gray-700/30 hover:bg-white/80 dark:hover:bg-gray-800/80 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="flex items-center gap-3">
                            @php
                                $priorityConfig = $complaint->priority_points > 7 ?
                                    ['color' => 'from-red-500 to-rose-600', 'icon' => '🔥'] :
                                    ($complaint->priority_points > 3 ?
                                        ['color' => 'from-amber-500 to-orange-600', 'icon' => '⚡'] :
                                        ['color' => 'from-green-500 to-emerald-600', 'icon' => '🌱']);
                            @endphp
                            <div class="w-12 h-12 bg-gradient-to-br {{ $priorityConfig['color'] }} rounded-xl flex items-center justify-center shadow-md group-hover/item:scale-110 transition-transform duration-300">
                                <span class="text-lg">{{ $priorityConfig['icon'] }}</span>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">النقاط</p>
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-gray-800 dark:text-white">{{ $complaint->priority_points }}</span>
                                    <div class="flex gap-0.5">
                                        @for($i = 0; $i < min($complaint->priority_points, 5); $i++)
                                            <div class="w-1.5 h-1.5 rounded-full bg-gradient-to-r {{ $priorityConfig['color'] }} animate-pulse" style="animation-delay: {{ $i * 0.1 }}s"></div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Region -->
                    <div class="group/item relative bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded-2xl p-4 border border-gray-200/30 dark:border-gray-700/30 hover:bg-white/80 dark:hover:bg-gray-800/80 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-md group-hover/item:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">المنطقة</p>
                                <p class="font-bold text-gray-800 dark:text-white">{{ $complaint->region }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- User -->
                    <div class="group/item relative bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded-2xl p-4 border border-gray-200/30 dark:border-gray-700/30 hover:bg-white/80 dark:hover:bg-gray-800/80 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md group-hover/item:scale-110 transition-transform duration-300 text-white font-bold">
                                    {{ substr($complaint->user->name, 0, 2) }}
                                </div>
                                <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white dark:border-gray-800 animate-pulse"></div>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">المستخدم</p>
                                <p class="font-bold text-gray-800 dark:text-white">{{ $complaint->user->name }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Assigned Agent -->
                    <div class="group/item relative bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded-2xl p-4 border border-gray-200/30 dark:border-gray-700/30 hover:bg-white/80 dark:hover:bg-gray-800/80 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-md group-hover/item:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">المسؤول</p>
                                <p class="font-bold text-gray-800 dark:text-white">{{ $complaint->assignedAgent->name ?? 'غير محدد' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Created Date -->
                    <div class="group/item relative bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded-2xl p-4 border border-gray-200/30 dark:border-gray-700/30 hover:bg-white/80 dark:hover:bg-gray-800/80 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-md group-hover/item:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">تاريخ الإنشاء</p>
                                <p class="font-bold text-gray-800 dark:text-white text-sm">{{ $createdAt }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Last Updated -->
                    <div class="group/item relative bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded-2xl p-4 border border-gray-200/30 dark:border-gray-700/30 hover:bg-white/80 dark:hover:bg-gray-800/80 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-md group-hover/item:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">آخر تحديث</p>
                                <p class="font-bold text-gray-800 dark:text-white text-sm">{{ $updatedAt }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Last Status Change -->
                    <div class="group/item relative bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded-2xl p-4 border border-gray-200/30 dark:border-gray-700/30 hover:bg-white/80 dark:hover:bg-gray-800/80 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-rose-500 to-pink-600 rounded-xl flex items-center justify-center shadow-md group-hover/item:scale-110 transition-transform duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h2m0 0h2a2 2 0 002-2V7a2 2 0 00-2-2h-2m0 0V3a2 2 0 012-2h2a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">تغيير الحالة</p>
                                <p class="font-bold text-gray-800 dark:text-white text-sm">{{ $lastStatusChangedAt }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Section -->
                <div class="relative bg-gradient-to-br from-gray-50 via-blue-50/50 to-gray-50 dark:from-gray-800 dark:via-gray-700 dark:to-gray-800 rounded-2xl p-6 border border-gray-200/50 dark:border-gray-700/50 backdrop-blur-sm">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">وصف الشكوى</h3>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-sm">{{ $complaint->description }}</p>
                </div>
            </div>

            <!-- Floating Elements -->
            <div class="absolute bottom-0 left-4 opacity-30">
                <div class="flex gap-1">
                    <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-purple-500 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                    <div class="w-2 h-2 bg-pink-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                </div>
            </div>
        </div>








{{--        ---------------------}}
        {{-- Actions Section --}}
        <div class="bg-white p-6 rounded-xl shadow border space-y-4">
            <h3 class="text-lg font-semibold text-gray-800">الإجراءات المتاحة</h3>

            @if($availableTransitions && count($availableTransitions))
                <div class="space-y-4">
                    <div class="text-sm text-gray-600">
                        الحالة الحالية:
                        <span class="font-bold text-indigo-700">{{ $complaint->status }}</span>
                    </div>

                    <textarea wire:model.defer="notes"
                              class="w-full mt-2 p-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
                              placeholder="ملاحظات (اختياري)"></textarea>

                    <div class="flex flex-wrap gap-2 mt-3">
                        @foreach($availableTransitions as $status)
                            <button wire:click="applyTransition('{{ $status }}')"
                                    class="px-4 py-2 rounded-full text-sm font-semibold transition duration-300
                                   bg-indigo-600 hover:bg-indigo-700 text-white shadow">
                                تحويل إلى: {{ $status }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @else
                <p class="text-sm text-gray-500">لا توجد إجراءات متاحة حالياً لهذا الدور أو الحالة.</p>
            @endif

            @if (in_array($complaint->status, ['تم التحقق']) && in_array(auth()->user()->getRoleNames()->first(), ['government_admin', 'complaint_manager']))
                <div class="mt-4">
                    <button wire:click="assignToFieldAgent"
                            class="px-4 py-2 rounded-full bg-amber-600 hover:bg-amber-700 text-white shadow text-sm">
                        تعيين للموظف ميداني
                    </button>
                </div>
            @endif

        </div>


        {{-- Timeline --}}
        <div class="bg-white p-6 rounded-xl shadow border space-y-4">
            <h3 class="text-lg font-semibold text-gray-800">سجل تغيير الحالات</h3>

            <div class="space-y-6 border-r-2 border-indigo-500 pr-4 relative">
                @forelse($logs as $log)
                    <div class="relative">
                        <div class="absolute right-[-11px] top-1 w-4 h-4 bg-indigo-500 rounded-full ring-4 ring-white"></div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-700">
                                <span class="font-bold">{{ $log->user->name }}</span>
                                قام بتغيير الحالة من
                                <span class="text-yellow-700 font-semibold">{{ $log->from_status }}</span>
                                إلى
                                <span class="text-green-600 font-semibold">{{ $log->to_status }}</span>
                            </p>
                            <p class="text-xs text-gray-500 mt-1">{{ $log->created_at->translatedFormat('d M Y - h:i A') }}</p>
                            @if ($log->notes)
                                <div class="text-xs text-gray-600 mt-2 border rounded p-2 bg-gray-50">
                                    {{ $log->notes }}
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">لا يوجد سجل حتى الآن.</p>
                @endforelse
            </div>
        </div>


        {{-- Durations --}}
        <div class="bg-white p-6 rounded-xl shadow border space-y-4">
            <h3 class="text-lg font-semibold text-gray-800">المدة في كل حالة</h3>
            <table class="w-full text-sm text-right border rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-700 font-semibold">
                <tr>
                    <th class="py-2 px-3">الحالة</th>
                    <th class="py-2 px-3">تاريخ الدخول</th>
                    <th class="py-2 px-3">تاريخ الخروج</th>
                    <th class="py-2 px-3">المدة</th>
                </tr>
                </thead>
                <tbody class="divide-y">
                @forelse($durations as $duration)
                    <tr>
                        <td class="py-2 px-3">{{ $duration->status }}</td>
                        <td class="py-2 px-3">{{ \Carbon\Carbon::parse($duration->entered_at)->translatedFormat('d M Y - h:i A') }}</td>
                        <td class="py-2 px-3">{{ $duration->left_at ? \Carbon\Carbon::parse($duration->left_at)->translatedFormat('d M Y - h:i A') : 'جاري' }}</td>
                        <td class="py-2 px-3">
                            @php
                                $start = \Carbon\Carbon::parse($duration->entered_at);
                                $end = $duration->left_at ? \Carbon\Carbon::parse($duration->left_at) : now();
                                $diff = $start->diff($end);
                            @endphp
                            {{ $diff->d }} يوم {{ $diff->h }} ساعة {{ $diff->i }} دقيقة
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="py-4 text-center text-gray-500">لا توجد بيانات مدة</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Info Cards --}}
        <div class="grid sm:grid-cols-2 gap-6">
            {{-- Submitted By --}}
            <div class="bg-white p-5 rounded-xl shadow border text-sm space-y-2">
                <h4 class="font-semibold text-gray-800 mb-2">مقدم الشكوى</h4>
                <div class="flex items-center gap-3">
                    <img src="{{ $complaint->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($complaint->user->name) }}"
                         class="w-12 h-12 rounded-full object-cover border shadow" />
                    <div>
                        <p class="font-medium text-gray-900">{{ $complaint->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $complaint->user->email }}</p>
                    </div>
                </div>
            </div>

            {{-- Assigned Agent --}}
            <div class="bg-white p-5 rounded-xl shadow border text-sm space-y-2">
                <h4 class="font-semibold text-gray-800 mb-2">المسؤول عن المتابعة</h4>
                <div class="flex items-center gap-3">
                    @if($complaint->assignedAgent)
                        <img src="{{ $complaint->assignedAgent->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($complaint->assignedAgent->name) }}"
                             class="w-12 h-12 rounded-full object-cover border shadow" />
                        <div>
                            <p class="font-medium text-gray-900">{{ $complaint->assignedAgent->name }}</p>
                            <p class="text-xs text-gray-500">{{ $complaint->assignedAgent->email }}</p>
                        </div>
                    @else
                        <p class="text-gray-500">لم يتم الإسناد بعد.</p>
                    @endif
                </div>
            </div>
        </div>


        {{-- Location Map --}}
        @php
            $locations = [
                [
                    'lat' => $complaint->location->latitude,
                    'lng' => $complaint->location->longitude,
                    'name' => $complaint->location->name,
                    'description' => $complaint->region,
                ],
                // Add more if needed
            ];
        @endphp

        <div class="bg-white p-6 rounded-xl shadow border space-y-4">
            <h3 class="text-lg font-semibold text-gray-800">الموقع</h3>
            <livewire:map.map-dynamic-component :locations="$locations" />
        </div>

        {{-- Complaint Images --}}
        <div class="bg-white p-6 rounded-xl shadow border space-y-4">
            <h3 class="text-lg font-semibold text-gray-800">صور الشكوى</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                @forelse($complaint->complaintImages as $img)
                    <img src="{{ $img->image_url }}" class="rounded-lg object-cover h-32 w-full" />
                    <img src="{{ $img->image_url }}" class="rounded-lg object-cover h-32 w-full" />

                @empty
                    <p class="text-gray-500 col-span-full">لا توجد صور</p>
                @endforelse
            </div>
        </div>

        {{-- Achievement Images --}}
        <div class="bg-white p-6 rounded-xl shadow border space-y-4">
            <h3 class="text-lg font-semibold text-gray-800">صور الإنجاز</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                @forelse($complaint->achievementImages as $img)
                    <img src="{{ $img->image_url }}" class="rounded-lg object-cover h-32 w-full" />
                @empty
                    <p class="text-gray-500 col-span-full">لا توجد صور</p>
                @endforelse
            </div>
        </div>

        @if(auth()->user()->hasRole('field_agent')  && in_array($complaint->status , ['مغلقة' , 'منجزة']))
            <div class="mt-6 p-4 bg-white rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-3">رفع صور الإنجاز</h3>

                <input type="file" wire:model="achievementImages" multiple accept="image/*" class="mb-3" />

                @error('achievementImages.*')
                <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror

                <button wire:click="uploadAchievementImages"
                        class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    رفع الصور
                </button>

            </div>
        @endif


    </div>

</div>
