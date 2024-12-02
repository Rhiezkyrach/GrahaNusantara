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

{{-- Popular Tag --}}
@if($trending)
<div class="block w-full mb-3">
    <div class="flex flex-row items-center justify-between px-2 py-1 bg-teal-100 dark:bg-teal-200 border border-teal-300 rounded">
        <div class="flex flex-row items-center">
            <div class="h-8 w-8 bg-gradient-to-tr text-white text-center text-lg from-teal-400 to-indigo-500 rounded"><i class="mt-1.5 fa-solid fa-hashtag"></i></div>
            <div class="text-lg ml-2 text-teal-600 dark:text-teal-700 whitespace-nowrap"><span class="font-bold">TAG POPULER</span></div>    
        </div>
        <div class="text-xs lg:text-sm"><a href="/indeks" class="py-0.5 text-gray-500 hover:text-gray-700"><i class="fa-solid fa-arrow-right-long"></i></a></div>
    </div>

    <div class="flex flex-col gap-2">
        <div class="mt-1"></div>
        @foreach($trending as $tr)
            @php
                $tag = explode(',', $tr->tag);
            @endphp
            
            <a href="{{ $tag[0] ? url('/search?tag=' . $tag[0]) : ''}}" class="group flex flex-row text-sm text-teal-600 font-semibold ">
                <span class="px-1 py-0.5 text-white bg-teal-500 group-hover:bg-teal-600 border border-gray-300 rounded-l">#</span>
                <span class="-ml-px px-1 py-0.5 bg-gray-100 group-hover:bg-gray-200 border border-gray-300 rounded-r">{{ $tag[0] ? $tag[0] : '' }}</span>
            </a>
        @endforeach
    </div>
</div>
@endif
{{-- /Popular Tag --}}

{{-- Fokus --}}
@foreach($Fokus as $key => $d)
<div class="mt-5 w-full flex-flex-row">
    <img class="object-cover rounded-t-lg" src="{{ asset('storage/' . $d->foto) }}" alt="Dewan Perwakilan Rakyat">
    
    <div class="relative w-full mb-3 p-4 bg-gray-200 h-auto rounded-b-lg">
        {{-- <div class="mr-5 absolute top-0 right-0 z-0 text-sm font-semibold text-red-600"><span class="bg-white py-1 px-3 rounded-b-md">CALON DEWAN</span></div> --}}
        <div class="">
        @foreach($d->Berita->slice(0, 3) as $b)
        <a href="/berita/{{ $b->slug }}" class="my-2 text-sm font-semibold hover:text-red-600 "><p class="leading-snug">{{ $b->judul }}</p></a>
        <div class="my-1 w-full h-px {{ $loop->last ? '' : 'bg-red-600' }}"></div>
        @endforeach
        </div>
    </div>
</div>
@endforeach
{{-- /Fokus --}}

<!-- Opini -->
@if($Opini)
<div class="block w-full mt-5 mb-3">
    <div class="flex flex-row items-center justify-between px-2 py-1 bg-teal-100 dark:bg-teal-200 border border-teal-300 rounded">
        <div class="flex flex-row items-center">
            <div class="h-8 w-8 bg-gradient-to-tr text-white text-center text-lg from-teal-400 to-indigo-500 rounded"><i class="mt-1.5 fa-regular fa-comments"></i></div>
            <div class="text-lg ml-2 text-teal-600 dark:text-teal-700 whitespace-nowrap"><span class="font-bold">KOLOM</span></div>    
        </div>
        <div class="text-xs lg:text-sm"><a href="/indeks" class="py-0.5 text-gray-500 hover:text-gray-700"><i class="fa-solid fa-arrow-right-long"></i></a></div>
    </div>

    <div class="flex flex-col gap-3 divide-y divide-gray-200 rounded-full">

    @foreach($Opini as $op)
    <div class="flex flex-col w-full">
    <div class="flex flex-row mt-3">
        <div class="flex w-14 h-14 2xl:w-20 2xl:h-20">
        <a href="/berita/{{ $op->slug }}" class="w-full">
        @if($op->oleh !== '' && $op->oleh !== NULL )
            <img src="{{ asset('storage/' . $op->foto_penulis) }}" class="w-full h-full object-cover rounded-full" alt="" aria-hidden="true">
        @elseif($op->reporter->foto)
            <img src="{{ asset('storage/' . $op->reporter->foto) }}" class="w-full h-full object-cover rounded-full" alt="{{ $op->wartawan }}" aria-hidden="true">
        @else
            <img src="{{ asset('storage/gambar/foto/wartawan/default_photo.jpg') }}" class="w-full h-full object-cover rounded-full" alt="rajamedia" aria-hidden="true">
        @endif
        </a>
        </div>
        <div class="flex flex-col w-9/12">
        @if($op->oleh !== '')
        <p class="pl-3 text-xs 2xl:text-sm font-bold text-teal-600 dark:text-teal-500">{{ strtoupper($op->oleh) }}</p>
        @else
        <p class="pl-3 text-xs 2xl:text-sm font-bold text-teal-600 dark:text-teal-500">{{ strtoupper($op->wartawan) }}</p>
        @endif
        <a href="/berita/{{ $op->slug }}" class="pl-3 text-base 2xl:text:lg mt-0.5 font-semibold leading-tight dark:text-white hover:text-red-600 dark:hover:text-amber-300">{!! $op->judul !!}</a>
        <p class="pl-3 text-xxs 2xl:text-xs mt-1 dark:text-gray-200"><i class="far fa-clock"></i> {{ Carbon\Carbon::parse($op->tanggal_tayang . ' ' . $op->waktu)->diffForHumans() }}</p>
        </div>
    </div>
    </div>
    @endforeach

    </div>
