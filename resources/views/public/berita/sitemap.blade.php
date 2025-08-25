<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
    xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"
    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
                            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

    <!-- Homepage -->
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->toW3cString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    <!-- Berita Index -->
    <url>
        <loc>{{ route('berita.index') }}</loc>
        <lastmod>{{ now()->toW3cString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>

    <!-- Berita Archive -->
    <url>
        <loc>{{ route('berita.archive') }}</loc>
        <lastmod>{{ now()->toW3cString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.7</priority>
    </url>

    <!-- Categories -->
    @foreach ($categories as $category)
        <url>
            <loc>{{ route('berita.kategori', $category->slug) }}</loc>
            <lastmod>{{ $category->updated_at->toW3cString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    <!-- Individual Berita -->
    @foreach ($beritas as $berita)
        <url>
            <loc>{{ route('berita.show', $berita->slug) }}</loc>
            <lastmod>{{ $berita->updated_at->toW3cString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.6</priority>

            @if ($berita->gambar)
                <image:image>
                    <image:loc>{{ $berita->gambar_url }}</image:loc>
                    <image:title>
                        <![CDATA[{{ $berita->judul }}]]>
                    </image:title>
                    <image:caption>
                        <![CDATA[{{ $berita->excerpt_formatted }}]]>
                    </image:caption>
                </image:image>
            @endif

            <news:news>
                <news:publication>
                    <news:name>{{ config('app.village_name', 'Desa Kilwaru') }}</news:name>
                    <news:language>id</news:language>
                </news:publication>
                <news:publication_date>{{ $berita->published_at->toW3cString() }}</news:publication_date>
                <news:title>
                    <![CDATA[{{ $berita->judul }}]]>
                </news:title>
                @if ($berita->tags && count($berita->tags) > 0)
                    <news:keywords>
                        <![CDATA[{{ implode(',', $berita->tags) }}]]>
                    </news:keywords>
                @endif
            </news:news>
        </url>
    @endforeach
</urlset>
