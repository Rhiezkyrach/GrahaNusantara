<body class="dark:bg-slate-800 selection:bg-red-600 selection:text-white">
  <header class="w-full h-auto shadow-md lg:shadow-none transition">
    <!-- Mobile Nav -->
    <nav class="lg:hidden fixed z-20 top-0 bg-white dark:bg-slate-700 shadow-md w-full px-4 mx-auto py-2">
      <div class="relative flex flex-warp items-center justify-between">
        <div id="justify" class="z-20 w-full flex items-center justify-between">
          <a href="{{ url('/') }}">
            <img src="{{ asset('storage/'. $setting->logo ) }}" alt="{{ $setting->judul_situs }}" class="w-40">
          </a>

          <div class="flex flex-row gap-3 items-center">
            {{-- Dark Mode --}}
            <button id="theme-toggle-mobile" type="button"
              class="w-7 h-7 text-gray-700 dark:text-gray-700 bg-gray-300 hover:bg-gray-400 dark:hover:bg-gray-500 rounded-full p-[5px]">
              <div id="theme-toggle-dark-icon-mobile" class="hidden text-sm text-center"><i
                  class="fa-solid fa-moon"></i></div>
              <div id="theme-toggle-light-icon-mobile" class="hidden text-sm text-center"><i
                  class="fa-solid fa-sun"></i></div>
            </button>
            {{-- /Dark Mode --}}

            <!-- hamburger Menu -->
            <div class="flex">
              <button id="hamburger" class="relative w-8 h-8">
                <div class="hidden rotate-45"></div>
                <div class="hidden -rotate-45"></div>
                <div role="hidden" id="line"
                  class="inset-0 w-6 h-0.5 m-auto rounded-full bg-gray-500 dark:bg-gray-300 transform transition duration-300">
                </div>
                <div role="hidden" id="line2"
                  class="inset-0 w-5 h-0.5 mt-1.5 ml-2 m-auto rounded-full bg-gray-500 dark:bg-gray-300 transform transition duration-300">
                </div>
                <div role="hidden" id="line3"
                  class="inset-0 w-6 h-0.5 mt-1.5 m-auto rounded-full bg-gray-500 dark:bg-gray-300 transform transition duration-300">
                </div>
              </button>
            </div>
            <!-- /Hamburger Menu -->
          </div>

        </div>
      </div>
    </nav>

    <div id="navlinks" class="fixed z-50 hidden h-screen w-full bg-slate-800 transition">
      <ul class="px-4 mt-8 text-gray-600 text-lg tracking-wide mx-auto lg:flex lg:space-x-8 lg:py-0">

        <li class="relative w-full">
          <form action="/search" class="w-full" autocomplete="off">
            <input type="text" name="cari"
              class="w-full px-3 py-1.5 rounded-lg border border-gray-200 focus:outline-none focus:ring-1 focus:ring-sky-500"
              placeholder="Cari Berita..." value="{{ request('cari') }}" required>
            <div class="absolute top-0 right-0 w-auto h-full rounded-r-lg bg-gradient-to-r from-rose-600 to-orange-500">
              <button type="submit" class="py-1 px-4 text-white"><i class="fas fa-search"></i></button>
            </div>
          </form>
        </li>

        <div class="w-full flex flex-col gap-2 divide-y divide-gray-300 mt-6">
          @if($navKategori)
          @foreach($navKategori as $nk)
          <li><a href="/kategori/{{ $nk->slug }}" class="block w-full pt-2 transition text-white"><i
                class="fa-solid fa-circle-chevron-right"></i> {{ $nk->nama }}</a></li>
          @endforeach
          @endif
          <li><a href="/indeks" class="block w-full pt-2 transition text-white"><i class="fa-solid fa-list-ul"></i>
              Indeks</a></li>
        </div>

        <div class="w-full mt-24">
          <div class="text-sm text-gray-400 font-semibold">{{ $setting->judul_situs }}</div>
          <div class="text-xxs text-gray-400 font-light">{{ $setting->tagline }}</div>
        </div>

      </ul>
    </div>

    <!-- /Mobile Nav -->

    <!-- PC Nav -->
    <nav class="hidden lg:block">
      <div class="w-full h-auto bg-black shadow-sm">
        <div class="mx-auto lg:w-[1080px] px-4 xl:px-0 flex flex-row items-center justify-between">

          <div class="flex flex-row gap-2 items-center">
            <div
              class="py-1 bg-gradient-to-r from-sky-500 to-blue-600 px-4 h-full text-sm text-white italic whitespace-nowrap">
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
      </div>

      <div class="mx-auto lg:w-[1080px] px-4 xl:px-0 mt-6 flex flex-row items-center justify-between">
        {{-- Logo --}}
        <div class="w-auto my-3">
          <a href="{{ url('/') }}"><img class="w-80" src="{{ asset('storage/'. $setting->logo ) }}"
              alt="{{ $setting->judul_situs }}"></a>
        </div>
        {{-- /Logo --}}

        <div class="w-auto flex flex-row gap-3 items-center">
          {{-- Form Cari --}}
          <form class="w-auto" action="/search" class="w-full" autocomplete="off">
            <div
              class="flex flex-row bg-gradient-to-r from-rose-600 to-orange-500 p-0.5 rounded-full items-center justify-between">

              <div class="relative block w-64">
                <input type="text" name="cari"
                  class="w-full px-3 py-1 rounded-full border border-gray-200 focus:outline-none focus:ring-1 focus:amber-sky-300 placeholder:text-xs"
                  placeholder="Cari Berita..." value="{{ request('cari') }}" required>
              </div>

              <button type="submit"
                class="text-sm text-white ml-2 mr-4 font-semibold hover:text-yellow-300">Cari</button>

            </div>
          </form>
          {{-- /Form Cari --}}

          {{-- Dark Mode --}}
          <button id="theme-toggle" type="button"
            class="w-10 h-10 text-gray-700 dark:text-gray-700 bg-gray-300 hover:bg-gray-400 dark:hover:bg-gray-500 rounded-full p-2">
            <div id="theme-toggle-dark-icon" class="hidden text-base text-center"><i class="fa-solid fa-moon"></i></div>
            <div id="theme-toggle-light-icon" class="hidden text-base text-center"><i class="fa-solid fa-sun"></i></div>
          </button>
          {{-- /Dark Mode --}}
        </div>


      </div>

      {{-- Navigasi --}}
      <div class="mx-auto w-full mt-5 overflow-hidden py-2.5 px-6 bg-gradient-to-r from-rose-600 to-orange-500">
        <ul class="lg:w-[1080px] px-4 lg:px-0 mx-auto flex flex-row grow-0 gap-2 lg:gap-1 items-center justify-between">
          <li class="lg:text-xs xl:text-sm text-white hover:text-yellow-300 uppercase font-bold whitespace-nowrap"><a
              href="{{ url('/') }}"><i class="fas fa-home"></i> Home</a></li>
          <div class="h-6 w-px bg-gray-100/50"></div>

          @if($navKategori)
          @foreach($navKategori as $nk)
          <li
            class="lg:text-xs xl:text-sm text-white hover:text-yellow-300 font-bold uppercase tracking-wide whitespace-nowrap">
            <a href="/kategori/{{ $nk->slug }}">{{ $nk->nama }}</a>
          </li>
          @endforeach
          @endif

          @if($extraNavKategori->count())
          <li
            class="group lg:text-xs xl:text-sm text-white hover:text-yellow-300 font-bold uppercase tracking-wide whitespace-nowrap">
            Lainnya <i class="fa-solid fa-angle-down"></i>
            <div class="group-hover:block dropdown-menu absolute hidden h-auto">
              <ul
                class="relative z-50 top-0 mt-5 w-auto divide-y divide-gray-100/50 bg-gradient-to-r from-rose-600 to-orange-500 shadow px-6 py-4 rounded-md">
                @foreach($extraNavKategori as $enk)
                <li
                  class="py-1.5 block text-white hover:text-yellow-300 font-bold lg:text-xs uppercase xl:text-sm whitespace-nowrap">
                  <a href="/kategori/{{ $enk->slug }}">{{ $enk->nama }}</a>
                </li>
                @endforeach
              </ul>
            </div>
          </li>
          @endif

          <li
            class="lg:text-xs xl:text-sm text-white hover:text-yellow-300 font-bold uppercase tracking-wide whitespace-nowrap">
            <a href="/indeks">Indeks</a>
          </li>

        </ul>
      </div>
      {{-- /Navigasi --}}

      {{-- Regional --}}
      <div class="mx-auto lg:w-[1080px] h-auto py-2 px-5 bg-gray-200 dark:bg-gray-300 rounded-b-lg overflow-hidden">
        <ul class="flex flex-row gap-4 items-center justify-between">
          @foreach($Network->slice(0, 10) as $net)
          <li class="text-sm font-semibold text-gray-800 hover:text-red-600"><a href="{{ $net->url }}">{{ $net->nama
              }}</a></li>
          @endforeach

          <li
            class="group text-sm font-semibold text-white hover:text-amber-300 bg-gradient-to-r from-cyan-500 to-blue-600 px-3 py-1 rounded-full">
            Regional Lainnya <i class="fa-solid fa-angle-down"></i>
            <div class="group-hover:block dropdown-menu absolute hidden h-auto">
              <ul
                class="relative z-50 top-0 mt-5 w-auto divide-y divide-gray-100/50 bg-gradient-to-r from-cyan-500 to-blue-600 shadow px-6 py-4 rounded-md">
                @foreach($Network->skip(10) as $net)
                <li class="py-1.5 block text-sm font-semibold text-white hover:text-amber-300"><a
                    href="{{ $net->url }}">{{ $net->nama }}</a></li>
                @endforeach
              </ul>
            </div>
          </li>

        </ul>
      </div>
      {{-- /Regional --}}

      {{-- Navigasi Scroll --}}
      <div class="navigasi w-full h-auto hidden fixed z-50 top-0 shadow-md">

        <div class="w-full bg-white dark:bg-slate-800 py-1.5">
          <div class="mx-auto lg:w-[1080px] px-4 xl:px-0 flex flex-row items-center justify-between">

            <div class="w-auto">
              <a href="{{ url('/') }}"><img class="w-56" src="{{ asset('storage/'. $setting->logo ) }}"
                  alt="{{ $setting->judul_situs }}"></a>
            </div>

            <form class="w-auto" action="/berita" class="w-full" autocomplete="off">
              <div
                class="flex flex-row bg-gradient-to-r from-rose-600 to-orange-500 p-0.5 rounded-full items-center justify-between">

                <div class="relative block w-64">
                  <input type="text" name="cari"
                    class="w-full px-2 py-0.5 rounded-full border border-gray-200 focus:outline-none focus:ring-1 focus:amber-sky-300 placeholder:text-xs"
                    placeholder="Cari Berita..." value="{{ request('cari') }}" required>
                </div>

                <button type="submit"
                  class="text-xs text-white ml-2 mr-4 font-semibold hover:text-yellow-300">Cari</button>

              </div>
            </form>

          </div>
        </div>

        <div class="w-full bg-gradient-to-tr from-rose-600 to-orange-500">
          <ul
            class="mx-auto lg:w-[1080px] px-4 xl:px-0 flex flex-row grow-0 gap-2 lg:gap-1 py-1.5 items-center justify-between">
            <li class="lg:text-xs xl:text-sm text-white hover:text-amber-300 font-bold uppercase whitespace-nowrap"><a
                href="{{ url('/') }}"><i class="fas fa-home"></i> Home</a></li>
            <div class="h-6 w-px bg-gray-100/50"></div>
            @if($navKategori)
            @foreach($navKategori as $nk)
            <li
              class="lg:text-xs xl:text-sm text-white hover:text-yellow-300 font-bold uppercase tracking-wide whitespace-nowrap">
              <a href="/kategori/{{ $nk->slug }}">{{ $nk->nama }}</a>
            </li>
            @endforeach
            @endif

            @if($extraNavKategori->count())
            <li
              class="group relative lg:text-xs xl:text-sm text-white hover:text-amber-300 font-bold uppercase tracking-wide">
              Lainnya <i class="fa-solid fa-angle-down"></i>
              <div class="group-hover:block dropdown-menu absolute hidden h-auto">
                <ul
                  class="relative z-10 top-0 mt-5 w-auto divide-y divide-gray-100/50 bg-gradient-to-r from-rose-600 to-orange-500 shadow px-6 py-4 rounded-md">
                  @foreach($extraNavKategori as $enk)
                  <li
                    class="py-1.5 block text-white hover:text-yellow-300 font-bold uppercase lg:text-xs xl:text-sm whitespace-nowrap">
                    <a href="/kategori/{{ $enk->slug }}">{{ $enk->nama }}</a>
                  </li>
                  @endforeach
                </ul>
              </div>
            </li>
            @endif

            <li
              class="lg:text-xs xl:text-sm text-white hover:text-yellow-300 font-bold uppercase tracking-wide whitespace-nowrap">
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
  <div id="eksplor"
    class="lg:hidden flex flex-row w-full bg-gradient-to-r from-rose-600 to-orange-500 overflow-x-auto mt-12 mx-auto px-4 py-2 no-scrollbar">
    {{-- <div class="px-3 py-1 bg-red-600 rounded-md text-xs font-semibold text-white whitespace-nowrap"><i
        class="far fa-compass"></i> Eksplorasi</div> --}}
    {{-- <div class="flex-shrink-0 w-px ml-3 h-auto bg-gray-300"></div> --}}
    <div class="flex flex-row gap-4">
      @if($navKategori)
      @foreach($navKategori as $nk)
      <a href="/kategori/{{ $nk->slug }}">
        <p class="text-sm text-white font-semibold whitespace-nowrap">{{ $nk->nama }}</p>
      </a>
      @endforeach
      @endif

      @if($extraNavKategori)
      @foreach($extraNavKategori as $enkm)
      <a href="/kategori/{{ $enkm->slug }}">
        <p class="text-sm text-white font-semibold whitespace-nowrap">{{ $enkm->nama }}</p>
      </a>
      @endforeach
      @endif

      <a href="/indeks">
        <p class="text-sm text-white font-semibold whitespace-nowrap">Indeks</p>
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

  <script>
    $(document).scroll(function() {
  var y = $(this).scrollTop();
  if (y > 260) {
    $('.navigasi').slideDown();
  } else {
    $('.navigasi').slideUp();
  }
  });
  </script>