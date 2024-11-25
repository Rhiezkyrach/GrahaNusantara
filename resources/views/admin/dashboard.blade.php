@extends('admin.layouts.header')

@section('admincontent')
    <!-- main Container -->
    <div class="w-full h-auto bg-white px-4 my-20 md:mx-5 lg:mx-10 2xl:mx-12 md:mt-5 md:mb-14">
      <div class="flex flex-col md:flex-row items-center justify-between gap-2">
        <div class="font-sembibold">{!! $salam !!}, <span class="font-semibold text-red-600">{{ auth()->user()->name }}</span>.</div>
        <a href="{{ $setting && $setting->Network ? $setting->Network->url : url('/') }}" target="_blank">
          <div class="text-xxs -mt-px font-semibold text-white bg-red-500 hover:bg-red-600 py-2 px-3 rounded-full inline-block align-middle">Kunjungi Situs <i class="fas fa-external-link-alt"></i></div>
        </a>
      </div>
      <div class="mt-5 w-full h-px bg-gray-200 rounded-full"></div>
      {{-- main content --}}

      {{-- chart --}}
      <div class="bg-gray-100">
        
        <div class="py-2 px-4 w-full flex flex-col md:flex-row items-center justify-between gap-2 bg-gray-200">
          <div class="pt-1 text-center font-semibold">GRAFIK PENGUNJUNG</div>

          <div class="w-full md:w-48">
            <select id="pilihgrafik" class="w-full p-1 text-sm border border-gray-400 rounded-md">
              <option class="text-gray-500" value="HARIAN">HARIAN</option>
              <option class="text-gray-500" value="BULANAN">BULANAN</option>
            </select>
          </div>
        </div>

        <div id="harian" class="w-full">
          <div id="chart_harian" class="block h-72 rounded pr-3.5"></div>
        </div>
        
        <div id="bulanan" class="w-full hidden">
          <div id="chart_bulanan" class="block h-72 rounded pr-3.5"></div>
        </div>
      </div>
        

      <div class="grid grid-cols-1 md:grid-cols-2 mt-4 w-full gap-5">

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
            <div class="w-full flex flex-row items-center justify-between {{ $loop->even ? 'bg-gradient-to-r from-blue-600 to-indigo-600' : 'bg-gradient-to-r from-emerald-600 to-green-600' }} rounded-lg">
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
@push('css')
{{-- ApexCharts v3.39.0 --}}
<link href="{{ asset('plugin/apexchart/dist/apexcharts.css') }}" rel="stylesheet">
@endpush

@push('js')
<script src="{{ asset('plugin/apexchart/dist/apexcharts.min.js') }}"></script>

<script>
$(document).ready(function () {

    //DAILY CHART
    var chart_harian = new ApexCharts(document.querySelector("#chart_harian"), {
        chart: {
            // type: 'line',
            width: '100%',
            height: '250px',
            zoom: {
                enabled: false,
            },
        },
        stroke: {
            width: 2,
            curve: 'smooth',
        },
        markers: {
            size: 3,
        },
        legend: {
            show: true,
            position: 'top',
            // horizontalAlign: 'left',
        },
        grid: {
            row: {
                colors: ['#e5e5e5', 'transparent'],
                opacity: 0.5
            },
            column: {
                colors: ['#f8f8f8', 'transparent'],
            },
            xaxis: {
                lines: {
                show: true
                }
            }
        },
        series: [{
                    name: 'Pembaca',
                    type: 'line',
                    data: {{ $visitor_daily }}
                },
            ],
        yaxis: {
            labels: {
            // formatter: function(val, index) {
            //         return val.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });
            //     }
            }
        },
        xaxis:{
            categories: {!! $hari !!}
            // categories: ["Jan", "Feb", "Mar", "Apr" , "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
        },
        plotOptions: {
            bar: {
                dataLabels: {
                position: 'top'
                }
            }
        },
    }).render();

    //MONTHLY CHART
    var chart_bulanan = new ApexCharts(document.querySelector("#chart_bulanan"), {
        chart: {
            // type: 'line',
            width: '100%',
            height: '250px',
            zoom: {
                enabled: false,
            },
        },
        stroke: {
            width: 2,
            curve: 'smooth',
        },
        markers: {
            size: 3,
        },
        legend: {
            show: true,
            position: 'top',
            // horizontalAlign: 'left',
        },
        grid: {
            row: {
                colors: ['#e5e5e5', 'transparent'],
                opacity: 0.5
            },
            column: {
                colors: ['#f8f8f8', 'transparent'],
            },
            xaxis: {
                lines: {
                show: true
                }
            }
        },
        series: [{
                    name: 'Pembaca',
                    type: 'line',
                    data: {{ $visitor_monthly }}
                },
            ],
        yaxis: {
            labels: {
            // formatter: function(val, index) {
            //         return val.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });
            //     }
            }
        },
        xaxis:{
            // categories: {!! $hari !!}
            categories: ["Jan", "Feb", "Mar", "Apr" , "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"]
        },
        plotOptions: {
            bar: {
                dataLabels: {
                position: 'top'
                }
            }
        },
    }).render();


    $('#pilihgrafik').on('change', function(){
      let grafik = $(this).children(':selected').val();

      if(grafik == 'BULANAN'){
        $('#bulanan').addClass('block');
        $('#bulanan').removeClass('hidden');

        $('#harian').removeClass('block');
        $('#harian').addClass('hidden');
      } else {
        $('#bulanan').addClass('hidden');
        $('#bulanan').removeClass('block');

        $('#harian').removeClass('hidden');
        $('#harian').addClass('block');
      }

    });
});

</script>

@endpush
@endsection