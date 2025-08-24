@extends('layouts.main')

@push('style')
    {{-- Gaya CSS dari file detail berita, pastikan CSS yang sama disertakan --}}
    <style>
        /* Detail Container Styles */
        .detail-container {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .detail-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--cream);
        }

        .status-badges {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .status-published {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .status-draft {
            background: rgba(255, 140, 66, 0.1);
            color: var(--accent-orange);
            border: 1px solid rgba(255, 140, 66, 0.3);
        }

        .status-archived {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
            border: 1px solid rgba(108, 117, 125, 0.3);
        }

        .featured-badge {
            background: linear-gradient(135deg, #ffc107, #ffb300);
            color: white;
            border: none;
        }

        .detail-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 15px;
            line-height: 1.3;
        }

        [data-theme="dark"] .detail-title {
            color: var(--light-green);
        }

        .detail-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            background: var(--cream);
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .meta-icon {
            width: 35px;
            height: 35px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .meta-content {
            flex: 1;
            min-width: 0;
        }

        .meta-label {
            font-size: 0.8rem;
            color: var(--soft-gray);
            margin-bottom: 2px;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .meta-value {
            font-weight: 600;
            color: var(--primary-green);
            word-wrap: break-word;
        }

        [data-theme="dark"] .meta-value {
            color: var(--light-green);
        }

        /* Content Sections */
        .content-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--cream);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        [data-theme="dark"] .section-title {
            color: var(--light-green);
        }

        .section-icon {
            width: 35px;
            height: 35px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }

        /* Image Display */
        .featured-image {
            width: 100%;
            max-height: 400px;
            object-fit: contain;
            /* Menggunakan contain agar tidak terpotong */
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 15px;
            background-color: var(--cream);
        }

        .no-image {
            background: var(--cream);
            border: 2px dashed rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            padding: 60px 20px;
            text-align: center;
            color: var(--soft-gray);
            margin-bottom: 20px;
        }

        .no-image i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        /* Content Display */
        .content-display {
            background: var(--cream);
            border-radius: 15px;
            padding: 25px;
            line-height: 1.8;
            font-size: 1rem;
            color: inherit;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .content-display p {
            margin-bottom: 15px;
        }

        .content-display p:last-child {
            margin-bottom: 0;
        }

        .content-display h1,
        .content-display h2,
        .content-display h3 {
            color: var(--primary-green);
            margin-top: 25px;
            margin-bottom: 15px;
        }

        [data-theme="dark"] .content-display h1,
        [data-theme="dark"] .content-display h2,
        [data-theme="dark"] .content-display h3 {
            color: var(--light-green);
        }

        /* Tags Display */
        .tags-display {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .tag-item {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .no-tags {
            color: var(--soft-gray);
            font-style: italic;
            padding: 10px 0;
        }

        /* Category Display */
        .category-display {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .category-display:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            color: white;
        }

        /* Action Buttons */
        .detail-actions {
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
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: white;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 140, 66, 0.3);
            color: white;
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
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
            transform: translateY(-2px);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #e74c3c);
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: white;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
            color: white;
        }

        .btn-info {
            background: linear-gradient(135deg, #17a2b8, #138496);
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: white;
        }

        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(23, 162, 184, 0.3);
            color: white;
        }

        /* Stats grid for apbdes */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: var(--warm-white);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: white;
            margin: 0 auto 10px;
        }

        .stat-icon.anggaran {
            background: linear-gradient(135deg, #20c997, #28a745);
        }

        .stat-icon.dokumen {
            background: linear-gradient(135deg, #17a2b8, #138496);
        }

        .stat-icon.baliho {
            background: linear-gradient(135deg, #6f42c1, #6610f2);
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 5px;
        }

        [data-theme="dark"] .stat-number {
            color: var(--light-green);
        }

        .stat-label {
            color: var(--soft-gray);
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .detail-container {
                padding: 20px;
            }

            .detail-title {
                font-size: 1.5rem;
            }

            .detail-meta {
                grid-template-columns: 1fr;
            }

            .detail-actions {
                flex-direction: column;
            }

            .btn-primary,
            .btn-warning,
            .btn-success,
            .btn-outline-secondary,
            .btn-danger,
            .btn-info {
                width: 100%;
                justify-content: center;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .status-badges {
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .detail-actions {
                padding: 15px;
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
                    <li class="breadcrumb-item"><a href="{{ route('admin.apbdes.index') }}">Kelola APBDes</a></li>
                    <li class="breadcrumb-item active">Detail APBDes</li>
                </ol>
            </nav>
            <h1 class="page-title">Detail APBDes Tahun {{ $apbdes->tahun }}</h1>
            <p class="page-subtitle">Informasi lengkap Anggaran Pendapatan dan Belanja Desa (APBDes).</p>
        </div>

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

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon anggaran">
                    <i class="bi bi-wallet"></i>
                </div>
                <div class="stat-number">
                    {{ $apbdes->total_anggaran_formatted }}
                </div>
                <div class="stat-label">Total Anggaran</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon dokumen">
                    <i class="bi bi-file-pdf"></i>
                </div>
                <div class="stat-number">
                    {{ $apbdes->pdf_dokumen ? '✓ Ada' : '✗ Tidak Ada' }}
                </div>
                <div class="stat-label">Dokumen PDF</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon baliho">
                    <i class="bi bi-image"></i>
                </div>
                <div class="stat-number">
                    {{ $apbdes->baliho_image ? '✓ Ada' : '✗ Tidak Ada' }}
                </div>
                <div class="stat-label">Gambar Baliho</div>
            </div>
        </div>

        <div class="detail-container">
            <div class="detail-header">
                <h1 class="detail-title">APBDes Tahun {{ $apbdes->tahun }}</h1>
                <div class="detail-meta">
                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                        <div class="meta-content">
                            <div class="meta-label">Dibuat</div>
                            <div class="meta-value">{{ $apbdes->created_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-icon">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <div class="meta-content">
                            <div class="meta-label">Terakhir Update</div>
                            <div class="meta-value">{{ $apbdes->updated_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-section">
                <h3 class="section-title">
                    <div class="section-icon">
                        <i class="bi bi-pie-chart"></i>
                    </div>
                    Rincian Anggaran
                </h3>
                <div class="row g-3">
                    <div class="col-md-6 col-lg-4">
                        <div class="meta-item">
                            <div class="meta-content">
                                <div class="meta-label">Pemerintahan Desa</div>
                                <div class="meta-value">{{ $apbdes->pemerintahan_desa_formatted }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="meta-item">
                            <div class="meta-content">
                                <div class="meta-label">Pembangunan Desa</div>
                                <div class="meta-value">{{ $apbdes->pembangunan_desa_formatted }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="meta-item">
                            <div class="meta-content">
                                <div class="meta-label">Pembinaan Kemasyarakatan</div>
                                <div class="meta-value">{{ $apbdes->kemasyarakatan_formatted }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="meta-item">
                            <div class="meta-content">
                                <div class="meta-label">Pemberdayaan Masyarakat</div>
                                <div class="meta-value">{{ $apbdes->pemberdayaan_formatted }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="meta-item">
                            <div class="meta-content">
                                <div class="meta-label">Bencana, Darurat & Mendesak</div>
                                <div class="meta-value">{{ $apbdes->bencana_darurat_formatted }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-section">
                <h3 class="section-title">
                    <div class="section-icon">
                        <i class="bi bi-file-earmark-arrow-down"></i>
                    </div>
                    File Dokumen & Gambar
                </h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="meta-item">
                            <div class="meta-icon" style="background: #17a2b8;">
                                <i class="bi bi-file-pdf"></i>
                            </div>
                            <div class="meta-content">
                                <div class="meta-label">Dokumen PDF APBDes</div>
                                <div class="meta-value">
                                    @if ($apbdes->pdf_dokumen)
                                        <a href="{{ route('admin.apbdes.download.pdf', $apbdes) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="bi bi-download me-1"></i> Unduh PDF
                                        </a>
                                    @else
                                        <span class="text-warning">Belum ada dokumen PDF</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="meta-item">
                            <div class="meta-icon" style="background: #6f42c1;">
                                <i class="bi bi-image"></i>
                            </div>
                            <div class="meta-content">
                                <div class="meta-label">Gambar Baliho APBDes</div>
                                <div class="meta-value">
                                    @if ($apbdes->baliho_image)
                                        <a href="{{ Storage::url($apbdes->baliho_image) }}" target="_blank"
                                            class="btn btn-primary btn-sm">
                                            <i class="bi bi-eye me-1"></i> Lihat Gambar
                                        </a>
                                    @else
                                        <span class="text-warning">Belum ada gambar baliho</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-section">
                <h3 class="section-title">
                    <div class="section-icon">
                        <i class="bi bi-image"></i>
                    </div>
                    Pratinjau Gambar Baliho
                </h3>
                @if ($apbdes->baliho_image)
                    <img src="{{ Storage::url($apbdes->baliho_image) }}" alt="Baliho APBDes Tahun {{ $apbdes->tahun }}"
                        class="featured-image">
                @else
                    <div class="no-image">
                        <i class="bi bi-image"></i>
                        <h5>Tidak ada gambar baliho</h5>
                        <p>Gambar baliho untuk APBDes tahun ini belum diunggah.</p>
                    </div>
                @endif
            </div>

            <div class="detail-actions">
                <a href="{{ route('admin.apbdes.edit', $apbdes->tahun) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i>
                    Edit APBDes
                </a>

                <form action="{{ route('admin.apbdes.destroy', $apbdes->tahun) }}" method="POST"
                    style="display: inline;"
                    onsubmit="return confirm('Yakin ingin menghapus data APBDes ini? Tindakan ini tidak dapat dibatalkan dan akan menghapus semua file terkait!')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i>
                        Hapus APBDes
                    </button>
                </form>

                <a href="{{ route('admin.apbdes.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide alerts
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // Enhanced form submissions
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn && !submitBtn.disabled) {
                        setTimeout(() => {
                            submitBtn.disabled = true;
                            submitBtn.innerHTML =
                                '<i class="bi bi-hourglass-split"></i> Processing...';
                        }, 50);
                    }
                });
            });

            // Animate cards on load
            animateCards();
        });

        function animateCards() {
            const cards = document.querySelectorAll('.detail-container, .stat-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        }
    </script>
@endpush
