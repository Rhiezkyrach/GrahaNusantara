<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ID Card - {{ $data ? $data->name : '' }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $setting ? asset('storage/' . $setting->favicon) : '' }}">

    <style>
        @page { size: 55mm 85mm; margin: 0}
    body {
        font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
        font-size: 12px;
    }

    * {
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }

    .container{
        position: relative;
        width: 55mm;
        height: 85mm;
        background-color: azure;
    }

    .container_back{
        position: relative;
        width: 55mm;
        height: 85mm;
        background-color: darkred;
    }

    .background{
        width: 100%; 
        height: 60%; 
        position:absolute; 
        top: 0;  
        z-index: -1;
    }

    .background > img{
        width: 100%; 
        object-fit: cover;
    }

    .logo-container {
        position: relative;
        width: 140px;
        height: 30px;
        padding: 10px 5px 10px 5px;
        background-color: white;
        margin: auto;
        border-radius: 0px 0px 10px 10px;
        text-align: center;
        overflow: hidden;
    }

    .logo-img {
        /* position: absolute; */
        display: block;
        /* bottom: 5px; */
        margin-left: auto; 
        margin-right: auto; 
        /* transform: translate(-50%, -50%); */
        max-height: 30px;
        max-width: 135px;
        object-fit: cover;
    }

    .pers{
        font-size: 50px;
        color: white;
        text-align: center;
    }

    .foto-container {
        width: 120px;
        height: 120px;
        background-color: white;
        margin: auto;
        border-radius: 100px;
        overflow: hidden;
        border: 5px solid darkred;
    }

    .foto-container > img {
        /* margin: auto; */
        width: 100%;
        /* height: 100%; */
        object-fit: cover;
    }

    .nama{
        margin-top: 12px;
        margin-bottom: 5px;
        font-size: 14px;
        color: darkred;
        font-weight: bold;
        text-transform: uppercase;
        text-align: center;
    }

    .footer{
        width: 100%;
        display: block;
        position:absolute; 
        bottom: 0;  
    }

    .site > p {
        font-size: 9px;
        color:white;
        padding-top: 2px;
        padding-bottom: 4px;
        text-align: center;
        margin: auto;
        background-color:darkblue;
    }

    .footer > p {
        font-size: 7.5px;
        color:white;
        padding-top: 8px;
        padding-bottom: 8px;
        text-align: center;
        margin: auto;
        background-color:darkred;
    }

    .content_back{
        position: absolute;
        top: 0;
        padding: 15px;
    }

    .content_backborder {
        height:100%;
        padding-left: 10px;
        padding-right: 10px;
        border: 1.5px solid white;
        border-radius: 5px;
    }

    .content_backborder > p {
        font-size: 9px;
        color:white;
        text-align: center;
    }

    .signature {
        margin-top: 15px;
        padding: 2px;
        width:60%; 
        height:40px; 
        margin:auto; 
        background_color:white; 
        border-radius:5px;
        overflow: hidden;
        text-align: center;
    }

    .signature > img {
        display: block;
        height: 40px;
        margin: auto;
        object-fit: cover;
    }

    .cp {
        margin-top: 15px;
        padding: 2px;
        width:60%; 
        height:40px; 
        margin:auto; 
        background_color:white; 
        border-radius:5px;
        overflow: hidden;
    }

    .title{
        
    }

    .text-xs {
        font-size: 8px;
    }

    .text-sm {
        font-size: 10px;
    }

    .text-md {
        font-size: 14px;
    }

    .whitespace-nowrap{
        white-space: nowrap;
    }

    .font-bold {
        font-weight: bold;
    }
    </style>
</head>
<body>
    {{-- FRONT --}}
    <div class="container">
        <div class='background'>
            <img src="{{ asset('images/bg_idcard.png') }}" alt="">
        </div>
        <div class="logo-container">
            <img class="logo-img" src="{{ $setting ? asset('storage/' . $setting->logo) : '' }}" alt="">
        </div>

        <div class="pers">PERS</div>

        <div class="foto-container">
            <img src="{{ $data->profile_photo_path ? asset('storage/' . $data->profile_photo_path) : asset('images/profile-default.png')}}" alt="">
        </div>

        <div class="nama">{{ $data->name }}</div>

        
        <div class="footer">

            <div class="site">
                <p>{{ $setting->Network ? parse_url($setting->Network->url, PHP_URL_HOST) : $setting->judul_situs }}</p>
            </div>

            <p style="text-transform: uppercase;">BERLAKU HINGGA {{ $data->valid_to ? Carbon\Carbon::parse($data->valid_to)->translatedFormat('d F Y') : Carbon\Carbon::now()->endOfYear()->translatedFormat('d F Y') }}</p>
        </div>
    </div>

    {{-- BACK --}}
    <div class="container_back">
        <div class="content_back">
            <div class="content_backborder">

                {{-- <p style="margin-top:15px">ID Card ini berlaku selama pemegang masih berstatus karyawan <span style="font-weight:700; color:yellow">{{ $setting->judul_situs }}.</span></p> --}}
                <p style="margin-top:15px">ID Card diterbitkan <span style="font-weight:700; color:yellow">Raja Media Network.</span></p>
                <p>Bagi yang menemukan ID Card ini, mohon dikembalikan ke Kantor Redaksi <span style="font-weight:700; color:yellow">{{ $setting->judul_situs }}.</span></p>
                <p>Atas segala bantuan yang diberikan kepada pemegang id card ini, dalam melaksanakan tugas jurnalistik, kami ucapkan terima kasih.</p>
                
                <p style="font-weight:700; margin-top:20px; color:yellow">ALAMAT KANTOR REDAKSI:</p>
                <p style="font-size: 8px; margin-top:-5px">{{ $setting->alamat }}</p>

                <div class="signature">
                    <img src="{{ $struktur ? asset('storage/' . $struktur->ttd) : '' }}" alt="">
                </div>

                <p style="font-size: 10px; font-weight:700; margin-top: 6px; text-transform: uppercase;">{{ $struktur && $struktur->User ? $struktur->User->name : '' }}</p>
                <p style="font-size: 7px; margin-top:-10px">{{ $struktur ? $struktur->jabatan : '' }}</p>
            </div>

        </div>
    </div>
</body>
</html>
