<div class="mx-auto max-w-5xl px-6 py-10 space-y-10 animate-fade-in-up" dir="rtl">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
            {{ $project['title'] }}
            <span class="text-sm px-3 py-1 rounded-full bg-indigo-100 text-indigo-700 shadow-sm">
                {{ $project['status'] }}
            </span>
        </h1>
    </div>

    {{-- Hero image with hover zoom --}}
    <div class="relative group overflow-hidden rounded-xl shadow-lg">
        <img src="{{ $project['image_url'] }}"
             alt="{{ $project['title'] }}"
             class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-105" />
    </div>

    {{-- Project metadata --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm text-gray-700 bg-white/60 backdrop-blur p-6 rounded-xl shadow space-y-1 sm:space-y-0">
        <div><strong>التصنيف:</strong> {{ $project['category'] }}</div>
        <div><strong>الموقع:</strong> {{ $project['location']['name'] }}</div>
        <div><strong>تاريخ الإنشاء:</strong> {{ $project['created_at'] }}</div>
        @if(!empty($project['execution_date']))
            <div><strong>تاريخ التنفيذ:</strong> {{ $project['execution_date'] }}</div>
        @endif
        <div><strong>المشاركون:</strong> {{ $project['joined_participants'] }} / {{ $project['number_of_participants'] }}</div>
        <div><strong>المبلغ المتبرّع:</strong> {{ number_format($project['donation_total']) }} / {{ number_format($project['required_amount']) }} ل.س</div>
    </div>

    {{-- Description --}}
    <div class="prose prose-sm sm:prose-base prose-gray max-w-none text-right">
        <p>{{ $project['description'] }}</p>
    </div>

    {{-- Ratings Section --}}
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800">التقييمات</h2>
            <span class="text-sm text-gray-500">({{ count($ratings) }}) — متوسط: {{ $avgRating }}/5</span>
        </div>

        @if(empty($ratings))
            <p class="text-gray-500 text-sm text-center py-8">لا توجد تقييمات بعد.</p>
        @else
            <ul class="space-y-4">
                @foreach ($ratings as $r)
                    <li class="bg-white/80 backdrop-blur rounded-xl shadow-md p-5 flex gap-4 items-start transition transform hover:scale-[1.01] hover:shadow-lg duration-300 animate-fade-in">
                        <img src="{{ $r['avatar'] }}"
                             alt="{{ $r['user_name'] }}"
                             class="w-12 h-12 rounded-full object-cover border border-gray-200 shadow-sm">

                        <div class="flex-1 space-y-1">
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-800">{{ $r['user_name'] }}</span>
                                <span class="text-xs text-gray-400">{{ $r['created_ago'] }}</span>
                            </div>

                            <div class="flex items-center gap-1 text-yellow-500">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= $r['rating'] ? '' : 'text-gray-300' }}">★</span>
                                @endfor
                                <span class="text-sm text-gray-600 ml-2">{{ $r['rating'] }}/5</span>
                            </div>

                            @if ($r['comment'])
                                <p class="text-gray-700 mt-1 text-sm">{{ $r['comment'] }}</p>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
