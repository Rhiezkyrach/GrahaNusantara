@extends('layouts.main')

@section('main_section')

{{-- Iklan Home A --}}
@if($iklanHomeA) {{-- if iklan --}}
@foreach($iklanHomeA as $iHomeA)
<div class="w-full my-4">
    <div class="block w-full mx-auto overflow-hidden">
        @if($iHomeA->jenis == "Banner")
        <a href="{{ $iHomeA->link }}"><img class="w-full object-cover" src="{{ asset('storage/'. $iHomeA->foto) }}" alt="{{ $iHomeA->nama }}"></a>
        @else
        {!! $iHomeA->kode !!}
        @endif
    </div>
</div>
@endforeach
@endif
{{-- /Iklan Home A --}}

<!-- Berita Terkini -->
<div class="flex flex-row items-center justify-between">
    <div class="flex flex-row items-center">
        <div class="h-8 w-1.5 bg-gradient-to-tr from-rose-600 to-orange-500 rounded-full rotate-12"></div>
        <div class="text-lg lg:text-xl ml-2 italic text-slate-700 dark:text-gray-100 whitespace-nowrap"><span class="font-bold">BERITA</span> TERKINI</div>    
    </div>
    <div class="text-xs lg:text-sm"><a href="/indeks" class="font-semibold py-0.5 text-gray-500 hover:text-gray-700"><i class="fa-solid fa-arrow-right-long"></i></a></div>
</div>

<div id="post" class="block w-full">
    {{-- Ajax --}}
</div>

<div class="mt-4 w-auto text-center mx-auto">
    <button id="load-more" class="block w-36 py-2 px-3 text-red-600 ring-2 ring-red-600 ring-inset hover:ring-0 hover:bg-red-600 hover:text-white rounded-md whitespace-nowrap mx-auto" data-paginate="2">
        <span id="spinner" class="hidden animate-spin rounded-full text-lg"><i class="fas fa-spinner"></i></span>
        <span id="text" class="text-sm font-semibold">Muat Lagi...</span>
        <p id="nopost" class="hidden mt-2 text-xs font-semibold">Tidak Ada Berita...</p>
    </button>
</div>

<!-- /Berita Terkini -->

{{-- Iklan Home B --}}
@if($iklanHomeB) {{-- if iklan --}}
@foreach($iklanHomeB as $iHomeB)
<div class="w-full my-4">
    <div class="block w-full mx-auto overflow-hidden">
        @if($iHomeB->jenis == "Banner")
        <a href="{{ $iHomeB->link }}"><img class="w-full object-cover" src="{{ asset('storage/'. $iHomeB->foto) }}" alt="{{ $iHomeB->nama }}"></a>
        @else
        {!! $iHomeB->kode !!}
        @endif
    </div>
</div>
@endforeach
@endif
{{-- /Iklan Home B --}}

