{{-- Iklan Headline --}}
{{-- @if($iklanHeadline)
@foreach($iklanHeadline as $iHeadline)
<div class="flex mx-auto lg:w-[1024px] 2xl:w-[1280px] h-auto -mt-1 mb-4 overflow-hidden">
    <div class="w-full">
        @if($iHeadline->jenis == "Banner")
        <a href="{{ $iHeadline->link }}"><img class="w-full h-full object-contain"
                src="{{ asset('storage/'. $iHeadline->foto) }}" alt="{{ $iHeadline->nama }}"></a>
        @else
        {!! $iHeadline->kode !!}
        @endif
    </div>
</div>
@endforeach
@endif --}}
{{-- /Iklan Headline --}}

<!-- Headline Swiper-->
<div class="block w-full md:w-8/12 h-full">
    <div class="swiper mySwiper w-full">
        <div class="swiper-wrapper">

            @foreach($headline as $hl)
            <div class="swiper-slide">
                <div class="flex flex-col justify-between group relative h-auto rounded-xl overflow-hidden">

                    <div
                        class="absolute top-0 z-10 px-5 py-1.5 bg-gradient-to-r from-rose-600 to-orange-500 text-sm text-white font-semibold rounded-br-xl">
                        {{ $hl->kategori->nama }}</div>
                    <div
                        class="absolute bottom-6 group-hover:mb-2 px-4 flex flex-col items-start transition-all duration-300 ease-in-out">
                        <a href="/berita/{{ $hl->slug }}"
                            class="z-10 mx-2 lg:mx-4 text-lg lg:text-2xl font-bold text-white tracking-wide antialiased">{!!
                            $hl->judul !!}</a>
                        <p class="z-10 mx-2 lg:mx-4 text-xs 2xl:text-base mt-2 text-white antialiased"><i
                                class="far fa-clock"></i> {{ Carbon\Carbon::parse($hl->tanggal_tayang . ' '
                            .$hl->waktu)->diffForHumans() }}</p>
                    </div>

                    <a href="/berita/{{ $hl->slug }}" class="w-full">
                        <div
                            class="flex w-full h-72 lg:h-96 z-1 bg-gradient-to-t from-gray-900 rounded-xl overflow-hidden">
                            <img class="w-full h-full object-cover mix-blend-overlay group-hover:brightness-75 transition-all duration-300 ease-in-out"
                                src="{{ asset('storage/' . $hl->gambar_detail) }}" alt="{{ $hl->caption }}">
                        </div>
                    </a>

                </div>
            </div>
            @endforeach

        </div>
        <div class="mt-8">
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>
<!-- /Headline Swiper-->

{{-- Headline Side --}}

<!-- Today's Trending -->
<div
    class="relative hidden md:flex md:flex-col w-4/12 bg-gray-200 dark:bg-gray-600 rounded-xl h-72 lg:h-96 overflow-y-auto no-scrollbar">
    <div
        class="absolute top-0 px-5 py-1.5 bg-gradient-to-r from-sky-500 to-blue-600 text-white italic whitespace-nowrap rounded-br-xl">
        <span class="font-bold">TODAY'S </span><i class="fa-solid fa-arrow-trend-up text-amber-300"></i>
        <span>TRENDING</span>
    </div>
    <div class="mt-8 mb-5 flex flex-col divide-y gap-4 divide-gray-400/70">

        @foreach($trending as $tr)
        <div class="pt-4 mx-4 flex flex-row gap-5 justify-between">
            <div class="flex flex-col">
                <div class="flex flex-row items-center">
                    <div
                        class="hidden lg:block px-2 py-1 bg-gradient-to-r from-rose-600 to-orange-500 text-xxs font-semibold text-white rounded-full">
                        {{ $tr->kategori->nama }}</div>
                    <div class="lg:ml-2 text-xxs text-gray-800 dark:text-gray-300"><i class="far fa-clock"></i> {{
                        Carbon\Carbon::parse($tr->tanggal_tayang . ' ' .$tr->waktu)->diffForHumans() }}</div>
                </div>
                <a href="/berita/{{ $tr->slug }}">
                    <div
                        class="dark:text-white mt-1.5 text-xs lg:text-sm font-semibold hover:text-red-600 dark:hover:text-amber-300">
                        {!! $tr->judul !!}</div>
                </a>
            </div>
            <div class="w-16 lg:w-20">
                <div class="flex w-16 h-16 lg:w-20 lg:h-20 bg-gray-500 rounded-md overflow-hidden">
                    <a href="/berita/{{ $tr->slug }}"><img class="w-full h-full object-cover"
                            src="{{ asset('thumbnail/' . $tr->gambar_detail) }}" alt="{{ $tr->caption }}"></a>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>
<!-- /Today's Trending -->

{{-- /Headline Side --}}