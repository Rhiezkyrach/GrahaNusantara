<form id="forms" method="post" action="/admin/struktur/{{ $struktur->id }}" enctype="multipart/form-data">
    @csrf
    @method('put')

    <div class="w-full h-auto px-2 py-2 border border-amber-500 rounded-md itemrow bg-amber-100/25">
    <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-amber-500 text-white">EDIT STRUKTUR</span></div>

      <div class="grid grid-cols-1 gap-2">

        {{-- NETWORK --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputid_network"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">NETWORK</span></label>
          <select id="inputid_network" name="id_network" class="select2 main_input_md" required>
            <option value="">Pilih</option>
            @foreach($network as $d)
            <option value="{{ $d->id_network }}" @selected($struktur->id_network == $d->id_network)>{{ $d->nama }}</option>
            @endforeach
          </select>
        </div>

        {{-- NAMA USER --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputid_user"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">NAMA USER</span></label>
          <select id="inputid_user" name="id_user" class="select2 main_input_md" required>
            <option value="">Pilih</option>
            @foreach($user as $d)
            <option value="{{ $d->id }}" @selected($struktur->id_user == $d->id)>{{ $d->name }}</option>
            @endforeach
          </select>
        </div>

        {{-- JABATAN --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputjabatan"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">JABATAN</span></label>
            <input type="text" id="inputjabatan" name="jabatan" class="main_input_md"
                value="{{ old('jabatan', $struktur->jabatan) }}" auto-complete="off" required>
        </div>

        {{-- TTD --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputttd"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">TTD</span></label>
            <div class="flex w-full h-48 mb-0.5 p-2 overflow-hidden rounded-md">
              @if($struktur->ttd)
                  <input name="ttdLama" type="file" class="hidden" value="{{ $struktur->ttd }}">
                  <img src="{{ asset('storage/'. $struktur->ttd) }}" class="ttd-preview w-full h-full my-auto object-cover overflow-hidden rounded">
              @else
                <img class="object-cover w-full h-full ttd-preview rounded" src="{{ asset('images/img-default.png') }}" alt="">
              @endif
            </div>
            <input name="ttd" id="inputttd" type="file" class="w-full file-input file-input-bordered" accept="image/*">
            @error('ttd')
                <div class="text-xs text-red-600">{{ $message }}</div>
            @enderror
        </div>

        {{-- STATUS --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputstatus"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">STATUS</span></label>
          <select id="inputstatus" name="status" class="main_input_md" required>
            <option value="1" @selected($struktur->status == '1')>Aktif</option>
            <option value="0" @selected($struktur->status == '0')>Tidak Aktif</option>
          </select>  
        </div>

      </div>

    </div>

    <x-close-modal-button>
        <x-slot:submit></x-slot:submit>
    </x-close-modal-button>
</form>
