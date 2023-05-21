@extends('admin.layouts.header')

@section('admincontent')

<!-- main Container -->
<div class="w-full h-auto bg-white px-5 my-20 md:mx-8 md:mt-5 md:mb-14">
  <div class="flex flex-row items-center justify-between">
    <div class="md:text-2xl font-semibold">Laporan Jumlah Berita</div>
    <a href="/" target="_blank">
      <div class="text-xxs -mt-px font-semibold text-white bg-red-500 hover:bg-red-600 py-2 px-3 rounded-full inline-block align-middle">Kunjungi Situs <i class="fas fa-external-link-alt"></i></div>
    </a>
  </div>
  <div class="mt-5 w-full h-px bg-gray-200 rounded-full"></div>

  {{-- main content --}}

    {{-- table --}}
    <div class="mt-5 h-auto w-full lg:w-1/2">
      
      <div class="font-semibold">DATA BERITA TANGGAL {{ strToUpper(Carbon\Carbon::now()->translatedFormat('d F Y')) }}</div>

      <form method="post" action="/admin/laporan_wartawan">
      @csrf

      <div class="my-4 flex flex-col md:flex-row gap-2 w-full md:items-center">
          <div class="font-semibold">Tanggal:</div>
          <input type="date" name="tanggal" class="px-4 py-2 w-full md:w-52 border border-gray-400 rounded-lg active:outline-none" value="{{ old('tanggal', Carbon\Carbon::now()->translatedFormat('Y-m-d')) }}">

        <button type="submit" class="bg-sky-600 hover:bg-sky-700 py-2.5 w-full md:w-20 text-white text-center font-semibold rounded-lg"><i class="fas fa-sort"></i> Filter</button>
      </div>

      </form>

      <div class="mt-2 flex flex-col">
        <div class="overflow-x-auto">
          <div class="align-middle inline-block min-w-full px-px">
          <div class="shadow overflow-hidden border-b h-auto border-gray-200 rounded-lg">

            <table class="min-w-full">
              <thead class="bg-gradient-to-r from-slate-600 to-gray-600">
                <tr class="divide-x divide-gray-200">
                  <th class="px-2 py-2 text-xs text-center uppercase font-bold text-white whitespace-nowrap tracking-wide">No</th>
                  <th class="px-3 py-2 text-xs text-left uppercase font-bold text-white whitespace-nowrap tracking-wide">Nama</th>
                  <th class="px-3 py-2 text-xs text-left uppercase font-bold text-white whitespace-nowrap tracking-wide">Jumlah Berita</th>
                </tr>
              </thead>
              <tbody>
                
                @if($jumlahBerita->count())
                @foreach($jumlahBerita as $jb)
                <tr class="divide-x divide-gray-200 {{ $loop->even ? 'bg-sky-100' : '' }}">
                  <td class="px-2 py-2 text-xs text-center whitespace-nowrap">{{ $loop->iteration }}</td>
                  <td class="px-3 py-2 text-xs text-left whitespace-nowrap md:whitespace-normal">{{ $jb->nama_wartawan }}</td>
                  <td class="px-3 py-2 text-xs text-left whitespace-nowrap md:whitespace-normal">{{ $jb->hitung_count }}</td>
                </tr>
                @endforeach

                @else
                <tr class="w-full">
                  <td class="px-6 py-2 text-left">Belum ada berita</td>
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