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

<div class="mt-4 w-auto text-center mx-auto">
    <button id="load-more" class="block w-36 py-2 px-3 text-teal-600 dark:text-teal-400 ring-2 ring-teal-600 ring-inset hover:ring-0 bg-teal-100 dark:bg-teal-800 hover:bg-teal-600 hover:text-white rounded-md whitespace-nowrap mx-auto" data-paginate="2">
        <span id="spinner" class="hidden animate-spin rounded-full text-lg"><i class="fa-regular fa-circle-notch"></i></span>
        <span id="text" class="text-sm font-semibold">Muat Lagi...</span>
        <p id="nopost" class="hidden mt-2 text-xs font-semibold">Tidak Ada Berita...</p>
    </button>
</div>

{{-- @else
  <div class="text-center text-xl font-semibold">Tidak Ada Berita</div>
@endif --}}

<!-- /Kategori Terkini --> 

@push('js')
<script type="text/javascript">
    let paginate = 1;
    loadMoreData(paginate);

    $('#load-more').click(function() {
        let page = $(this).data('paginate');
        loadMoreData(page);
        $(this).data('paginate', page+1);
    });
    // run function when user click load more button
    function loadMoreData(paginate) {
        $.ajax({
            url: '?page=' + paginate,
            type: 'get',
            datatype: 'html',
            beforeSend: function() {
                $('#text').text('Memuat Berita');
                $('#spinner').removeClass('hidden').addClass('inline-block');
            }
        })
        .done(function(data) {
            if(data.length == 0) {
                $('#nopost').removeClass('hidden');
                $('#load-more').hide();
                return;
                } else {
                $('#text').text('Muat Lagi...');
                $('#spinner').removeClass('inline-block').addClass('hidden');
                $('#post').append(data);
                }
        })
        .fail(function(jqXHR, ajaxOptions, thrownError) {
            alert('Tidak Dapat Memuat Berita.');
        });
    }
</script>
@endpush
@endsection