@extends('admin.layouts.header')

@section('admincontent')

<!-- main Container -->
<x-main-container title="Pengaturan halaman">

  {{-- main content --}}
  <div class="flex flex-col mt-5 bg-gray-200 p-4 h-auto w-full rounded-lg">

    <form method="post" action="/admin/pengaturan/{{ $pengaturan->id }}" enctype="multipart/form-data">
    @method('put')
    @csrf

    <div class="w-full h-auto px-2 py-2 border border-blue-500 rounded-md itemrow bg-green-100/25">
        <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-blue-500 text-white">SETELAN SITUS</span></div>

        <div class="grid grid-cols-1 md:grid-cols-3 justify-start gap-2">
            {{-- NAMA SITUS --}}
            <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputjudul_situs"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">NAMA SITUS</span></label>
                <input type="text" id="inputjudul_situs" name="judul_situs" class="main_input_md"
                    value="{{ old('judul_situs', $pengaturan->judul_situs) }}" auto-complete="off" required>
            </div>

            {{-- TAGLINE --}}
            <div class="md:col-span-2 bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputtagline"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">TAGLINE</span></label>
                <input type="text" id="inputtagline" name="tagline" class="main_input_md"
                    value="{{ old('tagline', $pengaturan->tagline) }}" auto-complete="off" required>
            </div>

            {{-- DESKRIPSI --}}
            <div class="md:col-span-3 bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputdeskripsi"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">DESKRIPSI</span></label>
                <input type="text" id="inputdeskripsi" name="deskripsi" class="main_input_md"
                    value="{{ old('deskripsi', $pengaturan->deskripsi) }}" auto-complete="off" required>
            </div>

            {{-- COPYRIGHT --}}
            <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputcopyright"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">COPYRIGHT</span></label>
                <input type="text" id="inputcopyright" name="copyright" class="main_input_md"
                    value="{{ old('copyright', $pengaturan->copyright) }}" auto-complete="off" required>
            </div>

            {{-- KEYWORDS --}}
            <div class="md:col-span-2 bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputkeyword"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">KEYWORDS</span></label>
                <input type="text" id="inputkeyword" name="keyword" class="main_input_md"
                    value="{{ old('keyword', $pengaturan->keyword) }}" auto-complete="off" required>
            </div>

            {{-- LOGO --}}
            <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputlogo"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">LOGO</span></label>
                <div class="flex w-full h-32 mb-2 p-2 overflow-hidden rounded-md">
                    @if($pengaturan->logo)
                        <input name="logoLama" type="file" class="hidden" value="{{ $pengaturan->logo }}">
                        <img src="{{ asset('storage/'. $pengaturan->logo) }}" class="logo-preview w-full my-auto object-cover overflow-hidden">
                    @else
                        <img class="object-cover w-full h-full logo-preview" src="{{ asset('images/img-default.png') }}" alt="">
                    @endif
                </div>
                <input name="logo" id="inputlogo" type="file" class="w-full file-input file-input-bordered" accept="image/*">
                @error('logo')
                    <div class="text-xs text-red-600">{{ $message }}</div>
                @enderror
            </div>

            {{-- DARK LOGO --}}
            <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputdarklogo"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">DARK LOGO</span></label>
                <div class="flex w-full h-32 mb-2 p-2 overflow-hidden rounded-md">
                    @if($pengaturan->darklogo)
                        <input name="darklogoLama" type="file" class="hidden" value="{{ $pengaturan->darklogo }}">
                        <img src="{{ asset('storage/'. $pengaturan->darklogo) }}" class="darklogo-preview w-full my-auto object-cover overflow-hidden">
                    @else
                        <img class="object-cover w-full h-full darklogo-preview" src="{{ asset('images/img-default.png') }}" alt="">
                    @endif
                </div>
                <input name="darklogo" id="inputdarklogo" type="file" class="w-full file-input file-input-bordered" accept="image/*">
                @error('darklogo')
                    <div class="text-xs text-red-600">{{ $message }}</div>
                @enderror
            </div>

            {{-- FAVICON --}}
            <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputfavicon"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">FAVICON</span></label>
                <div class="flex w-full h-32 mb-2 p-2 overflow-hidden rounded-md">
                    @if($pengaturan->favicon)
                        <input name="faviconLama" type="file" class="hidden" value="{{ $pengaturan->favicon }}">
                        <img src="{{ asset('storage/'. $pengaturan->favicon) }}" class="favicon-preview w-full my-auto object-cover overflow-hidden">
                    @else
                        <img class="object-cover w-full h-full favicon-preview" src="{{ asset('images/img-default.png') }}" alt="">
                    @endif
                </div>
                <input name="favicon" id="inputfavicon" type="file" class="w-full file-input file-input-bordered" accept="image/x-icon">
                @error('favicon')
                    <div class="text-xs text-red-600">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="divider"></div>

    <div class="w-full h-auto px-2 py-2 border border-blue-500 rounded-md itemrow bg-green-100/25">
        <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-blue-500 text-white">ALAMAT, KONTAK & SOSIAL MEDIA</span></div>

        <div class="grid grid-cols-1 md:grid-cols-3 justify-start gap-2">
          {{-- ALAMAT --}}
          <div class="md:col-span-2 bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputalamat"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">ALAMAT</span></label>
              <input type="text" id="inputalamat" name="alamat" class="main_input_md"
                  value="{{ old('alamat', $pengaturan->alamat) }}" auto-complete="off" required>
          </div>

          {{-- TELEPON --}}
          <div class="bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputtelepon"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">TELEPON</span></label>
              <input type="text" id="inputtelepon" name="telepon" class="main_input_md"
                  value="{{ old('telepon', $pengaturan->telepon) }}" auto-complete="off" required>
          </div>

          {{-- GOOGLE MAP EMBED --}}
          <div class="md:col-span-2 bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputgoogle_map"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">GOOGLE MAP EMBED</span></label>
              <input type="text" id="inputgoogle_map" name="google_map" class="main_input_md"
                  value="{{ old('google_map', $pengaturan->google_map) }}" auto-complete="off">
          </div>

          {{-- EMAIL --}}
          <div class="bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputemail"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">EMAIL</span></label>
              <input type="text" id="inputemail" name="email" class="main_input_md"
                  value="{{ old('email', $pengaturan->email) }}" auto-complete="off" required>
          </div>

          {{-- FACEBOOK --}}
          <div class="bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputfacebook"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">FACEBOOK</span></label>
              <input type="text" id="inputfacebook" name="facebook" class="main_input_md"
                  value="{{ old('facebook', $pengaturan->facebook) }}" auto-complete="off" required>
          </div>

          {{-- INSTAGRAM --}}
          <div class="bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputinstagram"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">INSTAGRAM</span></label>
              <input type="text" id="inputinstagram" name="instagram" class="main_input_md"
                  value="{{ old('instagram', $pengaturan->instagram) }}" auto-complete="off" required>
          </div>

          {{-- TWITTER (X) --}}
          <div class="bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputtwitter"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">TWITTER (X)</span></label>
              <input type="text" id="inputtwitter" name="twitter" class="main_input_md"
                  value="{{ old('twitter', $pengaturan->twitter) }}" auto-complete="off" required>
          </div>

          {{-- TIKTOK --}}
          <div class="bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputtiktok"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">TIKTOK</span></label>
              <input type="text" id="inputtiktok" name="tiktok" class="main_input_md"
                  value="{{ old('tiktok', $pengaturan->tiktok) }}" auto-complete="off" required>
          </div>

          {{-- YOUTUBE --}}
          <div class="bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputyoutube"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">YOUTUBE</span></label>
              <input type="text" id="inputyoutube" name="youtube" class="main_input_md"
                  value="{{ old('youtube', $pengaturan->youtube) }}" auto-complete="off" required>
          </div>

          {{-- GOOGLE NEWS --}}
          <div class="bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputgoogle_news"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">GOOGLE NEWS</span></label>
              <input type="text" id="inputgoogle_news" name="google_news" class="main_input_md"
                  value="{{ old('google_news', $pengaturan->google_news) }}" auto-complete="off" required>
          </div>
        </div>
    </div>

    <div class="divider"></div>

    <div class="w-full h-auto px-2 py-2 border border-blue-500 rounded-md itemrow bg-green-100/25">
        <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-blue-500 text-white">PENGATURAN LANJUTAN</span></div>

        <div class="grid grid-cols-1 md:grid-cols-3 justify-start gap-2">
          {{-- HEAD CODE --}}
          <div class="md:col-span-3 bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputheadcode"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">HEAD CODE</span></label>
              <textarea name="headcode" class="w-full main_input_textarea" id="inputheadcode" rows="10" autocomplete="off">{{ old('headcode', $pengaturan->headcode) }}</textarea>
          </div>

          {{-- FOOTER CODE --}}
          <div class="md:col-span-3 bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputfootercode"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">FOOTER CODE</span></label>
              <textarea name="footercode" class="w-full main_input_textarea" id="inputfootercode" rows="10" autocomplete="off">{{ old('footercode', $pengaturan->footercode) }}</textarea>
          </div>

          {{-- GOOGLE API KEY --}}
          <div class="bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputgoogle_api_key"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">GOOGLE API KEY</span></label>
              <input type="text" id="inputgoogle_api_key" name="google_api_key" class="main_input_md"
                  value="{{ old('google_api_key', $pengaturan->google_api_key) }}" auto-complete="off">
          </div>

          {{-- WHATSAPP API KEY --}}
          <div class="bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputwhatsapp_api_key"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">WHATSAPP API KEY</span></label>
              <input type="text" id="inputwhatsapp_api_key" name="whatsapp_api_key" class="main_input_md"
                  value="{{ old('whatsapp_api_key', $pengaturan->google_api_key) }}" auto-complete="off">
          </div>

          {{-- OPEN AI API KEY --}}
          <div class="bg-gradient-to-b from-slate-300 rounded-lg">
              <label class="mb-1" for="inputopenai_api_key"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">OPEN AI API KEY</span></label>
              <input type="text" id="inputopenai_api_key" name="openai_api_key" class="main_input_md"
                  value="{{ old('openai_api_key', $pengaturan->openai_api_key) }}" auto-complete="off">
          </div>
        </div>
    </div>

    <div class="flex mt-2">
      {{-- <x-back-button url="{{ url('/') }}">Kembali</x-back-button> --}}
      <x-submit-button>Simpan</x-submit-button>
    </div>
    {{-- /Submit --}}

    </form>

  </div>
  {{-- /main content --}}

</x-main-container>
<!-- /Main Container -->

@push('js')
<script>
$(document).ready(function () {
    $('#inputlogo').change(function() {
        const file = this.files[0];
        // console.log(file);
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                // console.log(event.target.result);
                $('.logo-preview').attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    $('#inputdarklogo').change(function() {
        const file = this.files[0];
        // console.log(file);
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                // console.log(event.target.result);
                $('.darklogo-preview').attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    $('#inputfavicon').change(function() {
        const file = this.files[0];
        // console.log(file);
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                // console.log(event.target.result);
                $('.favicon-preview').attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush

@endsection