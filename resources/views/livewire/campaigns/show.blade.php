<div class="mx-auto max-w-7xl px-4 py-6 space-y-6" dir="rtl">

    {{-- Compact Header & Hero Layout --}}
    <div class="bg-gradient-to-r from-indigo-50 via-white to-purple-50 rounded-2xl overflow-hidden shadow-xl border border-gray-100">
        <div class="flex flex-col lg:flex-row">
            {{-- Hero image - Smaller, side-by-side --}}
            <div class="lg:w-1/3">
                <div class="relative group overflow-hidden h-48 lg:h-64">
                    <img src="{{ $project['image_url'] }}"
                         alt="{{ $project['title'] }}"
                         class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110 group-hover:brightness-110" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
            </div>

            {{-- Project Info & Metadata --}}
            <div class="lg:w-2/3 p-6 lg:p-8 space-y-6">
                {{-- Title & Status --}}
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 leading-tight">
                        {{ $project['title'] }}
                    </h1>
                    <span class="px-4 py-2 rounded-full text-sm font-medium shadow-lg
                        {{ $project['status'] === 'نشطة' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : '' }}
                        {{ $project['status'] === 'منجزة' ? 'bg-blue-100 text-blue-700 border border-blue-200' : '' }}
                        {{ $project['status'] === 'ملغية' ? 'bg-red-100 text-red-700 border border-red-200' : '' }}">
                        {{ $project['status'] }}
                    </span>
                </div>

                {{-- Compact Metadata Grid --}}
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
                    <div class="bg-white/70 backdrop-blur-sm rounded-xl p-3 border border-gray-100">
                        <div class="text-gray-500 text-xs">التصنيف</div>
                        <div class="font-semibold text-gray-800">{{ $project['category'] }}</div>
                    </div>
                    <div class="bg-white/70 backdrop-blur-sm rounded-xl p-3 border border-gray-100">
                        <div class="text-gray-500 text-xs">الموقع</div>
                        <div class="font-semibold text-gray-800">{{ $project['location']['name'] }}</div>
                    </div>
                    <div class="bg-white/70 backdrop-blur-sm rounded-xl p-3 border border-gray-100">
                        <div class="text-gray-500 text-xs">تاريخ الإنشاء</div>
                        <div class="font-semibold text-gray-800">{{ $project['created_at'] }}</div>
                    </div>
                    @if(!empty($project['execution_date']))
                        <div class="bg-white/70 backdrop-blur-sm rounded-xl p-3 border border-gray-100">
                            <div class="text-gray-500 text-xs">تاريخ التنفيذ</div>
                            <div class="font-semibold text-gray-800">{{ $project['execution_date'] }}</div>
                        </div>
                    @endif
                    <div class="bg-white/70 backdrop-blur-sm rounded-xl p-3 border border-gray-100">
                        <div class="text-gray-500 text-xs">المشاركون</div>
                        <div class="font-semibold text-gray-800">{{ $project['joined_participants'] }} / {{ $project['number_of_participants'] }}</div>
                    </div>
                    <div class="bg-white/70 backdrop-blur-sm rounded-xl p-3 border border-gray-100">
                        <div class="text-gray-500 text-xs">المبلغ المتبرّع</div>
                        <div class="font-semibold text-gray-800">{{ number_format($project['donation_total']) }} / {{ number_format($project['required_amount']) }} ل.س</div>
                    </div>
                </div>

                {{-- Progress Bars --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">نسبة المشاركة</span>
                            <span class="font-medium">{{ round(($project['joined_participants'] / $project['number_of_participants']) * 100) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-1000"
                                 style="width: {{ ($project['joined_participants'] / $project['number_of_participants']) * 100 }}%"></div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">نسبة التبرعات</span>
                            <span class="font-medium">{{ round(($project['donation_total'] / $project['required_amount']) * 100) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 h-2 rounded-full transition-all duration-1000"
                                 style="width: {{ ($project['donation_total'] / $project['required_amount']) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Status Update & Description Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Status Update (if official campaign) --}}
        @if($project['type'] === 'حملة رسمية')
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 h-fit">
                    <h3 class="font-semibold text-gray-800 mb-4">إدارة الحملة</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">تحديث الحالة</label>
                            <select wire:model="newStatus" id="status"
                                    class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors">
                                <option value="">-- اختر الحالة --</option>
                                <option value="نشطة">نشطة</option>
                                <option value="منجزة">منجزة</option>
                                <option value="ملغية">ملغية</option>
                            </select>
                        </div>
                        <button wire:click="updateStatus"
                                class="w-full px-4 py-3 text-sm font-medium bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl shadow-lg transition-all duration-300 transform hover:scale-105">
                            حفظ التغييرات
                        </button>
                    </div>

                    @if (session()->has('message'))
                        <div class="mt-4 p-3 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl">
                            {{ session('message') }}
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Description --}}
        <div class="{{ $project['type'] === 'حملة رسمية' ? 'lg:col-span-2' : 'lg:col-span-3' }}">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">وصف المشروع</h3>
                <div class="prose prose-sm max-w-none text-right text-gray-700 leading-relaxed">
                    <p>{{ $project['description'] }}</p>
                </div>
            </div>
        </div>


    </div>


    {{-- Compact Ratings Section --}}
    <div class="flex flex-col-3 justify-between items-center gap-2">

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 h-full w-1/2">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <h2 class="text-xl font-bold text-gray-800">التقييمات</h2>
            <div class="flex items-center gap-2">
                <div class="flex items-center">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="text-yellow-400 {{ $i <= round($avgRating) ? '' : 'text-gray-300' }}">★</span>
                    @endfor
                </div>
                <span class="text-sm text-gray-500 bg-gray-50 px-3 py-1 rounded-full">
                    {{ $avgRating }}/5 ({{ count($ratings) }} تقييم)
                </span>
            </div>
        </div>

        @if(empty($ratings))
            <div class="text-center py-12 text-gray-400">
                <div class="text-4xl mb-2">💭</div>
                <p class="text-sm">لا توجد تقييمات بعد</p>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 max-h-96 overflow-y-auto">
                @foreach ($ratings as $r)
                    <div class="bg-gray-50 rounded-xl p-4 hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex gap-3 items-start">
                            <img src="{{ $r['avatar'] }}"
                                 alt="{{ $r['user_name'] }}"
                                 class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm flex-shrink-0">

                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium text-gray-900 text-sm truncate">{{ $r['user_name'] }}</span>
                                    <span class="text-xs text-gray-400">{{ $r['created_ago'] }}</span>
                                </div>

                                <div class="flex items-center gap-2 mb-2">
                                    <div class="flex items-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span class="text-xs {{ $i <= $r['rating'] ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                        @endfor
                                    </div>
                                    <span class="text-xs text-gray-600">{{ $r['rating'] }}/5</span>
                                </div>

                                @if ($r['comment'])
                                    <p class="text-gray-700 text-xs leading-relaxed">{{ $r['comment'] }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>


        {{-- Location Map --}}
        @php
            $locations = [
                [
                    'lat' => $project['location']['latitude'],
                    'lng' => $project['location']['longitude'],
                    'name' => $project['location']['name'],
                ],
            ];
        @endphp
        <div class="bg-white p-6 rounded-xl shadow border space-y-4 w-1/2 ">
            <livewire:map.map-dynamic-component :locations="$locations" />
        </div>

    </div>
</div>
