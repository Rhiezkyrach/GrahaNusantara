<!-- Navbar Mobile -->
<nav class="md:hidden fixed z-[9999] top-0 bg-gray-100 shadow-md w-full px-4 lg:px-20 mx-auto py-2">
  <div class="relative flex flex-warp items-center justify-between">
    <div id="justify" class="w-full flex items-center justify-between">
      <a href="{{ url('/admin/dashboard') }}">
        <img src="{{ asset('storage/' . $setting->logo) }}" alt="{{ $setting->judul_situs }}" class="w-36" />
      </a>
      <!-- hamburger Menu -->
      <div class="flex">
        <button id="hamburger" class="relative w-8 h-8">
          <div class="hidden rotate-45"></div><div class="hidden -rotate-45"></div>
          <div role="hidden" id="line" class="inset-0 w-6 h-0.5 m-auto rounded-full bg-gray-500 transform transition duration-300"></div>
          <div role="hidden" id="line2" class="inset-0 w-5 h-0.5 mt-1.5 ml-2 m-auto rounded-full bg-gray-500 transform transition duration-300"></div>
          <div role="hidden" id="line3" class="inset-0 w-6 h-0.5 mt-1.5 m-auto rounded-full bg-gray-500 transform transition duration-300"></div>
        </button>
      </div>
      <!-- /Hamburger Menu -->
    </div>
  </div>

  <div id="navlinks" class="hidden h-screen px-4 w-full transition overflow-y-scroll">
    <ul class="py-4 text-gray-600 text-lg tracking-wide lg:flex lg:space-x-8 lg:py-0">

      <select id="networkselect" class="networkselect mt-2.5 w-full px-4 py-2 text-sm  bg-lime-200 hover:bg-lime-300 text-lime-700 border-2 border-lime-500 text-center font-semibold uppercase rounded">
          @php
            $access = App\Models\NetworkAccess::where('id_user', auth()->user()->id)->pluck('id_network');
            $networks = [];
            if(auth()->user()->level == 'owner'){
              $networks = App\Models\Network::get();
            } else {
              $networks = App\Models\Network::whereIn('id_network', $access)->get();
            }
          @endphp
          @foreach($networks as $d)
          <option value="{{ $d->id_network }}" @selected($d->id_network == auth()->user()->id_network )><i class="fa-duotone fa-location-dot"></i> {{ $d->nama }}</option>
          @endforeach
      </select>

      <div class="text-xxs mt-2 mb-1 text-gray-500">MENU</div>
      <li><a href="{{ url('/admin/dashboard') }}" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fas fa-home"></i> Dashboard</a></li>
      <li><a href="{{ url('/admin/berita') }}" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="far fa-newspaper"></i> Berita</a></li>
      <li><a href="{{ url('/admin/list-tayang') }}" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fas fa-list"></i> List Tayang @if($list_tayang)<div class="ml-1 text-xxs badge badge-info gap-2">{{ $list_tayang }}</div>@endif</a></li>
      <li><a href="{{ url('/admin/galeri') }}" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fas fa-images"></i> Galeri</a></li>
      
      @canany(['owner', 'admin'])
      <li><a href="{{ url('/admin/epaper') }}" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fa-solid fa-file-pdf"></i> e-Paper</a></li>
      @endcanany

      <li><a href="{{ url('/admin/media') }}" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fa-regular fa-folder-open"></i> File Manager</a></li>
      <li><a href="{{ url('/admin/profile') }}" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fas fa-user"></i> Profil Saya</a></li>
      
      @canany(['owner', 'admin'])
      <div class="text-xxs mt-4 mb-1 text-gray-500">ADMIN</div>
      <li><a href="{{ url('/admin/kategori') }}" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fas fa-th-large"></i> Kategori</a></li>
      <li><a href="{{ url('/admin/fokus') }}" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fa-regular fa-object-group"></i> Fokus</a></li>
      <li><a href="{{ url('/admin/halaman') }}" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fas fa-file-alt"></i> Halaman</a></li>
      <li><a href="{{ url('/admin/iklan') }}" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fas fa-donate"></i> Iklan</a></li>
      <li><a href="{{ url('/admin/wartawan') }}" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fas fa-users"></i> Wartawan</a></li>
      <li><a href="{{ url('/admin/user') }}" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fa-solid fa-user-gear"></i> Users</a></li>
      <li><a href="{{ url('/admin/laporan') }}" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fas fa-chart-bar"></i> Laporan</a></li>
      <li><a href="{{ url('/admin/pengaturan/'. $id_setting .'/edit') }}" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fas fa-cog"></i> Pengaturan</a></li>
      @endcanany
      
      @can('owner')
      <div class="text-xxs mt-4 mb-1 text-gray-500">OWNER</div>
      <li><a href="{{ url('/admin/network') }}" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fa-solid fa-diagram-project"></i> Network</a></li>
      <li><a href="{{ url('/admin/struktur') }}" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fa-solid fa-screen-users"></i> Struktur</a></li>
      @endcan

    </ul>

    <form action="{{ url('/logout') }}" method="post">
      @csrf
      <button type="submit" class="bg-red-600 rounded-md mb-2 py-1 px-2">
      <span class="text-xs xl:text-sm text-white font-semibold ">Log Out <i class="fas fa-sign-out-alt"></i></span>
      </button>
    </form>
  </div>
</nav>
<!-- Navbar Mobile -->

@push('js')
<script>
$(document).ready(function () {
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

  // Set Network
  $('.networkselect').on('change', function(){
      let network = $(this).children(':selected').val();
      let url = "{{ route('setnetwork') }}" + `?network=${network}`;

      $.get(url, function(data){
          if (window.location.href.indexOf("pengaturan") > -1) {
            window.location.href = "{{ url('/admin/dashboard') }}";
          } else {
            window.location.reload();
          }
      })
  });
});
</script>
@endpush