<!-- Politik -->
<div class="block w-full mt-5 mb-3">
    <div class="flex flex-row items-center justify-between">
        <div class="flex flex-row items-center">
            <div class="h-8 w-1.5 bg-gradient-to-tr from-rose-600 to-orange-500 rounded-full rotate-12"></div>
            <div class="text-lg lg:text-xl ml-2 italic text-slate-700 dark:text-gray-100 whitespace-nowrap"><span class="font-bold">POLITIK</span></div>
        </div>
        <div class="text-xs lg:text-sm"><a href="/indeks" class="font-semibold py-0.5 text-gray-500 hover:text-gray-700"><i class="fa-solid fa-arrow-right-long"></i></a></div>
    </div>

    <div class="flex flex-col w-full mt-4">
    <div class="md:grid md:grid-cols-2 gap-4">

        @foreach($Politik->slice(0, 2) as $pol)
        <div class="md:w-full {{ $loop->iteration == 2 ? 'hidden md:block' : '' }}">
        <div class="relative flex h-52 md:h-40 lg:h-52 mb-3 bg-gray-500 rounded-lg overflow-hidden">
            <div class="absolute top-0 z-10 px-5 py-1.5 bg-gradient-to-r from-rose-600 to-orange-500 text-xs text-white font-semibold rounded-br-xl">{{ $pol->kategori->nama }}</div>
            <a href="/berita/{{ $pol->slug }}" class="w-full"><img src="{{ asset('thumbnail/' . $pol->gambar_detail) }}" class="w-full h-full object-cover" alt="{{ $pol->caption }}"></a>
        </div>
        <a href="/berita/{{ $pol->slug }}" class="text-base md:text-xl font-bold leading-snug md:leading-snug dark:text-white hover:text-red-600 dark:hover:text-amber-300">{!! $pol->judul !!}</a>
        <p class="text-xxxs md:text-xxs xl:text-xs text-sky-900 dark:text-red-500 font-medium mt-1.5 mb-3">{{ Carbon\Carbon::parse($pol->tanggal_tayang . ' ' . $pol->waktu)->translatedFormat('l, d F Y | H:i') }} WIB</p>
        </div>
        @endforeach

    </div>

    <div class="flex flex-col divide-y divide-gray-300 dark:divide-gray-400">

        @foreach($Politik->skip(2) as $pol)
        <div class="flex flex-row w-full py-4">
            <div class="relative flex w-3/12 h-20 md:h-24 lg:h-28 rounded-lg overflow-hidden">
            <div class="absolute top-0 px-3 py-1 bg-gradient-to-r from-rose-600 to-orange-500 text-xxxs md:text-xxs text-white font-semibold rounded-br-md rounded-tl-md">{{ $pol->kategori->nama }}</div>
            <a href="/berita/{{ $pol->slug }}" class="w-full"><img src="{{ asset('thumbnail/' . $pol->gambar_detail) }}" class="w-full h-full object-cover" alt="{{ $pol->caption }}"></a>
            </div>
            <div class="flex flex-col w-9/12">
            <a href="/berita/{{ $pol->slug }}" class="pl-4 mb-3 text-base md:text-xl font-semibold leading-snug md:leading-snug dark:text-white hover:text-red-600 dark:hover:text-amber-300">{!! $pol->judul !!}</a>
            <p class="pl-4 text-xxxs md:text-xxs xl:text-xs text-sky-900 dark:text-red-500 font-medium -mt-1">{{ Carbon\Carbon::parse($pol->tanggal_tayang . ' ' . $pol->waktu)->translatedFormat('l, d F Y | H:i') }} WIB</p>
            <p class="hidden lg:flex pl-4 text-xs mt-2 dark:text-gray-100">{!! strip_tags(Str::words($pol->isi, 20)) !!}</p>
            </div>
        </div>
        @endforeach

    </div>
    </div>

</div>
<!-- /Politik -->

<!-- Galeri -->
<div class="block w-full mt-4 mb-3 p-4 bg-gradient-to-r from-rose-600 to-orange-500 rounded-lg">
    <div class="flex flex-row items-center justify-between">
        <div class="flex flex-row items-center">
            {{-- <div class="h-8 w-1.5 bg-white rounded-full rotate-12"></div> --}}
            <div class="text-lg lg:text-xl italic text-white whitespace-nowrap"><span class="font-bold"><i class="fa-solid fa-camera"></i> GALERI</span></div>
        </div>
        <div class="text-xs lg:text-sm"><a href="/indeks" class="font-semibold py-0.5 text-white hover:text-amber-300"><i class="fa-solid fa-arrow-right-long"></i></a></div>
    </div>

    <div class="mt-4 md:grid md:grid-cols-2 gap-4">

        @foreach($Galeri as $gal)
        <div class="md:w-full {{ $loop->iteration == 2 ? 'mt-4 md:mt-0' : '' }}">
        <div class="relative flex h-48 md:h-36 lg:h-48 mb-3 bg-gray-500 rounded-lg overflow-hidden">
            <div class="absolute top-0 right-0 mt-3 mr-3 px-2 py-1 bg-white text-red-600 font-semibold rounded-md"><i class="fa-solid fa-images"></i></div>
            <a href="/berita/{{ $gal->slug }}" class="w-full"><img src="{{ asset('thumbnail/' . $gal->gambar_detail) }}" class="w-full h-full object-cover" alt="{{ $gal->caption }}"></a>
        </div>
        <a href="/berita/{{ $gal->slug }}" class="text-base md:text-xl font-bold leading-snug md:leading-snug text-white hover:text-amber-300">{!! $gal->judul !!}</a>
        <p class="text-xxxs md:text-xxs xl:text-xs text-white font-medium mt-1.5 mb-3">{{ Carbon\Carbon::parse($gal->tanggal_tayang . ' ' . $gal->waktu)->translatedFormat('l, d F Y | H:i') }} WIB</p>
        </div>
        @endforeach

    </div>

</div>
<!-- /Galeri -->

