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

<!-- Breadcrumb -->
<nav class="flex px-4 py-2 text-gray-700 border border-teal-300 rounded-md bg-gray-50 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
  <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
    <li class="inline-flex items-center">
      <a href="{{ url('/') }}" class="inline-flex items-center text-xxxs md:text-xs font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
          <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
        </svg>
        Home
      </a>
    </li>
    <li>
      <div class="flex items-center">
        <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-gray-400 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
        </svg>
        <a href="{{ url('/kategori/' . Str::slug(strtolower($berita->kategori->nama), '-')) }}" class="ms-1 text-xxxs md:text-xs font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">{{ $berita->kategori->nama }}</a>
      </div>
    </li>
    <li aria-current="page">
      <a href="{{ url('berita/' . $berita->slug) }}">
      <div class="flex items-center">
        <svg class="rtl:rotate-180  w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
        </svg>
        <span class="ms-1 text-xxxs md:text-xs font-bold text-teal-600 md:ms-2 dark:text-gray-400">Detail</span>
      </div>
      </a>
    </li>
  </ol>
</nav>

{{-- Judul --}}
@if($berita->judul_atas)
  <div class="text-base font-bold mt-4 uppercase text-red-600">{{ $berita->judul_atas }}</div>
@endif

<h1 class="text-xl md:text-3xl font-extrabold mt-2 leading-tight text-slate-800 dark:text-white">{!! $berita->judul !!}</h1>

@if($berita->sub_judul)
  <h2 class="text-base md:text-xl font-semibold mt-2 text-gray-500 dark-text-gray-300 leading-snug">{{ $berita->sub_judul }}</h2>
@endif
{{-- /Judul --}}

<div class="flex flex-row w-full mt-4 items-center justify-between">
    {{-- Detail Wartawan --}}
    <div class="flex flex-row items-center">
        <div class="flex w-8 h-8 md:w-10 md:h-10 rounded-full bg-gray-100 overflow-hidden">
          @if($berita->oleh !== '' && $berita->oleh !== NULL)
            @if($berita->foto_penulis)
            <img class="w-full object-cover" src="{{ asset('storage/' . $berita->foto_penulis) }}" aria-hidden="true" alt="">
            @endif
            <img class="w-full object-cover" src="{{ asset('images/profile-default.png') }}" aria-hidden="true" alt="">
          @elseif($berita->reporter->foto)
          <img class="w-full object-cover" src="{{ asset('storage/' . $berita->reporter->foto) }}" aria-hidden="true" alt="">
          @else
          <img class="w-full object-cover" src="{{ asset('images/profile-default.png') }}" aria-hidden="true" alt="">
          @endif
        </div>

        <div class="ml-1 md:ml-2 flex flex-col justify-between">
          @if($berita->oleh !== '' && $berita->oleh !== NULL)
          <div class="text-xs md:text-sm font-bold text-teal-600">{{ $berita->oleh }} <i class="fa-solid fa-badge-check"></i></div>
          @else
          <div class="text-xs md:text-sm font-bold text-teal-600">{{ $berita->wartawan}} <i class="fa-solid fa-badge-check"></i></div>
          @endif
          <div class="mt-px text-xxxs md:text-xs dark:text-gray-200">{{ Carbon\Carbon::parse($berita->tanggal_tayang . ' ' .$berita->waktu)->translatedFormat('l, d F Y | H:i')}} WIB</div>
        </div>
    </div>
    {{-- /Detail Wartawan --}}

    {{-- Sharer --}}
    <div class="flex flex-row gap-2">
      {{-- Facebook --}}
      <div class="block hover:-mt-1 duration-300 ease-in-out">
        <a href="{{ 'https://www.facebook.com/sharer/sharer.php?u=' .  url('berita/' . $berita->slug) }}" 
            target="_blank" class="flex text-lg p-1 md:p-2 bg-slate-200 hover:bg-teal-200 border border-teal-300 rounded">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="text-blue-600" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
          </svg>
        </a>
      </div>
      {{-- X --}}
      <div class="block hover:-mt-1 duration-300 ease-in-out">
        <a href="{{ 'https://twitter.com/intent/tweet?url=' .  url('berita/' . $berita->slug) }}" 
            target="_blank" class="flex text-lg p-1 md:p-2 bg-slate-200 hover:bg-teal-200 border border-teal-300 rounded">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="text-slate-700" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
            <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
          </svg>
        </a>
      </div>
      {{-- Whatsapp --}}
      <div class="block hover:-mt-1 duration-300 ease-in-out">
        <a href="{{ 'https://web.whatsapp.com/send?text=' . $berita->judul . '%0A' .  url('berita/' . $berita->slug) }}" 
            target="_blank" class="hidden md:flex text-lg p-1 md:p-2 bg-slate-200 hover:bg-teal-200 border border-teal-300 rounded">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="text-green-600" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
            <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
          </svg>
        </a>
        <a href="{{ 'https://api.whatsapp.com/send?text=' . $berita->judul . '%0A' .  url('berita/' . $berita->slug)  }}"
            target="_blank" class="flex md:hidden text-lg p-1 md:p-2 bg-slate-200 hover:bg-teal-200 border border-teal-300 rounded">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="text-green-600" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
            <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
          </svg>
        </a>
      </div>
      {{-- Telegram --}}
      <div class="block hover:-mt-1 duration-300 ease-in-out">
        <a href="{{ 'https://telegram.me/share/url?url=' .  url('berita/' . $berita->slug) }}" 
            target="_blank" class="flex text-lg p-1 md:p-2 bg-slate-200 hover:bg-teal-200 border border-teal-300 rounded">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="text-teal-600" fill="currentColor" class="bi bi-telegram" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.287 5.906q-1.168.486-4.666 2.01-.567.225-.595.442c-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294q.39.01.868-.32 3.269-2.206 3.374-2.23c.05-.012.12-.026.166.016s.042.12.037.141c-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8 8 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629q.14.092.27.187c.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.4 1.4 0 0 0-.013-.315.34.34 0 0 0-.114-.217.53.53 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09"/>
          </svg>
        </a>
      </div>
    </div>
  {{-- /Sharer --}}
