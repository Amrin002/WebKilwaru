@extends('template.main')

@section('title', 'Berita - ' . config('app.village_name', 'Desa Kilwaru'))
@section('description', 'Berita terbaru dan informasi penting seputar ' . config('app.village_name', 'Desa Kilwaru'))

@push('styles')
    <style>
        .berita-hero {
            background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 89, 0.8)),
                url('https://images.unsplash.com/photo-1504711434969-e33886168f5c?ixlib=rb-4.0.3') center/cover;
            color: white;
            padding: 100px 0 50px;
            margin-top: -80px;
            padding-top: 160px;
        }

        .filter-btn {
            background: white;
            border: 2px solid var(--primary-green);
            color: var(--primary-green);
            padding: 8px 20px;
            border-radius: 50px;
            transition: all 0.3s ease;
            margin: 5px;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: var(--primary-green);
            color: white;
            transform: translateY(-2px);
        }

        .search-box {
            position: relative;
            max-width: 500px;
            margin: 0 auto;
        }

        .search-box input {
            width: 100%;
            padding: 15px 50px 15px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 50px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            border-color: var(--accent-orange);
            box-shadow: 0 0 0 0.2rem rgba(255, 140, 66, 0.25);
        }

        .search-box button {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--accent-orange);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .search-box button:hover {
            background: #e07a35;
            transform: translateY(-50%) scale(1.1);
        }

        .berita-card {
            height: 100%;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .berita-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .berita-card .card-img-top {
            height: 220px;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .berita-card:hover .card-img-top {
            transform: scale(1.05);
        }

        .berita-meta {
            font-size: 0.875rem;
            color: var(--soft-gray);
        }

        .sidebar-widget {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .sidebar-widget h5 {
            color: var(--primary-green);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--accent-orange);
        }

        .sidebar-item {
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .sidebar-item:last-child {
            border-bottom: none;
        }

        .sidebar-item:hover {
            padding-left: 10px;
            background: #f8f9fa;
            margin: 0 -10px;
            padding-right: 10px;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
        }

        .empty-state i {
            font-size: 5rem;
            color: var(--soft-gray);
            margin-bottom: 20px;
        }

        .category-badge {
            font-size: 0.75rem;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="berita-hero">
        <div class="container">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-4">Berita & Informasi</h1>
                <p class="lead">Dapatkan informasi terkini seputar kegiatan dan perkembangan
                    {{ config('app.village_name', 'Desa Kilwaru') }}</p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <!-- Search and Filter -->
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto">
                    <form action="{{ route('berita.index') }}" method="GET" class="search-box mb-4">
                        <input type="text" name="search" placeholder="Cari berita..." value="{{ request('search') }}">
                        <button type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>

                    <div class="text-center">
                        <button
                            class="filter-btn {{ !request('kategori') || request('kategori') == 'all' ? 'active' : '' }}"
                            onclick="filterByCategory('all')">
                            Semua Berita
                        </button>
                        @foreach ($kategoriList as $kategori)
                            <button class="filter-btn {{ request('kategori') == $kategori->slug ? 'active' : '' }}"
                                onclick="filterByCategory('{{ $kategori->slug }}')">
                                {{ $kategori->nama }} ({{ $kategori->published_beritas_count }})
                            </button>
                        @endforeach
                    </div>

                    <div class="text-center mt-3">
                        <select class="form-select d-inline-block w-auto" onchange="sortBerita(this.value)">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    @if (request('search'))
                        <div class="alert alert-info mb-4">
                            Menampilkan hasil pencarian untuk: <strong>{{ request('search') }}</strong>
                            <a href="{{ route('berita.index') }}" class="float-end">Hapus Filter</a>
                        </div>
                    @endif

                    @if ($featuredBerita->count() > 0 && !request('search') && !request('page'))
                        <!-- Featured News -->
                        <div class="mb-5">
                            <h3 class="mb-4">Berita Utama</h3>
                            <div id="featuredCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($featuredBerita as $index => $featured)
                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                            <div class="card border-0 overflow-hidden">
                                                <div class="row g-0">
                                                    <div class="col-md-6">
                                                        <img src="{{ $featured->gambar_url }}"
                                                            alt="{{ $featured->judul }}" class="img-fluid h-100"
                                                            style="object-fit: cover;">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card-body p-4">
                                                            @if ($featured->kategoriBeri)
                                                                <span class="category-badge"
                                                                    style="background-color: {{ $featured->kategoriBeri->warna }}; color: white;">
                                                                    {{ $featured->kategoriBeri->nama }}
                                                                </span>
                                                            @endif
                                                            <h4 class="card-title mt-3">{{ $featured->judul }}</h4>
                                                            <p class="card-text">{{ $featured->excerpt_formatted }}</p>
                                                            <div class="berita-meta mb-3">
                                                                <i class="bi bi-calendar"></i>
                                                                {{ $featured->published_at->format('d M Y') }} |
                                                                <i class="bi bi-eye"></i> {{ $featured->views }} views
                                                            </div>
                                                            <a href="{{ route('berita.show', $featured->slug) }}"
                                                                class="btn btn-primary">
                                                                Baca Selengkapnya
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if ($featuredBerita->count() > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#featuredCarousel"
                                        data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#featuredCarousel"
                                        data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- News Grid -->
                    <div class="row">
                        @forelse($beritas as $berita)
                            <div class="col-md-6 mb-4">
                                <div class="card berita-card h-100">
                                    <div class="overflow-hidden">
                                        <img src="{{ $berita->gambar_url }}" class="card-img-top"
                                            alt="{{ $berita->judul }}">
                                    </div>
                                    <div class="card-body">
                                        @if ($berita->kategoriBeri)
                                            <span class="category-badge"
                                                style="background-color: {{ $berita->kategoriBeri->warna }}; color: white;">
                                                {{ $berita->kategoriBeri->nama }}
                                            </span>
                                        @endif
                                        <h5 class="card-title mt-2">
                                            <a href="{{ route('berita.show', $berita->slug) }}"
                                                class="text-decoration-none text-dark">
                                                {{ $berita->judul }}
                                            </a>
                                        </h5>
                                        <p class="card-text">{{ $berita->excerpt_formatted }}</p>
                                        <div class="berita-meta">
                                            <i class="bi bi-calendar"></i> {{ $berita->published_at_relative }} |
                                            <i class="bi bi-eye"></i> {{ $berita->views }} views
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent border-top-0">
                                        <a href="{{ route('berita.show', $berita->slug) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            Baca Selengkapnya <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="empty-state">
                                    <i class="bi bi-newspaper"></i>
                                    <h4>Tidak Ada Berita</h4>
                                    <p class="text-muted">
                                        @if (request('search'))
                                            Tidak ditemukan berita dengan kata kunci "{{ request('search') }}"
                                        @else
                                            Belum ada berita yang dipublikasikan
                                        @endif
                                    </p>
                                    @if (request('search'))
                                        <a href="{{ route('berita.index') }}" class="btn btn-primary">
                                            Lihat Semua Berita
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if ($beritas->hasPages())
                        <div class="d-flex justify-content-center mt-5">
                            {{ $beritas->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Popular News Widget -->
                    <div class="sidebar-widget">
                        <h5>Berita Populer</h5>
                        @forelse($popularBerita as $popular)
                            <div class="sidebar-item">
                                <div class="d-flex gap-3">
                                    <img src="{{ $popular->gambar_url }}" alt="{{ $popular->judul }}"
                                        style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            <a href="{{ route('berita.show', $popular->slug) }}"
                                                class="text-decoration-none text-dark">
                                                {{ Str::limit($popular->judul, 50) }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">
                                            <i class="bi bi-eye"></i> {{ $popular->views }} views
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">Belum ada berita populer</p>
                        @endforelse
                    </div>

                    <!-- Latest News Widget -->
                    <div class="sidebar-widget">
                        <h5>Berita Terbaru</h5>
                        @forelse($latestBerita as $latest)
                            <div class="sidebar-item">
                                <h6 class="mb-1">
                                    <a href="{{ route('berita.show', $latest->slug) }}"
                                        class="text-decoration-none text-dark">
                                        {{ Str::limit($latest->judul, 60) }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <i class="bi bi-calendar"></i> {{ $latest->published_at_relative }}
                                </small>
                            </div>
                        @empty
                            <p class="text-muted">Belum ada berita terbaru</p>
                        @endforelse
                    </div>

                    <!-- Categories Widget -->
                    <div class="sidebar-widget">
                        <h5>Kategori</h5>
                        @foreach ($kategoriList as $kategori)
                            <div class="sidebar-item">
                                <a href="{{ route('berita.kategori', $kategori->slug) }}"
                                    class="text-decoration-none d-flex justify-content-between align-items-center">
                                    <span class="text-dark">
                                        <i class="bi bi-folder" style="color: {{ $kategori->warna }}"></i>
                                        {{ $kategori->nama }}
                                    </span>
                                    <span class="badge bg-secondary rounded-pill">
                                        {{ $kategori->published_beritas_count }}
                                    </span>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Archive Widget -->
                    <div class="sidebar-widget">
                        <h5>Arsip</h5>
                        <div class="sidebar-item">
                            <a href="{{ route('berita.archive') }}" class="text-decoration-none text-dark">
                                <i class="bi bi-archive"></i> Lihat Arsip Berita
                            </a>
                        </div>
                    </div>

                    <!-- RSS Feed Widget -->
                    <div class="sidebar-widget">
                        <h5>Subscribe</h5>
                        <div class="sidebar-item">
                            <a href="{{ route('berita.rss') }}" class="text-decoration-none text-dark" target="_blank">
                                <i class="bi bi-rss-fill text-warning"></i> RSS Feed
                            </a>
                        </div>
                        <div class="sidebar-item">
                            <a href="#" class="text-decoration-none text-dark" onclick="copyRSSLink(event)">
                                <i class="bi bi-clipboard text-info"></i> Copy RSS Link
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function filterByCategory(slug) {
            const url = new URL(window.location);
            if (slug === 'all') {
                url.searchParams.delete('kategori');
            } else {
                url.searchParams.set('kategori', slug);
            }
            url.searchParams.delete('page');
            window.location.href = url;
        }

        function sortBerita(sortBy) {
            const url = new URL(window.location);
            url.searchParams.set('sort', sortBy);
            url.searchParams.delete('page');
            window.location.href = url;
        }

        // Live search with debounce
        let searchTimeout;
        const searchInput = document.querySelector('.search-box input');
        const searchResults = document.createElement('div');
        searchResults.className = 'search-results position-absolute w-100 bg-white border rounded-3 shadow-lg mt-2 d-none';
        searchResults.style.zIndex = '1000';
        searchInput.parentElement.appendChild(searchResults);

        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            const query = e.target.value;

            if (query.length < 2) {
                searchResults.classList.add('d-none');
                return;
            }

            searchTimeout = setTimeout(() => {
                fetch(`{{ route('berita.search') }}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        searchResults.innerHTML = '';

                        if (data.length === 0) {
                            searchResults.innerHTML =
                                '<div class="p-3 text-center text-muted">Tidak ada hasil</div>';
                        } else {
                            data.forEach(berita => {
                                const item = document.createElement('a');
                                item.href = berita.url;
                                item.className =
                                    'd-block p-3 text-decoration-none text-dark border-bottom';
                                item.innerHTML = `
                                <div class="d-flex gap-3">
                                    <img src="${berita.gambar_url}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                    <div>
                                        <h6 class="mb-1">${berita.judul}</h6>
                                        <small class="text-muted">${berita.published_at}</small>
                                    </div>
                                </div>
                            `;
                                searchResults.appendChild(item);
                            });
                        }

                        searchResults.classList.remove('d-none');
                    })
                    .catch(error => {
                        console.error('Search error:', error);
                    });
            }, 300);
        });

        // Hide search results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.parentElement.contains(e.target)) {
                searchResults.classList.add('d-none');
            }
        });

        // Infinite scroll (optional)
        let loading = false;
        window.addEventListener('scroll', function() {
            if (loading) return;

            const scrollPosition = window.innerHeight + window.scrollY;
            const pageHeight = document.documentElement.offsetHeight;

            if (scrollPosition >= pageHeight - 1000) {
                const currentPage = {{ $beritas->currentPage() }};
                const lastPage = {{ $beritas->lastPage() }};

                if (currentPage < lastPage) {
                    loading = true;
                    // Load more berita via AJAX
                    console.log('Load more berita...');
                }
            }
        });
    </script>
@endpush
