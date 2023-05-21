<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  {{-- Google Font --}}
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

  {{-- Tailwind CSS 3.0.24 --}}
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  {{-- Font Awesome 6.1.1 --}}
  <link href="{{ asset('plugin/fontawesome/css/all.css') }}" rel="stylesheet">
  {{-- CKEditor 4.19 --}}
  <script src="{{ asset('plugin/ckeditor/ckeditor.js') }}"></script>
  {{-- Jquery --}}
  <script src="{{ asset('plugin/jquery/jquery-3.6.0.min.js') }}"></script>

  {{-- SweetAlert 2 --}}
  <link rel="stylesheet" href="{{ asset('plugin/sweetalert/dist/sweetalert2.min.css') }}">
  <script src="{{ asset('plugin/sweetalert/dist/sweetalert2.all.min.js') }}"></script>

  {{-- Favicon --}}
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

  @stack('css')

  <title>{{ $judul }}</title>

  <meta name="robots" content="noindex">
  <meta name="googlebot" content="noindex">
  <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>

<div class="flex flex-row">

  @if(!Request::is('cmslogin'))
    @include('admin.layouts.sidebar')
    @include('admin.layouts.navbar')

  <div class="relative flex w-full md:w-10/12">
    
    @yield('admincontent')

    @include('admin.layouts.footer')

  </div>

  @else
    @yield('admincontent')
  @endif

</div>

<script src="{{ asset('/js/cms.js') }}"></script>
@include('sweetalert::alert')
@stack('js')


</body>
</html>