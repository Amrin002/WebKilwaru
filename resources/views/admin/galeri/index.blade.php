{{-- Galeri Management --}}
@extends('layouts.main')

@push('style')
    <style>
        /* Galeri Management Styles */
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

        /* Statistics Cards */
        .galeri-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .galeri-stat-card {
            background: var(--warm-white);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .galeri-stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-orange), var(--primary-green));
        }

        .galeri-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: white;
            margin-bottom: 15px;
        }

        .stat-icon.total {
            background: linear-gradient(135deg, #4a7c59, #8fbc8f);
        }

        .stat-icon.today {
            background: linear-gradient(135deg, #ff8c42, #ffa726);
        }

        .stat-icon.month {
            background: linear-gradient(135deg, #2d5016, #4a7c59);
        }

        .stat-icon.year {
            background: linear-gradient(135deg, #6c757d, #8e9297);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-green);
            line-height: 1;
            margin-bottom: 5px;
        }

        [data-theme="dark"] .stat-number {
            color: var(--light-green);
        }

        .stat-label {
            color: var(--soft-gray);
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Filter and Search Section */
        .filter-section {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .filter-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-green);
            margin: 0;
        }

        [data-theme="dark"] .filter-title {
            color: var(--light-green);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45, 80, 22, 0.3);
        }

        .btn-outline-primary {
            color: var(--primary-green);
            border: 2px solid var(--primary-green);
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            background: transparent;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--primary-green);
            border-color: var(--primary-green);
            transform: translateY(-2px);
        }

        [data-theme="dark"] .btn-outline-primary {
            color: var(--light-green);
            border-color: var(--light-green);
        }

        [data-theme="dark"] .btn-outline-primary:hover {
            background: var(--light-green);
            border-color: var(--light-green);
            color: var(--primary-green);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #e74c3c);
            border: none;
            border-radius: 12px;
            padding: 8px 16px;
            font-weight: 600;
        }

        .form-control,
        .form-select {
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 12px 16px;
            transition: all 0.3s ease;
            background: var(--warm-white);
            color: inherit;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent-orange);
            box-shadow: 0 0 0 0.2rem rgba(255, 140, 66, 0.25);
        }

        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background: var(--warm-white);
            border-color: rgba(255, 255, 255, 0.2);
            color: #333;
        }

        /* Gallery Grid */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }

        .gallery-card {
            background: var(--warm-white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .gallery-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .gallery-image {
            width: 100%;
            height: 200px;
            background: var(--cream);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .gallery-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .gallery-card:hover .gallery-image img {
            transform: scale(1.05);
        }

        .gallery-placeholder {
            font-size: 3rem;
            color: var(--soft-gray);
            opacity: 0.5;
        }

        .gallery-content {
            padding: 20px;
        }

        .gallery-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 8px;
            line-height: 1.4;
        }

        [data-theme="dark"] .gallery-title {
            color: var(--light-green);
        }

        .gallery-description {
            color: var(--soft-gray);
            font-size: 0.9rem;
            margin-bottom: 15px;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .gallery-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-top: 10px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .gallery-date {
            color: var(--soft-gray);
            font-size: 0.8rem;
        }

        .gallery-id {
            background: rgba(45, 80, 22, 0.1);
            color: var(--primary-green);
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.8rem;
            border-radius: 8px;
        }

        /* Data Table Container */
        .data-table-container {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .table-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary-green);
            margin: 0;
        }

        [data-theme="dark"] .table-title {
            color: var(--light-green);
        }

        .view-toggle {
            display: flex;
            gap: 5px;
            background: rgba(0, 0, 0, 0.05);
            padding: 5px;
            border-radius: 10px;
        }

        .view-toggle .btn {
            padding: 8px 16px;
            border: none;
            background: transparent;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .view-toggle .btn.active {
            background: var(--primary-green);
            color: white;
        }

        .table {
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 0;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            font-weight: 600;
            border: none;
            padding: 15px 12px;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            padding: 15px 12px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            color: inherit;
            vertical-align: middle;
        }

        [data-theme="dark"] .table tbody td {
            border-bottom-color: rgba(255, 255, 255, 0.1);
        }

        .table tbody tr:hover {
            background: var(--cream);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table-image {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        /* Pagination */
        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            border: none;
            color: var(--primary-green);
            padding: 10px 15px;
            margin: 0 2px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background: var(--cream);
            color: var(--primary-green);
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border: none;
            color: white;
        }

        [data-theme="dark"] .page-link {
            color: var(--light-green);
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

        .alert-warning {
            background: rgba(255, 193, 7, 0.1);
            border-left-color: #ffc107;
            color: #856404;
        }

        /* Hidden class for view toggle */
        .hidden {
            display: none !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .galeri-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 20px;
            }

            .filter-section {
                padding: 20px;
            }

            .data-table-container {
                padding: 20px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 4px;
            }

            .btn-sm {
                width: 100%;
                font-size: 0.75rem;
            }

            .filter-header {
                flex-direction: column;
                gap: 15px;
            }

            .table-header {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }
        }

        @media (max-width: 576px) {
            .galeri-stats {
                grid-template-columns: 1fr;
            }

            .gallery-grid {
                grid-template-columns: 1fr;
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
                    <li class="breadcrumb-item active">Galeri Foto</li>
                </ol>
            </nav>
            <h1 class="page-title">Galeri Foto Desa</h1>
            <p class="page-subtitle">Kelola dan pantau galeri foto kegiatan dan dokumentasi desa</p>
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

        <!-- Statistics -->
        <div class="galeri-stats">
            <div class="galeri-stat-card">
                <div class="stat-icon total">
                    <i class="bi bi-images"></i>
                </div>
                <div class="stat-number">{{ number_format($galeris->total() ?? 0) }}</div>
                <div class="stat-label">Total Foto</div>
            </div>
            <div class="galeri-stat-card">
                <div class="stat-icon today">
                    <i class="bi bi-calendar-plus"></i>
                </div>
                <div class="stat-number">{{ $galeris->where('created_at', '>=', today())->count() }}</div>
                <div class="stat-label">Hari Ini</div>
            </div>
            <div class="galeri-stat-card">
                <div class="stat-icon month">
                    <i class="bi bi-calendar-month"></i>
                </div>
                <div class="stat-number">{{ $galeris->where('created_at', '>=', now()->startOfMonth())->count() }}</div>
                <div class="stat-label">Bulan Ini</div>
            </div>
            <div class="galeri-stat-card">
                <div class="stat-icon year">
                    <i class="bi bi-calendar-year"></i>
                </div>
                <div class="stat-number">{{ $galeris->where('created_at', '>=', now()->startOfYear())->count() }}</div>
                <div class="stat-label">Tahun Ini</div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-header">
                <h4 class="filter-title">
                    <i class="bi bi-funnel me-2"></i>Filter & Pencarian
                </h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Foto Baru
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-gear me-2"></i>Pengaturan
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="deleteAll()">
                                    <i class="bi bi-trash me-2"></i>Hapus Semua
                                </a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('public.galeri.index') }}" target="_blank">
                                    <i class="bi bi-eye me-2"></i>Lihat Galeri Public
                                </a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <form method="GET" action="{{ route('admin.galeri.index') }}" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Cari Nama Kegiatan atau Keterangan</label>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama kegiatan atau keterangan foto...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Upload</label>
                    <input type="date" class="form-control" name="date" value="{{ request('date') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-search"></i>
                        </button>
                        <a href="{{ route('admin.galeri.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Data Display -->
        <div class="data-table-container">
            <div class="table-header">
                <h4 class="table-title">
                    <i class="bi bi-grid me-2"></i>Galeri Foto
                </h4>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-muted">
                        {{ $galeris->count() }} foto dari {{ $galeris->total() }} total
                    </div>
                    <div class="view-toggle">
                        <button class="btn active" id="gridView" onclick="toggleView('grid')">
                            <i class="bi bi-grid-3x3-gap"></i> Grid
                        </button>
                        <button class="btn" id="listView" onclick="toggleView('list')">
                            <i class="bi bi-list"></i> List
                        </button>
                    </div>
                </div>
            </div>

            @if ($galeris->count() > 0)
                <!-- Grid View -->
                <div id="gridContainer" class="gallery-grid">
                    @foreach ($galeris as $galeri)
                        <div class="gallery-card">
                            <div class="gallery-image">
                                @if ($galeri->foto)
                                    <img src="{{ $galeri->foto_url }}" alt="{{ $galeri->nama_kegiatan }}"
                                        onclick="previewImage('{{ $galeri->foto_url }}', '{{ $galeri->nama_kegiatan }}')">
                                @else
                                    <i class="bi bi-image gallery-placeholder"></i>
                                @endif
                            </div>
                            <div class="gallery-content">
                                <h6 class="gallery-title">{{ $galeri->nama_kegiatan }}</h6>
                                @if ($galeri->keterangan)
                                    <p class="gallery-description">{{ $galeri->keterangan }}</p>
                                @endif
                                <div class="gallery-meta">
                                    <span class="gallery-date">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ $galeri->created_at->format('d M Y') }}
                                    </span>
                                    <span class="gallery-id">#{{ $galeri->id }}</span>
                                </div>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.galeri.show', $galeri->id) }}"
                                        class="btn btn-sm btn-outline-primary" title="Detail">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                    <a href="{{ route('admin.galeri.edit', $galeri->id) }}"
                                        class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger"
                                        onclick="confirmDelete({{ $galeri->id }})" title="Hapus">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- List View -->
                <div id="listContainer" class="hidden">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal Upload</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($galeris as $galeri)
                                    <tr>
                                        <td>
                                            @if ($galeri->foto)
                                                <img src="{{ $galeri->foto_url }}" alt="{{ $galeri->nama_kegiatan }}"
                                                    class="table-image"
                                                    onclick="previewImage('{{ $galeri->foto_url }}', '{{ $galeri->nama_kegiatan }}')">
                                            @else
                                                <div
                                                    class="table-image d-flex align-items-center justify-content-center bg-light">
                                                    <i class="bi bi-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $galeri->nama_kegiatan }}</strong>
                                            <br>
                                            <small class="text-muted">#{{ $galeri->id }}</small>
                                        </td>
                                        <td>
                                            @if ($galeri->keterangan)
                                                {{ Str::limit($galeri->keterangan, 50) }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $galeri->created_at->format('d M Y H:i') }}</td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('admin.galeri.show', $galeri->id) }}"
                                                    class="btn btn-sm btn-outline-primary" title="Detail">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.galeri.edit', $galeri->id) }}"
                                                    class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="confirmDelete({{ $galeri->id }})" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Menampilkan {{ $galeris->firstItem() }} - {{ $galeris->lastItem() }} dari {{ $galeris->total() }}
                        foto
                    </div>
                    {{ $galeris->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-images"></i>
                    <h5>Tidak ada foto galeri</h5>
                    <p class="mb-3">Belum ada foto yang diupload ke galeri desa</p>
                    <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>Upload Foto Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Image Preview Modal -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imagePreviewModalLabel">Preview Foto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="previewImage" src="" alt="" class="img-fluid rounded"
                        style="max-height: 500px;">
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Forms -->
    @foreach ($galeris as $galeri)
        <form id="deleteForm{{ $galeri->id }}" action="{{ route('admin.galeri.destroy', $galeri->id) }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
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

        // View Toggle Functionality
        function toggleView(view) {
            const gridView = document.getElementById('gridView');
            const listView = document.getElementById('listView');
            const gridContainer = document.getElementById('gridContainer');
            const listContainer = document.getElementById('listContainer');

            if (view === 'grid') {
                gridView.classList.add('active');
                listView.classList.remove('active');
                gridContainer.classList.remove('hidden');
                listContainer.classList.add('hidden');
                localStorage.setItem('galeriView', 'grid');
            } else {
                listView.classList.add('active');
                gridView.classList.remove('active');
                listContainer.classList.remove('hidden');
                gridContainer.classList.add('hidden');
                localStorage.setItem('galeriView', 'list');
            }
        }

        // Load saved view preference
        document.addEventListener('DOMContentLoaded', function() {
            const savedView = localStorage.getItem('galeriView') || 'grid';
            toggleView(savedView);
        });

        // Image Preview Function
        function previewImage(imageUrl, imageName) {
            const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
            const previewImg = document.getElementById('previewImage');
            const modalTitle = document.getElementById('imagePreviewModalLabel');

            previewImg.src = imageUrl;
            previewImg.alt = imageName;
            modalTitle.textContent = imageName;

            modal.show();
        }

        // Confirm Delete Function
        function confirmDelete(galeriId) {
            if (confirm('Yakin ingin menghapus foto ini? Tindakan ini tidak dapat dibatalkan.')) {
                document.getElementById('deleteForm' + galeriId).submit();
            }
        }

        // // Delete All Function
        function deleteAll() {
            if (confirm(
                    'Yakin ingin menghapus SEMUA foto galeri? Tindakan ini tidak dapat dibatalkan dan akan menghapus seluruh galeri foto.'
                )) {
                if (confirm('Konfirmasi sekali lagi - SEMUA foto galeri akan dihapus permanen!')) {
                    // Create form for delete all
                    const form = document.createElement('form');
                    form.method = 'POST';


                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';

                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';

                    form.appendChild(csrfToken);
                    form.appendChild(methodField);
                    document.body.appendChild(form);
                    form.submit();
                }
            }
        }

        // Search on Enter
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        this.closest('form').submit();
                    }
                });
            }

            // Auto submit on date change
            const dateInput = document.querySelector('input[name="date"]');
            if (dateInput) {
                dateInput.addEventListener('change', function() {
                    this.closest('form').submit();
                });
            }
        });

        // Image Loading Error Handler
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('img[src]');
            images.forEach(img => {
                img.addEventListener('error', function() {
                    this.style.display = 'none';
                    const placeholder = document.createElement('div');
                    placeholder.className =
                        'gallery-placeholder d-flex align-items-center justify-content-center';
                    placeholder.innerHTML = '<i class="bi bi-image-fill text-muted"></i>';
                    placeholder.style.width = this.style.width || '100%';
                    placeholder.style.height = this.style.height || '200px';
                    placeholder.style.background = 'var(--cream)';
                    placeholder.style.borderRadius = '10px';
                    this.parentNode.insertBefore(placeholder, this);
                });
            });
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl + N = Tambah foto baru
            if (e.ctrlKey && e.key === 'n') {
                e.preventDefault();
                window.location.href = '{{ route('admin.galeri.create') }}';
            }

            // Escape = Close modal
            if (e.key === 'Escape') {
                const modal = bootstrap.Modal.getInstance(document.getElementById('imagePreviewModal'));
                if (modal) {
                    modal.hide();
                }
            }
        });

        // Drag and Drop hint
        function initDragDrop() {
            const dropZone = document.querySelector('.gallery-grid');

            if (dropZone) {
                dropZone.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.style.background = 'rgba(45, 80, 22, 0.05)';
                    this.style.border = '2px dashed var(--primary-green)';
                });

                dropZone.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    this.style.background = '';
                    this.style.border = '';
                });

                dropZone.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.style.background = '';
                    this.style.border = '';

                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        // Redirect ke halaman create
                        window.location.href = '{{ route('admin.galeri.create') }}';
                    }
                });
            }
        }

        // Initialize drag drop
        document.addEventListener('DOMContentLoaded', initDragDrop);

        // Toast notification helper
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `alert alert-${type} position-fixed`;
            toast.style.top = '20px';
            toast.style.right = '20px';
            toast.style.zIndex = '9999';
            toast.style.minWidth = '300px';
            toast.innerHTML = `
                <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
            `;

            document.body.appendChild(toast);

            setTimeout(() => {
                if (toast.parentElement) {
                    toast.remove();
                }
            }, 5000);
        }
    </script>
@endpush
