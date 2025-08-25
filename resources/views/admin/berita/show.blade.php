{{-- Detail Berita --}}
@extends('layouts.main')

@push('style')
    <style>
        /* Detail Container Styles */
        .detail-container {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .detail-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--cream);
        }

        .status-badges {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .status-published {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .status-draft {
            background: rgba(255, 140, 66, 0.1);
            color: var(--accent-orange);
            border: 1px solid rgba(255, 140, 66, 0.3);
        }

        .status-archived {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
            border: 1px solid rgba(108, 117, 125, 0.3);
        }

        .featured-badge {
            background: linear-gradient(135deg, #ffc107, #ffb300);
            color: white;
            border: none;
        }

        .detail-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 15px;
            line-height: 1.3;
        }

        [data-theme="dark"] .detail-title {
            color: var(--light-green);
        }

        .detail-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            background: var(--cream);
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .meta-icon {
            width: 35px;
            height: 35px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .meta-content {
            flex: 1;
            min-width: 0;
        }

        .meta-label {
            font-size: 0.8rem;
            color: var(--soft-gray);
            margin-bottom: 2px;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .meta-value {
            font-weight: 600;
            color: var(--primary-green);
            word-wrap: break-word;
        }

        [data-theme="dark"] .meta-value {
            color: var(--light-green);
        }

        /* Content Sections */
        .content-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--cream);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        [data-theme="dark"] .section-title {
            color: var(--light-green);
        }

        .section-icon {
            width: 35px;
            height: 35px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }

        /* Image Display */
        .featured-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .no-image {
            background: var(--cream);
            border: 2px dashed rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            padding: 60px 20px;
            text-align: center;
            color: var(--soft-gray);
            margin-bottom: 20px;
        }

        .no-image i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        /* Content Display */
        .content-display {
            background: var(--cream);
            border-radius: 15px;
            padding: 25px;
            line-height: 1.8;
            font-size: 1rem;
            color: inherit;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .content-display p {
            margin-bottom: 15px;
        }

        .content-display p:last-child {
            margin-bottom: 0;
        }

        .content-display h1,
        .content-display h2,
        .content-display h3 {
            color: var(--primary-green);
            margin-top: 25px;
            margin-bottom: 15px;
        }

        [data-theme="dark"] .content-display h1,
        [data-theme="dark"] .content-display h2,
        [data-theme="dark"] .content-display h3 {
            color: var(--light-green);
        }

        /* Tags Display */
        .tags-display {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .tag-item {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .no-tags {
            color: var(--soft-gray);
            font-style: italic;
            padding: 10px 0;
        }

        /* Category Display */
        .category-display {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .category-display:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            color: white;
        }

        /* Action Buttons */
        .detail-actions {
            background: var(--cream);
            border-radius: 15px;
            padding: 20px;
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45, 80, 22, 0.3);
            color: white;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: white;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 140, 66, 0.3);
            color: white;
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
            color: white;
        }

        .btn-outline-secondary {
            color: var(--soft-gray);
            border: 2px solid var(--soft-gray);
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            background: transparent;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-outline-secondary:hover {
            background: var(--soft-gray);
            border-color: var(--soft-gray);
            transform: translateY(-2px);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #e74c3c);
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: white;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
            color: white;
        }

        .btn-info {
            background: linear-gradient(135deg, #17a2b8, #138496);
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: white;
        }

        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(23, 162, 184, 0.3);
            color: white;
        }

        /* Statistics Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: var(--warm-white);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: white;
            margin: 0 auto 10px;
        }

        .stat-icon.views {
            background: linear-gradient(135deg, #17a2b8, #138496);
        }

        .stat-icon.date {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
        }

        .stat-icon.author {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 5px;
        }

        [data-theme="dark"] .stat-number {
            color: var(--light-green);
        }

        .stat-label {
            color: var(--soft-gray);
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .detail-container {
                padding: 20px;
            }

            .detail-title {
                font-size: 1.5rem;
            }

            .detail-meta {
                grid-template-columns: 1fr;
            }

            .detail-actions {
                flex-direction: column;
            }

            .btn-primary,
            .btn-warning,
            .btn-success,
            .btn-outline-secondary,
            .btn-danger,
            .btn-info {
                width: 100%;
                justify-content: center;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .status-badges {
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .detail-actions {
                padding: 15px;
            }
        }

        /* Loading Animation */
        .loading-skeleton {
            background: linear-gradient(90deg, var(--cream) 25%, rgba(255, 255, 255, 0.5) 50%, var(--cream) 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-content">
        <!-- Page Header -->
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Konten</li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.berita.index') }}">Kelola Berita</a></li>
                    <li class="breadcrumb-item active">Detail Berita</li>
                </ol>
            </nav>
            <h1 class="page-title">Detail Berita</h1>
            <p class="page-subtitle">Informasi lengkap berita <strong>{{ $berita->judul }}</strong></p>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon views">
                    <i class="bi bi-eye"></i>
                </div>
                <div class="stat-number">{{ number_format($berita->views) }}</div>
                <div class="stat-label">Views</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon date">
                    <i class="bi bi-calendar"></i>
                </div>
                <div class="stat-number">
                    {{ $berita->published_at ? $berita->published_at->format('d') : '-' }}
                </div>
                <div class="stat-label">
                    {{ $berita->published_at ? $berita->published_at->format('M Y') : 'Belum Publish' }}
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon author">
                    <i class="bi bi-person"></i>
                </div>
                <div class="stat-number" style="font-size: 1rem;">{{ $berita->penulis }}</div>
                <div class="stat-label">Penulis</div>
            </div>
        </div>

        <!-- Main Detail Container -->
        <div class="detail-container">
            <!-- Header with Status -->
            <div class="detail-header">
                <div class="status-badges">
                    <div class="status-badge status-{{ $berita->status }}">
                        <i class="bi bi-circle-fill"></i>
                        {{ ucfirst($berita->status) }}
                    </div>
                    @if ($berita->is_featured)
                        <div class="status-badge featured-badge">
                            <i class="bi bi-star-fill"></i>
                            Featured
                        </div>
                    @endif
                    @if ($berita->tags && count($berita->tags) > 0)
                        <div class="status-badge"
                            style="background: rgba(108, 117, 125, 0.1); color: #6c757d; border: 1px solid rgba(108, 117, 125, 0.3);">
                            <i class="bi bi-tags"></i>
                            {{ count($berita->tags) }} Tags
                        </div>
                    @endif
                </div>

                <h1 class="detail-title">{{ $berita->judul }}</h1>

                <!-- Meta Information -->
                <div class="detail-meta">
                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="bi bi-link-45deg"></i>
                        </div>
                        <div class="meta-content">
                            <div class="meta-label">Slug URL</div>
                            <div class="meta-value">{{ $berita->slug }}</div>
                        </div>
                    </div>

                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="bi bi-folder"></i>
                        </div>
                        <div class="meta-content">
                            <div class="meta-label">Kategori</div>
                            <div class="meta-value">
                                @if ($berita->kategoriBeri)
                                    <a href="{{ route('admin.kategori-berita.show', $berita->kategoriBeri->slug) }}"
                                        class="category-display"
                                        style="background-color: {{ $berita->kategoriBeri->warna }};">
                                        {{ $berita->kategoriBeri->nama }}
                                    </a>
                                @else
                                    <span class="text-muted">Tidak ada kategori</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        <div class="meta-content">
                            <div class="meta-label">Dibuat</div>
                            <div class="meta-value">{{ $berita->created_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>

                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <div class="meta-content">
                            <div class="meta-label">Terakhir Update</div>
                            <div class="meta-value">{{ $berita->updated_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>

                    @if ($berita->published_at)
                        <div class="meta-item">
                            <div class="meta-icon">
                                <i class="bi bi-send"></i>
                            </div>
                            <div class="meta-content">
                                <div class="meta-label">Dipublikasi</div>
                                <div class="meta-value">{{ $berita->published_at->format('d M Y, H:i') }}</div>
                            </div>
                        </div>
                    @endif

                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="bi bi-eye"></i>
                        </div>
                        <div class="meta-content">
                            <div class="meta-label">Total Views</div>
                            <div class="meta-value">{{ number_format($berita->views) }} kali</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Excerpt Section -->
            @if ($berita->excerpt)
                <div class="content-section">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-quote"></i>
                        </div>
                        Ringkasan
                    </h3>
                    <div class="content-display">
                        {{ $berita->excerpt }}
                    </div>
                </div>
            @endif

            <!-- Featured Image Section -->
            <div class="content-section">
                <h3 class="section-title">
                    <div class="section-icon">
                        <i class="bi bi-image"></i>
                    </div>
                    Gambar Utama
                </h3>

                @if ($berita->gambar)
                    <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}" class="featured-image">
                @else
                    <div class="no-image">
                        <i class="bi bi-image"></i>
                        <h5>Tidak ada gambar</h5>
                        <p>Berita ini belum memiliki gambar utama</p>
                    </div>
                @endif
            </div>

            <!-- Content Section -->
            <div class="content-section">
                <h3 class="section-title">
                    <div class="section-icon">
                        <i class="bi bi-file-text"></i>
                    </div>
                    Konten Berita
                </h3>
                <div class="content-display">
                    {!! nl2br(e($berita->konten)) !!}
                </div>
            </div>

            <!-- Tags Section -->
            <div class="content-section">
                <h3 class="section-title">
                    <div class="section-icon">
                        <i class="bi bi-tags"></i>
                    </div>
                    Tags
                </h3>

                @if ($berita->tags && count($berita->tags) > 0)
                    <div class="tags-display">
                        @foreach ($berita->tags as $tag)
                            <div class="tag-item">
                                <i class="bi bi-tag"></i>
                                {{ $tag }}
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="no-tags">
                        <i class="bi bi-info-circle me-2"></i>
                        Belum ada tags untuk berita ini
                    </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="detail-actions">
                <a href="{{ route('admin.berita.edit', $berita->slug) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i>
                    Edit Berita
                </a>

                @if ($berita->status == 'published')
                    <a href="{{ route('berita.show', $berita->slug) }}" target="_blank" class="btn btn-info">
                        <i class="bi bi-box-arrow-up-right"></i>
                        Lihat di Web
                    </a>

                    <form action="{{ route('admin.berita.toggle-publish', $berita->slug) }}" method="POST"
                        style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary"
                            onclick="return confirm('Yakin ingin unpublish berita ini?')">
                            <i class="bi bi-pause-circle"></i>
                            Unpublish
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.berita.toggle-publish', $berita->slug) }}" method="POST"
                        style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-success"
                            onclick="return confirm('Yakin ingin publish berita ini?')">
                            <i class="bi bi-send"></i>
                            Publish Sekarang
                        </button>
                    </form>
                @endif

                <a href="{{ route('admin.berita.duplicate', $berita->slug) }}" class="btn btn-primary">
                    <i class="bi bi-copy"></i>
                    Duplikasi
                </a>

                <form action="{{ route('admin.berita.toggle-featured', $berita->slug) }}" method="POST"
                    style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-{{ $berita->is_featured ? 'outline-secondary' : 'success' }}"
                        onclick="return confirm('{{ $berita->is_featured ? 'Hapus status featured?' : 'Jadikan berita featured?' }}')">
                        <i class="bi bi-star{{ $berita->is_featured ? '' : '-fill' }}"></i>
                        {{ $berita->is_featured ? 'Unfeature' : 'Feature' }}
                    </button>
                </form>

                <form action="{{ route('admin.berita.destroy', $berita->slug) }}" method="POST"
                    style="display: inline;"
                    onsubmit="return confirm('Yakin ingin menghapus berita ini? Tindakan ini tidak dapat dibatalkan!')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i>
                        Hapus
                    </button>
                </form>

                <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        <!-- Additional Information -->
        @if ($berita->excerpt || $berita->tags)
            <div class="detail-container">
                <h3 class="section-title">
                    <div class="section-icon">
                        <i class="bi bi-info-circle"></i>
                    </div>
                    Informasi Tambahan
                </h3>

                <div class="row g-3">
                    @if ($berita->excerpt)
                        <div class="col-md-6">
                            <div class="meta-item">
                                <div class="meta-icon">
                                    <i class="bi bi-text-paragraph"></i>
                                </div>
                                <div class="meta-content">
                                    <div class="meta-label">Panjang Excerpt</div>
                                    <div class="meta-value">{{ strlen($berita->excerpt) }} karakter</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="col-md-6">
                        <div class="meta-item">
                            <div class="meta-icon">
                                <i class="bi bi-file-text"></i>
                            </div>
                            <div class="meta-content">
                                <div class="meta-label">Panjang Konten</div>
                                <div class="meta-value">{{ strlen($berita->konten) }} karakter</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="meta-item">
                            <div class="meta-icon">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div class="meta-content">
                                <div class="meta-label">Estimasi Baca</div>
                                <div class="meta-value">{{ ceil(str_word_count($berita->konten) / 200) }} menit</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="meta-item">
                            <div class="meta-icon">
                                <i class="bi bi-hash"></i>
                            </div>
                            <div class="meta-content">
                                <div class="meta-label">Total Tags</div>
                                <div class="meta-value">{{ $berita->tags ? count($berita->tags) : 0 }} tags</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- SEO Information -->
        <div class="detail-container">
            <h3 class="section-title">
                <div class="section-icon">
                    <i class="bi bi-search"></i>
                </div>
                Informasi SEO
            </h3>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="bi bi-link-45deg"></i>
                        </div>
                        <div class="meta-content">
                            <div class="meta-label">URL Slug</div>
                            <div class="meta-value" style="word-break: break-all;">{{ $berita->slug }}</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="bi bi-type"></i>
                        </div>
                        <div class="meta-content">
                            <div class="meta-label">Panjang Judul</div>
                            <div class="meta-value">
                                {{ strlen($berita->judul) }} karakter
                                @if (strlen($berita->judul) > 60)
                                    <small class="text-warning">(Terlalu panjang untuk SEO)</small>
                                @elseif(strlen($berita->judul) < 30)
                                    <small class="text-info">(Bisa diperpanjang untuk SEO)</small>
                                @else
                                    <small class="text-success">(Optimal untuk SEO)</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if ($berita->excerpt)
                    <div class="col-md-6">
                        <div class="meta-item">
                            <div class="meta-icon">
                                <i class="bi bi-card-text"></i>
                            </div>
                            <div class="meta-content">
                                <div class="meta-label">Meta Description</div>
                                <div class="meta-value">
                                    {{ strlen($berita->excerpt) }} karakter
                                    @if (strlen($berita->excerpt) > 160)
                                        <small class="text-warning">(Terlalu panjang)</small>
                                    @elseif(strlen($berita->excerpt) < 120)
                                        <small class="text-info">(Bisa diperpanjang)</small>
                                    @else
                                        <small class="text-success">(Optimal)</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-md-6">
                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="bi bi-image"></i>
                        </div>
                        <div class="meta-content">
                            <div class="meta-label">Featured Image</div>
                            <div class="meta-value">
                                @if ($berita->gambar)
                                    <span class="text-success">✓ Ada</span>
                                @else
                                    <span class="text-warning">✗ Tidak ada</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide alerts
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // Initialize tooltips for all elements with title attribute
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Copy slug to clipboard
            const slugElement = document.querySelector('.meta-value[style*="word-break"]');
            if (slugElement) {
                slugElement.style.cursor = 'pointer';
                slugElement.title = 'Klik untuk copy slug';
                slugElement.addEventListener('click', function() {
                    navigator.clipboard.writeText(this.textContent).then(function() {
                        // Show temporary success message
                        const originalText = slugElement.textContent;
                        slugElement.textContent = 'Copied!';
                        slugElement.style.color = '#28a745';

                        setTimeout(() => {
                            slugElement.textContent = originalText;
                            slugElement.style.color = '';
                        }, 1000);
                    });
                });
            }

            // Animate cards on load
            animateCards();
        });

        function animateCards() {
            const cards = document.querySelectorAll('.detail-container, .stat-card');

            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';

                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        }

        // Confirm actions with better UX
        function confirmAction(message, callback) {
            if (confirm(message)) {
                // Show loading state
                const button = event.target.closest('button') || event.target.closest('a');
                if (button) {
                    const originalContent = button.innerHTML;
                    button.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Loading...';
                    button.disabled = true;

                    // Restore button state if action is cancelled
                    setTimeout(() => {
                        if (callback) callback();
                    }, 100);
                }
                return true;
            }
            return false;
        }

        // Enhanced form submissions
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn && !submitBtn.disabled) {
                    setTimeout(() => {
                        submitBtn.disabled = true;
                        const originalContent = submitBtn.innerHTML;
                        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Processing...';
                    }, 50);
                }
            });
        });

        // Reading time calculation
        function calculateReadingTime(text) {
            const wordsPerMinute = 200;
            const words = text.split(/\s+/).length;
            const minutes = Math.ceil(words / wordsPerMinute);
            return minutes;
        }

        // Add smooth scrolling to anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Performance logging
        window.addEventListener('load', function() {
            const loadTime = window.performance.timing.loadEventEnd - window.performance.timing.navigationStart;
            console.log(`Detail page loaded in ${loadTime}ms`);
        });
    </script>
@endpush
