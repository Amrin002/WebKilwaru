@extends('template.main')

@section('title', $berita->judul . ' - ' . config('app.village_name', 'Desa Kilwaru'))
@section('description', $berita->excerpt_formatted)

@push('head')
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $berita->judul }}">
    <meta property="og:description" content="{{ $berita->excerpt_formatted }}">
    <meta property="og:image" content="{{ $berita->gambar_url }}">
    <meta property="og:url" content="{{ route('berita.show', $berita->slug) }}">
    <meta property="og:type" content="article">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $berita->judul }}">
    <meta name="twitter:description" content="{{ $berita->excerpt_formatted }}">
    <meta name="twitter:image" content="{{ $berita->gambar_url }}">
@endpush

@push('styles')
    <style>
        .article-header {
            background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 89, 0.8)),
                url('{{ $berita->gambar_url }}') center/cover;
            color: white;
            padding: 150px 0 50px;
            margin-top: -80px;
            position: relative;
        }

        .article-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(to top, white, transparent);
        }

        .article-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #333;
        }

        .article-content p {
            margin-bottom: 1.5rem;
        }

        .article-content img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin: 2rem 0;
        }

        .article-content h2,
        .article-content h3,
        .article-content h4 {
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: var(--primary-green);
        }

        .article-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .article-meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--soft-gray);
        }

        .share-buttons {
            display: flex;
            gap: 10px;
            margin-top: 2rem;
        }

        .share-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f0f0f0;
            color: #333;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .share-btn:hover {
            transform: translateY(-3px);
        }

        .share-btn.facebook:hover {
            background: #1877f2;
            color: white;
        }

        .share-btn.twitter:hover {
            background: #1da1f2;
            color: white;
        }

        .share-btn.whatsapp:hover {
            background: #25d366;
            color: white;
        }

        .share-btn.telegram:hover {
            background: #0088cc;
            color: white;
        }

        .related-article {
            transition: all 0.3s ease;
        }

        .related-article:hover {
            transform: translateY(-5px);
        }

        .navigation-links {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 3rem;
            padding-top: 3rem;
            border-top: 2px solid #f0f0f0;
        }

        .nav-link-card {
            flex: 1;
            min-width: 250px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
        }

        .nav-link-card:hover {
            background: var(--primary-green);
            color: white;
            transform: translateY(-3px);
        }

        .comment-section {
            margin-top: 3rem;
            padding-top: 3rem;
            border-top: 2px solid #f0f0f0;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin-bottom: 2rem;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "›";
            font-size: 1.2rem;
            color: var(--soft-gray);
        }
    </style>
@endpush

