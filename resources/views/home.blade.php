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
<div class="flex flex-row items-center justify-between px-2 py-1 bg-teal-100 dark:bg-teal-200 border border-teal-300 rounded">
    <div class="flex flex-row items-center">
        <div class="h-8 w-8 text-white text-center text-lg bg-gradient-to-tr from-teal-500 to-indigo-500 rounded"><i class="mt-1.5 fa-regular fa-newspaper"></i></div>
        <div class="text-lg ml-2 text-teal-600 dark:text-teal-700 whitespace-nowrap"><span class="font-bold">BERITA</span> TERKINI</div>    
    </div>
    <div class="text-xs lg:text-sm"><a href="/indeks" class="py-0.5 text-gray-500 hover:text-gray-700">Lihat Lainnya <i class="fa-solid fa-arrow-right-long"></i></a></div>
</div>

<div id="post" class="block w-full">
    {{-- Ajax --}}
</div>

<div class="mt-4 w-auto text-center mx-auto">
    <button id="load-more" class="block w-36 py-2 px-3 text-teal-600 dark:text-teal-400 ring-2 ring-teal-600 ring-inset hover:ring-0 bg-teal-100 dark:bg-teal-800 hover:bg-teal-600 hover:text-white rounded-md whitespace-nowrap mx-auto" data-paginate="2">
        <span id="spinner" class="hidden animate-spin rounded-full text-lg"><i class="fa-regular fa-circle-notch"></i></span>
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

<!-- KATEGORI 1 & 2 -->
@foreach($Kategori->slice(0, 2) as $key => $d)
<div class="block w-full mt-5 mb-3">
    <div class="flex flex-row items-center justify-between px-2 py-1 bg-teal-100 dark:bg-teal-200 border border-teal-300 rounded">
        <div class="flex flex-row items-center">
            <div class="h-8 w-8 text-white text-center text-lg bg-gradient-to-tr from-teal-500 to-indigo-500 rounded"><i class="mt-1.5 fa-regular fa-landmark"></i></div>
            <div class="text-lg ml-2 text-teal-600 dark:text-teal-700 whitespace-nowrap"><span class="font-bold uppercase">{{ $d->nama }}</span></div>    
        </div>
        <div class="text-xs lg:text-sm"><a href="/indeks" class="py-0.5 text-gray-500 hover:text-gray-700">Lihat Lainnya <i class="fa-solid fa-arrow-right-long"></i></a></div>
    </div>

    <div class="flex flex-col w-full mt-4">
    <div class="md:grid md:grid-cols-2 gap-4">

        @foreach($d->Berita->slice(0, 2) as $b)
        <div class="md:w-full {{ $loop->iteration == 2 ? 'hidden md:block' : '' }}">
        <div class="relative flex h-52 md:h-40 lg:h-52 mb-3 bg-gray-500 rounded-lg overflow-hidden">
            <div class="absolute top-0 z-10 px-5 py-1.5 main_color text-xs text-white font-semibold rounded-br-xl">{{ $b->kategori->nama }}</div>
            @if($b->gambar_detail)
                <a href="/berita/{{ $b->slug }}" class="w-full"><img src="{{ $network_utama ? $network_utama->url . '/storage/' . $b->gambar_detail : '' }}" class="w-full h-full object-cover" alt="{{ $b->caption }}"></a>
            @else
                <div class="w-full h-full rounded-lg skeleton"></div>
            @endif
        </div>
        <a href="/berita/{{ $b->slug }}" class="text-lg md:text-xl font-bold leading-snug md:leading-snug dark:text-white hover:text-red-600 dark:hover:text-amber-300">{!! $b->judul !!}</a>
        <p class="text-xxxs md:text-xxs xl:text-xs text-sky-900 dark:text-teal-400 font-medium mt-1.5 mb-3">{{ Carbon\Carbon::parse($b->tanggal_tayang . ' ' . $b->waktu)->translatedFormat('l, d F Y') }}</p>
        </div>
        @endforeach

    </div>

    <div class="flex flex-col divide-y divide-gray-300 dark:divide-gray-400">

        @foreach($d->Berita->slice(3, 2) as $b)
        <div class="flex flex-row w-full py-4 items-center">
            <div class="relative flex w-3/12 h-20 md:h-24 lg:h-28 rounded-lg overflow-hidden">
                <div class="absolute top-0 z-10 px-3 py-1 main_color text-xxxs md:text-xxs text-white font-semibold rounded-br-md rounded-tl-md">{{ $b->kategori->nama }}</div>
                @if($b->gambar_detail)
                    <a href="/berita/{{ $b->slug }}" class="w-full"><img src="{{ $network_utama ? $network_utama->url . '/thumbnail/' . $b->gambar_detail : '' }}" class="w-full h-full object-cover" alt="{{ $b->caption }}"></a>
                @else
                    <div class="w-full h-full rounded-lg skeleton"></div>
                @endif
            </div>
            <div class="flex flex-col w-9/12">
            {{-- <div class="pl-4 text-xs text-white"><span class="px-1 py-0.5 main_color rounded">{{ $b->kategori->nama }}</span></div> --}}
            <a href="/berita/{{ $b->slug }}" class="pl-4 mb-2 text-base md:text-lg font-semibold leading-snug md:leading-snug dark:text-white hover:text-teal-600 dark:hover:text-teal-300">{!! $b->judul !!}</a>
            <p class="pl-4 text-xxxs md:text-xxs xl:text-xs text-sky-900 dark:text-teal-400 font-medium -mt-1">{{ Carbon\Carbon::parse($b->tanggal_tayang . ' ' . $b->waktu)->translatedFormat('l, d F Y') }}</p>
            {{-- <p class="hidden lg:flex pl-4 text-xs mt-2 dark:text-gray-100">{!! strip_tags(Str::words($b->isi, 20)) !!}</p> --}}
            </div>
        </div>
        @endforeach

    </div>
    </div>

