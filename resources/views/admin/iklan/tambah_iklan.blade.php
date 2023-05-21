@extends('admin.layouts.header')

@section('admincontent')

<!-- main Container -->
<div class="w-full h-auto bg-white px-5 my-20 md:mx-8 md:mt-5 md:mb-14">
  <div class="flex flex-row items-center justify-between">
    <div class="md:text-2xl font-semibold">Tambah Iklan</div>
    <a href="/" target="_blank">
      <div class="text-xxs -mt-px font-semibold text-white bg-red-500 hover:bg-red-600 py-2 px-3 rounded-full inline-block align-middle">Kunjungi Situs <i class="fas fa-external-link-alt"></i></div>
    </a>
  </div>
  <div class="mt-5 w-full h-px bg-gray-200 rounded-full"></div>

  {{-- main content --}}

  <div class="flex flex-col mt-5 bg-gray-100 p-4 h-auto w-full rounded-lg">

    <form method="post" action="/admin/iklan" enctype="multipart/form-data">
    @csrf

    {{-- Nama Iklan --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Nama Iklan</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="text" id="nama" name="nama" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Nama Iklan" value="{{ old('nama') }}" autocomplete="off" required>
          @error('nama')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Nama Iklan --}}

    {{-- Jenis --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Jenis Iklan</div>
      <div class="flex flex-col w-full md:w-5/12">
        <select id="jenis" name="jenis" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" required>
          @foreach($jenisIklan as $jenis)
          <option value="{{ $jenis }}">{{ $jenis }}</option>
          @endforeach
        </select>
          @error('jenis')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Jenis --}}

    {{-- Posisi --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Posisi Iklan <a href="{{ asset('images/guide_iklan.jpg') }}" target="_blank"><i class="fa-solid fa-circle-question text-blue-500 hover:text-blue-700"></i></a></div>
      <div class="flex flex-col w-full md:w-5/12">
        <select id="posisi" name="posisi" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" required>
          @foreach($posisiIklan as $posisi)
          <option value="{{ $posisi }}">{{ $posisi }}</option>
          @endforeach
        </select>
          @error('posisi')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Posisi --}}

    {{-- Status --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Status</div>
      <div class="flex flex-col w-full md:w-5/12">
        <select id="status" name="status" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" required>
          <option value="1">Aktif</option>
          <option value="0">Tidak Aktif</option>
        </select>
          @error('status')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Status --}}

    {{-- Foto --}}
    <div class="flex flex-col md:flex-row mt-2 items-center">
      <div class="w-full md:w-2/12 font-semibold">Gambar</div>
      <div class="flex flex-col w-full md:w-5/12">
        <img class="img-preview mb-2 w-full max-h-auto  object-cover overflow-hidden">
        <input type="file" id="foto" name="foto" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" onchange="previewGambar()">
        @error('foto')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Foto --}}

    {{-- Kode --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Kode</div>
      <div class="flex flex-col w-full md:w-10/12">
          <textarea id="kode" name="kode" class="my-1 p-2 w-full md:w-6/12 h-28 border border-gray-400 rounded-md">{{ old('kode') }}</textarea>
        @error('kode')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Kode --}}

    {{--Link --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Link</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="text" id="link" name="link" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Link" value="{{ old('link') }}" autocomplete="off">
          @error('link')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Link --}}

    {{--AE --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">AE</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="text" id="AE" name="AE" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Account Executive" value="{{ old('AE') }}" autocomplete="off">
          @error('AE')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /AE --}}

    {{-- Urutan --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Urutan</div>
      <div class="flex flex-col w-full md:w-5/12">
        <select id="urutan" name="urutan" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" required>
          @for($i=1; $i <=10; $i++)
          <option value="{{ $i }}">{{  $i }}</option>
          @endfor
        </select>
          @error('urutan')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Urutan --}}

    {{-- Awal Tayang --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Awal Tayang</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="date" id="awal_tayang" name="awal_tayang" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" value="{{ Carbon\Carbon::now()->translatedFormat('Y-m-d') }}" autocomplete="off" required>
        @error('awal_tayang')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Awal Tayang --}}

    {{-- Akhir Tayang --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Akhir Tayang</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="date" id="akhir_tayang" name="akhir_tayang" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" value="{{ Carbon\Carbon::now()->translatedFormat('Y-m-d') }}" autocomplete="off" required>
        @error('awal_tayang')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Akhir Tayang --}}

    {{-- Submit --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold"></div>
      <div class="flex flex-col md:flex-row w-full md:w-5/12 divide-x gap-2">
        <button type="submit" class="bg-green-600 hover:bg-green-700 py-2 w-full md:w-1/2 text-white text-center font-semibold rounded-lg"><i class="fas fa-save"></i> Simpan</button>
        <a href="/admin/iklan" class="bg-red-500 hover:bg-red-700 py-2 w-full md:w-1/2 text-white text-center font-semibold rounded-lg"><i class="far fa-list-alt"></i> Kembali ke Tabel</a>
      </div>
    </div>
    {{-- /Submit --}}

    </form>

  </div>

  {{-- /main content --}}

</div>
<!-- /Main Container -->

<script>
  function previewGambar(){
      const image = document.querySelector('#foto');
      const imgPreview = document.querySelector('.img-preview');
      
      imgPreview.style.display = 'block';

      const oFReader = new FileReader();
      oFReader.readAsDataURL(image.files[0]);

      oFReader.onload = function(oFREvent){
        imgPreview.src = oFREvent.target.result;
      }

  }
</script>

@endsection