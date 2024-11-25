@extends('admin.layouts.header')

@section('admincontent')

<!-- main Container -->
<x-main-container title="Tambah Berita" url="{{ $setting && $setting->Network ? $setting->Network->url : url('/') }}">

  {{-- main content --}}
  <div class="flex flex-col mt-5 bg-gray-200 p-4 h-auto w-full rounded-lg">
    <form method="post" action="/admin/berita" enctype="multipart/form-data">
    @csrf
    
      <div class="w-full h-auto px-2 py-2 border border-green-500 rounded-md itemrow bg-green-100/25">
        <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-green-500 text-white">ISI BERITA</span></div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-2.5">

          {{-- KATEGORI --}}
          <div class="bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputid_kategori"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">KATEGORI</span></label>
              <select id="inputid_kategori" name="id_kategori" class="select2 main_input_md" required>
                <option class="text-gray-500 "value=""></option>
                @foreach($kategori as $kt)
                  <option value="{{ $kt->id }}" @selected(old('id_kategori') == $kt->id)>{{ $kt->nama }}</option>
                @endforeach
              </select>
              @error('id_kategori') <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div> @enderror
          </div>

          {{-- FOKUS --}}
          <div class="bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputid_fokus"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">FOKUS</span></label>
              <select id="inputid_fokus" name="id_fokus" class="select2 main_input_md">
                <option class="text-gray-500 "value=""></option>
                @foreach($fokus as $f)
                  <option value="{{ $f->id }}" @selected(old('id_fokus') == $f->id)>{{ $f->nama }}</option>
                @endforeach
              </select>
              @error('id_fokus') <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div> @enderror
          </div>

          {{-- JUDUL ATAS --}}
          <div class="md:col-span-2 bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputjudul_atas"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">JUDUL ATAS</span></label>
            <input type="text" id="inputjudul_atas" name="judul_atas" class="main_input_md" placeholder="Judul Atas" value="{{ old('judul_atas') }}" autocomplete="off">
              @error('judul_atas') <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>@enderror
          </div>

          {{-- JUDUL --}}
          <div class="md:col-span-4 bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputjudul"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">JUDUL</span></label>
            <input type="text" id="inputjudul" name="judul" class="main_input_md" placeholder="Judul (Panjang Maks. 80 Karakter)" value="{{ old('judul') }}" autocomplete="off" required>
              @error('judul')<div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>@enderror
          </div>

          {{-- SUB JUDUL --}}
          <div class="md:col-span-4 bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputsub_judul"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">SUB JUDUL</span></label>
            <input type="text" id="inputsub_judul" name="sub_judul" class="main_input_md" placeholder="Sub Judul" value="{{ old('sub_judul') }}" autocomplete="off">
              @error('sub_judul')<div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>@enderror
          </div>

          {{-- ISI --}}
          <div class="md:col-span-4 bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="isi"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">ISI</span></label>
            <textarea id="isi" name="isi" required>{{ old('isi', $isi) }}</textarea>
              @error('isi')<div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>@enderror
          </div>

          {{-- TAG --}}
          <div class="md:col-span-4 bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputtag"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">TAG</span></label>
            <input type="text" id="inputtag" name="tag" class="main_input_md" placeholder="Tag (pisahkan dengan koma)" value="{{ old('tag') }}" autocomplete="off" required>
              @error('tag')<div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>@enderror
          </div>
          {{-- /Tag --}}

        </div>
      </div>

      <div class="divider"></div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-2.5 md:gap-3">
        
        <div class="w-full h-auto px-2 py-2 border border-green-500 rounded-md itemrow bg-green-100/25">
          <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-green-500 text-white">GAMBAR</span></div>
          
          <div class="grid grid-cols-1 gap-2.5">

            {{-- GAMBAR --}}
            <div class="relative bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputgambar_detail"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">GAMBAR</span></label>
                <img class="img-preview mb-2 w-full h-60 object-cover overflow-hidden" src="{{ asset('images/img-default.png') }}">
                <button id="cancelImageButton" type="button" class="hidden absolute top-0 right-0 mt-6 px-2 py-1 bg-red-600 text-xs text-white"><i class="fa-solid fa-trash"></i></button>
                {{-- SELECT FROM FILE MANAGER --}}
                <input type="hidden" id="inputgambar_detail_copy" name="gambar_detail_copy">
                {{-- FILE UPLOAD --}}
                <div id="inputgambar_detail_container">
                  <input type="file" id="inputgambar_detail" name="gambar_detail" class="hidden w-full file-input file-input-bordered">
                </div>
                  @error('gambar_detail') <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>@enderror
                <button type="button" id="selectImageButton" class="w-full btn btn-primary">PILIH GAMBAR</button>
            </div>

            {{-- CAPTION --}}
            <div class="bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputcaption"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">CAPTION</span></label>
                <textarea id="inputcaption" name="caption" class="main_input_md" placeholder="Caption Gambar" rows="5" autocomplete="off" required>{{ old('caption') }}</textarea>
                @error('caption')<div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>@enderror
            </div>

          </div>

        </div>

        <div class="w-full h-auto px-2 py-2 border border-green-500 rounded-md itemrow bg-green-100/25">
          <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-green-500 text-white">WARTAWAN</span></div>
          
          <div class="grid grid-cols-1 gap-2.5">

            {{-- WARTAWAN --}}
            <div class="bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputid_wartawan"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">WARTAWAN</span></label>
              @if(auth()->user()->level == 'wartawan')
                <input type="text" id="inputid_wartawan" name="id_wartawan" class="hidden" value="{{ auth()->user()->Reporter ? auth()->user()->Reporter->id_wartawan : '' }}" autocomplete="off" readonly>
                <input type="text" id="inputid_wartawan_nama" name="id_wartawan_nama" class="main_input_md" value="{{ auth()->user()->Reporter ? auth()->user()->Reporter->nama_wartawan : '' }}" autocomplete="off" readonly>
              @else
              <select id="inputid_wartawan" name="id_wartawan" class="select2 main_input_md" required>
                <option class="text-gray-500 "value="">Pilih Wartawan</option>
                @foreach($wartawan as $w)
                <option value="{{ $w->id_wartawan }}" @selected(old('id_wartawan') == $w->id_wartawan)>{{ $w->nama_wartawan }}</option>
                @endforeach
              </select>
              @endif
                @error('id_wartawan')<div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>@enderror
            </div>

            {{-- REDAKTUR --}}
            <div class="bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputpenulis"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">REDAKTUR</span></label>
              <input type="text" id="inputpenulis" name="penulis" class="main_input_md" placeholder="{{ auth()->user()->name }}" value="{{ old('penulis') }}" autocomplete="off" readonly>
                @error('penulis')<div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>@enderror
            </div>

            <div class="divider my-1 text-xs"><i class="fa-solid fa-angles-down"></i> Isi Untuk Artikel Opini <i class="fa-solid fa-angles-down"></i></div>

            {{-- <div class="grid grid-cols-3 gap-2.5"> --}}
              <div class="relative my-1 flex w-full">
                <div class="mx-auto w-32 h-32 rounded-full overflow-hidden border-2 border-gray-400">
                  <img class="penulis-preview mb-2 w-full h-full object-cover" src="{{ asset('images/profile-default.png') }}">
                  <button id="cancelImagePenulisButton" type="button" class="hidden absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 mt-10 px-2 py-1 bg-red-600 text-xs text-white rounded"><i class="fa-solid fa-trash"></i></button>
                </div>
              </div>

              {{-- <div class="col-span-2 grid grid-cols-1 gap-2.5"> --}}
                {{-- OLEH --}}
                <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                  <label class="mb-1" for="inputoleh"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">OLEH</span></label>
                    <input type="text" id="inputoleh" name="oleh" class="main_input_md" placeholder="Penulis" value="{{ old('oleh') }}" autocomplete="off">
                      @error('oleh')<div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>@enderror
                </div>

                {{-- FOTO PENULIS --}}
                <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                  <label class="mb-1" for="inputfoto_penulis"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">FOTO PENULIS</span></label>
                    <div id="inputgambar_penulis_container">
                      <input type="file" id="inputfoto_penulis" name="foto_penulis" class="w-full file-input file-input-bordered">
                    </div>
                    @error('foto_penulis')<div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>@enderror
                </div>
              {{-- </div> --}}

            {{-- </div> --}}

          </div>
        </div>


        <div class="grid grid-cols-1 gap-2.5">

          <div class="w-full h-auto px-2 py-2 border border-green-500 rounded-md itemrow bg-green-100/25">
            <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-green-500 text-white">EMBED</span></div>
            
            <div class="grid grid-cols-1 gap-2.5">

              {{-- URL VIDEO --}}
              <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputvideo"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">URL VIDEO</span></label>
                <input type="text" id="inputvideo" name="video" class="main_input_md" placeholder="URL Video" value="{{ old('video') }}" autocomplete="off">
                  @error('video')<div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>@enderror
              </div>

              {{-- KODE EMBED --}}
              <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputvideo"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">KODE EMBED</span></label>
                <input type="text" id="kode_embed" name="kode_embed" class="main_input_md" placeholder="Embed Instagram/Twitter/Youtube" value="{{ old('kode_embed') }}" autocomplete="off">
                  @error('kode_embed') <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>@enderror
              </div>

            </div>

          </div>

          <div class="divider my-2"></div>

          <div class="w-full h-auto px-2 py-2 border border-green-500 rounded-md itemrow bg-green-100/25">
            <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-green-500 text-white">PUBLISH</span></div>
            
            <div class="grid grid-cols-1 gap-2.5">

              {{-- TANGGAL TAYANG --}}
              <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputtanggal_tayang"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">TANGGAL TAYANG</span></label>
                <input type="date" id="inputtanggal_tayang" name="tanggal_tayang" class="main_input_md" value="{{ old('tanggal_tayang', Carbon\Carbon::now()->translatedFormat('Y-m-d')) }}" autocomplete="off" required>
                  @error('tanggal_tayang')<div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>@enderror
              </div>

              {{-- JAM TAYANG --}}
              <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputwaktu"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">JAM TAYANG</span></label>
                <input type="time" id="inputwaktu" name="waktu" class="main_input_md" value="{{ old('waktu', Carbon\Carbon::now()->translatedFormat('H:i')) }}" autocomplete="off" required>
                  @error('waktu') <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>@enderror
              </div>

              {{-- HEADLINE --}}
              <div class="form-control bg-slate-300 px-2 rounded">
                <label class="label cursor-pointer">
                  <span class="label-text font-semibold">HEADLINE</span>
                  <input type="hidden" id="headline" name="headline" value="0">
                  <input type="checkbox" id="headline" name="headline" value="1" class="checkbox checkbox-primary" />
                  @error('headline')<div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>@enderror
                </label>
              </div>

              {{-- PUBLISH --}}
              
              <div class="form-control bg-slate-300 px-2 rounded">
                <label class="label cursor-pointer">
                  <span class="label-text font-semibold">PUBLISH</span>
                  <input type="hidden" id="publish" name="publish" value="0">
                  <input type="checkbox" id="publish" name="publish" value="1" class="checkbox checkbox-primary" @if(auth()->user()->level == 'wartawan') disabled @endif/>
                  @error('publish')<div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>@enderror
                </label>
              </div>

            </div>
          </div>
        
        </div>

      </div>
      
      <div class="flex mt-2">
        <x-back-button url="{{ url('/admin/berita') }}">Kembali</x-back-button>
        <x-submit-button>Simpan</x-submit-button>
      </div>

    </form>
  </div>
  {{-- /main content --}}

