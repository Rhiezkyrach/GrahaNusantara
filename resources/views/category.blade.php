@extends('layouts.main')

@section('main_section')

<!-- Kategori Terkini -->
<div class="flex flex-row items-center justify-between">
    <div class="flex flex-row items-center">
        <div class="h-8 w-1.5 bg-gradient-to-tr from-rose-600 to-orange-500 rounded-full rotate-12"></div>
        <div class="text-lg lg:text-xl ml-2 italic text-slate-700 whitespace-nowrap"><span class="font-bold">BERITA</span> TERKINI</div>    
    </div>
    <div class="text-xs lg:text-sm"><a href="/indeks" class="font-semibold py-0.5 text-gray-500 hover:text-gray-700"><i class="fa-solid fa-arrow-right-long"></i></a></div>
</div>

<div id="post" class="w-full">
  {{-- Ajax --}}
</div>

<div id="loading" class="hidden mt-4 w-full">
  <div class="text-center font-semibold whitespace-nowrap">
  <span id="spinner" class="inline-block animate-spin rounded-full text-red-600 text-xl"><i class="fas fa-spinner"></i></span>
  <p class="ml-1 inline-block dark:text-gray-200">Memuat Berita...</p>
  </div>
</div>

{{-- @else
  <div class="text-center text-xl font-semibold">Tidak Ada Berita</div>
@endif --}}

<!-- /Kategori Terkini --> 

<script type="text/javascript">
  var paginate = 1;
  loadMoreData(paginate);
  $(window).scroll(function() {
      if($(window).scrollTop() + $(window).height() >= $(document).height()) {
          paginate++;
          loadMoreData(paginate);
        }
  });
  // run function when user reaches to end of the page
  function loadMoreData(paginate) {
      $.ajax({
          url: '?page=' + paginate,
          type: 'get',
          datatype: 'html',
          beforeSend: function() {
              $('#loading').show();
          }
      })
      .done(function(data) {
          if(data.length == 0) {
              $('#loading').html('Tidak Ada Berita.');
              return;
            } else {
              $('#loading').hide();
              $('#post').append(data);
            }
      })
          .fail(function(jqXHR, ajaxOptions, thrownError) {
            alert('Tidak Dapat Memuat Berita.');
          });
  }
</script>

@endsection