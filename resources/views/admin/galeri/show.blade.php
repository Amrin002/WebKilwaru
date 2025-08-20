@extends('layouts.main')

@push('style')
    <style>
        /* =================================
               DETAIL VIEW STYLES
               ================================= */

        /* Container Styles */
        .detail-container {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        /* Header Styles */
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
            line-height: 1.3;
        }

        [data-theme="dark"] .detail-title {
            color: var(--light-green);
        }

        .detail-subtitle {
            color: var(--soft-gray);
            font-size: 1.1rem;
            margin-bottom: 15px;
        }

        .galeri-id-badge {
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

        /* Meta Information */
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
            background: linear-gradient(135deg, #17a2b8, #20c997);
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
            box-shadow: 0 5px 15px rgba(23, 162, 184, 0.3);
            color: white;
        }

        /* Photo Display Section */
        .photo-display-container {
            background: linear-gradient(135deg, rgba(45, 80, 22, 0.05), rgba(255, 140, 66, 0.05));
            border: 2px solid rgba(45, 80, 22, 0.1);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 25px;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .photo-display-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-green), var(--accent-orange));
        }

        .photo-display-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .photo-display-icon {
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

        .photo-display-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--primary-green);
            margin: 0;
        }

        [data-theme="dark"] .photo-display-title {
            color: var(--light-green);
        }

        .main-photo {
            max-width: 100%;
            max-height: 600px;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            border: 4px solid white;
            margin: 0 auto 20px;
            display: block;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .main-photo:hover {
            transform: scale(1.02);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
        }

        .photo-placeholder {
            width: 400px;
            height: 400px;
            background: var(--cream);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border: 4px solid white;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        .photo-placeholder i {
            font-size: 4rem;
            color: var(--soft-gray);
            opacity: 0.5;
        }

        .photo-info {
            background: rgba(45, 80, 22, 0.1);
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
            text-align: left;
        }

        .photo-info h6 {
            color: var(--primary-green);
            font-weight: 600;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        [data-theme="dark"] .photo-info h6 {
            color: var(--light-green);
        }

        .photo-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .photo-detail-item {
            text-align: center;
            background: rgba(255, 255, 255, 0.7);
            padding: 15px;
            border-radius: 10px;
        }

        .photo-detail-label {
            font-size: 0.8rem;
            color: var(--soft-gray);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .photo-detail-value {
            font-weight: 600;
            color: var(--primary-green);
            font-size: 1rem;
        }

        [data-theme="dark"] .photo-detail-value {
            color: var(--light-green);
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
            padding: 25px;
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
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-value {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-green);
            word-break: break-word;
            line-height: 1.4;
        }

        [data-theme="dark"] .detail-value {
            color: var(--light-green);
        }

        .detail-value.large {
            font-size: 1.4rem;
            font-weight: 700;
        }

        .detail-value.highlight {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Keterangan Card */
        .keterangan-card {
            background: linear-gradient(135deg, rgba(255, 140, 66, 0.1), rgba(45, 80, 22, 0.05));
            border: 2px solid rgba(255, 140, 66, 0.2);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
            position: relative;
            overflow: hidden;
        }

        .keterangan-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-orange), var(--primary-green));
        }

        .keterangan-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .keterangan-icon {
            width: 50px;
            height: 50px;
            border-radius: 15px;
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .keterangan-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-green);
            margin: 0;
        }

        [data-theme="dark"] .keterangan-title {
            color: var(--light-green);
        }

        .keterangan-content {
            font-size: 1.1rem;
            color: var(--soft-gray);
            line-height: 1.7;
            padding: 20px;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 15px;
            border-left: 4px solid var(--accent-orange);
            margin: 0;
        }

        /* Statistics Mini Cards */
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

        .stat-mini-icon.views {
            background: linear-gradient(135deg, #6f42c1, #8e44ad);
        }

        .stat-mini-icon.size {
            background: linear-gradient(135deg, #17a2b8, #20c997);
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

        /* Image Modal */
        .image-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.9);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .image-modal.show {
            display: flex;
        }

        .modal-image {
            max-width: 90%;
            max-height: 90%;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 30px;
            color: white;
            font-size: 2rem;
            cursor: pointer;
            background: rgba(255, 255, 255, 0.2);
            width: 50px;
            height: 50px;
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
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

            .main-photo {
                max-height: 400px !important;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .detail-container {
                padding: 20px;
            }

            .photo-display-container {
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

            .photo-details {
                grid-template-columns: 1fr;
            }

            .main-photo {
                max-height: 400px;
            }
        }

        @media (max-width: 576px) {
            .galeri-id-badge {
                font-size: 1rem;
                padding: 10px 20px;
            }

            .photo-display-header {
                flex-direction: column;
                text-align: center;
            }

            .keterangan-header {
                flex-direction: column;
                text-align: center;
            }

            .stats-mini {
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
                    <li class="breadcrumb-item"><a href="{{ route('admin.galeri.index') }}">Galeri Foto</a></li>
                    <li class="breadcrumb-item active">Detail Foto</li>
                </ol>
            </nav>
            <h1 class="page-title">Detail Foto Galeri</h1>
            <p class="page-subtitle">Informasi lengkap foto galeri desa</p>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('admin.galeri.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i>Kembali ke Galeri
            </a>
            <a href="{{ route('admin.galeri.edit', $galeri->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i>Edit Foto
            </a>
            <a href="{{ route('public.galeri.show', $galeri->id) }}" class="btn btn-info" target="_blank">
                <i class="fas fa-eye"></i>Lihat di Public
            </a>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i>Cetak
            </button>
            <form action="{{ route('admin.galeri.destroy', $galeri->id) }}" method="POST" style="display: inline-block;"
                onsubmit="return confirm('Yakin ingin menghapus foto ini? Tindakan ini tidak dapat dibatalkan!')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i>Hapus
                </button>
            </form>
        </div>

        <!-- Main Detail Container -->
        <div class="detail-container">
            <!-- Header Section -->
            <div class="detail-header">
                <div class="detail-icon">
                    <i class="fas fa-camera"></i>
                </div>
                <h2 class="detail-title">{{ $galeri->nama_kegiatan }}</h2>
                <p class="detail-subtitle">Dokumentasi kegiatan dan aktivitas desa</p>
                <div class="galeri-id-badge">
                    #{{ $galeri->id }}
                    <button class="copy-btn ms-2" onclick="copyToClipboard('{{ $galeri->id }}', this)"
                        title="Salin ID foto">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>

                <div class="detail-meta">
                    <div class="meta-item">
                        <span class="meta-label">Upload</span>
                        <span class="meta-value">{{ $galeri->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Terakhir Update</span>
                        <span class="meta-value">{{ $galeri->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Selisih Waktu</span>
                        <span class="meta-value">{{ $galeri->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <!-- Photo Display Section -->
            <div class="photo-display-container">
                <div class="photo-display-header">
                    <div class="photo-display-icon">
                        <i class="fas fa-image"></i>
                    </div>
                    <h4 class="photo-display-title">Foto Kegiatan</h4>
                </div>

                @if ($galeri->foto)
                    <img src="{{ $galeri->foto_url }}" alt="{{ $galeri->nama_kegiatan }}" class="main-photo"
                        onclick="openImageModal('{{ $galeri->foto_url }}', '{{ $galeri->nama_kegiatan }}')">
                @else
                    <div class="photo-placeholder">
                        <i class="fas fa-image"></i>
                    </div>
                @endif

                <div class="photo-info">
                    <h6><i class="fas fa-info-circle me-2"></i>Informasi Foto</h6>
                    <div class="photo-details">
                        <div class="photo-detail-item">
                            <div class="photo-detail-label">Ukuran</div>
                            <div class="photo-detail-value">600 x 600 px</div>
                        </div>
                        <div class="photo-detail-item">
                            <div class="photo-detail-label">Format</div>
                            <div class="photo-detail-value">JPEG</div>
                        </div>
                        <div class="photo-detail-item">
                            <div class="photo-detail-label">Status</div>
                            <div class="photo-detail-value">{{ $galeri->foto ? 'Aktif' : 'Tidak Ada' }}</div>
                        </div>
                        <div class="photo-detail-item">
                            <div class="photo-detail-label">URL</div>
                            <div class="photo-detail-value">
                                <button class="copy-btn" onclick="copyToClipboard('{{ $galeri->foto_url }}', this)"
                                    title="Salin URL foto">
                                    <i class="fas fa-link"></i> Salin URL
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Keterangan Section -->
            @if ($galeri->keterangan)
                <div class="keterangan-card">
                    <div class="keterangan-header">
                        <div class="keterangan-icon">
                            <i class="fas fa-align-left"></i>
                        </div>
                        <h4 class="keterangan-title">Keterangan Kegiatan</h4>
                    </div>
                    <p class="keterangan-content">
                        {{ $galeri->keterangan }}
                        <button class="copy-btn float-end" onclick="copyToClipboard(`{{ $galeri->keterangan }}`, this)"
                            title="Salin keterangan">
                            <i class="fas fa-copy"></i>
                        </button>
                    </p>
                </div>
            @endif

            <!-- Detail Sections -->
            <!-- Section 1: Identitas -->
            <div class="detail-section">
                <h4 class="section-title">
                    <div class="section-icon">
                        <i class="fas fa-id-card"></i>
                    </div>
                    Identitas Foto
                </h4>

                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-hashtag"></i>
                            ID Foto
                        </div>
                        <div class="detail-value large highlight">#{{ $galeri->id }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-calendar-alt"></i>
                            Nama Kegiatan
                        </div>
                        <div class="detail-value large">{{ $galeri->nama_kegiatan }}</div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Detail Teknis -->
            <div class="detail-section">
                <h4 class="section-title">
                    <div class="section-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    Detail Teknis
                </h4>

                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-file-image"></i>
                            File Path
                        </div>
                        <div class="detail-value">{{ $galeri->foto ?? 'Tidak ada file' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-expand-arrows-alt"></i>
                            Dimensi
                        </div>
                        <div class="detail-value">600 x 600 pixel</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-file"></i>
                            Format
                        </div>
                        <div class="detail-value">JPEG</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="fas fa-shield-alt"></i>
                            Status
                        </div>
                        <div class="detail-value">{{ $galeri->foto ? 'Aktif' : 'Tidak Aktif' }}</div>
                    </div>
                </div>
            </div>

            <!-- Statistics Mini Cards -->
            <div class="detail-section">
                <h4 class="section-title">
                    <div class="section-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    Informasi Sistem
                </h4>

                <div class="stats-mini">
                    <div class="stat-mini-card">
                        <div class="stat-mini-icon created">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div class="stat-mini-label">Tanggal Upload</div>
                        <div class="stat-mini-value">{{ $galeri->created_at->format('d M Y') }}</div>
                    </div>
                    <div class="stat-mini-card">
                        <div class="stat-mini-icon updated">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="stat-mini-label">Terakhir Update</div>
                        <div class="stat-mini-value">{{ $galeri->updated_at->format('d M Y') }}</div>
                    </div>
                    <div class="stat-mini-card">
                        <div class="stat-mini-icon created">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-mini-label">Usia Foto</div>
                        <div class="stat-mini-value">{{ $galeri->created_at->diffInDays(now()) }} hari</div>
                    </div>
                    <div class="stat-mini-card">
                        <div class="stat-mini-icon size">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-mini-label">Update Terakhir</div>
                        <div class="stat-mini-value">{{ $galeri->updated_at->diffForHumans() }}</div>
                    </div>
                    @if ($galeri->keterangan)
                        <div class="stat-mini-card">
                            <div class="stat-mini-icon views">
                                <i class="fas fa-comment-alt"></i>
                            </div>
                            <div class="stat-mini-label">Panjang Keterangan</div>
                            <div class="stat-mini-value">{{ strlen($galeri->keterangan) }} karakter</div>
                        </div>
                    @endif
                    <div class="stat-mini-card">
                        <div class="stat-mini-icon size">
                            <i class="fas fa-external-link-alt"></i>
                        </div>
                        <div class="stat-mini-label">Public URL</div>
                        <div class="stat-mini-value">
                            <button class="copy-btn"
                                onclick="copyToClipboard('{{ route('public.galeri.show', $galeri->id) }}', this)"
                                title="Salin URL public">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="image-modal" id="imageModal">
        <span class="modal-close" onclick="closeImageModal()">&times;</span>
        <img class="modal-image" id="modalImage" src="" alt="">
    </div>
@endsection

@push('script')
    <script>
        // =================================
        // UTILITY FUNCTIONS
        // =================================

        // Copy to clipboard function with fallback
        function copyToClipboard(text, button) {
            // Modern browser support
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(function() {
                    showCopySuccess(button);
                }).catch(function(err) {
                    console.error('Modern clipboard failed: ', err);
                    fallbackCopyTextToClipboard(text, button);
                });
            } else {
                // Fallback for older browsers
                fallbackCopyTextToClipboard(text, button);
            }
        }

        // Fallback copy function for older browsers
        function fallbackCopyTextToClipboard(text, button) {
            const textArea = document.createElement('textarea');
            textArea.value = text;

            // Avoid scrolling to bottom
            textArea.style.top = '0';
            textArea.style.left = '0';
            textArea.style.position = 'fixed';
            textArea.style.opacity = '0';

            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    showCopySuccess(button);
                } else {
                    throw new Error('Copy command failed');
                }
            } catch (err) {
                console.error('Fallback copy failed: ', err);
                // Show error message
                const toast = document.createElement('div');
                toast.textContent = 'Gagal menyalin ke clipboard. Silakan salin manual.';
                toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #dc3545;
                color: white;
                padding: 12px 24px;
                border-radius: 10px;
                z-index: 10000;
                font-size: 0.9rem;
                font-weight: 600;
                box-shadow: 0 5px 20px rgba(220, 53, 69, 0.3);
                animation: slideIn 0.3s ease;
            `;

                document.body.appendChild(toast);
                setTimeout(() => {
                    if (document.body.contains(toast)) {
                        document.body.removeChild(toast);
                    }
                }, 3000);

                // Show text in prompt for manual copy
                prompt('Salin teks berikut:', text);
            }

            document.body.removeChild(textArea);
        }

        // Show copy success feedback
        function showCopySuccess(button) {
            const icon = button.querySelector('i');
            const originalClass = icon.className;
            const originalText = button.textContent || button.title;

            icon.className = 'fas fa-check';
            button.classList.add('copy-success');

            if (button.textContent.includes('Salin')) {
                button.innerHTML = '<i class="fas fa-check"></i> Tersalin!';
            } else {
                button.title = 'Tersalin!';
            }

            // Show temporary success message
            const toast = document.createElement('div');
            toast.textContent = 'Berhasil disalin ke clipboard!';
            toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #28a745;
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            z-index: 10000;
            font-size: 0.9rem;
            font-weight: 600;
            box-shadow: 0 5px 20px rgba(40, 167, 69, 0.3);
            animation: slideIn 0.3s ease;
        `;

            document.body.appendChild(toast);

            // Reset after 2 seconds
            setTimeout(() => {
                icon.className = originalClass;
                button.classList.remove('copy-success');

                if (originalText.includes('Salin')) {
                    button.innerHTML = `<i class="${originalClass}"></i> ${originalText}`;
                } else {
                    button.title = originalText;
                }

                if (document.body.contains(toast)) {
                    document.body.removeChild(toast);
                }
            }, 2000);
        }

        // =================================
        // IMAGE MODAL FUNCTIONS
        // =================================

        // Open image modal
        function openImageModal(imageSrc, imageAlt) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');

            modalImage.src = imageSrc;
            modalImage.alt = imageAlt;
            modal.classList.add('show');

            // Prevent body scroll
            document.body.style.overflow = 'hidden';
        }

        // Close image modal
        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.remove('show');

            // Restore body scroll
            document.body.style.overflow = 'auto';
        }

        // =================================
        // ADDITIONAL FUNCTIONS
        // =================================

        // Share functionality
        function sharePhoto() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $galeri->nama_kegiatan }}',
                    text: '{{ $galeri->keterangan ?? 'Foto galeri desa' }}',
                    url: '{{ route('public.galeri.show', $galeri->id) }}'
                });
            } else {
                // Fallback: copy URL to clipboard
                copyToClipboard('{{ route('public.galeri.show', $galeri->id) }}',
                    document.createElement('button'));
            }
        }

        // Download photo function
        function downloadPhoto() {
            if ('{{ $galeri->foto }}') {
                const link = document.createElement('a');
                link.href = '{{ $galeri->foto_url }}';
                link.download = '{{ Str::slug($galeri->nama_kegiatan) }}.jpg';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);

                // Show success message
                const toast = document.createElement('div');
                toast.textContent = 'Foto berhasil didownload!';
                toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #17a2b8;
                color: white;
                padding: 12px 24px;
                border-radius: 10px;
                z-index: 10000;
                font-size: 0.9rem;
                font-weight: 600;
                box-shadow: 0 5px 20px rgba(23, 162, 184, 0.3);
                animation: slideIn 0.3s ease;
            `;

                document.body.appendChild(toast);
                setTimeout(() => {
                    if (document.body.contains(toast)) {
                        document.body.removeChild(toast);
                    }
                }, 3000);
            }
        }

        // Print functionality
        function preparePrint() {
            const printStyles = `
            @media print {
                .action-buttons { display: none !important; }
                .copy-btn { display: none !important; }
                body { -webkit-print-color-adjust: exact !important; }
                .detail-container { page-break-inside: avoid; }
                .main-photo { max-height: 400px !important; }
                .image-modal { display: none !important; }
            }
        `;

            const printStyle = document.createElement('style');
            printStyle.textContent = printStyles;
            document.head.appendChild(printStyle);
        }

        // =================================
        // ANIMATIONS & STYLES
        // =================================

        // Add CSS animations
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
        }
        
        .image-modal {
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    `;
        document.head.appendChild(style);

        // =================================
        // INITIALIZATION
        // =================================

        // Initialize when DOM loaded
        document.addEventListener('DOMContentLoaded', function() {
            preparePrint();

            // Smooth scroll for long content and animate items
            document.querySelectorAll('.detail-item').forEach((item, index) => {
                item.style.animationDelay = `${index * 0.1}s`;
                item.style.animation = 'fadeInUp 0.6s ease forwards';
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeImageModal();
                }
            });

            // Close modal when clicking outside image
            document.getElementById('imageModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeImageModal();
                }
            });

            // Photo hover effect
            const mainPhoto = document.querySelector('.main-photo');
            if (mainPhoto) {
                mainPhoto.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.02)';
                });

                mainPhoto.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            }

            // Auto-focus on main photo if it exists
            const photoContainer = document.querySelector('.photo-display-container');
            if (photoContainer && window.location.hash === '#photo') {
                photoContainer.scrollIntoView({
                    behavior: 'smooth'
                });
            }

            // Add download button to action buttons if photo exists
            @if ($galeri->foto)
                const actionButtons = document.querySelector('.action-buttons');
                if (actionButtons) {
                    const downloadBtn = document.createElement('button');
                    downloadBtn.className = 'btn btn-info';
                    downloadBtn.onclick = downloadPhoto;
                    downloadBtn.innerHTML = '<i class="fas fa-download"></i>Download Foto';

                    // Insert before print button
                    const printBtn = actionButtons.querySelector('button[onclick="window.print()"]');
                    if (printBtn) {
                        actionButtons.insertBefore(downloadBtn, printBtn);
                    } else {
                        actionButtons.appendChild(downloadBtn);
                    }
                }
            @endif

            // Show success message if redirected from update
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('updated') === 'success') {
                const toast = document.createElement('div');
                toast.textContent = 'Foto galeri berhasil diperbarui!';
                toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #28a745;
                color: white;
                padding: 12px 24px;
                border-radius: 10px;
                z-index: 10000;
                font-size: 0.9rem;
                font-weight: 600;
                box-shadow: 0 5px 20px rgba(40, 167, 69, 0.3);
                animation: slideIn 0.3s ease;
            `;

                document.body.appendChild(toast);
                setTimeout(() => {
                    if (document.body.contains(toast)) {
                        document.body.removeChild(toast);
                    }
                }, 5000);

                // Remove parameter from URL
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        });
    </script>
@endpush
