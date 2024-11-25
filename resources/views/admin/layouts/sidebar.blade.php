<!-- Nav Sidebar PC -->
  <div class="relative hidden md:flex w-2/12 h-screen">

      <div class="fixed py-3 px-5 2xl:py-4 2xl:px-8 w-2/12 bg-gradient-to-t from-slate-800 to-gray-700 h-screen overflow-y-auto no-scrollbar">
        <div class="flex flex-col w-full">
          <a href="{{ url('/admin/dashboard') }}"><img class="w-36 mt-2" src="{{ asset('storage/' . $setting->darklogo) }}" alt="{{ $setting->judul_situs }}"></a>
        <div class="grid grid-col gap-2.5">

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

          <div class="text-gray-300 mt-4 text-xxxs lg:text-xxs 2xl:text-xs font-semibold">MENU</div>
          <div class="w-full h-px -mt-1 bg-gray-300"></div>

          <div class="{{ Request::is('admin/dashboard') ? 'text-slate-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold items-center' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold items-center' }}">
            <a href="{{ url('/admin/dashboard') }}"><div class="inline-flex whitespace-nowrap"><i class="fas fa-home text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Dashboard</span></div></a>
          </div>

          <div class="{{ Request::is(['admin/berita', 'admin/berita/*']) ? 'text-slate-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="{{ url('/admin/berita') }}"><div class="inline-flex whitespace-nowrap"><i class="far fa-newspaper text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Berita</span></div></a>
          </div>
          <div class="{{ Request::is('admin/list-tayang') ? 'text-slate-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="{{ url('/admin/list-tayang') }}"><div class="inline-flex whitespace-nowrap"><i class="fas fa-list text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">List Tayang</span></div>@if($list_tayang)<div class="ml-1 text-xxs badge badge-info gap-2">{{ $list_tayang }}</div>@endif</a>
          </div>
          <div class="{{ Request::is('admin/galeri') ? 'text-slate-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="{{ url('/admin/galeri') }}"><div class="inline-flex whitespace-nowrap"><i class="fas fa-images text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Galeri</span></div></a>
          </div>
          
          @canany(['owner', 'admin'])
          <div class="{{ Request::is(['admin/epaper', 'admin/epaper/*']) ? 'text-slate-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="{{ url('/admin/epaper') }}"><div class="inline-flex whitespace-nowrap"><i class="fa-solid fa-file-pdf text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">e-Paper</span></div></a>
          </div>
          @endcanany
          
          <div class="{{ Request::is('admin/media') ? 'text-slate-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="{{ url('/admin/media') }}"><div class="inline-flex whitespace-nowrap"><i class="fa-regular fa-folder-open text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">File Manager</span></div></a>
          </div>
          <div class="{{ Request::is('admin/profil') ? 'text-slate-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="{{ url('/admin/profile') }}"><div class="inline-flex whitespace-nowrap"><i class="fas fa-user text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Profil Saya</span></div></a>
          </div>

          @canany(['owner', 'admin'])
          <div class="text-gray-300 mt-3 text-xxxs lg:text-xxs 2xl:text-xs font-semibold">ADMIN</div>
          <div class="w-full h-px -mt-1 bg-gray-300"></div>

          <div class="{{ Request::is(['admin/kategori', 'admin/kategori/*']) ? 'text-slate-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="{{ url('/admin/kategori') }}"><div class="inline-flex whitespace-nowrap"><i class="fa-solid fa-table-cells-large text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Kategori</span></div></a>
          </div>
          <div class="{{ Request::is(['admin/fokus', 'admin/fokus/*']) ? 'text-slate-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="{{ url('/admin/fokus') }}"><div class="inline-flex whitespace-nowrap"><i class="fa-regular fa-object-group text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Fokus</span></div></a>
          </div>
          <div class="{{ Request::is(['admin/halaman', 'admin/halaman/*']) ? 'text-slate-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
          <a href="{{ url('/admin/halaman') }}"><div class="inline-flex whitespace-nowrap"><i class="fas fa-file-alt text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Halaman</span></div></a>
          </div>
          <div class="{{ Request::is(['admin/iklan', 'admin/iklan/*']) ? 'text-slate-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="{{ url('/admin/iklan') }}"><div class="inline-flex whitespace-nowrap"><i class="fas fa-donate text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Iklan</span></div></a>
          </div>
          <div class="{{ Request::is(['admin/wartawan', 'admin/wartawan/*']) ? 'text-slate-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="{{ url('/admin/wartawan') }}"><div class="inline-flex whitespace-nowrap"><i class="fas fa-users text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Wartawan</span></div></a>
          </div>
          <div class="{{ Request::is(['admin/user', 'admin/user/*']) ? 'text-slate-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="{{ url('/admin/user') }}"><div class="inline-flex whitespace-nowrap"><i class="fa-solid fa-user-gear text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Users</span></div></a>
          </div>
          <div class="{{ Request::is(['admin/laporan', 'admin/laporan_wartawan']) ? 'text-slate-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="{{ url('/admin/laporan') }}"><div class="inline-flex whitespace-nowrap"><i class="fas fa-chart-bar text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Laporan</span></div></a>
          </div>

          <div class="{{ Request::is(['admin/pengaturan', 'admin/pengaturan/*']) ? 'text-slate-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="{{ url('/admin/pengaturan/'. $id_setting .'/edit') }}"><div class="inline-flex whitespace-nowrap"><i class="fas fa-cog text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Pengaturan</span></div></a>
          </div>
          @endcanany

          @can('owner')
          <div class="text-gray-300 mt-3 text-xxxs lg:text-xxs 2xl:text-xs font-semibold">OWNER</div>
          <div class="w-full h-px -mt-1 bg-gray-300"></div>
          <div class="{{ Request::is(['admin/network', 'admin/network/*']) ? 'text-slate-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="{{ url('/admin/network') }}"><div class="inline-flex whitespace-nowrap"><i class="fa-solid fa-diagram-project text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Network</span></div></a>
          </div>
          <div class="{{ Request::is(['admin/struktur', 'admin/struktur/*']) ? 'text-slate-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="{{ url('/admin/struktur') }}"><div class="inline-flex whitespace-nowrap"><i class="fa-solid fa-screen-users text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Struktur</span></div></a>
          </div>
          @endcan

          {{-- <div class="mt-2 2xl:mt-6 text-gray-800 bg-white py-0.5 px-1 rounded-full">
            <div class="flex flex-row items-center">
              <div class="w-5 h-5 lg:w-7 lg:h-7 2xl:w-8 2xl:h-8 bg-gray-300 rounded-full overflow-hidden">
                <a href="#"><img class="object-cover" src="{{ asset('storage/' . Auth()->user()->foto) }}" alt=""></a>
              </div>
                <form action="{{ url('/logout') }}" method="post">
                  @csrf
                  <button type="submit" class="hover:text-red-600 hover:translate-x-2 transition duration-500">
                  <span class="ml-2 text-xxxs lg:text-xs xl:text-sm font-semibold pr-1 whitespace-nowrap">Log Out <i class="fas fa-sign-out-alt"></i></span>
                  </button>
                </form>

            </div>
          </div> --}}

        </div>

      </div>
    </div>

  </div>
<!-- Nav Sidear PC -->

@push('js')
<script>
$(document).ready(function () {
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
