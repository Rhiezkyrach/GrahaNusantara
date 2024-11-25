<form id="forms" method="post" action="/admin/network_access" enctype="multipart/form-data">
@csrf

    <div class="w-full h-auto px-2 py-2 border border-green-500 rounded-md itemrow bg-green-100/25">
        <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-green-500 text-white">TAMBAH AKSES NETWORK</span></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">

            <input type="hidden" id="inputid_network" name="id_network" value="{{ $id_network }}">

            {{-- NAMA USER --}}
            <div class="md:col-span-2 bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputid_user"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">NAMA USER</span></label>
                <select id="inputid_user" name="id_user" class="select2 main_input_md" required>
                    <option value="">Pilih</option>
                    @foreach($user as $d)
                    <option value="{{ $d->id }}" data-username="{{ $d->username }}" data-level="{{ $d->level }}">{{  $d->name . ' (' . $d->level . '-' . $d->Network->nama .')'}}</option>
                    @endforeach
                </select>
            </div>

            {{-- USERNAME --}}
            <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputusername"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">USERNAME</span></label>
                <input type="text" id="inputusername" name="username" class="main_input_md"
                    value="{{ old('username') }}" auto-complete="off" readonly>
            </div>

            {{-- LEVEL --}}
            <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputlevel"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">LEVEL</span></label>
                <input type="text" id="inputlevel" name="level" class="main_input_md"
                    value="{{ old('level') }}" auto-complete="off" readonly>
            </div>
            
        </div>

    </div>

    <x-close-modal-button>
        <x-slot:submit></x-slot:submit>
    </x-close-modal-button>
</form>