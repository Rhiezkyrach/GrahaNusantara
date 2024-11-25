<form id="forms" method="post" action="/admin/user/{{ $user->id }}" enctype="multipart/form-data">
  @csrf
  @method('put')

  <div class="w-full h-auto px-2 py-2 border border-amber-500 rounded-md itemrow bg-amber-100/25">
    <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-amber-500 text-white">EDIT USER</span></div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">

      {{-- USERNAME --}}
      <div class="bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputusername"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">USERNAME</span></label>
          <input type="text" id="inputusername" name="username" class="main_input_md"
              value="{{ old('username', $user->username) }}" auto-complete="off" required>
      </div>

      {{-- PASSWORD --}}
      <div class="bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputpassword"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">PASSWORD</span></label>
          <input type="password" id="inputpassword" name="password" class="main_input_md" placeholder="Kosongkan jika tidak diubah" 
            value="{{ old('password') }}" autocomplete="off">
      </div>
      
      <div class="md:col-span-2 divider my-1"></div>

      {{-- NAMA --}}
      <div class="md:col-span-2 bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputname"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">NAMA</span></label>
          <input type="text" id="inputname" name="name" class="main_input_md"
              value="{{ old('name', $user->name) }}" auto-complete="off" required>
      </div>

      <div class="grid grid-cols-1 gap-2">
        {{-- INISIAL --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputinisial"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">INISIAL</span></label>
            <input type="text" id="inputinisial" name="inisial" class="main_input_md"
                value="{{ old('inisial', $user->inisial) }}" auto-complete="off" required>
        </div>

        {{-- EMAIL --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputemail"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">EMAIL</span></label>
            <input type="email" id="inputemail" name="email" class="main_input_md"
                value="{{ old('email', $user->email) }}" auto-complete="off" required>
        </div>

        {{-- LEVEL --}}
        <div class="bg-gradient-to-b from-slate-300 rounded-lg">
            <label class="mb-1" for="inputlevel"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">LEVEL</span></label>
            <select id="inputlevel" name="level" class="select2 main_input_md" required>
              <option value="owner" @selected($user->level == 'owner')>Owner</option>
              <option value="admin" @selected($user->level == 'admin')>Admin</option>
              <option value="redaktur" @selected($user->level == 'redaktur')>Redaktur</option>
              <option value="wartawan" @selected($user->level == 'wartawan')>Wartawan</option>
            </select>
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
            <select id="inputstatus" name="status" class="main_input_md" required>
              <option value="1" @selected($user->status == '1')>Aktif</option>
              <option value="0" @selected($user->status == '0')>Tidak Aktif</option>
            </select>
        </div>
      </div>

      {{-- FOTO --}}
      <div class="bg-gradient-to-b from-slate-300 rounded-lg">
          <label class="mb-1" for="inputfoto"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">FOTO</span></label>
          <div class="flex w-full h-64 mb-1 p-2 overflow-hidden rounded-md">
              @if($user->profile_photo_path)
                <input name="fotoLamaUser" type="file" class="hidden" value="{{ $user->profile_photo_path }}">
                <input name="fotoLamaWartawan" type="file" class="hidden" value="{{ $user->Reporter ? $user->Reporter->foto : '' }}">
                <img src="{{ asset('storage/'. $user->profile_photo_path) }}" class="foto-preview w-full h-full my-auto object-cover overflow-hidden rounded">
              @else
                  <img class="object-cover w-full h-full foto-preview rounded" z src="{{ asset('images/img-default.png') }}" alt="">
              @endif
          </div>
          <input name="foto" id="inputfoto" type="file" class="w-full file-input file-input-bordered" accept="image/*">
      </div>

    </div>

  </div>

  <x-close-modal-button>
        <x-slot:submit></x-slot:submit>
    </x-close-modal-button>
</form>
