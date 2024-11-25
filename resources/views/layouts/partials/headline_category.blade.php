<!-- Headline Swiper-->
<div class="flex w-full md:w-8/12 h-72 md:h-full md:flex-shrink-0">
    <section id="splide_headline_category" class="splide w-full h-full" aria-label="Headline News">
        <div class="splide__track">
            <div class="splide__list">

                @foreach($hlkategori as $hl)
                <div class="splide__slide">
                    <div class="flex flex-col justify-between group relative h-auto rounded-xl overflow-hidden">

                        {{-- <div class="absolute top-0 z-10 px-5 py-1.5 bg-gradient-to-r from-rose-600 to-orange-500 text-sm text-white font-semibold rounded-br-xl">{{ $hl->kategori->nama }}</div> --}}
                        <div class="absolute bottom-8 group-hover:mb-2 px-4 flex flex-col items-start transition-all duration-300 ease-in-out">
                            <a href="/berita/{{ $hl->slug }}" class="z-10 mx-2 lg:mx-4 text-base md:text-xl font-bold text-white tracking-wide antialiased">{!! $hl->judul !!}</a>

                            <div class="z-10 mx-2 lg:mx-4 mt-2 flex flex-row gap-2 items-center">
                                <div class="px-1.5 py-0.5 text-xs bg-gradient-to-r from-teal-500 to-indigo-500 text-white font-semibold rounded tracking-wide">{{ $hl->kategori->nama }}</div>
                                <p class="text-xs 2xl:text-base text-white antialiased"><i class="far fa-clock"></i> {{ Carbon\Carbon::parse($hl->tanggal_tayang . ' ' . $hl->waktu)->diffForHumans() }}</p>
                            </div>
                        </div>

                        <a href="/berita/{{ $hl->slug }}" class="group w-full h-72 lg:h-96 rounded-lg overflow-hidden">
                            <div class="w-full h-full bg-gradient-to-t from-gray-900 to-80%">
                                @if($hl->gambar_detail && Storage::exists($hl->gambar_detail))
                                    <img class="w-full h-full object-cover mix-blend-overlay group-hover:brightness-75 transition-all duration-300 ease-in-out" src="{{ asset('storage/' . $hl->gambar_detail) }}" alt="{{ $hl->caption }}">
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
<div class="hidden md:grid md:grid-rows-2 gap-2 w-4/12 h-72 lg:h-96">

    @foreach($hlkategori->skip(3) as $hk)
    <div class="relative w-full h-full bg-gray-200 rounded-xl overflow-hidden">
        @if($hk->gambar_detail)
            <a href="/berita/{{ $hk->slug }}"><img class="w-full h-full object-cover" src="{{ asset('thumbnail/' . $hk->gambar_detail) }}" alt="{{ $hk->caption }}"></a>
        @else
            <div class="w-full h-full rounded-md skeleton"></div>
        @endif
        <div class="absolute bottom-0 w-full h-auto p-3 bg-slate-800/60">
            <div class="flex flex-col">
                <div class="text-sm font-semibold text-white hover:text-yellow-300 whitespace-normal"><a href="/berita/{{ $hk->slug }}">{!! $hk->judul !!}</a></div>
                <div class="mt-2 text-xxs text-white">{{ Carbon\Carbon::parse($hk->tanggal_tayang . ' ' . $hk->waktu)->translatedFormat('l, d F Y | H:i') }} WIB</div>
            </div>
        </div>
    </div>
    @endforeach

</div>
{{-- /Headline Side --}}

@push('js')
<script>
$( document ).ready(function() {
  let splide_headline_category = new Splide( '#splide_headline_category', {
    type   : 'loop',
    autoplay: true,
    interval: 3000,
  }).mount();
});
</script>
@endpush