<div  class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12 space-y-10 animate-fade-in-up rtl:ml-0">

    {{-- Title --}}
    <h1 class="text-4xl font-bold text-right text-gray-900 rtl:ml-0">الحملات الرسمية</h1>

    {{-- Filter pills --}}
    <div class="flex justify-end gap-2 flex-wrap mt-6 animate-fade-in">
        @foreach (['نشطة', 'منجزة', 'ملغية'] as $filter)
            <button wire:click="$set('status', '{{ $filter }}')"
                    class="px-5 py-2 rounded-full text-sm font-semibold transition-all duration-300
                       border focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-indigo-500
                       {{ $status === $filter
                            ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg'
                            : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50' }}">
                {{ $filter }}
            </button>
        @endforeach
    </div>

    {{-- Projects Grid --}}
    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 animate-fade-in-up " dir="rtl">
        @forelse ($projects as $project)
            <a href="{{ route('campaigns.show', $project['id']) }}"
               class="group relative overflow-hidden rounded-2xl bg-white/70 backdrop-blur-md shadow-md
                      ring-1 ring-gray-200 transition-transform duration-300 hover:-translate-y-1 hover:shadow-xl">

                {{-- Image --}}
                <div class="relative">
                    <img src="{{ $project['image_url'] }}"
                         alt="{{ $project['title'] }}"
                         class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-105" />
                    <span class="absolute top-3 right-3 bg-white/90 text-gray-800 text-xs px-3 py-1 rounded-full shadow">
                        {{ $project['status'] }}
                    </span>
                </div>

                {{-- Content --}}
                <div class="p-5 space-y-3 flex flex-col h-full justify-between rtl:ml-0">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 truncate ">{{ $project['title'] }}</h2>

                        {{-- Rating preview --}}
                        @if(!empty($project['ratings']))
                            @php
                                $avg = collect($project['ratings'])->avg('rating');
                                $count = count($project['ratings']);
                            @endphp
                            <div class="flex items-center gap-1 text-yellow-400 mt-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="h-4 w-4 {{ $i <= $avg ? 'fill-current' : 'fill-gray-300' }}"
                                         viewBox="0 0 20 20" fill="currentColor">
                                        <polygon points="10,1 12,7 18,7 13,11 15,17 10,13 5,17 7,11 2,7 8,7"/>
                                    </svg>
                                @endfor
                                <span class="text-xs text-gray-600">({{ $count }})</span>
                            </div>
                        @endif

                        <p class="text-sm text-gray-600 line-clamp-2 mt-2">
                            {{ $project['description'] }}
                        </p>
                    </div>

                    <div class="flex justify-between items-center text-xs text-gray-500 mt-3">
                        <span>{{ $project['created_at'] }}</span>
                        <span>{{ number_format($project['donation_total']) }}
                            / {{ number_format($project['required_amount']) }} ل.س</span>
                    </div>
                </div>
            </a>
        @empty
            <p class="col-span-full text-center text-gray-500 py-16 text-lg animate-fade-in">لا توجد حملات حالياً</p>
        @endforelse
    </div>

    {{-- Pagination --}}
    {{-- <div class="mt-12">{{ $projects->links() }}</div> --}}
</div>
