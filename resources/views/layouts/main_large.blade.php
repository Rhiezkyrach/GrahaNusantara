@include('layouts.header')
  @include('layouts.navigasi')

  <main class="mx-auto lg:w-[1024px] 2xl:w-[1280px] px-4 xl:px-0 mt-6">

    @yield('main_section')
    
  </main>

  @include('layouts.footer')

</body>
</html>