@extends('layouts.main')

@section('main_section')
{{-- @dd(Str::slug('nama', '-')) --}}

{{-- Iklan News A --}}
@if($iklanNewsA->count()) {{-- if iklan --}}
@foreach($iklanNewsA as $iNewsA)
<div class="w-full mb-4">
    <div class="block w-full mx-auto overflow-hidden">
        @if($iNewsA->jenis == "Banner")
        <a href="{{ $iNewsA->link }}"><img class="w-full object-cover" src="{{ asset('storage/'. $iNewsA->foto) }}" alt="{{ $iNewsA->nama }}"></a>
        @else
        {!! $iNewsA->kode !!}
        @endif
    </div>
</div>
@endforeach
@endif
{{-- /Iklan News A --}}

{{-- Detail --}}
<div class="flex flex-col w-full h-auto">
<div class="mb-1 w-auto flex text-xxs font-semibold">
  <a href="{{ url('/') }}"><span class="text-gray-600 dark:text-gray-200 hover:text-red-600">Home</span></a> <span class="mx-1.5 text-gray-600"><i class="fa-solid fa-caret-right"></i></span> <a href="/kategori/{{ Str::slug(strtolower($berita->kategori->nama), '-') }}"><span class="text-white bg-gradient-to-r from-rose-600 to-orange-500 px-2 py-1 rounded-full">{{ $berita->kategori->nama }}</span></a>
</div>

{{-- Judul --}}
@if($berita->judul_atas)
<div class="text-md font-bold mt-4 uppercase text-red-600">{{ $berita->judul_atas }}</div>
@endif
<h1 class="text-2xl md:text-3xl font-black mt-2 leading-tight dark:text-white">{!! $berita->judul !!}</h1>
@if($berita->sub_judul)
<h2 class="text-lg md:text-xl font-semibold mt-2 text-gray-500 dark-text-gray-300 leading-snug">{{ $berita->sub_judul }}</h2>
@endif
{{-- /Judul --}}

{{-- Detail Wartawan --}}
<div class="flex mt-3 flex-row items-center">
    <div class="flex w-10 h-10 md:w-12 md:h-12 rounded-full bg-gray-100 overflow-hidden">
      @if($berita->oleh !== '' && $berita->oleh !== NULL)
        @if($berita->foto_penulis)
        <img class="w-full object-cover" src="{{ asset('storage/' . $berita->foto_penulis) }}" aria-hidden="true" alt="">
        @endif
        <img class="w-full object-cover" src="{{ asset('storage/gambar/foto/wartawan/default_photo.jpg') }}" aria-hidden="true" alt="">
      @elseif($berita->reporter->foto)
      <img class="w-full object-cover" src="{{ asset('storage/' . $berita->reporter->foto) }}" aria-hidden="true" alt="">
      @else
      <img class="w-full object-cover" src="{{ asset('storage/gambar/foto/wartawan/default_photo.jpg') }}" aria-hidden="true" alt="">
      @endif
    </div>
    <div class="ml-3 flex flex-col justify-between">
      @if($berita->oleh !== '' && $berita->oleh !== NULL)
      <div class="text-sm font-semibold text-red-600">Oleh: {{ $berita->oleh }}</div>
      @else
      <div class="text-sm font-semibold text-red-600">Laporan: {{ $berita->wartawan}}</div>
      @endif
      <div class="text-xxs dark:text-gray-200">{{ Carbon\Carbon::parse($berita->tanggal_tayang . ' ' .$berita->waktu)->translatedFormat('l, d F Y | H:i')}} WIB</div>
    </div>
</div>
{{-- /Detail Wartawan --}}

<div class="z-0 flex flex-row w-full mt-4 bg-gray-200 px-3 py-2 rounded-md items-center justify-between">
    <div class="text-sm font-semibold">Share:</div>
    <!-- ShareThis BEGIN --><div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
</div>

{{-- Foto --}}
<div class="swiper galeriSwiper mt-2 flex w-full h-56 md:h-72 lg:h-[400px] bg-gray-100 {{ $galeri->count() ? 'rounded-md' : 'rounded-t-md' }} overflow-hidden">
    @if($galeri->count())
    <div class="swiper-wrapper">
      @foreach($galeri as $g)
      <img class="swiper-slide w-full h-full object-cover" src="{{ asset('storage/' . $g->nama_photo) }}" alt="{{ $berita->caption }}" title="{{ $berita->judul }}">
      @endforeach
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    @elseif($berita->video != '')
    <iframe src="{{ $berita->video }}" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>
    @else
    <img class="w-full h-full object-cover" src="{{ asset('storage/' . $berita->gambar_detail) }}" alt="{{ $berita->caption }}" title="{{ $berita->judul }}">
    @endif
