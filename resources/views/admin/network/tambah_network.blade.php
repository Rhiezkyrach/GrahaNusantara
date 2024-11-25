<form id="forms" method="post" action="/admin/network" enctype="multipart/form-data">
@csrf

    <div class="w-full h-auto px-2 py-2 border border-green-500 rounded-md itemrow bg-green-100/25">
        <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-green-500 text-white">TAMBAH NETWORK</span></div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">

            <div class="grid grid-cols-1 gap-1">
                {{-- NAMA NETWORK --}}
                <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                    <label class="mb-1" for="inputnama"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">NAMA NETWORK</span></label>
                    <input type="text" id="inputnama" name="nama" class="main_input_md"
                        value="{{ old('nama') }}" auto-complete="off" required>
                </div>

                {{-- TAGLINE --}}
                <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                    <label class="mb-1" for="inputtagline"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">TAGLINE</span></label>
                    <input type="text" id="inputtagline" name="tagline" class="main_input_md"
                        value="{{ old('tagline') }}" auto-complete="off" required>
                </div>

                {{-- URL --}}
                <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                    <label class="mb-1" for="inputurl"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">URL</span></label>
                    <input type="url" id="inputurl" name="url" class="main_input_md" pattern="https://.*" placeholder="https://contoh.com"
                        value="{{ old('url') }}" auto-complete="off" required>
                </div>
            </div>

            {{-- LOGO --}}
            <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                <label class="mb-1" for="inputlogo"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">LOGO</span></label>
                <div class="flex w-full h-32 mb-1 p-2 overflow-hidden rounded-md">
                    <img class="object-cover w-full h-full logo-preview rounded" src="{{ asset('images/img-default.png') }}" alt="">
                </div>
                <input name="logo" id="inputlogo" type="file" class="w-full file-input file-input-bordered" accept="image/*" required>
                @error('image')
                    <div class="text-xs text-red-600">{{ $message }}</div>
                @enderror
            </div>
            
        </div>

        <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-2">
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
                <option value="1" @selected(old('status') == '1')>Aktif</option>
                <option value="0" @selected(old('status') == '0')>Tidak Aktif</option>
                </select>  
            </div>
        </div>

    </div>

    <x-close-modal-button>
        <x-slot:submit></x-slot:submit>
    </x-close-modal-button>
</form>