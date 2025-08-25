{{-- Arsip Surat Management --}}
@extends('layouts.main')

@push('style')
    <style>
        /* Arsip Surat Management Styles - Consistent with KK Theme */
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
        .arsip-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .arsip-stat-card {
            background: var(--warm-white);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .arsip-stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-orange), var(--primary-green));
        }

        .arsip-stat-card:hover {
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

        .stat-icon.masuk {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .stat-icon.keluar {
            background: linear-gradient(135deg, #ff8c42, #ffa726);
        }

        .stat-icon.tahun {
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

        /* Data Table */
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

        .badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-primary {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
        }

        .badge-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .badge-warning {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            color: white;
        }

        /* Kategori Surat Badges */
        .kategori-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .kategori-badge.masuk {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .kategori-badge.keluar {
            background: rgba(255, 140, 66, 0.1);
            color: var(--accent-orange);
            border: 1px solid rgba(255, 140, 66, 0.3);
        }

        .kategori-badge i {
            font-size: 0.8rem;
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

        /* Generate Nomor Button */
        .btn-generate {
            background: linear-gradient(135deg, #6f42c1, #8e44ad);
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-generate:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(111, 66, 193, 0.3);
            color: white;
        }

        /* Import Modal Specific Styles - Same as KK */
        .import-step {
            background: rgba(45, 80, 22, 0.05);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 4px solid var(--primary-green);
        }

        .import-step h6 {
            color: var(--primary-green);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .template-download {
            background: linear-gradient(135deg, rgba(255, 140, 66, 0.1), rgba(255, 140, 66, 0.05));
            border: 1px solid rgba(255, 140, 66, 0.3);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
        }

        .file-drop-zone {
            border: 2px dashed #ccc;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            background: var(--cream);
        }

        .file-drop-zone:hover,
        .file-drop-zone.dragover {
            border-color: var(--primary-green);
            background: rgba(45, 80, 22, 0.05);
        }

        .file-drop-zone.has-file {
            border-color: var(--primary-green);
            background: rgba(40, 167, 69, 0.1);
        }

        .btn-template {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-template:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 140, 66, 0.3);
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .arsip-stats {
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
        }

        @media (max-width: 576px) {
            .arsip-stats {
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
                    <li class="breadcrumb-item">Administrasi</li>
                    <li class="breadcrumb-item active">Arsip Surat</li>
                </ol>
            </nav>
            <h1 class="page-title">Arsip Surat</h1>
            <p class="page-subtitle">Kelola dan pantau arsip surat masuk dan keluar di sistem administrasi desa</p>
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

        @if (session('import_errors') && count(session('import_errors')) > 0)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Error Import:</strong>
                <ul class="mb-0 mt-2">
                    @foreach (session('import_errors') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Statistics -->
        <div class="arsip-stats">
            <div class="arsip-stat-card">
                <div class="stat-icon total">
                    <i class="bi bi-archive"></i>
                </div>
                <div class="stat-number">{{ number_format($statistik['total']) }}</div>
                <div class="stat-label">Total Arsip</div>
            </div>
            <div class="arsip-stat-card">
                <div class="stat-icon masuk">
                    <i class="bi bi-arrow-down-circle"></i>
                </div>
                <div class="stat-number">{{ number_format($statistik['surat_masuk']) }}</div>
                <div class="stat-label">Surat Masuk</div>
            </div>
            <div class="arsip-stat-card">
                <div class="stat-icon keluar">
                    <i class="bi bi-arrow-up-circle"></i>
                </div>
                <div class="stat-number">{{ number_format($statistik['surat_keluar']) }}</div>
                <div class="stat-label">Surat Keluar</div>
            </div>
            <div class="arsip-stat-card">
                <div class="stat-icon tahun">
                    <i class="bi bi-calendar-event"></i>
                </div>
                <div class="stat-number">{{ request('tahun', date('Y')) }}</div>
                <div class="stat-label">Tahun Aktif</div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-header">
                <h4 class="filter-title">
                    <i class="bi bi-funnel me-2"></i>Filter & Pencarian
                </h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.arsip-surat.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Arsip Baru
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-download me-2"></i>Export/Import
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.arsip-surat.export', request()->query()) }}">
                                    <i class="bi bi-file-earmark-excel me-2"></i>Export CSV
                                </a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.arsip-surat.statistik') }}">
                                    <i class="bi bi-graph-up me-2"></i>Statistik
                                </a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#importModal">
                                    <i class="bi bi-upload me-2"></i>Import CSV
                                </a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <form method="GET" action="{{ route('admin.arsip-surat.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Cari Nomor, Pengirim, Tujuan, atau Perihal</label>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                        placeholder="Cari nomor surat, pengirim, tujuan, atau perihal...">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Kategori</label>
                    <select class="form-select" name="kategori">
                        <option value="">Semua Kategori</option>
                        <option value="masuk" {{ request('kategori') == 'masuk' ? 'selected' : '' }}>Surat Masuk</option>
                        <option value="keluar" {{ request('kategori') == 'keluar' ? 'selected' : '' }}>Surat Keluar
                        </option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tahun</label>
                    <select class="form-select" name="tahun">
                        <option value="">Semua Tahun</option>
                        @foreach ($tahunList as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Bulan</label>
                    <select class="form-select" name="bulan">
                        <option value="">Semua Bulan</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-search"></i>
                        </button>
                        <a href="{{ route('admin.arsip-surat.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Data Table -->
        <div class="data-table-container">
            <div class="table-header">
                <h4 class="table-title">
                    <i class="bi bi-archive me-2"></i>Daftar Arsip Surat
                </h4>
                <div class="text-muted">
                    Menampilkan {{ $arsipSurat->firstItem() ?? 0 }} - {{ $arsipSurat->lastItem() ?? 0 }} dari
                    {{ $arsipSurat->total() }} data
                </div>
            </div>

            @if ($arsipSurat->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nomor Surat</th>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Pengirim/Tujuan</th>
                                <th>Perihal/Tentang</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($arsipSurat as $arsip)
                                <tr>
                                    <td>
                                        <span class="badge badge-primary">{{ $arsip->nomor_surat }}</span>
                                    </td>
                                    <td>{{ $arsip->tanggal_surat_formatted }}</td>
                                    <td>
                                        <span class="kategori-badge {{ $arsip->kategori_surat }}">
                                            @if ($arsip->kategori_surat == 'masuk')
                                                <i class="bi bi-arrow-down"></i>
                                                Masuk
                                            @elseif($arsip->kategori_surat == 'keluar')
                                                <i class="bi bi-arrow-up"></i>
                                                Keluar
                                            @else
                                                <i class="bi bi-question-circle"></i>
                                                Unknown
                                            @endif
                                        </span>
                                    </td>
                                    <td>{{ $arsip->pihak_terkait }}</td>
                                    <td>
                                        <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                            title="{{ $arsip->konten_utama }}">
                                            {{ $arsip->konten_utama }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($arsip->keterangan)
                                            <div style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                                title="{{ $arsip->keterangan }}">
                                                {{ $arsip->keterangan }}
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.arsip-surat.show', $arsip->id) }}"
                                                class="btn btn-sm btn-outline-primary" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.arsip-surat.edit', $arsip->id) }}"
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.arsip-surat.destroy', $arsip->id) }}"
                                                method="POST" style="display: inline-block;"
                                                onsubmit="return confirm('Yakin ingin menghapus arsip surat ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
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
                        Menampilkan {{ $arsipSurat->firstItem() }} - {{ $arsipSurat->lastItem() }} dari
                        {{ $arsipSurat->total() }}
                        data
                    </div>
                    {{ $arsipSurat->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-archive"></i>
                    <h5>Tidak ada arsip surat</h5>
                    <p class="mb-3">Belum ada arsip surat yang tersedia</p>
                    <a href="{{ route('admin.arsip-surat.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Arsip Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">
                        <i class="bi bi-upload me-2"></i>Import Data Arsip Surat
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Step 1: Download Template -->
                    <div class="import-step">
                        <h6><i class="bi bi-1-circle me-2"></i>Download Template CSV</h6>
                        <p class="mb-2">Download template CSV terlebih dahulu untuk memastikan format data yang benar.
                        </p>
                        <div class="template-download">
                            <i class="bi bi-file-earmark-text" style="font-size: 2rem; color: #28a745;"></i>
                            <div class="mt-2">
                                {{-- <a href="{{ route('admin.arsip-surat.template') }}" class="btn-template"> --}}
                                <i class="bi bi-download"></i>
                                Download Template CSV
                                {{-- </a> --}}
                            </div>
                            <small class="text-muted mt-2 d-block">Template berisi format dan contoh data arsip
                                surat</small>
                        </div>
                    </div>

                    <!-- Step 2: Prepare Data -->
                    <div class="import-step">
                        <h6><i class="bi bi-2-circle me-2"></i>Siapkan Data CSV</h6>
                        <p class="mb-2">Isi template CSV dengan data arsip surat yang akan diimport.</p>
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Format kolom yang diperlukan:</strong><br>
                            <code>nomor_surat | tanggal_surat | pengirim | perihal | tujuan_surat | tentang |
                                keterangan</code>
                        </div>
                    </div>

                    <!-- Step 3: Upload File -->
                    <div class="import-step">
                        <h6><i class="bi bi-3-circle me-2"></i>Upload File CSV</h6>
                        <form action="{{ route('admin.arsip-surat.import') }}" method="POST"
                            enctype="multipart/form-data" id="importForm">
                            @csrf

                            <!-- File Drop Zone -->
                            <div class="file-drop-zone" id="fileDropZone">
                                <i class="bi bi-cloud-upload" style="font-size: 3rem; color: #6c757d;"></i>
                                <h6 class="mt-3 mb-2">Drag & Drop file CSV di sini</h6>
                                <p class="text-muted mb-3">atau klik untuk memilih file</p>
                                <input type="file" class="d-none" name="file" id="fileInput" accept=".csv,.txt"
                                    required>
                                <button type="button" class="btn btn-outline-primary"
                                    onclick="document.getElementById('fileInput').click()">
                                    <i class="bi bi-folder2-open me-2"></i>Pilih File
                                </button>
                            </div>

                            <!-- File Info -->
                            <div class="file-info" id="fileInfo" style="display: none;">
                                <i class="bi bi-file-earmark-text text-success me-2"></i>
                                <span id="fileName"></span>
                                <span class="badge bg-success ms-2" id="fileSize"></span>
                                <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="clearFile()">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>

                            <!-- Progress Container -->
                            <div class="progress-container" id="progressContainer" style="display: none;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Importing data...</small>
                                    <small class="text-muted" id="progressText">0%</small>
                                </div>
                                <div class="import-progress">
                                    <div class="import-progress-bar" id="progressBar"></div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Import Tips -->
                    <div class="import-tips">
                        <h6><i class="bi bi-lightbulb me-2"></i>Tips Import Data</h6>
                        <ul>
                            <li>Pastikan nomor surat belum ada dalam sistem</li>
                            <li>Format tanggal: YYYY-MM-DD (contoh: 2025-08-11)</li>
                            <li>Untuk surat masuk: isi kolom pengirim dan perihal</li>
                            <li>Untuk surat keluar: isi kolom tujuan_surat dan tentang</li>
                            <li>Maksimal 1000 data per file untuk performa optimal</li>
                            <li>Data yang error akan dilewati dan ditampilkan dalam laporan</li>
                        </ul>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="importForm" class="btn btn-primary" id="importBtn" disabled>
                        <i class="bi bi-upload me-2"></i>Import Data
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Generate Nomor Modal -->
    <div class="modal fade" id="generateModal" tabindex="-1" aria-labelledby="generateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="generateModalLabel">
                        <i class="bi bi-hash me-2"></i>Generate Nomor Surat
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Tahun</label>
                            <input type="number" class="form-control" id="generateTahun" value="{{ date('Y') }}"
                                min="2020" max="2030">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Bulan</label>
                            <select class="form-select" id="generateBulan">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $i == date('n') ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="button" class="btn btn-success w-100" onclick="doGenerateNomor()">
                            <i class="bi bi-gear me-2"></i>Generate Nomor Surat
                        </button>
                    </div>
                    <div id="generateResult" class="mt-3" style="display: none;">
                        <div class="alert alert-success">
                            <h6>Nomor Surat Berikutnya:</h6>
                            <h4 id="generatedNomor" class="mb-0"></h4>
                            <small class="text-muted">Nomor urut: <span id="generatedUrut"></span></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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

            // Import Modal functionality
            initializeImportModal();
        });

        // Import Modal Functions
        function initializeImportModal() {
            const fileDropZone = document.getElementById('fileDropZone');
            const fileInput = document.getElementById('fileInput');
            const fileInfo = document.getElementById('fileInfo');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const importBtn = document.getElementById('importBtn');
            const importForm = document.getElementById('importForm');
            const progressContainer = document.getElementById('progressContainer');
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');

            // Global function untuk clear file
            window.clearFile = function() {
                fileInput.value = '';
                fileDropZone.classList.remove('has-file');
                fileInfo.style.display = 'none';
                importBtn.disabled = true;
            }

            // Prevent default behavior on click
            fileDropZone.addEventListener('click', function(e) {
                if (e.target.tagName !== 'BUTTON' && e.target.tagName !== 'INPUT') {
                    e.preventDefault();
                    fileInput.click();
                }
            });

            // File drag and drop handlers
            fileDropZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                fileDropZone.classList.add('dragover');
            });

            fileDropZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                fileDropZone.classList.remove('dragover');
            });

            fileDropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                fileDropZone.classList.remove('dragover');

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    handleFileSelect(files[0]);
                }
            });

            fileInput.addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    handleFileSelect(e.target.files[0]);
                }
            });

            function handleFileSelect(file) {
                // Validate file type
                const fileExtension = file.name.split('.').pop().toLowerCase();
                if (!['csv', 'txt'].includes(fileExtension)) {
                    alert('Hanya file CSV (.csv, .txt) yang diperbolehkan!');
                    clearFile();
                    return;
                }

                // Validate file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('Ukuran file maksimal 5MB!');
                    clearFile();
                    return;
                }

                // Update UI
                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);
                fileDropZone.classList.add('has-file');
                fileInfo.style.display = 'block';
                importBtn.disabled = false;
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Form submission dengan progress
            importForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Validasi file ada
                if (!fileInput.files || fileInput.files.length === 0) {
                    alert('Silakan pilih file terlebih dahulu!');
                    return;
                }

                const formData = new FormData(importForm);

                // Disable button dan show loading
                importBtn.disabled = true;
                importBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Importing...';
                progressContainer.style.display = 'block';

                // Progress animation
                let progress = 0;
                const progressInterval = setInterval(() => {
                    progress += Math.random() * 15;
                    if (progress > 90) progress = 90;
                    updateProgress(progress);
                }, 500);

                // Submit form dengan AJAX
                fetch(importForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        clearInterval(progressInterval);
                        updateProgress(100);

                        if (!response.ok) {
                            throw new Error('Import failed with status: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            setTimeout(() => {
                                alert(data.message || 'Import berhasil!');
                                window.location.reload();
                            }, 1000);
                        } else {
                            throw new Error(data.message || 'Import gagal!');
                        }
                    })
                    .catch(error => {
                        clearInterval(progressInterval);
                        console.error('Error:', error);
                        alert(error.message || 'Terjadi kesalahan saat import data!');
                        resetImportForm();
                    });
            });

            function updateProgress(value) {
                progressBar.style.width = value + '%';
                progressText.textContent = Math.round(value) + '%';
            }

            function resetImportForm() {
                importBtn.disabled = false;
                importBtn.innerHTML = '<i class="bi bi-upload me-2"></i>Import Data';
                progressContainer.style.display = 'none';
                progressBar.style.width = '0%';
                progressText.textContent = '0%';
            }

            // Reset form ketika modal ditutup
            const importModal = document.getElementById('importModal');
            if (importModal) {
                importModal.addEventListener('hidden.bs.modal', function() {
                    clearFile();
                    resetImportForm();
                });
            }
        }

        // Confirm delete
        function confirmDelete(url) {
            if (confirm('Yakin ingin menghapus arsip surat ini?')) {
                window.location.href = url;
            }
        }
    </script>
@endpush
