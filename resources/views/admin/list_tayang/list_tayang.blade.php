@extends('admin.layouts.header')

@section('admincontent')

<!-- main Container -->
<div class="w-full h-auto bg-white px-5 my-20 md:mx-8 md:mt-5 md:mb-14">
  <div class="flex flex-row items-center justify-between">
    <div class="md:text-2xl font-semibold">List Tayang Berita</div>
    <a href="/" target="_blank">
      <div class="text-xxs -mt-px font-semibold text-white bg-red-500 hover:bg-red-600 py-2 px-3 rounded-full inline-block align-middle">Kunjungi Situs <i class="fas fa-external-link-alt"></i></div>
    </a>
  </div>
  <div class="mt-5 w-full h-px bg-gray-200 rounded-full"></div>

  {{-- main content --}}

    {{-- table --}}
    <div class="mt-5 h-auto w-full">

      <div class="mt-4 flex flex-col">
        <div class="overflow-x-auto">
          <div class="align-middle inline-block min-w-full px-px">
          <div class="shadow overflow-hidden border-b h-auto border-gray-200 rounded-lg">

            <table class="min-w-full">
              <thead class="bg-gradient-to-r from-slate-600 to-gray-600">
                <tr class="divide-x divide-gray-200">
                  <th class="px-2 py-2 text-xs text-center uppercase font-bold text-white whitespace-nowrap tracking-wide">No</th>
                  <th class="px-3 py-2 text-xs text-left uppercase font-bold text-white whitespace-nowrap tracking-wide">Tanggal</th>
                  <th class="px-3 py-2 text-xs text-left uppercase font-bold text-white whitespace-nowrap tracking-wide">Judul</th>
                  <th class="px-3 py-2 text-xs text-left uppercase font-bold text-white whitespace-nowrap tracking-wide">Kategori</th>
                  <th class="px-3 py-2 text-xs text-left uppercase font-bold text-white whitespace-nowrap tracking-wide">Editor</th>
                  <th class="px-3 py-2 text-xs text-left uppercase font-bold text-white whitespace-nowrap tracking-wide">Wartawan</th>
                  <th class="px-2 py-2 text-xs text-center uppercase font-bold text-white whitespace-nowrap tracking-wide">HL</th>
                  <th class="px-3 py-2 text-xs text-center uppercase font-bold text-white whitespace-nowrap tracking-wide">Status</th>
                  <th class="px-2 py-2 text-xs text-center uppercase font-bold text-white whitespace-nowrap tracking-wide">Dilihat</th>
                  <th class="px-3 py-2 text-xs text-left uppercase font-bold text-white whitespace-nowrap tracking-wide">Link</th>
                  <th class="px-3 py-2 text-xs text-center uppercase font-bold text-white whitespace-nowrap tracking-wide">Aksi</th>
                </tr>
              </thead>
              <tbody>
                
                @if($berita->count())
                @foreach($berita as $b)
                <tr class="divide-x divide-gray-200 {{ $loop->even ? 'bg-sky-100' : '' }}">
                  <td class="px-2 py-2 text-xs text-center whitespace-nowrap">{{ $loop->iteration }}</td>
                  <td class="px-3 py-2 text-xs text-left whitespace-nowrap md:whitespace-normal">{{ Carbon\Carbon::parse($b->tanggal_tayang . $b->waktu)->translatedFormat('d-m-Y H:i') }} WIB</td>
                  <td class="px-3 py-2 text-xs text-left font-semibold whitespace-nowrap md:whitespace-normal">{{ $b->judul }}</td>
                  <td class="px-3 py-2 text-xs text-left whitespace-nowrap md:whitespace-normal">{{ $b->kategori->nama }}</td>
                  <td class="px-3 py-2 text-xs text-left whitespace-nowrap md:whitespace-normal">{{ $b->penulis }}</td>
                  <td class="px-3 py-2 text-xs text-left whitespace-nowrap md:whitespace-normal">{{ $b->wartawan }}</td>
                  <td class="px-2 py-2 text-xs text-center whitespace-nowrap">
                    @if($b->headline == 1)
                    <div class="text-sm text-green-800"><i class="fas fa-check-circle"></i></div>
                    @endif 
                  </td>
                  <td class="px-3 py-2 text-xs text-center whitespace-nowrap">
                    @if($b->publish == 0)
                    <div class="inline-flex text-xxs font-semibold text-red-800 bg-red-200 px-2 py-1 rounded-full">Draf</div>
                    @elseif($b->publish == 1 && Carbon\Carbon::parse($b->tanggal_tayang . $b->waktu)->translatedFormat('Y-m-d H:i') >= Carbon\Carbon::now())
                    <div class="inline-flex text-xxs font-semibold text-yellow-800 bg-yellow-200 px-2 py-1 rounded-full">Terjadwal</div>
                    @elseif($b->publish == 1 && Carbon\Carbon::parse($b->tanggal_tayang . $b->waktu)->translatedFormat('Y-m-d H:i') <= Carbon\Carbon::now())
                    <div class="inline-flex text-xxs font-semibold text-green-800 bg-green-200 px-2 py-1 rounded-full">Tayang</div>                    
                    @endif  
                  </td>
                  <td class="px-2 py-2 text-xs text-center whitespace-nowrap">{{ $b->counter }}</td>
                  <td class="px-3 py-2 text-xs text-left whitespace-nowrap select-all"><input class="placeholder-gray-500 w-28 p-1 border border-blue-300 rounded-md" value="{{ URL::to('/') }}/detail/{{ $b->id_berita }}/{{ Str::slug($b->judul, '-') }}"></td>
                  <td class="px-3 py-2 text-xs text-center whitespace-nowrap">
                      <div class="flex flex-row gap-1 ">
                          <a href="{{ URL::to('/') }}/detail/{{ $b->id_berita }}/{{ Str::slug($b->judul, '-') }}" target="_blank"><div class="text-xxs text-white bg-sky-600 hover:bg-sky-700 p-1.5 rounded-md"><i class="fas fa-eye"></i></div></a>
                          <a href="/admin/berita/{{ $b->id_berita }}/edit"><div class="text-xxs text-white bg-amber-500 hover:bg-amber-600 p-1.5 rounded-md"><i class="fas fa-pen-alt"></i></div></a>
                          <form action="/admin/berita/{{ $b->id_berita }}" method="post">
                            @method('delete')
                            @csrf
                            <button class="text-xxs text-white bg-red-600 hover:bg-red-700 p-1.5 rounded-md" onclick="return confirm('Yakin ingin menghapus video?')"><i class="fas fa-trash-alt"></i></button>
                          </form>
                      </div>
                  </td>
                </tr>
                @endforeach

                @else
                <tr class="w-full">
                  <td class="px-6 py-2 text-left">Tidak ada berita</td>
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

@endsection