</div>
@if($galeri->count() == NULL)
<div class="px-3 py-2 text-xs bg-gray-200 rounded-b-md">{{ $berita->caption }}</div>
@endif
{{-- /Foto --}}

{{-- Iklan News B --}}
@if($iklanNewsB->count()) {{-- if iklan --}}
@foreach($iklanNewsB as $iNewsB)
<div class="w-full my-4">
    <div class="block w-full mx-auto overflow-hidden">
        @if($iNewsB->jenis == "Banner")
        <a href="{{ $iNewsB->link }}"><img class="w-full object-cover" src="{{ asset('storage/'. $iNewsB->foto) }}" alt="{{ $iNewsB->nama }}"></a>
        @else
        {!! $iNewsB->kode !!}
        @endif
    </div>
</div>
@endforeach
@endif
{{-- /Iklan News B --}}

{{-- Isi --}}
@php
$paragraphs = explode('</p>', $berita->isi);

foreach($paragraphs as $paragraph){
        $blocks[] = $paragraph . "</p>";
}

unset($blocks[count($blocks)-1]);
$jumlahParagraf = count($blocks);
@endphp

<div class="mt-4 text-base dark:text-white md:leading-relaxed space-y-5">
  
  @foreach(array_slice($blocks, 0, $jumlahParagraf - 1) as $block)
    {!! $block !!}
    @if($loop->iteration == 2 && $terkait->count())
    <div class="flex flex-col md:float-left w-full h-auto">
      <div class="relative bg-gradient-to-tr from-slate-200 to-slate-100 dark:bg-gray-600 h-auto rounded-md overflow-hidden">
        <div class="absolute top-0 z-10 px-5 py-1.5 bg-gradient-to-r from-rose-600 to-orange-500 text-xs text-white font-semibold rounded-br-xl">BACA JUGA</div>
        <div class="my-3 mt-8 mx-5 flex flex-col divide-y divide-red-600">
          @foreach($terkait->take(3) as $tk)
          <a href="/berita/{{ $tk->slug }}"><div class="py-2 text-sm font-semibold dark:text-gray-800 hover:text-red-600 dark:hover:text-red-600">{!! $tk->judul !!}</div></a>
          @endforeach
        </div>
      </div>
      <div class="block w-full h-2 md:h-5"></div>
    </div>
    @endif
  @endforeach

  {{-- Paragraf terakhir --}}
  @foreach(array_slice($blocks, $jumlahParagraf - 1, $jumlahParagraf) as $block)
    @php $e = explode('</p>', $block, 2) @endphp
    {!! $e[0] !!}<span class="inline-block ml-1 -mb-0.5 w-4 h-4 bg-white rounded-full overflow-hidden"><img class="object-cover" src="{{ asset('images/icon_rajamedia.png') }}" alt="rajamedia"></span></p>
  @endforeach

</div>
{{-- /Isi --}}

@if($berita->kode_embed)
<div class="w-full mt-5 text-center">
 <div class="block mx-auto">{!! $berita->kode_embed !!}</div>
</div>
@endif

{{-- Tag --}}
<div class="mt-5 flex flex-row flex-wrap gap-1">
    <div class="font-semibold dark:text-gray-100"><i class="fas fa-tags"></i> TAG:</div>
    @php $tags = explode(',', $berita->tag) @endphp
    @foreach($tags as $t)
    <form action="/search">
    <input type="hidden" name="tag" value="{{ $t }}">
    </form>
    <a href="/search?tag={{ $t }}"><div class="inline-flex whitespace-pre"><span class="text-sm font-extrabold bg-amber-500 text-gray-800 py-1 px-2 rounded-l-md"><i class="fas fa-hashtag"></i></span> <span class="text-sm font-medium bg-red-600 hover:bg-red-800 text-white py-1 px-2 rounded-r-md">{{ $t }}</span></div></a>
    @endforeach
</div>
{{-- /Tag --}}

