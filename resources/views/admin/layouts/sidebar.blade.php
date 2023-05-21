<!-- Nav Sidebar PC -->
  <div class="relative hidden md:flex w-2/12 h-screen">

      <div class="fixed py-3 px-5 2xl:py-4 2xl:px-8 w-2/12 bg-gradient-to-t from-indigo-900 to-cyan-600 h-screen overflow-y-auto no-scrollbar">
        <div class="flex flex-col w-full">
          <a href="/admin/dashboard"><img class="w-36 mt-2" src="{{ asset('storage/' . $setting->darklogo) }}" alt="{{ $setting->judul_situs }}"></a>
        <div class="grid grid-col gap-2 ">

          <div class="text-gray-300 mt-4 text-xxxs lg:text-xxs 2xl:text-xs font-semibold">MENU</div>
          <div class="w-full h-px -mt-1 bg-gray-300"></div>

          <div class="{{ Request::is('admin/dashboard') ? 'text-sky-700 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold items-center' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold items-center' }}">
            <a href="/admin/dashboard"><div class="inline-flex whitespace-nowrap"><i class="fas fa-home text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Dashboard</span></div></a>
          </div>

          <div class="{{ Request::is(['admin/berita', 'admin/berita/*']) ? 'text-sky-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="/admin/berita"><div class="inline-flex whitespace-nowrap"><i class="far fa-newspaper text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Berita</span></div></a>
          </div>
          <div class="{{ Request::is('admin/galeri') ? 'text-sky-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="/admin/galeri"><div class="inline-flex whitespace-nowrap"><i class="fas fa-images text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Galeri</span></div></a>
          </div>
          <div class="{{ Request::is(['admin/epaper', 'admin/epaper/*']) ? 'text-sky-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="/admin/epaper"><div class="inline-flex whitespace-nowrap"><i class="fa-solid fa-file-pdf text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">ePaper</span></div></a>
          </div>
          <div class="{{ Request::is(['admin/kategori', 'admin/kategori/*']) ? 'text-sky-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="/admin/kategori"><div class="inline-flex whitespace-nowrap"><i class="fa-solid fa-table-cells-large text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Kategori</span></div></a>
          </div>
          <div class="{{ Request::is('admin/list-tayang') ? 'text-sky-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="/admin/list-tayang"><div class="inline-flex whitespace-nowrap"><i class="fas fa-list text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">List Tayang</span></div></a>
          </div>

          @can('superadmin')
          <div class="text-gray-300 mt-3 text-xxxs lg:text-xxs 2xl:text-xs font-semibold">SUPERADMIN</div>
          <div class="w-full h-px -mt-1 bg-gray-300"></div>

          <div class="{{ Request::is(['admin/halaman', 'admin/halaman/*']) ? 'text-sky-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
          <a href="/admin/halaman"><div class="inline-flex whitespace-nowrap"><i class="fas fa-file-alt text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Halaman</span></div></a>
          </div>
          <div class="{{ Request::is(['admin/laporan', 'admin/laporan_wartawan']) ? 'text-sky-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="/admin/laporan"><div class="inline-flex whitespace-nowrap"><i class="fas fa-chart-bar text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Laporan</span></div></a>
          </div>
          <div class="{{ Request::is(['admin/user', 'admin/user/*']) ? 'text-sky-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="/admin/user"><div class="inline-flex whitespace-nowrap"><i class="fas fa-user text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Users</span></div></a>
          </div>
          <div class="{{ Request::is(['admin/wartawan', 'admin/wartawan/*']) ? 'text-sky-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="/admin/wartawan"><div class="inline-flex whitespace-nowrap"><i class="fas fa-users text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Wartawan</span></div></a>
          </div>
          <div class="{{ Request::is(['admin/iklan', 'admin/iklan/*']) ? 'text-sky-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="/admin/iklan"><div class="inline-flex whitespace-nowrap"><i class="fas fa-donate text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Iklan</span></div></a>
          </div>
          <div class="{{ Request::is(['admin/network', 'admin/network/*']) ? 'text-sky-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="/admin/network"><div class="inline-flex whitespace-nowrap"><i class="fa-solid fa-diagram-project text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Network</span></div></a>
          </div>
          <div class="{{ Request::is(['admin/pengaturan', 'admin/pengaturan/*']) ? 'text-sky-800 py-1.5 px-3 bg-gradient-to-b from-yellow-300 to-amber-400 rounded-md font-semibold' : 'text-gray-100 hover:text-white hover:translate-x-2 transition duration-500 font-semibold' }}">
            <a href="/admin/pengaturan/1/edit"><div class="inline-flex whitespace-nowrap"><i class="fas fa-cog text-xs md:text-xxs lg:text-sm w-4 2xl:w-5"></i><span class="ml-2 text-xs md:text-xxs lg:text-sm">Pengaturan</span></div></a>
          </div>
          @endcan

          <div class="mt-2 2xl:mt-6 text-gray-800 bg-white py-0.5 px-1 rounded-full">
            <div class="flex flex-row items-center">
              <div class="w-5 h-5 lg:w-7 lg:h-7 2xl:w-8 2xl:h-8 bg-gray-300 rounded-full overflow-hidden">
                <a href="#"><img class="object-cover" src="{{ asset('storage/' . Auth()->user()->foto) }}" alt=""></a>
              </div>
                <form action="/cmslogout" method="post">
                  @csrf
                  <button type="submit" class="hover:text-red-600 hover:translate-x-2 transition duration-500">
                  <span class="ml-2 text-xxxs lg:text-xs xl:text-sm font-semibold pr-1 whitespace-nowrap">Log Out <i class="fas fa-sign-out-alt"></i></span>
                  </button>
                </form>

            </div>
          </div>

        </div>

      </div>
    </div>

  </div>
<!-- Nav Sidear PC -->