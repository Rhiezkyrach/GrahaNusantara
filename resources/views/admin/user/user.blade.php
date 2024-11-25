@extends('admin.layouts.header')

@section('admincontent')

<!-- main Container -->
<x-main-container title="Management User" url="{{ $setting && $setting->Network ? $setting->Network->url : url('/') }}">

  {{-- table --}}
  <div class="mt-5 w-full">
    {{-- Table Controls --}}
    <x-table-controls addurl="{{ url('admin/user/create') }}"/>

    <table id="datatable" class="display w-full order-column">
      <thead class="bg-slate-300">
        <tr>
          <th>NETWORK</th>
          <th>USERNAME</th>
          <th>NAMA</th>
          <th>INISIAL</th>
          <th>LEVEL</th>
          <th>EMAIL</th>
          <th>STATUS</th>
          <th class="w-32 noExport !text-center" data-priority="2">AKSI</th>
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

<!-- Modal -->
<x-modals class="max-w-2xl">
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
            'url': '/admin/user',
        },
        'columns':[
            { data: 'id_network' },
            { data: 'username' },
            { data: 'name' },
            { data: 'inisial' },
            { data: 'level' },
            { data: 'email' },
            { data: 'status' },
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
        let url = 'user/create';

        $.get(url, function (data) {
            $('#modal-container').prop('checked',true);
            $('#modal-ajax').html(data);
            $('.select2').select2({
                dropdownParent: $('#modal-content'),
                placeholder: 'Select One'
            });

            // Preview Logo
            $('#inputfoto').change(function() {
                const file = this.files[0];
                // console.log(file);
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        // console.log(event.target.result);
                        $('.foto-preview').attr('src', event.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });

            //check if number already exist
            $('#formSubmit').on('click', function(e){
                e.preventDefault();
                let unique = $('#inputusername').val();
                let email = $('#inputemail').val();

                $.ajax({
                    url: 'user/check/?unique=' + unique + '&email=' + email,
                    method: 'GET',
                    success: function(data){
                        if(data){
                        // Show number is taken alert
                        Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Username/Email Sudah Ada!',
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
    $(document).on('click', '.infoDataButton', function (event) {
        event.preventDefault();
        let id = $(this).data('id');
        let url = 'user/' + id ;

        $.get(url, function (data) {
            $('#modal-container').prop('checked',true);
            $('#modal-ajax').html(data);
        });

    });

    //Edit
    $(document).on('click', '.editDataButton', function (event) {
        event.preventDefault();
        let id = $(this).data('id');
        let url = 'user/' + id + '/edit';

        $.get(url, function (data) {
            $('#modal-container').prop('checked',true);
            $('#modal-ajax').html(data);
            $('.select2').select2({
                dropdownParent: $('#modal-content')
            });

            // Preview Logo
            $('#inputfoto').change(function() {
                const file = this.files[0];
                // console.log(file);
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        // console.log(event.target.result);
                        $('.foto-preview').attr('src', event.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Prevent double click input
            $('#forms').on('submit', function(){
                $('#formSubmit').prop( "disabled", true );
                $('#process').addClass('hidden');
                $('#processing').removeClass('hidden');
            });
        });
    });

    // Confirm Delete
    $(document).on('click', '.deleteButton', function (event) {
      event.preventDefault();
      let id = $(this).data('id');
      Swal.fire({
          title: 'Hapus User?',
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