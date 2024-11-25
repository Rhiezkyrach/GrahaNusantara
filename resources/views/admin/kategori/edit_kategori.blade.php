<form method="post" action="/admin/kategori/{{ $kategori->slug }}">
  @csrf
  @method('put')

    <div class="w-full h-auto px-2 py-2 border border-amber-500 rounded-md itemrow bg-amber-100/25">
    <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-amber-500 text-white">EDIT KATEGORI</span></div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-2">

        {{-- NAMA KATEGORI --}}
        <div class="md:col-span-3 bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputnama"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">NAMA KATEGORI</span></label>
            <input type="text" id="inputnama" name="nama" class="main_input_md"
                value="{{ old('nama', $kategori->nama) }}" auto-complete="off" required>
        </div>

        {{-- STATUS --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputstatus"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">STATUS</span></label>
          <select id="status" name="status" class="main_input_md" required>
            <option value="1" @selected($kategori->status== '1')>Aktif</option>
            <option value="0" @selected($kategori->status== '0')>Tidak Aktif</option>
          </select>  
        </div>

        {{-- NAVIGASI --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputnavigasi"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">NAVIGASI</span></label>
          <select id="navigasi" name="navigasi" class="main_input_md" required>
            <option value="1" @selected($kategori->navigasi== '1')>Aktif</option>
            <option value="0" @selected($kategori->navigasi== '0')>Tidak Aktif</option>
          </select>  
        </div>

        {{-- URUTAN --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputurutan"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">URUTAN</span></label>
            <select id="inputurutan" name="urutan" class="mt-1 md:mt-0 w-full p-2 border border-gray-400 rounded-md" required>
              @for($i=1; $i <=10; $i++)
              <option value="{{ $i }}" @selected($kategori->urutan == $i)>{{  $i }}</option>
              @endfor
            </select>
        </div>
        
      </div>

    </div>

  <x-close-modal-button>
        <x-slot:submit></x-slot:submit>
    </x-close-modal-button>
</form>