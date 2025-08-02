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

        .kk-number-badge {
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

        /* Full Address Card */
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

        /* RT/RW Badge */
        .rt-rw-badges {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .rt-rw-badge {
            background: linear-gradient(135deg, var(--secondary-green), var(--light-green));
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
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

            .rt-rw-badges {
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .kk-number-badge {
                font-size: 1rem;
                padding: 10px 20px;
            }

            .address-card-header {
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
                    <li class="breadcrumb-item">Data Penduduk</li>
                    <li class="breadcrumb-item"><a href="{{ route('kk.index') }}">Data Kartu Keluarga</a></li>
                    <li class="breadcrumb-item active">Detail KK</li>
                </ol>
            </nav>
            <h1 class="page-title">Detail Kartu Keluarga</h1>
            <p class="page-subtitle">Informasi lengkap data kartu keluarga dalam sistem</p>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('kk.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>Kembali ke Daftar
            </a>
            <a href="{{ route('kk.edit', $kk->no_kk) }}" class="btn btn-warning">
                <i class="bi bi-pencil-square"></i>Edit Data
            </a>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="bi bi-printer"></i>Cetak
            </button>
            <form action="{{ route('kk.destroy', $kk->no_kk) }}" method="POST" style="display: inline-block;"
                onsubmit="return confirm('Yakin ingin menghapus data KK ini? Tindakan ini tidak dapat dibatalkan!')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i>Hapus
                </button>
            </form>
        </div>

        <!-- Main Detail Container -->
        <div class="detail-container">
            <!-- Header Section -->
            <div class="detail-header">
                <div class="detail-icon">
                    <i class="bi bi-house-door-fill"></i>
                </div>
                <h2 class="detail-title">Kartu Keluarga</h2>
                <p class="detail-subtitle">Data lengkap informasi kartu keluarga</p>
                <div class="kk-number-badge">
                    {{ $kk->no_kk }}
                    <button class="copy-btn ms-2" onclick="copyToClipboard('{{ $kk->no_kk }}', this)"
                        title="Salin nomor KK">
                        <i class="bi bi-copy"></i>
                    </button>
                </div>

                <div class="detail-meta">
                    <div class="meta-item">
                        <span class="meta-label">Dibuat</span>
                        <span class="meta-value">{{ $kk->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Terakhir Update</span>
                        <span class="meta-value">{{ $kk->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Selisih Waktu</span>
                        <span class="meta-value">{{ $kk->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <!-- Full Address Card -->
            <div class="address-card">
                <div class="address-card-header">
                    <div class="address-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h4 class="address-title">Alamat Lengkap</h4>
                </div>
                <div class="address-full">
                    {{ $kk->alamat_lengkap }}
                    <button class="copy-btn float-end" onclick="copyToClipboard('{{ $kk->alamat_lengkap }}', this)"
                        title="Salin alamat lengkap">
                        <i class="bi bi-copy"></i>
                    </button>
                </div>
                <div class="rt-rw-badges">
                    <span class="rt-rw-badge">RT {{ $kk->rt }}</span>
                    <span class="rt-rw-badge">RW {{ $kk->rw }}</span>
                </div>
            </div>

            <!-- Detail Sections -->
            <!-- Section 1: Identitas -->
            <div class="detail-section">
                <h4 class="section-title">
                    <div class="section-icon">
                        <i class="bi bi-card-text"></i>
                    </div>
                    Identitas Kartu Keluarga
                </h4>

                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="bi bi-hash"></i>
                            Nomor KK
                        </div>
                        <div class="detail-value large highlight">{{ $kk->no_kk }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="bi bi-house"></i>
                            Alamat
                        </div>
                        <div class="detail-value">{{ $kk->alamat }}</div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Lokasi Detail -->
            <div class="detail-section">
                <h4 class="section-title">
                    <div class="section-icon">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    Detail Lokasi
                </h4>

                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="bi bi-signpost"></i>
                            RT / RW
                        </div>
                        <div class="detail-value">{{ $kk->rt }} / {{ $kk->rw }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="bi bi-building"></i>
                            Desa/Kelurahan
                        </div>
                        <div class="detail-value">{{ $kk->desa }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="bi bi-signpost-2"></i>
                            Kecamatan
                        </div>
                        <div class="detail-value">{{ $kk->kecamatan }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="bi bi-buildings"></i>
                            Kabupaten/Kota
                        </div>
                        <div class="detail-value">{{ $kk->kabupaten }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="bi bi-map"></i>
                            Provinsi
                        </div>
                        <div class="detail-value">{{ $kk->provinsi }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="bi bi-mailbox"></i>
                            Kode Pos
                        </div>
                        <div class="detail-value">{{ $kk->kode_pos }}</div>
                    </div>
                </div>
            </div>

            <!-- Statistics Mini Cards -->
            <div class="detail-section">
                <h4 class="section-title">
                    <div class="section-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    Informasi Sistem
                </h4>

                <div class="stats-mini">
                    <div class="stat-mini-card">
                        <div class="stat-mini-icon created">
                            <i class="bi bi-plus-circle"></i>
                        </div>
                        <div class="stat-mini-label">Tanggal Dibuat</div>
                        <div class="stat-mini-value">{{ $kk->created_at->format('d M Y') }}</div>
                    </div>
                    <div class="stat-mini-card">
                        <div class="stat-mini-icon updated">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <div class="stat-mini-label">Terakhir Update</div>
                        <div class="stat-mini-value">{{ $kk->updated_at->format('d M Y') }}</div>
                    </div>
                    <div class="stat-mini-card">
                        <div class="stat-mini-icon created">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <div class="stat-mini-label">Usia Data</div>
                        <div class="stat-mini-value">{{ $kk->created_at->diffInDays(now()) }} hari</div>
                    </div>
                    <div class="stat-mini-card">
                        <div class="stat-mini-icon updated">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div class="stat-mini-label">Update Terakhir</div>
                        <div class="stat-mini-value">{{ $kk->updated_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>
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

                icon.className = 'bi bi-check';
                button.classList.add('copy-success');
                button.title = 'Tersalin!';

                // Show temporary success message
                const toast = document.createElement('div');
                toast.textContent = 'Berhasil disalin ke clipboard!';
                toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #28a745;
                color: white;
                padding: 10px 20px;
                border-radius: 8px;
                z-index: 9999;
                font-size: 0.9rem;
                font-weight: 600;
                box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
                animation: slideIn 0.3s ease;
            `;

                document.body.appendChild(toast);

                // Reset after 2 seconds
                setTimeout(() => {
                    icon.className = originalClass;
                    button.classList.remove('copy-success');
                    button.title = 'Salin';
                    document.body.removeChild(toast);
                }, 2000);

            }).catch(function(err) {
                console.error('Failed to copy: ', err);
                alert('Gagal menyalin ke clipboard');
            });
        }

        // Add CSS for animation
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
    `;
        document.head.appendChild(style);

        // Print functionality
        function preparePrint() {
            // Add print-specific styles
            const printStyles = `
            @media print {
                .action-buttons { display: none !important; }
                .copy-btn { display: none !important; }
                body { -webkit-print-color-adjust: exact !important; }
                .detail-container { page-break-inside: avoid; }
            }
        `;

            const printStyle = document.createElement('style');
            printStyle.textContent = printStyles;
            document.head.appendChild(printStyle);
        }

        // Initialize print preparation
        document.addEventListener('DOMContentLoaded', function() {
            preparePrint();

            // Smooth scroll for long content
            document.querySelectorAll('.detail-item').forEach((item, index) => {
                item.style.animationDelay = `${index * 0.1}s`;
                item.style.animation = 'fadeInUp 0.6s ease forwards';
            });
        });

        // Add fade in animation
        const fadeStyle = document.createElement('style');
        fadeStyle.textContent = `
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
    `;
        document.head.appendChild(fadeStyle);
    </script>
@endpush
