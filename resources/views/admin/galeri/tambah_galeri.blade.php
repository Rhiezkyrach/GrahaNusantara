@extends('admin.layouts.header')

@section('admincontent')

<!-- main Container -->
<div class="w-full h-auto bg-white px-5 my-20 md:mx-8 md:mt-5 md:mb-14">
  <div class="flex flex-row items-center justify-between">
    <div class="md:text-2xl font-semibold">Tambah Berita Foto</div>
    <a href="/" target="_blank">
      <div class="text-xxs -mt-px font-semibold text-white bg-red-500 hover:bg-red-600 py-2 px-3 rounded-full inline-block align-middle">Kunjungi Situs <i class="fas fa-external-link-alt"></i></div>
    </a>
  </div>
  <div class="mt-5 w-full h-px bg-gray-200 rounded-full"></div>

  {{-- main content --}}

  <div class="flex flex-col mt-5 bg-gray-100 p-4 h-auto w-full rounded-lg">

    <form method="post" action="/admin/galeri" enctype="multipart/form-data">
    @csrf

    {{-- Kategori --}}
    <div class="flex flex-col md:flex-row items-center">
      <div class="w-full md:w-2/12 font-semibold">Kategori</div>
       <div class="flex flex-col w-full md:w-5/12">
        <select id="id_channel" name="id_channel" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" required disabled>
          <option class="text-gray-500 "value="">Pilih Kategori</option>
          <option value="{{ $kategoriGaleri->id }}" selected>{{ $kategoriGaleri->nama }}</option>
          {{-- @foreach($kategori as $kt)
            @if(old('id_channel') == $kt->id)
            <option value="{{ $kt->id }}" selected>{{ $kt->nama }}</option>
            @else
            <option value="{{ $kt->id }}">{{ $kt->nama }}</option>
            @endif
          @endforeach --}}
        </select>
        @error('id_channel')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Kategori --}}

    {{-- Judul Atas --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Judul Atas</div>
      <div class="flex flex-col w-full md:w-8/12">
        <input type="text" id="judul_atas" name="judul_atas" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Judul Atas" value="{{ old('judul_atas') }}" autocomplete="off">
          @error('judul_atas')
            <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>
      </div>
    {{-- /Judul Atas--}}

    {{-- Judul --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Judul</div>
      <div class="flex flex-col w-full md:w-8/12">
        <input type="text" id="judul" name="judul" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Judul (Panjang Maks. 80 Karakter)" value="{{ old('judul') }}" autocomplete="off" required>
          @error('judul')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Judul --}}

    {{-- Sub Judul --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Sub Judul</div>
      <div class="flex flex-col w-full md:w-8/12">
        <input type="text" id="sub_judul" name="sub_judul" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Sub Judul" value="{{ old('sub_judul') }}" autocomplete="off">
          @error('sub_judul')
            <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>
      </div>
    {{-- /Sub Judul --}}

    {{-- Isi --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Isi</div>
      <div class="flex flex-col w-full md:w-10/12">
        <div class="mt-1 md:mt-0 w-full">
          <textarea id="isi" name="isi" required>{{ old('isi', $isi) }}</textarea>
        </div>
        @error('isi')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Isi --}}

    {{-- Tag --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Tag</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="text" id="tag" name="tag" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Tag (pisahkan dengan koma)" value="{{ old('tag') }}" autocomplete="off" required>
        @error('tag')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Tag --}}

    {{-- Redaktur --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Redaktur</div>
      <input type="text" id="penulis" name="penulis" class="mt-1 md:mt-0 w-full md:w-5/12 p-2 border border-gray-400 rounded-md" placeholder="{{ auth()->user()->nama }}" value="{{ old('penulis') }}" autocomplete="off" disabled>
    </div>
    {{-- /Redaktur --}}

    {{-- Oleh --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Oleh</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="text" id="oleh" name="oleh" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Penulis" value="{{ old('oleh') }}" autocomplete="off">
        @error('oleh')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Oleh --}}

    {{-- Wartawan --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Wartawan</div>
      <div class="flex flex-col w-full md:w-5/12">
        <select id="id_wartawan" name="id_wartawan" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" required>
          <option class="text-gray-500 "value="">Pilih Wartawan</option>
          @foreach($wartawan as $w)
            @if(old('id_wartawan') == $w->id_wartawan)
            <option value="{{ $w->id_wartawan }}" selected>{{ $w->nama_wartawan }}</option>
            @else
            <option value="{{ $w->id_wartawan }}">{{ $w->nama_wartawan }}</option>
            @endif
          @endforeach
        </select>
        @error('id_wartawan')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Wartawan --}}

    {{-- Gambar Utama--}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Gambar Utama</div>
      <div class="flex flex-col w-full md:w-5/12">
        <img class="img-preview mb-2 w-full max-h-64 object-cover overflow-hidden">
        <input type="file" id="gambar_detail" name="gambar_detail" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" onchange="previewGambar()" required>
        @error('gambar_detail')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Gambar Utama--}}

    {{-- Gambar Slide --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Gambar Slide</div>
      <div class="flex flex-col w-full md:w-5/12">
        <div class="images-preview mb-2 w-full h-auto object-cover overflow-hidden"></div>
        <input type="file" id="nama_photo" name="nama_photo[]" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" required multiple>
        @error('nama_photo')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Gambar Slide --}}

    {{-- Caption --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Caption Foto</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="text" id="caption" name="caption" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Caption Gambar" value="{{ old('caption') }}" autocomplete="off" required>
        @error('caption')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Caption --}}

    {{-- Embed --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Kode Embed</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="text" id="kode_embed" name="kode_embed" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Embed Instagram/Twitter/Youtube" value="{{ old('kode_embed') }}" autocomplete="off">
        @error('kode_embed')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Embed --}}

    {{-- Headline --}}
    <div class="flex flex-col md:flex-row mt-3">
      <div class="w-full md:w-2/12 font-semibold">Headline</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="hidden" id="headline" name="headline" value="0">
        <input type="checkbox" id="headline" name="headline" value="1" class="mt-[5px] w-4 h-4">
        @error('headline')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Headline --}}

    {{-- Tanggal Tayang --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Tanggal Tayang</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="date" id="tanggal_tayang" name="tanggal_tayang" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" value="{{ old('tanggal_tayang', Carbon\Carbon::now()->translatedFormat('Y-m-d')) }}" autocomplete="off" required>
        @error('tanggal_tayang')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Tanggal Tayang --}}

    {{-- Jam Tayang --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Jam Tayang</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="text" id="waktu" name="waktu" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" value="{{ old('waktu', Carbon\Carbon::now()->translatedFormat('H:i')) }}" autocomplete="off" required>
        @error('waktu')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Jam Tayang --}}

    {{-- Publish --}}
    <div class="flex flex-col md:flex-row mt-3">
      <div class="w-full md:w-2/12 font-semibold">Publish</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="hidden" id="publish" name="publish" value="0">
        <input type="checkbox" id="publish" name="publish" value="1" class="mt-[5px] w-4 h-4">
      @error('publish')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Publish --}}

    {{-- Submit --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold"></div>
      <div class="flex flex-col md:flex-row w-full md:w-10/12 divide-x gap-2">
        <button type="submit" class="bg-green-600 hover:bg-green-700 py-2 w-full md:w-1/2 text-white text-center font-semibold rounded-lg"><i class="fas fa-save"></i> Simpan</button>
        <a href="/admin/berita" class="bg-red-500 hover:bg-red-700 py-2 w-full md:w-1/2 text-white text-center font-semibold rounded-lg"><i class="far fa-list-alt"></i> Kembali ke Tabel</a>
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
  const image = document.querySelector('#gambar_detail');
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