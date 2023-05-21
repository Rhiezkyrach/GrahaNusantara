@extends('admin.layouts.header')

@section('admincontent')

<!-- main Container -->
<div class="w-full h-auto bg-white px-5 my-20 md:mx-8 md:mt-5 md:mb-14">
  <div class="flex flex-row items-center justify-between">
    <div class="md:text-2xl font-semibold">Management Kategori</div>
    <a href="/" target="_blank">
      <div class="text-xxs -mt-px font-semibold text-white bg-red-500 hover:bg-red-600 py-2 px-3 rounded-full inline-block align-middle">Kunjungi Situs <i class="fas fa-external-link-alt"></i></div>
    </a>
  </div>
  <div class="mt-5 w-full h-px bg-gray-200 rounded-full"></div>

  {{-- main content --}}
    
    {{-- table --}}
    <div class="mt-5 h-auto w-full">
      <div class="flex flex-row w-full justify-between">
          <a href="/admin/kategori/create"><div class="text-white font-semibold bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg"><i class="fas fa-plus"></i> Tambah Kategori</div></a> 
      </div>

      @if(session()->has('success'))
      <div id="inform" class="mt-3 flex flex-row bg-sky-100 w-full items-center justify-between rounded-lg">
        <div class="py-2 px-4 text-sm text-sky-800">
          <span class="text-lg"><i class="fas fa-info"></i></span> {{ session('success') }}
        </div>
        <button id="close-inform" class="py-2 px-4 text-sky-800 text-lg"><i class="fas fa-times"></i></button>
      </div>
      @endif

      <div class="mt-4 flex flex-col">
        <div class="overflow-x-auto">
          <div class="align-middle inline-block min-w-full px-px">
          <div class="shadow overflow-hidden border-b h-auto border-gray-200 rounded-lg">

            <table class="min-w-full">
              <thead class="bg-gradient-to-r from-slate-600 to-gray-600">
                <tr class="divide-x divide-gray-200">
                  <th class="px-2 py-2 text-sm text-center uppercase font-bold text-white whitespace-nowrap tracking-wide">No</th>
                  <th class="px-3 py-2 text-sm text-center uppercase font-bold text-white whitespace-nowrap tracking-wide">Nama Kategori</th>
                  <th class="px-3 py-2 text-sm text-center uppercase font-bold text-white whitespace-nowrap tracking-wide">Status</th>
                  <th class="px-3 py-2 text-sm text-center uppercase font-bold text-white whitespace-nowrap tracking-wide">Navigasi</th>
                  <th class="px-3 py-2 text-sm text-center uppercase font-bold text-white whitespace-nowrap tracking-wide">Urutan</th>
                  <th class="px-3 py-2 text-sm text-center uppercase font-bold text-white whitespace-nowrap tracking-wide">Aksi</th>
                </tr>
              </thead>
              <tbody>
                
                @if($kategori->count())
                @foreach($kategori as $k)
                <tr class="divide-x divide-gray-200 {{ $loop->even ? 'bg-sky-100' : '' }}">
                  <td class="px-2 py-2 text-sm text-center whitespace-nowrap">{{ $loop->iteration }}</td>
                  <td class="px-2 py-2 text-sm text-center whitespace-nowrap md:whitespace-normal">{{ $k->nama }}</td>
                  <td class="px-3 py-2 text-sm text-center whitespace-nowrap">
                    @if($k->status == 0)
                        <div class="inline-flex text-xxs font-semibold text-red-800 bg-red-200 px-2 py-1 rounded-full">Tidak Aktif</div>
                    @else
                        <div class="inline-flex text-xxs font-semibold text-green-800 bg-green-200 px-2 py-1 rounded-full">Aktif</div>
                    @endif    
                  </td>                
                  <td class="px-3 py-2 text-sm text-center whitespace-nowrap">
                    @if($k->navigasi == 0)
                        <div class="inline-flex text-xxs font-semibold text-red-800 bg-red-200 px-2 py-1 rounded-full">Tidak Aktif</div>
                    @else
                        <div class="inline-flex text-xxs font-semibold text-green-800 bg-green-200 px-2 py-1 rounded-full">Aktif</div>
                    @endif    
                  </td>
                  <td class="px-2 py-2 text-sm text-center whitespace-nowrap md:whitespace-normal">{{ $k->urutan }}</td>             
                  <td class="px-3 py-2 text-sm text-center w-20 whitespace-nowrap">
                      <div class="flex flex-row gap-2 ">
                          <a href="/admin/kategori/{{ $k->slug }}/edit"><div class="text-xxs font-semibold text-white bg-amber-500 hover:bg-amber-600 py-2 px-3 rounded-md"><i class="fas fa-pen-alt"></i> Edit</div></a>
                          {{-- <form action="/admin/kategori/{{ $k->slug }}" method="post">
                            @method('delete')
                            @csrf
                            <button class="text-xxs font-semibold text-white bg-red-600 hover:bg-red-700 py-2 px-3 rounded-md" onclick="return confirm('Yakin ingin menghapus video?')"><i class="fas fa-trash-alt"></i> Hapus</button>
                          </form> --}}
                      </div>
                  </td>
                </tr>
                @endforeach

                @else
                <tr class="w-full">
                  <td class="px-6 py-2 text-left">Tidak ada data</td>
                </tr>
                @endif

              </tbody>                   
            </table>

          </div>
          </div>
        </div>
      </div>

    </div>
    {{-- /table --}}
  {{-- /main content --}}

</div>
<!-- /Main Container -->

<script>
let inform = document.querySelector("#inform");
let closeInform = document.querySelector("#close-inform");

closeInform.addEventListener("click", function () {
    inform.classList.add("hidden");
});

</script>


@endsection