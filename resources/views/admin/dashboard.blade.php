@extends('admin.layouts.header')

@section('admincontent')

    <!-- main Container -->
    <div class="w-full h-auto bg-white px-4 my-20 md:mx-5 lg:mx-10 2xl:mx-12 md:mt-5 md:mb-14">
      <div class="flex flex-row items-center justify-between">
        <div class="md:text-xl font-sembibold">{!! $salam !!}, <span class="font-semibold text-red-600">{{ auth()->user()->nama }}</span>.</div>
        {{-- <a href="/" target="_blank">
          <div class="text-xxs -mt-px font-semibold text-white bg-red-500 hover:bg-red-600 py-2 px-3 rounded-full inline-block align-middle">Kunjungi Situs <i class="fas fa-external-link-alt"></i></div>
        </a> --}}
      </div>
      <div class="mt-5 w-full h-px bg-gray-200 rounded-full"></div>

      {{-- main content --}}
      <div class="grid grid-cols-1 md:grid-cols-2 mt-8 w-full gap-5">

        {{-- Table Kiri --}}
        <div class="w-full">

          {{-- 1st table --}}
          <div class="h-auto w-full">
            <div class="font-semibold">BERITA HARI INI</div>

            <div class="mt-2 flex flex-col">
              <div class="overflow-x-auto">
                <div class="align-middle inline-block min-w-full px-px">
                <div class="shadow overflow-hidden border-b h-auto border-gray-200 rounded-lg">

                  <table class="min-w-full">
                    <thead class="bg-gradient-to-r from-slate-600 to-gray-600">
                      <tr class="divide-x divide-gray-200">
                        <th class="px-2 py-2 text-sm text-center uppercase font-bold text-white whitespace-nowrap tracking-wide">No</th>
                        <th class="px-4 py-2 text-sm text-left uppercase font-bold text-white whitespace-nowrap tracking-wide ">Nama</th>
                        <th class="px-4 py-2 text-sm text-left uppercase font-bold text-white whitespace-nowrap tracking-wide ">Jumlah</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                      @if($jumlahBerita->count())
                      @foreach($jumlahBerita as $jb)
                      <tr class="divide-x divide-gray-200 {{ $loop->iteration %2 == 0 ? 'bg-sky-100' : '' }}">
                        <td class="px-2 py-2 text-sm text-center whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 text-sm text-left whitespace-nowrap md:whitespace-normal">{{ $jb->nama_wartawan }}</td>
                        <td class="px-4 py-2 text-sm text-left whitespace-nowrap">{{ $jb->hitung_count }}</td>
                      </tr>
                      @endforeach

                      @else
                      <tr class="w-full">
                        <td class="px-6 py-2 text-sm text-left">Belum ada berita</td>
                      </tr>
                      @endif

                    </tbody>                   
                  </table>
                    
                </div>
                </div>
              </div>
            </div>

              @can('superadmin')
              <a href="/admin/laporan_wartawan">
                <div class="mt-2 text-xs text-right hover:text-red-600">selengkapnya <i class="far fa-arrow-alt-circle-right"></i></div>
              </a>
              @endcan

          </div>
          {{-- /1st table --}}

          {{-- 2nd table --}}
          <div class="mt-5 h-auto w-full">
            <div class="font-semibold">POPULER MINGGU INI</div>

            <div class="mt-2 flex flex-col">
              <div class="overflow-x-auto">
                <div class="align-middle inline-block min-w-full px-px">
                <div class="shadow overflow-hidden border-b h-auto border-gray-200 rounded-lg">

                  <table class="min-w-full">
                    <thead class="bg-gradient-to-r from-slate-600 to-gray-600">
                      <tr class="divide-x divide-gray-200">
                        <th class="px-2 py-2 text-sm text-left uppercase font-bold text-white whitespace-nowrap tracking-wide">No</th>
                        <th class="px-4 py-2 text-sm text-left uppercase font-bold text-white whitespace-nowrap tracking-wide ">Judul</th>
                        <th class="px-4 py-2 text-sm text-left uppercase font-bold text-white whitespace-nowrap tracking-wide ">Dilihat</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                      @if($populer->count())
                      @foreach($populer as $pv)
                      <tr class="divide-x divide-gray-200 {{ $loop->even ? 'bg-sky-100' : '' }}">
                        <td class="px-2 py-2 text-sm text-center whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 text-sm text-left whitespace-normal">{{ $pv->judul }}</td>
                        <td class="px-4 py-2 text-sm text-center whitespace-nowrap">{{ $pv->counter }}</td>
                      </tr>
                      @endforeach

                      @else
                      <tr class="w-full">
                        <td class="px-4 py-2 text-sm text-left">Belum ada berita populer</td>
                      </tr>
                      @endif

                    </tbody>                   
                  </table>
                    
                </div>
                </div>
              </div>
            </div>

              @can('superadmin')
              <a href="/admin/laporan">
                <div class="mt-2 text-xs text-right hover:text-red-600">selengkapnya <i class="far fa-arrow-alt-circle-right"></i></div>
              </a>
              @endcan
          </div>
          {{-- /2nd table --}}

        </div>

        {{-- Google Trends --}}
        <div class="h-auto w-full">
          {{-- <div class="font-semibold">GOOGLE TRENDS</div> --}}
          <img class="w-32 h-auto" src="{{ asset('images/g_trends.png') }}" alt="">
          <div class="mt-2 flex flex-col gap-1.5">
            
            @foreach($trends->channel->item as $data)
            <div class="w-full flex flex-row items-center justify-between {{ $loop->even ? 'bg-gradient-to-r from-sky-600 to-indigo-600' : 'bg-gradient-to-r from-amber-600 to-rose-500' }} rounded-lg">
              <div class="py-2 px-5 text-sm font-semibold text-white">{{ $data->title }}</div>
              <div class="py-2 px-5 text-xs text-white">{{ $data->children('ht', true)->approx_traffic }} Pencarian</div>
            </div>
            @endforeach

          </div>
        </div>
        {{-- /Google Trends --}}

      </div>
      {{-- /main content --}}

    </div>
    <!-- /Main Container -->

@endsection