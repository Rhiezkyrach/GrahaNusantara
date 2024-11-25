@if($terkini->count())
@foreach($terkini as $kn)

<div class="relative flex flex-col mt-3 w-full h-auto">
    <div class="absolute top-0 z-10 px-3 py-1 main_color text-xxxs md:text-xxs text-white font-semibold rounded-br-md rounded-tl-md">{{ $kn->kategori->nama }}</div>
    <div class="w-full flex flex-row">
        <div class="w-3/12 h-20 md:h-24 lg:h-28 bg-gray-500 rounded-md overflow-hidden">
            @if($kn->gambar_detail)
                <a href="/berita/{{ $kn->slug }}"><img class="w-full h-full object-cover hover:scale-105 duration-300 ease-in-out" src="{{ asset('thumbnail/' . $kn->gambar_detail) }}" alt="{{ $kn->caption }}"></a>
            @else
                <div class="w-full h-full rounded-md skeleton"></div>
            @endif
        </div>
        <div class="flex flex-col w-9/12">
            {{-- <div class="px-4 text-xxs text-white"><span class="px-2 py-0.5 main_color rounded">{{ $kn->kategori->nama }}</span></div> --}}
            <a href="/berita/{{ $kn->slug }}"><p class="px-4 text-sm md:text-xl leading-snug font-bold dark:text-white hover:text-red-600 dark:hover:text-teal-300">{!! $kn->judul !!}</p></a>
            {{-- <p class="px-4 text-xxxs md:text-xs mt-1 font-semibold text-sky-900 dark:text-red-500 mb-3 lg:mb-1"><i class="far fa-calendar-alt"></i> {{ Carbon\Carbon::parse($kn->tanggal_tayang)->translatedFormat('l, d F Y') }} | <i class="far fa-clock"></i> {{ Carbon\Carbon::parse($kn->waktu)->translatedFormat('H:i') }} WIB</p> --}}
            <p class="px-4 text-xxs md:text-xs mt-1 font-semibold text-sky-900 dark:text-red-500 mb-2 lg:mb-1"><i class="far fa-calendar-alt"></i> {{ Carbon\Carbon::parse($kn->tanggal_tayang)->translatedFormat('l, d F Y')}}</p>
            {{-- <p class="hidden lg:flex dark:text-gray-100 px-4 text-xs mt-1 mb-1">{!! strip_tags(Str::words($kn->isi, 20)) !!}</p> --}}
        </div>
    </div>
</div>
<div class="mt-2 w-full h-px bg-gray-200 dark:bg-gray-400"></div>
@endforeach

@else
  <div class="text-center text-xl font-semibold dark:text-gray-200">Tidak Ada Berita</div>
@endif