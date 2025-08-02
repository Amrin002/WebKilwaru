@extends('layouts.main')

@push('style')
    <style>
        /* Detail View Styles */
        .detail-container {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .detail-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--cream);
            position: relative;
        }

        .detail-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 3rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .detail-avatar::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: rotate(45deg);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
            }

            100% {
                transform: translateX(100%) translateY(100%) rotate(45deg);
            }
        }

        .detail-name {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 10px;
        }

        [data-theme="dark"] .detail-name {
            color: var(--light-green);
        }

        .detail-nik {
            font-size: 1.1rem;
            color: var(--soft-gray);
            margin-bottom: 15px;
            font-family: 'Courier New', monospace;
            letter-spacing: 1px;
        }

        .status-badges {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-badge.gender-male {
            background: linear-gradient(135deg, #2196F3, #64B5F6);
            color: white;
        }

        .status-badge.gender-female {
            background: linear-gradient(135deg, #E91E63, #F8BBD9);
            color: white;
        }

        .status-badge.age {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            color: white;
        }

        .status-badge.family {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
        }

        /* Detail Sections */
        .detail-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--cream);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        [data-theme="dark"] .section-title {
            color: var(--light-green);
        }

        .section-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .detail-item {
            background: var(--cream);
            border-radius: 15px;
            padding: 20px;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .detail-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .detail-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--soft-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .detail-value {
            font-size: 1.1rem;
            color: var(--primary-green);
            font-weight: 600;
            word-break: break-word;
        }

        [data-theme="dark"] .detail-value {
            color: var(--light-green);
        }

        .detail-value.empty {
            color: var(--soft-gray);
            font-style: italic;
            font-weight: normal;
        }

        /* Special detail items */
        .detail-item.highlight {
            background: linear-gradient(135deg, rgba(255, 140, 66, 0.1), rgba(45, 80, 22, 0.05));
            border: 1px solid rgba(255, 140, 66, 0.2);
        }

        .detail-item.highlight .detail-value {
            color: var(--accent-orange);
        }

        /* Copy button styles */
        .copy-btn {
            background: transparent;
            border: 1px solid var(--accent-orange);
            border-radius: 6px;
            color: var(--accent-orange);
            padding: 4px 8px;
            font-size: 0.7rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-left: 8px;
        }

        .copy-btn:hover {
            background: var(--accent-orange);
            color: white;
            transform: scale(1.05);
        }

        .copy-btn i {
            font-size: 0.8rem;
        }

        /* KK Info Card */
        .kk-info-card {
            background: linear-gradient(135deg, rgba(45, 80, 22, 0.1), rgba(143, 188, 143, 0.1));
            border: 1px solid rgba(45, 80, 22, 0.2);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .kk-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .kk-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .kk-details h6 {
            color: var(--primary-green);
            font-weight: 600;
            margin-bottom: 5px;
            font-size: 1.1rem;
        }

        [data-theme="dark"] .kk-details h6 {
            color: var(--light-green);
        }

        .kk-details p {
            color: var(--soft-gray);
            margin: 0;
            font-size: 0.9rem;
        }

        /* Action Buttons */
        .action-buttons {
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
            min-width: 140px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45, 80, 22, 0.3);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            min-width: 140px;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 140, 66, 0.3);
        }

        .btn-outline-secondary {
            color: var(--soft-gray);
            border: 2px solid var(--soft-gray);
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            background: transparent;
            transition: all 0.3s ease;
            min-width: 140px;
        }

        .btn-outline-secondary:hover {
            background: var(--soft-gray);
            border-color: var(--soft-gray);
            transform: translateY(-2px);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #e74c3c);
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            min-width: 140px;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }

        /* Page Header Styles */
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

        .alert-info {
            background: rgba(23, 162, 184, 0.1);
            border-left-color: #17a2b8;
            color: #0c5460;
        }

        /* Timeline/History Section */
        .timeline {
            position: relative;
            padding: 20px 0;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 30px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--cream);
        }

        .timeline-item {
            position: relative;
            padding-left: 70px;
            margin-bottom: 20px;
        }

        .timeline-icon {
            position: absolute;
            left: 18px;
            top: 0;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--accent-orange);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.8rem;
        }

        .timeline-content {
            background: var(--cream);
            border-radius: 10px;
            padding: 15px;
        }

        .timeline-title {
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 5px;
        }

        [data-theme="dark"] .timeline-title {
            color: var(--light-green);
        }

        .timeline-date {
            font-size: 0.8rem;
            color: var(--soft-gray);
        }

        /* Context Menu Styles */
        .context-menu {
            position: fixed;
            background: var(--warm-white);
            border: 1px solid var(--cream);
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            padding: 5px 0;
            min-width: 150px;
        }

        .context-menu-item {
            padding: 8px 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
            color: inherit;
        }

        .context-menu-item:hover {
            background: var(--cream);
        }

        .context-menu-item i {
            width: 16px;
            text-align: center;
        }

        /* Print Styles */
        @media print {

            .action-buttons,
            .page-header nav,
            .copy-btn {
                display: none !important;
            }

            .detail-container {
                box-shadow: none;
                border: 1px solid #ddd;
            }

            .detail-avatar::before {
                animation: none;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .detail-container {
                padding: 20px;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .detail-avatar {
                width: 100px;
                height: 100px;
                font-size: 2.5rem;
            }

            .detail-name {
                font-size: 1.6rem;
            }

            .status-badges {
                flex-direction: column;
                align-items: center;
            }

            .kk-header {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 576px) {

            .btn-primary,
            .btn-warning,
            .btn-outline-secondary,
            .btn-danger {
                width: 100%;
                margin-bottom: 10px;
            }

            .section-title {
                flex-direction: column;
                text-align: center;
                gap: 8px;
            }

            .detail-header {
                margin-bottom: 20px;
            }
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-in {
            animation: slideIn 0.8s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(-30px);
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
    <div class="dashboard-content">
        <!-- Page Header -->
        <div class="page-header fade-in">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Data Penduduk</li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.penduduk.index') }}">Data Penduduk</a></li>
                    <li class="breadcrumb-item active">Detail Penduduk</li>
                </ol>
            </nav>
            <h1 class="page-title">Detail Data Penduduk</h1>
            <p class="page-subtitle">Informasi lengkap data penduduk dalam sistem administrasi desa</p>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
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

        <!-- KK Information Card -->
        <div class="kk-info-card slide-in">
            <div class="kk-header">
                <div class="kk-icon">
                    <i class="fas fa-home"></i>
                </div>
                <div class="kk-details">
                    <h6>Kartu Keluarga: {{ $penduduk->no_kk }}</h6>
                    <p>
                        @if ($penduduk->kk)
                            {{ $penduduk->kk->alamat }} - RT {{ $penduduk->kk->rt ?? '-' }} / RW
                            {{ $penduduk->kk->rw ?? '-' }}
                        @else
                            Data KK tidak ditemukan
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <!-- Main Detail Container -->
        <div class="detail-container fade-in">
            <!-- Detail Header with Photo and Basic Info -->
            <div class="detail-header">
                <div class="detail-avatar">
                    {{ strtoupper(substr($penduduk->nama_lengkap, 0, 1)) }}{{ strtoupper(substr(explode(' ', $penduduk->nama_lengkap)[1] ?? '', 0, 1)) }}
                </div>
                <h2 class="detail-name">{{ $penduduk->nama_lengkap }}</h2>
                <div class="detail-nik">NIK: {{ $penduduk->nik }}</div>
                <div class="status-badges">
                    <span
                        class="status-badge {{ $penduduk->jenis_kelamin == 'Laki-laki' ? 'gender-male' : 'gender-female' }}">
                        <i class="fas fa-{{ $penduduk->jenis_kelamin == 'Laki-laki' ? 'mars' : 'venus' }} me-1"></i>
                        {{ $penduduk->jenis_kelamin }}
                    </span>
                    <span class="status-badge age">
                        <i class="fas fa-calendar-alt me-1"></i>
                        {{ \Carbon\Carbon::parse($penduduk->tanggal_lahir)->age }} Tahun
                    </span>
                    <span class="status-badge family">
                        <i class="fas fa-users me-1"></i>
                        {{ $penduduk->status_keluarga }}
                    </span>
                </div>
            </div>

            <!-- Section 1: Identitas Pribadi -->
            <div class="detail-section slide-in">
                <h4 class="section-title">
                    <div class="section-icon">
                        <i class="fas fa-id-card"></i>
                    </div>
                    Identitas Pribadi
                </h4>
                <div class="detail-grid">
                    <div class="detail-item highlight">
                        <div class="detail-label">NIK</div>
                        <div class="detail-value" id="nik-value">
                            {{ $penduduk->nik }}
                            <button class="copy-btn" onclick="copyToClipboard('{{ $penduduk->nik }}', 'NIK')"
                                title="Salin NIK">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Nama Lengkap</div>
                        <div class="detail-value">{{ $penduduk->nama_lengkap }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Tempat Lahir</div>
                        <div class="detail-value">{{ $penduduk->tempat_lahir }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Tanggal Lahir</div>
                        <div class="detail-value">{{ \Carbon\Carbon::parse($penduduk->tanggal_lahir)->format('d F Y') }}
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Jenis Kelamin</div>
                        <div class="detail-value">
                            <i class="fas fa-{{ $penduduk->jenis_kelamin == 'Laki-laki' ? 'mars' : 'venus' }} me-2"></i>
                            {{ $penduduk->jenis_kelamin }}
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Agama</div>
                        <div class="detail-value">
                            <i class="fas fa-pray me-2"></i>
                            {{ $penduduk->agama }}
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Golongan Darah</div>
                        <div class="detail-value {{ empty($penduduk->golongan_darah) ? 'empty' : '' }}">
                            <i class="fas fa-tint me-2"></i>
                            {{ $penduduk->golongan_darah ?: 'Belum diisi' }}
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Kewarganegaraan</div>
                        <div class="detail-value">
                            <i class="fas fa-flag me-2"></i>
                            {{ $penduduk->kewarganegaraan }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Pendidikan & Pekerjaan -->
            <div class="detail-section slide-in">
                <h4 class="section-title">
                    <div class="section-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    Pendidikan & Pekerjaan
                </h4>
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Pendidikan Terakhir</div>
                        <div class="detail-value">
                            <i class="fas fa-university me-2"></i>
                            {{ $penduduk->pendidikan }}
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Pekerjaan</div>
                        <div class="detail-value">
                            <i class="fas fa-briefcase me-2"></i>
                            {{ $penduduk->pekerjaan }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Status & Keluarga -->
            <div class="detail-section slide-in">
                <h4 class="section-title">
                    <div class="section-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    Status & Data Keluarga
                </h4>
                <div class="detail-grid">
                    <div class="detail-item highlight">
                        <div class="detail-label">Nomor Kartu Keluarga</div>
                        <div class="detail-value">
                            {{ $penduduk->no_kk }}
                            <button class="copy-btn" onclick="copyToClipboard('{{ $penduduk->no_kk }}', 'Nomor KK')"
                                title="Salin Nomor KK">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Status Perkawinan</div>
                        <div class="detail-value">
                            <i class="fas fa-heart me-2"></i>
                            {{ $penduduk->status }}
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Status dalam Keluarga</div>
                        <div class="detail-value">
                            <i class="fas fa-user-friends me-2"></i>
                            {{ $penduduk->status_keluarga }}
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Nama Ayah</div>
                        <div class="detail-value">
                            <i class="fas fa-male me-2"></i>
                            {{ $penduduk->nama_ayah }}
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Nama Ibu</div>
                        <div class="detail-value">
                            <i class="fas fa-female me-2"></i>
                            {{ $penduduk->nama_ibu }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 4: Informasi Tambahan -->
            <div class="detail-section slide-in">
                <h4 class="section-title">
                    <div class="section-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    Informasi Tambahan
                </h4>
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">Umur Saat Ini</div>
                        <div class="detail-value">
                            <i class="fas fa-birthday-cake me-2"></i>
                            {{ \Carbon\Carbon::parse($penduduk->tanggal_lahir)->age }} tahun
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Kategori Usia</div>
                        <div class="detail-value">
                            @php
                                $age = \Carbon\Carbon::parse($penduduk->tanggal_lahir)->age;
                                $category = '';
                                $icon = '';
                                if ($age < 15) {
                                    $category = 'Anak-anak';
                                    $icon = 'fa-child';
                                } elseif ($age < 65) {
                                    $category = 'Usia Produktif';
                                    $icon = 'fa-user-tie';
                                } else {
                                    $category = 'Lansia';
                                    $icon = 'fa-user-clock';
                                }
                            @endphp
                            <i class="fas {{ $icon }} me-2"></i>
                            {{ $category }}
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Data Ditambahkan</div>
                        <div class="detail-value">
                            <i class="fas fa-calendar-plus me-2"></i>
                            {{ $penduduk->created_at->format('d F Y H:i') }}
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Terakhir Diperbarui</div>
                        <div class="detail-value">
                            <i class="fas fa-edit me-2"></i>
                            {{ $penduduk->updated_at->format('d F Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 5: Riwayat/Timeline -->
            <div class="detail-section slide-in">
                <h4 class="section-title">
                    <div class="section-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    Riwayat Data
                </h4>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-icon">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-title">Data Penduduk Ditambahkan</div>
                            <div class="timeline-date">{{ $penduduk->created_at->format('d F Y, H:i') }}</div>
                        </div>
                    </div>
                    @if ($penduduk->created_at != $penduduk->updated_at)
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="fas fa-edit"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Data Terakhir Diperbarui</div>
                                <div class="timeline-date">{{ $penduduk->updated_at->format('d F Y, H:i') }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('admin.penduduk.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                </a>
                <a href="{{ route('admin.penduduk.edit', $penduduk->nik) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>Edit Data
                </a>
                <button type="button" class="btn btn-primary" onclick="printDetail()">
                    <i class="fas fa-print me-2"></i>Cetak Detail
                </button>
                @if ($penduduk->kk)
                    <a href="{{ route('admin.kk.show', $penduduk->no_kk) }}" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i>Lihat KK
                    </a>
                @endif
                <form action="{{ route('admin.penduduk.destroy', $penduduk->nik) }}" method="POST"
                    style="display: inline-block;" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                        <i class="fas fa-trash me-2"></i>Hapus Data
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus Data
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data penduduk berikut?</p>
                    <div class="alert alert-warning">
                        <strong>Nama:</strong> {{ $penduduk->nama_lengkap }}<br>
                        <strong>NIK:</strong> {{ $penduduk->nik }}<br>
                        <strong>KK:</strong> {{ $penduduk->no_kk }}
                    </div>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian:</strong> Tindakan ini tidak dapat dibatalkan!
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" onclick="executeDelete()">
                        <i class="fas fa-trash me-2"></i>Ya, Hapus Data
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    if (alert.querySelector('.btn-close')) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                }, 5000);
            });

            // Initialize animations
            initAnimations();

            // Initialize tooltips
            initTooltips();
        });

        // Initialize animations for sections
        function initAnimations() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationDelay = `${entry.target.dataset.delay || 0}ms`;
                        entry.target.classList.add('fade-in');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            // Observe all detail sections
            document.querySelectorAll('.detail-section').forEach((section, index) => {
                section.dataset.delay = index * 100;
                observer.observe(section);
            });
        }

        // Initialize tooltips
        function initTooltips() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    placement: 'top'
                });
            });
        }

        // Copy to clipboard function
        function copyToClipboard(text, label) {
            navigator.clipboard.writeText(text).then(function() {
                showToast(`${label} berhasil disalin!`, 'success');
            }).catch(function() {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                try {
                    document.execCommand('copy');
                    showToast(`${label} berhasil disalin!`, 'success');
                } catch (err) {
                    showToast('Gagal menyalin teks', 'error');
                }
                document.body.removeChild(textArea);
            });
        }

        // Show toast notification
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} 
                               position-fixed top-0 end-0 m-3`;
            toast.style.zIndex = '9999';
            toast.style.minWidth = '300px';
            toast.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
                ${message}
            `;

            document.body.appendChild(toast);

            // Auto remove after 3 seconds
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 3000);
        }

        // Print detail function
        function printDetail() {
            // Create print-friendly version
            const printWindow = window.open('', '_blank');
            const printContent = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Detail Penduduk - ${document.querySelector('.detail-name').textContent}</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 20px; }
                        .section { margin-bottom: 20px; }
                        .section-title { font-size: 1.2rem; font-weight: bold; color: #2d5016; border-bottom: 1px solid #ddd; padding-bottom: 5px; margin-bottom: 10px; }
                        .detail-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
                        .detail-item { padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
                        .detail-label { font-weight: bold; font-size: 0.9rem; color: #666; }
                        .detail-value { margin-top: 5px; font-size: 1rem; }
                        @media print { body { margin: 0; } }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>DETAIL DATA PENDUDUK</h1>
                        <h2>${document.querySelector('.detail-name').textContent}</h2>
                        <p>NIK: ${document.querySelector('.detail-nik').textContent}</p>
                    </div>
                    ${generatePrintContent()}
                </body>
                </html>
            `;

            printWindow.document.write(printContent);
            printWindow.document.close();
            printWindow.print();
        }

        // Generate print content
        function generatePrintContent() {
            const sections = document.querySelectorAll('.detail-section');
            let content = '';

            sections.forEach(section => {
                const title = section.querySelector('.section-title').textContent.trim();
                const items = section.querySelectorAll('.detail-item');

                content += `<div class="section">`;
                content += `<div class="section-title">${title}</div>`;
                content += `<div class="detail-grid">`;

                items.forEach(item => {
                    const label = item.querySelector('.detail-label').textContent;
                    const valueElement = item.querySelector('.detail-value');
                    // Remove copy button from print content
                    const value = valueElement.textContent.replace(/\s*$/, '').trim();
                    content += `
                        <div class="detail-item">
                            <div class="detail-label">${label}</div>
                            <div class="detail-value">${value}</div>
                        </div>
                    `;
                });

                content += `</div></div>`;
            });

            return content;
        }

        // Confirm delete function
        function confirmDelete() {
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }

        // Execute delete
        function executeDelete() {
            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            modal.hide();

            // Add loading state to delete button
            const deleteBtn = document.querySelector('#deleteForm button');
            const originalText = deleteBtn.innerHTML;
            deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...';
            deleteBtn.disabled = true;

            // Submit delete form
            document.getElementById('deleteForm').submit();
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // E for edit
            if (e.key === 'e' || e.key === 'E') {
                if (!e.ctrlKey && !e.altKey && !e.metaKey) {
                    const target = e.target;
                    if (target.tagName !== 'INPUT' && target.tagName !== 'TEXTAREA') {
                        e.preventDefault();
                        window.location.href = '{{ route('admin.penduduk.edit', $penduduk->nik) }}';
                    }
                }
            }

            // P for print
            if (e.key === 'p' || e.key === 'P') {
                if (e.ctrlKey) {
                    e.preventDefault();
                    printDetail();
                }
            }

            // Escape to go back
            if (e.key === 'Escape') {
                window.location.href = '{{ route('admin.penduduk.index') }}';
            }

            // B for back
            if (e.key === 'b' || e.key === 'B') {
                if (!e.ctrlKey && !e.altKey && !e.metaKey) {
                    const target = e.target;
                    if (target.tagName !== 'INPUT' && target.tagName !== 'TEXTAREA') {
                        e.preventDefault();
                        window.location.href = '{{ route('admin.penduduk.index') }}';
                    }
                }
            }
        });

        // Add hover effects to detail items
        document.querySelectorAll('.detail-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.transition = 'all 0.3s ease';
            });

            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Add double-click to edit functionality
        document.querySelectorAll('.detail-value').forEach(value => {
            value.addEventListener('dblclick', function() {
                if (confirm('Ingin mengedit data ini? Anda akan diarahkan ke halaman edit.')) {
                    window.location.href = '{{ route('admin.penduduk.edit', $penduduk->nik) }}';
                }
            });
        });

        // Add context menu for additional actions
        document.addEventListener('contextmenu', function(e) {
            if (e.target.closest('.detail-value')) {
                e.preventDefault();

                // Remove existing context menu
                const existingMenu = document.querySelector('.context-menu');
                if (existingMenu) {
                    existingMenu.remove();
                }

                // Create context menu
                const contextMenu = document.createElement('div');
                contextMenu.className = 'context-menu';
                contextMenu.style.cssText = `
                    position: fixed;
                    top: ${e.clientY}px;
                    left: ${e.clientX}px;
                `;

                const value = e.target.textContent.trim();
                const menuItems = [{
                        text: 'Salin Teks',
                        icon: 'fas fa-copy',
                        action: () => copyToClipboard(value, 'Teks')
                    },
                    {
                        text: 'Edit Data',
                        icon: 'fas fa-edit',
                        action: () => window.location.href =
                            '{{ route('admin.penduduk.edit', $penduduk->nik) }}'
                    }
                ];

                menuItems.forEach(item => {
                    const menuItem = document.createElement('div');
                    menuItem.className = 'context-menu-item';
                    menuItem.innerHTML = `<i class="${item.icon}"></i> ${item.text}`;

                    menuItem.addEventListener('click', function() {
                        item.action();
                        contextMenu.remove();
                    });

                    contextMenu.appendChild(menuItem);
                });

                document.body.appendChild(contextMenu);

                // Remove context menu on click elsewhere
                setTimeout(() => {
                    document.addEventListener('click', function removeMenu() {
                        if (contextMenu.parentNode) {
                            contextMenu.remove();
                        }
                        document.removeEventListener('click', removeMenu);
                    });
                }, 100);
            }
        });

        // Add loading animation for navigation
        document.querySelectorAll('a[href]').forEach(link => {
            if (!link.target || link.target !== '_blank') {
                link.addEventListener('click', function(e) {
                    if (this.href && !this.href.includes('#')) {
                        // Add loading indicator
                        const originalText = this.innerHTML;
                        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
                        this.style.pointerEvents = 'none';

                        // Restore after 3 seconds if still on page
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.style.pointerEvents = 'auto';
                        }, 3000);
                    }
                });
            }
        });

        // Add swipe gestures for mobile navigation
        let touchStartX = 0;
        let touchEndX = 0;

        document.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
        });

        document.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            const swipeThreshold = 100;
            const diff = touchStartX - touchEndX;

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    // Swipe left - go to edit
                    window.location.href = '{{ route('admin.penduduk.edit', $penduduk->nik) }}';
                } else {
                    // Swipe right - go back
                    window.location.href = '{{ route('admin.penduduk.index') }}';
                }
            }
        }

        // Performance monitoring
        window.addEventListener('load', function() {
            const loadTime = window.performance.timing.loadEventEnd - window.performance.timing.navigationStart;
            console.log(`Detail page loaded in ${loadTime}ms`);
        });

        // Initialize page with fade-in effect
        document.body.style.opacity = '0';
        window.addEventListener('load', function() {
            document.body.style.transition = 'opacity 0.5s ease-in';
            document.body.style.opacity = '1';
        });
    </script>
@endpush
