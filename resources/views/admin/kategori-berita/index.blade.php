{{-- Kategori Berita Management --}}
@extends('layouts.main')

@push('style')
    <style>
        /* Kategori Berita Management Styles */
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
        .kategori-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .kategori-stat-card {
            background: var(--warm-white);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .kategori-stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-orange), var(--primary-green));
        }

        .kategori-stat-card:hover {
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

        .stat-icon.active {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .stat-icon.inactive {
            background: linear-gradient(135deg, #ff8c42, #ffa726);
        }

        .stat-icon.with-berita {
            background: linear-gradient(135deg, #dc3545, #e74c3c);
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

        .btn-info {
            background: linear-gradient(135deg, #17a2b8, #138496);
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

        /* Data Table */
        .data-table-container {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            overflow: visible;
            /* Changed from hidden to visible */
        }

        .table-responsive {
            border-radius: 12px;
            overflow-x: auto;
            overflow-y: visible;
            /* Allow vertical overflow for dropdowns */
        }

        /* Dropdown specific fixes */
        .table .dropdown {
            position: static;
            /* Ensure dropdown can overflow table bounds */
        }

        .table .dropdown-menu {
            position: absolute;
            z-index: 1050;
            /* Higher z-index to appear above other elements */
            min-width: 160px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Fix for dropdown at the end of table */
        .table tbody tr:last-child .dropdown-menu,
        .table tbody tr:nth-last-child(2) .dropdown-menu {
            transform: translateY(-100%);
            top: auto;
            bottom: 0;
        }

        /* Dropdown that opens upward */
        .dropup .dropdown-menu {
            top: auto;
            bottom: 100%;
            margin-top: 0;
            margin-bottom: 2px;
        }

        .dropdown-menu-up {
            transform: translateY(-100%) !important;
            top: auto !important;
            bottom: 100% !important;
            margin-bottom: 2px !important;
        }

        /* Ensure dropdown items are properly styled */
        .dropdown-item {
            padding: 8px 16px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dropdown-item:hover {
            background-color: var(--cream);
        }

        .dropdown-item.text-danger:hover {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        /* Ensure table container doesn't clip dropdowns */
        .table-responsive {
            overflow-x: auto;
            overflow-y: visible;
        }

        @media (max-width: 768px) {
            .table-responsive {
                overflow-y: auto;
                /* On mobile, allow vertical scroll */
            }

            /* Mobile dropdown adjustments */
            .dropdown-menu {
                position: fixed !important;
                transform: none !important;
                left: 10px !important;
                right: 10px !important;
                width: auto !important;
                max-width: calc(100vw - 20px) !important;
            }
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

        /* Kategori Item Styles */
        .kategori-item {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .kategori-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .kategori-content {
            flex: 1;
            min-width: 0;
        }

        .kategori-title {
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 3px;
            line-height: 1.3;
        }

        [data-theme="dark"] .kategori-title {
            color: var(--light-green);
        }

        .kategori-slug {
            font-size: 0.85rem;
            color: var(--soft-gray);
            font-family: 'Courier New', monospace;
        }

        .kategori-description {
            font-size: 0.9rem;
            color: var(--soft-gray);
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        /* Badges */
        .badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .badge-warning {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            color: white;
        }

        .badge-secondary {
            background: linear-gradient(135deg, #6c757d, #8e9297);
            color: white;
        }

        .badge-danger {
            background: linear-gradient(135deg, #dc3545, #e74c3c);
            color: white;
        }

        .badge-info {
            background: linear-gradient(135deg, #17a2b8, #138496);
            color: white;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.8rem;
            border-radius: 8px;
        }

        /* Bulk Actions */
        .bulk-actions {
            background: var(--cream);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            display: none;
            align-items: center;
            gap: 15px;
        }

        .bulk-actions.show {
            display: flex;
        }

        .bulk-select-all {
            margin-right: 10px;
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

        .alert-info {
            background: rgba(23, 162, 184, 0.1);
            border-left-color: #17a2b8;
            color: #0c5460;
        }

        /* Status Toggle Button */
        .status-toggle {
            border: none;
            border-radius: 20px;
            padding: 6px 12px;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-toggle.active {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .status-toggle.inactive {
            background: linear-gradient(135deg, #6c757d, #8e9297);
            color: white;
        }

        .status-toggle:hover {
            transform: scale(1.05);
        }

        /* Urutan Badge */
        .urutan-badge {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            color: white;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            min-width: 30px;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .kategori-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .table-responsive {
                border-radius: 12px;
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

            .kategori-item {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 576px) {
            .kategori-stats {
                grid-template-columns: 1fr;
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

            .bulk-actions {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
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
                    <li class="breadcrumb-item active">Kategori Berita</li>
                </ol>
            </nav>
            <h1 class="page-title">Kelola Kategori Berita</h1>
            <p class="page-subtitle">Kelola dan atur kategori untuk mengorganisir berita</p>
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

        @if (session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="bi bi-info-circle me-2"></i>
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Statistics -->
        <div class="kategori-stats">
            <div class="kategori-stat-card">
                <div class="stat-icon total">
                    <i class="bi bi-tags"></i>
                </div>
                <div class="stat-number">{{ number_format($statistics['total']) }}</div>
                <div class="stat-label">Total Kategori</div>
            </div>
            <div class="kategori-stat-card">
                <div class="stat-icon active">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-number">{{ number_format($statistics['active']) }}</div>
                <div class="stat-label">Kategori Aktif</div>
            </div>
            <div class="kategori-stat-card">
                <div class="stat-icon inactive">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div class="stat-number">{{ number_format($statistics['inactive']) }}</div>
                <div class="stat-label">Non-Aktif</div>
            </div>
            <div class="kategori-stat-card">
                <div class="stat-icon with-berita">
                    <i class="bi bi-newspaper"></i>
                </div>
                <div class="stat-number">{{ number_format($statistics['with_berita']) }}</div>
                <div class="stat-label">Berisi Berita</div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-header">
                <h4 class="filter-title">
                    <i class="bi bi-funnel me-2"></i>Filter & Pencarian
                </h4>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('admin.kategori-berita.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Kategori
                    </a>
                    <button type="button" class="btn btn-outline-primary" onclick="reorderKategori()">
                        <i class="bi bi-arrows-move me-2"></i>Atur Urutan
                    </button>
                </div>
            </div>

            <form method="GET" action="{{ route('admin.kategori-berita.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Cari Kategori</label>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama kategori atau deskripsi...">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Urutan</label>
                    <select class="form-select" name="sort_by">
                        <option value="urutan" {{ request('sort_by') == 'urutan' ? 'selected' : '' }}>Urutan</option>
                        <option value="nama" {{ request('sort_by') == 'nama' ? 'selected' : '' }}>Nama</option>
                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Tanggal
                            Dibuat</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Arah</label>
                    <select class="form-select" name="sort_order">
                        <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>A-Z / Lama-Baru
                        </option>
                        <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Z-A / Baru-Lama
                        </option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-search"></i>
                        </button>
                        <a href="{{ route('admin.kategori-berita.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Bulk Actions -->
        <div class="bulk-actions" id="bulkActions">
            <input type="checkbox" class="form-check-input bulk-select-all" id="selectAll">
            <label for="selectAll" class="form-check-label me-3">Pilih Semua</label>

            <form action="{{ route('admin.kategori-berita.bulk-action') }}" method="POST" id="bulkForm"
                class="d-flex gap-2 flex-wrap">
                @csrf
                <input type="hidden" name="action" id="bulkAction">
                <div id="selectedItems"></div>

                <button type="button" class="btn btn-sm btn-success" onclick="setBulkAction('activate')">
                    <i class="bi bi-check-circle me-1"></i>Aktifkan
                </button>
                <button type="button" class="btn btn-sm btn-warning" onclick="setBulkAction('deactivate')">
                    <i class="bi bi-x-circle me-1"></i>Non-aktifkan
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="setBulkAction('delete')">
                    <i class="bi bi-trash me-1"></i>Hapus
                </button>
            </form>
        </div>

        <!-- Data Table -->
        <div class="data-table-container">
            <div class="table-header">
                <h4 class="table-title">
                    <i class="bi bi-list me-2"></i>Daftar Kategori Berita
                </h4>
                <div class="text-muted">
                    Menampilkan {{ $kategoriList->firstItem() ?? 0 }} - {{ $kategoriList->lastItem() ?? 0 }} dari
                    {{ $kategoriList->total() }} kategori
                </div>
            </div>

            @if ($kategoriList->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="40">
                                    <input type="checkbox" class="form-check-input" id="masterCheck">
                                </th>
                                <th width="80">Urutan</th>
                                <th>Kategori</th>
                                <th width="200">Deskripsi</th>
                                <th width="100">Status</th>
                                <th width="100">Jumlah Berita</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kategoriList as $kategori)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input item-check"
                                            value="{{ $kategori->id }}" name="selected_items[]">
                                    </td>
                                    <td>
                                        <span class="urutan-badge">{{ $kategori->urutan }}</span>
                                    </td>
                                    <td>
                                        <div class="kategori-item">
                                            <div class="kategori-icon" style="background-color: {{ $kategori->warna }};">
                                                <i class="{{ $kategori->icon ?? 'bi bi-tag' }}"></i>
                                            </div>
                                            <div class="kategori-content">
                                                <div class="kategori-title">{{ $kategori->nama }}</div>
                                                <div class="kategori-slug">{{ $kategori->slug }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="kategori-description">
                                            {{ $kategori->deskripsi ?? 'Tidak ada deskripsi' }}
                                        </div>
                                    </td>
                                    <td>
                                        <form method="POST"
                                            action="{{ route('admin.kategori-berita.toggle-active', $kategori->slug) }}"
                                            style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="status-toggle {{ $kategori->is_active ? 'active' : 'inactive' }}">
                                                <i
                                                    class="bi bi-{{ $kategori->is_active ? 'check-circle' : 'x-circle' }} me-1"></i>
                                                {{ $kategori->is_active ? 'Aktif' : 'Non-Aktif' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        @if ($kategori->beritas_count > 0)
                                            <a href="{{ route('admin.kategori-berita.show', $kategori->slug) }}"
                                                class="badge badge-info text-decoration-none">
                                                {{ $kategori->beritas_count }} Berita
                                            </a>
                                        @else
                                            <span class="badge badge-secondary">0 Berita</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.kategori-berita.show', $kategori->slug) }}"
                                                class="btn btn-sm btn-outline-primary" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.kategori-berita.edit', $kategori->slug) }}"
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                    type="button" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.kategori-berita.show', $kategori->slug) }}">
                                                            <i class="bi bi-eye me-2"></i>Detail
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.kategori-berita.edit', $kategori->slug) }}">
                                                            <i class="bi bi-pencil me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <form
                                                            action="{{ route('admin.kategori-berita.destroy', $kategori->slug) }}"
                                                            method="POST" style="display: inline;"
                                                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="bi bi-trash me-2"></i>Hapus
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Menampilkan {{ $kategoriList->firstItem() }} - {{ $kategoriList->lastItem() }} dari
                        {{ $kategoriList->total() }}
                        kategori
                    </div>
                    {{ $kategoriList->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-tags"></i>
                    <h5>Belum ada kategori berita</h5>
                    <p class="mb-3">Mulai buat kategori pertama untuk mengorganisir berita</p>
                    <a href="{{ route('admin.kategori-berita.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>Buat Kategori Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Reorder Modal -->
    <div class="modal fade" id="reorderModal" tabindex="-1" aria-labelledby="reorderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reorderModalLabel">
                        <i class="bi bi-arrows-move"></i> Atur Urutan Kategori
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-3">Drag dan drop untuk mengatur urutan kategori</p>
                    <form method="POST" action="{{ route('admin.kategori-berita.update-urutan') }}" id="reorderForm">
                        @csrf
                        <div id="sortable-list" class="list-group">
                            @foreach ($kategoriList as $kategori)
                                <div class="list-group-item d-flex align-items-center" data-id="{{ $kategori->id }}">
                                    <i class="bi bi-grip-vertical text-muted me-3" style="cursor: move;"></i>
                                    <div class="kategori-icon me-2" style="background-color: {{ $kategori->warna }};">
                                        <i class="{{ $kategori->icon ?? 'bi bi-tag' }} text-white"></i>
                                    </div>
                                    <span class="flex-grow-1">{{ $kategori->nama }}</span>
                                    <span class="badge bg-secondary">{{ $kategori->urutan }}</span>
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="reorderForm" class="btn btn-primary">Simpan Urutan</button>
                </div>
            </div>
        </div>
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

            // Initialize bulk actions
            initBulkActions();
        });

        // Bulk Actions Functionality
        function initBulkActions() {
            const masterCheck = document.getElementById('masterCheck');
            const itemChecks = document.querySelectorAll('.item-check');
            const bulkActions = document.getElementById('bulkActions');
            const selectAll = document.getElementById('selectAll');

            // Master checkbox functionality
            if (masterCheck) {
                masterCheck.addEventListener('change', function() {
                    itemChecks.forEach(check => {
                        check.checked = this.checked;
                    });
                    toggleBulkActions();
                });
            }

            // Individual checkbox functionality
            itemChecks.forEach(check => {
                check.addEventListener('change', function() {
                    const checkedItems = document.querySelectorAll('.item-check:checked');
                    if (masterCheck) {
                        masterCheck.checked = checkedItems.length === itemChecks.length;
                        masterCheck.indeterminate = checkedItems.length > 0 && checkedItems.length <
                            itemChecks.length;
                    }
                    toggleBulkActions();
                });
            });

            // Select all functionality
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    itemChecks.forEach(check => {
                        check.checked = this.checked;
                    });
                    if (masterCheck) {
                        masterCheck.checked = this.checked;
                        masterCheck.indeterminate = false;
                    }
                    toggleBulkActions();
                });
            }

            function toggleBulkActions() {
                const checkedItems = document.querySelectorAll('.item-check:checked');
                if (checkedItems.length > 0) {
                    bulkActions.classList.add('show');
                    updateSelectedItems();
                } else {
                    bulkActions.classList.remove('show');
                }
            }

            function updateSelectedItems() {
                const checkedItems = document.querySelectorAll('.item-check:checked');
                const selectedItemsContainer = document.getElementById('selectedItems');
                selectedItemsContainer.innerHTML = '';

                checkedItems.forEach(item => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'selected_items[]';
                    input.value = item.value;
                    selectedItemsContainer.appendChild(input);
                });
            }
        }

        // Set bulk action and submit form
        function setBulkAction(action) {
            const checkedItems = document.querySelectorAll('.item-check:checked');

            if (checkedItems.length === 0) {
                alert('Pilih minimal satu kategori untuk melakukan aksi bulk!');
                return;
            }

            let confirmMessage = '';
            switch (action) {
                case 'delete':
                    confirmMessage = `Yakin ingin menghapus ${checkedItems.length} kategori yang dipilih?`;
                    break;
                case 'activate':
                    confirmMessage = `Yakin ingin mengaktifkan ${checkedItems.length} kategori yang dipilih?`;
                    break;
                case 'deactivate':
                    confirmMessage = `Yakin ingin menonaktifkan ${checkedItems.length} kategori yang dipilih?`;
                    break;
            }

            if (confirm(confirmMessage)) {
                document.getElementById('bulkAction').value = action;
                document.getElementById('bulkForm').submit();
            }
        }

        // Reorder functionality
        function reorderKategori() {
            const modal = new bootstrap.Modal(document.getElementById('reorderModal'));
            modal.show();
        }

        // Initialize sortable functionality (requires jQuery UI)
        $(document).ready(function() {
            if (typeof jQuery !== 'undefined' && jQuery.ui) {
                $('#sortable-list').sortable({
                    handle: '.bi-grip-vertical',
                    update: function(event, ui) {
                        // Update form data when order changes
                        const orders = [];
                        $('#sortable-list .list-group-item').each(function(index) {
                            orders.push($(this).data('id'));
                        });

                        // Add hidden inputs to form
                        const form = document.getElementById('reorderForm');
                        const existingInputs = form.querySelectorAll('input[name="orders[]"]');
                        existingInputs.forEach(input => input.remove());

                        orders.forEach((id, index) => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'orders[]';
                            input.value = id;
                            form.appendChild(input);
                        });
                    }
                });
            }
        });

        // Search with debounce
        let searchTimeout;
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    // Auto submit form after 500ms of no typing
                    if (this.value.length >= 3 || this.value.length === 0) {
                        this.form.submit();
                    }
                }, 500);
            });
        }

        // Status toggle with loading effect
        document.querySelectorAll('.status-toggle').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                const form = this.closest('form');
                const originalContent = this.innerHTML;

                // Add loading state
                this.innerHTML = '<i class="bi bi-hourglass-split"></i> Loading...';
                this.disabled = true;

                // Submit form after a short delay for UX
                setTimeout(() => {
                    form.submit();
                }, 300);
            });
        });

        // Auto-submit filter form on select change
        document.querySelectorAll('form select').forEach(select => {
            select.addEventListener('change', function() {
                this.form.submit();
            });
        });

        // Fix dropdown positioning
        function initDropdownFix() {
            const dropdownButtons = document.querySelectorAll('.dropdown button[data-bs-toggle="dropdown"]');

            dropdownButtons.forEach(button => {
                button.addEventListener('show.bs.dropdown', function() {
                    const dropdown = this.closest('.dropdown');
                    const menu = dropdown.querySelector('.dropdown-menu');
                    const rect = this.getBoundingClientRect();
                    const viewportHeight = window.innerHeight;

                    // Check if there's enough space below
                    const spaceBelow = viewportHeight - rect.bottom;
                    const menuHeight = 200; // Approximate dropdown menu height

                    if (spaceBelow < menuHeight) {
                        // Not enough space below, show dropdown above
                        menu.classList.add('dropdown-menu-up');
                        dropdown.classList.add('dropup');
                    } else {
                        // Enough space below, show dropdown below (default)
                        menu.classList.remove('dropdown-menu-up');
                        dropdown.classList.remove('dropup');
                    }
                });
            });
        }

        // Initialize dropdown fix after DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            initDropdownFix();
        });
    </script>
@endpush
