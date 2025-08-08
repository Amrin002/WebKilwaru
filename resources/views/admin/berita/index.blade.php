{{-- Berita Management --}}
@extends('layouts.main')

@push('style')
    <style>
        /* Berita Management Styles */
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
        .berita-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .berita-stat-card {
            background: var(--warm-white);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .berita-stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-orange), var(--primary-green));
        }

        .berita-stat-card:hover {
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

        .stat-icon.published {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .stat-icon.draft {
            background: linear-gradient(135deg, #ff8c42, #ffa726);
        }

        .stat-icon.featured {
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

        /* Berita Item in Table */
        .berita-item {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .berita-thumbnail {
            width: 60px;
            height: 45px;
            border-radius: 6px;
            object-fit: cover;
            flex-shrink: 0;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .berita-content {
            flex: 1;
            min-width: 0;
        }

        .berita-title {
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

        .berita-excerpt {
            font-size: 0.8rem;
            color: var(--soft-gray);
            margin-bottom: 2px;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .berita-meta {
            display: flex;
            gap: 10px;
            align-items: center;
            font-size: 0.75rem;
            color: var(--soft-gray);
        }

        .berita-meta span {
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

        [data-theme="dark"] .berita-title {
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
            .berita-stats {
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

            .berita-thumbnail {
                width: 50px;
                height: 40px;
            }

            .berita-title {
                font-size: 0.85rem;
            }

            .berita-excerpt {
                display: none;
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
            .berita-stats {
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

            .berita-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .berita-thumbnail {
                width: 100%;
                height: 120px;
                margin-bottom: 8px;
            }

            /* Hide some columns on mobile */
            .table thead th:nth-child(5),
            .table tbody td:nth-child(5),
            .table thead th:nth-child(6),
            .table tbody td:nth-child(6) {
                display: none;
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
        <!-- Page Header -->
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Konten</li>
                    <li class="breadcrumb-item active">Kelola Berita</li>
                </ol>
            </nav>
            <h1 class="page-title">Kelola Berita</h1>
            <p class="page-subtitle">Kelola dan publikasikan berita serta informasi desa</p>
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
        <div class="berita-stats">
            <div class="berita-stat-card">
                <div class="stat-icon total">
                    <i class="bi bi-newspaper"></i>
                </div>
                <div class="stat-number">{{ number_format($statistics['total']) }}</div>
                <div class="stat-label">Total Berita</div>
            </div>
            <div class="berita-stat-card">
                <div class="stat-icon published">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-number">{{ number_format($statistics['published']) }}</div>
                <div class="stat-label">Published</div>
            </div>
            <div class="berita-stat-card">
                <div class="stat-icon draft">
                    <i class="bi bi-file-text"></i>
                </div>
                <div class="stat-number">{{ number_format($statistics['draft']) }}</div>
                <div class="stat-label">Draft</div>
            </div>
            <div class="berita-stat-card">
                <div class="stat-icon featured">
                    <i class="bi bi-star"></i>
                </div>
                <div class="stat-number">{{ number_format($statistics['featured']) }}</div>
                <div class="stat-label">Featured</div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-header">
                <h4 class="filter-title">
                    <i class="bi bi-funnel me-2"></i>Filter & Pencarian
                </h4>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>Tulis Berita Baru
                    </a>
                    <a href="{{ route('admin.kategori-berita.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-tags me-2"></i>Kelola Kategori
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-download me-2"></i>Export
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.berita.export', request()->query()) }}">
                                    <i class="bi bi-file-excel me-2"></i>Export Excel
                                </a></li>
                            <li><a class="dropdown-item" href="{{ route('berita.rss') }}" target="_blank">
                                    <i class="bi bi-rss me-2"></i>RSS Feed
                                </a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <form method="GET" action="{{ route('admin.berita.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Cari Judul atau Konten</label>
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}"
                        placeholder="Cari judul, konten, atau penulis...">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status">
                        <option value="">Semua Status</option>
                        @foreach ($statusList as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Kategori</label>
                    <select class="form-select" name="kategori">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoriList as $kategori)
                            <option value="{{ $kategori->slug }}"
                                {{ request('kategori') == $kategori->slug ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Featured</label>
                    <select class="form-select" name="featured">
                        <option value="">Semua</option>
                        <option value="yes" {{ request('featured') == 'yes' ? 'selected' : '' }}>Ya</option>
                        <option value="no" {{ request('featured') == 'no' ? 'selected' : '' }}>Tidak</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-search"></i>
                        </button>
                        <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-primary">
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

            <form action="{{ route('admin.berita.bulk-action') }}" method="POST" id="bulkForm"
                class="d-flex gap-2 flex-wrap">
                @csrf
                <input type="hidden" name="action" id="bulkAction">
                <div id="selectedItems"></div>

                <button type="button" class="btn btn-sm btn-success" onclick="setBulkAction('publish')">
                    <i class="bi bi-check-circle me-1"></i>Publish
                </button>
                <button type="button" class="btn btn-sm btn-warning" onclick="setBulkAction('unpublish')">
                    <i class="bi bi-pause-circle me-1"></i>Unpublish
                </button>
                <button type="button" class="btn btn-sm btn-info" onclick="setBulkAction('feature')">
                    <i class="bi bi-star me-1"></i>Feature
                </button>
                <button type="button" class="btn btn-sm btn-secondary" onclick="setBulkAction('archive')">
                    <i class="bi bi-archive me-1"></i>Archive
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="setBulkAction('delete')">
                    <i class="bi bi-trash me-1"></i>Hapus
                </button>
            </form>
        </div>

        <!-- Data Table -->
        <!-- Bagian Data Table yang diperbaiki -->
        <div class="data-table-container">
            <div class="table-header">
                <h4 class="table-title">
                    <i class="bi bi-list me-2"></i>Daftar Berita
                </h4>
                <div class="text-muted">
                    Menampilkan {{ $beritas->firstItem() ?? 0 }} - {{ $beritas->lastItem() ?? 0 }} dari
                    {{ $beritas->total() }} berita
                </div>
            </div>

            @if ($beritas->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="40" class="text-center">
                                    <input type="checkbox" class="form-check-input" id="masterCheck">
                                </th>
                                <th width="400">Berita</th>
                                <th width="120" class="text-center">Kategori</th>
                                <th width="100" class="text-center">Status</th>
                                <th width="100">Penulis</th>
                                <th width="80" class="text-center">Views</th>
                                <th width="120">Tanggal</th>
                                <th width="180" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($beritas as $berita)
                                <tr>
                                    <td class="text-center align-middle">
                                        <input type="checkbox" class="form-check-input item-check"
                                            value="{{ $berita->id }}" name="selected_items[]">
                                    </td>
                                    <td>
                                        <div class="berita-item">
                                            <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}"
                                                class="berita-thumbnail">
                                            <div class="berita-content">
                                                <div class="berita-title">
                                                    {{ $berita->judul }}
                                                    @if ($berita->is_featured)
                                                        <i class="bi bi-star-fill text-warning ms-1" title="Featured"></i>
                                                    @endif
                                                </div>
                                                <div class="berita-excerpt">{{ $berita->excerpt_formatted }}</div>
                                                <div class="berita-meta">
                                                    <span><i class="bi bi-eye"></i>
                                                        {{ number_format($berita->views) }}</span>
                                                    @if ($berita->tags && count($berita->tags) > 0)
                                                        <span><i class="bi bi-tags"></i>
                                                            {{ implode(', ', array_slice($berita->tags, 0, 2)) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        @if ($berita->kategoriBeri)
                                            <span class="badge"
                                                style="background-color: {{ $berita->kategoriBeri->warna }}">
                                                {{ $berita->kategoriBeri->nama }}
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        @if ($berita->status == 'published')
                                            <span class="badge badge-success">Published</span>
                                        @elseif ($berita->status == 'draft')
                                            <span class="badge badge-warning">Draft</span>
                                        @else
                                            <span class="badge badge-secondary">Archived</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <small>{{ $berita->penulis }}</small>
                                    </td>
                                    <td class="text-center align-middle">
                                        <span class="badge badge-info">{{ number_format($berita->views) }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <small>
                                            @if ($berita->published_at)
                                                {{ $berita->published_at->format('d/m/Y') }}<br>
                                                {{ $berita->published_at->format('H:i') }}
                                            @else
                                                <em class="text-muted">Belum dipublish</em>
                                            @endif
                                        </small>
                                    </td>
                                    <td class="align-middle">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.berita.show', $berita->slug) }}"
                                                class="btn btn-outline-primary" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.berita.edit', $berita->slug) }}"
                                                class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            @if ($berita->status == 'published')
                                                <a href="{{ route('berita.show', $berita->slug) }}" target="_blank"
                                                    class="btn btn-info" title="Lihat">
                                                    <i class="bi bi-box-arrow-up-right"></i>
                                                </a>
                                            @endif

                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-outline-secondary dropdown-toggle"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('admin.berita.duplicate', $berita->slug) }}">
                                                            <i class="bi bi-copy me-2"></i>Duplikasi
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form
                                                            action="{{ route('admin.berita.toggle-featured', $berita->slug) }}"
                                                            method="POST" class="mb-0">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="bi bi-star me-2"></i>
                                                                {{ $berita->is_featured ? 'Unfeature' : 'Feature' }}
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form
                                                            action="{{ route('admin.berita.toggle-publish', $berita->slug) }}"
                                                            method="POST" class="mb-0">
                                                            @csrf
                                                            <button type="submit" class="dropdown-item">
                                                                <i
                                                                    class="bi bi-{{ $berita->status == 'published' ? 'pause' : 'play' }}-circle me-2"></i>
                                                                {{ $berita->status == 'published' ? 'Unpublish' : 'Publish' }}
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.berita.destroy', $berita->slug) }}"
                                                            method="POST" class="mb-0"
                                                            onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
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
                        Menampilkan {{ $beritas->firstItem() }} - {{ $beritas->lastItem() }} dari {{ $beritas->total() }}
                        berita
                    </div>
                    {{ $beritas->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-newspaper"></i>
                    <h5>Belum ada berita</h5>
                    <p class="mb-3">Mulai tulis berita pertama Anda untuk menginformasi warga desa</p>
                    <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>Tulis Berita Pertama
                    </a>
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
                }, 5000);
            });

            // Initialize bulk actions
            initBulkActions();

            // Initialize all dropdowns
            const dropdowns = document.querySelectorAll('[data-bs-toggle="dropdown"]');
            dropdowns.forEach(dropdown => {
                // Pastikan dropdown instance ter-initialize
                new bootstrap.Dropdown(dropdown);

                // Handle dropdown positioning
                dropdown.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const dropdownMenu = this.nextElementSibling;

                    // Calculate position to prevent cutoff
                    setTimeout(() => {
                        const rect = dropdownMenu.getBoundingClientRect();
                        const viewportHeight = window.innerHeight;

                        // If dropdown goes below viewport, position it above
                        if (rect.bottom > viewportHeight) {
                            dropdownMenu.style.transform =
                                `translateY(-${rect.height + 10}px)`;
                        }

                        // Ensure dropdown is not cut off on the right
                        if (rect.right > window.innerWidth) {
                            dropdownMenu.classList.add('dropdown-menu-end');
                        }
                    }, 10);
                });
            });

            // Fix untuk form submit di dalam dropdown
            const dropdownForms = document.querySelectorAll('.dropdown-menu form');
            dropdownForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    // Prevent dropdown from closing immediately
                    e.stopPropagation();
                });
            });

            // Prevent dropdown from closing when clicking inside
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.addEventListener('click', function(e) {
                    if (e.target.tagName !== 'A' && !e.target.closest('button[type="submit"]')) {
                        e.stopPropagation();
                    }
                });
            });
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
                alert('Pilih minimal satu berita untuk melakukan aksi bulk!');
                return;
            }

            let confirmMessage = '';
            switch (action) {
                case 'delete':
                    confirmMessage = `Yakin ingin menghapus ${checkedItems.length} berita yang dipilih?`;
                    break;
                case 'publish':
                    confirmMessage = `Yakin ingin mempublish ${checkedItems.length} berita yang dipilih?`;
                    break;
                case 'unpublish':
                    confirmMessage = `Yakin ingin meng-unpublish ${checkedItems.length} berita yang dipilih?`;
                    break;
                case 'archive':
                    confirmMessage = `Yakin ingin mengarsipkan ${checkedItems.length} berita yang dipilih?`;
                    break;
                case 'feature':
                    confirmMessage = `Yakin ingin menjadikan ${checkedItems.length} berita sebagai featured?`;
                    break;
                case 'unfeature':
                    confirmMessage = `Yakin ingin menghapus status featured dari ${checkedItems.length} berita?`;
                    break;
            }

            if (confirm(confirmMessage)) {
                document.getElementById('bulkAction').value = action;
                document.getElementById('bulkForm').submit();
            }
        }

        // Confirm individual delete
        function confirmDelete(url) {
            if (confirm('Yakin ingin menghapus berita ini?')) {
                window.location.href = url;
            }
        }

        // Quick status toggle
        function toggleStatus(slug, currentStatus) {
            const newStatus = currentStatus === 'published' ? 'draft' : 'published';
            const confirmMessage = `Yakin ingin mengubah status berita menjadi ${newStatus}?`;

            if (confirm(confirmMessage)) {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/berita/${slug}/toggle-publish`;

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;

                form.appendChild(csrfInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Quick feature toggle
        function toggleFeature(slug, isFeatured) {
            const action = isFeatured ? 'menghapus status featured' : 'menjadikan featured';
            const confirmMessage = `Yakin ingin ${action} berita ini?`;

            if (confirm(confirmMessage)) {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/berita/${slug}/toggle-featured`;

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;

                form.appendChild(csrfInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

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

        // Preview image before upload (untuk halaman create/edit nanti)
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('imagePreview');
                    if (preview) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
