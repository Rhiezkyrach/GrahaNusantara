@extends('admin.layouts.header')

@section('admincontent')

<!-- main Container -->
<div class="w-full h-auto bg-white px-5 my-20 md:mx-8 md:mt-5 md:mb-14">
  <div class="flex flex-row items-center justify-between">
    <div class="md:text-2xl font-semibold">Tambah Halaman</div>
    <a href="/" target="_blank">
      <div class="text-xxs -mt-px font-semibold text-white bg-red-500 hover:bg-red-600 py-2 px-3 rounded-full inline-block align-middle">Kunjungi Situs <i class="fas fa-external-link-alt"></i></div>
    </a>
  </div>
  <div class="mt-5 w-full h-px bg-gray-200 rounded-full"></div>

  {{-- main content --}}

  <div class="flex flex-col mt-5 bg-gray-100 p-4 h-auto w-full rounded-lg">

    <form method="post" action="/admin/halaman" enctype="multipart/form-data">
    @csrf

    {{-- Judul Halaman --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Judul Halaman</div>
      <div class="flex flex-col w-full md:w-6/12">
        <input type="text" id="judul" name="judul" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Judul Halaman" value="{{ old('judul') }}" autocomplete="off" required>
          @error('judul')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Judul Halaman --}}

    {{-- Publish --}}
    {{-- <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Publish</div>
      <div class="flex flex-col w-full md:w-6/12">
        <select id="publish" name="publish" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" required>
          <option value="1">Aktif</option>
          <option value="0">Tidak Aktif</option>
        </select>
          @error('publish')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div> --}}
    {{-- /Publish --}}

    {{-- Urutan --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Urutan</div>
      <div class="flex flex-col w-full md:w-6/12">
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

    {{-- Isi --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Isi</div>
      <div class="flex flex-col w-full md:w-10/12">
        <div class="mt-1 md:mt-0 w-full">
          <textarea id="isi" name="isi">{{ old('isi') }}</textarea>
        </div>
        @error('isi')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Isi --}}

    {{-- Submit --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold"></div>
      <div class="flex flex-col md:flex-row w-full md:w-6/12 divide-x gap-2">
        <button type="submit" class="bg-green-600 hover:bg-green-700 py-2 w-full md:w-1/2 text-white text-center font-semibold rounded-lg"><i class="fas fa-save"></i> Simpan</button>
        <a href="/admin/halaman" class="bg-red-500 hover:bg-red-700 py-2 w-full md:w-1/2 text-white text-center font-semibold rounded-lg"><i class="far fa-list-alt"></i> Kembali ke Tabel</a>
      </div>
    </div>
    {{-- /Submit --}}

    </form>

  </div>

  {{-- /main content --}}

</div>
<!-- /Main Container -->

<script>
  // Editor
CKEDITOR.replace('isi', {
    filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
    filebrowserUploadMethod: 'form',
    forcePasteAsPlainText : true,
    removePlugins: 'pastefromword',
    allowedContent: {
            script: true,
            div: true,
            $1: {
                // This will set the default set of elements
                elements: CKEDITOR.dtd,
                attributes: true,
                styles: true,
                classes: true
            }
        }
});
</script>

@endsection