<!-- Hukum -->
<div class="block w-full mt-5 mb-3">
    <div class="flex flex-row items-center justify-between">
        <div class="flex flex-row items-center">
            <div class="h-8 w-1.5 bg-gradient-to-tr from-rose-600 to-orange-500 rounded-full rotate-12"></div>
            <div class="text-lg lg:text-xl ml-2 italic text-slate-700 dark:text-gray-100 whitespace-nowrap"><span class="font-bold">HUKUM</span></div>
        </div>
        <div class="text-xs lg:text-sm"><a href="/indeks" class="font-semibold py-0.5 text-gray-500 hover:text-gray-700"><i class="fa-solid fa-arrow-right-long"></i></a></div>
    </div>

    <div class="flex flex-col w-full mt-4">
    <div class="md:grid md:grid-cols-2 gap-4">

        @foreach($Hukum->slice(0, 2) as $hkm)
        <div class="md:w-full {{ $loop->iteration == 2 ? 'hidden md:block' : '' }}">
        <div class="relative flex h-52 md:h-40 lg:h-52 mb-3 bg-gray-500 rounded-lg overflow-hidden">
            <div class="absolute top-0 z-10 px-5 py-1.5 bg-gradient-to-r from-rose-600 to-orange-500 text-xs text-white font-semibold rounded-br-xl">{{ $hkm->kategori->nama }}</div>
            <a href="/berita/{{ $hkm->slug }}" class="w-full"><img src="{{ asset('thumbnail/' . $hkm->gambar_detail) }}" class="w-full h-full object-cover" alt="{{ $hkm->caption }}"></a>
        </div>
        <a href="/berita/{{ $hkm->slug }}" class="text-base md:text-xl font-bold leading-snug md:leading-snug dark:text-white hover:text-red-600 dark:hover:text-amber-300">{!! $hkm->judul !!}</a>
        <p class="text-xxxs md:text-xxs xl:text-xs text-sky-900 dark:text-red-500 font-medium mt-1.5 mb-3">{{ Carbon\Carbon::parse($hkm->tanggal_tayang . ' ' . $hkm->waktu)->translatedFormat('l, d F Y | H:i') }} WIB</p>
        </div>
        @endforeach

    </div>

    <div class="flex flex-col divide-y divide-gray-300 dark:divide-gray-400">

        @foreach($Hukum->skip(2) as $hkm)
        <div class="flex flex-row w-full py-4">
            <div class="relative flex w-3/12 h-20 md:h-24 lg:h-28 rounded-lg overflow-hidden">
            <div class="absolute top-0 px-3 py-1 bg-gradient-to-r from-rose-600 to-orange-500 text-xxxs md:text-xxs text-white font-semibold rounded-br-md rounded-tl-md">{{ $hkm->kategori->nama }}</div>
            <a href="/berita/{{ $hkm->slug }}" class="w-full"><img src="{{ asset('thumbnail/' . $hkm->gambar_detail) }}" class="w-full h-full object-cover" alt="{{ $hkm->caption }}"></a>
            </div>
            <div class="flex flex-col w-9/12">
            <a href="/berita/{{ $hkm->slug }}" class="pl-4 mb-3 text-base md:text-xl font-semibold leading-snug md:leading-snug dark:text-white hover:text-red-600 dark:hover:text-amber-300">{!! $hkm->judul !!}</a>
            <p class="pl-4 text-xxxs md:text-xxs xl:text-xs text-sky-900 dark:text-red-500 font-medium -mt-1">{{ Carbon\Carbon::parse($hkm->tanggal_tayang . ' ' . $hkm->waktu)->translatedFormat('l, d F Y | H:i') }} WIB</p>
            <p class="hidden lg:flex pl-4 text-xs mt-2 dark:text-gray-100">{!! strip_tags(Str::words($hkm->isi, 20)) !!}</p>
            </div>
        </div>
        @endforeach

    </div>
    </div>

</div>
<!-- /Hukum -->

{{-- Iklan Home C --}}
@if($iklanHomeC) {{-- if iklan --}}
@foreach($iklanHomeC as $iHomeC)
<div class="w-full my-4">
    <div class="block w-full mx-auto overflow-hidden">
        @if($iHomeC->jenis == "Banner")
        <a href="{{ $iHomeC->link }}"><img class="w-full object-cover" src="{{ asset('storage/'. $iHomeC->foto) }}" alt="{{ $iHomeC->nama }}"></a>
        @else
        {!! $iHomeC->kode !!}
        @endif
    </div>
</div>
@endforeach
@endif
{{-- /Iklan Home C --}}