</div>
@endforeach
<!-- END:KATEGORI 1 & 2 -->


{{-- KATEGORI 3 & 4 --}}
@foreach($Kategori->slice(2, 2) as $key => $d)
<div class="block w-full mt-4 mb-3">
    <div class="flex flex-row items-center justify-between px-2 py-1 bg-teal-100 dark:bg-teal-200 border border-teal-300 rounded">
        <div class="flex flex-row items-center">
            <div class="h-8 w-8 bg-gradient-to-tr text-white text-center text-lg from-teal-500 to-indigo-500 rounded"><i class="mt-1.5 {{ $d->nama == 'Hukum' ? 'fa-solid fa-gavel' : 'fa-solid fa-chart-simple' }}"></i></div>
            <div class="text-lg ml-2 text-teal-600 dark:text-teal-700 whitespace-nowrap"><span class="font-bold uppercase">{{ $d->nama }}</span></div>    
        </div>
        <div class="text-xs lg:text-sm"><a href="/indeks" class="py-0.5 text-gray-500 hover:text-gray-700">Lihat Lainnya <i class="fa-solid fa-arrow-right-long"></i></a></div>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 mt-3 lg:mt-4 w-full">

        @foreach($d->Berita->take(6) as $b)
        <div class="w-full mt-2">
        <div class="relative flex h-28 md:h-36 rounded-lg overflow-hidden">
            <div class="absolute top-0 px-3 py-1 main_color text-xxs md:text-xs text-white font-semibold rounded-br-md rounded-tl-md">{{ $b->kategori->nama }}</div>
            @if($b->gambar_detail)
                <a href="/berita/{{ $b->slug }}" class="w-full"><img src="{{ $network_utama ? $network_utama->url . '/thumbnail/' . $b->gambar_detail : '' }}" alt="{{ $b->caption }}" class="w-full h-full object-cover"></a>
            @else
                <div class="w-full h-full rounded-lg skeleton"></div>
            @endif
        </div>
        <p class="mt-3 text-sm md:text-base leading-tight font-semibold dark:text-white hover:text-red-600 dark:hover:text-amber-300"><a href="/berita/{{ $b->slug }}">{!! $b->judul !!}</a></p>
        <p class="mt-1 text-xxs font-medium text-sky-900 dark:text-teal-400">{{ Carbon\Carbon::parse($b->tanggal_tayang . ' ' . $b->waktu)->translatedFormat('l, d F Y') }}</p>
        </div>
        @endforeach

    </div>
</div>
@endforeach
{{-- END:KATEGORI 3 & 4 --}}

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

@push('js')
<script type="text/javascript">
$( document ).ready(function() {
    
    // run function when user click load more button
    let paginate = 1;
    loadMoreData(paginate);

    $('#load-more').click(function() {
        let page = $(this).data('paginate');
        loadMoreData(page);
        $(this).data('paginate', page+1);
    });
    
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
});
</script>
@endpush

@endsection