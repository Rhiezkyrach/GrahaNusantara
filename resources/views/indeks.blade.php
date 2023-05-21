@extends('layouts.main')

@section('main_section')

<!-- Indeks -->
<div class="block w-full mb-8">
  <form method="post" action="/indeks">
      @csrf

      <div class="flex flex-col md:flex-row gap-2 w-full md:items-center">
          <div class="text-sm font-semibold dark:text-gray-100">Tanggal:</div>
          <input type="date" name="tanggal" class="px-4 py-2 w-full text-sm md:w-44 border border-gray-400 rounded-lg active:outline-none" value="{{ old('tanggal', Carbon\Carbon::now()->translatedFormat('Y-m-d')) }}">
        <button type="submit" class="text-sm bg-sky-600 hover:bg-sky-700 py-2.5 px-4 w-full md:w-auto text-white text-center font-semibold rounded-lg whitespace-nowrap"><i class="fas fa-sort"></i> Filter</button>
      </div>

    </form>
</div>

<div class="font-semibold mb-5 dark:text-gray-100">BERITA {{ strToUpper(Carbon\Carbon::now()->translatedFormat('l, d F Y')) }}</div>
@if($indeks->count())
<div class="relative flex-col w-full h-auto">
  <div class="absolute left-[125px] md:left-[157px] shrink-0 w-0.5 h-full bg-red-600 rounded-full"></div>

  <div class="flex flex-col w-full h-auto">

    @foreach($indeks as $in)
    <div class="{{ $loop->iteration == 1 ? ' ' : 'mt-8' }} flex flex-row w-full gap-5">
      <div class="shrink-0 w-24 h-20 md:w-32 md:h-24 bg-gray-100 rounded-md overflow-hidden">
        <a href="/berita/{{ $in->slug }}"><img class="w-full h-full object-cover" src="{{ asset('storage/' . $in->gambar_detail) }}" alt="{{ $in->caption }}"></a>
      </div>
      <div class="shrink-0 w-5 h-5 bg-red-600 rounded-full"></div>
      <div class="w-full flex flex-col">
        <p class="-mt-1 text-lg md:text-xl font-bold text-red-600">{{ Carbon\Carbon::parse($in->waktu)->translatedFormat('H:i') }} WIB</p>
        <p class="text-xxxs md:text-xxs 2xl:text-sm text-sky-900 dark:text-amber-500">{{ Carbon\Carbon::parse($in->tanggal_tayang)->translatedFormat('l. d F Y') }}</p>
        <a href="/berita/{{ $in->slug }}"><p class="mt-2 text-sm md:text-lg 2xl:text-2xl leading-snug md:leading-snug font-bold dark:text-white hover:text-red-600 dark:hover:text-amber-300">{!! $in->judul !!}</p></a>
        {{-- <div class="mt-2 w-full h-0.5 bg-gray-100"></div> --}}
      </div>
    </div>
    @endforeach

  </div>

</div>

@else
  <div class="text-center">Belum ada Berita</div>
@endif
<!-- /Indeks -->

@endsection