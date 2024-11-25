@extends('admin.layouts.header')

@section('admincontent')

<!-- main Container -->
<x-main-container title="Profil Saya" url="{{ $setting && $setting->Network ? $setting->Network->url : url('/') }}">

    {{-- content --}}
    <div class="mt-5 w-full">

        <form id="forms" method="post" action="/admin/profile/{{ $user->id }}" enctype="multipart/form-data">
        @csrf
        @method('put')

        {{-- INFO DISPLAY --}}
        <div class="relative w-full h-52 bg-gradient-to-r from-green-300 to-yellow-300 rounded-xl">
            <div class="w-full-h full overflow-hidden">
                <div class="mt-0.5 absolute top-1/2 left-1/2 -translate-x-1/2 w-52 h-52 border-4 border-white rounded-full"></div>
            </div>
            <div class="mt-5 p-1 absolute w-44 h-44 bg-gradient-to-tr from-amber-300 via-rose-300 to-indigo-500 rounded-full top-1/2 left-1/2 -translate-x-1/2">
                <div class="relative p-0.5 w-full h-full rounded-full">
                    <div class="w-full h-full bg-gray-100 rounded-full overflow-hidden">
                        @if($user->profile_photo_path)
                            <input type="file" name="fotoLamaWartawan" class="hidden" value="{{ $user->Reporter ? $user->reporter_foto : ''}}"/> 
                            <input type="file" name="fotoLamaUser" class="hidden" value="{{ $user->profile_photo_path }}"/> 
                            <img id="avatar-img" class="w-full h-full object-cover" src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="">
                        @else
                            <div id="avatar-initial" class="-mt-1 w-full h-full text-6xl font-bold text-gray-400 flex justify-center items-center uppercase">{{ substr($user->name, 0, 1) }}</div>
                            <img id="avatar-img" class="w-full h-full hidden object-cover" src="" alt="">
                        @endif
                        
                        <label for='inputfoto' class="group">
                            <div id="uploadfoto" class="absolute bottom-0 right-0 w-8 h-8 mr-4 bg-blue-400 hover:bg-blue-600 rounded-full cursor-pointer"><i class="fa-duotone fa-camera-retro ml-2 mt-2 group-hover:text-white"></i></div>
                        </label>
                        <input type="file" id="inputfoto" name="foto" class="hidden"/> 
                        {{-- <input type="hidden" class="toggle"> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-28  text-center text-3xl font-bold">{{ $user->name }}</div>
        <div class="mt-1 flex flex-row gap-2 items-center justify-center">
            {{-- LEVEL --}}
            <div class="text-center text-sm"><span class="px-2 py-1 bg-green-600 text-white rounded"><i class="fa-solid fa-badge-check"></i> {{ $user->level }}</span></div>
            {{-- ID CARD --}}
            <a href="{{ url('admin/id-card/' . $user->id) }}" target="_blank" class="text-center text-sm"><span class="px-2 py-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded"><i class="fa-regular fa-id-card"></i> ID CARD SAYA</span></a>
        </div>
        <div class="mt-1.5 text-center text-xs">Berita dipublish: {{ $jumlah_berita }} Berita</div>

        <div class="divider"></div>

        <div class="w-full h-auto px-2 py-2 border border-blue-500 rounded-md itemrow bg-blue-100/25">
            <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-blue-500 text-white">DETAIL PROFILE</span></div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">

                {{-- NAMA --}}
                <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                    <label class="mb-1" for="inputname"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">NAMA</span></label>
                    <input type="text" id="inputname" name="name" class="main_input_md"
                        value="{{ old('name', $user->name) }}" auto-complete="off" readonly>
                </div>

                {{-- INISIAL --}}
                <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                    <label class="mb-1" for="inputinisial"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">INISIAL</span></label>
                    <input type="text" id="inputinisial" name="inisial" class="main_input_md"
                        value="{{ old('inisial', $user->inisial) }}" auto-complete="off" readonly>
                </div>

                {{-- LEVEL --}}
                <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                    <label class="mb-1" for="inputlevel"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">LEVEL</span></label>
                    <input type="text" id="inputlevel" name="level" class="main_input_md"
                        value="{{ old('level', $user->level) }}" auto-complete="off" readonly>
                </div>

                {{-- EMAIL --}}
                <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                    <label class="mb-1" for="inputemail"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">EMAIL</span></label>
                    <input type="text" id="inputemail" name="email" class="main_input_md"
                        value="{{ old('email', $user->email) }}" auto-complete="off" readonly>
                </div>

            </div>

        </div>

        <div class="divider"></div>

        <div class="w-full h-auto px-2 py-2 border border-amber-500 rounded-md itemrow bg-amber-100/25">
            <div class="-mt-1.5 mb-2.5 text-center font-semibold"><span class="px-4 py-1 rounded-b-lg bg-amber-500 text-white">UBAH PASSWORD</span></div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">

                {{-- PASSWORD LAMA --}}
                <div class="relative bg-gradient-to-b from-slate-300 rounded-lg">
                    <label class="mb-1" for="inputpassword_lama"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">PASSWORD LAMA</span></label>
                    <input type="password" id="inputpassword_lama" name="password_lama" class="main_input_md"
                        value="{{ old('password_lama') }}" auto-complete="off">

                    <div id="toggle_inputpassword_lama" class="absolute top-0 right-0 mt-8 mr-2 cursor-pointer">
                        <div id="closed_inputpassword_lama" class=""><i class="fa-duotone fa-eye-slash"></i></div>
                        <div id="opened_inputpassword_lama" class="hidden"><i class="fa-duotone fa-eye"></i></div>
                    </div>
                </div>

                {{-- PASSWORD BARU --}}
                <div class="relative bg-gradient-to-b from-slate-300 rounded-lg">
                    <label class="mb-1" for="inputpassword_baru"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">PASSWORD BARU</span></label>
                    <input type="password" id="inputpassword_baru" name="password_baru" class="main_input_md"
                        value="{{ old('password_baru') }}" auto-complete="off">

                    <div id="toggle_inputpassword_baru" class="absolute top-0 right-0 mt-8 mr-2 cursor-pointer">
                        <div id="closed_inputpassword_baru" class=""><i class="fa-duotone fa-eye-slash"></i></div>
                        <div id="opened_inputpassword_baru" class="hidden"><i class="fa-duotone fa-eye"></i></div>
                    </div>
                </div>

                {{-- CONFIRM PASSWORD BARU --}}
                <div class="relative bg-gradient-to-b from-slate-300 rounded-lg">
                    <label class="mb-1" for="inputconfirm_password_baru"><span class="text-xs uppercase py-1 pl-2.5 font-semibold">CONFIRM PASSWORD BARU</span></label>
                    <input type="password" id="inputconfirm_password_baru" name="confirm_password_baru" class="main_input_md"
                        value="{{ old('confirm_password_baru') }}" auto-complete="off">

                    <div id="toggle_confirm_password_baru" class="absolute top-0 right-0 mt-8 mr-2 cursor-pointer">
                        <div id="closed_confirm_password_baru" class=""><i class="fa-duotone fa-eye-slash"></i></div>
                        <div id="opened_confirm_password_baru" class="hidden"><i class="fa-duotone fa-eye"></i></div>
                    </div>
                </div>

            </div>

            <div class="flex mt-2">
                {{-- <x-back-button url="{{ url('/') }}">Kembali</x-back-button> --}}
                <x-submit-button>Simpan</x-submit-button>
            </div>

        </div>

        </form>
            
    </div>
    {{-- /content --}}

</x-main-container>
<!-- /Main Container -->

<!-- Modal -->
<x-modals class="max-w-2xl">
    <x-slot:inputid>modal-container</x-slot:inputid>
    <x-slot:modalid>modal-content</x-slot:modalid>
    <div id="modal-ajax">
        {{-- Ajax --}}
    </div>
</x-modals>

@push('js')
<script>
$(document).ready(function () {

    $('#inputfoto').change(function() {
        const file = this.files[0];
        console.log(file);
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                // console.log(event.target.result);
                $('#avatar-initial').addClass('hidden');
                $('#avatar-img').removeClass('hidden');
                $('#avatar-img').attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    // Toogle Password Visibility
    $('#toggle_inputpassword_lama').on('click', function() {
        let type = $('#inputpassword_lama').attr('type')

        if( type === 'password' ){
            $('#opened_inputpassword_lama').removeClass('hidden')
            $('#closed_inputpassword_lama').addClass('hidden')
            $('#inputpassword_lama').attr("type", "text");
        }else{
            $('#opened_inputpassword_lama').addClass('hidden')
            $('#closed_inputpassword_lama').removeClass('hidden')
            $('#inputpassword_lama').attr("type", "password");
        } 
    });

    $('#toggle_inputpassword_baru').on('click', function() {
        let type = $('#inputpassword_baru').attr('type')

        if( type === 'password' ){
            $('#opened_inputpassword_baru').removeClass('hidden')
            $('#closed_inputpassword_baru').addClass('hidden')
            $('#inputpassword_baru').attr("type", "text");
        }else{
            $('#opened_inputpassword_baru').addClass('hidden')
            $('#closed_inputpassword_baru').removeClass('hidden')
            $('#inputpassword_baru').attr("type", "password");
        } 
    });

    $('#toggle_confirm_password_baru').on('click', function() {
        let type = $('#inputconfirm_password_baru').attr('type')

        if( type === 'password' ){
            $('#opened_confirm_password_baru').removeClass('hidden')
            $('#closed_confirm_password_baru').addClass('hidden')
            $('#confirm_password_baru').attr("type", "text");
        }else{
            $('#opened_confirm_password_baru').addClass('hidden')
            $('#closed_confirm_password_baru').removeClass('hidden')
            $('#inputconfirm_password_baru').attr("type", "password");
        } 
    });

    //check password new & confirmed password is same
    $('#formSubmit').on('click', function(e){
        event.preventDefault();

        let password_baru = $('#inputpassword_baru').val();
        let confirm_password_baru = $('#inputconfirm_password_baru').val();

        if(password_baru != confirm_password_baru){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Konfirmasi Password Tidak Sama!',
                timer: 10000,
                toast: true,
                position: 'top-end',
            })
        } else {
            // Prevent double click input
            $('#forms').on('submit', function(){
                $('#formSubmit').prop( "disabled", true );
                $('#process').addClass('hidden');
                $('#processing').removeClass('hidden');
            });

            //Submit 
            $("#formSubmit").unbind('click').click();
        }

    });
});
</script>
@endpush

@endsection