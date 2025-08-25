{{-- UMKM Management Admin Index View --}}
@extends('layouts.main')

@push('style')
    {{-- Menggunakan gaya dari admin berita karena strukturnya serupa --}}
    <style>
        /* Mengadaptasi style yang sudah ada untuk UMKM */
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
        .umkm-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .umkm-stat-card {
            background: var(--warm-white);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .umkm-stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-orange), var(--primary-green));
        }

        .umkm-stat-card:hover {
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

        .stat-icon.pending {
            background: linear-gradient(135deg, #ff8c42, #ffa726);
        }

        .stat-icon.approved {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .stat-icon.rejected {
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

        /* Tabs */
        .nav-tabs {
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
        }

        .nav-tabs .nav-link {
            border: 1px solid transparent;
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
            color: var(--soft-gray);
            font-weight: 600;
        }

        .nav-tabs .nav-link:hover,
        .nav-tabs .nav-link:focus {
            border-color: #e9ecef #e9ecef #dee2e6;
            isolation: isolate;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary-green);
            background-color: var(--warm-white);
            border-color: #dee2e6 #dee2e6 var(--warm-white);
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
            flex-wrap: wrap;
            gap: 15px;
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

        /* Button Styles */
        .btn {
            transition: all 0.3s ease;
            font-weight: 600;
            border-radius: 10px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border: none;
            color: white;
            padding: 8px 16px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45, 80, 22, 0.3);
        }

        .btn-outline-primary {
            color: var(--primary-green);
            border: 2px solid var(--primary-green);
            background: transparent;
            padding: 8px 16px;
        }

        .btn-outline-primary:hover {
            background: var(--primary-green);
            color: white;
            border-color: var(--primary-green);
            transform: translateY(-2px);
        }

        .btn-outline-secondary {
            color: #6c757d;
            border: 1px solid #6c757d;
            background: transparent;
            padding: 6px 12px;
        }

        .btn-outline-secondary:hover {
            background: #6c757d;
            color: white;
            border-color: #6c757d;
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            color: white;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            border: none;
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #e74c3c);
            border: none;
            color: white;
        }

        .btn-info {
            background: linear-gradient(135deg, #17a2b8, #138496);
            border: none;
            color: white;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #8e9297);
            border: none;
            color: white;
        }

        /* Small buttons */
        .btn-sm {
            padding: 5px 10px;
            font-size: 0.875rem;
        }

        /* Button Group */
        .btn-group {
            display: inline-flex;
            vertical-align: middle;
        }

        .btn-group>.btn {
            position: relative;
            flex: 0 1 auto;
        }

        .btn-group>.btn:not(:last-child):not(.dropdown-toggle) {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .btn-group>.btn:not(:first-child) {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            margin-left: -1px;
        }

        /* Form Controls */
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

        /* Data Table Container */
        .data-table-container {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .table-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary-green);
            margin: 0;
        }

        /* Table Styles */
        .table {
            width: 100%;
            margin-bottom: 0;
            border-collapse: collapse;
            background-color: transparent;
        }

        .table-responsive {
            display: block;
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            font-weight: 600;
            border: none;
            padding: 12px;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            white-space: nowrap;
            text-align: left;
        }

        .table thead th:first-child {
            border-top-left-radius: 10px;
        }

        .table thead th:last-child {
            border-top-right-radius: 10px;
        }

        .table tbody td {
            padding: 12px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            background-color: var(--warm-white);
        }

        .table tbody tr:hover td {
            background-color: var(--cream);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Table Alignment */
        .text-center {
            text-align: center !important;
        }

        .align-middle {
            vertical-align: middle !important;
        }

        /* UMKM Item in Table */
        .umkm-item {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .umkm-thumbnail {
            width: 60px;
            height: 45px;
            border-radius: 6px;
            object-fit: cover;
            flex-shrink: 0;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .umkm-content {
            flex: 1;
            min-width: 0;
        }

        .umkm-title {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--primary-green);
            margin-bottom: 2px;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .umkm-title a {
            color: inherit;
            text-decoration: none;
        }

        .umkm-title a:hover {
            color: var(--accent-orange);
        }

        .umkm-meta {
            display: flex;
            gap: 10px;
            align-items: center;
            font-size: 0.75rem;
            color: var(--soft-gray);
        }

        .umkm-meta span {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 4px 8px;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge.bg-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .badge.bg-warning {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            color: white;
        }

        .badge.bg-secondary {
            background: linear-gradient(135deg, #6c757d, #8e9297);
            color: white;
        }

        .badge.bg-danger {
            background: linear-gradient(135deg, #dc3545, #e74c3c);
            color: white;
        }

        .badge.bg-info {
            background: linear-gradient(135deg, #17a2b8, #138496);
            color: white;
        }

        /* Dropdown */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-toggle {
            white-space: nowrap;
        }

        .dropdown-toggle::after {
            display: inline-block;
            margin-left: 0.255em;
            vertical-align: 0.255em;
            content: "";
            border-top: 0.3em solid;
            border-right: 0.3em solid transparent;
            border-bottom: 0;
            border-left: 0.3em solid transparent;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            display: none;
            min-width: 10rem;
            padding: 0.5rem 0;
            margin: 0.125rem 0 0;
            font-size: 0.875rem;
            color: #212529;
            text-align: left;
            list-style: none;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175);
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-menu-end {
            right: 0;
            left: auto;
        }

        .dropdown-item {
            display: block;
            width: 100%;
            padding: 0.5rem 1rem;
            clear: both;
            font-weight: 400;
            color: #212529;
            text-align: inherit;
            text-decoration: none;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            color: #1e2125;
            background-color: #f8f9fa;
        }

        .dropdown-item.text-danger {
            color: #dc3545;
        }

        .dropdown-item.text-danger:hover {
            background-color: rgba(220, 53, 69, 0.1);
        }

        .dropdown-divider {
            height: 0;
            margin: 0.5rem 0;
            overflow: hidden;
            border-top: 1px solid #e9ecef;
        }

        .dropdown-item i {
            width: 20px;
            display: inline-block;
        }

        /* Fix form inside dropdown */
        .dropdown-menu form {
            margin: 0;
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
            flex-wrap: wrap;
        }

        .bulk-actions.show {
            display: flex;
        }

        .bulk-select-all {
            margin-right: 10px;
        }

        /* Pagination */
        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            margin-bottom: 0;
        }

        .page-link {
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: var(--primary-green);
            background-color: #fff;
            border: 1px solid #dee2e6;
            text-decoration: none;
        }

        .page-link:hover {
            z-index: 2;
            color: var(--primary-green);
            background-color: var(--cream);
            border-color: #dee2e6;
        }

        .page-item:first-child .page-link {
            margin-left: 0;
            border-top-left-radius: 0.5rem;
            border-bottom-left-radius: 0.5rem;
        }

        .page-item:last-child .page-link {
            border-top-right-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
        }

        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
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

        /* Alert Messages */
        .alert {
            position: relative;
            padding: 1rem 1rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 0.375rem;
        }

        .alert-success {
            color: #0f5132;
            background-color: #d1e7dd;
            border-color: #badbcc;
        }

        .alert-danger {
            color: #842029;
            background-color: #f8d7da;
            border-color: #f5c2c7;
        }

        .alert-warning {
            color: #664d03;
            background-color: #fff3cd;
            border-color: #ffecb5;
        }

        .alert-info {
            color: #055160;
            background-color: #cff4fc;
            border-color: #b6effb;
        }

        .alert-dismissible {
            padding-right: 3rem;
        }

        .alert-dismissible .btn-close {
            position: absolute;
            top: 0;
            right: 0;
            z-index: 2;
            padding: 1.25rem 1rem;
        }

        /* Dark Theme Adjustments */
        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background: var(--warm-white);
            border-color: rgba(255, 255, 255, 0.2);
            color: #333;
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

        [data-theme="dark"] .table tbody td {
            border-bottom-color: rgba(255, 255, 255, 0.1);
            background-color: var(--warm-white);
        }

        [data-theme="dark"] .table tbody tr:hover td {
            background-color: var(--cream);
        }

        [data-theme="dark"] .umkm-title {
            color: var(--light-green);
        }

        [data-theme="dark"] .table-title {
            color: var(--light-green);
        }

        [data-theme="dark"] .filter-title {
            color: var(--light-green);
        }

        [data-theme="dark"] .stat-number {
            color: var(--light-green);
        }

        [data-theme="dark"] .empty-state h5 {
            color: var(--light-green);
        }

        [data-theme="dark"] .page-link {
            color: var(--light-green);
        }

        [data-theme="dark"] .dropdown-menu {
            background: var(--warm-white);
            border-color: rgba(255, 255, 255, 0.2);
        }

        [data-theme="dark"] .dropdown-item {
            color: #333;
        }

        [data-theme="dark"] .dropdown-item:hover {
            background-color: var(--cream);
            color: var(--primary-green);
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .umkm-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-section {
                padding: 20px;
            }

            .data-table-container {
                padding: 15px;
            }

            .table {
                font-size: 0.85rem;
            }

            .table thead th {
                padding: 10px 8px;
                font-size: 0.8rem;
            }

            .table tbody td {
                padding: 10px 8px;
            }

            .umkm-thumbnail {
                width: 50px;
                height: 40px;
            }

            .umkm-title {
                font-size: 0.85rem;
            }

            .btn-group {
                display: flex;
                flex-wrap: wrap;
                gap: 4px;
            }

            .btn-sm {
                padding: 4px 8px;
                font-size: 0.75rem;
            }

            .dropdown-menu {
                min-width: 140px;
            }

            .badge {
                font-size: 0.7rem;
                padding: 3px 6px;
            }
        }

        @media (max-width: 576px) {
            .umkm-stats {
                grid-template-columns: 1fr;
            }

            .filter-header {
                flex-direction: column;
                align-items: stretch;
            }

            .table-header {
                flex-direction: column;
                align-items: stretch;
            }

            .bulk-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .umkm-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .umkm-thumbnail {
                width: 100%;
                height: 120px;
                margin-bottom: 8px;
            }
        }

        /* Utility Classes */
        .mb-0 {
            margin-bottom: 0 !important;
        }

        .me-2 {
            margin-right: 0.5rem !important;
        }

        .ms-1 {
            margin-left: 0.25rem !important;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .text-warning {
            color: #ffc107 !important;
        }

        .d-flex {
            display: flex !important;
        }

        .d-inline-block {
            display: inline-block !important;
        }

        .gap-2 {
            gap: 0.5rem !important;
        }

        .flex-wrap {
            flex-wrap: wrap !important;
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-content">
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">UMKM</li>
                    <li class="breadcrumb-item active">Kelola UMKM</li>
                </ol>
            </nav>
            <h1 class="page-title">{{ $titleHeader }}</h1>
            <p class="page-subtitle">Kelola dan verifikasi pendaftaran UMKM dari warga desa</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                <div>
                    {{ session('success') }}
                    @if (session('waLink'))
                        <a href="{{ session('waLink') }}" target="_blank" class="btn btn-sm btn-success ms-3">
                            <i class="fab fa-whatsapp me-1"></i> Kirim Notifikasi WA
                        </a>
                    @endif
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <div>{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-info-circle me-2"></i>
                <div>{{ session('info') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-octagon me-2"></i>
                <div>{{ session('warning') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="umkm-stats">
            <div class="umkm-stat-card">
                <div class="stat-icon total">
                    <i class="bi bi-shop"></i>
                </div>
                <div class="stat-number">{{ number_format($stats['total']) }}</div>
                <div class="stat-label">Total UMKM</div>
            </div>
            <div class="umkm-stat-card">
                <div class="stat-icon pending">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="stat-number">{{ number_format($stats['pending']) }}</div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="umkm-stat-card">
                <div class="stat-icon approved">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-number">{{ number_format($stats['approved']) }}</div>
                <div class="stat-label">Disetujui</div>
            </div>
            <div class="umkm-stat-card">
                <div class="stat-icon rejected">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div class="stat-number">{{ number_format($stats['rejected']) }}</div>
                <div class="stat-label">Ditolak</div>
            </div>
        </div>

        <div class="filter-section">
            <div class="filter-header">
                <h4 class="filter-title">
                    <i class="bi bi-funnel me-2"></i>Filter & Pencarian
                </h4>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('admin.umkm.create') }}" class="btn btn-primary d-none">
                        <i class="bi bi-plus-lg me-2"></i>Tambah UMKM
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-download me-2"></i>Export
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.umkm.export', request()->query()) }}">
                                    <i class="bi bi-file-excel me-2"></i>Export Excel
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <form method="GET" action="{{ route('admin.umkm.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Cari Nama UMKM/Produk/NIK</label>
                    <input type="text" class="form-control" name="search" id="search"
                        value="{{ request('search') }}" placeholder="Cari UMKM, produk, atau pemilik...">
                </div>
                <div class="col-md-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select class="form-select" name="kategori" id="kategori">
                        @foreach ($kategoriOptions as $key => $value)
                            <option value="{{ $key }}" {{ request('kategori') == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="tab" class="form-label">Status</label>
                    <select class="form-select" name="tab" id="tab">
                        <option value="all" {{ $tab == 'all' ? 'selected' : '' }}>Semua</option>
                        <option value="pending" {{ $tab == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $tab == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ $tab == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-search"></i> Cari
                        </button>
                        <a href="{{ route('admin.umkm.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="bulk-actions" id="bulkActions">
            <input type="checkbox" class="form-check-input bulk-select-all" id="selectAll">
            <label for="selectAll" class="form-check-label me-3">Pilih Semua</label>

            <form action="{{ route('admin.umkm.bulk-action') }}" method="POST" id="bulkForm"
                class="d-flex gap-2 flex-wrap">
                @csrf
                <input type="hidden" name="action" id="bulkAction">
                <div id="selectedItems"></div>

                <button type="button" class="btn btn-sm btn-success" onclick="setBulkAction('approve')">
                    <i class="bi bi-check-circle me-1"></i>Setujui
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="setBulkAction('reject')">
                    <i class="bi bi-x-circle me-1"></i>Tolak
                </button>
                <button type="button" class="btn btn-sm btn-secondary" onclick="setBulkAction('delete')">
                    <i class="bi bi-trash me-1"></i>Hapus
                </button>

                {{-- Catatan untuk bulk reject, disembunyikan secara default --}}
                <div id="bulkRejectNote" class="d-none">
                    <label for="bulk_catatan" class="form-label mb-1">Catatan Penolakan Massal:</label>
                    <textarea name="bulk_catatan" id="bulk_catatan" class="form-control" rows="2"
                        placeholder="Masukkan catatan penolakan..."></textarea>
                </div>
            </form>
        </div>

        <div class="data-table-container">
            <div class="table-header">
                <h4 class="table-title">
                    <i class="bi bi-list me-2"></i>Daftar UMKM
                </h4>
                <div class="text-muted">
                    Menampilkan {{ $umkms->firstItem() ?? 0 }} - {{ $umkms->lastItem() ?? 0 }} dari
                    {{ $umkms->total() }} UMKM
                </div>
            </div>

            @if ($umkms->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="40" class="text-center">
                                    <input type="checkbox" class="form-check-input" id="masterCheck">
                                </th>
                                <th width="250">Info UMKM</th>
                                <th width="150">Pemilik</th>
                                <th width="120" class="text-center">Kategori</th>
                                <th width="120" class="text-center">Status</th>
                                <th width="150">Tanggal Daftar</th>
                                <th width="150" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($umkms as $umkm)
                                <tr>
                                    <td class="text-center align-middle">
                                        <input type="checkbox" class="form-check-input item-check"
                                            value="{{ $umkm->id }}" name="umkm_ids[]">
                                    </td>
                                    <td>
                                        <div class="umkm-item">
                                            <img src="{{ $umkm->foto_produk_url }}" alt="{{ $umkm->nama_umkm }}"
                                                class="umkm-thumbnail">
                                            <div class="umkm-content">
                                                <div class="umkm-title">
                                                    <a href="{{ route('admin.umkm.show', $umkm->id) }}">
                                                        {{ $umkm->nama_umkm }}
                                                    </a>
                                                </div>
                                                <small class="text-muted">{{ Str::limit($umkm->nama_produk, 30) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <small>{{ $umkm->nama_pemilik }}</small>
                                        <br>
                                        <small class="text-muted">{{ $umkm->nik }}</small>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge bg-secondary">{{ $umkm->kategori_label }}</span>
                                    </td>
                                    <td class="text-center align-middle">
                                        {!! $umkm->status_badge !!}
                                    </td>
                                    <td class="align-middle">
                                        <small>
                                            {{ $umkm->created_at->format('d M Y') }}<br>
                                            {{ $umkm->created_at->format('H:i') }}
                                        </small>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('admin.umkm.show', $umkm->id) }}"
                                                class="btn btn-sm btn-info" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            {{-- Aksi Cepat Sesuai Status --}}
                                            @if ($umkm->isPending())
                                                <a href="{{ route('admin.umkm.approve', $umkm->id) }}"
                                                    class="btn btn-sm btn-success" title="Setujui"
                                                    onclick="return confirm('Yakin ingin menyetujui UMKM ini?')">
                                                    <i class="bi bi-check-circle"></i>
                                                </a>
                                                <a href="{{ route('admin.umkm.reject.form', $umkm->id) }}"
                                                    class="btn btn-sm btn-warning" title="Tolak">
                                                    <i class="bi bi-x-circle"></i>
                                                </a>
                                            @elseif ($umkm->isApproved())
                                                <a href="{{ route('admin.umkm.toggle-status', $umkm->id) }}"
                                                    class="btn btn-sm btn-outline-warning" title="Ubah ke Pending"
                                                    onclick="return confirm('Yakin ingin mengubah status UMKM ini ke pending?')">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </a>
                                            @elseif ($umkm->isRejected())
                                                <a href="{{ route('admin.umkm.reset-to-pending', $umkm->id) }}"
                                                    class="btn btn-sm btn-primary" title="Reset ke Pending"
                                                    onclick="return confirm('Yakin ingin mereset UMKM ini ke pending?')">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </a>
                                            @endif

                                            <form action="{{ route('admin.umkm.destroy', $umkm->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus UMKM ini? Tindakan ini tidak dapat dibatalkan.')"
                                                class="d-inline-block">
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

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Menampilkan {{ $umkms->firstItem() }} - {{ $umkms->lastItem() }} dari {{ $umkms->total() }}
                        UMKM
                    </div>
                    {{ $umkms->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-shop"></i>
                    <h5>Tidak ada pendaftaran UMKM</h5>
                    <p class="mb-3">Belum ada UMKM yang tersedia pada status ini.</p>
                </div>
            @endif
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
                }, 10000); // Tunda auto-close untuk memberi waktu admin klik link WA
            });

            // Inisialisasi tabs
            const tabLinks = document.querySelectorAll('.nav-tabs .nav-link');
            tabLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const tabParam = this.getAttribute('data-tab');
                    const url = new URL(window.location.href);
                    url.searchParams.set('tab', tabParam);
                    window.location.href = url.toString();
                });
            });

            // Set tab aktif berdasarkan URL parameter
            const urlParams = new URLSearchParams(window.location.search);
            const activeTab = urlParams.get('tab') || 'pending';
            const navLink = document.querySelector(`.nav-link[data-tab="${activeTab}"]`);
            if (navLink) {
                navLink.classList.add('active');
            } else {
                document.querySelector('.nav-link[data-tab="pending"]').classList.add('active');
            }

            // Inisialisasi bulk actions
            initBulkActions();

            // Inisialisasi semua dropdowns
            const dropdowns = document.querySelectorAll('[data-bs-toggle="dropdown"]');
            dropdowns.forEach(dropdown => {
                new bootstrap.Dropdown(dropdown);
            });
        });

        // Bulk Actions Functionality
        function initBulkActions() {
            const masterCheck = document.getElementById('masterCheck');
            const itemChecks = document.querySelectorAll('.item-check');
            const bulkActions = document.getElementById('bulkActions');
            const selectAll = document.getElementById('selectAll');

            if (!masterCheck || !selectAll) return;

            // Master checkbox functionality
            masterCheck.addEventListener('change', function() {
                itemChecks.forEach(check => {
                    check.checked = this.checked;
                });
                toggleBulkActions();
            });

            // Individual checkbox functionality
            itemChecks.forEach(check => {
                check.addEventListener('change', function() {
                    const checkedItems = document.querySelectorAll('.item-check:checked');
                    masterCheck.checked = checkedItems.length === itemChecks.length;
                    masterCheck.indeterminate = checkedItems.length > 0 && checkedItems.length < itemChecks
                        .length;
                    selectAll.checked = masterCheck.checked;
                    toggleBulkActions();
                });
            });

            // Select all functionality (for the separate "Pilih Semua" checkbox)
            selectAll.addEventListener('change', function() {
                itemChecks.forEach(check => {
                    check.checked = this.checked;
                });
                masterCheck.checked = this.checked;
                masterCheck.indeterminate = false;
                toggleBulkActions();
            });

            function toggleBulkActions() {
                const checkedItems = document.querySelectorAll('.item-check:checked');
                const bulkRejectNote = document.getElementById('bulkRejectNote');

                if (checkedItems.length > 0) {
                    bulkActions.classList.add('show');
                    updateSelectedItems();

                    // Cek status item yang dipilih. Jika ada yang 'rejected' atau 'approved', sembunyikan tombol 'approve'/'reject'
                    let canApprove = true;
                    let canReject = true;
                    checkedItems.forEach(item => {
                        const row = item.closest('tr');
                        const statusBadge = row.querySelector('.status-badge');
                        if (statusBadge) {
                            const status = statusBadge.textContent.trim().toLowerCase();
                            if (status === 'disetujui' || status === 'ditolak') {
                                canApprove = false;
                            }
                            if (status === 'disetujui' || status === 'ditolak') {
                                canReject = false;
                            }
                        }
                    });

                    // Tampilkan/sembunyikan tombol aksi bulk
                    document.querySelector('button[onclick*="approve"]').style.display = canApprove ? 'inline-block' :
                        'none';
                    document.querySelector('button[onclick*="reject"]').style.display = canReject ? 'inline-block' : 'none';

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
                    input.name = 'umkm_ids[]';
                    input.value = item.value;
                    selectedItemsContainer.appendChild(input);
                });
            }
        }

        function setBulkAction(action) {
            const bulkForm = document.getElementById('bulkForm');
            const bulkActionInput = document.getElementById('bulkAction');
            const checkedItems = document.querySelectorAll('.item-check:checked');
            const bulkRejectNote = document.getElementById('bulkRejectNote');

            if (checkedItems.length === 0) {
                alert('Pilih minimal satu UMKM untuk melakukan aksi bulk!');
                return;
            }

            // Atur visibility form catatan penolakan
            if (action === 'reject') {
                bulkRejectNote.classList.remove('d-none');
            } else {
                bulkRejectNote.classList.add('d-none');
            }

            let confirmMessage = '';
            switch (action) {
                case 'approve':
                    confirmMessage = `Yakin ingin menyetujui ${checkedItems.length} UMKM yang dipilih?`;
                    break;
                case 'reject':
                    // Konfirmasi akan dilakukan setelah catatan diisi
                    break;
                case 'delete':
                    confirmMessage =
                        `Yakin ingin menghapus ${checkedItems.length} UMKM yang dipilih? Tindakan ini tidak dapat dibatalkan.`;
                    break;
            }

            if (action === 'reject') {
                const catatan = document.getElementById('bulk_catatan').value;
                if (!catatan) {
                    alert('Catatan penolakan harus diisi!');
                    return;
                }
                confirmMessage = `Yakin ingin menolak ${checkedItems.length} UMKM dengan catatan: "${catatan}"?`;
            }

            if (confirm(confirmMessage)) {
                bulkActionInput.value = action;
                bulkForm.submit();
            }
        }
    </script>
@endpush