</x-main-container>
<!-- /Main Container -->

<!-- Modal -->
<x-modals class="max-w-4xl">
    <x-slot:inputid>modal-container</x-slot:inputid>
    <x-slot:modalid>modal-content</x-slot:modalid>
    <div id="modal-ajax">
        @livewire('file-manager')
    </div>
</x-modals>

@push('js')
<script>
$(document).ready(function () {
  // CKEditor
  ClassicEditor.create( document.querySelector( '#isi' ), {
      simpleUpload: {
          uploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}"
      },
      image: {
          toolbar: [ 'toggleImageCaption', 'imageTextAlternative', 'ckboxImageEdit' ]
      }
  })
  .then( editor => {
  } )
  .catch( error => {
      console.error( error );
  } );

  // Select 2
  $('.select2').select2({
    placeholder: 'Pilih'
  });

  //selectImageButton
  $(document).on('click', '#selectImageButton', function (event) {
      event.preventDefault();

      $('#modal-container').prop('checked',true);

      $(document).on('click', '.selectimage', function (){
        let image = $(this).data('gambar');
        let url_image = "{{ asset('storage') }}" + '/' + image;

        $('#inputgambar_detail_copy').val(image)
        $('#modal-container').prop('checked', false);
        $('.img-preview').attr('src', url_image);
        $('#cancelImageButton').removeClass('hidden');

      });

  });
      
  // Preview Gambar Detail
  $(document).on('change', '#inputgambar_detail', function() {
      const file = this.files[0];

      if (file) {
          let reader = new FileReader();
          reader.onload = function(event) {
              $('.img-preview').attr('src', event.target.result);
          }
          reader.readAsDataURL(file);

          // Close Modal
          $('#modal-container').prop('checked', false);
          $('#cancelImageButton').removeClass('hidden');
      }
  });

  // Preview Foto Penulis
  $(document).on('change', '#inputfoto_penulis', function() {
      const file = this.files[0];

      if (file) {
          let reader = new FileReader();
          reader.onload = function(event) {
              $('.penulis-preview').attr('src', event.target.result);
          }
          reader.readAsDataURL(file);

          $('#cancelImagePenulisButton').removeClass('hidden')
      }
  });

  // Cancel Detail Image Input
  $('#cancelImageButton').on('click', function(){
    // reset preview
    $('#inputgambar_detail_copy').val('')
    $('.img-preview').attr('src', "{{ asset('images/img-default.png') }}");
    $('#cancelImageButton').addClass('hidden');

    // remove gambar_detail file input
    $('#inputgambar_detail').remove();
    $('#inputgambar_detail_container').append(`<input type="file" id="inputgambar_detail" name="gambar_detail" class="hidden w-full file-input file-input-bordered">`);
  });

  // Cancel Foto Penulis
  $('#cancelImagePenulisButton').on('click', function(){
    // reset preview
    $('.penulis-preview').attr('src', "{{ asset('images/profile-default.png') }}");
    $('#cancelImagePenulisButton').addClass('hidden');

    // remove gambar_detail file input
    $('#inputfoto_penulis').remove();
    $('#inputgambar_penulis_container').append(`<input type="file" id="inputfoto_penulis" name="foto_penulis" class="w-full file-input file-input-bordered">`);
  });

});

</script>
@endpush
@endsection