@section('content')
    <!-- Article Header -->
    <header class="article-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    @if ($berita->kategoriBeri)
                        <span class="badge mb-3"
                            style="background-color: {{ $berita->kategoriBeri->warna }}; font-size: 0.9rem; padding: 8px 20px;">
                            {{ $berita->kategoriBeri->nama }}
                        </span>
                    @endif
                    <h1 class="display-4 fw-bold mb-4">{{ $berita->judul }}</h1>
                    <p class="lead">{{ $berita->excerpt_formatted }}</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Article Content -->
                <div class="col-lg-8">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('berita.index') }}">Berita</a></li>
                            @if ($berita->kategoriBeri)
                                <li class="breadcrumb-item">
                                    <a href="{{ route('berita.kategori', $berita->kategoriBeri->slug) }}">
                                        {{ $berita->kategoriBeri->nama }}
                                    </a>
                                </li>
                            @endif
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ Str::limit($berita->judul, 30) }}
                            </li>
                        </ol>
                    </nav>

                    <!-- Article Meta -->
                    <div class="article-meta">
                        <div class="article-meta-item">
                            <i class="bi bi-person-circle"></i>
                            <span>{{ $berita->penulis ?? 'Admin' }}</span>
                        </div>
                        <div class="article-meta-item">
                            <i class="bi bi-calendar3"></i>
                            <span>{{ $berita->published_at->format('d F Y') }}</span>
                        </div>
                        <div class="article-meta-item">
                            <i class="bi bi-clock"></i>
                            <span>{{ $berita->published_at_relative }}</span>
                        </div>
                        <div class="article-meta-item">
                            <i class="bi bi-eye"></i>
                            <span>{{ $berita->views }} views</span>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    @if ($berita->gambar)
                        <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}"
                            class="img-fluid rounded-3 mb-4 w-100">
                    @endif

                    <!-- Article Content -->
                    <div class="article-content">
                        {!! $berita->konten !!}
                    </div>

                    <!-- Tags -->
                    @if ($berita->tags && count($berita->tags) > 0)
                        <div class="mt-4">
                            <i class="bi bi-tags"></i>
                            @foreach ($berita->tags as $tag)
                                <span class="badge bg-secondary me-2">{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    @endif

                    <!-- Share Buttons -->
                    <div class="share-buttons">
                        <span class="me-3">Bagikan:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('berita.show', $berita->slug)) }}"
                            target="_blank" class="share-btn facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('berita.show', $berita->slug)) }}&text={{ urlencode($berita->judul) }}"
                            target="_blank" class="share-btn twitter">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($berita->judul . ' ' . route('berita.show', $berita->slug)) }}"
                            target="_blank" class="share-btn whatsapp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <a href="https://t.me/share/url?url={{ urlencode(route('berita.show', $berita->slug)) }}&text={{ urlencode($berita->judul) }}"
                            target="_blank" class="share-btn telegram">
                            <i class="bi bi-telegram"></i>
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="navigation-links">
                        @if ($previousBerita)
                            <a href="{{ route('berita.show', $previousBerita->slug) }}" class="nav-link-card">
                                <small class="text-muted d-block mb-2">
                                    <i class="bi bi-arrow-left"></i> Berita Sebelumnya
                                </small>
                                <strong>{{ $previousBerita->judul }}</strong>
                            </a>
                        @endif

                        @if ($nextBerita)
                            <a href="{{ route('berita.show', $nextBerita->slug) }}" class="nav-link-card text-end">
                                <small class="text-muted d-block mb-2">
                                    Berita Selanjutnya <i class="bi bi-arrow-right"></i>
                                </small>
                                <strong>{{ $nextBerita->judul }}</strong>
                            </a>
                        @endif
                    </div>

                    <!-- Comment Section (Optional) -->
                    <div class="comment-section">
                        <h4 class="mb-4">Komentar</h4>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            Fitur komentar akan segera tersedia. Tetap pantau berita terbaru dari kami!
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Related Articles -->
                    @if ($relatedBerita->count() > 0)
                        <div class="sidebar-widget">
                            <h5>Berita Terkait</h5>
                            @foreach ($relatedBerita as $related)
                                <div class="sidebar-item">
                                    <article class="related-article">
                                        <div class="d-flex gap-3">
                                            <img src="{{ $related->gambar_url }}" alt="{{ $related->judul }}"
                                                style="width: 100px; height: 80px; object-fit: cover; border-radius: 8px;">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">
                                                    <a href="{{ route('berita.show', $related->slug) }}"
                                                        class="text-decoration-none text-dark">
                                                        {{ $related->judul }}
                                                    </a>
                                                </h6>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar"></i>
                                                    {{ $related->published_at->format('d M Y') }}
                                                </small>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Popular News -->
                    <div class="sidebar-widget">
                        <h5>Berita Populer</h5>
                        @foreach ($popularBerita as $popular)
                            <div class="sidebar-item">
                                <h6 class="mb-1">
                                    <a href="{{ route('berita.show', $popular->slug) }}"
                                        class="text-decoration-none text-dark">
                                        {{ $popular->judul }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <i class="bi bi-eye"></i> {{ $popular->views }} views
                                </small>
                            </div>
                        @endforeach
                    </div>

                    <!-- Latest News -->
                    <div class="sidebar-widget">
                        <h5>Berita Terbaru</h5>
                        @foreach ($latestBerita as $latest)
                            <div class="sidebar-item">
                                <h6 class="mb-1">
                                    <a href="{{ route('berita.show', $latest->slug) }}"
                                        class="text-decoration-none text-dark">
                                        {{ $latest->judul }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <i class="bi bi-calendar"></i> {{ $latest->published_at_relative }}
                                </small>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Copy link to clipboard
        function copyLink() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                alert('Link berhasil disalin!');
            });
        }

        // Print article
        function printArticle() {
            window.print();
        }
    </script>
@endpush
