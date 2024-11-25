<div class="w-full h-auto bg-white px-5 my-20 md:mt-5 md:mb-14">
  <div class="flex flex-row items-center justify-between">
    <div class="md:text-2xl text-slate-800 font-bold uppercase">{{ $title }}</div>
    <a href="{{ url('/') }}" target="_blank">
      <div class="text-xxs -mt-px font-semibold text-white bg-red-500 hover:bg-red-600 py-2 px-3 rounded-full inline-block align-middle">Kunjungi Situs <i class="fas fa-external-link-alt"></i></div>
    </a>
  </div>
  
  <div class="mt-5 w-full h-px bg-gray-200 rounded-full"></div>

  {{ $slot }}

</div>