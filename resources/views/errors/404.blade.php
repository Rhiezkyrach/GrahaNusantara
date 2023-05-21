<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    {{-- Tailwind CSS 3.0.12 --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <title>Halaman Tidak Ditemukan - SinPo.id</title>
</head>
<body>
    <div class="flex flex-col w-full px-10 py-auto min-h-screen bg-gray-100/50 items-center justify-center">
        <img class="block w-96 object-cover" src="{{ asset('images/notfound.png') }}" alt="">
        <div class="mt-4 text-center text-2xl md:text-3xl font-bold">Halaman Tidak Ditemukan</div>
        <div class="mt-1 text-center text-sm">Kemungkinan halaman telah dihapus, atau anda salah menuliskan URL.</div>
        <div class="mt-4 text-center bg-sky-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md"><a href="{{ url('/') }}">Kembali ke Beranda</a></div>
    </div>

</body>
</html>