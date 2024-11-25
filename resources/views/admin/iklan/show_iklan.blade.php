<div class="w-full h-auto px-2 py-2 border border-blue-500 rounded-md itemrow bg-blue-100/25">
    <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-blue-500 text-white">DETAIL IKLAN</span></div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">

    {{-- NAMA IKLAN --}}
    <div class="md:col-span-2 bg-gradient-to-b from-slate-300 rounded-lg">
        <label class="mb-1" for="inputnama"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">NAMA IKLAN</span></label>
        <input type="text" id="inputnama" name="nama" class="main_input_md"
            value="{{ old('nama', $iklan->nama) }}" auto-complete="off" readonly>
    </div>

    {{-- JENIS --}}
    <div class="bg-gradient-to-b from-slate-300 rounded-lg">
        <label class="mb-1" for="inputjenis"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">JENIS IKLAN</span></label>
        <input type="text" id="inputjenis" name="jenis" class="main_input_md"
            value="{{ old('jenis', $iklan->jenis) }}" auto-complete="off" readonly>
    </div>

    {{-- POSISI --}}
    <div class="bg-gradient-to-b from-slate-300 rounded-lg">
        <label class="mb-1" for="inputposisi"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">POSISI <a href="{{ asset('images/guide_iklan.jpg') }}" target="_blank"><i class="fa-solid fa-circle-question text-blue-500 hover:text-blue-700"></i></a></span></label>
        <input type="text" id="inputposisi" name="posisi" class="main_input_md"
            value="{{ old('posisi', $iklan->posisi) }}" auto-complete="off" readonly>
    </div>

    {{-- FOTO --}}
    <div class="bg-gradient-to-b from-slate-300 rounded-lg">
        <label class="mb-1" for="inputfoto"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">FOTO</span></label>
        <div class="flex w-full h-56 mb-2 p-2 overflow-hidden rounded-md">
                @if($iklan->foto)
                <img src="{{ asset('storage/'. $iklan->foto) }}" class="foto-preview w-full h-full my-auto object-cover overflow-hidden rounded">
            @else
                <img class="object-cover w-full h-full foto-preview rounded" src="{{ asset('images/img-default.png') }}" alt="">
            @endif
        </div>
        {{-- <input name="foto" id="inputfoto" type="file" class="w-full file-input file-input-bordered" accept="image/*"> --}}
    </div>
        
    {{-- KODE --}}
    <div class="bg-gradient-to-b from-slate-300 rounded-lg">
        <label class="mb-1" for="inputkode"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">KODE</span></label>
        <textarea id="kode" name="kode" class="w-full main_input_textarea" rows="10" readonly>{{ old('kode', $iklan->kode) }}</textarea>
    </div>

    {{-- LINK --}}
    <div class="bg-gradient-to-b from-slate-300 rounded-lg">
        <label class="mb-1" for="inputlink"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">LINK</span></label>
        <input type="text" id="inputlink" name="link" class="main_input_md"
            value="{{ old('link', $iklan->link) }}" auto-complete="off" readonly>
    </div>

    {{-- AE --}}
    <div class="bg-gradient-to-b from-slate-300 rounded-lg">
        <label class="mb-1" for="inputAE"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">AE</span></label>
        <input type="text" id="inputAE" name="AE" class="main_input_md"
            value="{{ old('AE', $iklan->AE) }}" auto-complete="off" readonly>
    </div>

    {{-- URUTAN --}}
    <div class="bg-gradient-to-b from-slate-300 rounded-lg">
        <label class="mb-1" for="inputurutan"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">URUTAN</span></label>
        <input type="text" id="inputurutan" name="urutan" class="main_input_md"
            value="{{ old('urutan', $iklan->urutan) }}" auto-complete="off" readonly>
    </div>

    {{-- STATUS --}}
    <div class="bg-gradient-to-b from-slate-300 rounded-lg">
        <label class="mb-1" for="inputstatus"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">STATUS</span></label>
        <input type="text" id="inputstatus" name="status" class="main_input_md"
            value="{{ $iklan->status == '1' ? 'Aktif' : 'Tidak Aktif' }}" auto-complete="off" readonly>
    </div>

    {{-- AWAL TAYANG --}}
    <div class="bg-gradient-to-b from-slate-300 rounded-lg">
        <label class="mb-1" for="inputposisi"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">AWAL TAYANG</span></label>
        <input type="date" id="awal_tayang" name="awal_tayang" class="main_input_md" value="{{ Carbon\Carbon::parse($iklan->awal_tayang)->translatedFormat('Y-m-d') }}" autocomplete="off" readonly>
    </div>

    {{-- AKHIR TAYANG --}}
    <div class="bg-gradient-to-b from-slate-300 rounded-lg">
        <label class="mb-1" for="inputposisi"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">AKHIR TAYANG</span></label>
        <input type="date" id="akhir_tayang" name="akhir_tayang" class="main_input_md" value="{{ Carbon\Carbon::parse($iklan->akhir_tayang)->translatedFormat('Y-m-d') }}" autocomplete="off" readonly>
    </div>

    </div>

</div>

<x-close-modal-button/>