{{-- Surat KPT Detail View --}}
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
            padding-bottom: 25px;
            border-bottom: 2px solid var(--cream);
            position: relative;
        }

        .detail-header::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-green), var(--accent-orange));
            border-radius: 2px;
        }

        .detail-icon {
            width: 100px;
            height: 100px;
            border-radius: 25px;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2.5rem;
            color: white;
            box-shadow: 0 8px 25px rgba(45, 80, 22, 0.3);
        }

        .detail-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 10px;
        }

        [data-theme="dark"] .detail-title {
            color: var(--light-green);
        }

        .detail-subtitle {
            color: var(--soft-gray);
            font-size: 1.1rem;
            margin-bottom: 15px;
        }

        .surat-number-badge {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            color: white;
            padding: 12px 24px;
            border-radius: 15px;
            font-weight: 700;
            font-size: 1.1rem;
            display: inline-block;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(255, 140, 66, 0.3);
        }

        .detail-meta {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .meta-item {
            text-align: center;
            color: var(--soft-gray);
            font-size: 0.9rem;
        }

        .meta-label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .meta-value {
            color: var(--primary-green);
            font-weight: 600;
        }

        [data-theme="dark"] .meta-value {
            color: var(--light-green);
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 15px;
        }

        .status-diproses {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: white;
            box-shadow: 0 4px 15px rgba(251, 191, 36, 0.3);
        }

        .status-disetujui {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .status-ditolak {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        /* Tipe Pemohon Badge */
        .tipe-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-left: 10px;
        }

        .tipe-user {
            background: rgba(45, 80, 22, 0.1);
            color: var(--primary-green);
            border: 1px solid rgba(45, 80, 22, 0.2);
        }

        .tipe-guest {
            background: rgba(255, 140, 66, 0.1);
            color: var(--accent-orange);
            border: 1px solid rgba(255, 140, 66, 0.2);
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
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
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 140, 66, 0.3);
            color: white;
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #e74c3c);
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
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
            color: white;
            transform: translateY(-2px);
        }

        .btn-info {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
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
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--soft-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-green);
            word-break: break-word;
        }

        [data-theme="dark"] .detail-value {
            color: var(--light-green);
        }

        .detail-value.large {
            font-size: 1.3rem;
            font-weight: 700;
        }

        .detail-value.highlight {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Address Card */
        .address-card {
            background: linear-gradient(135deg, rgba(45, 80, 22, 0.05), rgba(255, 140, 66, 0.05));
            border: 2px solid rgba(45, 80, 22, 0.1);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
            position: relative;
            overflow: hidden;
        }

        .address-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-green), var(--accent-orange));
        }

        .address-card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .address-icon {
            width: 50px;
            height: 50px;
            border-radius: 15px;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .address-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-green);
            margin: 0;
        }

        [data-theme="dark"] .address-title {
            color: var(--light-green);
        }

        .address-full {
            font-size: 1.1rem;
            color: var(--soft-gray);
            line-height: 1.6;
            padding: 15px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 12px;
            border-left: 4px solid var(--accent-orange);
        }

        /* User Info Card */
        .user-info-card {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.05), rgba(147, 197, 253, 0.05));
            border: 2px solid rgba(59, 130, 246, 0.1);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
            position: relative;
            overflow: hidden;
        }

        .user-info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #93c5fd);
        }

        /* Keterangan Card */
        .keterangan-card {
            background: linear-gradient(135deg, rgba(156, 163, 175, 0.05), rgba(209, 213, 219, 0.05));
            border: 2px solid rgba(156, 163, 175, 0.1);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .keterangan-card.empty {
            background: rgba(0, 0, 0, 0.02);
            border: 2px dashed rgba(0, 0, 0, 0.1);
        }

        /* Statistics Cards */
        .stats-mini {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .stat-mini-card {
            background: var(--warm-white);
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .stat-mini-icon {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            margin: 0 auto 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }

        .stat-mini-icon.created {
            background: linear-gradient(135deg, #28a745, #20c997);
        }

        .stat-mini-icon.updated {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
        }

        .stat-mini-icon.status {
            background: linear-gradient(135deg, #6f42c1, #8e44ad);
        }

        .stat-mini-icon.type {
            background: linear-gradient(135deg, #17a2b8, #138496);
        }

        .stat-mini-label {
            font-size: 0.8rem;
            color: var(--soft-gray);
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-mini-value {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--primary-green);
        }

        [data-theme="dark"] .stat-mini-value {
            color: var(--light-green);
        }

        /* Copy Button */
        .copy-btn {
            background: none;
            border: none;
            color: var(--soft-gray);
            cursor: pointer;
            padding: 5px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .copy-btn:hover {
            color: var(--accent-orange);
            background: rgba(255, 140, 66, 0.1);
        }

        .copy-success {
            color: #28a745 !important;
        }

        /* Status Management Modal */
        .status-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .status-modal.active {
            display: flex;
        }

        .modal-content {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 30px;
            max-width: 500px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }

        /* Print Styles */
        @media print {

            .action-buttons,
            .page-header nav {
                display: none !important;
            }

            .detail-container {
                box-shadow: none !important;
                border: 1px solid #000 !important;
            }

            .detail-header {
                border-bottom: 2px solid #000 !important;
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
                align-items: stretch;
            }

            .detail-meta {
                flex-direction: column;
                gap: 15px;
            }

            .detail-icon {
                width: 80px;
                height: 80px;
                font-size: 2rem;
            }

            .detail-title {
                font-size: 1.5rem;
            }

            .stats-mini {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .surat-number-badge {
                font-size: 1rem;
                padding: 10px 20px;
            }

            .stats-mini {
                grid-template-columns: 1fr;
            }

            .status-badge {
                font-size: 0.75rem;
                padding: 6px 12px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-content">
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Pelayanan Surat</li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.surat-kpt.index') }}">Surat KPT</a></li>
                    <li class="breadcrumb-item active">Detail Surat</li>
                </ol>
            </nav>
            <h1 class="page-title">Detail Surat Keterangan Penghasilan Tetap</h1>
            <p class="page-subtitle">Informasi lengkap data surat keterangan penghasilan tetap dalam sistem</p>
        </div>

        <div class="action-buttons">
            <a href="{{ route('admin.surat-kpt.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i>Kembali ke Daftar
            </a>

            @if ($surat->status !== 'disetujui')
                <a href="{{ route('admin.surat-kpt.edit', $surat->id) }}" class="btn btn-warning">
                    <i class="fas fa-pencil-alt"></i>Edit Data
                </a>
            @endif

            <button onclick="openStatusModal()" class="btn btn-info">
                <i class="fas fa-edit"></i>Update Status
            </button>

            @if ($surat->status === 'disetujui' && $surat->nomor_surat)
                <a href="{{ route('admin.surat-kpt.download', $surat->id) }}" class="btn btn-success" target="_blank">
                    <i class="fas fa-download"></i>Download Surat
                </a>
            @endif

            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i>Cetak Detail
            </button>

            <form action="{{ route('admin.surat-kpt.destroy', $surat->id) }}" method="POST" style="display: inline-block;"
                onsubmit="return confirm('Yakin ingin menghapus surat ini? Tindakan ini tidak dapat dibatalkan!')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i>Hapus
                </button>
            </form>
        </div>

        <div class="detail-container">
            <div class="detail-header">
                <div class="detail-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h2 class="detail-title">Surat Keterangan Penghasilan Tetap</h2>
                <p class="detail-subtitle">Data lengkap informasi surat keterangan penghasilan tetap</p>

                <div class="status-badge status-{{ $surat->status }}">
                    {{ ucfirst($surat->status) }}
                </div>

                @if ($surat->nomor_surat)
                    <div class="surat-number-badge">
                        {{ $surat->nomor_surat }}
                        <button class="copy-btn ms-2" onclick="copyToClipboard('{{ $surat->nomor_surat }}', this)"
                            title="Salin nomor surat">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                @else
                    <div class="surat-number-badge" style="background: linear-gradient(135deg, #6c757d, #8d9498);">
                        Belum Ada Nomor Surat
                    </div>
                @endif

                <div class="detail-meta">
                    <div class="meta-item">
                        <span class="meta-label">Dibuat</span>
                        <span class="meta-value">{{ $surat->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Terakhir Update</span>
                        <span class="meta-value">{{ $surat->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Tipe Pemohon</span>
                        <span class="meta-value">
                            {{ $surat->user_id ? 'Pengguna Terdaftar' : 'Guest' }}
                            <span class="tipe-badge {{ $surat->user_id ? 'tipe-user' : 'tipe-guest' }}">
                                {{ $surat->user_id ? 'USER' : 'GUEST' }}
                            </span>
                        </span>
                    </div>
                </div>
            </div>

            @if ($surat->user_id && $surat->user)
                <div class="user-info-card">
                    <div class="address-card-header">
                        <div class="address-icon" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <h4 class="address-title" style="color: #3b82f6;">Informasi Pengguna Terdaftar</h4>
                    </div>
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-user"></i>
                                Nama Pengguna
                            </div>
                            <div class="detail-value">{{ $surat->user->name }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-envelope"></i>
                                Email
                            </div>
                            <div class="detail-value">{{ $surat->user->email }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="fas fa-calendar-alt"></i>
                                Bergabung Sejak
                            </div>
                            <div class="detail-value">{{ $surat->user->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="detail-section">
                <h4 class="section-title">
                    <div class="section-icon">
                        <i class="fas fa-id-card"></i>
                    </div>
                    Data Pihak yang Bersangkutan
                </h4>
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-user-alt"></i>
                            Nama Lengkap
                        </div>
                        <div class="detail-value large highlight">{{ $surat->nama_yang_bersangkutan }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-id-card-alt"></i>
                            NIK
                        </div>
                        <div class="detail-value">{{ $surat->nik }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-venus-mars"></i>
                            Jenis Kelamin
                        </div>
                        <div class="detail-value">{{ $surat->jenis_kelamin }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Tempat & Tanggal Lahir
                        </div>
                        <div class="detail-value">{{ $surat->tempat_lahir }}, {{ $surat->tanggal_lahir_formatted }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-briefcase"></i>
                            Pekerjaan
                        </div>
                        <div class="detail-value">{{ $surat->pekerjaan }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-crosshairs"></i>
                            Agama
                        </div>
                        <div class="detail-value">{{ $surat->agama }}</div>
                    </div>
                </div>
            </div>

            <div class="address-card">
                <div class="address-card-header">
                    <div class="address-icon">
                        <i class="fas fa-map-signs"></i>
                    </div>
                    <h4 class="address-title">Alamat Lengkap Pihak yang Bersangkutan</h4>
                </div>
                <div class="address-full">
                    {{ $surat->alamat_yang_bersangkutan }}
                    <button class="copy-btn float-end"
                        onclick="copyToClipboard('{{ $surat->alamat_yang_bersangkutan }}', this)"
                        title="Salin alamat lengkap">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
                @if ($surat->nomor_telepon)
                    <div class="mt-3">
                        <strong>Kontak:</strong>
                        <span class="text-primary">{{ $surat->nomor_telepon }}</span>
                        <button class="copy-btn" onclick="copyToClipboard('{{ $surat->nomor_telepon }}', this)"
                            title="Salin nomor telepon">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                @endif
            </div>

            <div class="detail-section">
                <h4 class="section-title">
                    <div class="section-icon">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    Detail Keterangan Surat
                </h4>
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-user-friends"></i>
                            Nama Ayah
                        </div>
                        <div class="detail-value">{{ $surat->nama_ayah }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-user-friends"></i>
                            Nama Ibu
                        </div>
                        <div class="detail-value">{{ $surat->nama_ibu }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-user-tie"></i>
                            Pekerjaan Orang Tua
                        </div>
                        <div class="detail-value">{{ $surat->pekerjaan_orang_tua }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-money-bill-wave"></i>
                            Penghasilan Per Bulan
                        </div>
                        <div class="detail-value">Rp {{ number_format($surat->penghasilan_per_bulan, 0, ',', '.') }}</div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-info-circle"></i>
                            Keperluan
                        </div>
                        <div class="detail-value">{{ $surat->keperluan }}</div>
                    </div>
                </div>
            </div>

            @if ($surat->keterangan)
                <div class="detail-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-comment-dots"></i>
                        </div>
                        Keterangan
                    </h4>
                    <div class="keterangan-card">
                        <div class="address-full">
                            {{ $surat->keterangan }}
                            <button class="copy-btn float-end"
                                onclick="copyToClipboard('{{ $surat->keterangan }}', this)" title="Salin keterangan">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="detail-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-comment-dots"></i>
                        </div>
                        Keterangan
                    </h4>
                    <div class="keterangan-card empty">
                        <div class="text-center text-muted">
                            <i class="fas fa-comment-slash fa-2x mb-2"></i>
                            <p class="mb-0">Tidak ada keterangan tambahan</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (!$surat->user_id && $surat->public_token)
                <div class="detail-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-link"></i>
                        </div>
                        Link Tracking untuk Guest
                    </h4>
                    <div class="user-info-card">
                        <div class="address-card-header">
                            <div class="address-icon" style="background: linear-gradient(135deg, #6f42c1, #8e44ad);">
                                <i class="fas fa-link"></i>
                            </div>
                            <h4 class="address-title" style="color: #6f42c1;">Link Tracking Surat</h4>
                        </div>
                        <div class="address-full">
                            {{ route('public.surat-kpt.track', $surat->public_token) }}
                            <button class="copy-btn float-end"
                                onclick="copyToClipboard('{{ route('public.surat-kpt.track', $surat->public_token) }}', this)"
                                title="Salin link tracking">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i>
                                Link ini dapat dibagikan kepada pemohon untuk melacak status surat
                            </small>
                        </div>
                    </div>
                </div>
            @endif

            <div class="detail-section">
                <h4 class="section-title">
                    <div class="section-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    Informasi Sistem
                </h4>
                <div class="stats-mini">
                    <div class="stat-mini-card">
                        <div class="stat-mini-icon created">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div class="stat-mini-label">Tanggal Dibuat</div>
                        <div class="stat-mini-value">{{ $surat->created_at->format('d M Y') }}</div>
                    </div>
                    <div class="stat-mini-card">
                        <div class="stat-mini-icon updated">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="stat-mini-label">Terakhir Update</div>
                        <div class="stat-mini-value">{{ $surat->updated_at->format('d M Y') }}</div>
                    </div>
                    <div class="stat-mini-card">
                        <div class="stat-mini-icon status">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <div class="stat-mini-label">Status Surat</div>
                        <div class="stat-mini-value">{{ ucfirst($surat->status) }}</div>
                    </div>
                    <div class="stat-mini-card">
                        <div class="stat-mini-icon type">
                            <i class="fas fa-user-tag"></i>
                        </div>
                        <div class="stat-mini-label">Tipe Pemohon</div>
                        <div class="stat-mini-value">{{ $surat->user_id ? 'User' : 'Guest' }}</div>
                    </div>
                    <div class="stat-mini-card">
                        <div class="stat-mini-icon created">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-mini-label">Usia Data</div>
                        <div class="stat-mini-value">{{ $surat->created_at->diffInDays(now()) }} hari</div>
                    </div>
                    <div class="stat-mini-card">
                        <div class="stat-mini-icon updated">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-mini-label">Update Terakhir</div>
                        <div class="stat-mini-value">{{ $surat->updated_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="status-modal" id="statusModal">
        <div class="modal-content">
            <div class="form-header">
                <div class="form-icon" style="width: 60px; height: 60px; font-size: 1.5rem;">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <h3 class="form-title" style="font-size: 1.5rem;">Update Status Surat</h3>
                <p class="form-subtitle">Ubah status dan berikan keterangan untuk surat ini</p>
            </div>

            <form id="statusForm" method="POST" action="{{ route('admin.surat-kpt.update-status', $surat->id) }}">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="status" class="form-label">Status Surat <span class="required">*</span></label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="diproses" {{ $surat->status == 'diproses' ? 'selected' : '' }}>Sedang Diproses
                        </option>
                        <option value="disetujui" {{ $surat->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ $surat->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                        placeholder="Keterangan tambahan (opsional)">{{ $surat->keterangan }}</textarea>
                </div>
                <div class="mb-3" id="nomor-surat-container" style="display: none;">
                    <label for="nomor_surat" class="form-label">Nomor Surat</label>
                    <input type="text" class="form-control" id="nomor_surat" name="nomor_surat"
                        placeholder="Nomor surat (otomatis jika dikosongkan)"
                        value="{{ old('nomor_surat', $surat->nomor_surat ?? '') }}">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-outline-secondary" onclick="closeStatusModal()">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check me-2"></i>Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Copy to clipboard function
        function copyToClipboard(text, button) {
            navigator.clipboard.writeText(text).then(function() {
                // Change icon to success
                const icon = button.querySelector('i');
                const originalClass = icon.className;

                icon.className = 'fas fa-check';
                button.classList.add('copy-success');
                button.title = 'Tersalin!';

                // Show temporary success message
                showToast('Berhasil disalin ke clipboard!', 'success');

                // Reset after 2 seconds
                setTimeout(() => {
                    icon.className = originalClass;
                    button.classList.remove('copy-success');
                    button.title = 'Salin';
                }, 2000);

            }).catch(function(err) {
                console.error('Failed to copy: ', err);
                showToast('Gagal menyalin ke clipboard', 'error');
            });
        }

        // Toast notification function
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.textContent = message;

            const bgColor = type === 'success' ? '#28a745' : '#dc3545';
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${bgColor};
                color: white;
                padding: 12px 20px;
                border-radius: 12px;
                z-index: 99999;
                font-size: 0.9rem;
                font-weight: 600;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
                animation: slideIn 0.3s ease;
            `;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => {
                    if (document.body.contains(toast)) {
                        document.body.removeChild(toast);
                    }
                }, 300);
            }, 3000);
        }

        // Status Modal Functions
        function openStatusModal() {
            document.getElementById('statusModal').classList.add('active');
            document.body.style.overflow = 'hidden';

            // Check if status is "disetujui" and show nomor surat field
            const currentStatus = document.getElementById('status').value;
            if (currentStatus === 'disetujui') {
                document.getElementById('nomor-surat-container').style.display = 'block';
            }
        }

        function closeStatusModal() {
            document.getElementById('statusModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.getElementById('statusModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeStatusModal();
            }
        });

        // Handle status form submission
        document.getElementById('statusForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            // Show loading
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memperbarui...';
            submitBtn.disabled = true;

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                            'content') || formData.get('_token')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Status surat berhasil diperbarui!', 'success');

                        // Reload page after a short delay
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        showToast(data.message || 'Gagal memperbarui status', 'error');

                        // Reset button
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Terjadi kesalahan sistem', 'error');

                    // Reset button
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
        });

        // Add CSS for animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOut {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .detail-item {
                opacity: 0;
                animation: fadeInUp 0.6s ease forwards;
            }
        `;
        document.head.appendChild(style);

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Add staggered animation to detail items
            document.querySelectorAll('.detail-item').forEach((item, index) => {
                item.style.animationDelay = `${index * 0.1}s`;
            });

            // Add meta tag for CSRF if not exists
            if (!document.querySelector('meta[name="csrf-token"]')) {
                const meta = document.createElement('meta');
                meta.name = 'csrf-token';
                meta.content = '{{ csrf_token() }}';
                document.head.appendChild(meta);
            }

            // Toggle visibility of nomor surat input based on status
            const statusSelect = document.getElementById('status');
            const nomorSuratContainer = document.getElementById('nomor-surat-container');
            if (statusSelect && nomorSuratContainer) {
                statusSelect.addEventListener('change', function() {
                    if (this.value === 'disetujui') {
                        nomorSuratContainer.style.display = 'block';
                    } else {
                        nomorSuratContainer.style.display = 'none';
                    }
                });

                // Initial state
                if (statusSelect.value === 'disetujui') {
                    nomorSuratContainer.style.display = 'block';
                }
            }
        });

        // Print functionality
        function preparePrint() {
            const printStyles = `
                @media print {
                    .action-buttons, .copy-btn, .status-modal { display: none !important; }
                    body { -webkit-print-color-adjust: exact !important; }
                    .detail-container { page-break-inside: avoid; }
                    .status-badge { 
                        background: #333 !important; 
                        color: white !important; 
                        -webkit-print-color-adjust: exact !important;
                    }
                }
            `;

            const printStyle = document.createElement('style');
            printStyle.textContent = printStyles;
            document.head.appendChild(printStyle);
        }

        // Initialize print preparation
        preparePrint();
    </script>
@endpush
