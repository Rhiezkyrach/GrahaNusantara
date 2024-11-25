@extends('admin.layouts.header')

@section('admincontent')

<!-- main Container -->
<x-main-container title="Edit Halaman" url="{{ $setting && $setting->Network ? $setting->Network->url : url('/') }}">

  {{-- main content --}}
  <div class="flex flex-col mt-5 bg-gray-200 p-4 h-auto w-full rounded-lg">

    <form method="post" action="/admin/halaman/{{ $halaman->slug }}" enctype="multipart/form-data">
      @csrf
      @method('put')

      <div class="w-full h-auto px-2 py-2 border border-amber-500 rounded-md itemrow bg-amber-100/25">
        <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-amber-500 text-white">EDIT HALAMAN</span></div>

        <div class="grid grid-cols-1 md:grid-cols-4 justify-start gap-2">
          {{-- JUDUL HALAMAN --}}
          <div class="md:col-span-2 bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputjudul_situs"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">JUDUL HALAMAN</span></label>
              <input type="text" id="inputjudul_situs" name="judul" class="main_input_md" placeholder="Judul Halaman" 
                value="{{ old('judul', $halaman->judul) }}" autocomplete="off" required>
                @error('judul') <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div> @enderror
          </div>

          {{-- URUTAN --}}
          <div class="bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputurutan"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">URUTAN</span></label>
              <select id="urutan" name="urutan" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" required>
                @for($i=1; $i <=10; $i++)
                <option value="{{ $i }}" @selected($halaman->urutan == $i)>{{  $i }}</option>
                @endfor
              </select>
              @error('urutan') <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div> @enderror
          </div>

          {{-- STATUS --}}
          <div class="bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputstatus"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">STATUS</span></label>
              <select id="inputstatus" name="status" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" required>
                <option value="0" @selected($halaman->status == '0')>Tidak Aktif</option>
                <option value="1" @selected($halaman->status == '1')>Aktif</option>
              </select>
              @error('status') <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div> @enderror
          </div>

          {{-- ISI --}}
          <div class="md:col-span-4 bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputisi"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">ISI</span></label>
            <textarea id="inputisi" name="isi">{{ old('isi', $halaman->isi) }}</textarea>
              @error('isi') <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div> @enderror
          </div>

        </div>
      </div>

    <div class="flex mt-2">
      <x-back-button url="{{ url('admin/halaman') }}">Kembali</x-back-button>
      <x-submit-button>Simpan</x-submit-button>
    </div>

    </form>

  </div>
  {{-- /main content --}}

</x-main-container>
<!-- /Main Container -->

@push('js')
<script>
$(document).ready(function () {
  ClassicEditor.create( document.querySelector( '#inputisi' ), {
      simpleUpload: {
          uploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}"
      },
      image: {
          toolbar: [ 'toggleImageCaption', 'imageTextAlternative', 'ckboxImageEdit' ]
      }
  })
  .then( editor => {
      // editor.ui.view.editable.element.style.height = '400px';
  })
  .catch( error => {
      console.error( error );
  });
});
</script>
@endpush
@endsection