</div>

{{-- Foto --}}
<div class="mt-2 flex w-full h-56 md:h-72 lg:h-[400px] bg-gray-100 {{ $galeri->count() ? 'rounded-md' : 'rounded-t-md' }} overflow-hidden">
    @if($galeri->count())

    <section id="galeri" class="splide w-full flex-shrink-0 flex-grow-0" aria-label="Galeri Foto">
      <div class="splide__track">
        <div class="splide__list">
          @foreach($galeri as $g)
            @if($g->nama_photo && Storage::exists($g->nama_photo))
              <img class="splide__slide w-full h-full object-cover" src="{{ asset('storage/' . $g->nama_photo ) }}" alt="{{ $berita->caption }}" title="{{ $berita->judul }}">
            @else
              <div class="w-full h-full rounded-t-md skeleton"></div>
            @endif
          @endforeach
        </div>
      </div>
    </section>

    @elseif($berita->video != '')
      <iframe src="{{ $berita->video }}" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>
    @else
      @if($berita->gambar_detail && Storage::exists($berita->gambar_detail))
        <img class="w-full h-full object-cover" src="{{ asset('storage/' . $berita->gambar_detail) }}" alt="{{ $berita->caption }}" title="{{ $berita->judul }}">
      @else
        <div class="w-full h-full rounded-md skeleton"></div>
      @endif
    @endif
</div>
@if($galeri->count() == NULL)
<div class="px-3 py-2 -mt-1 text-xs bg-teal-50 border border-teal-300 rounded-b-md">{{ $berita->caption }}</div>
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

<div class="mt-4 text-base dark:text-white">
  
  @foreach(array_slice($blocks, 0, $jumlahParagraf - 1) as $block)
    {!! $block !!}
    @if($loop->iteration == 2 && $terkait->count())
    <div class="flex flex-col md:float-left w-full h-auto">
      <div class="relative bg-gradient-to-tr from-slate-200 to-slate-100 dark:bg-gray-600 h-auto rounded-md overflow-hidden">
        <div class="absolute top-0 z-10 px-5 py-1.5 bg-gradient-to-r from-teal-400 to-indigo-600 text-xs text-white font-semibold rounded-br-xl">BACA JUGA</div>
        <div class="my-3 mt-8 mx-5 flex flex-col divide-y divide-slate-600">
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
    {!! $e[0] !!}
    {{-- <span class="inline-block ml-1 -mb-0.5 w-4 h-4 bg-white rounded-full overflow-hidden"><img class="object-cover" src="{{ asset('images/icon_rajamedia.png') }}" alt="rajamedia"></span></p> --}}
  @endforeach

</div>
{{-- /Isi --}}

@if($berita->kode_embed)
<div class="w-full mt-5 text-center">
 <div class="block mx-auto">{!! $berita->kode_embed !!}</div>
</div>
@endif

{{-- Tag --}}
<div class="mt-5 flex flex-row flex-wrap gap-1.5">
    <div class="font-semibold dark:text-gray-100"><i class="fas fa-tags"></i> TAG:</div>
    @php $tags = explode(',', $berita->tag) @endphp
    @foreach($tags as $t)
      <a href="{{ url('/search?tag=' . $t)}}" class="group flex flex-row text-sm text-teal-600 font-semibold ">
          <span class="px-1 py-0.5 text-white bg-teal-500 group-hover:bg-teal-600 border border-teal-500 rounded-l">#</span>
          <span class="-ml-px px-1 py-0.5 bg-gray-50 group-hover:bg-gray-200 border border-teal-500 rounded-r">{{ $t }}</span>
      </a>
    @endforeach