</div>
@endif
<!-- /Opini -->

{{-- Corong Rakyat --}}
{{-- @if($corongRakyat)
<div class="relative w-full mt-5 mb-3 px-4 py-6 bg-gradient-to-r from-red-600 to-orange-500 h-auto rounded-lg">
    <div class="mr-5 absolute top-0 right-0 z-0 text-sm font-semibold text-red-600 dark:text-amber-500"><span class="bg-white dark:bg-slate-800 py-1 px-3 rounded-b-md">CORONG RAKYAT</span></div>
    <div class="pt-4 text-base font-bold text-white">{{ $corongRakyat->nama }}</div>
    <div class="mt-2 text-xs italic text-white">{{ $corongRakyat->kode }}</div>
    <div class="mt-2 text-xs font-semibold text-white">{{ $corongRakyat->AE }}</div>
</div>
@endif --}}
{{-- /Corong Rakyat --}}

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
            <div class="flex w-full h-52 md:h-40 lg:h-52 z-1 bg-gradient-to-t from-30% from-gray-900 rounded-b-xl transition-all duration-300 ease-in-out overflow-hidden">
                @if($pop1->gambar_detail && Storage::exists($pop1->gambar_detail))
                    <img class="w-full h-full object-cover mix-blend-overlay" src="{{ asset('storage/' . $pop1->gambar_detail) }}" alt="{{ $pop1->caption }}">
                @else
                    <div class="w-full h-full rounded-b-xl skeleton"></div>
                @endif
            </div>
        </a>
    </div>
    @endforeach
    {{-- 1st Populer --}}
    
    <div class="mt-4 mb-2 flex flex-col px-2 gap-4 items-start">
        @foreach($populer->skip(1) as $pop)
            <div class="group flex flex-row w-full gap-1">
                <div class="flex flex-grow-0 w-10 h-10 bg-gradient-to-tr from-indigo-600 to-teal-400 group-hover:text-red-500 dark:group-hover:text-amber-300 rounded-md">
                    <div class="text-2xl font-bold text-gray-200 text-center mx-auto">{{  sprintf('%02d', $loop->iteration + 1) }}</div>
                </div>
                {{-- <div class="ml-2 w-px h-auto min-h-25px bg-gray-400"></div> --}}
                <div class="md:-mt-1 w-full flex flex-col">
                    <a href="/berita/{{ $pop->slug }}" class="ml-3 text-sm lg:text-base font-semibold leading-snug dark:text-white hover:text-red-600 dark:hover:text-amber-300">{!! $pop->judul !!}</a>
                    <p class="pl-3 text-xxs dark:text-gray-200"><span class="font-bold text-red-600">{{ $pop->kategori->nama }}</span> | {{ Carbon\Carbon::parse($pop->tanggal_tayang . ' ' . $pop->waktu)->diffForHumans() }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
<!-- /Populer-->

<!-- Olahraga -->
{{-- @if($Olahraga)
<div class="block w-full h-auto mt-5">
    <div class="flex flex-row mt-5 items-center justify-between">
    <div class="flex flex-col">
        <div class="text-lg 2xl:text-xl"><span class="font-extrabold text-slate-800">Olahraga</span></div>
        <div class="w-full h-1.5 bg-red-600"></div>
    </div>
        <div class="text-xs lg:text-sm"><a href="/kategori/parlemen" class="font-semibold py-0.5 text-gray-500 hover:text-gray-700"><i class="fa-solid fa-arrow-right-long"></i></a></div>
    </div>
    <div class="flex w-full h-px bg-red-600"></div>

    <div class="mt-2 flex flex-col justify-between">
        <div class="bg-gray-200 h-52 md:h-36 lg:h-52 2xl:h-56 my-2 rounded-md overflow-hidden">
        <a href="#"><img class="w-full object-cover" src="{{ asset('storage/'. $Olahraga->gambar_detail) }}" alt="{{ $Olahraga->judul }}"></a>
        </div>
        <a href="#" class="mt-1.5 font-semibold text-lg hover:text-red-600" target="_blank">{!! $Olahraga->judul !!}</a>
        <p class="text-xs mt-1.5"><i class="far fa-clock"></i> {{ Carbon\Carbon::parse($Olahraga->tanggal_tayang)->diffForhumans() }}</p>
    </div>
    </div>
@endif --}}
<!-- Olahraga -->

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