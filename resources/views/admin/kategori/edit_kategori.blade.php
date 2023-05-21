@extends('admin.layouts.header')

@section('admincontent')

<!-- main Container -->
<div class="w-full h-auto bg-white px-5 my-20 md:mx-8 md:mt-5 md:mb-14">
  <div class="flex flex-row items-center justify-between">
    <div class="md:text-2xl font-semibold">Edit Kategori</div>
    <a href="/" target="_blank">
      <div class="text-xxs -mt-px font-semibold text-white bg-red-500 hover:bg-red-600 py-2 px-3 rounded-full inline-block align-middle">Kunjungi Situs <i class="fas fa-external-link-alt"></i></div>
    </a>
  </div>
  <div class="mt-5 w-full h-px bg-gray-200 rounded-full"></div>

  {{-- main content --}}
  <div class="flex flex-col mt-5 bg-gray-100 p-4 h-auto w-full rounded-lg">

    <form method="post" action="/admin/kategori/{{ $kategori->slug }}">
    @method('put')
    @csrf

    {{-- Nama Kategori --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Nama Kategori</div>
      <div class="flex flex-col w-full md:w-6/12">
        <input type="text" id="nama" name="nama" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Nama Kategori" value="{{ old('nama', $kategori->nama) }}" autocomplete="off" required>
          @error('nama')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Nama Kategori --}}

    {{-- Status --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Status</div>
      <div class="flex flex-col w-full md:w-6/12">
        <select id="status" name="status" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" required>
          @if(old('status', $kategori->status) == 1)
            <option value="1" Selected>Aktif</option>
            <option value="0">Tidak Aktif</option>
          @else
            <option value="0" Selected>Tidak Aktif</option>
            <option value="1">Aktif</option>
          @endif           
        </select>
          @error('status')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Status --}}
    
    {{-- Navigasi --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Navigasi</div>
      <div class="flex flex-col w-full md:w-6/12">
        <select id="navigasi" name="navigasi" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" required>
          @if(old('navigasi', $kategori->navigasi) == 1)
            <option value="1" Selected>Aktif</option>
            <option value="0">Tidak Aktif</option>
          @else
            <option value="0" Selected>Tidak Aktif</option>
            <option value="1">Aktif</option>
          @endif           
        </select>
          @error('navigasi')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Navigasi --}}

    {{-- Urutan --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Urutan</div>
      <div class="flex flex-col w-full md:w-6/12">
        <select id="urutan" name="urutan" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" required>
            @if(old('urutan', $kategori->urutan == $kategori->urutan))
            <option class="text-white/0" value="{{ $kategori->urutan }}" selected>{{  $kategori->urutan }}</option>
              @for($i=1; $i <=10; $i++)
                <option value="{{ $i }}">{{  $i }}</option>
              @endfor
            @else
              @for($i=1; $i <=10; $i++)
                <option value="{{ $i }}">{{  $i }}</option>
              @endfor
            @endif         
        </select>
          @error('urutan')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Urutan --}}

    {{-- Submit --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold"></div>
      <div class="flex flex-col md:flex-row w-full md:w-6/12 divide-x gap-2">
        <button type="submit" class="bg-green-600 hover:bg-green-700 py-2 w-full md:w-1/2 text-white text-center font-semibold rounded-lg"><i class="fas fa-save"></i> Simpan</button>
        <a href="/admin/kategori" class="bg-red-500 hover:bg-red-700 py-2 w-full md:w-1/2 text-white text-center font-semibold rounded-lg"><i class="far fa-list-alt"></i> Kembali ke Tabel</a>
      </div>
    </div>
    {{-- /Submit --}}

    </form>

  </div>

  {{-- /main content --}}

</div>
<!-- /Main Container -->

@endsection