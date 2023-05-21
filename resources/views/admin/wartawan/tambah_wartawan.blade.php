@extends('admin.layouts.header')

@section('admincontent')

<!-- main Container -->
<div class="w-full h-auto bg-white px-5 my-20 md:mx-8 md:mt-5 md:mb-14">
  <div class="flex flex-row items-center justify-between">
    <div class="md:text-2xl font-semibold">Tambah Wartawan</div>
    <a href="/" target="_blank">
      <div class="text-xxs -mt-px font-semibold text-white bg-red-500 hover:bg-red-600 py-2 px-3 rounded-full inline-block align-middle">Kunjungi Situs <i class="fas fa-external-link-alt"></i></div>
    </a>
  </div>
  <div class="mt-5 w-full h-px bg-gray-200 rounded-full"></div>

  {{-- main content --}}

  <div class="flex flex-col mt-5 bg-gray-100 p-4 h-auto w-full rounded-lg">

    <form method="post" action="/admin/wartawan" enctype="multipart/form-data">
    @csrf

    {{-- Nama Wartawan --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Nama</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="text" id="nama_wartawan" name="nama_wartawan" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Nama" value="{{ old('nama_wartawan') }}" autocomplete="off" required>
          @error('nama_wartawan')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Nama Wartawan --}}

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
      <div class="w-full md:w-2/12 font-semibold">Foto</div>
      <div class="flex flex-col w-full md:w-5/12">
        <img class="img-preview mb-2 w-32 max-h-32 rounded-full object-cover overflow-hidden">
        <input type="file" id="foto" name="foto" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" onchange="previewGambar()">
        @error('foto')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Foto --}}

    {{-- Submit --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold"></div>
      <div class="flex flex-col md:flex-row w-full md:w-5/12 divide-x gap-2">
        <button type="submit" class="bg-green-600 hover:bg-green-700 py-2 w-full md:w-1/2 text-white text-center font-semibold rounded-lg"><i class="fas fa-save"></i> Simpan</button>
        <a href="/admin/wartawan" class="bg-red-500 hover:bg-red-700 py-2 w-full md:w-1/2 text-white text-center font-semibold rounded-lg"><i class="far fa-list-alt"></i> Kembali ke Tabel</a>
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