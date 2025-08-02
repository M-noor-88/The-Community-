<div dir="rtl">
    <div class="max-w-5xl mx-auto p-6 space-y-8">


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
                                <p class="font-bold text-gray-800 dark:text-white text-sm" dir="ltr">{{ $createdAt }}</p>
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
                                <p class="font-bold text-gray-800 dark:text-white text-sm" dir="ltr">{{ $updatedAt }}</p>
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
                                <p class="font-bold text-gray-800 dark:text-white text-sm" dir="ltr">{{ $lastStatusChangedAt }}</p>
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



        {{-- Modern Actions Section --}}
        <div class="relative bg-gradient-to-br from-white via-gray-50 to-indigo-50/30 dark:from-gray-900 dark:via-gray-850 dark:to-gray-800 rounded-3xl shadow-xl border border-gray-200/50 dark:border-gray-700/50 overflow-hidden group">

            <!-- Subtle Background Animation -->
            <div class="absolute -top-8 -right-8 w-32 h-32 bg-gradient-to-br from-indigo-400/10 via-purple-400/10 to-blue-400/10 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-700"></div>

            <div class="relative z-10 p-4 space-y-6">
                <!-- Header -->
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-800 via-indigo-600 to-purple-600 dark:from-white dark:via-indigo-400 dark:to-purple-400 bg-clip-text text-transparent">
                            الإجراءات المتاحة
                        </h3>
                        <div class="w-20 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full mt-1"></div>
                    </div>
                </div>

                @if($availableTransitions && count($availableTransitions))
                    <div class="space-y-6">
                        <!-- Current Status Display -->
                        <div class="relative bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded-2xl p-5 border border-gray-200/30 dark:border-gray-700/30">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">الحالة الحالية:</span>
                                <div class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-4 py-2 rounded-full shadow-lg">
                                    <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                    <span class="font-bold text-sm">{{ $complaint->status }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Notes Textarea -->
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">ملاحظات إضافية</label>
                            <div class="relative group">
                        <textarea wire:model.defer="notes"
                                  class="w-full p-4 bg-white/70 dark:bg-gray-800/70 backdrop-blur-sm border-2 border-gray-200/50 dark:border-gray-600/50 rounded-2xl text-gray-700 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500 resize-none transition-all duration-300 hover:border-indigo-400 dark:hover:border-indigo-500 focus:border-indigo-500 dark:focus:border-indigo-400 focus:ring-4 focus:ring-indigo-500/20 focus:outline-none"
                                  rows="4"
                                  placeholder="أضف ملاحظاتك هنا (اختياري)..."></textarea>
                                <div class="absolute bottom-3 left-3 text-xs text-gray-400">
                                    <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-4">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">التحويلات المتاحة:</p>
                            <div class="flex flex-wrap gap-3">
                                @foreach($availableTransitions as $status)
                                    <button wire:click="applyTransition('{{ $status }}')"
                                            class="group relative inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-600 hover:from-indigo-600 hover:via-purple-600 hover:to-indigo-700 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-indigo-500/20">
                                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                        <span>{{ $status }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-20 h-20 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-600 rounded-full flex items-center justify-center mx-auto mb-4 opacity-50">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0H10m4-6V7a2 2 0 00-2-2H8a2 2 0 00-2 2v4"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">لا توجد إجراءات متاحة حالياً</p>
                        <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">للدور الحالي أو حالة الشكوى</p>
                    </div>
                @endif

                @if (in_array($complaint->status, ['تم التحقق']) && in_array(auth()->user()->getRoleNames()->first(), ['government_admin', 'complaint_manager']))
                    <div class="pt-6 border-t border-gray-200/50 dark:border-gray-700/50">
                        <button wire:click="assignToFieldAgent"
                                class="group relative inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 hover:-translate-y-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <span>تعيين للموظف الميداني</span>
                        </button>
                    </div>
                @endif
            </div>

        </div>

        {{-- Modern Timeline Section --}}
        <div class="relative bg-gradient-to-br from-white via-gray-50 to-blue-50/30 dark:from-gray-900 dark:via-gray-850 dark:to-gray-800 rounded-3xl shadow-xl border border-gray-200/50 dark:border-gray-700/50 overflow-hidden group mt-4">

            <!-- Subtle Background Animation -->
            <div class="absolute -top-8 -left-8 w-32 h-32 bg-gradient-to-br from-blue-400/10 via-teal-400/10 to-green-400/10 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-700"></div>

            <div class="relative z-10 p-4">
                <!-- Header -->
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold bg-gradient-to-r from-gray-800 via-blue-600 to-teal-600 dark:from-white dark:via-blue-400 dark:to-teal-400 bg-clip-text text-transparent">
                            سجل تغيير الحالات
                        </h3>
                        <div class="w-10 h-1 bg-gradient-to-r from-blue-500 to-teal-500 rounded-full mt-1"></div>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="relative">
                    @forelse($logs as $index => $log)
                        <div class="relative flex items-start gap-1 pb-2 {{ !$loop->last ? 'border-l-2 border-gradient-to-b from-blue-300 to-teal-300 dark:from-blue-600 dark:to-teal-600 ml-6' : '' }}">

                            <!-- Timeline Dot -->
                            <div class="relative z-10 flex-shrink-0">
                                <div class="w-4 h-4 bg-gradient-to-br from-blue-500 to-teal-600 rounded-full ring-4 ring-white dark:ring-gray-900 shadow-lg animate-pulse" style="animation-delay: {{ $index * 0.1 }}s"></div>
                                @if(!$loop->last)
                                    <div class="absolute top-4 left-1/2 transform -translate-x-1/2 w-0.5 h-8 bg-gradient-to-b from-blue-300 to-teal-300 dark:from-blue-600 dark:to-teal-600"></div>
                                @endif
                            </div>

                            <!-- Timeline Content -->
                            <div class="flex-1 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm rounded-2xl p-5 border border-gray-200/30 dark:border-gray-700/30 hover:bg-white/80 dark:hover:bg-gray-800/80 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 group/item">

                                <!-- Action Description -->
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-4 h-4 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center text-white text-xs font-bold">
                                        {{ substr($log->user->name, 0, 2) }}
                                    </div>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 font-medium">
                                        <span class="font-bold text-indigo-600 dark:text-indigo-400">{{ $log->user->name }}</span>
                                        قام بتغيير الحالة من
                                        <span class="inline-flex items-center px-2 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 rounded-lg text-xs font-semibold mx-1">{{ $log->from_status }}</span>
                                        إلى
                                        <span class="inline-flex items-center px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-lg text-xs font-semibold mx-1">{{ $log->to_status }}</span>
                                    </p>
                                </div>

                                <!-- Timestamp -->
                                <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 mb-3">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $log->created_at->translatedFormat('d M Y - h:i A') }}</span>
                                </div>

                                <!-- Notes -->
                                @if ($log->notes)
                                    <div class="bg-gradient-to-br from-gray-50 via-blue-50/50 to-gray-50 dark:from-gray-700 dark:via-gray-600 dark:to-gray-700 rounded-xl p-4 border border-gray-200/50 dark:border-gray-600/50">
                                        <div class="flex items-center gap-2 mb-2">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                            </svg>
                                            <span class="text-xs font-semibold text-gray-600 dark:text-gray-400">ملاحظة:</span>
                                        </div>
                                        <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">{{ $log->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="w-20 h-20 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-600 rounded-full flex items-center justify-center mx-auto mb-4 opacity-50">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 font-medium">لا يوجد سجل حتى الآن</p>
                            <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">سيظهر هنا تاريخ تغيير الحالات</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>


        {{-- Compact Durations Section --}}
        <div class="relative bg-gradient-to-br from-white via-gray-50 to-purple-50/20 dark:from-gray-900 dark:via-gray-850 dark:to-gray-800 rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">

            <!-- Subtle Background -->
            <div class="absolute -top-4 -right-4 w-20 h-20 bg-gradient-to-br from-purple-400/10 to-blue-400/10 rounded-full blur-xl"></div>

            <div class="relative z-10 p-5">
                <!-- Compact Header -->
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">المدة في كل حالة</h3>
                </div>

                <!-- Compact Table -->
                <div class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-sm rounded-xl border border-gray-200/30 dark:border-gray-700/30 overflow-hidden">
                    <div class="grid grid-cols-4 gap-2 bg-gradient-to-r from-gray-100 to-gray-50 dark:from-gray-700 dark:to-gray-600 p-3 text-xs font-semibold text-gray-700 dark:text-gray-300">
                        <div>الحالة</div>
                        <div>دخول</div>
                        <div>خروج</div>
                        <div>المدة</div>
                    </div>

                    <div class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                        @forelse($durations as $duration)
                            <div class="grid grid-cols-4 gap-2 p-3 text-xs hover:bg-white/80 dark:hover:bg-gray-800/80 transition-colors duration-200 group">
                                <div class="font-medium text-gray-800 dark:text-white">
                                    <span class="inline-block w-2 h-2 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full mr-2 group-hover:animate-pulse"></span>
                                    {{ $duration->status }}
                                </div>
                                <div class="text-gray-600 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($duration->entered_at)->translatedFormat('d M') }}
                                </div>
                                <div class="text-gray-600 dark:text-gray-400">
                                    {{ $duration->left_at ? \Carbon\Carbon::parse($duration->left_at)->translatedFormat('d M') : 'جاري' }}
                                </div>
                                <div class="font-semibold text-gray-700 dark:text-gray-300">
                                    @php
                                        $start = \Carbon\Carbon::parse($duration->entered_at);
                                        $end = $duration->left_at ? \Carbon\Carbon::parse($duration->left_at) : now();
                                        $diff = $start->diff($end);
                                    @endphp
                                    <span class="text-indigo-600 dark:text-indigo-400">Day: {{ $diff->d }} </span>
                                    <span class="text-amber-600 dark:text-amber-400 mr-1">Hour: {{ $diff->h }} </span>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center">
                                <div class="w-12 h-12 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-2 opacity-50">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">لا توجد بيانات مدة</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Compact Info Cards --}}
        <div class="grid sm:grid-cols-2 gap-4 mt-4">
            {{-- Submitted By Card --}}
            <div class="relative bg-gradient-to-br from-white via-blue-50/30 to-white dark:from-gray-900 dark:via-gray-850 dark:to-gray-800 rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden group hover:shadow-xl transition-all duration-300">

                <!-- Background Element -->
                <div class="absolute -top-3 -right-3 w-16 h-16 bg-gradient-to-br from-blue-400/10 to-purple-400/10 rounded-full blur-lg group-hover:scale-110 transition-transform duration-500"></div>

                <div class="relative z-10 p-4">
                    <!-- Header -->
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-sm text-gray-800 dark:text-white">مقدم الشكوى</h4>
                    </div>

                    <!-- User Info -->
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <img src="{{ $complaint->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($complaint->user->name) }}"
                                 class="w-10 h-10 rounded-full object-cover border-2 border-white dark:border-gray-700 shadow-md group-hover:scale-110 transition-transform duration-300" />
                            <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 rounded-full border border-white dark:border-gray-800"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-sm text-gray-900 dark:text-white truncate">{{ $complaint->user->name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $complaint->user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Assigned Agent Card --}}
            <div class="relative bg-gradient-to-br from-white via-green-50/30 to-white dark:from-gray-900 dark:via-gray-850 dark:to-gray-800 rounded-2xl shadow-lg border border-gray-200/50 dark:border-gray-700/50 overflow-hidden group hover:shadow-xl transition-all duration-300">

                <!-- Background Element -->
                <div class="absolute -top-3 -left-3 w-16 h-16 bg-gradient-to-br from-green-400/10 to-teal-400/10 rounded-full blur-lg group-hover:scale-110 transition-transform duration-500"></div>

                <div class="relative z-10 p-4">
                    <!-- Header -->
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-6 h-6 bg-gradient-to-br from-green-500 to-teal-600 rounded-lg flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                        <h4 class="font-bold text-sm text-gray-800 dark:text-white">المسؤول عن المتابعة</h4>
                    </div>

                    <!-- Agent Info -->
                    @if($complaint->assignedAgent)
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <img src="{{ $complaint->assignedAgent->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($complaint->assignedAgent->name) }}"
                                     class="w-10 h-10 rounded-full object-cover border-2 border-white dark:border-gray-700 shadow-md group-hover:scale-110 transition-transform duration-300" />
                                <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-blue-500 rounded-full border border-white dark:border-gray-800"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-sm text-gray-900 dark:text-white truncate">{{ $complaint->assignedAgent->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $complaint->assignedAgent->email }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-600 rounded-full flex items-center justify-center opacity-50">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">لم يتم الإسناد بعد</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500">في انتظار التعيين</p>
                            </div>
                        </div>
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

{{--        --}}{{-- Complaint Images --}}
{{--        <div class="bg-white p-6 rounded-xl shadow border space-y-4">--}}
{{--            <h3 class="text-lg font-semibold text-gray-800">صور الشكوى</h3>--}}
{{--            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">--}}
{{--                @forelse($complaint->complaintImages as $img)--}}
{{--                    <img src="{{ $img->image_url }}" class="rounded-lg object-cover h-32 w-full" />--}}
{{--                    <img src="{{ $img->image_url }}" class="rounded-lg object-cover h-32 w-full" />--}}

{{--                @empty--}}
{{--                    <p class="text-gray-500 col-span-full">لا توجد صور</p>--}}
{{--                @endforelse--}}
{{--            </div>--}}
{{--        </div>--}}

        {{-- Complaint Images Section --}}
        {{-- Complaint Images Section --}}
        <div class="bg-gradient-to-br from-gray-50 to-white p-8 rounded-3xl shadow-xl border border-gray-50 space-y-8">
            <h3 class="text-3xl font-light text-gray-700 tracking-wide text-center">صور الشكوى</h3>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($complaint->complaintImages as $img)
                    <div class="group relative w-full pb-[100%] rounded-xl overflow-hidden
                        shadow-md hover:shadow-lg transition-all duration-300 ease-in-out
                        transform hover:-translate-y-1">
                        <img src="{{ $img->image_url }}" alt="Complaint Image"
                             class="absolute inset-0 w-full h-full object-cover
                            transition-transform duration-300 group-hover:scale-105" />
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20
                            transition-opacity duration-300 flex items-center justify-center">
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 px-6">
                        <p class="text-gray-400 text-xl font-light leading-relaxed">
                            لا توجد صور مرفقة لهذه الشكوى في الوقت الحالي.
                        </p>
                    </div>
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
