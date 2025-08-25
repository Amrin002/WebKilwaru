<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:content="http://purl.org/rss/1.0/modules/content/">
    <channel>
        <title>{{ config('app.village_name', 'Desa Kilwaru') }} - Berita</title>
        <link>{{ route('berita.index') }}</link>
        <description>Berita terbaru dari {{ config('app.village_name', 'Desa Kilwaru') }}</description>
        <language>id-ID</language>
        <lastBuildDate>{{ now()->toRssString() }}</lastBuildDate>
        <atom:link href="{{ route('berita.rss') }}" rel="self" type="application/rss+xml" />
        <generator>Laravel RSS Feed</generator>
        <webMaster>{{ config('mail.from.address', 'admin@desakilwaru.id') }} ({{ config('app.village_name') }})
        </webMaster>
        <copyright>Copyright {{ date('Y') }} {{ config('app.village_name', 'Desa Kilwaru') }}</copyright>

        @foreach ($beritas as $berita)
            <item>
                <title>
                    <![CDATA[{{ $berita->judul }}]]>
                </title>
                <link>{{ route('berita.show', $berita->slug) }}</link>
                <description>
                    <![CDATA[{{ $berita->excerpt_formatted }}]]>
                </description>
                <content:encoded>
                    <![CDATA[{!! $berita->konten !!}]]>
                </content:encoded>
                <pubDate>{{ $berita->published_at->toRssString() }}</pubDate>
                <guid isPermaLink="true">{{ route('berita.show', $berita->slug) }}</guid>
                @if ($berita->kategoriBeri)
                    <category>
                        <![CDATA[{{ $berita->kategoriBeri->nama }}]]>
                    </category>
                @endif
                @if ($berita->gambar)
                    <enclosure url="{{ $berita->gambar_url }}" type="image/jpeg" length="0" />
                @endif
                <author>{{ config('mail.from.address', 'admin@desakilwaru.id') }} ({{ $berita->penulis ?? 'Admin' }})
                </author>
                @if ($berita->tags && count($berita->tags) > 0)
                    @foreach ($berita->tags as $tag)
                        <category>
                            <![CDATA[{{ $tag }}]]>
                        </category>
                    @endforeach
                @endif
            </item>
        @endforeach
    </channel>
</rss>