<div class="w-full mt-5 grid grid-cols-1 gap-2 lg:grid-cols-2 lg:gap-4">

  @if($berita_prev)
  <div class="w-full h-auto px-4 py-3 bg-gradient-to-r from-rose-600 to-red-600 rounded-md">
    <div class="flex flex-row items-center justify-between">
      <div class="flex shrink-0 w-12 h-12 bg-white rounded-md overflow-hidden">
        <a href="/berita/{{ $berita_prev->slug }}"><img class="w-full h-full object-cover" src="{{ asset('thumbnail/' . $berita_prev->gambar_detail) }}" alt="{{ $berita_prev->caption }}"></a>
      </div>
      <div class="flex w-full flex-col">
        <div class="ml-2 md:ml-3 text-xxs text-left text-yellow-300 font-semibold">Pos Sebelumnya:</div>
        <a href="/berita/{{ $berita_prev->slug }}"><div class="ml-2 md:ml-3 text-xs mt-1 text-left text-gray-100 hover:text-white font-bold">{!! Str::wordCount($berita_prev->judul) > 10 ? Str::words($berita_prev->judul, 10, '...') : $berita_prev->judul !!}</div></a>
      </div>
    </div>
  </div>
  @endif

  @if($berita_next)
  <div class="w-full h-auto px-4 py-3 bg-gradient-to-l from-rose-600 to-red-600 rounded-md">
    <div class="flex flex-row items-center justify-between">
      <div class="flex w-full flex-col">
        <div class="mr-2 md:mr-3 text-xxs text-right text-yellow-300 font-semibold">Pos Berikutnya:</div>
        <a href="/berita/{{ $berita_next->slug }}"><div class="mr-2 md:mr-3 text-xs mt-1 text-right text-gray-100 hover:text-white font-bold">{!! Str::wordCount($berita_next->judul) > 10 ? Str::words($berita_next->judul, 10, '...') : $berita_next->judul !!}</div></a>
      </div>
      <div class="flex shrink-0 w-12 h-12 bg-white rounded-md overflow-hidden">
        <a href="/berita/{{ $berita_next->slug }}"><img class="w-full h-full object-cover" src="{{ asset('thumbnail/' . $berita_next->gambar_detail) }}" alt="{{ $berita_next->caption }}"></a>
      </div>
    </div>
  </div>
  @endif

</div>

{{-- Iklan News C --}}
@if($iklanNewsC->count()) {{-- if iklan --}}
@foreach($iklanNewsC as $iNewsC)
<div class="w-full my-4">
    <div class="block w-full mx-auto overflow-hidden">
        @if($iNewsC->jenis == "Banner")
        <a href="{{ $iNewsC->link }}"><img class="w-full object-cover" src="{{ asset('storage/'. $iNewsC->foto) }}" alt="{{ $iNewsC->nama }}"></a>
        @else
        {!! $iNewsC->kode !!}
        @endif
    </div>
</div>
@endforeach
@endif
{{-- /Iklan News C --}}

{{-- FB Comment --}}
<div class="mt-5 flex flex-col w-full bg-gray-100 p-1 rounded-md">
    <div class="ml-2 mt-1 font-semibold whitespace-nowrap"><i class="fas fa-comments"></i> Komentar:</div>
    <div class="fb-comments" data-href="{{ url('/') }}/berita/{{ $berita->slug }}" data-width="100%" data-numposts="10"></div>
</div>
{{-- /FB Comment --}}

<div class="flex w-full my-6 h-0.5 bg-gray-200"></div>

