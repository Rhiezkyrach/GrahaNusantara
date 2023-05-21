@extends('admin.layouts.header')

@section('admincontent')

<!-- main Container -->
<div class="w-full h-auto bg-white px-5 my-20 md:mx-8 md:mt-5 md:mb-14">
  <div class="flex flex-row items-center justify-between">
    <div class="md:text-2xl font-semibold">Edit Berita</div>
    <a href="/" target="_blank">
      <div class="text-xxs -mt-px font-semibold text-white bg-red-500 hover:bg-red-600 py-2 px-3 rounded-full inline-block align-middle">Kunjungi Situs <i class="fas fa-external-link-alt"></i></div>
    </a>
  </div>
  <div class="mt-5 w-full h-px bg-gray-200 rounded-full"></div>

  {{-- main content --}}
  <div class="flex flex-col mt-5 bg-gray-100 p-4 h-auto w-full rounded-lg">

    <form method="post" action="/admin/epaper/{{ $epaper->slug }}" enctype="multipart/form-data">
    @method('put')
    @csrf

    {{-- Edisi --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Edisi</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="date" id="edisi" name="edisi" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" value="{{ old('edisi', Carbon\Carbon::now()->parse($epaper->edisi)->translatedFormat('Y-m-d')) }}" autocomplete="off" required>
        @error('edisi')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Edisi --}}

    {{-- Cover PDF --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Cover</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="hidden" name="coverLama" value="{{ $epaper->cover }}">
        @if($epaper->cover)
        <img src="{{ asset('storage/'. $epaper->cover) }}" class="img-preview mb-2 w-full object-cover overflow-hidden">
        @else
        <img class="img-preview mb-2 w-full object-cover overflow-hidden">
        @endif
        <input type="file" id="cover" name="cover" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" onchange="previewGambar()">
        @error('cover')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Cover PDF --}}

    {{-- File PDF --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">File PDF</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="hidden" name="pdfLama" value="{{ $epaper->pdf }}">
        @if($epaper->pdf)
        <p class="font-semibold mb-1">file: {{ $epaper->pdf }}</p>
        @endif
        <input type="file" id="pdf" name="pdf" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md">
        @error('pdf')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /File PDF --}}

    {{-- Submit --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold"></div>
      <div class="flex flex-col md:flex-row w-full md:w-10/12 divide-x gap-2">
        <button type="submit" class="bg-green-600 hover:bg-green-700 py-2 w-full md:w-1/2 text-white text-center font-semibold rounded-lg"><i class="fas fa-save"></i> Simpan</button>
        <a href="/admin/epaper" class="bg-red-500 hover:bg-red-700 py-2 w-full md:w-1/2 text-white text-center font-semibold rounded-lg"><i class="far fa-list-alt"></i> Kembali ke Tabel</a>
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

function previewGambar(){
  const image = document.querySelector('#cover');
  const imgPreview = document.querySelector('.img-preview');
  
  imgPreview.style.display = 'block';

  const oFReader = new FileReader();
  oFReader.readAsDataURL(image.files[0]);

  oFReader.onload = function(oFREvent){
    imgPreview.src = oFREvent.target.result;
  }

}

$(function() {
// Multiple images preview with JavaScript
var previewImages = function(input, imgPreviewPlaceholder) {
if (input.files) {
var filesAmount = input.files.length;
for (i = 0; i < filesAmount; i++) {
var reader = new FileReader();
reader.onload = function(event) {
$($.parseHTML('<img>')).attr('src', event.target.result).attr('class', 'py-2 w-full max-h-64 object-cover overflow-hidden').appendTo(imgPreviewPlaceholder);
}
reader.readAsDataURL(input.files[i]);
}
}
};
$('#nama_photo').on('change', function() {
previewImages(this, 'div.images-preview');
});
});
</script>
@endsection