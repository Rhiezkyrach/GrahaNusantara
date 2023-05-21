<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700;1,900&display=swap" as="style">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    {{-- Tailwind CSS 3.0.24 --}}
    <link href="{{ asset('css/app.css?v=') . filemtime('css/app.css') }}" rel="stylesheet">
    {{-- Swiper CSS 8.2.2 --}}
    <link href="{{ asset('plugin/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    {{-- Font Awesome 6.1.1 --}}
    <link href="{{ asset('plugin/fontawesome/css/all.min.css') }}" rel="stylesheet">
    {{-- Style CSS --}}
    <link href="{{ asset('css/style.css?v=') . filemtime('css/style.css') }}" rel="stylesheet">
    {{-- Jquery --}}
    <script src="{{ asset('plugin/jquery/jquery-3.6.0.min.js') }}"></script>

    <!-- PWA  -->
    <meta name="theme-color" content="#d10010"/>
    <link rel="apple-touch-icon" href="{{ asset('raja_media.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <title>{!! $judul !!}</title>

    @if($setting->headcode)
      {!! $setting->headcode !!}
    @endif

    <link rel="canonical" href="{{ url()->current() }}">

    <meta name="robots" content="index,follow" />
    <meta name="googlebot" content="index,follow" />
    <meta name="googlebot-news" content="index,follow" />
    <meta name="msnbot" content="index,follow" />
    <meta name="webcrawlers" content="index,follow" />
    <meta name="spiders" content="index,follow" />
    <meta name="rating" content="general" />

    <meta name="description" content="{{ $deskripsi }}" />
    <meta name="keywords" content="{{ $keyword }}" />
    <meta name="news_keywords" content="{{ $keyword }}" />
    <meta name="author" content="{{ $author }}" />

    {{-- Open Graph --}}
    <meta property="fb:pages" content="1380957078884401" />
    <meta property="og:url" content="https://{{  $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $judul }}" />
    <meta property="og:description" content="{{ $deskripsi }}" />
    <meta property="og:image" content="{{ $foto }}" />
    <meta property="og:site_name" content="{{ $setting->judul_situs }}" />
    <meta property="article:author" content="{{ $author }}" />
    <meta property="article:publisher" content="https://web.facebook.com/profile.php?id=100076537295731" />
    <meta property="fb:app_id" content="559785848921682" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@RM_RajaMedia" />
    <meta name="twitter:creator" content="@RM_RajaMedia" />
    <meta name="twitter:title" content="{{ $judul }}">
    <meta name="twitter:description" content="{{ $deskripsi }}"/>
    <meta name="twitter:image" content="{{ $foto }}"/>

    {{-- Facebook --}}
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v14.0&appId=559785848921682&autoLogAppEvents=1" nonce="qMPcSAt9"></script>

    {{-- Sharethis --}}
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=62b153cc17626600191f44a5&product=sop' async='async'></script>

    {{-- Dark Mode Check --}}
    <script>
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark')
    }
    </script>

</head>
