@extends('admin.layouts.header')

@section('admincontent')

<!-- main Container -->
<div class="w-full h-auto bg-white px-5 my-20 md:mx-8 md:mt-5 md:mb-14">
  <div class="flex flex-row items-center justify-between">
    <div class="md:text-2xl font-semibold">Pengaturan Halaman</div>
    <a href="/" target="_blank">
      <div class="text-xxs -mt-px font-semibold text-white bg-red-500 hover:bg-red-600 py-2 px-3 rounded-full inline-block align-middle">Kunjungi Situs <i class="fas fa-external-link-alt"></i></div>
    </a>
  </div>
  <div class="mt-5 w-full h-px bg-gray-200 rounded-full"></div>

  {{-- main content --}}
  
  <div class="flex flex-col mt-5 bg-gray-100 p-4 h-auto w-full rounded-lg">

    <form method="post" action="/admin/pengaturan/{{ $pengaturan->id }}" enctype="multipart/form-data">
    @method('put')
    @csrf

    {{-- Judul Situs --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Nama Situs</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="text" id="judul_situs" name="judul_situs" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Nama Situs" value="{{ old('judul_situs', $pengaturan->judul_situs) }}" autocomplete="off" required>
          @error('jusul_situs')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Judul Situs --}}

    {{-- Tagline --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Tagline</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="text" id="tagline" name="tagline" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Tagline" value="{{ old('tagline', $pengaturan->tagline) }}" autocomplete="off" required>
          @error('tagline')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Tagline --}}

    {{-- Deskripi --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Deskripsi</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="text" id="deskripsi" name="deskripsi" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Deskripsi" value="{{ old('deskripsi', $pengaturan->deskripsi) }}" autocomplete="off" required>
          @error('deskripsi')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Deskripsi --}}

    {{-- Logo --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Logo</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="hidden" name="logoLama" value="{{ $pengaturan->logo }}">
        @if($pengaturan->logo)
        <img src="{{ asset('storage/'. $pengaturan->logo) }}" class="logo-preview mb-2 w-full h-auto object-cover overflow-hidden">
        @else
        <img class="logo-preview mb-2 w-full h-auto object-cover overflow-hidden">
        @endif
        <input type="file" id="logo" name="logo" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" onchange="previewLogo()">
        @error('logo')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Logo --}}

    {{-- Dark Logo --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Dark Logo</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="hidden" name="darklogoLama" value="{{ $pengaturan->darklogo }}">
        @if($pengaturan->darklogo)
        <img src="{{ asset('storage/'. $pengaturan->darklogo) }}" class="darklogo-preview mb-2 w-full h-auto object-cover overflow-hidden">
        @else
        <img class="darklogo-preview mb-2 w-full h-auto object-cover overflow-hidden">
        @endif
        <input type="file" id="darklogo" name="darklogo" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" onchange="previewDarkLogo()">
        @error('darklogo')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Dark Logo --}}

    {{-- Head Kode --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Head Code</div>
      <div class="flex flex-col w-full md:w-10/12">
          <textarea id="headcode" name="headcode" class="my-1 p-2 w-full md:w-6/12 h-28 border border-gray-400 rounded-md">{{ old('headcode', $pengaturan->headcode) }}</textarea>
        @error('headcode')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Head Kode --}}

    {{-- Footer Kode --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Footer Code</div>
      <div class="flex flex-col w-full md:w-10/12">
          <textarea id="footercode" name="footercode" class="my-1 p-2 w-full md:w-6/12 h-28 border border-gray-400 rounded-md">{{ old('footercode', $pengaturan->footercode) }}</textarea>
        @error('footercode')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
        @enderror
      </div>
    </div>
    {{-- /Footer Kode --}}

    {{-- Alamat --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Alamat</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="text" id="alamat" name="alamat" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Alamat" value="{{ old('alamat', $pengaturan->alamat) }}" autocomplete="off" required>
          @error('alamat')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Alamat --}}

    {{-- Telepon --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Telepon</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="text" id="telepon" name="telepon" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Telepon" value="{{ old('telepon', $pengaturan->telepon) }}" autocomplete="off" required>
          @error('telepon')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Telepon --}}

    {{-- Email --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Email</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="email" id="email" name="email" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Email" value="{{ old('email', $pengaturan->email) }}" autocomplete="off" required>
          @error('email')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Email --}}

    {{-- Facebook --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Facebook</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="text" id="facebook" name="facebook" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Facebook" value="{{ old('facebook', $pengaturan->facebook) }}" autocomplete="off">
          @error('facebook')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Facebook --}}

    {{-- Instagram --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Instagram</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="text" id="instagram" name="instagram" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Instagram" value="{{ old('instagram', $pengaturan->instagram) }}" autocomplete="off">
          @error('instagram')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Instagram --}}

    {{-- Twitter --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Twitter</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="text" id="twitter" name="twitter" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Twitter" value="{{ old('twitter', $pengaturan->twitter) }}" autocomplete="off">
          @error('twitter')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Twtiter --}}

    {{-- Youtube --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Youtube</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="text" id="youtube" name="youtube" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Youtube" value="{{ old('youtube', $pengaturan->youtube) }}" autocomplete="off">
          @error('youtube')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Youtube --}}

    {{-- Copyright --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold">Copyright</div>
      <div class="flex flex-col w-full md:w-5/12">
        <input type="text" id="copyright" name="copyright" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" placeholder="Youtube" value="{{ old('copyright', $pengaturan->copyright) }}" autocomplete="off" required>
          @error('copyright')
          <div class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</div>
          @enderror
      </div>     
    </div>
    {{-- /Copyright --}}

    {{-- Submit --}}
    <div class="flex flex-col md:flex-row mt-3 items-center">
      <div class="w-full md:w-2/12 font-semibold"></div>
        <button type="submit" class="bg-green-600 hover:bg-green-700 py-2 w-full md:w-5/12 text-white text-center font-semibold rounded-lg"><i class="fas fa-save"></i> Simpan</button>
    </div>
    {{-- /Submit --}}

    </form>

  </div>

  {{-- /main content --}}

</div>
<!-- /Main Container -->

@push('js')
<script>
function previewLogo(){
  const image = document.querySelector('#logo');
  const imgPreview = document.querySelector('.logo-preview');
  
  imgPreview.style.display = 'block';

  const oFReader = new FileReader();
  oFReader.readAsDataURL(image.files[0]);

  oFReader.onload = function(oFREvent){
    imgPreview.src = oFREvent.target.result;
  }

}

function previewDarkLogo(){
  const image = document.querySelector('#darklogo');
  const imgPreview = document.querySelector('.darklogo-preview');
  
  imgPreview.style.display = 'block';

  const oFReader = new FileReader();
  oFReader.readAsDataURL(image.files[0]);

  oFReader.onload = function(oFREvent){
    imgPreview.src = oFREvent.target.result;
  }

}
</script>
@endpush

@endsection