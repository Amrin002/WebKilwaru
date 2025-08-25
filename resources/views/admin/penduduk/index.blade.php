@extends('layouts.main')

@push('style')
    <style>
        /* Penduduk Management Styles */
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
        .penduduk-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .penduduk-stat-card {
            background: var(--warm-white);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .penduduk-stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-orange), var(--primary-green));
        }

        .penduduk-stat-card:hover {
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

        .stat-icon.male {
            background: linear-gradient(135deg, #2196F3, #64B5F6);
        }

        .stat-icon.female {
            background: linear-gradient(135deg, #E91E63, #F8BBD9);
        }

        .stat-icon.children {
            background: linear-gradient(135deg, #FF9800, #FFB74D);
        }

        .stat-icon.adult {
            background: linear-gradient(135deg, #4CAF50, #81C784);
        }

        .stat-icon.elderly {
            background: linear-gradient(135deg, #9C27B0, #CE93D8);
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

        .badge-info {
            background: linear-gradient(135deg, #17a2b8, #20c997);
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

        /* Gender and Age Badges */
        .gender-male {
            background: linear-gradient(135deg, #2196F3, #64B5F6);
            color: white;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .gender-female {
            background: linear-gradient(135deg, #E91E63, #F8BBD9);
            color: white;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .age-badge {
            background: linear-gradient(135deg, var(--soft-gray), #8e9297);
            color: white;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-left: 5px;
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
            background: rgba(255, 140, 66, 0.1);
            border: 1px solid rgba(255, 140, 66, 0.3);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            display: none;
        }

        .bulk-actions.show {
            display: block;
        }

        .bulk-actions-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .selected-count {
            font-weight: 600;
            color: var(--accent-orange);
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

        /* Sorting Indicators */
        .sortable {
            cursor: pointer;
            position: relative;
            user-select: none;
        }

        .sortable:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .sortable::after {
            content: '⇅';
            position: absolute;
            right: 8px;
            opacity: 0.5;
            font-size: 0.8rem;
        }

        .sortable.asc::after {
            content: '↑';
            opacity: 1;
            color: var(--accent-orange);
        }

        .sortable.desc::after {
            content: '↓';
            opacity: 1;
            color: var(--accent-orange);
        }

        /* import style */
        /* Import Modal Specific Styles - sama seperti KK */
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

        .file-info {
            display: none;
            margin-top: 15px;
            padding: 10px;
            background: rgba(40, 167, 69, 0.1);
            border-radius: 8px;
            border-left: 4px solid #28a745;
        }

        .progress-container {
            display: none;
            margin-top: 20px;
        }

        .import-progress {
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }

        .import-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-green), var(--secondary-green));
            width: 0%;
            transition: width 0.3s ease;
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

        .import-tips {
            background: rgba(32, 201, 151, 0.1);
            border: 1px solid rgba(32, 201, 151, 0.3);
            border-radius: 10px;
            padding: 15px;
            margin-top: 15px;
        }

        .import-tips h6 {
            color: #20c997;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .import-tips ul {
            margin-bottom: 0;
            padding-left: 20px;
        }

        .import-tips li {
            margin-bottom: 5px;
            color: var(--soft-gray);
            font-size: 0.9rem;
        }

        /* Import errors display */
        .import-errors {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            border-radius: 10px;
            padding: 15px;
            margin-top: 15px;
            display: none;
        }

        .import-errors.show {
            display: block;
        }

        .import-errors h6 {
            color: #dc3545;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .error-list {
            max-height: 200px;
            overflow-y: auto;
        }

        .error-item {
            background: white;
            border-radius: 6px;
            padding: 8px 12px;
            margin-bottom: 8px;
            border-left: 3px solid #dc3545;
        }


        /* Responsive */
        @media (max-width: 768px) {
            .penduduk-stats {
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
        }

        @media (max-width: 576px) {
            .penduduk-stats {
                grid-template-columns: 1fr;
            }

            .table-header {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }

            .bulk-actions-header {
                flex-direction: column;
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
                    <li class="breadcrumb-item">Data Penduduk</li>
                    <li class="breadcrumb-item active">Data Penduduk</li>
                </ol>
            </nav>
            <h1 class="page-title">Data Penduduk</h1>
            <p class="page-subtitle">Kelola dan pantau data penduduk di sistem administrasi desa</p>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('import_gagal') && count(session('import_gagal')) > 0)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Data yang gagal diimport:</strong>
                <ul class="mb-0 mt-2">
                    @foreach (session('import_gagal') as $gagal)
                        <li>
                            NIK: {{ $gagal['nik'] ?? '-' }} -
                            Nama: {{ $gagal['nama_lengkap'] ?? '-' }} -
                            Alasan: {{ $gagal['alasan'] }}
                        </li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Statistics -->
        <div class="penduduk-stats">
            <div class="penduduk-stat-card">
                <div class="stat-icon total">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">{{ number_format($penduduk->total()) }}</div>
                <div class="stat-label">Total Penduduk</div>
            </div>
            <div class="penduduk-stat-card">
                <div class="stat-icon male">
                    <i class="fas fa-male"></i>
                </div>
                <div class="stat-number">{{ number_format($penduduk->where('jenis_kelamin', 'Laki-laki')->count()) }}</div>
                <div class="stat-label">Laki-laki</div>
            </div>
            <div class="penduduk-stat-card">
                <div class="stat-icon female">
                    <i class="fas fa-female"></i>
                </div>
                <div class="stat-number">{{ number_format($penduduk->where('jenis_kelamin', 'Perempuan')->count()) }}</div>
                <div class="stat-label">Perempuan</div>
            </div>
            <div class="penduduk-stat-card">
                <div class="stat-icon children">
                    <i class="fas fa-child"></i>
                </div>
                <div class="stat-number">
                    {{ number_format($penduduk->filter(function ($p) {return \Carbon\Carbon::parse($p->tanggal_lahir)->age < 15;})->count()) }}
                </div>
                <div class="stat-label">Anak-anak</div>
            </div>
            <div class="penduduk-stat-card">
                <div class="stat-icon adult">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="stat-number">
                    {{ number_format($penduduk->filter(function ($p) {$age = \Carbon\Carbon::parse($p->tanggal_lahir)->age;return $age >= 15 && $age < 65;})->count()) }}
                </div>
                <div class="stat-label">Usia Produktif</div>
            </div>
            <div class="penduduk-stat-card">
                <div class="stat-icon elderly">
                    <i class="fas fa-walking-cane"></i>
                </div>
                <div class="stat-number">
                    {{ number_format($penduduk->filter(function ($p) {return \Carbon\Carbon::parse($p->tanggal_lahir)->age >= 65;})->count()) }}
                </div>
                <div class="stat-label">Lansia</div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-header">
                <h4 class="filter-title">
                    <i class="fas fa-filter me-2"></i>Filter & Pencarian
                </h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.penduduk.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Penduduk
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-download me-2"></i>Export/Print
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.penduduk.export', request()->query()) }}">
                                    <i class="fas fa-file-excel me-2"></i>Export Excel
                                </a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.penduduk.print', request()->query()) }}"
                                    target="_blank">
                                    <i class="fas fa-print me-2"></i>Print Data
                                </a></li>
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#importModal">
                                    <i class="bi bi-upload me-2"></i>Import Excel
                                </a>
                            </li>
                        </ul>
                    </div>
                    <button class="btn btn-outline-primary" onclick="toggleBulkActions()">
                        <i class="fas fa-check-square me-2"></i>Pilih Multiple
                    </button>
                </div>
            </div>

            <form method="GET" action="{{ route('admin.penduduk.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Cari NIK/Nama/No. KK</label>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                        placeholder="Cari admin.penduduk...">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Jenis Kelamin</label>
                    <select class="form-select" name="jenis_kelamin">
                        <option value="all">Semua</option>
                        <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                            Laki-laki</option>
                        <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                            Perempuan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Agama</label>
                    <select class="form-select" name="agama">
                        <option value="all">Semua Agama</option>
                        @foreach ($agamaList as $agama)
                            <option value="{{ $agama }}" {{ request('agama') == $agama ? 'selected' : '' }}>
                                {{ $agama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status Keluarga</label>
                    <select class="form-select" name="status_keluarga">
                        <option value="all">Semua Status</option>
                        @foreach ($statusKeluargaList as $status)
                            <option value="{{ $status }}"
                                {{ request('status_keluarga') == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <label class="form-label">Urutkan</label>
                    <select class="form-select" name="sort_by">
                        <option value="nama_lengkap" {{ request('sort_by') == 'nama_lengkap' ? 'selected' : '' }}>Nama
                        </option>
                        <option value="tanggal_lahir" {{ request('sort_by') == 'tanggal_lahir' ? 'selected' : '' }}>Umur
                        </option>
                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Terbaru
                        </option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('admin.penduduk.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Bulk Actions -->
        <div class="bulk-actions" id="bulkActions">
            <div class="bulk-actions-header">
                <div>
                    <span class="selected-count" id="selectedCount">0</span> data terpilih
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-danger btn-sm" onclick="bulkDelete()">
                        <i class="fas fa-trash me-1"></i>Hapus Terpilih
                    </button>
                    <button class="btn btn-outline-primary btn-sm" onclick="toggleBulkActions()">
                        <i class="fas fa-times"></i>Batal
                    </button>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="data-table-container">
            <div class="table-header">
                <h4 class="table-title">
                    <i class="fas fa-table me-2"></i>Daftar Penduduk
                </h4>
                <div class="text-muted">
                    Menampilkan {{ $penduduk->firstItem() ?? 0 }} - {{ $penduduk->lastItem() ?? 0 }} dari
                    {{ $penduduk->total() }} data
                </div>
            </div>

            @if ($penduduk->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="selectAll" class="form-check-input"
                                        style="display: none;">
                                    <span id="selectAllLabel">NIK</span>
                                </th>
                                <th class="sortable" data-sort="nama_lengkap">Nama Lengkap</th>
                                <th>TTL</th>
                                <th>Jenis Kelamin</th>
                                <th>Agama</th>
                                <th>Status Keluarga</th>
                                <th>Pekerjaan</th>
                                <th>No. KK</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penduduk as $person)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input row-checkbox"
                                            value="{{ $person->nik }}" style="display: none;">
                                        <span class="badge badge-primary">{{ $person->nik }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $person->nama_lengkap }}</strong>
                                        <div class="text-muted small">{{ $person->pendidikan }}</div>
                                    </td>
                                    <td>
                                        {{ $person->tempat_lahir }},
                                        {{ \Carbon\Carbon::parse($person->tanggal_lahir)->format('d/m/Y') }}
                                        <span class="age-badge">{{ \Carbon\Carbon::parse($person->tanggal_lahir)->age }}
                                            thn</span>
                                    </td>
                                    <td>
                                        <span
                                            class="{{ $person->jenis_kelamin == 'Laki-laki' ? 'gender-male' : 'gender-female' }}">
                                            <i
                                                class="fas fa-{{ $person->jenis_kelamin == 'Laki-laki' ? 'male' : 'female' }} me-1"></i>
                                            {{ $person->jenis_kelamin }}
                                        </span>
                                    </td>
                                    <td>{{ $person->agama }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $person->status_keluarga == 'Kepala Keluarga' ? 'badge-warning' : 'badge-info' }}">
                                            {{ $person->status_keluarga }}
                                        </span>
                                    </td>
                                    <td>{{ $person->pekerjaan }}</td>
                                    <td>
                                        <a href="{{ route('admin.kk.show', $person->no_kk) }}"
                                            class="badge badge-success" title="Lihat KK">
                                            {{ $person->no_kk }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.penduduk.show', $person->nik) }}"
                                                class="btn btn-sm btn-outline-primary" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.penduduk.edit', $person->nik) }}"
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.penduduk.destroy', $person->nik) }}"
                                                method="POST" style="display: inline-block;"
                                                onsubmit="return confirm('Yakin ingin menghapus data penduduk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
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
                        Menampilkan {{ $penduduk->firstItem() }} - {{ $penduduk->lastItem() }} dari
                        {{ $penduduk->total() }} data
                    </div>
                    {{ $penduduk->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <h5>Tidak ada data penduduk</h5>
                    <p class="mb-3">Belum ada data penduduk yang tersedia dengan kriteria pencarian</p>
                    <a href="{{ route('admin.penduduk.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Penduduk Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Bulk Delete Modal -->
    <div class="modal fade" id="bulkDeleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus <strong><span id="deleteCount"></span></strong> data penduduk yang
                        dipilih?</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian:</strong> Tindakan ini tidak dapat dibatalkan!
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('admin.penduduk.bulk-action') }}" method="POST" id="bulkDeleteForm">
                        @csrf
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="selected_ids" id="selectedIds">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Hapus Data
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">
                        <i class="bi bi-upload me-2"></i>Import Data Penduduk
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Step 1: Download Template -->
                    <div class="import-step">
                        <h6><i class="bi bi-1-circle me-2"></i>Download Template Excel</h6>
                        <p class="mb-2">Download template Excel terlebih dahulu untuk memastikan format data yang benar.
                        </p>
                        <div class="template-download">
                            <i class="bi bi-file-earmark-excel" style="font-size: 2rem; color: #28a745;"></i>
                            <div class="mt-2">
                                <a href="{{ route('admin.penduduk.template') }}" class="btn-template">
                                    <i class="bi bi-download"></i>
                                    Download Template Excel
                                </a>
                            </div>
                            <small class="text-muted mt-2 d-block">
                                Template berisi format dan contoh data yang benar
                            </small>
                        </div>
                    </div>

                    <!-- Step 2: Prepare Data -->
                    <div class="import-step">
                        <h6><i class="bi bi-2-circle me-2"></i>Siapkan Data Excel</h6>
                        <p class="mb-2">Isi template Excel dengan data penduduk yang akan diimport.</p>
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Format kolom yang diperlukan:</strong><br>
                            <code>nik | no_kk | nama_lengkap | tempat_lahir | tanggal_lahir | jenis_kelamin | agama |
                                pendidikan | pekerjaan | status | status_keluarga | golongan_darah | kewarganegaraan |
                                nama_ayah | nama_ibu</code>
                        </div>
                        <div class="alert alert-warning mt-2">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Penting:</strong> Pastikan No. KK sudah terdaftar di sistem sebelum import data
                            penduduk!
                        </div>
                    </div>

                    <!-- Step 3: Upload File -->
                    <div class="import-step">
                        <h6><i class="bi bi-3-circle me-2"></i>Upload File Excel</h6>
                        <form action="{{ route('admin.penduduk.import') }}" method="POST" enctype="multipart/form-data"
                            id="importForm">
                            @csrf

                            <!-- File Drop Zone -->
                            <div class="file-drop-zone" id="fileDropZone">
                                <i class="bi bi-cloud-upload" style="font-size: 3rem; color: #6c757d;"></i>
                                <h6 class="mt-3 mb-2">Drag & Drop file Excel di sini</h6>
                                <p class="text-muted mb-3">atau klik untuk memilih file</p>
                                <input type="file" class="d-none" name="file" id="fileInput" accept=".xlsx,.xls"
                                    required>
                                <button type="button" class="btn btn-outline-primary"
                                    onclick="document.getElementById('fileInput').click()">
                                    <i class="bi bi-folder2-open me-2"></i>Pilih File
                                </button>
                            </div>

                            <!-- File Info -->
                            <div class="file-info" id="fileInfo">
                                <i class="bi bi-file-earmark-excel text-success me-2"></i>
                                <span id="fileName"></span>
                                <span class="badge bg-success ms-2" id="fileSize"></span>
                                <button type="button" class="btn btn-sm btn-outline-danger ms-2" onclick="clearFile()">
                                    <i class="bi bi-x"></i>
                                </button>
                            </div>

                            <!-- Progress Container -->
                            <div class="progress-container" id="progressContainer">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Importing data...</small>
                                    <small class="text-muted" id="progressText">0%</small>
                                </div>
                                <div class="import-progress">
                                    <div class="import-progress-bar" id="progressBar"></div>
                                </div>
                            </div>

                            <!-- Import Errors Display -->
                            <div class="import-errors" id="importErrors">
                                <h6><i class="bi bi-exclamation-triangle me-2"></i>Data yang Gagal Import</h6>
                                <div class="error-list" id="errorList"></div>
                            </div>
                        </form>
                    </div>

                    <!-- Import Tips -->
                    <div class="import-tips">
                        <h6><i class="bi bi-lightbulb me-2"></i>Tips Import Data Penduduk</h6>
                        <ul>
                            <li><strong>NIK harus 16 digit</strong> dan belum terdaftar dalam sistem</li>
                            <li><strong>No. KK harus sudah terdaftar</strong> di sistem terlebih dahulu</li>
                            <li><strong>Format tanggal:</strong> DD/MM/YYYY (contoh: 01/01/1990)</li>
                            <li><strong>Jenis kelamin:</strong> "Laki-laki" atau "Perempuan"</li>
                            <li><strong>Status keluarga:</strong> "Kepala Keluarga", "Istri", "Anak", atau "Lainnya"</li>
                            <li>Awali NIK dan No. KK dengan tanda petik (') untuk menghindari format scientific notation
                            </li>
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
@endsection

@push('script')
    <script>
        let bulkMode = false;
        let selectedItems = [];

        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });

            // Initialize sorting
            initSorting();

            // import function
            // Import Modal functionality
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
            const importErrors = document.getElementById('importErrors');
            const errorList = document.getElementById('errorList');
        });

        // Toggle bulk actions mode
        function toggleBulkActions() {
            bulkMode = !bulkMode;
            const checkboxes = document.querySelectorAll('.row-checkbox, #selectAll');
            const selectAllLabel = document.getElementById('selectAllLabel');
            const bulkActions = document.getElementById('bulkActions');

            if (bulkMode) {
                checkboxes.forEach(cb => cb.style.display = 'inline-block');
                selectAllLabel.textContent = '';
                bulkActions.classList.add('show');
            } else {
                checkboxes.forEach(cb => {
                    cb.style.display = 'none';
                    cb.checked = false;
                });
                selectAllLabel.textContent = 'NIK';
                bulkActions.classList.remove('show');
                selectedItems = [];
                updateSelectedCount();
            }
        }

        // Handle select all checkbox
        document.getElementById('selectAll').addEventListener('change', function() {
            const rowCheckboxes = document.querySelectorAll('.row-checkbox');
            const isChecked = this.checked;

            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
                const value = checkbox.value;

                if (isChecked && !selectedItems.includes(value)) {
                    selectedItems.push(value);
                } else if (!isChecked && selectedItems.includes(value)) {
                    selectedItems = selectedItems.filter(item => item !== value);
                }
            });

            updateSelectedCount();
        });

        // Handle individual row checkboxes
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('row-checkbox')) {
                const value = e.target.value;

                if (e.target.checked) {
                    if (!selectedItems.includes(value)) {
                        selectedItems.push(value);
                    }
                } else {
                    selectedItems = selectedItems.filter(item => item !== value);
                    document.getElementById('selectAll').checked = false;
                }

                updateSelectedCount();

                // Check if all are selected
                const totalCheckboxes = document.querySelectorAll('.row-checkbox').length;
                if (selectedItems.length === totalCheckboxes) {
                    document.getElementById('selectAll').checked = true;
                }
            }
        });

        // Update selected count display
        function updateSelectedCount() {
            document.getElementById('selectedCount').textContent = selectedItems.length;
        }

        // Bulk delete function
        function bulkDelete() {
            if (selectedItems.length === 0) {
                alert('Pilih minimal satu data untuk dihapus');
                return;
            }

            document.getElementById('deleteCount').textContent = selectedItems.length;
            document.getElementById('selectedIds').value = JSON.stringify(selectedItems);

            const modal = new bootstrap.Modal(document.getElementById('bulkDeleteModal'));
            modal.show();
        }

        // Sorting functionality
        function initSorting() {
            const sortableHeaders = document.querySelectorAll('.sortable');
            const currentSort = '{{ request('sort_by', 'nama_lengkap') }}';
            const currentOrder = '{{ request('sort_order', 'asc') }}';

            // Set initial sort indicator
            sortableHeaders.forEach(header => {
                if (header.dataset.sort === currentSort) {
                    header.classList.add(currentOrder);
                }
            });

            sortableHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const sortBy = this.dataset.sort;
                    let sortOrder = 'asc';

                    // Toggle sort order if clicking the same column
                    if (this.classList.contains('asc')) {
                        sortOrder = 'desc';
                    } else if (this.classList.contains('desc')) {
                        sortOrder = 'asc';
                    }

                    // Build URL with current filters and new sort
                    const url = new URL(window.location);
                    url.searchParams.set('sort_by', sortBy);
                    url.searchParams.set('sort_order', sortOrder);

                    window.location.href = url.toString();
                });
            });
        }
        // Global function untuk clear file
        window.clearFile = function() {
            fileInput.value = '';
            fileDropZone.classList.remove('has-file');
            fileInfo.style.display = 'none';
            importBtn.disabled = true;
            importErrors.classList.remove('show');
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
                // Set file ke input
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
            const allowedTypes = [
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-excel',
                'text/csv',
                'application/csv'
            ];

            const fileExtension = file.name.split('.').pop().toLowerCase();
            if (!['xlsx', 'xls', 'csv'].includes(fileExtension)) {
                alert('Hanya file Excel (.xlsx, .xls) atau CSV yang diperbolehkan!');
                clearFile();
                return;
            }

            // Validate file size (max 10MB)
            if (file.size > 10 * 1024 * 1024) {
                alert('Ukuran file maksimal 10MB!');
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

        // Form submission dengan progress yang benar
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
            importErrors.classList.remove('show');
            errorList.innerHTML = '';

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
                        // Tampilkan data yang gagal jika ada
                        if (data.data && data.data.gagal && data.data.gagal.length > 0) {
                            showImportErrors(data.data.gagal);

                            // Tunggu sebentar sebelum reload agar user bisa lihat error
                            setTimeout(() => {
                                if (confirm(
                                        'Import selesai dengan beberapa data yang gagal. Lihat halaman untuk detail. Reload halaman?'
                                    )) {
                                    window.location.reload();
                                }
                            }, 2000);
                        } else {
                            // Tunggu sebentar untuk animasi selesai
                            setTimeout(() => {
                                alert(data.message || 'Import berhasil!');
                                window.location.reload();
                            }, 1000);
                        }
                    } else {
                        throw new Error(data.message || 'Import gagal!');
                    }
                })
                .catch(error => {
                    clearInterval(progressInterval);
                    console.error('Error:', error);
                    alert(error.message || 'Terjadi kesalahan saat import data!');

                    // Reset form
                    resetImportForm();
                });
        });

        function showImportErrors(errors) {
            if (errors && errors.length > 0) {
                importErrors.classList.add('show');
                errorList.innerHTML = '';

                errors.forEach(error => {
                    const errorItem = document.createElement('div');
                    errorItem.className = 'error-item';
                    errorItem.innerHTML = `
                            <strong>NIK: ${error.nik || '-'}</strong><br>
                            Nama: ${error.nama_lengkap || '-'}<br>
                            <span class="text-danger">Alasan: ${error.alasan}</span>
                        `;
                    errorList.appendChild(errorItem);
                });
            }
        }

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
                importErrors.classList.remove('show');
                errorList.innerHTML = '';
            });
        }

        // Age calculation helper (for client-side if needed)
        function calculateAge(birthDate) {
            const today = new Date();
            const birth = new Date(birthDate);
            let age = today.getFullYear() - birth.getFullYear();
            const monthDiff = today.getMonth() - birth.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
                age--;
            }

            return age;
        }

        // Print functionality
        function printData() {
            const url = '{{ route('admin.penduduk.print') }}?' + new URLSearchParams(window.location.search);
            window.open(url, '_blank');
        }

        // Export functionality
        function exportData() {
            const url = '{{ route('admin.penduduk.export') }}?' + new URLSearchParams(window.location.search);
            window.location.href = url;
        }

        // Advanced search toggle
        function toggleAdvancedSearch() {
            const advancedFilters = document.getElementById('advancedFilters');
            const toggleBtn = document.getElementById('advancedToggle');

            if (advancedFilters.style.display === 'none') {
                advancedFilters.style.display = 'block';
                toggleBtn.innerHTML = '<i class="fas fa-chevron-up me-1"></i>Sembunyikan Filter Lanjutan';
            } else {
                advancedFilters.style.display = 'none';
                toggleBtn.innerHTML = '<i class="fas fa-chevron-down me-1"></i>Filter Lanjutan';
            }
        }

        // Quick filter by gender
        function filterByGender(gender) {
            const url = new URL(window.location);
            url.searchParams.set('jenis_kelamin', gender);
            window.location.href = url.toString();
        }

        // Quick filter by age group
        function filterByAgeGroup(group) {
            const url = new URL(window.location);
            url.searchParams.set('age_group', group);
            window.location.href = url.toString();
        }

        // Reset all filters
        function resetFilters() {
            window.location.href = '{{ route('admin.penduduk.index') }}';
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl + N for new penduduk
            if (e.ctrlKey && e.key === 'n') {
                e.preventDefault();
                window.location.href = '{{ route('admin.penduduk.create') }}';
            }

            // Escape to cancel bulk mode
            if (e.key === 'Escape' && bulkMode) {
                toggleBulkActions();
            }
        });

        // Tooltip initialization for action buttons
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                placement: 'top'
            });
        });
    </script>
@endpush