</div>
{{-- /Tag --}}

<div class="w-full mt-5 flex flex-col">

  @if($berita_next)
  <div class="w-full h-auto px-4 py-3 main_color rounded-t-md">
    <div class="flex flex-row items-center justify-between">
      <div class="flex w-full flex-col">
        <div class="mr-2 md:mr-3 text-xxs md:text-xs text-right text-teal-600 font-semibold"><span class="px-2 py-0.5 bg-gray-100 rounded-full">Baca Berikutnya:</span></div>
        <a href="/berita/{{ $berita_next->slug }}"><div class="mr-2 md:mr-3 mt-2 text-xs md:text-sm text-right text-gray-100 hover:text-yellow-300 font-bold">{!! Str::wordCount($berita_next->judul) > 12 ? Str::words($berita_next->judul, 12, '...') : $berita_next->judul !!}</div></a>
      </div>
      <div class="flex shrink-0 w-12 h-12 bg-white rounded-md overflow-hidden">
        @if($berita_next->gambar_detail)
          <a href="/berita/{{ $berita_next->slug }}"><img class="w-full h-full object-cover" src="{{ asset('thumbnail/' . $berita_next->gambar_detail) }}" alt="{{ $berita_next->caption }}"></a>
        @else
          <div class="w-full h-full rounded-md skeleton"></div>
        @endif
      </div>
    </div>
  </div>
  @elseif($berita_prev)
   <div class="w-full h-auto px-4 py-3 main_color rounded-t-md">
    <div class="flex flex-row items-center justify-between">
      <div class="flex shrink-0 w-12 h-12 bg-white rounded-md overflow-hidden">
        <a href="/berita/{{ $berita_prev->slug }}"><img class="w-full h-full object-cover" src="{{ asset('thumbnail/' . $berita_prev->gambar_detail) }}" alt="{{ $berita_prev->caption }}"></a>
      </div>
      <div class="flex w-full flex-col">
        <div class="ml-2 md:ml-3 text-xxs md:text-xs text-left text-teal-600 font-semibold"><span class="px-2 py-0.5 bg-gray-100 rounded-full">Jangan Terlewat:</span></div>
        @if($berita_prev->gambar_detail)
          <a href="/berita/{{ $berita_prev->slug }}"><div class="ml-2 md:ml-3 mt-2 text-xs md:text-sm text-left text-gray-100 hover:text-yellow-300 font-bold">{!! Str::wordCount($berita_prev->judul) > 12 ? Str::words($berita_prev->judul, 12, '...') : $berita_prev->judul !!}</div></a>
        @else
          <div class="w-full h-full rounded-md skeleton"></div>
        @endif
      </div>
    </div>
  </div>
  @endif

  <a href="{{ url('kategori/' . Str::slug($berita->Kategori->nama)) }}" class="text-xs text-center text-slate-50 w-full p-2 bg-slate-800 rounded-b-md hover:text-red-600">Lihat {{ $berita->Kategori->nama }} Selengkapnya <i class="fa-solid fa-arrow-right"></i></a>

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
  <div class="flex flex-row items-center justify-between px-2 py-1 bg-teal-100 dark:bg-teal-200 border border-teal-300 rounded">
      <div class="flex flex-row items-center">
          <div class="h-8 w-8 bg-gradient-to-tr text-white text-center text-lg from-teal-500 to-indigo-500 rounded"><i class="mt-1.5 fa-regular fa-badge-check"></i></div>
          <div class="text-lg ml-2 text-teal-600 dark:text-teal-700 whitespace-nowrap"><span class="font-bold">PILIHAN UNTUKMU</span></div>    
      </div>
      <div class="text-xs lg:text-sm"><a href="/indeks" class="py-0.5 text-gray-500 hover:text-gray-700">Lihat Lainnya <i class="fa-solid fa-arrow-right-long"></i></a></div>
  </div>

  <div class="mt-5 w-full grid grid-cols-2 lg:grid-cols-3 gap-5">

    @if($terkait->count())
    @foreach($terkait as $tr)
    <div class="flex flex-col">
      <div class="w-full h-28 md:h-32 bg-gray-300 rounded-md overflow-hidden">
        @if($tr->gambar_detail)
          <a href="/berita/{{ $tr->slug }}"><img class="w-full h-full object-cover" src="{{ asset('thumbnail/' . $tr->gambar_detail) }}" alt="{{ $tr->caption }}"></a>
        @else
            <div class="w-full h-full rounded-md skeleton"></div>
        @endif
      </div>
      <a href="/berita/{{ $tr->slug }}"><div class="mt-2 text-xxs md:text-base dark:text-white hover:text-red-600 dark:hover:text-amber-300 font-semibold leading-snug">{!! $tr->judul !!}</div></a>
      <div class="mt-1 text-xxxs font-semibold text-cyan-900 dark:text-red-500">{{ carbon\Carbon::parse($tr->tanggal_tayang)->translatedFormat('l, d F Y') }}</div>
    </div>
    @endforeach
    @endif

    @if($terkait->count() < 6)
    @foreach($terkaitkanal as $tk)
    <div class="flex flex-col">
      <div class="w-full h-28 md:h-32 bg-gray-300 rounded-md overflow-hidden">
        @if($tk->gambar_detail)
          <a href="/berita/{{ $tk->slug }}"><img class="w-full h-full object-cover" src="{{ asset('thumbnail/' . $tk->gambar_detail) }}" alt="{{ $tk->caption }}"></a>
        @else
            <div class="w-full h-full rounded-md skeleton"></div>
        @endif
      </div>
      <a href="/berita/{{ $tk->slug }}"><div class="mt-2 text-xxs md:text-base dark:text-white hover:text-red-600 dark:hover:text-amber-300 font-semibold leading-snug">{!! $tk->judul !!}</div></a>
      <div class="mt-1 text-xxxs font-semibold text-cyan-900 dark:text-red-500">{{ carbon\Carbon::parse($tk->tanggal_tayang)->translatedFormat('l, d F Y') }}</div>
    </div>
    @endforeach
    @endif

  </div>
