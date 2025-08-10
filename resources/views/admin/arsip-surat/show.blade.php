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
        }

        .detail-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: white;
        }

        .detail-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 10px;
        }

        [data-theme="dark"] .detail-title {
            color: var(--light-green);
        }

        .detail-subtitle {
            color: var(--soft-gray);
            font-size: 1rem;
            margin-bottom: 0;
        }

        .arsip-info-badges {
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .arsip-info-badge {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            padding: 8px 16px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-block;
        }

        .category-badge {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            color: white;
            padding: 8px 16px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .status-badge {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 8px 16px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .detail-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.2rem;
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
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }

        .detail-field {
            margin-bottom: 20px;
            background: var(--cream);
            border-radius: 12px;
            padding: 15px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .field-label {
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 8px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        [data-theme="dark"] .field-label {
            color: var(--light-green);
        }

        .field-icon {
            width: 20px;
            height: 20px;
            border-radius: 5px;
            background: var(--primary-green);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.7rem;
        }

        .field-value {
            color: var(--soft-gray);
            font-size: 0.95rem;
            line-height: 1.5;
            min-height: 20px;
            word-wrap: break-word;
        }

        .empty-value {
            color: #adb5bd;
            font-style: italic;
        }

        /* Info Card */
        .info-card {
            background: linear-gradient(135deg, rgba(45, 80, 22, 0.1), rgba(255, 140, 66, 0.05));
            border: 1px solid rgba(45, 80, 22, 0.2);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .info-card .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--primary-green);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .info-card h6 {
            color: var(--primary-green);
            font-weight: 600;
            margin-bottom: 10px;
        }

        [data-theme="dark"] .info-card h6 {
            color: var(--light-green);
        }

        .info-card p {
            color: var(--soft-gray);
            margin-bottom: 0;
            font-size: 0.9rem;
            line-height: 1.5;
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
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            min-width: 120px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45, 80, 22, 0.3);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            min-width: 120px;
            color: white;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 140, 66, 0.3);
            color: white;
        }

        .btn-outline-secondary {
            color: var(--soft-gray);
            border: 2px solid var(--soft-gray);
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            background: transparent;
            transition: all 0.3s ease;
            min-width: 120px;
        }

        .btn-outline-secondary:hover {
            background: var(--soft-gray);
            border-color: var(--soft-gray);
            transform: translateY(-2px);
        }

        .btn-outline-danger {
            color: #dc3545;
            border: 2px solid #dc3545;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            background: transparent;
            transition: all 0.3s ease;
            min-width: 120px;
        }

        .btn-outline-danger:hover {
            background: #dc3545;
            border-color: #dc3545;
            color: white;
            transform: translateY(-2px);
        }

        /* Meta Information */
        .meta-info {
            background: rgba(255, 140, 66, 0.1);
            border: 1px solid rgba(255, 140, 66, 0.2);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .meta-info h6 {
            color: var(--accent-orange);
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .meta-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
        }

        .meta-item {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
        }

        .meta-label {
            color: var(--soft-gray);
            font-weight: 500;
        }

        .meta-value {
            color: var(--primary-green);
            font-weight: 600;
        }

        [data-theme="dark"] .meta-value {
            color: var(--light-green);
        }

        /* Timeline */
        .timeline {
            background: var(--cream);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .timeline-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 10px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .timeline-item:last-child {
            border-bottom: none;
        }

        .timeline-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: var(--primary-green);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.8rem;
        }

        .timeline-content {
            flex: 1;
        }

        .timeline-title {
            font-weight: 600;
            color: var(--primary-green);
            font-size: 0.9rem;
            margin-bottom: 2px;
        }

        [data-theme="dark"] .timeline-title {
            color: var(--light-green);
        }

        .timeline-time {
            color: var(--soft-gray);
            font-size: 0.8rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .detail-container {
                padding: 20px;
            }

            .detail-actions {
                flex-direction: column;
            }

            .arsip-info-badges {
                flex-direction: column;
                align-items: center;
            }

            .meta-info-grid {
                grid-template-columns: 1fr;
            }

            .detail-header {
                margin-bottom: 20px;
            }

            .detail-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
        }

        @media (max-width: 576px) {

            .btn-primary,
            .btn-warning,
            .btn-outline-secondary,
            .btn-outline-danger {
                width: 100%;
            }
        }

        /* Print Styles */
        @media print {

            .detail-actions,
            .page-header,
            .info-card {
                display: none;
            }

            .detail-container {
                box-shadow: none;
                border: 1px solid #000;
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
                    <li class="breadcrumb-item"><a href="{{ route('admin.arsip-surat.index') }}">Arsip Surat</a></li>
                    <li class="breadcrumb-item active">Detail Arsip</li>
                </ol>
            </nav>
            <h1 class="page-title">Detail Arsip Surat</h1>
            <p class="page-subtitle">Informasi lengkap data arsip surat</p>
        </div>

        <!-- Info Card -->
        <div class="info-card">
            <div class="info-icon">
                <i class="bi bi-info-lg"></i>
            </div>
            <h6>Informasi Detail</h6>
            <p>
                Halaman ini menampilkan informasi lengkap dari arsip surat.
                Anda dapat melakukan edit, hapus, atau kembali ke daftar arsip surat.
            </p>
        </div>

        <!-- Main Detail -->
        <div class="detail-container">
            <div class="detail-header">
                <div class="detail-icon">
                    <i class="bi bi-file-earmark-text-fill"></i>
                </div>
                <h2 class="detail-title">Detail Arsip Surat</h2>
                <div class="arsip-info-badges">
                    <span class="arsip-info-badge">{{ $arsipSurat->nomor_surat }}</span>
                    <span class="category-badge">
                        <i
                            class="bi bi-{{ $arsipSurat->kategori_surat === 'masuk' ? 'arrow-down-circle' : 'arrow-up-circle' }} me-1"></i>
                        Surat {{ ucfirst($arsipSurat->kategori_surat) }}
                    </span>
                    <span class="status-badge">
                        <i class="bi bi-check-circle me-1"></i>
                        Tersimpan
                    </span>
                </div>
                <p class="detail-subtitle">
                    Dibuat: {{ $arsipSurat->created_at->format('d/m/Y H:i') }} |
                    Diupdate: {{ $arsipSurat->updated_at->format('d/m/Y H:i') }}
                </p>
            </div>

            <!-- Meta Information -->
            <div class="meta-info">
                <h6><i class="bi bi-info-circle me-2"></i>Informasi Metadata</h6>
                <div class="meta-info-grid">
                    <div class="meta-item">
                        <span class="meta-label">ID Arsip:</span>
                        <span class="meta-value">#{{ $arsipSurat->id }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Kategori:</span>
                        <span class="meta-value">{{ ucfirst($arsipSurat->kategori_surat) }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Tahun:</span>
                        <span class="meta-value">{{ $arsipSurat->tanggal_surat->format('Y') }}</span>
                    </div>
                    <div class="meta-item">
                        <span class="meta-label">Bulan:</span>
                        <span class="meta-value">{{ $arsipSurat->tanggal_surat->format('F') }}</span>
                    </div>
                </div>
            </div>

            <!-- Section 1: Identitas Surat -->
            <div class="detail-section">
                <h4 class="section-title">
                    <div class="section-icon">
                        <i class="bi bi-card-heading"></i>
                    </div>
                    Identitas Surat
                </h4>

                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-field">
                            <div class="field-label">
                                <div class="field-icon">
                                    <i class="bi bi-hash"></i>
                                </div>
                                Nomor Surat
                            </div>
                            <div class="field-value">{{ $arsipSurat->nomor_surat }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-field">
                            <div class="field-label">
                                <div class="field-icon">
                                    <i class="bi bi-calendar3"></i>
                                </div>
                                Tanggal Surat
                            </div>
                            <div class="field-value">{{ $arsipSurat->tanggal_surat_formatted }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Detail Surat (Dynamic based on category) -->
            @if ($arsipSurat->kategori_surat === 'masuk')
                <!-- Surat Masuk Details -->
                <div class="detail-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-arrow-down-circle"></i>
                        </div>
                        Detail Surat Masuk
                    </h4>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-field">
                                <div class="field-label">
                                    <div class="field-icon">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    Pengirim
                                </div>
                                <div class="field-value">
                                    {{ $arsipSurat->pengirim ?: 'Tidak ada data' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="detail-field">
                                <div class="field-label">
                                    <div class="field-icon">
                                        <i class="bi bi-chat-text"></i>
                                    </div>
                                    Perihal
                                </div>
                                <div class="field-value">
                                    {{ $arsipSurat->perihal ?: 'Tidak ada data' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Surat Keluar Details -->
                <div class="detail-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-arrow-up-circle"></i>
                        </div>
                        Detail Surat Keluar
                    </h4>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-field">
                                <div class="field-label">
                                    <div class="field-icon">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>
                                    Tujuan Surat
                                </div>
                                <div class="field-value">
                                    {{ $arsipSurat->tujuan_surat ?: 'Tidak ada data' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="detail-field">
                                <div class="field-label">
                                    <div class="field-icon">
                                        <i class="bi bi-file-text"></i>
                                    </div>
                                    Tentang
                                </div>
                                <div class="field-value">
                                    {{ $arsipSurat->tentang ?: 'Tidak ada data' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Section 3: Informasi Tambahan -->
            <div class="detail-section">
                <h4 class="section-title">
                    <div class="section-icon">
                        <i class="bi bi-chat-text"></i>
                    </div>
                    Informasi Tambahan
                </h4>

                <div class="row">
                    <div class="col-md-12">
                        <div class="detail-field">
                            <div class="field-label">
                                <div class="field-icon">
                                    <i class="bi bi-sticky"></i>
                                </div>
                                Keterangan
                            </div>
                            <div class="field-value {{ !$arsipSurat->keterangan ? 'empty-value' : '' }}">
                                {{ $arsipSurat->keterangan ?: 'Tidak ada keterangan tambahan' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="detail-section">
                <h4 class="section-title">
                    <div class="section-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    Riwayat Data
                </h4>

                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-icon">
                            <i class="bi bi-plus"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-title">Data Dibuat</div>
                            <div class="timeline-time">{{ $arsipSurat->created_at->format('d/m/Y H:i:s') }}</div>
                        </div>
                    </div>
                    @if ($arsipSurat->created_at != $arsipSurat->updated_at)
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="bi bi-pencil"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-title">Terakhir Diupdate</div>
                                <div class="timeline-time">{{ $arsipSurat->updated_at->format('d/m/Y H:i:s') }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="detail-actions">
                <a href="{{ route('admin.arsip-surat.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
                <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="bi bi-printer me-2"></i>Cetak
                </button>
                <a href="{{ route('admin.arsip-surat.edit', $arsipSurat->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square me-2"></i>Edit
                </a>
                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                    <i class="bi bi-trash me-2"></i>Hapus
                </button>
            </div>

            <!-- Hidden Delete Form -->
            <form id="deleteForm" action="{{ route('admin.arsip-surat.destroy', $arsipSurat->id) }}" method="POST"
                style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth section animations
            const sections = document.querySelectorAll('.detail-section');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1
            });

            sections.forEach(section => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(20px)';
                section.style.transition = 'all 0.6s ease';
                observer.observe(section);
            });

            // Show sections with staggered animation
            setTimeout(() => {
                sections.forEach((section, index) => {
                    setTimeout(() => {
                        section.style.opacity = '1';
                        section.style.transform = 'translateY(0)';
                    }, index * 200);
                });
            }, 100);

            // Add hover effects to detail fields
            const detailFields = document.querySelectorAll('.detail-field');
            detailFields.forEach(field => {
                field.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 3px 10px rgba(0, 0, 0, 0.1)';
                });

                field.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'none';
                });
            });

            // Copy to clipboard functionality
            const copyableFields = document.querySelectorAll('.field-value');
            copyableFields.forEach(field => {
                field.addEventListener('click', function() {
                    const text = this.textContent.trim();
                    if (text && text !== 'Tidak ada data' && text !==
                        'Tidak ada keterangan tambahan') {
                        navigator.clipboard.writeText(text).then(() => {
                            showToast('Teks berhasil disalin ke clipboard');
                        });
                    }
                });

                field.style.cursor = 'pointer';
                field.title = 'Klik untuk menyalin';
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // E for Edit
                if (e.key === 'e' || e.key === 'E') {
                    e.preventDefault();
                    window.location.href = '{{ route('admin.arsip-surat.edit', $arsipSurat->id) }}';
                }

                // P for Print
                if (e.key === 'p' || e.key === 'P') {
                    e.preventDefault();
                    window.print();
                }

                // Escape to go back
                if (e.key === 'Escape') {
                    window.location.href = '{{ route('admin.arsip-surat.index') }}';
                }
            });
        });

        // Delete confirmation
        function confirmDelete() {
            if (confirm(
                    'Apakah Anda yakin ingin menghapus arsip surat ini?\n\nData yang sudah dihapus tidak dapat dikembalikan.'
                )) {
                document.getElementById('deleteForm').submit();
            }
        }

        // Toast notification helper
        function showToast(message) {
            // Create toast element
            const toast = document.createElement('div');
            toast.className = 'toast-notification';
            toast.innerHTML = `
                <div style="
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: var(--primary-green);
                    color: white;
                    padding: 12px 20px;
                    border-radius: 8px;
                    box-shadow: 0 3px 10px rgba(0,0,0,0.2);
                    z-index: 9999;
                    font-size: 0.9rem;
                    font-weight: 500;
                ">
                    <i class="bi bi-check-circle me-2"></i>${message}
                </div>
            `;

            document.body.appendChild(toast);

            // Remove toast after 3 seconds
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Enhanced print functionality
        function enhancedPrint() {
            const printWindow = window.open('', '_blank');
            const printContent = document.querySelector('.detail-container').innerHTML;

            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Detail Arsip Surat - ${document.querySelector('.arsip-info-badge').textContent}</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        .detail-actions { display: none; }
                        .info-card { display: none; }
                        .section-title { border-bottom: 2px solid #333; padding-bottom: 5px; }
                        .detail-field { margin-bottom: 15px; padding: 10px; border: 1px solid #ddd; }
                        .field-label { font-weight: bold; color: #333; }
                        .field-value { color: #666; margin-top: 5px; }
                    </style>
                </head>
                <body>
                    ${printContent}
                </body>
                </html>
            `);

            printWindow.document.close();
            printWindow.print();
        }
    </script>
@endpush
