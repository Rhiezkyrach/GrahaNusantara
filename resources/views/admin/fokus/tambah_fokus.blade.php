<form method="post" action="/admin/fokus" enctype="multipart/form-data">
  @csrf

    <div class="w-full h-auto px-2 py-2 border border-green-500 rounded-md itemrow bg-green-100/25">
      <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-green-500 text-white">TAMBAH FOKUS</span></div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-2">

        {{-- JUDUL FOKUS --}}
        <div class="md:col-span-2 bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputnama"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">JUDUL FOKUS</span></label>
            <input type="text" id="inputnama" name="nama" class="main_input_md"
                value="{{ old('nama') }}" auto-complete="off" required>
        </div>

        {{-- STATUS --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputstatus"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">STATUS</span></label>
          <select id="inputstatus" name="status" class="main_input_md" required>
            <option value="1" selected>Aktif</option>
            <option value="0">Tidak Aktif</option>
          </select>  
        </div>

        {{-- URUTAN --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputurutan"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">URUTAN</span></label>
            <select id="inputurutan" name="urutan" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" required>
              @for($i=1; $i <=10; $i++)
              <option value="{{ $i }}">{{  $i }}</option>
              @endfor
            </select>
        </div>

        {{-- FOTO --}}
        <div class="md:col-span-2 bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputfoto"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">GAMBAR</span></label>
            <div class="flex w-full h-36 mb-0.5 p-2 overflow-hidden rounded-md">
                <img class="object-cover w-full h-full foto-preview rounded" src="{{ asset('images/img-default.png') }}" alt="">
            </div>
            <input name="foto" id="inputfoto" type="file" class="w-full file-input file-input-bordered" accept="image/*" required>
            @error('foto')
                <div class="text-xs text-red-600">{{ $message }}</div>
            @enderror
        </div>

        {{-- WARNA BACKGROUND --}}
        <div class="md:col-span-2 bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputbg_color"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">WARNA BACKGROUND</span></label>
            <input type="color" id="inputbg_color" name="bg_color" class="h-12 main_input_md"
                value="{{ old('bg_color') }}" auto-complete="off" required>
        </div>
        
      </div>

    </div>

  <x-close-modal-button>
        <x-slot:submit></x-slot:submit>
    </x-close-modal-button>
</form>