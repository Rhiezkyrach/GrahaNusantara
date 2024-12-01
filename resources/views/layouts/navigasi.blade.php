<body class="bg-slate-50 dark:bg-slate-800 selection:bg-teal-600 selection:text-white">
  <header class="w-full h-auto shadow-md lg:shadow-none transition">
    <!-- Mobile Nav -->
    <nav class="lg:hidden fixed z-20 top-0 bg-slate-50 dark:bg-slate-700 shadow-md w-full px-4 mx-auto py-2">
      <div class="relative flex flex-warp items-center justify-between">
        <div id="justify" class="z-20 w-full flex items-center justify-between">
          <a href="{{ url('/') }}">
            <img src="{{ asset('storage/'. $setting->logo ) }}" alt="{{ $setting->judul_situs }}" class="w-32">
          </a>

          <div class="flex flex-row gap-3 items-center">
            {{-- Dark Mode --}}
            <button id="theme-toggle-mobile" type="button" class="w-7 h-7 text-gray-700 dark:text-gray-700 bg-gray-300 hover:bg-gray-400 dark:hover:bg-gray-500 rounded-full p-[5px]">
              <div id="theme-toggle-dark-icon-mobile" class="hidden text-sm text-center"><i class="fa-solid fa-moon"></i></div>
              <div id="theme-toggle-light-icon-mobile" class="hidden text-sm text-center"><i class="fa-solid fa-sun"></i></div>
            </button>
            {{-- /Dark Mode --}}

            <!-- hamburger Menu -->
            <div class="flex">
              <button id="hamburger" class="relative w-8 h-8">
                <div class="hidden rotate-45"></div>
                <div class="hidden -rotate-45"></div>
                <div role="hidden" id="line" class="inset-0 w-6 h-0.5 m-auto rounded-full bg-gray-500 dark:bg-gray-300 transform transition duration-300">
                </div>
                <div role="hidden" id="line2" class="inset-0 w-5 h-0.5 mt-1.5 ml-2 m-auto rounded-full bg-gray-500 dark:bg-gray-300 transform transition duration-300">
                </div>
                <div role="hidden" id="line3" class="inset-0 w-6 h-0.5 mt-1.5 m-auto rounded-full bg-gray-500 dark:bg-gray-300 transform transition duration-300">
                </div>
              </button>
            </div>
            <!-- /Hamburger Menu -->
          </div>

        </div>
      </div>
    </nav>

    <div id="navlinks" class="fixed z-50 hidden h-screen w-full bg-gradient-to-t from-indigo-800 to-teal-800 transition">
      <ul class="px-4 mt-8 text-gray-600 text-lg tracking-wide mx-auto lg:flex lg:space-x-8 lg:py-0">

        <li class="relative w-full">
          <form action="/search" class="w-full" autocomplete="off">
            <input type="text" name="cari" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-1 focus:ring-sky-500"
              placeholder="Cari Berita..." value="{{ request('cari') }}" required>
            <div class="absolute top-0 right-0 w-auto h-full rounded-r-lg main_color">
              <button type="submit" class="py-1 px-4 text-white"><i class="mt-2 fas fa-search"></i></button>
            </div>
          </form>
        </li>

        <div class="mt-6 mb-2 text-xs font-semibold text-center"><span class="px-1.5 py-0.5 bg-teal-200 border border-teal-400 text-teal-600 rounded">KATEGORI BERITA</span></div>
        <div class="w-full grid grid-cols-2 gap-4">
          @if($navKategori)
            @foreach($navKategori as $nk)
            <li><a href="/kategori/{{ $nk->slug }}" class="block w-full pt-1 transition text-sm text-white border-b border-gray-100 pb-2"><i class="fa-regular fa-newspaper"></i> {{ $nk->nama }}</a></li>
            @endforeach
          @endif
            {{-- <li><a href="/indeks" class="block w-full pt-2 transition text-sm text-white"><i class="fa-solid fa-list-ul"></i> Indeks</a></li> --}}
        </div>

        <div class="mt-7 mb-2 text-xs font-semibold text-center"><span class="px-1.5 py-0.5 bg-teal-200 border border-teal-400 text-teal-600 rounded">LAINNYA</span></div>
        <div class="w-full grid grid-cols-2 gap-4">
            <li><a href="/statis/redaksi" class="block w-full pt-1 transition text-sm text-white border-b border-gray-100 pb-2"><i class="fa-solid fa-users"></i> Redaksi</a></li>
            <li><a href="/statis/tentang-kami" class="block w-full pt-1 transition text-sm text-white border-b border-gray-100 pb-2"><i class="fa-solid fa-laptop"></i> Tentang Kami</a></li>
            <li><a href="/statis/kontak-kami" class="block w-full pt-1 transition text-sm text-white border-b border-gray-100 pb-2"><i class="fa-regular fa-envelope"></i> Kontak</a></li>
            <li><a href="/indeks" class="block w-full pt-2 transition text-sm text-white border-b border-gray-100 pb-2"><i class="fa-solid fa-list-ul"></i> Indeks Berita</a></li>
        </div>

        <div class="w-full mt-24">
          <div class="text-gray-400 font-semibold">{{ $setting->judul_situs }}</div>
          <div class="text-xxs text-gray-400 font-light">{{ $setting->tagline }}</div>
        </div>

      </ul>
    </div>

    <!-- /Mobile Nav -->

    <!-- PC Nav -->
    <nav class="hidden lg:block bg-slate-200 shadow-sm">
      {{-- <div class="w-full h-auto bg-black shadow-sm">
        <div class="mx-auto lg:w-[1080px] px-4 xl:px-0 flex flex-row items-center justify-between">

          <div class="flex flex-row gap-2 items-center">
            <div class="py-1 bg-gradient-to-r from-sky-500 to-blue-600 px-4 h-full text-sm text-white italic whitespace-nowrap">
              <span class="font-bold">BREAKING</span> <i class="fa-solid fa-bolt text-amber-300"></i> <span>NEWS</span>
            </div>

            <div class="swiper breakingSwiper w-[600px] overflow-hidden">
              <div class="swiper-wrapper">
                @foreach($headline as $hl)
                <div class="swiper-slide">
                  <a href="/berita/{{ $hl->slug }}" class="ml-2 text-xs text-white hover:text-amber-400">{!! $hl->judul
                    !!}</a>
                </div>
                @endforeach
              </div>
            </div>

          </div>

          <div class="flex flex-row gap-2 items-center whitespace-nowrap">

            <div class="flex flex-row items-center justify-center">
              <div class="text-xl text-gray-100 hover:text-yellow-300"><a href="{{ $setting->facebook }}"><i
                    class="fab fa-facebook-square"></i></a></div>
              <div class="text-xl text-gray-100 hover:text-yellow-300 ml-2"><a href="{{ $setting->instagram }}"><i
                    class="fab fa-instagram-square"></i></a></div>
              <div class="text-xl text-gray-100 hover:text-yellow-300 ml-2"><a href="{{ $setting->twitter }}"><i
                    class="fab fa-twitter-square"></i></a></div>
              <div class="text-xl text-gray-100 hover:text-yellow-300 ml-2"><a href="{{ $setting->youtube }}"><i
                    class="fab fa-youtube-square"></i></a></div>
            </div>

            <div class="w-px h-5 ml-1 bg-gray-300"></div>

            <div class="text-xs text-gray-100 font-medium">{{ Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </div>
          </div>

        </div>
      </div> --}}

      <div class="mx-auto lg:w-[1080px] px-4 xl:px-0 flex flex-row items-center justify-between">
        {{-- Logo --}}
        <div class="w-auto my-3">
          <a href="{{ url('/') }}"><img class="w-60" src="{{ asset('storage/'. $setting->logo ) }}"
              alt="{{ $setting->judul_situs }}"></a>
        </div>
        {{-- /Logo --}}

        <div class="w-auto flex flex-row gap-3 items-start">
          {{-- Form Cari --}}
          <form class="w-auto" action="/search" class="w-full" autocomplete="off">
            <div class="flex flex-row main_color p-0.5 rounded-lg items-center justify-between">

              <div class="relative block w-64">
                <input type="text" name="cari" class="w-full px-3 py-1 rounded-md border border-gray-200 focus:outline-none focus:ring-1 focus:amber-sky-300 placeholder:text-xs"
                  placeholder="Cari Berita..." value="{{ request('cari') }}" required>
              </div>

              <button type="submit" class="text-sm text-white ml-3 mr-3 font-semibold hover:text-yellow-300"><i class="fa-solid fa-magnifying-glass"></i></button>

            </div>
          </form>
          {{-- /Form Cari --}}

          {{-- Dark Mode --}}
          <button id="theme-toggle" type="button" class="w-[38px] h-[38px] text-teal-700 dark:text-teal-700 bg-gray-300 hover:bg-gray-400 dark:hover:bg-gray-500 rounded-md p-2">
            <div id="theme-toggle-dark-icon" class="hidden text-base text-center"><i class="fa-regular fa-moon"></i></div>
            <div id="theme-toggle-light-icon" class="hidden text-base text-center"><i class="fa-regular fa-sun"></i></div>
          </button>
          {{-- /Dark Mode --}}
        </div>
      </div>

      {{-- Navigasi --}}
      <div class="w-full px-2 bg-amber-400">
        <div class="relative mx-auto lg:w-[1080px] ">

          {{-- Social --}}
          {{-- <div class="absolute right-0 -top-6 flex flex-row gap-0.5">
            <a href="#" class="w-6 h-6 bg-teal-400 rounded-tl-md text-white text-center hover:-mt-1 hover:h-7 duration-200"><i class="mt-1 fa-brands fa-facebook-f"></i> </a>
            <a href="#" class="w-6 h-6 bg-teal-400 text-white text-center hover:-mt-1 hover:h-7 duration-200"><i class="mt-1 fa-brands fa-instagram"></i> </a>
            <a href="#" class="w-6 h-6 bg-teal-400 text-white text-center hover:-mt-1 hover:h-7 duration-200"><i class="mt-1 fa-brands fa-twitter"></i> </a>
            <a href="#" class="w-6 h-6 bg-teal-400 rounded-tr-md text-white text-center hover:-mt-1 hover:h-7 duration-200"><i class="mt-1 fa-brands fa-tiktok"></i> </a>
          </div> --}}

          <ul class="w-full px-4 lg:px-0 mx-auto flex flex-row grow-0 gap-2 lg:gap-1 items-center justify-between overflow-hidden">
            {{-- <li class="lg:text-xs xl:text-sm text-slate-900 uppercase font-bold whitespace-nowrap">
              <a href="{{ url('/') }}"><i class="fas fa-home"></i> Home</a>
            </li>
            <div class="h-6 w-px bg-gray-100/50"></div> --}}

            @if($navKategori)
            @foreach($navKategori as $nk)
            <li class="py-3 px-2 text-slate-900 font-bold tracking-wide whitespace-nowrap">
              <a href="/kategori/{{ $nk->slug }}">{{ $nk->nama }}</a>
            </li>
            @endforeach
            @endif

            @if($extraNavKategori->count())
            <li class="group py-3 px-2 text-slate-900 font-bold tracking-wide whitespace-nowrap">Lainnya <i class="fa-solid fa-angle-down"></i>
              <div class="group-hover:block dropdown-menu absolute hidden h-auto">
                <ul class="relative z-50 top-0 mt-2 w-auto divide-y divide-gray-100/50 bg-gradient-to-r from-blue-600 to-blue-500 shadow px-6 py-4 rounded-md">
                  @foreach($extraNavKategori as $enk)
                  <li class="py-1.5 block text-white font-bold lg:text-xs xl whitespace-nowrap">
                    <a href="/kategori/{{ $enk->slug }}">{{ $enk->nama }}</a>
                  </li>
                  @endforeach
                </ul>
              </div>
            </li>
            @endif

            <li class="py-3 px-2 text-slate-900 font-bold tracking-wide whitespace-nowrap">
              <a href="/indeks">Indeks</a>
            </li>

          </ul>
        </div>
      </div>
      {{-- /Navigasi --}}

      {{-- Breaking --}}
      {{-- <div class="mx-auto lg:w-[1080px] h-auto bg-gray-700 dark:bg-gray-900 rounded-b-lg overflow-hidden">

        <div class="flex flex-row gap-2">
          <div class="py-1.5 bg-gradient-to-r from-teal-400 to-indigo-600 px-4 h-full text-sm text-white italic whitespace-nowrap">
            <span class="font-bold">BREAKING</span> <i class="fa-solid fa-bolt text-amber-300"></i> <span>NEWS</span>
          </div>

          <section id="splide_breaking" class="splide w-[900px] h-8 overflow-hidden" aria-labelledby="Breaking News">
            <div class="splide__track">
              <div class="splide__list">
                @foreach($headline as $hl)
                <div class="splide__slide my-auto">
                  <a href="/berita/{{ $hl->slug }}" class="text-xs text-white hover:text-amber-400">{!! $hl->judul !!} <span class="-mt-1 ml-1 bg-blue-100 text-slate-900 text-xxxs px-1 py-px rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">{{ Carbon\Carbon::parse($hl->created_at)->diffForHumans() }}</span> </a>
                </div>
                @endforeach
              </div>
            </div>
          </section>

        </div>
      </div> --}}
      {{-- /Breaking --}}

      {{-- Navigasi Scroll --}}
      <div class="navigasi w-full h-auto hidden fixed z-50 top-0 shadow-md">

        <div class="w-full bg-white dark:bg-slate-800 py-1.5">
          <div class="mx-auto lg:w-[1080px] px-4 xl:px-0 flex flex-row items-center justify-between">

            <div class="py-1 w-auto">
              <a href="{{ url('/') }}"><img class="w-44" src="{{ asset('storage/'. $setting->logo ) }}"
                  alt="{{ $setting->judul_situs }}"></a>
            </div>

            <form class="w-auto" action="/berita" class="w-full" autocomplete="off">
              <div class="mt-4 flex flex-row main_color p-0.5 rounded-lg items-center justify-between">

                <div class="relative block w-64">
                  <input type="text" name="cari" class="w-full px-3 py-1 rounded-md border border-gray-200 focus:outline-none focus:ring-1 focus:amber-sky-300 placeholder:text-xs"
                    placeholder="Cari Berita..." value="{{ request('cari') }}" required>
                </div>

                <button type="submit" class="text-xs text-white ml-3 mr-3 font-semibold hover:text-yellow-300"><i class="fa-solid fa-magnifying-glass"></i></button>

              </div>
            </form>

          </div>
        </div>

        <div class="w-full bg-teal-100 border-y-2 border-teal-400">
          <ul class="mx-auto lg:w-[1080px] flex flex-row grow-0 gap-2 lg:gap-1 items-center justify-between">
            {{-- <li class="pt-2.5 pb-1 px-2 text-sm text-slate-900 border-b-4 hover:border-b-teal-700 font-bold uppercase whitespace-nowrap"><a
              href="{{ url('/') }}"><i class="fas fa-home"></i> Home</a>
            </li> --}}
            <div class="h-6 w-px bg-gray-100/50"></div>
            @if($navKategori)
            @foreach($navKategori as $nk)
            <li class="pt-2.5 pb-1 px-2 text-sm text-slate-900 border-b-4 hover:border-b-teal-700 font-bold uppercase tracking-wide whitespace-nowrap">
              <a href="/kategori/{{ $nk->slug }}">{{ $nk->nama }}</a>
            </li>
            @endforeach
            @endif

            @if($extraNavKategori->count())
            <li class="group relative pt-2.5 pb-1 px-2 text-sm text-slate-900 border-b-4 hover:border-b-teal-700 font-bold uppercase tracking-wide whitespace-nowrap">Lainnya <i class="fa-solid fa-angle-down"></i>
              <div class="group-hover:block dropdown-menu absolute hidden h-auto">
                <ul class="relative z-10 top-0 mt-5 w-auto divide-y divide-gray-100/50 bg-gradient-to-r from-blue-600 to-blue-500 shadow px-6 py-4 rounded-md">
                  @foreach($extraNavKategori as $enk)
                  <li class="py-1.5 block text-white hover:text-yellow-300 font-bold uppercase pt-2.5 pb-1 px-2 text-sm whitespace-nowrap">
                    <a href="/kategori/{{ $enk->slug }}">{{ $enk->nama }}</a>
                  </li>
                  @endforeach
                </ul>
              </div>
            </li>
            @endif

            <li class="pt-2.5 pb-1 px-2 text-sm text-slate-900 border-b-4 hover:border-b-teal-700 font-bold uppercase tracking-wide whitespace-nowrap">
              <a href="/indeks">Indeks</a>
            </li>
          </ul>
        </div>
      </div>
      {{-- /Navigasi Scroll --}}

    </nav>
    <!-- /PC Nav -->
  </header>

  <!-- Ekplorasi -->
  <div id="eksplor" class="lg:hidden flex flex-row w-full bg-gradient-to-r from-teal-100 to-indigo-100 overflow-x-auto mt-14 mx-auto px-4 py-2 no-scrollbar">
    {{-- <div class="px-3 py-1 bg-red-600 rounded-md text-xs font-semibold text-white whitespace-nowrap"><i
        class="far fa-compass"></i> Eksplorasi</div> --}}
    {{-- <div class="flex-shrink-0 w-px ml-3 h-auto bg-gray-300"></div> --}}
    <div class="flex flex-row gap-4">
      @if($navKategori)
      @foreach($navKategori as $nk)
      <a href="/kategori/{{ $nk->slug }}">
        <p class="text-sm text-teal-600 font-semibold whitespace-nowrap">{{ $nk->nama }}</p>
      </a>
      @endforeach
      @endif

      @if($extraNavKategori)
      @foreach($extraNavKategori as $enkm)
      <a href="/kategori/{{ $enkm->slug }}">
        <p class="text-sm text-teal-600 font-semibold whitespace-nowrap">{{ $enkm->nama }}</p>
      </a>
      @endforeach
      @endif

      <a href="/indeks">
        <p class="text-sm text-teal-600 font-semibold whitespace-nowrap">Indeks</p>
      </a>
    </div>
  </div>
  <!-- /Ekplorasi -->

  {{-- Iklan Header Mobile--}}
  @if($iklanHeader) {{-- if iklan --}}
  <div class="block lg:hidden w-full h-auto px-4 mt-4 overflow-hidden">
    @if($iklanHeader->jenis == "Banner")
    <a href="{{ $iklanHeader->link }}"><img class="h-full object-cover"
        src="{{ asset('storage/'. $iklanHeader->foto) }}" alt="{{ $iklanHeader->nama }}"></a>
    @else
    {!! $iklanHeader->kode !!}
    @endif
  </div>
  @endif
  {{-- /Iklan Header Mobile--}}

  {{-- Dewan Pers --}}
  {{-- <div class="flex w-14 h-14 md:w-16 md:h-16 fixed z-50 bottom-10 right-10">
    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-500 opacity-75"></span>
    <a href="{{ url('/') }}/statis/1/redaksi">
      <span class="relative inline-flex w-14 h-14 md:w-16 md:h-16 bg-white shadow-sm rounded-full overflow-hidden">
        <img src="{{ asset('images/dewan_pers.jpg') }}" class="w-8 h-8 md:w-10 md:h-10 mx-auto my-auto object-cover"
          alt="Dewan Pers SinPo">
    </a>
    </span>
  </div> --}}
  {{-- /Dewan Pers --}}

@push('js')
<script>
$( document ).ready(function() {
  $(document).scroll(function() {
    let y = $(this).scrollTop();
    
    if (y > 260) {
      $('.navigasi').slideDown();
    } else {
      $('.navigasi').slideUp();
    }
  });

  // Breaking News
  let splide_breaking = new Splide( '#splide_breaking', {
    type   : 'loop',
    autoplay: true,
    interval: 2500,
    arrows: false,
    pagination: false,
  }).mount();

  // Toggle Hamburger
  $('#hamburger').on('click', function(){
    if($('#navlinks').hasClass("hidden")){
      $('#navlinks').removeClass("hidden");
      // $('#justify').addClass("justify-between");
      $('#line2').addClass("hidden");
      $('#line').addClass("rotate-45 absolute");
      $('#line3').removeClass("mt-1.5");
      $('#line3').addClass("-rotate-45 absolute");
    }else{
      $('#navlinks').addClass("hidden");
      $('#line2').removeClass("hidden");
      $('#line').removeClass("rotate-45 absolute");
      $('#line3').removeClass("-rotate-45 absolute");
      $('#line3').addClass("mt-1.5");
      // console.log($('#navlinks').hasClass("hidden"))
    }
  });
});
</script>
@endpush