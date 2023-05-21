@extends('admin.layouts.header')

@section('admincontent')
<div class="flex w-full h-screen px-2 bg-gray-100/50 items-center justify-center">

  <form class="w-full md:w-[420px] marker:h-auto px-5" action="/cmslogin" method="post">
  @csrf

    <img class="w-52 mb-5 mx-auto" src="{{ asset('storage/' . $setting->logo) }}" alt="">
    <div class="bg-gradient-to-tr from-sky-200 to-lime-200 px-4 shadow-lg border-t-2 border-gray-100 h-auto">
      <div class="text-lg mt-4 font-semibold">Login</div>
      <input name="username" id="username" class="w-full mt-2 bg-white border border-gray-200 focus:outline-none focus:ring-1 focus:ring-red-600 focus:border-transparent rounded-lg h-12 px-5" type="text" placeholder="username" autofocus autocomplete="off" required value="{{ old('username') }}">
      <input name="password" id="password" class="w-full mt-2 bg-white border border-gray-200 focus:outline-none focus:ring-1 focus:ring-red-600 focus:border-transparent rounded-lg h-12 px-5" type="password" placeholder="password" required>

      @if(session()->has('loginError'))
        <div class="mt-2 text-xs text-red-600 text-center">{{ session('loginError') }}</div>
      @endif

      <button class="w-full my-6 bg-gradient-to-tr from-red-600 to-red-500 hover:from-red-500 hover:to-red-700 rounded-lg py-3 font-semibold text-white"><i class="fas fa-sign-in-alt"></i> Login</button>
    </div>
    <div class="w-full h-1 bg-gradient-to-r from-red-600 to-amber-500"></div>
    <div class="text-xs text-center mt-4">{!! $setting->copyright !!}</div> 
  </form>

</div>
@endsection