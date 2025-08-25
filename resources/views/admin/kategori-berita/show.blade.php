{{-- Kategori Berita Detail Page --}}
@extends('layouts.main')

@push('style')
    <style>
        /* Kategori Detail Page Styles */
        .page-header {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 10px;
        }

        [data-theme="dark"] .page-title {
            color: var(--light-green);
        }

        .page-subtitle {
            color: var(--soft-gray);
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
            font-size: 0.9rem;
        }

        .breadcrumb-item a {
            color: var(--primary-green);
            text-decoration: none;
        }

        [data-theme="dark"] .breadcrumb-item a {
            color: var(--light-green);
        }

        .breadcrumb-item.active {
            color: var(--soft-gray);
        }

        /* Category Header Section */
        .kategori-header {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .kategori-header-content {
            display: flex;
            align-items: center;
            gap: 25px;
            margin-bottom: 25px;
        }

        .kategori-icon-large {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            flex-shrink: 0;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .kategori-info {
            flex: 1;
        }

        .kategori-name {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 5px;
        }

        [data-theme="dark"] .kategori-name {
            color: var(--light-green);
        }

        .kategori-slug-display {
            font-family: 'Courier New', monospace;
            color: var(--soft-gray);
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .kategori-description-full {
            color: var(--soft-gray);
            font-size: 1.1rem;
            line-height: 1.6;
        }

        /* Category Actions */
        .kategori-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .action-btn {
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45, 80, 22, 0.3);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            color: white;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 140, 66, 0.3);
        }

        .btn-outline-danger {
            color: #dc3545;
            border: 2px solid #dc3545;
            background: transparent;
        }

        .btn-outline-danger:hover {
            background: #dc3545;
            border-color: #dc3545;
            transform: translateY(-2px);
            color: white;
        }

        /* Status and Stats Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .info-card {
            background: var(--warm-white);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .info-label {
            font-size: 0.85rem;
            color: var(--soft-gray);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .info-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-green);
        }

        [data-theme="dark"] .info-value {
            color: var(--light-green);
        }

        .status-badge-large {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-badge-large.active {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .status-badge-large.inactive {
            background: linear-gradient(135deg, #6c757d, #8e9297);
            color: white;
        }

        /* Color Preview */
        .color-preview {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .color-box {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.5);
        }

        .color-code {
            font-family: 'Courier New', monospace;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-green);
        }

        [data-theme="dark"] .color-code {
            color: var(--light-green);
        }

        /* Related News Section */
        .related-news {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary-green);
            margin: 0;
        }

        [data-theme="dark"] .section-title {
            color: var(--light-green);
        }

        .news-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .news-item {
            background: var(--cream);
            border-radius: 12px;
            padding: 20px;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .news-item:hover {
            transform: translateX(5px);
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
        }

        .news-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .news-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 5px;
            flex: 1;
        }

        [data-theme="dark"] .news-title {
            color: var(--light-green);
        }

        .news-meta {
            display: flex;
            gap: 20px;
            font-size: 0.85rem;
            color: var(--soft-gray);
            margin-bottom: 10px;
        }

        .news-meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .news-excerpt {
            color: var(--soft-gray);
            font-size: 0.95rem;
            line-height: 1.5;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .news-status {
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            flex-shrink: 0;
        }

        .news-status.published {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .news-status.draft {
            background: linear-gradient(135deg, #6c757d, #8e9297);
            color: white;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--soft-gray);
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h5 {
            margin-bottom: 10px;
            color: var(--primary-green);
        }

        [data-theme="dark"] .empty-state h5 {
            color: var(--light-green);
        }

        /* Alert Messages */
        .alert {
            border: none;
            border-radius: 15px;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-left: 4px solid;
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.1);
            border-left-color: #28a745;
            color: #155724;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            border-left-color: #dc3545;
            color: #721c24;
        }

        /* Delete Confirmation */
        .delete-warning {
            background: rgba(220, 53, 69, 0.1);
            border: 2px solid #dc3545;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }

        .delete-warning-title {
            color: #dc3545;
            font-weight: 600;
            margin-bottom: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .kategori-header-content {
                flex-direction: column;
                text-align: center;
            }

            .kategori-icon-large {
                margin: 0 auto;
            }

            .kategori-info {
                text-align: center;
            }

            .kategori-actions {
                justify-content: center;
                width: 100%;
            }

            .action-btn {
                flex: 1;
                min-width: 120px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .section-header {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }

            .news-header {
                flex-direction: column;
                gap: 10px;
            }

            .news-meta {
                flex-wrap: wrap;
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
                    <li class="breadcrumb-item">Berita & Info</li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.kategori-berita.index') }}">Kategori Berita</a>
                    </li>
                    <li class="breadcrumb-item active">{{ $kategori->nama }}</li>
                </ol>
            </nav>
            <h1 class="page-title">Detail Kategori Berita</h1>
            <p class="page-subtitle">Informasi lengkap tentang kategori {{ $kategori->nama }}</p>
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

        <!-- Category Header -->
        <div class="kategori-header">
            <div class="kategori-header-content">
                <div class="kategori-icon-large" style="background-color: {{ $kategori->warna }};">
                    <i class="{{ $kategori->icon ?? 'bi bi-tag' }}"></i>
                </div>
                <div class="kategori-info">
                    <h2 class="kategori-name">{{ $kategori->nama }}</h2>
                    <div class="kategori-slug-display">{{ $kategori->slug }}</div>
                    @if ($kategori->deskripsi)
                        <p class="kategori-description-full">{{ $kategori->deskripsi }}</p>
                    @else
                        <p class="kategori-description-full text-muted">Tidak ada deskripsi untuk kategori ini</p>
                    @endif
                </div>
            </div>

            <div class="kategori-actions">
                <a href="{{ route('admin.kategori-berita.edit', $kategori->slug) }}" class="btn btn-warning action-btn">
                    <i class="bi bi-pencil me-2"></i>Edit Kategori
                </a>
                <form action="{{ route('admin.kategori-berita.toggle-active', $kategori->slug) }}" method="POST"
                    style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="btn {{ $kategori->is_active ? 'btn-outline-warning' : 'btn-success' }} action-btn">
                        <i class="bi bi-{{ $kategori->is_active ? 'x-circle' : 'check-circle' }} me-2"></i>
                        {{ $kategori->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </form>
                @if ($kategori->beritas_count == 0)
                    <form action="{{ route('admin.kategori-berita.destroy', $kategori->slug) }}" method="POST"
                        style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger action-btn">
                            <i class="bi bi-trash me-2"></i>Hapus Kategori
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Category Information Grid -->
        <div class="info-grid">
            <div class="info-card">
                <div class="info-label">Status</div>
                <div class="info-value">
                    <span class="status-badge-large {{ $kategori->is_active ? 'active' : 'inactive' }}">
                        <i class="bi bi-{{ $kategori->is_active ? 'check-circle' : 'x-circle' }}"></i>
                        {{ $kategori->is_active ? 'Aktif' : 'Non-Aktif' }}
                    </span>
                </div>
            </div>

            <div class="info-card">
                <div class="info-label">Jumlah Berita</div>
                <div class="info-value">{{ $kategori->beritas_count }} Berita</div>
            </div>

            <div class="info-card">
                <div class="info-label">Urutan</div>
                <div class="info-value">#{{ $kategori->urutan }}</div>
            </div>

            <div class="info-card">
                <div class="info-label">Warna Kategori</div>
                <div class="color-preview">
                    <div class="color-box" style="background-color: {{ $kategori->warna }};"></div>
                    <span class="color-code">{{ $kategori->warna }}</span>
                </div>
            </div>

            <div class="info-card">
                <div class="info-label">Icon</div>
                <div class="info-value">
                    <i class="{{ $kategori->icon ?? 'bi bi-tag' }} me-2"></i>
                    <code style="font-size: 1rem;">{{ $kategori->icon ?? 'bi bi-tag' }}</code>
                </div>
            </div>

            <div class="info-card">
                <div class="info-label">Dibuat</div>
                <div class="info-value" style="font-size: 1.1rem;">
                    {{ $kategori->created_at->format('d M Y') }}
                    <small class="text-muted d-block">{{ $kategori->created_at->format('H:i') }}</small>
                </div>
            </div>
        </div>

        <!-- Related News Section -->
        <div class="related-news">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="bi bi-newspaper me-2"></i>Berita dalam Kategori Ini
                </h3>
                @if ($latestBerita->count() > 0)
                    <a href="{{ route('admin.berita.index', ['kategori' => $kategori->slug]) }}"
                        class="btn btn-outline-primary">
                        <i class="bi bi-arrow-right me-2"></i>Lihat Semua
                    </a>
                @endif
            </div>

            @if ($latestBerita->count() > 0)
                <div class="news-list">
                    @foreach ($latestBerita as $berita)
                        <div class="news-item">
                            <div class="news-header">
                                <h4 class="news-title">
                                    <a href="{{ route('admin.berita.show', $berita->slug) }}" class="text-decoration-none">
                                        {{ $berita->judul }}
                                    </a>
                                </h4>
                                <span class="news-status {{ $berita->status == 'published' ? 'published' : 'draft' }}">
                                    {{ $berita->status == 'published' ? 'Terbit' : 'Draft' }}
                                </span>
                            </div>
                            <div class="news-meta">
                                <div class="news-meta-item">
                                    <i class="bi bi-person"></i>
                                    {{ $berita->penulis->name ?? 'Unknown' }}
                                </div>
                                <div class="news-meta-item">
                                    <i class="bi bi-calendar"></i>
                                    {{ $berita->created_at->format('d M Y') }}
                                </div>
                                <div class="news-meta-item">
                                    <i class="bi bi-eye"></i>
                                    {{ number_format($berita->views ?? 0) }} views
                                </div>
                            </div>
                            <p class="news-excerpt">
                                {{ Str::limit(strip_tags($berita->konten), 150) }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-newspaper"></i>
                    <h5>Belum ada berita dalam kategori ini</h5>
                    <p class="mb-3">Mulai buat berita pertama untuk kategori {{ $kategori->nama }}</p>
                    <a href="{{ route('admin.berita.create', ['kategori' => $kategori->id]) }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>Buat Berita
                    </a>
                </div>
            @endif
        </div>

        <!-- Delete Warning (if category has news) -->
        @if ($kategori->beritas_count > 0)
            <div class="delete-warning">
                <h5 class="delete-warning-title">
                    <i class="bi bi-exclamation-triangle me-2"></i>Peringatan Penghapusan
                </h5>
                <p class="mb-0">
                    Kategori ini tidak dapat dihapus karena masih memiliki {{ $kategori->beritas_count }} berita.
                    Pindahkan atau hapus semua berita terlebih dahulu sebelum menghapus kategori ini.
                </p>
            </div>
        @endif
    </div>
@endsection

@push('script')
    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });

        // Add loading state to form buttons
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    const originalContent = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Loading...';
                    submitBtn.disabled = true;
                }
            });
        });

        // Animate info cards on load
        function animateInfoCards() {
            const cards = document.querySelectorAll('.info-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        }

        // Animate news items on load
        function animateNewsItems() {
            const items = document.querySelectorAll('.news-item');
            items.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateX(-20px)';

                setTimeout(() => {
                    item.style.transition = 'all 0.5s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateX(0)';
                }, 600 + (index * 100));
            });
        }

        // Initialize animations
        window.addEventListener('load', function() {
            animateInfoCards();
            animateNewsItems();
        });

        // Copy color code to clipboard
        document.querySelector('.color-code')?.addEventListener('click', function() {
            const colorCode = this.textContent;
            navigator.clipboard.writeText(colorCode).then(() => {
                // Show temporary feedback
                const originalText = this.textContent;
                this.textContent = 'Copied!';
                this.style.color = '#28a745';

                setTimeout(() => {
                    this.textContent = originalText;
                    this.style.color = '';
                }, 1500);
            });
        });

        // Copy icon class to clipboard
        document.querySelector('.info-card code')?.addEventListener('click', function() {
            const iconClass = this.textContent;
            navigator.clipboard.writeText(iconClass).then(() => {
                // Show temporary feedback
                const originalText = this.textContent;
                this.textContent = 'Copied!';
                this.style.color = '#28a745';

                setTimeout(() => {
                    this.textContent = originalText;
                    this.style.color = '';
                }, 1500);
            });
        });
    </script>
@endpush
