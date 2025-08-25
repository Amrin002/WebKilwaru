@extends('template.main')

@section('title', 'Kategori: ' . $kategori->nama . ' - ' . config('app.village_name', 'Desa Kilwaru'))
@section('description',
    'Berita dan informasi kategori ' .
    $kategori->nama .
    ' dari ' .
    config(
    'app.village_name',
    'Desa
    Kilwaru',
    ))

    @push('styles')
        <style>
            .category-hero {
                background: linear-gradient(135deg, {{ $kategori->warna }}dd, {{ $kategori->warna }}99),
                    url('https://images.unsplash.com/photo-1504711434969-e33886168f5c?ixlib=rb-4.0.3') center/cover;
                color: white;
                padding: 120px 0 60px;
                margin-top: -80px;
                position: relative;
            }

            .category-hero::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                height: 80px;
                background: linear-gradient(to top, white, transparent);
            }

            .category-icon {
                font-size: 4rem;
                margin-bottom: 1rem;
            }

            .berita-card {
                height: 100%;
                transition: all 0.3s ease;
                border: none;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
                overflow: hidden;
            }

            .berita-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            }

            .berita-card .card-img-top {
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
                margin-bottom: 20px;
            }

            .search-box {
                position: relative;
                max-width: 100%;
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
                border-color: {{ $kategori->warna }};
                box-shadow: 0 0 0 0.2rem {{ $kategori->warna }}33;
                outline: none;
            }

            .search-box button {
                position: absolute;
                right: 5px;
                top: 50%;
                transform: translateY(-50%);
                background: {{ $kategori->warna }};
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
                transform: translateY(-50%) scale(1.1);
            }
        </style>
    @endpush

@section('content')
    <!-- Category Hero -->
    <section class="category-hero">
        <div class="container text-center">
            <div class="category-icon">
                @if ($kategori->icon)
                    <i class="{{ $kategori->icon }}"></i>
                @else
                    <i class="fas fa-folder"></i>
                @endif
            </div>
            <h1 class="display-4 fw-bold mb-3">{{ $kategori->nama }}</h1>
            <p class="lead mb-0">{{ $kategori->deskripsi ?? 'Kumpulan berita dan informasi terkait ' . $kategori->nama }}</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Breadcrumb -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('berita.index') }}">Berita</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $kategori->nama }}</li>
                        </ol>
                    </nav>

                    <!-- Search Box -->
                    <div class="mb-4">
                        <form action="{{ route('berita.kategori', $kategori->slug) }}" method="GET" class="search-box">
                            <input type="text" name="search" placeholder="Cari berita di kategori ini..."
                                value="{{ request('search') }}">
                            <button type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Sort Options -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <strong>{{ $beritas->total() }}</strong> berita ditemukan
                            @if (request('search'))
                                untuk "<em>{{ request('search') }}</em>"
                            @endif
                        </div>
                        <select class="form-select w-auto" onchange="sortBerita(this.value)">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler
                            </option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        </select>
                    </div>

                    <!-- Featured Articles in Category -->
                    @if ($featuredBerita->count() > 0 && !request('search') && !request('page'))
                        <div class="mb-5">
                            <h4 class="mb-3">Berita Pilihan {{ $kategori->nama }}</h4>
                            <div class="row">
                                @foreach ($featuredBerita as $featured)
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100 berita-card">
                                            <div class="overflow-hidden" style="height: 150px;">
                                                <img src="{{ $featured->gambar_url }}" class="card-img-top"
                                                    alt="{{ $featured->judul }}" style="height: 100%; object-fit: cover;">
                                            </div>
                                            <div class="card-body">
                                                <h6 class="card-title">
                                                    <a href="{{ route('berita.show', $featured->slug) }}"
                                                        class="text-decoration-none text-dark">
                                                        {{ Str::limit($featured->judul, 50) }}
                                                    </a>
                                                </h6>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar"></i>
                                                    {{ $featured->published_at->format('d M Y') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr class="my-4">
                        </div>
                    @endif

                    <!-- Articles Grid -->
                    <div class="row">
                        @forelse($beritas as $berita)
                            <div class="col-md-6 mb-4">
                                <div class="card berita-card h-100">
                                    <div class="overflow-hidden" style="height: 200px;">
                                        <img src="{{ $berita->gambar_url }}" class="card-img-top"
                                            alt="{{ $berita->judul }}" style="height: 100%; object-fit: cover;">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">
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
                                    <i class="bi bi-folder2-open" style="color: {{ $kategori->warna }}"></i>
                                    <h4>Tidak Ada Berita</h4>
                                    <p class="text-muted">
                                        @if (request('search'))
                                            Tidak ditemukan berita dengan kata kunci "{{ request('search') }}" di kategori
                                            {{ $kategori->nama }}
                                        @else
                                            Belum ada berita di kategori {{ $kategori->nama }}
                                        @endif
                                    </p>
                                    <a href="{{ route('berita.index') }}" class="btn btn-primary">
                                        Lihat Semua Berita
                                    </a>
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
                    <!-- Category Info -->
                    <div class="sidebar-widget" style="border-left: 4px solid {{ $kategori->warna }};">
                        <h5>Tentang Kategori</h5>
                        <p>{{ $kategori->deskripsi ?? 'Kategori ' . $kategori->nama . ' berisi berbagai berita dan informasi terkait topik ini.' }}
                        </p>
                        <div class="d-flex justify-content-between mt-3">
                            <span><i class="bi bi-newspaper"></i> Total Berita</span>
                            <strong>{{ $kategori->published_beritas_count ?? 0 }}</strong>
                        </div>
                    </div>

                    <!-- Popular in Category -->
                    @if ($popularBerita->count() > 0)
                        <div class="sidebar-widget">
                            <h5>Populer di {{ $kategori->nama }}</h5>
                            @foreach ($popularBerita as $popular)
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
                            @endforeach
                        </div>
                    @endif

                    <!-- Latest in Category -->
                    @if ($latestBerita->count() > 0)
                        <div class="sidebar-widget">
                            <h5>Terbaru di {{ $kategori->nama }}</h5>
                            @foreach ($latestBerita as $latest)
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
                            @endforeach
                        </div>
                    @endif

                    <!-- Other Categories -->
                    @if ($otherKategori->count() > 0)
                        <div class="sidebar-widget">
                            <h5>Kategori Lainnya</h5>
                            @foreach ($otherKategori as $other)
                                <div class="sidebar-item">
                                    <a href="{{ route('berita.kategori', $other->slug) }}"
                                        class="text-decoration-none d-flex justify-content-between align-items-center">
                                        <span class="text-dark">
                                            <i class="bi bi-folder" style="color: {{ $other->warna }}"></i>
                                            {{ $other->nama }}
                                        </span>
                                        <span class="badge bg-secondary rounded-pill">
                                            {{ $other->published_beritas_count ?? 0 }}
                                        </span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Back to All News -->
                    <div class="text-center mt-4">
                        <a href="{{ route('berita.index') }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-arrow-left"></i> Lihat Semua Berita
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function sortBerita(sortBy) {
            const url = new URL(window.location);
            url.searchParams.set('sort', sortBy);
            url.searchParams.delete('page');
            window.location.href = url;
        }

        // Auto-complete search
        const searchInput = document.querySelector('.search-box input');
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function(e) {
                clearTimeout(searchTimeout);
                const query = e.target.value;

                if (query.length < 2) return;

                searchTimeout = setTimeout(() => {
                    // You can implement auto-complete here
                    console.log('Searching for:', query);
                }, 300);
            });
        }
    </script>
@endpush
