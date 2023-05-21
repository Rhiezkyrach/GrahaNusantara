<!-- Berita Bawah -->
<div class="w-full grid grid-cols-1 md:grid-cols-3 gap-5 mt-5">

    <!-- Parlemen -->
    <div class="w-full mt-2">
        <div class="flex flex-row items-center justify-between">
            <div class="flex flex-row items-center">
                <div class="h-8 w-1.5 bg-gradient-to-tr from-rose-600 to-orange-500 rounded-full rotate-12"></div>
                <div class="text-lg lg:text-xl ml-2 italic text-slate-700 dark:text-gray-100 whitespace-nowrap"><span class="font-bold">PARLEMEN</span></div>
            </div>
            <div class="text-xs lg:text-sm"><a href="/indeks" class="font-semibold py-0.5 text-gray-500 hover:text-gray-700"><i class="fa-solid fa-arrow-right-long"></i></a></div>
        </div>

        @foreach($Parlemen->slice(0, 3) as $par)
            @if($loop->iteration == 1)
            <div class="relative h-52 md:h-40 lg:h-52 rounded-md overflow-hidden my-3">
                <div class="absolute top-0 z-10 px-5 py-1.5 bg-gradient-to-r from-rose-600 to-orange-500 text-xs text-white font-semibold rounded-br-xl">{{ $par->kategori->nama }}</div>
                <a href="/berita/{{ $par->slug }}">
                <img class="w-full h-full object-cover" src="{{ asset('storage/' . $par->gambar_detail) }}" alt="{{ $par->caption }}">
                </a>
            </div>
            <a href="/berita/{{ $par->slug }}" class="text-xl font-bold leading-snug md:leading-snug dark:text-white hover:text-red-600 dark:hover:text-amber-300">{!! $par->judul !!}</a>
            <p class="text-xxs 2xl:text-sm text-sky-900 dark:text-red-500 font-medium mt-1.5 mb-3">{{ Carbon\Carbon::parse($par->tanggal_tayang . ' ' . $par->waktu)->translatedFormat('l, d F Y | H:i') }} WIB</p>
            @else
            <div class="flex flex-row">
                <div class="flex shrink-0 w-14 h-14 rounded-md overflow-hidden">
                    <a href="/berita/{{ $par->slug }}">
                    <img class="w-full h-full object-cover" src="{{ asset('storage/' . $par->gambar_detail) }}" alt="">
                    </a>
                </div>
                <a href="/berita/{{ $par->slug }}" class="ml-3 text-base font-bold leading-snug md:leading-snug dark:text-white hover:text-red-600 dark:hover:text-amber-300">{!! $par->judul !!}</a>
            </div>
            @endif
            <div class="block w-full h-px bg-gray-300 dark:bg-gray-400 rounded-full my-2"></div>
        @endforeach
    </div>
    <!-- /Parlemen -->

    <!-- Olahraga -->
    <div class="w-full mt-2">
        <div class="flex flex-row items-center justify-between">
            <div class="flex flex-row items-center">
                <div class="h-8 w-1.5 bg-gradient-to-tr from-rose-600 to-orange-500 rounded-full rotate-12"></div>
                <div class="text-lg lg:text-xl ml-2 italic text-slate-700 dark:text-gray-100 whitespace-nowrap"><span class="font-bold">OLAHRAGA</span></div>
            </div>
            <div class="text-xs lg:text-sm"><a href="/indeks" class="font-semibold py-0.5 text-gray-500 hover:text-gray-700"><i class="fa-solid fa-arrow-right-long"></i></a></div>
        </div>

        @foreach($Olahraga->slice(0, 3) as $ol)
            @if($loop->iteration == 1)
            <div class="relative h-52 md:h-40 lg:h-52 rounded-md overflow-hidden my-3">
                <div class="absolute top-0 z-10 px-5 py-1.5 bg-gradient-to-r from-rose-600 to-orange-500 text-xs text-white font-semibold rounded-br-xl">{{ $ol->kategori->nama }}</div>
                <a href="/berita/{{ $ol->slug }}">
                <img class="w-full h-full object-cover" src="{{ asset('storage/' . $ol->gambar_detail) }}" alt="{{ $ol->caption }}">
                </a>
            </div>
            <a href="/berita/{{ $ol->slug }}" class="text-xl font-bold leading-snug md:leading-snug dark:text-white hover:text-red-600 dark:hover:text-amber-300">{!! $ol->judul !!}</a>
            <p class="text-xxs 2xl:text-sm text-sky-900 dark:text-red-500 font-medium mt-1.5 mb-3">{{ Carbon\Carbon::parse($ol->tanggal_tayang . ' ' . $ol->waktu)->translatedFormat('l, d F Y | H:i') }} WIB</p>
            @else
            <div class="flex flex-row">
                <div class="flex shrink-0 w-14 h-14 rounded-md overflow-hidden">
                    <a href="/berita/{{ $ol->slug }}">
                    <img class="w-full h-full object-cover" src="{{ asset('storage/' . $ol->gambar_detail) }}" alt="">
                    </a>
                </div>
                <a href="/berita/{{ $ol->slug }}" class="ml-3 text-base font-bold leading-snug md:leading-snug dark:text-white hover:text-red-600 dark:hover:text-amber-300">{!! $ol->judul !!}</a>
            </div>
            @endif
            <div class="block w-full h-px bg-gray-300 dark:bg-gray-400 rounded-full my-2"></div>
        @endforeach
    </div>
    <!-- /Olahraga -->

    <!-- Dunia -->
    <div class="w-full mt-2">
        <div class="flex flex-row items-center justify-between">
            <div class="flex flex-row items-center">
                <div class="h-8 w-1.5 bg-gradient-to-tr from-rose-600 to-orange-500 rounded-full rotate-12"></div>
                <div class="text-lg lg:text-xl ml-2 italic text-slate-700 dark:text-gray-100 whitespace-nowrap"><span class="font-bold">DUNIA</span></div>
            </div>
            <div class="text-xs lg:text-sm"><a href="/indeks" class="font-semibold py-0.5 text-gray-500 hover:text-gray-700"><i class="fa-solid fa-arrow-right-long"></i></a></div>
        </div>

        @foreach($Dunia->slice(0, 3) as $dn)
            @if($loop->iteration == 1)
            <div class="relative h-52 md:h-40 lg:h-52 rounded-md overflow-hidden my-3">
                <div class="absolute top-0 z-10 px-5 py-1.5 bg-gradient-to-r from-rose-600 to-orange-500 text-xs text-white font-semibold rounded-br-xl">{{ $dn->kategori->nama }}</div>
                <a href="/berita/{{ $dn->slug }}">
                <img class="w-full h-full object-cover" src="{{ asset('storage/' . $dn->gambar_detail) }}" alt="{{ $dn->caption }}">
                </a>
            </div>
            <a href="/berita/{{ $dn->slug }}" class="text-xl font-bold leading-snug md:leading-snug dark:text-white hover:text-red-600 dark:hover:text-amber-300">{!! $dn->judul !!}</a>
            <p class="text-xxs 2xl:text-sm text-sky-900 dark:text-red-500 font-medium mt-1.5 mb-3">{{ Carbon\Carbon::parse($dn->tanggal_tayang . ' ' . $dn->waktu)->translatedFormat('l, d F Y | H:i') }} WIB</p>
            @else
            <div class="flex flex-row">
                <div class="flex shrink-0 w-14 h-14 rounded-md overflow-hidden">
                    <a href="/berita/{{ $dn->slug }}">
                    <img class="w-full h-full object-cover" src="{{ asset('storage/' . $dn->gambar_detail) }}" alt="">
                    </a>
                </div>
                <a href="/berita/{{ $dn->slug }}" class="ml-3 text-base font-bold leading-snug md:leading-snug dark:text-white hover:text-red-600 dark:hover:text-amber-300">{!! $dn->judul !!}</a>
            </div>
            @endif
            <div class="block w-full h-px bg-gray-300 dark:bg-gray-400 rounded-full my-2"></div>
        @endforeach
    </div>
    <!-- /Dunia -->

    <!-- Daerah -->
    <div class="w-full mt-2">
        <div class="flex flex-row items-center justify-between">
            <div class="flex flex-row items-center">
                <div class="h-8 w-1.5 bg-gradient-to-tr from-rose-600 to-orange-500 rounded-full rotate-12"></div>
                <div class="text-lg lg:text-xl ml-2 italic text-slate-700 dark:text-gray-100 whitespace-nowrap"><span class="font-bold">DAERAH</span></div>
            </div>
            <div class="text-xs lg:text-sm"><a href="/indeks" class="font-semibold py-0.5 text-gray-500 hover:text-gray-700"><i class="fa-solid fa-arrow-right-long"></i></a></div>
        </div>

        @foreach($Daerah->slice(0, 3) as $drh)
            @if($loop->iteration == 1)
            <div class="relative h-52 md:h-40 lg:h-52 rounded-md overflow-hidden my-3">
                <div class="absolute top-0 z-10 px-5 py-1.5 bg-gradient-to-r from-rose-600 to-orange-500 text-xs text-white font-semibold rounded-br-xl">{{ $drh->kategori->nama }}</div>
                <a href="/berita/{{ $drh->slug }}">
                <img class="w-full h-full object-cover" src="{{ asset('storage/' . $drh->gambar_detail) }}" alt="{{ $drh->caption }}">
                </a>
            </div>
            <a href="/berita/{{ $drh->slug }}" class="text-xl font-bold leading-snug md:leading-snug dark:text-white hover:text-red-600 dark:hover:text-amber-300">{!! $drh->judul !!}</a>
            <p class="text-xxs 2xl:text-sm text-sky-900 dark:text-red-500 font-medium mt-1.5 mb-3">{{ Carbon\Carbon::parse($drh->tanggal_tayang . ' ' . $drh->waktu)->translatedFormat('l, d F Y | H:i') }} WIB</p>
            @else
            <div class="flex flex-row">
                <div class="flex shrink-0 w-14 h-14 rounded-md overflow-hidden">
                    <a href="/berita/{{ $drh->slug }}">
                    <img class="w-full h-full object-cover" src="{{ asset('storage/' . $drh->gambar_detail) }}" alt="">
                    </a>
                </div>
                <a href="/berita/{{ $drh->slug }}" class="ml-3 text-base font-bold leading-snug md:leading-snug dark:text-white hover:text-red-600 dark:hover:text-amber-300">{!! $drh->judul !!}</a>
            </div>
            @endif
            <div class="block w-full h-px bg-gray-300 dark:bg-gray-400 rounded-full my-2"></div>
        @endforeach
    </div>
    <!-- /Daerah -->

    <!-- Keamanan -->
    <div class="w-full mt-2">
        <div class="flex flex-row items-center justify-between">
            <div class="flex flex-row items-center">
                <div class="h-8 w-1.5 bg-gradient-to-tr from-rose-600 to-orange-500 rounded-full rotate-12"></div>
                <div class="text-lg lg:text-xl ml-2 italic text-slate-700 dark:text-gray-100 whitespace-nowrap"><span class="font-bold">KEAMANAN</span></div>
            </div>
            <div class="text-xs lg:text-sm"><a href="/indeks" class="font-semibold py-0.5 text-gray-500 hover:text-gray-700"><i class="fa-solid fa-arrow-right-long"></i></a></div>
        </div>

        @foreach($Keamanan->slice(0, 3) as $kmn)
            @if($loop->iteration == 1)
            <div class="relative h-52 md:h-40 lg:h-52 rounded-md overflow-hidden my-3">
                <div class="absolute top-0 z-10 px-5 py-1.5 bg-gradient-to-r from-rose-600 to-orange-500 text-xs text-white font-semibold rounded-br-xl">{{ $kmn->kategori->nama }}</div>
                <a href="/berita/{{ $kmn->slug }}">
                <img class="w-full h-full object-cover" src="{{ asset('storage/' . $kmn->gambar_detail) }}" alt="{{ $kmn->caption }}">
                </a>
            </div>
            <a href="/berita/{{ $kmn->slug }}" class="text-xl font-bold leading-snug md:leading-snug dark:text-white hover:text-red-600 dark:hover:text-amber-300">{!! $kmn->judul !!}</a>
            <p class="text-xxs 2xl:text-sm text-sky-900 dark:text-red-500 font-medium mt-1.5 mb-3">{{ Carbon\Carbon::parse($kmn->tanggal_tayang . ' ' . $kmn->waktu)->translatedFormat('l, d F Y | H:i') }} WIB</p>
            @else
            <div class="flex flex-row">
                <div class="flex shrink-0 w-14 h-14 rounded-md overflow-hidden">
                    <a href="/berita/{{ $kmn->slug }}">
                    <img class="w-full h-full object-cover" src="{{ asset('storage/' . $kmn->gambar_detail) }}" alt="">
                    </a>
                </div>
                <a href="/berita/{{ $kmn->slug }}" class="ml-3 text-base font-bold leading-snug md:leading-snug dark:text-white hover:text-red-600 dark:hover:text-amber-300">{!! $kmn->judul !!}</a>
            </div>
            @endif
            <div class="block w-full h-px bg-gray-300 dark:bg-gray-400 rounded-full my-2"></div>
        @endforeach
    </div>
    <!-- /Keamanan -->

    <!-- Gaya Hidup -->
    <div class="w-full mt-2">
        <div class="flex flex-row items-center justify-between">
            <div class="flex flex-row items-center">
                <div class="h-8 w-1.5 bg-gradient-to-tr from-rose-600 to-orange-500 rounded-full rotate-12"></div>
                <div class="text-lg lg:text-xl ml-2 italic text-slate-700 dark:text-gray-100 whitespace-nowrap"><span class="font-bold">GAYA HIDUP</span></div>
            </div>
            <div class="text-xs lg:text-sm"><a href="/indeks" class="font-semibold py-0.5 text-gray-500 hover:text-gray-700"><i class="fa-solid fa-arrow-right-long"></i></a></div>
        </div>

        @foreach($GayaHidup->slice(0, 3) as $gh)
            @if($loop->iteration == 1)
            <div class="relative h-52 md:h-40 lg:h-52 rounded-md overflow-hidden my-3">
                <div class="absolute top-0 z-10 px-5 py-1.5 bg-gradient-to-r from-rose-600 to-orange-500 text-xs text-white font-semibold rounded-br-xl">{{ $gh->kategori->nama }}</div>
                <a href="/berita/{{ $gh->slug }}">
                <img class="w-full h-full object-cover" src="{{ asset('storage/' . $gh->gambar_detail) }}" alt="{{ $gh->caption }}">
                </a>
            </div>
            <a href="/berita/{{ $gh->slug }}" class="text-xl font-bold leading-snug md:leading-snug dark:text-white hover:text-red-600 dark:hover:text-amber-300">{!! $gh->judul !!}</a>
            <p class="text-xxs 2xl:text-sm text-sky-900 dark:text-red-500 font-medium mt-1.5 mb-3">{{ Carbon\Carbon::parse($gh->tanggal_tayang . ' ' . $gh->waktu)->translatedFormat('l, d F Y | H:i') }} WIB</p>
            @else
            <div class="flex flex-row">
                <div class="flex shrink-0 w-14 h-14 rounded-md overflow-hidden">
                    <a href="/berita/{{ $gh->slug }}">
                    <img class="w-full h-full object-cover" src="{{ asset('storage/' . $gh->gambar_detail) }}" alt="">
                    </a>
                </div>
                <a href="/berita/{{ $gh->slug }}" class="ml-3 text-base font-bold leading-snug md:leading-snug dark:text-white hover:text-red-600 dark:hover:text-amber-300">{!! $gh->judul !!}</a>
            </div>
            @endif
            <div class="block w-full h-px bg-gray-300 dark:bg-gray-400 rounded-full my-2"></div>
        @endforeach
    </div>
    <!-- /Gaya Hidup -->
    
</div>
<!-- /Berita Bawah -->