<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
                            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd
                            http://www.google.com/schemas/sitemap-news/0.9
                            http://www.google.com/schemas/sitemap-news/0.9/sitemap-news.xsd"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

    @foreach ($berita as $b)   
        <url>
            <loc>{{ url('/berita/' . $b->slug ) }}</loc>
            <news:news>
                <news:publication>
                    <news:name>{{ $setting->judul_situs }}</news:name>
                    <news:language>id</news:language>
                </news:publication>
                <news:publication_date>{{ Carbon\Carbon::parse($b->tanggal_tayang)->toISOString() }}</news:publication_date>
                <news:title>{{ strip_tags(html_entity_decode($b->judul)) }}</news:title>
                <news:keywords><![CDATA[{{ $b->tag }}]]></news:keywords>
            </news:news>
            <image:image>
                <image:loc>{{ asset('storage/' . $b->gambar_detail) }}</image:loc>
                <image:title><![CDATA[{{ $b->judul }}]]></image:title>
                <image:caption><![CDATA[{{ $b->caption }}]]></image:caption>
            </image:image>
        </url>
    @endforeach

</urlset>