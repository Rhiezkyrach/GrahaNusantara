{{-- Iklan Sidebar A--}}
@if($iklanSidebarA->count())
@foreach($iklanSidebarA as $isa)
<div class="block w-full my-4 md:mt-0 h-auto overflow-hidden">
    @if($isa->jenis == "Banner")
    <a href="{{ $isa->link }}"><img class="w-full object-cover" src="{{ asset('storage/'. $isa->foto) }}" alt="{{ $isa->nama }}"></a>
    @else
    {!! $isa->kode !!}
    @endif
</div>
@endforeach
@endif
{{-- /Iklan Sidebar A--}}

<!-- ePaper -->
{{-- @if($epaper)
<div class="block w-full h-auto mb-5 bg-gradient-to-tr from-emerald-700 to-sky-800 rounded-md">
<div class="flex flex-col justify-between mx-4">
    <div class="font-semibold text-lg 2xl:text-xl text-white mt-2">ePaper Edisi {{ Carbon\Carbon::parse($epaper->edisi)->translatedFormat('d F Y') }}</div>
    <div class="bg-white h-auto mt-2 mb-4 shadow-inner rounded-md overflow-hidden">
        <a href="{{ URL::to('/') }}/epaper/{{ $epaper->id }}/{{ Str::slug('epaper edisi '. Carbon\Carbon::parse($epaper->edisi)->translatedFormat('l, d F Y'), '-') }}">
        <img src="{{ asset('thumbnail/'. $epaper->cover) }}" alt="{{ 'epaper edisi'. $epaper->edisi }}">
        </a>
    </div>
</div>
</div>
@endif --}}
<!-- ePaper -->

{{-- Iklan Sidebar B--}}
@if($iklanSidebarB->count())
@foreach($iklanSidebarB as $isb)
<div class="block w-full my-4 md:mt-5 h-auto overflow-hidden">
    @if($isb->jenis == "Banner")
    <a href="{{ $isb->link }}"><img class="w-full object-cover" src="{{ asset('storage/'. $isb->foto) }}" alt="{{ $isb->nama }}"></a>
    @else
    {!! $isb->kode !!}
    @endif
</div>
@endforeach
@endif
{{-- /Iklan Sidebar B--}}

{{-- Google News --}}
<a href="{{ $setting->google_news }}" class="mt-4 md:mt-0 flex flex-row px-3 py-2 gap-2 bg-slate-200 hover:bg-slate-300 border borde-slate-500 rounded items-center justify-between">
    <div class="text-2xl text-gray-800"><i class="fa-regular fa-bell"></i></div>
    <div class="w-full text-sm text-gray-800">Jangan lewatkan Informasi terbaru, subscribe <span class="text-slate-800 font-bold">Google News {{ $setting->judul_situs }}</span></div>
</a>
{{-- /Google News --}}

<!-- Populer-->
<div class="mt-5 pb-2 flex flex-col bg-gray-200 dark:bg-gray-600 rounded-lg border border-teal-300 overflow-hidden">
    {{-- <div class="flex flex-row items-center">
        <div class="h-8 w-1.5 bg-gradient-to-tr from-rose-600 to-orange-500 rounded-full rotate-12"></div>
        <div class="text-lg lg:text-xl ml-2 italic text-slate-700 dark:text-gray-100 whitespace-nowrap"><span class="font-bold">BERITA</span> <i class="fa-solid fa-fire-flame-curved text-rose-600"></i> POPULER</div>
    </div>
    <div class="text-xs lg:text-sm"><a href="/indeks" class="font-semibold py-0.5 text-gray-500 hover:text-gray-700"><i class="fa-solid fa-arrow-right-long"></i></a></div> --}}

    <div class=" w-full text-center px-5 py-1.5 main_color text-white italic whitespace-nowrap">
        <span class="font-bold">BERITA</span> <i class="fa-solid fa-fire-flame-curved text-amber-300"></i> TERPOPULER</span>
    </div>

    {{-- 1st Polpuler --}}
    @foreach($populer->slice(0, 1) as $pop1)
    <div class="flex flex-col justify-between group relative h-auto overflow-hidden">         
        {{-- <div class="absolute top-0 z-10 px-4 py-1 bg-gradient-to-r from-rose-600 to-orange-500 text-4xl text-white font-bold rounded-br-xl">01</div> --}}
        <div class="absolute bottom-5 group-hover:mb-2 px-2 flex flex-col items-start transition-all duration-300 ease-in-out">
            <a href="/berita/{{ $pop1->slug }}" class="z-10 mx-2 text-sm lg:text-base font-semibold leading-none text-white antialiased">{!! $pop1->judul !!}</a>
            <p class="z-10 mx-2 text-xxs mt-3 text-white antialiased"><span class="mr-1 font-bold main_color px-1.5 py-0.5 text-white rounded">{{ $pop1->kategori->nama }}</span> {{ Carbon\Carbon::parse($pop1->tanggal_tayang . ' ' .$pop1->waktu)->diffForHumans() }}</p>
        </div>
        
        <a href="/berita/{{ $pop1->slug }}" class="w-full">
            <div class="flex w-full h-52 md:h-40 lg:h-52 z-1 bg-gradient-to-t from-30% from-gray-900 rounded-b-xl  transition-all duration-300 ease-in-out overflow-hidden">
                <img class="w-full h-full object-cover mix-blend-overlay" src="{{ asset('storage/' . $pop1->gambar_detail) }}" alt="{{ $pop1->caption }}">
            </div>
        </a>
    </div>
    @endforeach
    {{-- 1st Populer --}}
    
    <div class="mt-4 mb-2 flex flex-col px-2 gap-4 items-start">
        @foreach($populer->skip(1) as $pop)
            <div class="group flex flex-row w-full gap-1">
                <div class="flex flex-grow-0 w-10 h-10 bg-gradient-to-t from-indigo-600 to-teal-400 group-hover:text-red-500 dark:group-hover:text-amber-300 rounded-md">
                    <div class="text-2xl font-bold text-gray-200 text-center mx-auto">{{  sprintf('%02d', $loop->iteration + 1) }}</div>
                </div>
                {{-- <div class="ml-2 w-px h-auto min-h-25px bg-gray-400"></div> --}}
                <div class="md:-mt-1 w-full flex flex-col">
                    <a href="/berita/{{ $pop->slug }}" class="ml-3 text-sm lg:text-base font-semibold leading-snug dark:text-white hover:text-red-600 dark:hover:text-amber-300">{!! $pop->judul !!}</a>
                    <p class="pl-3 mt-px text-xxs dark:text-gray-200"><span class="font-bold text-red-600">{{ $pop->kategori->nama }}</span> | {{ Carbon\Carbon::parse($pop->tanggal_tayang . ' ' . $pop->waktu)->diffForHumans() }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
<!-- /Populer-->

{{-- Iklan Sidebar C--}}
@if($iklanSidebarC->count())
@foreach($iklanSidebarC as $isc)
<div class="block w-full my-4 h-auto overflow-hidden">
    @if($isc->jenis == "Banner")
    <a href="{{ $isc->link }}"><img class="w-full object-cover" src="{{ asset('storage/'. $isc->foto) }}" alt="{{ $isc->nama }}"></a>
    @else
    {!! $isc->kode !!}
    @endif
</div>
@endforeach
@endif
{{-- /Iklan Sidebar C--}}