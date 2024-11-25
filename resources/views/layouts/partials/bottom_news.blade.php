<!-- Berita Bawah -->
<div class="w-full grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">

    <!-- Kategori 5-10 -->
    @foreach($Kategori->slice(4, 6) as $key => $d)
    <div class="w-full mt-2">
        <div class="flex flex-row items-center justify-between">
            <div class="flex flex-row items-center">
                <div class="h-8 w-1.5 main_color rounded-full rotate-12"></div>
                <div class="text-lg lg:text-xl ml-2 italic text-slate-700 whitespace-nowrap"><span class="font-bold uppercase">{{ $d->nama }}</span></div>
            </div>
            <div class="text-xs lg:text-sm"><a href="/indeks" class="font-semibold py-0.5 text-gray-500 hover:text-gray-700"><i class="fa-solid fa-arrow-right-long"></i></a></div>
        </div>

        @foreach($d->berita->take(3) as $b)
            @if($loop->iteration == 1)
            <div class="relative h-52 md:h-40 lg:h-52 rounded-md overflow-hidden my-3">
                <div class="absolute top-0 z-10 px-5 py-1.5 main_color text-xs text-white font-semibold rounded-br-xl">{{ $b->kategori->nama }}</div>
                @if($b->gambar_detail && Storage::exists($b->gambar_detail))
                    <a href="/berita/{{ $b->slug }}"><img class="w-full h-full object-cover" src="{{ asset('storage/' . $b->gambar_detail) }}" alt="{{ $b->caption }}"></a>
                @else
                    <div class="w-full h-full rounded-md skeleton"></div>
                @endif
            </div>
            <a href="/berita/{{ $b->slug }}" class="text-xl font-bold leading-snug md:leading-snug hover:text-red-600">{!! $b->judul !!}</a>
            <p class="text-xxs 2xl:text-sm text-sky-900 font-medium mt-1.5 mb-3">{{ Carbon\Carbon::parse($b->tanggal_tayang . ' ' . $b->waktu)->translatedFormat('l, d F Y') }}</p>
            @else
            <div class="flex flex-row">
                <div class="flex shrink-0 w-14 h-14 rounded-md overflow-hidden">
                    @if($b->gambar_detail)
                        <a href="/berita/{{ $b->slug }}"><img class="w-full h-full object-cover" src="{{ asset('storage/' . $b->gambar_detail) }}" alt="{{ $b->caption }}"> </a>
                    @else
                        <div class="w-full h-full rounded-md skeleton"></div>
                    @endif
                </div>
                <a href="/berita/{{ $b->slug }}" class="ml-3 text-base font-bold leading-snug md:leading-snug hover:text-red-600">{!! $b->judul !!}</a>
            </div>
            @endif
            <div class="block w-full h-px bg-gray-300 rounded-full my-2"></div>
        @endforeach
    </div>
    @endforeach
    <!-- /Kategori 5-10 -->
    
</div>
<!-- /Berita Bawah -->