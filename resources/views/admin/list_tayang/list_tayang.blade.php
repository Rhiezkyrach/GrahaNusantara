@extends('admin.layouts.header')

@section('admincontent')

<!-- main Container -->
<x-main-container title="List Tayang" url="{{ $setting && $setting->Network ? $setting->Network->url : url('/') }}">
  {{-- table --}}
  <div class="mt-5 w-full">
    {{-- Table Controls --}}
    {{-- <x-table-controls addurl="{{ url('admin/berita/create') }}"/> --}}

    <table id="datatable" class="display w-full order-column">
      <thead class="bg-slate-300">
        <tr>
          <th>NETWORK</th>
          <th>TANGGAL</th>
          <th>JUDUL BERITA</th>
          <th>HL</th>
          <th>KATEGORI</th>
          <th>REDAKTUR</th>
          <th>WARTAWAN</th>
          <th>STATUS</th>
          <th>DILIHAT</th>
          <th>LINK</th>
          <th class="w-28 noExport !text-center" data-priority="2">Aksi</th>
        </tr>
      </thead>
      <tbody>
        {{-- Datatable Ajax--}}
      </tbody>                   
    </table>

  </div>
  {{-- /table --}}

</x-main-container>

<!-- /Main Container -->

@push('js')
<script>
//Ajax CSRF
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
});

$(document).ready(function () {
    let dataDatatable = $('#datatable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'get',
        'responsive': false,
        'searching': true,
        'autoWidth': false,
        'ordering': true,
        'info': true,
        'scrollX': true,
        'scrollY': '400px',
        'scrollCollapse': true,
        'fixedColumns':{ left: 0, right: 1 },
        'dom': 'rtip',
        // 'search': { search: searchTerm },
        'columnDefs': [{ targets: '_all', className: 'whitespace-nowrap'}],
        'order': [[0, 'desc']],
        'buttons': [
            {
            extend: 'excel',
            footer: false,
            exportOptions: {
                    columns: "thead th:not(.noExport)"
                }
            },
            {
            extend: 'pdf',
            footer: false,
            exportOptions: {
                    columns: "thead th:not(.noExport)"
                }
            },
            {
            extend: 'print',
            footer: false,
            exportOptions: {
                    columns: "thead th:not(.noExport)"
                }
            },
        ],
        'ajax': {
            'url': '/admin/list-tayang',
        },
        'columns':[
            { data: 'id_network' },
            { data: 'tanggal_tayang' },
            { data: 'judul' },
            { data: 'headline' },
            { data: 'kategori' },
            { data: 'penulis' },
            { data: 'wartawan' },
            { data: 'publish' },
            { data: 'counter' },
            { data: 'link' },
            { data: 'action' },
        ],

    });

    // row per page
    $('#rowsPerPage').on('change', function() {
        let row = $("#rowsPerPage").val()
        dataDatatable.page.len(row).draw();
    });

    //search
    $('#searchData').on( 'keyup', function () {
        dataDatatable.search( this.value ).draw();
    });

    //exports
    $("#printButton").on( "click", () => dataDatatable.button( '.buttons-print' ).trigger() );
    $("#excelButton").on("click", () => dataDatatable.button( '.buttons-excel' ).trigger() );
    $("#pdfButton").on("click", () => dataDatatable.button( '.buttons-pdf' ).trigger() );

    // Confirm Delete
    $(document).on('click', '.deleteButton', function (event) {
      event.preventDefault();
      let slug = $(this).data('slug');
      Swal.fire({
          title: 'Hapus Berita?',
          text: "Data akan dihapus permanen!",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal'
      }).then((result) => {
          if (result.isConfirmed) {
              $(this).closest("form").submit();
          }
      })
    });

});
</script>
@endpush

@endsection