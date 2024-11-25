<div class="w-full h-auto px-2 py-2 border border-blue-500 rounded-md itemrow bg-blue-100/25">
    <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-blue-500 text-white">DETAIL KATEGORI</span></div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-2">

        {{-- NAMA KATEGORI --}}
        <div class="md:col-span-3 bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputnama"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">NAMA KATEGORI</span></label>
            <input type="text" id="inputnama" name="nama" class="main_input_md"
                value="{{ old('nama', $kategori->nama) }}" auto-complete="off" readonly>
        </div>

        {{-- STATUS --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputstatus"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">STATUS</span></label>
          <input type="text" id="inputstatus" name="status" class="main_input_md"
                value="{{ $kategori->status == '1' ? 'Aktif' : 'Tidak Aktif' }}" auto-complete="off" readonly>
        </div>

        {{-- NAVIGASI --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputnavigasi"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">NAVIGASI</span></label>
          <input type="text" id="inputnavigasi" name="navigasi" class="main_input_md"
                value="{{ $kategori->navigasi == '1' ? 'Aktif' : 'Tidak Aktif' }}" auto-complete="off" readonly>
        </div>

        {{-- URUTAN --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputurutan"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">URUTAN</span></label>
            <input type="text" id="inputurutan" name="urutan" class="main_input_md"
                value="{{ $kategori->urutan }}" auto-complete="off" readonly>
        </div>
        
      </div>

    </div>

    <x-close-modal-button/>