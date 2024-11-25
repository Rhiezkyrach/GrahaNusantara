
<div class="w-full h-auto px-2 py-2 border border-blue-500 rounded-md itemrow bg-blue-100/25">
    <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-blue-500 text-white">DETAIL STRUKTUR</span></div>

    <div class="grid grid-cols-1 gap-2">

    {{-- NETWORK --}}
    <div class="bg-gradient-to-b from-slate-300 rounded-lg">
        <label class="mb-1" for="inputid_network"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">NETWORK</span></label>
        <input type="text" id="inputid_network" name="id_network" class="main_input_md"
            value="{{ old('id_network', $struktur->id_network) }}" auto-complete="off" readonly>
    </div>

    {{-- NAMA USER --}}
    <div class="bg-gradient-to-b from-slate-300 rounded-lg">
        <label class="mb-1" for="inputid_user"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">NAMA USER</span></label>
        <input type="text" id="inputjabatan" name="jabatan" class="main_input_md"
            value="{{ old('jabatan', $struktur->jabatan) }}" auto-complete="off" readonly>
    </div>

    {{-- JABATAN --}}
    <div class="bg-gradient-to-b from-slate-300 rounded-lg">
        <label class="mb-1" for="inputjabatan"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">JABATAN</span></label>
        <input type="text" id="inputjabatan" name="jabatan" class="main_input_md"
            value="{{ old('jabatan', $struktur->jabatan) }}" auto-complete="off" readonly>
    </div>

    {{-- TTD --}}
    <div class="bg-gradient-to-b from-slate-300 rounded-lg">
        <label class="mb-1" for="inputttd"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">TTD</span></label>
        <div class="flex w-full h-48 mb-0.5 p-2 overflow-hidden rounded-md">
            @if($struktur->ttd)
                <img src="{{ asset('storage/'. $struktur->ttd) }}" class="ttd-preview w-full h-full my-auto object-cover overflow-hidden rounded">
            @else
            <img class="object-cover w-full h-full ttd-preview rounded" src="{{ asset('images/img-default.png') }}" alt="">
            @endif
        </div>
    </div>

    {{-- STATUS --}}
    <div class="bg-gradient-to-b from-slate-300 rounded-lg">
        <label class="mb-1" for="inputstatus"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">STATUS</span></label>
        <select id="inputstatus" name="status" class="main_input_md" readonly>
            <option value="1" @selected($struktur->status == '1')>Aktif</option>
            <option value="0" @selected($struktur->status == '0')>Tidak Aktif</option>
        </select>  
    </div>

    </div>

</div>

<x-close-modal-button/>
