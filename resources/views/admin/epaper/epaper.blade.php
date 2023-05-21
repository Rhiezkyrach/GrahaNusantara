@extends('admin.layouts.header')

@section('admincontent')

<!-- main Container -->
<div class="w-full h-auto bg-white px-5 my-20 md:mx-8 md:mt-5 md:mb-14">
  <div class="flex flex-row items-center justify-between">
    <div class="md:text-2xl font-semibold">Management ePaper</div>
    <a href="/" target="_blank">
      <div class="text-xxs -mt-px font-semibold text-white bg-red-500 hover:bg-red-600 py-2 px-3 rounded-full inline-block align-middle">Kunjungi Situs <i class="fas fa-external-link-alt"></i></div>
    </a>
  </div>
  <div class="mt-5 w-full h-px bg-gray-200 rounded-full"></div>

  {{-- main content --}}

    {{-- table --}}
    <div class="mt-5 h-auto w-full">
        <div class="flex flex-row w-full items-center justify-between">
            <a href="/admin/epaper/create"><div class="text-white font-semibold bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg"><i class="fas fa-plus"></i> Tambah</div></a> 
            <form action="/admin/epaper" autocomplete="off">
                <div class="flex flex-row md:flex-row gap-2 w-full items-center">
                  <div class="text-xs md:text-sm font-semibold">Edisi:</div>
                  <input type="date" name="cari" class="px-2 py-1 md:px-4 md:py-2 w-28 text-xs md:text-sm md:w-44 border border-gray-400 rounded-lg active:outline-none" value="{{ old('cari', Carbon\Carbon::now()->translatedFormat('Y-m-d')) }}">
                <button type="submit" class="text-xs md:text-sm bg-sky-600 hover:bg-sky-700 py-1.5 px-2 md:py-2.5 md:px-4 md:w-auto text-white text-center font-semibold rounded-lg whitespace-nowrap"><i class="fas fa-sort"></i> Filter</button>
              </div>
            </form>
        </div>
        
      <div class="mt-4 flex flex-col">
        <div class="overflow-x-auto">
          <div class="align-middle inline-block min-w-full px-px">
            <div class="shadow overflow-hidden border-b h-auto border-gray-200 rounded-lg">

              <table class="min-w-full table-auto">
                <thead class="bg-gradient-to-r from-slate-600 to-gray-600">
                  <tr class="divide-x divide-gray-200">
                    <th class="px-2 py-2 text-xs text-center uppercase font-bold text-white whitespace-nowrap tracking-wide">No</th>
                    <th class="px-3 py-2 text-xs text-left uppercase font-bold text-white whitespace-nowrap tracking-wide">Edisi</th>
                    <th class="px-2 py-2 text-xs text-center uppercase font-bold text-white whitespace-nowrap tracking-wide">Dilihat</th>
                    <th class="px-3 py-2 text-xs text-left uppercase font-bold text-white whitespace-nowrap tracking-wide">Link</th>
                    <th class="mx-auto px-3 py-2 text-xs text-center uppercase font-bold text-white whitespace-nowrap tracking-wide">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  
                  @if($epaper->count())
                  @foreach($epaper as $ep)
                  <tr class="divide-x divide-gray-200 {{ $loop->even ? 'bg-sky-100' : '' }}">
                    <td class="px-2 py-2 text-xs text-center whitespace-nowrap">{{ $loop->iteration }}</td>
                    <td class="px-3 py-2 text-xs text-left whitespace-nowrap md:whitespace-normal">{{ Carbon\Carbon::parse($ep->edisi)->translatedFormat('l, d F Y') }}</td>
                    <td class="px-2 py-2 text-xs text-center whitespace-nowrap">{{ $ep->counter }}</td>
                    <td class="px-3 py-2 text-xs text-left whitespace-nowrap select-all"><input class="placeholder-gray-500 w-52 lg:w-72 p-1 border border-blue-300 rounded-md" value="{{ URL::to('/') }}/epaper/{{ $ep->slug }}"></td>
                    <td class="w-20 px-3 py-2 text-xs text-center whitespace-nowrap">
                        <div class="flex flex-row gap-1.5">
                            <a href="{{ URL::to('/') }}/epaper/{{ $ep->slug }}" target="_blank"><div class="text-xxs text-white bg-sky-600 hover:bg-sky-700 p-1.5 rounded-md"><i class="fas fa-eye"></i></div></a>
                            <a href="/admin/epaper/{{ $ep->slug }}/edit"><div class="text-xxs text-white bg-amber-500 hover:bg-amber-600 p-1.5 rounded-md"><i class="fas fa-pen-alt"></i></div></a>
                            <form action="/admin/epaper/{{ $ep->slug }}" method="post">
                              @method('delete')
                              @csrf
                              <button class="text-xxs text-white bg-red-600 hover:bg-red-700 p-1.5 rounded-md delete_confirm" data-slug="{{ $ep->slug }}"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </td>
                  </tr>
                  @endforeach

                  @else
                  <tr class="w-full">
                    <td class="px-6 py-2 text-left">Tidak ada ePaper</td>
                  </tr>
                  @endif

                </tbody>                   
              </table>

            </div>
          </div>
        </div>
      </div>
      
      <div class="hidden md:flex mt-5">
        <div class="flex">{{ $epaper->onEachSide(1)->links('vendor.pagination.tailwind-admin') }}</div>
      </div>
      <div class="mt-5 md:hidden">
          {{ $epaper->onEachSide(1)->links('vendor.pagination.simple-tailwind') }}
      </div>

    </div>
    {{-- /table --}}
    
</div>
  

  {{-- /main content --}}

<!-- /Main Container -->

@push('js')
<script>
$('.delete_confirm').on('click', function (e) {
      e.preventDefault();
      let slug = $(this).data('slug');
      Swal.fire({
          title: 'Hapus ePaper?',
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
</script>
@endpush

@endsection