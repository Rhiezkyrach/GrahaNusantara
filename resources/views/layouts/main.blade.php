@include('layouts.header')
  @include('layouts.navigasi')

  <main class="mx-auto lg:w-[1080px] px-4 xl:px-0 mt-5">

    <div class="md:flex md:flex-row md:gap-5 md:h-auto"> <!-- Headline PC Container -->
        
    @if(Request::is('/'))
        @include('layouts.headline')
    @elseif( Request::is(['kategori', 'kategori/*']))
        @include('layouts.partials.headline_category')
    @endif

    </div>  <!-- Headline PC Container -->

    <div class="md:flex md:flex-row"> <!-- PC Container -->
      <div class="md:w-8/12 md:flex md:flex-col"> <!-- PC Main Container -->

        @yield('main_section')

      </div> <!-- /PC Main Container -->

      <div class="md:w-4/12 md:flex md:flex-col md:pl-5"> <!-- /PC Sidebar Container -->
        <div class="md:sticky md:top-0 z-0"> <!-- Sticky Sidebar -->
        
        @if(Request::is('/'))
            @include('layouts.partials.home_sidebar')
        @else
            @include('layouts.partials.news_sidebar')
        @endif
          
        </div> <!-- Sticky Sidebar -->
      </div> <!-- /PC Sidebar Container -->

    </div> <!-- /PC Container -->

    @if(Request::is('/'))
        @include('layouts.partials.bottom_news')
    @endif
    
  </main>

  @include('layouts.footer')

</body>
</html>