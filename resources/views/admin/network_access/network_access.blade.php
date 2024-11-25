@extends('admin.layouts.header')

@section('admincontent')

<!-- main Container -->
<x-main-container title="Management Akses Network" url="{{ $setting && $setting->Network ? $setting->Network->url : url('/') }}">

    <div class="mt-5 grid grid-cols-1 md:grid-cols-4 gap-2">
        {{-- ID NETWORK --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputid_network"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">ID NETWORK</span></label>
            <input type="text" id="inputid_network" name="id_network" class="main_input_md"
                value="{{ $network->id_network }}" auto-complete="off" readonly>
        </div>

        {{-- NAMA NETWORK --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputnama"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">NAMA NETWORK</span></label>
            <input type="text" id="inputnama" name="nama" class="main_input_md"
                value="{{ $network->nama }}" auto-complete="off" readonly>
        </div>

        {{-- URL --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputurl"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">URL</span></label>
            <input type="text" id="inputurl" name="url" class="main_input_md"
                value="{{ $network->url }}" auto-complete="off" readonly>
        </div>

        {{-- STATUS --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputstatus"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">STATUS</span></label>
            <input type="text" id="inputstatus" name="status" class="main_input_md"
                value="{{ $network->status == '0' ? 'Tidak Aktif' : 'Aktif'}}" auto-complete="off" readonly>
        </div>
    </div>

    <div class="divider font-semibold text-sm">LIST USER MEMILIKI AKSES KE NETWORK</div>

    {{-- table --}}
    <div class="mt-5 w-full">
        {{-- Table Controls --}}
        <x-table-controls addurl="{{ url('admin/network_access/create') }}"/>

        <table id="datatable" class="display w-full order-column">
        <thead class="bg-slate-300">
            <tr>
                <th>NAMA</th>
                <th>USERNAME</th>
                <th>LEVEL</th>
                <th class="w-28 noExport !text-center" data-priority="2">AKSI</th>
            </tr>
        </thead>
        <tbody>
            {{-- Datatable Ajax--}}
        </tbody>                   
        </table>

    </div>
    {{-- /table --}}

    <x-back-button url="{{ url('/') }}">kembali</x-back-button>
    
</x-main-container>
<!-- /Main Container -->

<!-- Modal -->
<x-modals class="max-w-xl">
    <x-slot:inputid>modal-container</x-slot:inputid>
    <x-slot:modalid>modal-content</x-slot:modalid>
    <div id="modal-ajax">
        {{-- Ajax --}}
    </div>
</x-modals>

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
            'url': '/admin/network_access?id_network={{ $network->id_network }}',
        },
        'columns':[
            { data: 'name' },
            { data: 'username' },
            { data: 'level' },
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

    //New
    $(document).on('click', '#createDataButton', function (event) {
        event.preventDefault();
        let url = "{{ url('admin/network_access/create?id_network=' . $network->id_network) }}";

        $.get(url, function (data) {
            $('#modal-container').prop('checked',true);
            $('#modal-ajax').html(data);
            $('.select2').select2({
                dropdownParent: $('#modal-content'),
                placeholder: 'Pilih'
            });

            $('#inputid_user').on('change', function(){
                let username = $(this).children(':selected').data('username');
                let level = $(this).children(':selected').data('level');

                $('#inputusername').val(username)
                $('#inputlevel').val(level)
            })

            //check if access already exist
            $('#formSubmit').on('click', function(e){
                e.preventDefault();
                let id_user = $('#inputid_user').children(':selected').val();
                let id_network = $('#inputid_network').val();

                $.ajax({
                    url: "{{ url('admin/network_access/check/?id_user=') }}" + id_user + '&id_network=' + id_network,
                    method: 'GET',
                    success: function(data){
                        if(data){
                        // Show access is taken alert
                        Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Akses User ke Network Ini Sudah Ada!',
                                timer: 10000,
                                toast: true,
                                position: 'top-end',
                            })
                        } else {
                            // Prevent double click input
                            $('#forms').on('submit', function(){
                                $('#formSubmit').prop( "disabled", true );
                                $('#process').addClass('hidden');
                                $('#processing').removeClass('hidden');
                            });

                            //Submit 
                            $("#formSubmit").unbind('click').click();
                        }
                    }
                })

            });
        })
    });

    //Show
    // $(document).on('click', '.infoDataButton', function (event) {
    //     event.preventDefault();
    //     let id = $(this).data('id');
    //     let url = 'network_access/' + id ;

    //     $.get(url, function (data) {
    //         $('#modal-container').prop('checked',true);
    //         $('#modal-ajax').html(data);
    //     });

    // });

    //Edit
    // $(document).on('click', '.editDataButton', function (event) {
    //     event.preventDefault();
    //     let id = $(this).data('id');
    //     let url = 'network_access/' + id + '/edit';

    //     $.get(url, function (data) {
    //         $('#modal-container').prop('checked',true);
    //         $('#modal-ajax').html(data);
    //         $('.select2').select2({
    //             dropdownParent: $('#modal-content')
    //         });

    //         // Prevent double click input
    //         $('#forms').on('submit', function(){
    //             $('#formSubmit').prop( "disabled", true );
    //             $('#process').addClass('hidden');
    //             $('#processing').removeClass('hidden');
    //         });
    //     });
    // });

    // Confirm Delete
    $(document).on('click', '.deleteButton', function (event) {
      event.preventDefault();
      let id = $(this).data('id');
      Swal.fire({
          title: 'Hapus Akses Network?',
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