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
    <div class="flex px-4 lg:px-0 flex-col w-full h-auto bg-gray-800 dark:bg-gray-900 items-center">

      <div class="w-full lg:w-[1080px] flex flex-col md:flex-row items-center justify-between">

        {{-- LOGO --}}
        <div class="w-full flex flex-col py-6 mt-4">
          <a href="{{ url('/') }}">
            <img class="w-64 mx-auto md:mx-0" src="{{ asset('storage/' . $setting->darklogo) }}" alt="{{ $setting->judul_situs }}">
          </a>
          <div class="mt-4 text-xs text-center md:text-left text-white">{{ $setting->alamat }}</div>
        </div>
  
        {{-- Social Media --}}
        <div class="">

          <div class="font-bold mt-5 lg:text-lg text-teal-300 text-center md:text-left">FOLLOW US</div>
          <div class="flex flex-row mt-2 items-center justify-center">
            <div class="text-3xl text-gray-200 hover:text-white"><a href="{{ $setting->facebook }}"><i class="fab fa-facebook-square"></i></a></div>
            <div class="text-3xl text-gray-200 hover:text-white ml-3"><a href="{{ $setting->instagram }}"><i class="fab fa-instagram-square"></i></a></div>
            <div class="text-3xl text-gray-200 hover:text-white ml-3"><a href="{{ $setting->twitter }}"><i class="fab fa-twitter-square"></i></a></div>
            <div class="text-3xl text-gray-200 hover:text-white ml-3"><a href="{{ $setting->youtube }}"><i class="fab fa-youtube-square"></i></a></div>
          </div>
        </div>
      </div>

      {{-- Static Page --}}
      <div class="px-10 flex flex-row mt-5 mb-4 gap-x-3 md:gap-x-4 items-center flex-wrap justify-center">
        @foreach($halstatis as $hst)
        <div class="block text-sm font-semibold text-teal-300 hover:text-white text-center"><a href="/statis/{{ $hst->slug }}">{{ $hst->judul }}</a></div>
        @endforeach
      </div>

    </div>

    {{-- Copyright --}}
    <div class="w-full h-auto bg-gradient-to-r from-teal-500 to-indigo-600">
      <div class="text-xs lg:text-sm text-white text-center py-2.5">{!! $setting->copyright !!}</div>
    </div>
</footer>

{{-- Jquery --}}
<script src="{{ asset('plugin/jquery/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('plugin/splide/dist/js/splide.min.js') }}"></script>

@stack('js')

{{-- PWA Script --}}
<script src="{{ asset('/sw.js') }}"></script>
<script>
    if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("/sw.js").then(function (reg) {
            console.log("Service worker has been registered for scope: " + reg.scope);
        });
    }
</script>