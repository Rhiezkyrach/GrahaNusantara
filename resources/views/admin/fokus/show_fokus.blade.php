<div class="w-full h-auto px-2 py-2 border border-blue-500 rounded-md itemrow bg-blue-100/25">
    <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-blue-500 text-white">DETAIL FOKUS</span></div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-2">

        {{-- JUDUL FOKUS --}}
        <div class="md:col-span-2 bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputnama"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">JUDUL FOKUS</span></label>
            <input type="text" id="inputnama" name="nama" class="main_input_md"
                value="{{ old('nama', $fokus->nama) }}" auto-complete="off" readonly>
        </div>

        {{-- STATUS --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputstatus"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">STATUS</span></label>
          <input type="text" id="inputstatus" name="status" class="main_input_md"
                value="{{ $fokus->status == '1' ? 'Aktif' : 'Tidak Aktif' }}" auto-complete="off" readonly>
        </div>

        {{-- URUTAN --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputurutan"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">URUTAN</span></label>
            <input type="text" id="inputurutan" name="urutan" class="main_input_md"
                value="{{ $fokus->urutan }}" auto-complete="off" readonly>
        </div>

        {{-- FOTO --}}
        <div class="md:col-span-2 bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputfoto"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">FOTO</span></label>
            <div class="flex w-full h-36 mb-2 p-2 overflow-hidden rounded-md">
                    @if($fokus->foto)
                    <img src="{{ asset('storage/'. $fokus->foto) }}" class="foto-preview w-full h-full my-auto object-cover overflow-hidden rounded">
                @else
                    <img class="object-cover w-full h-full foto-preview rounded" src="{{ asset('images/img-default.png') }}" alt="">
                @endif
            </div>
            {{-- <input name="foto" id="inputfoto" type="file" class="w-full file-input file-input-bordered" accept="image/*"> --}}
        </div>
        
        {{-- WARNA BACKGROUND --}}
        <div class="md:col-span-2 bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputbg_color"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">WARNA BACKGROUND</span></label>
            <input type="color" id="inputbg_color" name="bg_color" class="h-12 main_input_md"
                value="{{ old('bg_color', $fokus->bg_color) }}" auto-complete="off" readonly>
        </div>

      </div>

    </div>

    <x-close-modal-button/>