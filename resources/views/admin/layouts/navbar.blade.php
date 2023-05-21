<!-- Navbar Mobile -->
<nav class="md:hidden fixed z-10 top-0 bg-white shadow-md w-full px-4 lg:px-20 mx-auto py-2">
  <div class="relative flex flex-warp items-center justify-between">
    <div id="justify" class="z-10 w-full flex items-center justify-between">
      <a href="/admin/dashboard">
        <img src="{{ asset('storage/' . $setting->logo) }}" alt="{{ $setting->judul_situs }}" class="w-36" />
      </a>
      <!-- hamburger Menu -->
      <div class="flex">
        <button id="hamburger" class="relative w-10 h-10 lg:hidden">
          <div class="hidden rotate-45"></div><div class="hidden -rotate-45"></div>
          <div role="hidden" id="line" class="inset-0 w-6 h-0.5 m-auto rounded-full bg-gray-500 transition duration-300"></div>
          <div role="hidden" id="line2" class="inset-0 w-5 h-0.5 mt-1.5 mr-2 m-auto rounded-full bg-gray-500 transition duration-300"></div>
          <div role="hidden" id="line3" class="inset-0 w-6 h-0.5 mt-1.5 m-auto rounded-full bg-gray-500 transition duration-300"></div>
        </button>
      </div>
      <!-- /Hamburger Menu -->
    </div>
  </div>

  <div id="navlinks" class="hidden h-auto px-4 w-full bg-white transition">
    <ul class="py-4 text-gray-600 text-lg tracking-wide lg:flex lg:space-x-8 lg:py-0">
      <div class="text-xxs mt-2 mb-1 text-gray-500">MENU</div>
      <li><a href="/admin/dashboard" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fas fa-home"></i> Dashboard</a></li>
      <li><a href="/admin/berita" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="far fa-newspaper"></i> Berita</a></li>
      <li><a href="/admin/galeri" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fas fa-images"></i> Galeri</a></li>
      <li><a href="/admin/epaper" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fa-solid fa-file-pdf"></i> ePaper</a></li>
      <li><a href="/admin/kategori" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fas fa-th-large"></i> Kategori</a></li>
      <li><a href="/admin/list-tayang" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fas fa-list"></i> List Tayang</a></li>
      
      @can('superadmin')
      <div class="text-xxs mt-4 mb-1 text-gray-500">SUPERADMIN</div>
      <li><a href="/admin/halaman" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fas fa-file-alt"></i> Halaman</a></li>
      <li><a href="/admin/laporan" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fas fa-chart-bar"></i> Laporan</a></li>
      <li><a href="/admin/user" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fas fa-user"></i> Users</a></li>
      <li><a href="/admin/wartawan" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fas fa-users"></i> Wartawan</a></li>
      <li><a href="/admin/iklan" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fas fa-donate"></i> Iklan</a></li>
      <li><a href="/admin/network" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fa-solid fa-diagram-project"></i> Network</a></li>
      <li><a href="/admin/pengaturan/1/edit" class="block text-sm font-semibold w-full py-1.5 transition hover:text-cyan-600"><i class="fas fa-cog"></i> Pengaturan</a></li>
      @endcan
      </li>
    </ul>

    <form action="/cmslogout" method="post">
      @csrf
      <button type="submit" class="bg-red-600 rounded-md mb-2 py-1 px-2">
      <span class="text-xs xl:text-sm text-white font-semibold ">Log Out <i class="fas fa-sign-out-alt"></i></span>
      </button>
    </form>
  </div>
</nav>
<!-- Navbar Mobile -->
