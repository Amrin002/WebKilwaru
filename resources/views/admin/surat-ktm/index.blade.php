{{-- Surat KTM Management --}}
@extends('layouts.main')

@push('style')
    <style>
        /* Surat KTM Management Styles - Consistent with Arsip Surat Theme */
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
        .ktm-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .ktm-stat-card {
            background: var(--warm-white);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .ktm-stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-orange), var(--primary-green));
        }

        .ktm-stat-card:hover {
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

        .stat-icon.diproses {
            background: linear-gradient(135deg, #6c757d, #8e9297);
        }

        .stat-icon.disetujui {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .stat-icon.ditolak {
            background: linear-gradient(135deg, #dc3545, #e74c3c);
        }

        .stat-icon.guest {
            background: linear-gradient(135deg, #ff8c42, #ffa726);
        }

        .stat-icon.registered {
            background: linear-gradient(135deg, #007bff, #0056b3);
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

        .badge-danger {
            background: linear-gradient(135deg, #dc3545, #e74c3c);
            color: white;
        }

        .badge-secondary {
            background: linear-gradient(135deg, #6c757d, #8e9297);
            color: white;
        }

        /* Status Badges */
        .status-badge {
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

        .status-badge.diproses {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
            border: 1px solid rgba(108, 117, 125, 0.3);
        }

        .status-badge.disetujui {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .status-badge.ditolak {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .status-badge i {
            font-size: 0.8rem;
        }

        /* Tipe Pemohon Badges */
        .tipe-badge {
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

        .tipe-badge.guest {
            background: rgba(255, 140, 66, 0.1);
            color: var(--accent-orange);
            border: 1px solid rgba(255, 140, 66, 0.3);
        }

        .tipe-badge.user {
            background: rgba(0, 123, 255, 0.1);
            color: #007bff;
            border: 1px solid rgba(0, 123, 255, 0.3);
        }

        .tipe-badge i {
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

        /* Bulk Actions */
        .bulk-actions {
            background: rgba(45, 80, 22, 0.05);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid rgba(45, 80, 22, 0.1);
            display: none;
        }

        .bulk-actions.show {
            display: block;
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

        /* Quick Status Update */
        .quick-status {
            display: inline-flex;
            gap: 5px;
        }

        .quick-status .btn {
            padding: 4px 8px;
            font-size: 0.7rem;
            border-radius: 6px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .ktm-stats {
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
            .ktm-stats {
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
                    <li class="breadcrumb-item">Administrasi</li>
                    <li class="breadcrumb-item active">Surat KTM</li>
                </ol>
            </nav>
            <h1 class="page-title">{{ $titleHeader ?? 'Surat Keterangan Tidak Mampu' }}</h1>
            <p class="page-subtitle">Kelola pengajuan surat keterangan tidak mampu dari warga dan guest</p>
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
        <div class="ktm-stats">
            <div class="ktm-stat-card">
                <div class="stat-icon total">
                    <i class="bi bi-file-text"></i>
                </div>
                <div class="stat-number">{{ number_format($statistik['total']) }}</div>
                <div class="stat-label">Total Surat</div>
            </div>
            <div class="ktm-stat-card">
                <div class="stat-icon diproses">
                    <i class="bi bi-clock"></i>
                </div>
                <div class="stat-number">{{ number_format($statistik['diproses']) }}</div>
                <div class="stat-label">Diproses</div>
            </div>
            <div class="ktm-stat-card">
                <div class="stat-icon disetujui">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-number">{{ number_format($statistik['disetujui']) }}</div>
                <div class="stat-label">Disetujui</div>
            </div>
            <div class="ktm-stat-card">
                <div class="stat-icon ditolak">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div class="stat-number">{{ number_format($statistik['ditolak']) }}</div>
                <div class="stat-label">Ditolak</div>
            </div>
            <div class="ktm-stat-card">
                <div class="stat-icon guest">
                    <i class="bi bi-person"></i>
                </div>
                <div class="stat-number">{{ number_format($statistik['guest']) }}</div>
                <div class="stat-label">Guest</div>
            </div>
            <div class="ktm-stat-card">
                <div class="stat-icon registered">
                    <i class="bi bi-person-check"></i>
                </div>
                <div class="stat-number">{{ number_format($statistik['user_terdaftar']) }}</div>
                <div class="stat-label">User Terdaftar</div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-header">
                <h4 class="filter-title">
                    <i class="bi bi-funnel me-2"></i>Filter & Pencarian
                </h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.surat-ktm.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Surat Baru
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-download me-2"></i>Export/Actions
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.surat-ktm.export', request()->query()) }}">
                                    <i class="bi bi-file-earmark-excel me-2"></i>Export Data
                                </a></li>
                            <li><a class="dropdown-item" href="#" onclick="toggleBulkActions()">
                                    <i class="bi bi-check-square me-2"></i>Bulk Actions
                                </a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            {{-- PERBAIKAN: Ganti route name yang salah --}}
                            <li><a class="dropdown-item" href="{{ route('admin.surat-ktm.api.statistik') }}">
                                    <i class="bi bi-graph-up me-2"></i>Statistik API
                                </a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Bulk Actions -->
            <div class="bulk-actions" id="bulkActions">
                <form action="{{ route('admin.surat-ktm.bulk-action') }}" method="POST" id="bulkForm">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label">Pilih Aksi</label>
                            <select class="form-select" name="action" required>
                                <option value="">Pilih Aksi</option>
                                <option value="approve">Setujui</option>
                                <option value="reject">Tolak</option>
                                <option value="delete">Hapus</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Keterangan (Opsional)</label>
                            <input type="text" class="form-control" name="keterangan"
                                placeholder="Keterangan untuk aksi ini...">
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success" disabled id="bulkSubmit">
                                    <i class="bi bi-check-lg me-2"></i>Jalankan
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="toggleBulkActions()">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <form method="GET" action="{{ route('admin.surat-ktm.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Cari Nama, NIK, atau Nomor Telepon</label>
                    <input type="text" class="form-control" name="search" value="{{ $filters['search'] ?? '' }}"
                        placeholder="Cari nama, NIK, atau nomor telepon...">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="">Semua Status</option>
                        <option value="diproses" {{ ($filters['status'] ?? '') == 'diproses' ? 'selected' : '' }}>
                            Diproses
                        </option>
                        <option value="disetujui" {{ ($filters['status'] ?? '') == 'disetujui' ? 'selected' : '' }}>
                            Disetujui
                        </option>
                        <option value="ditolak" {{ ($filters['status'] ?? '') == 'ditolak' ? 'selected' : '' }}>
                            Ditolak
                        </option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tipe Pemohon</label>
                    <select class="form-select" name="tipe_pemohon">
                        <option value="">Semua Tipe</option>
                        <option value="guest" {{ ($filters['tipe_pemohon'] ?? '') == 'guest' ? 'selected' : '' }}>
                            Guest
                        </option>
                        <option value="user" {{ ($filters['tipe_pemohon'] ?? '') == 'user' ? 'selected' : '' }}>
                            User Terdaftar
                        </option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tahun</label>
                    <select class="form-select" name="tahun">
                        <option value="">Semua Tahun</option>
                        @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                            <option value="{{ $i }}" {{ ($filters['tahun'] ?? '') == $i ? 'selected' : '' }}>
                                {{ $i }}
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
                        <a href="{{ route('admin.surat-ktm.index') }}" class="btn btn-outline-primary">
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
                    <i class="bi bi-file-text me-2"></i>Daftar Surat KTM
                </h4>
                <div class="text-muted">
                    Menampilkan {{ $surats->firstItem() ?? 0 }} - {{ $surats->lastItem() ?? 0 }} dari
                    {{ $surats->total() }} data
                </div>
            </div>

            @if ($surats->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" class="bulk-select-all" onchange="toggleAllCheckboxes(this)">
                                </th>
                                <th>No. Surat</th>
                                <th>Pemohon</th>
                                <th>Tipe</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($surats as $surat)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="surat-checkbox" name="surat_ids[]"
                                            value="{{ $surat->id }}" onchange="updateBulkActions()">
                                    </td>
                                    <td>
                                        @if ($surat->nomor_surat)
                                            <span class="badge badge-primary">{{ $surat->nomor_surat }}</span>
                                        @else
                                            <span class="text-muted">Belum ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $surat->nama }}</strong>
                                            @if ($surat->user)
                                                <br><small class="text-muted">{{ $surat->user->email }}</small>
                                            @elseif ($surat->nomor_telepon)
                                                <br><small class="text-muted">{{ $surat->nomor_telepon }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="tipe-badge {{ $surat->user_id ? 'user' : 'guest' }}">
                                            @if ($surat->user_id)
                                                <i class="bi bi-person-check"></i>
                                                User
                                            @else
                                                <i class="bi bi-person"></i>
                                                Guest
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $surat->status }}">
                                            @if ($surat->status == 'diproses')
                                                <i class="bi bi-clock"></i>
                                                Diproses
                                            @elseif($surat->status == 'disetujui')
                                                <i class="bi bi-check-circle"></i>
                                                Disetujui
                                            @elseif($surat->status == 'ditolak')
                                                <i class="bi bi-x-circle"></i>
                                                Ditolak
                                            @endif
                                        </span>
                                        @if ($surat->status == 'diproses')
                                            <div class="quick-status mt-1">
                                                <button type="button" class="btn btn-success btn-sm"
                                                    onclick="updateStatus({{ $surat->id }}, 'disetujui')"
                                                    title="Setujui">
                                                    <i class="bi bi-check"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="updateStatus({{ $surat->id }}, 'ditolak')"
                                                    title="Tolak">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            {{ $surat->created_at->format('d/m/Y') }}
                                            <br><small class="text-muted">{{ $surat->created_at->format('H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($surat->keterangan)
                                            <div style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                                title="{{ $surat->keterangan }}">
                                                {{ $surat->keterangan }}
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.surat-ktm.show', $surat->id) }}"
                                                class="btn btn-sm btn-outline-primary" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.surat-ktm.edit', $surat->id) }}"
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            @if ($surat->status == 'disetujui' && $surat->nomor_surat)
                                                <a href="{{ route('admin.surat-ktm.download', $surat->id) }}"
                                                    class="btn btn-sm btn-success" title="Download" target="_blank">
                                                    <i class="bi bi-download"></i>
                                                </a>
                                            @endif
                                            <form action="{{ route('admin.surat-ktm.destroy', $surat->id) }}"
                                                method="POST" style="display: inline-block;"
                                                onsubmit="return confirm('Yakin ingin menghapus surat ini?')">
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
                        Menampilkan {{ $surats->firstItem() }} - {{ $surats->lastItem() }} dari
                        {{ $surats->total() }} data
                    </div>
                    {{ $surats->appends(request()->query())->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-file-text"></i>
                    <h5>Tidak ada surat KTM</h5>
                    <p class="mb-3">Belum ada pengajuan surat keterangan tidak mampu</p>
                    <a href="{{ route('admin.surat-ktm.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Surat Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Update Status Modal -->
    <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStatusModalLabel">
                        <i class="bi bi-arrow-repeat me-2"></i>Update Status Surat
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateStatusForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="statusSuratId" name="surat_id">
                        <input type="hidden" id="statusValue" name="status">

                        <div class="mb-3">
                            <label class="form-label">Status Baru</label>
                            <div class="alert alert-info" id="statusInfo">
                                <!-- Status info will be populated by JavaScript -->
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="statusKeterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="statusKeterangan" name="keterangan" rows="3"
                                placeholder="Berikan keterangan untuk perubahan status ini..."></textarea>
                        </div>

                        <div class="mb-3" id="nomorSuratSection" style="display: none;">
                            <label for="statusNomorSurat" class="form-label">Nomor Surat</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="statusNomorSurat" name="nomor_surat"
                                    placeholder="Nomor surat akan di-generate otomatis">
                                {{-- <button type="button" class="btn btn-outline-primary" onclick="generateNomorSurat()">
                                    <i class="bi bi-gear"></i> Generate
                                </button> --}}
                            </div>
                            <small class="text-muted">Kosongkan untuk generate otomatis</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Perbaikan JavaScript untuk Modal Status Update Surat KTM

        // Pastikan DOM sudah siap
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });

            // Initialize modal
            const updateStatusModal = document.getElementById('updateStatusModal');
            if (updateStatusModal) {
                updateStatusModal.addEventListener('hidden.bs.modal', function() {
                    resetModalForm();
                });
            }
        });

        // Quick Status Update Functions - DIPERBAIKI
        function updateStatus(suratId, status) {
            console.log('Update Status Called:', {
                suratId,
                status
            }); // Debug log

            const statusInfo = document.getElementById('statusInfo');
            const nomorSuratSection = document.getElementById('nomorSuratSection');
            const statusKeterangan = document.getElementById('statusKeterangan');
            const modal = document.getElementById('updateStatusModal');

            if (!statusInfo || !nomorSuratSection || !statusKeterangan || !modal) {
                console.error('Modal elements not found!');
                return;
            }

            // Set form values
            document.getElementById('statusSuratId').value = suratId;
            document.getElementById('statusValue').value = status;

            // Update status info berdasarkan status
            if (status === 'disetujui') {
                statusInfo.innerHTML =
                    '<i class="bi bi-check-circle text-success me-2"></i>Surat akan <strong>DISETUJUI</strong>';
                statusInfo.className = 'alert alert-success';
                nomorSuratSection.style.display = 'block';
                statusKeterangan.placeholder = 'Keterangan persetujuan (opsional)...';
                statusKeterangan.removeAttribute('required');
            } else if (status === 'ditolak') {
                statusInfo.innerHTML = '<i class="bi bi-x-circle text-danger me-2"></i>Surat akan <strong>DITOLAK</strong>';
                statusInfo.className = 'alert alert-danger';
                nomorSuratSection.style.display = 'none';
                statusKeterangan.placeholder = 'Alasan penolakan (wajib diisi)...';
                statusKeterangan.setAttribute('required', 'required');
            }

            // Show modal menggunakan Bootstrap 5
            const modalInstance = new bootstrap.Modal(modal);
            modalInstance.show();
        }


        // Status update form submission - DIPERBAIKI
        document.addEventListener('DOMContentLoaded', function() {
            const updateStatusForm = document.getElementById('updateStatusForm');
            if (updateStatusForm) {
                updateStatusForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const suratId = formData.get('surat_id');
                    const status = formData.get('status');
                    const keterangan = formData.get('keterangan');
                    let nomorSurat = formData.get('nomor_surat');

                    // Validasi form
                    if (!suratId || !status) {
                        alert('Data surat atau status tidak valid!');
                        return;
                    }

                    // Validasi keterangan untuk status ditolak
                    if (status === 'ditolak' && (!keterangan || keterangan.trim() === '')) {
                        alert('Keterangan wajib diisi untuk penolakan surat!');
                        document.getElementById('statusKeterangan').focus();
                        return;
                    }


                    // Disable submit button dan tampilkan loading
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.disabled = true;
                    submitBtn.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';

                    // Prepare request data
                    const requestData = {
                        status: status,
                        keterangan: keterangan,
                        _token: document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                            'content') || '{{ csrf_token() }}'
                    };

                    // Tambahkan nomor surat jika status disetujui
                    if (status === 'disetujui' && nomorSurat) {
                        requestData.nomor_surat = nomorSurat;
                    }

                    console.log('Sending request data:', requestData);

                    // Send AJAX request
                    fetch(`/admin/surat-ktm/${suratId}/update-status`, {
                            method: 'PATCH',
                            body: JSON.stringify(requestData),
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': requestData._token
                            }
                        })
                        .then(response => {
                            console.log('Response status:', response.status);
                            if (!response.ok) {
                                return response.json().then(err => Promise.reject(err));
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Response data:', data);

                            if (data.success) {
                                // Close modal
                                const modal = bootstrap.Modal.getInstance(document.getElementById(
                                    'updateStatusModal'));
                                modal.hide();

                                // Show success message
                                showAlert('success', data.message || 'Status berhasil diupdate');

                                // Reload page setelah delay
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1500);
                            } else {
                                throw new Error(data.message || 'Gagal update status');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);

                            // Handle specific errors
                            let errorMessage = 'Terjadi kesalahan saat update status';

                            if (error.message && error.message.includes('Duplicate entry')) {
                                errorMessage =
                                    'Nomor surat sudah digunakan. Silakan generate nomor baru.';
                                // Re-generate nomor surat
                                generateNomorSurat();
                            } else if (error.message) {
                                errorMessage = error.message;
                            } else if (error.errors) {
                                // Handle validation errors
                                errorMessage = Object.values(error.errors).flat().join(', ');
                            }

                            showAlert('danger', errorMessage);

                            // Re-enable button
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        });
                });
            }
        });

        // Function untuk reset modal form
        function resetModalForm() {
            const form = document.getElementById('updateStatusForm');
            if (form) {
                form.reset();
            }

            const statusKeterangan = document.getElementById('statusKeterangan');
            if (statusKeterangan) {
                statusKeterangan.removeAttribute('required');
                statusKeterangan.placeholder = '';
            }

            const nomorSuratSection = document.getElementById('nomorSuratSection');
            if (nomorSuratSection) {
                nomorSuratSection.style.display = 'none';
            }
        }

        // Function untuk menampilkan alert
        function showAlert(type, message) {
            const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;

            const dashboardContent = document.querySelector('.dashboard-content');
            if (dashboardContent) {
                dashboardContent.insertAdjacentHTML('afterbegin', alertHtml);

                // Auto hide alert setelah 5 detik
                setTimeout(() => {
                    const alert = dashboardContent.querySelector('.alert');
                    if (alert) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                }, 5000);
            }
        }

        // Bulk Actions Functions
        function toggleBulkActions() {
            const bulkActions = document.getElementById('bulkActions');
            if (bulkActions) {
                bulkActions.classList.toggle('show');

                if (!bulkActions.classList.contains('show')) {
                    // Clear all checkboxes when hiding
                    document.querySelectorAll('.surat-checkbox').forEach(checkbox => {
                        checkbox.checked = false;
                    });
                    const bulkSelectAll = document.querySelector('.bulk-select-all');
                    if (bulkSelectAll) {
                        bulkSelectAll.checked = false;
                    }
                    updateBulkActions();
                }
            }
        }

        function toggleAllCheckboxes(mainCheckbox) {
            const checkboxes = document.querySelectorAll('.surat-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = mainCheckbox.checked;
            });
            updateBulkActions();
        }

        function updateBulkActions() {
            const checkedBoxes = document.querySelectorAll('.surat-checkbox:checked');
            const bulkSubmit = document.getElementById('bulkSubmit');
            const bulkForm = document.getElementById('bulkForm');

            if (bulkSubmit) {
                bulkSubmit.disabled = checkedBoxes.length === 0;
            }

            if (bulkForm) {
                // Remove existing hidden inputs
                const existingInputs = bulkForm.querySelectorAll('input[name="surat_ids[]"]');
                existingInputs.forEach(input => input.remove());

                // Add selected IDs to form
                checkedBoxes.forEach(checkbox => {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'surat_ids[]';
                    hiddenInput.value = checkbox.value;
                    bulkForm.appendChild(hiddenInput);
                });
            }

            // Update main checkbox state
            const mainCheckbox = document.querySelector('.bulk-select-all');
            const allCheckboxes = document.querySelectorAll('.surat-checkbox');
            if (mainCheckbox && allCheckboxes.length > 0) {
                mainCheckbox.checked = checkedBoxes.length === allCheckboxes.length;
                mainCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < allCheckboxes.length;
            }
        }

        // Bulk form submission handler
        document.addEventListener('DOMContentLoaded', function() {
            const bulkForm = document.getElementById('bulkForm');
            if (bulkForm) {
                bulkForm.addEventListener('submit', function(e) {
                    const checkedBoxes = document.querySelectorAll('.surat-checkbox:checked');
                    const action = this.querySelector('[name="action"]').value;

                    if (checkedBoxes.length === 0) {
                        e.preventDefault();
                        alert('Pilih minimal satu surat untuk diproses!');
                        return;
                    }

                    const actionText = {
                        'approve': 'menyetujui',
                        'reject': 'menolak',
                        'delete': 'menghapus'
                    };

                    if (!confirm(
                            `Yakin ingin ${actionText[action]} ${checkedBoxes.length} surat yang dipilih?`
                        )) {
                        e.preventDefault();
                    }
                });
            }
        });

        // Confirm delete function
        function confirmDelete(url) {
            if (confirm('Yakin ingin menghapus surat ini? Data yang sudah dihapus tidak dapat dikembalikan.')) {
                window.location.href = url;
            }
        }

        // Auto-refresh statistics every 30 seconds - PERBAIKAN ROUTE
        setInterval(function() {
            if (document.visibilityState === 'visible') {
                // Only refresh if page is visible and API route exists
                const currentUrl = window.location.pathname;
                if (currentUrl.includes('surat-ktm')) {
                    fetch('/admin/surat-ktm/api/statistik')
                        .then(response => response.json())
                        .then(data => {
                            // Update statistics cards safely
                            updateStatCard('.stat-icon.total + .stat-number', data.status?.total || 0);
                            updateStatCard('.stat-icon.diproses + .stat-number', data.status?.diproses || 0);
                            updateStatCard('.stat-icon.disetujui + .stat-number', data.status?.disetujui || 0);
                            updateStatCard('.stat-icon.ditolak + .stat-number', data.status?.ditolak || 0);
                            updateStatCard('.stat-icon.guest + .stat-number', data.tipe_pemohon?.guest || 0);
                            updateStatCard('.stat-icon.registered + .stat-number', data.tipe_pemohon?.user ||
                                0);
                        })
                        .catch(error => {
                            console.log('Failed to update statistics:', error);
                        });
                }
            }
        }, 30000);

        // Helper function untuk update stat cards
        function updateStatCard(selector, value) {
            const element = document.querySelector(selector);
            if (element) {
                element.textContent = new Intl.NumberFormat().format(value);
            }
        }
    </script>
@endpush
