<div class="w-full h-auto px-2 py-2 border border-blue-500 rounded-md itemrow bg-blue-100/25">
    <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-blue-500 text-white">DETAIL USER</span></div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">

        {{-- USERNAME --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputusername"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">USERNAME</span></label>
            <input type="text" id="inputusername" name="username" class="main_input_md"
                value="{{ old('username', $user->username) }}" auto-complete="off" readonly>
        </div>

        {{-- PASSWORD --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputpassword"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">PASSWORD</span></label>
            <input type="password" id="password" name="password" class="main_input_md" placeholder="Kosongkan jika tidak diubah" 
                value="{{ old('password') }}" autocomplete="off" readonly>
        </div>

        <div class="md:col-span-2 divider my-1"></div>

        {{-- NAMA --}}
        <div class="md:col-span-2 bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputname"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">NAMA</span></label>
            <input type="text" id="inputname" name="name" class="main_input_md"
                value="{{ old('name', $user->name) }}" auto-complete="off" readonly>
        </div>

        <div class="grid grid-cols-1 gap-2">
            {{-- INISIAL --}}
            <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputinisial"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">INISIAL</span></label>
                <input type="text" id="inputinisial" name="inisial" class="main_input_md"
                    value="{{ old('inisial', $user->inisial) }}" auto-complete="off" readonly>
            </div>

            {{-- EMAIL --}}
            <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputemail"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">EMAIL</span></label>
                <input type="email" id="inputemail" name="email" class="main_input_md"
                    value="{{ old('email', $user->email) }}" auto-complete="off" readonly>
            </div>

            {{-- LEVEL --}}
            <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputlevel"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">LEVEL</span></label>
                <input type="text" id="inputlevel" name="level" class="main_input_md"
                    value="{{ ucfirst($user->level) }}" auto-complete="off" readonly>
            </div>

            {{-- MASA BERLAKU IDCARD --}}
            <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputvalid_to"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">MASA BERLAKU IDCARD</span></label>
                <input type="date" id="inputvalid_to" name="valid_to" class="main_input_md"
                    min="{{ Carbon\Carbon::now()->translatedFormat('Y-m-d') }}"
                    value="{{ old('valid_to', Carbon\Carbon::parse($user->valid_to)->translatedFormat('Y-m-d')) }}" auto-complete="off" required>
            </div>

            {{-- STATUS --}}
            <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputstatus"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">STATUS</span></label>
                <input type="text" id="inputstatus" name="status" class="main_input_md"
                    value="{{ $user->status == '0' ? 'Tidak Aktif' : 'Aktif' }}" auto-complete="off" readonly>
            </div>
        </div>

        {{-- FOTO --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputfoto"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">FOTO</span></label>
            <div class="flex w-full h-64 mb-1 p-2 overflow-hidden rounded-md">
                @if($user->profile_photo_path)
                    <img src="{{ asset('storage/'. $user->profile_photo_path) }}" class="foto-preview w-full h-full my-auto object-cover overflow-hidden rounded">
                @else
                    <img class="object-cover w-full h-full foto-preview rounded" z src="{{ asset('images/img-default.png') }}" alt="">
                @endif
            </div>
            {{-- <input name="foto" id="inputfoto" type="file" class="w-full file-input file-input-bordered" accept="image/*"> --}}
        </div>

    </div>
</div>

<x-close-modal-button/>