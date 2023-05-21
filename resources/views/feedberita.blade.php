<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<rss version="2.0"
    xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:media="http://search.yahoo.com/mrss/"
    xmlns:atom="http://www.w3.org/2005/Atom">

    <channel>
        <title>Berita Terbaru - {{ $setting->judul_situs }}</title>
        <link>{{ url('/') }}</link>
        <atom:link href="{{ url('/feedberita') }}" rel="self" type="application/rss+xml" />
        <description>{{ $setting->deskripsi }}</description>
        <language>id</language>

        @foreach($berita as $b)
            <item>
                <title><![CDATA[{!! strip_tags($b->judul) !!}]]></title>
                <link>{{ url('/berita/' . $b->slug ) }}</link>
                <description><![CDATA[{!! Str::words($b->isi, 25) !!}]]></description>
                <category>{{ $b->kategori->nama }}</category>
                <author>{{ $b->wartawan }}</author>
                <guid>{{ url('/berita/' . $b->slug ) }}</guid>
                <pubDate>{{ date(DATE_RFC2822, strtotime($b->tanggal_tayang . $b->waktu)) }}</pubDate>
                <media:content url='{{ asset('storage/'. $b->gambar_detail) }}' type='image/jpeg' expression='full' width='650' height='400'>
                </media:content>
            </item>
        @endforeach

    </channel>

</rss>