{{-- Berita Lainnya --}}
<div class="block w-full">
  <div class="flex flex-row items-center justify-between">
      <div class="flex flex-row items-center">
          <div class="h-8 w-1.5 bg-gradient-to-tr from-rose-600 to-orange-500 rounded-full rotate-12"></div>
          <div class="text-lg lg:text-xl ml-2 italic text-slate-700 dark:text-gray-100 whitespace-nowrap"><span class="font-bold">BERITA</span> LAINNYA</div>
      </div>
      <div class="text-xs lg:text-sm"><a href="/indeks" class="font-semibold py-0.5 text-gray-500 hover:text-gray-700"><i class="fa-solid fa-arrow-right-long"></i></a></div>
  </div>

  <div class="mt-5 w-full grid grid-cols-2 lg:grid-cols-3 gap-5">

    @if($terkait->count())
    @foreach($terkait as $tr)
    <div class="flex flex-col">
      <div class="w-full h-28 md:h-32 bg-gray-300 rounded-md overflow-hidden">
        <a href="/berita/{{ $tr->slug }}"><img class="w-full h-full object-cover" src="{{ asset('thumbnail/' . $tr->gambar_detail) }}" alt="{{ $tr->caption }}"></a>
      </div>
      <a href="/berita/{{ $tr->slug }}"><div class="mt-2 text-sm dark:text-white hover:text-red-600 dark:hover:text-amber-300 md:text-base font-semibold leading-snug md:leading-snug">{!! $tr->judul !!}</div></a>
      <div class="mt-1 text-xxs font-semibold text-cyan-900 dark:text-red-500">{{ carbon\Carbon::parse($tr->tanggal_tayang)->translatedFormat('l, d F Y') }}</div>
    </div>
    @endforeach
    @endif

    @if($terkait->count() < 6)
    @foreach($terkaitkanal as $tk)
    <div class="flex flex-col">
      <div class="w-full h-28 md:h-32 bg-gray-300 rounded-md overflow-hidden">
        <a href="/berita/{{ $tk->slug }}"><img class="w-full h-full object-cover" src="{{ asset('thumbnail/' . $tk->gambar_detail) }}" alt="{{ $tk->caption }}"></a>
      </div>
      <a href="/berita/{{ $tk->slug }}"><div class="mt-2 text-sm dark:text-white hover:text-red-600 dark:hover:text-amber-300 md:text-base font-semibold leading-snug md:leading-snug">{!! $tk->judul !!}</div></a>
      <div class="mt-1 text-xxs font-semibold text-cyan-900 dark:text-red-500">{{ carbon\Carbon::parse($tk->tanggal_tayang)->translatedFormat('l, d F Y') }}</div>
    </div>
    @endforeach
    @endif

  </div>
</div>
{{-- /Berita Lainnya --}}

<div class="flex w-full my-8 h-0.5 bg-gray-200"></div>

{{-- Berita Terkini --}}
<div class="block w-full">
  <div class="flex flex-row items-center justify-between">
      <div class="flex flex-row items-center">
          <div class="h-8 w-1.5 bg-gradient-to-tr from-rose-600 to-orange-500 rounded-full rotate-12"></div>
          <div class="text-lg lg:text-xl ml-2 italic text-slate-700 dark:text-gray-100 whitespace-nowrap"><span class="font-bold">BERITA</span> TERKINI</div>
      </div>
      <div class="text-xs lg:text-sm"><a href="/indeks" class="font-semibold py-0.5 text-gray-500 hover:text-gray-700"><i class="fa-solid fa-arrow-right-long"></i></a></div>
  </div>

  <div class="w-full flex flex-col">
    
    @foreach($terkini as $kn)
    <div class="mt-3 flex flex-row w-full h-auto p-3 bg-white dark:bg-gray-600 border border-opacity-60 drop-shadow-sm hover:shadow-md rounded-lg overflow-hidden justify-between">
      <div class="flex flex-col">
        <a href="/berita/{{ $kn->slug }}"><div class="text-base md:text-lg dark:text-white hover:text-red-600 dark:hover:text-amber-300 font-semibold leading-snug md:leading-snug">{!! $kn->judul !!}</div></a>
        <div class="flex flex-row">
          <div class="mt-1 text-xs font-semibold text-red-600 dark:text-amber-500">{{ $kn->kategori->nama }}</div>
          <div class="mt-1 ml-2 text-xs dark:text-gray-200"><i class="far fa-clock"></i> {{ Carbon\Carbon::parse($kn->tanggal_tayang . ' ' . $kn->waktu)->diffForhumans() }}</div>
        </div>
      </div>
      <div class="w-4/12 md:w-2/12 ml-3">
        <div class="float-right flex w-20 h-20 bg-gray-500 rounded-md overflow-hidden">
          <a href="/berita/{{ $kn->slug }}"><img class="w-full h-full object-cover" src="{{ asset('thumbnail/' . $kn->gambar_detail) }}" alt=""></a>
        </div>
      </div>
    </div>
    @endforeach
    
  </div>
</div>
{{-- /Berita Terkini --}}

</div>
{{-- /Detail --}}

@endsection