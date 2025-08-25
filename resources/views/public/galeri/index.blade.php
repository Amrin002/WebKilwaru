@extends('template.main')

@section('title', 'Galeri Foto - ' . config('app.village_name', 'Desa Kilwaru'))
@section('description', 'Galeri foto kegiatan dan aktivitas terbaru di ' . config('app.village_name', 'Desa Kilwaru'))

@push('styles')
    <style>
        .galeri-hero {
            background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 89, 0.8)),
                url('https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?ixlib=rb-4.0.3') center/cover;
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

        .galeri-card {
            height: 100%;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border-radius: 15px;
            overflow: hidden;
        }

        .galeri-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .galeri-card .card-img-top {
            height: 280px;
            object-fit: cover;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .galeri-card:hover .card-img-top {
            transform: scale(1.05);
        }

        .galeri-meta {
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

        .photo-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .galeri-card-body {
            padding: 20px;
        }

        .galeri-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .galeri-description {
            color: var(--soft-gray);
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        /* Lightbox Modal */
        .lightbox-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .lightbox-modal.show {
            display: flex;
        }

        .lightbox-image {
            max-width: 90%;
            max-height: 90%;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .lightbox-close {
            position: absolute;
            top: 20px;
            right: 30px;
            color: white;
            font-size: 2rem;
            cursor: pointer;
            background: rgba(255, 255, 255, 0.2);
            width: 50px;
            height: 50px;
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .lightbox-close:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .lightbox-info {
            position: absolute;
            bottom: 30px;
            left: 30px;
            color: white;
            background: rgba(0, 0, 0, 0.7);
            padding: 15px 20px;
            border-radius: 10px;
            max-width: 400px;
        }

        .lightbox-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .lightbox-meta {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* Gallery Grid Layouts */
        .grid-view .galeri-card .card-img-top {
            height: 250px;
        }

        .list-view .galeri-card {
            margin-bottom: 20px;
        }

        .list-view .galeri-card .row {
            align-items: center;
        }

        .list-view .galeri-card .card-img-top {
            height: 150px;
        }

        .view-toggle {
            background: white;
            border: 2px solid var(--primary-green);
            color: var(--primary-green);
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin: 0 2px;
        }

        .view-toggle.active,
        .view-toggle:hover {
            background: var(--primary-green);
            color: white;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="galeri-hero">
        <div class="container">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-4">Galeri Foto</h1>
                <p class="lead">Dokumentasi kegiatan dan momen berharga di
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
                    <form action="{{ route('public.galeri.index') }}" method="GET" class="search-box mb-4">
                        <input type="text" name="search" placeholder="Cari foto kegiatan..."
                            value="{{ request('search') }}">
                        <button type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>

                    <div class="text-center mb-3">
                        <button class="filter-btn {{ !request('tahun') ? 'active' : '' }}" onclick="filterByYear('all')">
                            Semua Tahun
                        </button>
                        @for ($year = date('Y'); $year >= 2020; $year--)
                            <button class="filter-btn {{ request('tahun') == $year ? 'active' : '' }}"
                                onclick="filterByYear('{{ $year }}')">
                                {{ $year }}
                            </button>
                        @endfor
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <select class="form-select d-inline-block w-auto" onchange="sortGaleri(this.value)">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                            </select>
                        </div>
                        <div>
                            <button class="view-toggle {{ request('view') != 'list' ? 'active' : '' }}"
                                onclick="changeView('grid')" title="Grid View">
                                <i class="fas fa-th"></i>
                            </button>
                            <button class="view-toggle {{ request('view') == 'list' ? 'active' : '' }}"
                                onclick="changeView('list')" title="List View">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-9">
                    @if (request('search'))
                        <div class="alert alert-info mb-4">
                            Menampilkan hasil pencarian untuk: <strong>{{ request('search') }}</strong>
                            <a href="{{ route('public.galeri.index') }}" class="float-end">Hapus Filter</a>
                        </div>
                    @endif

                    <!-- Gallery Grid -->
                    <div class="row {{ request('view') == 'list' ? 'list-view' : 'grid-view' }}">
                        @forelse($galeris as $galeri)
                            <div class="{{ request('view') == 'list' ? 'col-12' : 'col-md-4' }} mb-4">
                                <div class="card galeri-card h-100">
                                    @if (request('view') == 'list')
                                        <div class="row g-0">
                                            <div class="col-md-4">
                                                <div class="position-relative overflow-hidden">
                                                    <img src="{{ $galeri->foto_url }}" class="card-img-top"
                                                        alt="{{ $galeri->nama_kegiatan }}"
                                                        onclick="openLightbox('{{ $galeri->foto_url }}', '{{ $galeri->nama_kegiatan }}', '{{ $galeri->created_at->format('d M Y') }}')">
                                                    <div class="photo-badge">
                                                        <i class="fas fa-camera"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="galeri-card-body">
                                                    <h5 class="galeri-title">{{ $galeri->nama_kegiatan }}</h5>
                                                    @if ($galeri->keterangan)
                                                        <p class="galeri-description">
                                                            {{ Str::limit($galeri->keterangan, 120) }}
                                                        </p>
                                                    @endif
                                                    <div class="galeri-meta">
                                                        <i class="fas fa-calendar"></i>
                                                        {{ $galeri->created_at->format('d M Y') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="position-relative overflow-hidden">
                                            <img src="{{ $galeri->foto_url }}" class="card-img-top"
                                                alt="{{ $galeri->nama_kegiatan }}"
                                                onclick="openLightbox('{{ $galeri->foto_url }}', '{{ $galeri->nama_kegiatan }}', '{{ $galeri->created_at->format('d M Y') }}')">
                                            <div class="photo-badge">
                                                <i class="fas fa-camera"></i>
                                            </div>
                                        </div>
                                        <div class="galeri-card-body">
                                            <h5 class="galeri-title">{{ $galeri->nama_kegiatan }}</h5>
                                            @if ($galeri->keterangan)
                                                <p class="galeri-description">
                                                    {{ Str::limit($galeri->keterangan, 80) }}
                                                </p>
                                            @endif
                                            <div class="galeri-meta">
                                                <i class="fas fa-calendar"></i> {{ $galeri->created_at->format('d M Y') }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="empty-state">
                                    <i class="fas fa-images"></i>
                                    <h4>Tidak Ada Foto</h4>
                                    <p class="text-muted">
                                        @if (request('search'))
                                            Tidak ditemukan foto dengan kata kunci "{{ request('search') }}"
                                        @else
                                            Belum ada foto yang tersedia
                                        @endif
                                    </p>
                                    @if (request('search'))
                                        <a href="{{ route('public.galeri.index') }}" class="btn btn-primary">
                                            Lihat Semua Foto
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if ($galeris->hasPages())
                        <div class="d-flex justify-content-center mt-5">
                            {{ $galeris->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="col-lg-3">
                    <!-- Latest Photos Widget -->
                    <div class="sidebar-widget">
                        <h5>Foto Terbaru</h5>
                        @php
                            $latestGaleri = \App\Models\Galeri::latest()->limit(5)->get();
                        @endphp
                        @forelse($latestGaleri as $latest)
                            <div class="sidebar-item">
                                <div class="d-flex gap-3">
                                    <img src="{{ $latest->foto_url }}" alt="{{ $latest->nama_kegiatan }}"
                                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; cursor: pointer;"
                                        onclick="openLightbox('{{ $latest->foto_url }}', '{{ $latest->nama_kegiatan }}', '{{ $latest->created_at->format('d M Y') }}')">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            {{ Str::limit($latest->nama_kegiatan, 40) }}
                                        </h6>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar"></i> {{ $latest->created_at->format('d M Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">Belum ada foto terbaru</p>
                        @endforelse
                    </div>

                    <!-- Statistics Widget -->
                    <div class="sidebar-widget">
                        <h5>Statistik</h5>
                        @php
                            $totalFoto = \App\Models\Galeri::count();
                            $fotoThisMonth = \App\Models\Galeri::whereMonth('created_at', date('m'))
                                ->whereYear('created_at', date('Y'))
                                ->count();
                            $fotoThisYear = \App\Models\Galeri::whereYear('created_at', date('Y'))->count();
                        @endphp
                        <div class="sidebar-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-dark">
                                    <i class="fas fa-images text-primary"></i> Total Foto
                                </span>
                                <span class="badge bg-primary rounded-pill">{{ $totalFoto }}</span>
                            </div>
                        </div>
                        <div class="sidebar-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-dark">
                                    <i class="fas fa-calendar-month text-success"></i> Bulan Ini
                                </span>
                                <span class="badge bg-success rounded-pill">{{ $fotoThisMonth }}</span>
                            </div>
                        </div>
                        <div class="sidebar-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-dark">
                                    <i class="fas fa-calendar-year text-info"></i> Tahun Ini
                                </span>
                                <span class="badge bg-info rounded-pill">{{ $fotoThisYear }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Archive Widget -->
                    <div class="sidebar-widget">
                        <h5>Arsip Foto</h5>
                        @php
                            $archives = \App\Models\Galeri::selectRaw('YEAR(created_at) as year, COUNT(*) as count')
                                ->groupBy('year')
                                ->orderBy('year', 'desc')
                                ->get();
                        @endphp
                        @forelse($archives as $archive)
                            <div class="sidebar-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('public.galeri.index', ['tahun' => $archive->year]) }}"
                                        class="text-decoration-none text-dark">
                                        <i class="fas fa-folder text-warning"></i> Tahun {{ $archive->year }}
                                    </a>
                                    <span class="badge bg-secondary rounded-pill">{{ $archive->count }}</span>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">Belum ada arsip foto</p>
                        @endforelse
                    </div>

                    <!-- Share Widget -->
                    <div class="sidebar-widget">
                        <h5>Bagikan</h5>
                        <div class="sidebar-item">
                            <a href="#" class="text-decoration-none text-dark" onclick="shareGallery(event)">
                                <i class="fas fa-share-alt text-primary"></i> Bagikan Galeri
                            </a>
                        </div>
                        <div class="sidebar-item">
                            <a href="#" class="text-decoration-none text-dark" onclick="copyGalleryLink(event)">
                                <i class="fas fa-link text-info"></i> Copy Link
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lightbox Modal -->
    <div class="lightbox-modal" id="lightboxModal">
        <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
        <img class="lightbox-image" id="lightboxImage" src="" alt="">
        <div class="lightbox-info" id="lightboxInfo">
            <div class="lightbox-title" id="lightboxTitle"></div>
            <div class="lightbox-meta" id="lightboxMeta"></div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // ============================================================================
        // DEFINISI FUNGSI GLOBAL - AGAR BISA DIAKSES DARI ONCLICK
        // ============================================================================

        // Filter and sorting functions - GLOBAL SCOPE
        window.filterByYear = function(year) {
            const url = new URL(window.location);
            if (year === 'all') {
                url.searchParams.delete('tahun');
            } else {
                url.searchParams.set('tahun', year);
            }
            url.searchParams.delete('page'); // Reset pagination
            window.location.href = url;
        };

        window.sortGaleri = function(sortBy) {
            const url = new URL(window.location);
            url.searchParams.set('sort', sortBy);
            url.searchParams.delete('page'); // Reset pagination
            window.location.href = url;
        };

        window.changeView = function(viewType) {
            const url = new URL(window.location);
            if (viewType === 'grid') {
                url.searchParams.delete('view');
            } else {
                url.searchParams.set('view', viewType);
            }
            url.searchParams.delete('page'); // Reset pagination
            window.location.href = url;
        };

        // Lightbox functions - GLOBAL SCOPE
        window.openLightbox = function(imageSrc, title, date) {
            const modal = document.getElementById('lightboxModal');
            const image = document.getElementById('lightboxImage');
            const titleEl = document.getElementById('lightboxTitle');
            const metaEl = document.getElementById('lightboxMeta');

            if (!modal || !image || !titleEl || !metaEl) {
                console.error('Lightbox elements not found');
                return;
            }

            image.src = imageSrc;
            image.alt = title;
            titleEl.textContent = title;
            metaEl.innerHTML = `<i class="fas fa-calendar"></i> ${date}`;

            modal.classList.add('show');
            document.body.style.overflow = 'hidden';

            // Add fade in effect
            setTimeout(() => {
                image.style.opacity = '1';
            }, 50);
        };

        window.closeLightbox = function() {
            const modal = document.getElementById('lightboxModal');
            const image = document.getElementById('lightboxImage');

            if (!modal) {
                console.error('Lightbox modal not found');
                return;
            }

            modal.classList.remove('show');
            document.body.style.overflow = 'auto';

            // Reset image opacity
            if (image) {
                image.style.opacity = '0';
            }
        };

        // Share functions - GLOBAL SCOPE
        window.shareGallery = function(event) {
            event.preventDefault();

            if (navigator.share) {
                navigator.share({
                    title: 'Galeri Foto {{ config('app.village_name', 'Desa Kilwaru') }}',
                    text: 'Lihat galeri foto kegiatan dan aktivitas di {{ config('app.village_name', 'Desa Kilwaru') }}',
                    url: window.location.href
                }).catch(function(error) {
                    console.log('Error sharing:', error);
                    copyGalleryLink(event);
                });
            } else {
                copyGalleryLink(event);
            }
        };

        window.copyGalleryLink = function(event) {
            event.preventDefault();
            const url = window.location.href;

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url).then(function() {
                    showToast('Link berhasil disalin!', 'success');
                }).catch(function() {
                    fallbackCopyLink(url);
                });
            } else {
                fallbackCopyLink(url);
            }
        };

        // ============================================================================
        // HELPER FUNCTIONS
        // ============================================================================

        function fallbackCopyLink(text) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            textArea.style.top = '-999999px';
            textArea.style.opacity = '0';
            document.body.appendChild(textArea);
            textArea.select();
            textArea.setSelectionRange(0, 99999); // For mobile devices

            try {
                document.execCommand('copy');
                showToast('Link berhasil disalin!', 'success');
            } catch (err) {
                console.error('Fallback copy failed:', err);
                showToast('Gagal menyalin link', 'error');
            }

            document.body.removeChild(textArea);
        }

        function showToast(message, type = 'success') {
            // Remove existing toast if any
            const existingToast = document.querySelector('.custom-toast');
            if (existingToast) {
                existingToast.remove();
            }

            const toast = document.createElement('div');
            toast.className = 'custom-toast';
            toast.textContent = message;
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#28a745' : '#dc3545'};
                color: white;
                padding: 12px 24px;
                border-radius: 10px;
                z-index: 10000;
                font-size: 0.9rem;
                font-weight: 600;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
                animation: slideInToast 0.3s ease;
                max-width: 300px;
                word-wrap: break-word;
            `;

            document.body.appendChild(toast);

            setTimeout(() => {
                if (document.body.contains(toast)) {
                    toast.style.animation = 'slideOutToast 0.3s ease';
                    setTimeout(() => {
                        if (document.body.contains(toast)) {
                            document.body.removeChild(toast);
                        }
                    }, 300);
                }
            }, 3000);
        }

        // ============================================================================
        // DOM READY FUNCTIONS
        // ============================================================================

        document.addEventListener('DOMContentLoaded', function() {
            console.log('Galeri page loaded');

            // Add CSS animations for toast
            addToastAnimations();

            // Initialize live search with debounce
            initLiveSearch();

            // Initialize keyboard shortcuts
            initKeyboardShortcuts();

            // Initialize lightbox click handlers
            initLightboxClickHandlers();

            // Initialize lazy loading if supported
            initLazyLoading();

            console.log('All galeri functions initialized');
        });

        function addToastAnimations() {
            if (document.querySelector('#toast-animations')) return;

            const style = document.createElement('style');
            style.id = 'toast-animations';
            style.textContent = `
                @keyframes slideInToast {
                    from {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }
                
                @keyframes slideOutToast {
                    from {
                        transform: translateX(0);
                        opacity: 1;
                    }
                    to {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                }
                
                .lightbox-image {
                    opacity: 0;
                    transition: opacity 0.3s ease;
                }
            `;
            document.head.appendChild(style);
        }

        function initLiveSearch() {
            let searchTimeout;
            const searchInput = document.querySelector('.search-box input');

            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    clearTimeout(searchTimeout);
                    const query = e.target.value.trim();

                    if (query.length < 2) return;

                    searchTimeout = setTimeout(() => {
                        // Auto submit form after 1 second of no typing
                        if (query.length >= 2) {
                            e.target.closest('form').submit();
                        }
                    }, 1000);
                });

                // Show search suggestions (optional enhancement)
                searchInput.addEventListener('focus', function() {
                    this.setAttribute('placeholder', 'Ketik minimal 2 karakter untuk pencarian otomatis...');
                });

                searchInput.addEventListener('blur', function() {
                    this.setAttribute('placeholder', 'Cari foto kegiatan...');
                });
            }
        }

        function initKeyboardShortcuts() {
            document.addEventListener('keydown', function(e) {
                // Close lightbox with Escape key
                if (e.key === 'Escape') {
                    closeLightbox();
                }

                // Open search with Ctrl+F or Cmd+F (prevent default and focus search)
                if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                    e.preventDefault();
                    const searchInput = document.querySelector('.search-box input');
                    if (searchInput) {
                        searchInput.focus();
                        searchInput.select();
                    }
                }

                // Navigate through images with arrow keys when lightbox is open
                if (document.getElementById('lightboxModal').classList.contains('show')) {
                    if (e.key === 'ArrowLeft') {
                        // Previous image logic could be added here
                        console.log('Previous image');
                    } else if (e.key === 'ArrowRight') {
                        // Next image logic could be added here
                        console.log('Next image');
                    }
                }
            });
        }

        function initLightboxClickHandlers() {
            // Close lightbox when clicking outside image
            const lightboxModal = document.getElementById('lightboxModal');
            if (lightboxModal) {
                lightboxModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeLightbox();
                    }
                });
            }

            // Close button click handler
            const closeButton = document.querySelector('.lightbox-close');
            if (closeButton) {
                closeButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    closeLightbox();
                });
            }

            // Prevent image click from closing lightbox
            const lightboxImage = document.getElementById('lightboxImage');
            if (lightboxImage) {
                lightboxImage.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }

            // Prevent info box click from closing lightbox
            const lightboxInfo = document.getElementById('lightboxInfo');
            if (lightboxInfo) {
                lightboxInfo.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
        }

        function initLazyLoading() {
            // Lazy loading for images (performance optimization)
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            if (img.dataset.src) {
                                img.src = img.dataset.src;
                                img.classList.remove('lazy');
                                img.classList.add('lazy-loaded');
                                imageObserver.unobserve(img);
                            }
                        }
                    });
                }, {
                    rootMargin: '50px 0px', // Load images 50px before they come into view
                    threshold: 0.01
                });

                // Observe all images with data-src attribute
                document.querySelectorAll('img[data-src]').forEach(img => {
                    imageObserver.observe(img);
                });
            }
        }

        // ============================================================================
        // ADDITIONAL UTILITY FUNCTIONS
        // ============================================================================

        // Function to reload page with new parameters (useful for filters)
        function reloadWithParams(params) {
            const url = new URL(window.location);
            Object.keys(params).forEach(key => {
                if (params[key]) {
                    url.searchParams.set(key, params[key]);
                } else {
                    url.searchParams.delete(key);
                }
            });
            url.searchParams.delete('page'); // Always reset pagination
            window.location.href = url;
        }

        // Function to get current URL parameters
        function getUrlParams() {
            const params = {};
            const urlParams = new URLSearchParams(window.location.search);
            for (const [key, value] of urlParams) {
                params[key] = value;
            }
            return params;
        }

        // Function to check if device is mobile
        function isMobile() {
            return window.innerWidth <= 768;
        }

        // Function to format file size
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Function to handle image load errors
        function handleImageError(img) {
            img.src = '/images/placeholder.jpg'; // Fallback image
            img.alt = 'Gambar tidak tersedia';
            img.classList.add('error-image');
        }

        // Add error handling to all gallery images
        document.addEventListener('DOMContentLoaded', function() {
            const galleryImages = document.querySelectorAll('.galeri-card img');
            galleryImages.forEach(img => {
                img.addEventListener('error', function() {
                    handleImageError(this);
                });
            });
        });

        // ============================================================================
        // ENHANCED FEATURES (OPTIONAL)
        // ============================================================================

        // Function to add image download capability
        window.downloadImage = function(imageUrl, filename) {
            const link = document.createElement('a');
            link.href = imageUrl;
            link.download = filename || 'galeri-foto.jpg';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            showToast('Download dimulai...', 'success');
        };

        // Function to add image to favorites (localStorage)
        window.toggleFavorite = function(imageId, imageName) {
            let favorites = JSON.parse(localStorage.getItem('galeri_favorites') || '[]');
            const index = favorites.findIndex(fav => fav.id === imageId);

            if (index > -1) {
                favorites.splice(index, 1);
                showToast('Dihapus dari favorit', 'success');
            } else {
                favorites.push({
                    id: imageId,
                    name: imageName,
                    date: new Date().toISOString()
                });
                showToast('Ditambahkan ke favorit', 'success');
            }

            localStorage.setItem('galeri_favorites', JSON.stringify(favorites));
            updateFavoriteButtons();
        };

        // Function to update favorite buttons
        function updateFavoriteButtons() {
            const favorites = JSON.parse(localStorage.getItem('galeri_favorites') || '[]');
            const favoriteButtons = document.querySelectorAll('.favorite-btn');

            favoriteButtons.forEach(btn => {
                const imageId = btn.dataset.imageId;
                const isFavorite = favorites.some(fav => fav.id === imageId);
                btn.classList.toggle('active', isFavorite);
                btn.innerHTML = isFavorite ? '<i class="fas fa-heart"></i>' : '<i class="far fa-heart"></i>';
            });
        }

        // Function to show image info
        window.showImageInfo = function(imageData) {
            const modal = document.createElement('div');
            modal.className = 'image-info-modal';
            modal.innerHTML = `
                <div class="modal-overlay">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Informasi Foto</h5>
                            <button class="btn-close" onclick="this.closest('.image-info-modal').remove()">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Nama:</strong> ${imageData.name}</p>
                            <p><strong>Tanggal:</strong> ${imageData.date}</p>
                            <p><strong>Deskripsi:</strong> ${imageData.description || 'Tidak ada deskripsi'}</p>
                        </div>
                    </div>
                </div>
            `;

            document.body.appendChild(modal);
        };

        // ============================================================================
        // PERFORMANCE OPTIMIZATIONS
        // ============================================================================

        // Throttle function for resize events
        function throttle(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Handle window resize for responsive adjustments
        window.addEventListener('resize', throttle(function() {
            // Adjust lightbox size on mobile
            const lightboxImage = document.getElementById('lightboxImage');
            if (lightboxImage && window.innerWidth <= 768) {
                lightboxImage.style.maxWidth = '95%';
                lightboxImage.style.maxHeight = '85%';
            } else if (lightboxImage) {
                lightboxImage.style.maxWidth = '90%';
                lightboxImage.style.maxHeight = '90%';
            }
        }, 250));

        // ============================================================================
        // DEBUGGING AND CONSOLE LOGS (REMOVE IN PRODUCTION)
        // ============================================================================

        console.log('Galeri JavaScript loaded successfully');
        console.log('Available functions:', {
            openLightbox: typeof window.openLightbox,
            closeLightbox: typeof window.closeLightbox,
            filterByYear: typeof window.filterByYear,
            sortGaleri: typeof window.sortGaleri,
            changeView: typeof window.changeView,
            shareGallery: typeof window.shareGallery,
            copyGalleryLink: typeof window.copyGalleryLink
        });
    </script>
@endpush
