<form id="forms" method="post" action="/admin/iklan" enctype="multipart/form-data">
    @csrf

    <div class="w-full h-auto px-2 py-2 border border-green-500 rounded-md itemrow bg-green-100/25">
      <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-green-500 text-white">TAMBAH IKLAN</span></div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-2">

        {{-- NAMA IKLAN --}}
        <div class="md:col-span-2 bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputnama"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">NAMA IKLAN</span></label>
            <input type="text" id="inputnama" name="nama" class="main_input_md"
                value="{{ old('nama') }}" auto-complete="off" required>
        </div>

        {{-- JENIS --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputjenis"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">JENIS IKLAN</span></label>
          <select id="inputjenis" name="jenis" class="main_input_md" required>
            @foreach($jenisIklan as $jenis)
            <option value="{{ $jenis }}">{{ $jenis }}</option>
            @endforeach
          </select>
        </div>

        {{-- POSISI --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputposisi"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">POSISI <a href="{{ asset('images/guide_iklan.jpg') }}" target="_blank"><i class="fa-solid fa-circle-question text-blue-500 hover:text-blue-700"></i></a></span></label>
          <select id="inputposisi" name="posisi" class="main_input_md" required>
              @foreach($posisiIklan as $posisi)
              <option value="{{ $posisi }}">{{ $posisi }}</option>
              @endforeach
          </select>
        </div>

        {{-- FOTO --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputfoto"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">GAMBAR</span></label>
            <div class="flex w-full h-48 mb-0.5 p-2 overflow-hidden rounded-md">
                <img class="object-cover w-full h-full foto-preview rounded" src="{{ asset('images/img-default.png') }}" alt="">
            </div>
            <input name="foto" id="inputfoto" type="file" class="w-full file-input file-input-bordered" accept="image/*" required>
            @error('foto')
                <div class="text-xs text-red-600">{{ $message }}</div>
            @enderror
        </div>

        {{-- KODE --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputkode"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">KODE</span></label>
          <textarea id="inputkode" name="kode" class="w-full main_input_textarea" rows="11">{{ old('kode') }}</textarea>
        </div>

        {{-- LINK --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputlink"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">LINK</span></label>
            <input type="text" id="inputlink" name="link" class="main_input_md"
                value="{{ old('link') }}" auto-complete="off">
        </div>

        {{-- AE --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputAE"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">AE</span></label>
            <input type="text" id="inputAE" name="AE" class="main_input_md"
                value="{{ old('AE') }}" auto-complete="off">
        </div>

        {{-- URUTAN --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputurutan"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">URUTAN</span></label>
          <select id="inputurutan" name="urutan" class="main_input_md" required>
            @for($i=1; $i <=10; $i++)
            <option value="{{ $i }}">{{  $i }}</option>
            @endfor
          </select>
        </div>

        {{-- STATUS --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputstatus"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">STATUS</span></label>
          <select id="inputstatus" name="status" class="main_input_md" required>
            <option value="1">Aktif</option>
            <option value="0">Tidak Aktif</option>
          </select>  
        </div>

        {{-- AWAL TAYANG --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputawal_tayang"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">AWAL TAYANG</span></label>
            <input type="date" id="awal_tayang" name="awal_tayang" class="main_input_md" value="{{ Carbon\Carbon::now()->translatedFormat('Y-m-d') }}" autocomplete="off" required>
        </div>

        {{-- AKHIR TAYANG --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputakhir_tayang"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">AKHIR TAYANG</span></label>
            <input type="date" id="akhir_tayang" name="akhir_tayang" class="main_input_md" value="{{ Carbon\Carbon::now()->translatedFormat('Y-m-d') }}" autocomplete="off" required>
        </div>

      </div>

    </div>

    <x-close-modal-button>
        <x-slot:submit></x-slot:submit>
    </x-close-modal-button>
</form>
