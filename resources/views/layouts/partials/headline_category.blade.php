<!-- Headline Swiper-->
<div class="md:w-8/12 h-full">
<div class="swiper mySwiper w-full">
    <div class="swiper-wrapper">

    @foreach($hlkategori->slice(0,3) as $hk)
    <div class="swiper-slide">
        <div class="flex flex-col justify-between group relative h-auto rounded-xl overflow-hidden">
            
            <div class="absolute top-0 z-10 px-5 py-1.5 bg-gradient-to-r from-rose-600 to-orange-500 text-sm text-white font-semibold rounded-br-xl">{{ $hk->kategori->nama }}</div>
            <div class="absolute bottom-6 group-hover:mb-2 px-4 flex flex-col items-start transition-all duration-300 ease-in-out">
                <a href="/berita/{{ $hk->slug }}" class="z-10 mx-2 lg:mx-4 text-lg lg:text-2xl font-bold text-white tracking-wide antialiased">{!! $hk->judul !!}</a>
                <p class="z-10 mx-2 lg:mx-4 text-xs 2xl:text-base mt-2 text-white antialiased"><i class="far fa-clock"></i> {{ Carbon\Carbon::parse($hk->tanggal_tayang . ' ' .$hk->waktu)->diffForHumans() }}</p>
            </div>

            <a href="/berita/{{ $hk->slug }}" class="w-full">
            <div class="flex w-full h-72 lg:h-96 z-1 bg-gradient-to-t from-gray-900 rounded-xl overflow-hidden">
                <img class="w-full h-full object-cover mix-blend-overlay group-hover:brightness-75 transition-all duration-300 ease-in-out" src="{{ asset('storage/' . $hk->gambar_detail) }}" alt="{{ $hk->caption }}">
            </div>
            </a>

        </div>
    </div>
    @endforeach
    
    </div>
    <div class="mt-8"><div class="swiper-pagination"></div></div>
</div>
</div>
<!-- /Headline Swiper-->

{{-- Headline Side --}}
<div class="hidden md:grid md:grid-rows-2 gap-2 w-4/12 h-72 lg:h-96">

@foreach($hlkategori->skip(3) as $hk)
<div class="relative w-full h-full bg-gray-200 rounded-xl overflow-hidden">
    <a href="/berita/{{ $hk->slug }}"><img class="w-full h-full object-cover" src="{{ asset('thumbnail/' . $hk->gambar_detail) }}" alt="{{ $hk->caption }}"></a>
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