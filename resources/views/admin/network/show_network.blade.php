<div class="w-full h-auto px-2 py-2 border border-blue-500 rounded-md itemrow bg-blue-100/25">
    <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-blue-500 text-white">DETAIL NETWORK</span></div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">

        <div class="grid grid-cols-1 gap-1">
            {{-- NAMA NETWORK --}}
            <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputnama"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">NAMA NETWORK</span></label>
                <input type="text" id="inputnama" name="nama" class="main_input_md"
                    value="{{ old('nama', $network->nama) }}" auto-complete="off" readonly>
            </div>

            {{-- TAGLINE --}}
            <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputtagline"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">TAGLINE</span></label>
                <input type="text" id="inputtagline" name="tagline" class="main_input_md"
                    value="{{ old('tagline', $network->Setting ? $network->Setting->tagline : '') }}" auto-complete="off" readonly>
            </div>

            {{-- URL --}}
            <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputurl"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">URL</span></label>
                <input type="text" id="inputurl" name="url" class="main_input_md"
                    value="{{ old('url', $network->url) }}" auto-complete="off" readonly>
            </div>
        </div>

        {{-- LOGO --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputlogo"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">LOGO</span></label>
            <div class="flex w-full h-48 mb-2 p-2 overflow-hidden rounded-md">
                <img src="{{ $network->logo ? asset('storage/'. $network->logo) : asset('images/img.default.png')}}" class="logo-preview w-full h-full my-auto object-cover overflow-hidden rounded">
            </div>
        </div>
    </div>

    <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-2">
        {{-- URUTAN --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputurutan"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">URUTAN</span></label>
            <input type="text" id="inputurutan" name="urutan" class="main_input_md"
                value="{{ old('urutan', $network->urutan) }}" auto-complete="off" readonly>
        </div>

        {{-- STATUS --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputstatus"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">STATUS</span></label>
            <input type="text" id="inputstatus" name="status" class="main_input_md"
                value="{{ $network->status == '1' ? 'Aktif' : 'Tidak Aktif' }}" auto-complete="off" readonly> 
        </div>
    </div>

</div>

<x-close-modal-button/>