<!-- Peristiwa -->
<div class="block w-full mt-4 mb-3">
    <div class="flex flex-row items-center justify-between">
        <div class="flex flex-row items-center">
            <div class="h-8 w-1.5 bg-gradient-to-tr from-rose-600 to-orange-500 rounded-full rotate-12"></div>
            <div class="text-lg lg:text-xl ml-2 italic text-slate-700 dark:text-gray-100 whitespace-nowrap"><span class="font-bold">PERISTIWA</span></div>
        </div>
        <div class="text-xs lg:text-sm"><a href="/indeks" class="font-semibold py-0.5 text-gray-500 hover:text-gray-700"><i class="fa-solid fa-arrow-right-long"></i></a></div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mt-3 lg:mt-4 w-full">

        @foreach($Peristiwa as $pwa)
        <div class="w-full mt-2">
        <div class="relative flex h-28 md:h-36 rounded-lg overflow-hidden">
            <div class="absolute top-0 px-3 py-1 bg-gradient-to-r from-rose-600 to-orange-500 text-xxs md:text-xs text-white font-semibold rounded-br-md rounded-tl-md">{{ $pwa->kategori->nama }}</div>
            <a href="/berita/{{ $pwa->slug }}" class="w-full"><img src="{{ asset('thumbnail/' . $pwa->gambar_detail) }}" alt="{{ $pwa->caption }}" class="w-full h-full object-cover"></a>
        </div>
        <p class="mt-3 lg:text-lg 2xl:text-xl leading-snug lg:leading-snug 2xl:leading-tight font-semibold dark:text-white hover:text-red-600 dark:hover:text-amber-300"><a href="/berita/{{ $pwa->slug }}">{!! $pwa->judul !!}</a></p>
        <p class="mt-1 text-xxxs md:font-xxs 2xl:font-xs font-medium text-sky-900 dark:text-red-500">{{ Carbon\Carbon::parse($pwa->tanggal_tayang . ' ' . $pwa->waktu)->translatedFormat('l, d F Y | H:i') }} WIB</p>
        </div>
        @endforeach

    </div>

</div>
<!-- /Peristiwa -->

<!-- Nasional -->
<div class="block w-full mt-4 mb-3">
    <div class="flex flex-row items-center justify-between">
        <div class="flex flex-row items-center">
            <div class="h-8 w-1.5 bg-gradient-to-tr from-rose-600 to-orange-500 rounded-full rotate-12"></div>
            <div class="text-lg lg:text-xl ml-2 italic text-slate-700 dark:text-gray-100 whitespace-nowrap"><span class="font-bold">NASIONAL</span></div>
        </div>
        <div class="text-xs lg:text-sm"><a href="/indeks" class="font-semibold py-0.5 text-gray-500 hover:text-gray-700"><i class="fa-solid fa-arrow-right-long"></i></a></div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mt-3 lg:mt-4 w-full">

        @foreach($Nasional as $nas)
        <div class="w-full mt-2">
        <div class="relative flex h-28 md:h-36 rounded-lg overflow-hidden">
            <div class="absolute top-0 px-3 py-1 bg-gradient-to-r from-rose-600 to-orange-500 text-xxs md:text-xs text-white font-semibold rounded-br-md rounded-tl-md">{{ $nas->kategori->nama }}</div>
            <a href="/berita/{{ $nas->slug }}" class="w-full"><img src="{{ asset('thumbnail/' . $nas->gambar_detail) }}" alt="{{ $nas->caption }}" class="w-full h-full object-cover"></a>
        </div>
        <p class="mt-3 lg:text-lg 2xl:text-xl leading-snug lg:leading-snug 2xl:leading-tight font-semibold dark:text-white hover:text-red-600 dark:hover:text-amber-300"><a href="/berita/{{ $nas->slug }}">{!! $nas->judul !!}</a></p>
        <p class="mt-1 text-xxxs md:font-xxs 2xl:font-xs font-medium text-sky-900 dark:text-red-500">{{ Carbon\Carbon::parse($nas->tanggal_tayang . ' ' . $nas->waktu)->translatedFormat('l, d F Y | H:i') }} WIB</p>
        </div>
        @endforeach

    </div>

</div>
<!-- /Nasional -->

<script type="text/javascript">
    var paginate = 1;
    loadMoreData(paginate);

    $('#load-more').click(function() {
        var page = $(this).data('paginate');
        loadMoreData(page);
        $(this).data('paginate', page+1);
    });
    // run function when user click load more button
    function loadMoreData(paginate) {
        $.ajax({
            url: '?page=' + paginate,
            type: 'get',
            datatype: 'html',
            beforeSend: function() {
                $('#text').text('Memuat Berita');
                $('#spinner').removeClass('hidden').addClass('inline-block');
            }
        })
        .done(function(data) {
            if(data.length == 0) {
                $('#nopost').removeClass('hidden');
                $('#load-more').hide();
                return;
                } else {
                $('#text').text('Muat Lagi...');
                $('#spinner').removeClass('inline-block').addClass('hidden');
                $('#post').append(data);
                }
        })
            .fail(function(jqXHR, ajaxOptions, thrownError) {
                alert('Tidak Dapat Memuat Berita.');
            });
    }
</script>

@endsection