</div>
{{-- /Berita Lainnya --}}

<div class="flex w-full my-8 h-0.5 bg-gray-200"></div>

{{-- Berita Terkini --}}
<div class="block w-full">
  <div class="flex flex-row items-center justify-between px-2 py-1 bg-teal-100 dark:bg-teal-200 border border-teal-300 rounded">
      <div class="flex flex-row items-center">
          <div class="h-8 w-8 bg-gradient-to-tr text-white text-center text-lg from-teal-500 to-indigo-500 rounded"><i class="mt-1.5 fa-regular fa-newspaper"></i></div>
          <div class="text-lg ml-2 text-teal-600 dark:text-teal-700 whitespace-nowrap"><span class="font-bold">BERITA TERKINI</span></div>    
      </div>
      <div class="text-xs lg:text-sm"><a href="/indeks" class="py-0.5 text-gray-500 hover:text-gray-700">Lihat Lainnya <i class="fa-solid fa-arrow-right-long"></i></a></div>
  </div>

  <div class="w-full flex flex-col">
    
    @foreach($terkini as $kn)
      <div class="mt-3 flex flex-row w-full h-auto p-3 bg-gray-100 dark:bg-gray-600 border border-teal-300 border-opacity-60 drop-shadow-sm hover:shadow-md rounded-lg overflow-hidden justify-between">
        <div class="flex flex-col">
          <a href="/berita/{{ $kn->slug }}"><div class="text-sm md:text-lg dark:text-white hover:text-red-600 dark:hover:text-amber-300 font-semibold leading-snug md:leading-snug">{!! $kn->judul !!}</div></a>
          <div class="flex flex-row">
            <div class="mt-1 text-xs font-semibold text-red-600 dark:text-amber-500">{{ $kn->kategori->nama }}</div>
            <div class="mt-1 ml-2 text-xs dark:text-gray-200"><i class="far fa-clock"></i> {{ Carbon\Carbon::parse($kn->tanggal_tayang . ' ' . $kn->waktu)->diffForhumans() }}</div>
          </div>
        </div>
        <div class="w-4/12 md:w-2/12 ml-3">
          <div class="float-right flex w-20 h-20 bg-gray-500 rounded-md overflow-hidden">
            @if($kn->gambar_detail)
              <a href="/berita/{{ $kn->slug }}"><img class="w-full h-full object-cover" src="{{ asset('thumbnail/' . $kn->gambar_detail) }}" alt=""></a>
            @else
              <div class="w-full h-full rounded-md skeleton"></div>
            @endif
          </div>
        </div>
      </div>
    @endforeach
    
  </div>
</div>
{{-- /Berita Terkini --}}

</div>
{{-- /Detail --}}

@push('js')
<script>
$( document ).ready(function() {

  let galeri = $('#galeri')
  
  if(galeri){
    new Splide( '#galeri', {
        mediaQuery: 'min',
        type   : 'loop',
        autoplay: true,
        interval: 3000,
        // pagination: false,
        gap: 10,
    }).mount();
  }
});
</script>
@endpush

@endsection