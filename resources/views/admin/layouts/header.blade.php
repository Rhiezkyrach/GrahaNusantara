<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  {{-- Google Font --}}
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

  {{-- Font Awesome 6.2.1 --}}
  <link href="{{ asset('plugin/fontawesome/css/all.css') }}" rel="stylesheet">
  {{-- DataTables --}}
  <link rel="stylesheet" type="text/css" href="{{ asset('plugin/datatables/datatables.min.css') }}"/>
  {{-- SweetAlert 2 --}}
  <link rel="stylesheet" href="{{ asset('plugin/sweetalert/dist/sweetalert2.min.css') }}">
  {{-- Select2 --}}
  <link rel="stylesheet" href="{{ asset('plugin/select2/select2.min.css') }}">

  {{-- Favicon --}}
  <link rel="shortcut icon" href="{{ $setting ? asset('storage/' . $setting->favicon) : asset('favicon.ico') }}">

  @stack('css')
  @vite(['resources/css/app.css', 'resources/css/select2.css'])

  <title>{{ $judul }}</title>

  <meta name="robots" content="noindex">
  <meta name="googlebot" content="noindex">
  <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>

<div class="relative flex flex-row">

  @if(!Request::is('cmslogin'))
    @include('admin.layouts.sidebar')
    @include('admin.layouts.navbar')

  <div class="relative flex w-full md:w-10/12 flex-shrink-0 flex-grow-0">
    
    @yield('admincontent')

    @include('admin.layouts.footer')

  </div>

  @else
    @yield('admincontent')
  @endif

</div>

@include('sweetalert::alert')

{{-- Jquery --}}
<script src="{{ asset('plugin/jquery/jquery-3.6.0.min.js') }}"></script>
{{-- CKEditor 4.19 --}}
{{-- <script src="{{ asset('plugin/ckeditor/ckeditor.js') }}"></script> --}}
{{-- CKEditor 5.41 --}}
<script src="{{ asset('plugin/ckeditor5/build/ckeditor.js') }}"></script>
{{-- DataTables --}}
<script src="{{ asset('plugin/datatables/datatables.min.js') }}"></script>
{{-- SweetAlert 2 --}}
<script src="{{ asset('plugin/sweetalert/dist/sweetalert2.all.min.js') }}"></script>
{{-- Select2 --}}
<script src="{{ asset('plugin/select2/select2.min.js') }}"></script>

@stack('js')

</body>
</html>