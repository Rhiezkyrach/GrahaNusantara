<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Silahkan masukan alamat email anda, kami akan mengirimkan link untuk mereset kata sandi anda.') }}
        </div>

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="bg-gradient-to-b from-slate-300 rounded-lg">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Email Link Reset Password') }}
                </x-button>
            </div>

            <a href="{{ url('/login') }}" class="float-right mt-2.5 text-xs hover:text-red-600 underline">Kembali ke Halaman Login</a>
        </form>
    </x-authentication-card>
</x-guest-layout>