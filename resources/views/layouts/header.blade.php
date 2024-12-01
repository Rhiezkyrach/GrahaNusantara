<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- Google Font: Figtree --}}
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    {{-- Splide 4.1.3 --}}
    <link rel="stylesheet" href="{{ asset('plugin/splide/dist/css/splide.min.css') }}"></link>
    {{-- Font Awesome 6.2.1 --}}
    <link href="{{ asset('plugin/fontawesome/css/all.css') }}" rel="stylesheet">

    @stack('css')
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/script.js'])

    <!-- PWA  -->
    <meta name="theme-color" content="#d10010"/>
    <link rel="apple-touch-icon" href="{{ asset('idisnews.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ $setting ? asset('storage/' . $setting->favicon) : asset('favicon.ico') }}">

    <title>{!! isset($berita) ? $berita->judul : $judul !!}</title>

    @if($setting->headcode)
      {!! $setting->headcode !!}
    @endif

    {{-- BEGIN: META TAG SEO --}}
    <link rel="canonical" href="{{ request()->fullUrl() }}">
    <meta name="robots" content="index,follow" />

    @if(isset($berita))
        @php
            $paragraphs = explode('</p>', $berita->isi);
            $deskripsi = html_entity_decode(strip_tags($paragraphs[0]));
        @endphp

        <meta name="description" content="{{ substr($deskripsi, 0, 150) }}" />
        <meta name="keywords" content="{{ $berita->tag }}" />
        <meta name="news_keywords" content="{{ $berita->tag }}" />
        <meta name="author" content="{{ $berita->wartawan }}" />

        {{-- Open Graph --}}
        <meta property="fb:pages" content="1380957078884401" />
        <meta property="og:url" content="{{ request()->fullUrl() }}" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="{{ $berita->judul }}" />
        <meta property="og:description" content="{{ substr($deskripsi, 0, 150) }}" />
        <meta property="og:image" content="{{ asset('storage/' . $berita->gambar_detail) }}" />
        <meta property="og:image:secure_url" content="{{ asset('storage/' . $berita->gambar_detail) }}" />
        <meta property="og:site_name" content="{{ $setting->judul_situs }}" />
        <meta property="article:author" content="{{ $berita->wartawan }}" />
        <meta property="article:publisher" content="https://web.facebook.com/profile.php?id=100076537295731" />
        <meta property="fb:app_id" content="1488921425167603" />
        
        {{-- Twitter Card --}}
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="@GrahaNusantara" />
        <meta name="twitter:creator" content="@GrahaNusantara" />
        <meta name="twitter:title" content="{{ $berita->judul }}">
        <meta name="twitter:description" content="{{ substr($deskripsi, 0, 150) }}"/>
        <meta name="twitter:image" content="{{ asset('storage/' . $berita->gambar_detail) }}"/>

        {{-- Schema Markup JSON-LD --}}
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "NewsArticle",
            "headline": "{{ $berita->judul }}",
            "description": "{{ strip_tags(substr($deskripsi, 0, 150)) }}",
            "datePublished": "{{ Carbon\Carbon::parse($berita->tanggal_tayang)->toISOString() }}",
            "author": {
                "@type": "Person",
                "name": "{{ $berita->wartawan }}"
            },
            "publisher": {
                "@type": "Organization",
                "name": "{{ $setting->judul_situs }}",
                "logo": {
                    "@type": "ImageObject",
                    "url": "{{ $setting ? asset('storage/' . $setting->logo) : asset('images/idis_news.png') }}"
                }
            },
            "image": ["{{ asset('storage/' . $berita->gambar_detail) }}"]
        }
        </script>
        
    @else
        <meta name="description" content="{{ $deskripsi }}" />
        <meta name="keywords" content="{{ $keyword }}" />
        <meta name="news_keywords" content="{{ $keyword }}" />
        <meta name="author" content="{{ $author }}" />
    @endif
    {{-- END: META TAG SEO --}}

    {{-- Facebook --}}
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v14.0&appId=1488921425167603&autoLogAppEvents=1" nonce="qMPcSAt9"></script>

    {{-- Dark Mode Check --}}
    <script>
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark')
    }
    </script>

</head>
