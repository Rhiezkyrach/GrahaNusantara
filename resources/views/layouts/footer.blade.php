{{-- Iklan Footer --}}
@if($iklanFooter) {{-- if iklan --}}
@foreach($iklanFooter as $iFooter)
<div class="flex mx-auto lg:w-[1080px] h-auto my-4 overflow-hidden">
    <div class="w-full">
    @if($iFooter->jenis == "Banner")
    <a href="{{ $iFooter->link }}"><img class="w-full h-full object-contain" src="{{ asset('storage/'. $iFooter->foto) }}" alt="{{ $iFooter->nama }}"></a>
    @else
    {!! $iFooter->kode !!}
    @endif
    </div>
</div>
@endforeach
@endif
{{-- /Iklan Footer --}}

<footer class="mt-8">
    <div class="flex flex-col w-full h-auto bg-gray-800 dark:bg-gray-900 items-center">
      <div class="flex py-6 mt-4">
        <a href="{{ url('/') }}">
          <img class="w-64" src="{{ asset('storage/' . $setting->darklogo) }}" alt="{{ $setting->judul_situs }}">
        </a>
      </div>


      <div class="font-bold lg:text-lg text-amber-300">RAJAMEDIA NETWORK</div>
      <div class="px-6 lg:w-[1080px] lg:px-0 flex flex-row mt-2 gap-y-2 gap-x-3 md:gap-x-4 divide-x divide-gray-400 items-center flex-wrap justify-center">
        @foreach($Network as $net)
        <div class="pl-3 block text-sm font-semibold text-gray-200 hover:text-white text-center"><a href="{{ $net->url }}">{{ $net->nama }}</a></div>
        @endforeach
      </div>
      <div class="w-full lg:w-[1080px] px-10 mt-2 lg:px-0">
        <div class="h-px bg-gray-400"></div>
      </div>

      <div class="font-bold mt-5 lg:text-lg text-amber-300">FOLLOW US</div>
      <div class="flex flex-row mt-2 items-center justify-center">
        <div class="text-3xl text-gray-200 hover:text-white"><a href="{{ $setting->facebook }}"><i class="fab fa-facebook-square"></i></a></div>
        <div class="text-3xl text-gray-200 hover:text-white ml-3"><a href="{{ $setting->instagram }}"><i class="fab fa-instagram-square"></i></a></div>
        <div class="text-3xl text-gray-200 hover:text-white ml-3"><a href="{{ $setting->twitter }}"><i class="fab fa-twitter-square"></i></a></div>
        <div class="text-3xl text-gray-200 hover:text-white ml-3"><a href="{{ $setting->youtube }}"><i class="fab fa-youtube-square"></i></a></div>
      </div>
      <div class="px-10 mt-5 text-xxs 2xl:text-xs text-white text-center">{{ $setting->alamat }}</div>
      <div class="px-10 flex flex-row mt-5 gap-x-3 md:gap-x-4 items-center flex-wrap justify-center">
        @foreach($halstatis as $hst)
        <div class="block text-sm font-semibold text-amber-300 hover:text-white text-center"><a href="/statis/{{ $hst->slug }}">{{ $hst->judul }}</a></div>
        @endforeach
      </div>
      <div class="w-full h-auto bg-gradient-to-r from-rose-600 to-orange-500 mt-5">
        <div class="text-xs lg:text-sm text-white text-center py-3">{!! $setting->copyright !!}</div>
      </div>
    </div>
</footer>

<script src="{{ asset('js/script.js?v=')  . filemtime('js/script.js') }}"></script>
<script src="{{ asset('plugin/swiper/swiper-bundle.min.js') }}"></script>

<!-- Initialize Headline Swiper -->
<script>
var swiper = new Swiper(".breakingSwiper", {
    spaceBetween: 10,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
    },
});
</script>

<!-- Initialize Headline Swiper -->
<script>
var swiper = new Swiper(".mySwiper", {
    spaceBetween: 10,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
    },
    pagination: {
    el: ".swiper-pagination",
    dynamicBullets: true,
    clickable: true,
    
    },
});
</script>

<!-- Initialize Swiper -->
<script>
  var swiper = new Swiper(".galeriSwiper", {
    autoplay: {
        delay: 3000,
        disableOnInteraction: true,
        pauseOnMouseEnter: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });
</script>

<script src="{{ asset('/sw.js') }}"></script>
<script>
    if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("/sw.js").then(function (reg) {
            console.log("Service worker has been registered for scope: " + reg.scope);
        });
    }
</script>