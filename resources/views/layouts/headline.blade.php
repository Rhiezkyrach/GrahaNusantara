{{-- Iklan Headline --}}
@if($iklanHeadline)
@foreach($iklanHeadline as $iHeadline)
<div class="flex mx-auto lg:w-[1080px] h-auto -mt-1 mb-4 overflow-hidden">
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
@endif
{{-- /Iklan Headline --}}

<!-- Headline Swiper-->
<div class="flex w-full md:w-8/12 h-72 md:h-full md:flex-shrink-0">
    <section id="splide_headline" class="splide w-full h-full" aria-label="Headline News">
        <div class="splide__track">
            <div class="splide__list">

                @foreach($headline as $hl)
                <div class="splide__slide">
                    <div class="flex flex-col justify-between group relative h-auto rounded-xl overflow-hidden">

                        {{-- <div class="absolute top-0 z-10 px-5 py-1.5 bg-gradient-to-r from-rose-600 to-orange-500 text-sm text-white font-semibold rounded-br-xl">{{ $hl->kategori->nama }}</div> --}}
                        <div class="absolute bottom-8 group-hover:mb-2 px-4 flex flex-col items-start transition-all duration-300 ease-in-out">
                            <a href="/berita/{{ $hl->slug }}" class="z-10 mx-2 lg:mx-4 text-base md:text-xl font-bold text-white leading-snug antialiased">{!! $hl->judul !!}</a>

                            <div class="z-10 mx-2 lg:mx-4 mt-2 flex flex-row gap-2 items-center">
                                <div class="px-1.5 py-0.5 text-xs 2xl:text-sm bg-gradient-to-r from-teal-500 to-indigo-500 text-white font-semibold rounded tracking-wide">{{ $hl->kategori->nama }}</div>
                                <p class="text-xs 2xl:text-sm text-white antialiased"><i class="far fa-clock"></i> {{ Carbon\Carbon::parse($hl->tanggal_tayang . ' ' . $hl->waktu)->diffForHumans() }}</p>
                            </div>
                        </div>

                        <a href="/berita/{{ $hl->slug }}" class="group w-full h-72 lg:h-96 rounded-lg overflow-hidden">
                            <div class="w-full h-full bg-gradient-to-t from-gray-900 to-80%">
                                @if($hl->gambar_detail && Storage::exists($hl->gambar_detail))
                                    <img class="w-full h-full object-cover mix-blend-overlay group-hover:brightness-75 transition-all duration-300 ease-in-out"src="{{ asset('storage/' . $hl->gambar_detail) }}" alt="{{ $hl->caption }}">
                                @else
                                    <div class="w-full h-full rounded-lg skeleton"></div>
                                @endif
                            </div>
                        </a>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
<!-- /Headline Swiper-->

{{-- Headline Side --}}

<!-- Today's Trending -->
<div class="relative hidden md:flex md:flex-col flex-grow-0 w-4/12 h-72 lg:h-96 main_color border-2 border-rose-600 rounded-md">
    
    <div class="mt-1 mb-4 flex flex-col divide-y gap-3 divide-gray-400/70 overflow-y-auto no-scrollbar">

        @foreach($trending as $tr)
        <div class="pt-3 {{ $loop->last ? 'pb-8' : '' }} mx-4 flex flex-row gap-2 justify-between">
            <div class="flex flex-col">

                <a href="/berita/{{ $tr->slug }}">
                    <div  class="text-white text-sm font-semibold hover:text-amber-300">{!! $tr->judul !!}</div>
                </a>

                <div class="mt-1 flex flex-row items-center">
                    <div class="hidden lg:block px-1 py-0.5 bg-amber-300 text-xxs font-semibold rounded-sm">{{ $tr->kategori->nama }}</div>
                    <div class="lg:ml-2 text-xxs text-white"><i class="far fa-clock"></i> {{ Carbon\Carbon::parse($tr->tanggal_tayang . ' ' .$tr->waktu)->diffForHumans() }}</div>
                </div>
            </div>

            <div class="w-16">
                <div class="flex w-12 h-12 lg:w-16 lg:h-16 bg-gray-500 rounded-md overflow-hidden">
                    @if($tr->gambar_detail)
                        <a href="/berita/{{ $tr->slug }}"><img class="w-full h-full object-cover" src="{{ asset('thumbnail/' . $tr->gambar_detail) }}" alt="{{ $tr->caption }}"></a>
                    @else
                        <div class="w-full h-full rounded-md skeleton"></div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

    </div>

    <div class="absolute bottom-0 w-full text-center px-5 py-1.5 bg-amber-300 text-rose-600 rounded-b-md italic">
        <i class="fa-solid fa-hashtag"></i></i><span>LAGI<b>TRENDING</b></span>
    </div>
</div>
<!-- /Today's Trending -->

{{-- /Headline Side --}}

@push('js')
<script>
$( document ).ready(function() {
  let splide_headline = new Splide( '#splide_headline', {
    type   : 'loop',
    autoplay: true,
    interval: 3000,
    gap: 2,
  }).mount();
});
</script>
@endpush