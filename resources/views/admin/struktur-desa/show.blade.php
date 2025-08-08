@extends('layouts.main')

@section('content')
    <div class="dashboard-content">
        <!-- Page Header -->
        <div class="page-header fade-in">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.struktur-desa.index') }}">Struktur Desa</a></li>
                    <li class="breadcrumb-item active">{{ $struktur_desa->nama }}</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h1 class="page-title">{{ $titleHeader }}</h1>
                    <p class="page-subtitle">Informasi lengkap pejabat desa</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.struktur-desa.edit', $struktur_desa) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit Data
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-three-dots"></i> Aksi Lainnya
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <form method="POST"
                                    action="{{ route('admin.struktur-desa.toggle-status', $struktur_desa) }}"
                                    style="display: inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        @if ($struktur_desa->aktif)
                                            <i class="bi bi-x-circle text-warning"></i> Nonaktifkan
                                        @else
                                            <i class="bi bi-check-circle text-success"></i> Aktifkan
                                        @endif
                                    </button>
                                </form>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('admin.struktur-desa.destroy', $struktur_desa) }}"
                                    onsubmit="return confirm('Yakin ingin menghapus pejabat ini?')"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    <a href="{{ route('admin.struktur-desa.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Main Detail Container -->
        <div class="detail-container fade-in">
            <!-- Detail Header with Photo and Basic Info -->
            <div class="detail-header">
                <div class="row align-items-center">
                    <div class="col-md-4 text-center">
                        <div class="detail-photo">
                            <img src="{{ $struktur_desa->image_url }}" alt="{{ $struktur_desa->nama }}"
                                class="profile-image">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="detail-info">
                            <h2 class="detail-name">{{ $struktur_desa->nama }}</h2>
                            <div class="detail-position">{{ $struktur_desa->posisi }}</div>
                            <div class="status-badges">
                                <span
                                    class="status-badge {{ $struktur_desa->aktif ? 'status-active' : 'status-inactive' }}">
                                    <i class="bi bi-{{ $struktur_desa->aktif ? 'check-circle' : 'x-circle' }}"></i>
                                    {{ $struktur_desa->status_jabatan }}
                                </span>
                                <span class="category-badge">
                                    <i class="bi bi-tag"></i>
                                    {{ $struktur_desa->kategori_display }}
                                </span>
                                @if ($struktur_desa->urutan)
                                    <span class="order-badge">
                                        <i class="bi bi-list-ol"></i>
                                        Urutan: {{ $struktur_desa->urutan }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 1: Data Personal -->
            <div class="detail-section slide-in">
                <h4 class="section-title">
                    <div class="section-icon">
                        <i class="bi bi-person-vcard"></i>
                    </div>
                    Data Personal
                </h4>
                <div class="detail-grid">
                    @if ($struktur_desa->nik)
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="bi bi-card-text"></i>
                                NIK
                            </div>
                            <div class="detail-value">{{ $struktur_desa->nik }}</div>
                        </div>
                    @endif
                    @if ($struktur_desa->nip)
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="bi bi-card-heading"></i>
                                NIP
                            </div>
                            <div class="detail-value">{{ $struktur_desa->nip }}</div>
                        </div>
                    @endif
                    @if ($struktur_desa->pendidikan_terakhir)
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="bi bi-mortarboard"></i>
                                Pendidikan Terakhir
                            </div>
                            <div class="detail-value">{{ $struktur_desa->pendidikan_terakhir }}</div>
                        </div>
                    @endif
                    @if ($struktur_desa->alamat)
                        <div class="detail-item span-full">
                            <div class="detail-label">
                                <i class="bi bi-geo-alt"></i>
                                Alamat
                            </div>
                            <div class="detail-value">{{ $struktur_desa->alamat }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Section 2: Kontak & Media Sosial -->
            <div class="detail-section slide-in">
                <h4 class="section-title">
                    <div class="section-icon">
                        <i class="bi bi-telephone"></i>
                    </div>
                    Kontak & Media Sosial
                </h4>
                <div class="detail-grid">
                    @if ($struktur_desa->telepon)
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="bi bi-telephone"></i>
                                Telepon
                            </div>
                            <div class="detail-value">
                                <a href="tel:{{ $struktur_desa->telepon }}" class="contact-link">
                                    {{ $struktur_desa->telepon }}
                                </a>
                            </div>
                        </div>
                    @endif
                    @if ($struktur_desa->email)
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="bi bi-envelope"></i>
                                Email
                            </div>
                            <div class="detail-value">
                                <a href="mailto:{{ $struktur_desa->email }}" class="contact-link">
                                    {{ $struktur_desa->email }}
                                </a>
                            </div>
                        </div>
                    @endif
                    @if ($struktur_desa->twitter)
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="bi bi-twitter"></i>
                                Twitter
                            </div>
                            <div class="detail-value">
                                <a href="{{ $struktur_desa->twitter }}" target="_blank" class="contact-link">
                                    {{ $struktur_desa->twitter }}
                                </a>
                            </div>
                        </div>
                    @endif
                    @if ($struktur_desa->facebook)
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="bi bi-facebook"></i>
                                Facebook
                            </div>
                            <div class="detail-value">
                                <a href="{{ $struktur_desa->facebook }}" target="_blank" class="contact-link">
                                    {{ $struktur_desa->facebook }}
                                </a>
                            </div>
                        </div>
                    @endif
                    @if ($struktur_desa->instagram)
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="bi bi-instagram"></i>
                                Instagram
                            </div>
                            <div class="detail-value">
                                <a href="{{ $struktur_desa->instagram }}" target="_blank" class="contact-link">
                                    {{ $struktur_desa->instagram }}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Section 3: Masa Jabatan -->
            <div class="detail-section slide-in">
                <h4 class="section-title">
                    <div class="section-icon">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                    Masa Jabatan
                </h4>
                <div class="detail-grid">
                    @if ($struktur_desa->mulai_menjabat)
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="bi bi-calendar-plus"></i>
                                Mulai Menjabat
                            </div>
                            <div class="detail-value">{{ $struktur_desa->mulai_menjabat->format('d F Y') }}</div>
                        </div>
                    @endif
                    @if ($struktur_desa->selesai_menjabat)
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="bi bi-calendar-minus"></i>
                                Selesai Menjabat
                            </div>
                            <div class="detail-value">{{ $struktur_desa->selesai_menjabat->format('d F Y') }}</div>
                        </div>
                    @endif
                    @if ($struktur_desa->masa_jabatan)
                        <div class="detail-item">
                            <div class="detail-label">
                                <i class="bi bi-clock"></i>
                                Lama Menjabat
                            </div>
                            <div class="detail-value">{{ $struktur_desa->masa_jabatan }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Section 4: Deskripsi/Bio -->
            @if ($struktur_desa->deskripsi)
                <div class="detail-section slide-in">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-file-text"></i>
                        </div>
                        Deskripsi
                    </h4>
                    <div class="description-content">
                        <p>{!! nl2br(e($struktur_desa->deskripsi)) !!}</p>
                    </div>
                </div>
            @endif

            <!-- Section 5: Informasi Sistem -->
            <div class="detail-section slide-in">
                <h4 class="section-title">
                    <div class="section-icon">
                        <i class="bi bi-info-circle"></i>
                    </div>
                    Informasi Sistem
                </h4>
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="bi bi-calendar-plus"></i>
                            Dibuat
                        </div>
                        <div class="detail-value">{{ $struktur_desa->created_at->format('d F Y - H:i') }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">
                            <i class="bi bi-pencil-square"></i>
                            Terakhir Diubah
                        </div>
                        <div class="detail-value">{{ $struktur_desa->updated_at->format('d F Y - H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // Add animations with delay
            document.addEventListener('DOMContentLoaded', function() {
                const sections = document.querySelectorAll('.detail-section');
                sections.forEach((section, index) => {
                    setTimeout(() => {
                        section.style.opacity = '0';
                        section.style.transform = 'translateX(-30px)';
                        section.style.transition = 'all 0.6s ease-out';
                        section.style.opacity = '1';
                        section.style.transform = 'translateX(0)';
                    }, index * 200);
                });
            });
        </script>
    @endpush

    @push('style')
        <style>
            .page-header {
                margin-bottom: 30px;
                padding-bottom: 20px;
                border-bottom: 2px solid var(--cream);
            }

            .breadcrumb {
                background: none;
                padding: 0;
                margin-bottom: 15px;
            }

            .breadcrumb-item a {
                color: var(--primary-green);
                text-decoration: none;
            }

            .breadcrumb-item.active {
                color: var(--soft-gray);
            }

            .page-title {
                font-size: 2rem;
                font-weight: 700;
                color: var(--primary-green);
                margin-bottom: 5px;
            }

            .page-subtitle {
                color: var(--soft-gray);
                margin-bottom: 0;
            }

            /* Detail Container Styles */
            .detail-container {
                background: var(--warm-white);
                border-radius: 20px;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
                overflow: hidden;
            }

            .detail-header {
                background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
                color: white;
                padding: 40px;
                position: relative;
                overflow: hidden;
            }

            .detail-header::before {
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                width: 200px;
                height: 200px;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
                transform: translate(50%, -50%);
            }

            .profile-image {
                width: 180px;
                height: 180px;
                border-radius: 20px;
                object-fit: cover;
                border: 5px solid rgba(255, 255, 255, 0.3);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            }

            .detail-name {
                font-size: 2.2rem;
                font-weight: 700;
                margin-bottom: 10px;
                text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            }

            .detail-position {
                font-size: 1.3rem;
                font-weight: 500;
                margin-bottom: 20px;
                opacity: 0.9;
            }

            .status-badges {
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
            }

            .status-badge,
            .category-badge,
            .order-badge {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 8px 15px;
                border-radius: 20px;
                font-size: 0.9rem;
                font-weight: 600;
                backdrop-filter: blur(10px);
            }

            .status-badge.status-active {
                background: rgba(40, 167, 69, 0.8);
                color: white;
            }

            .status-badge.status-inactive {
                background: rgba(108, 117, 125, 0.8);
                color: white;
            }

            .category-badge {
                background: rgba(255, 140, 66, 0.8);
                color: white;
            }

            .order-badge {
                background: rgba(255, 255, 255, 0.2);
                color: white;
            }

            /* Detail Sections */
            .detail-section {
                padding: 30px 40px;
                border-bottom: 1px solid var(--cream);
            }

            .detail-section:last-child {
                border-bottom: none;
            }

            .section-title {
                display: flex;
                align-items: center;
                gap: 15px;
                font-size: 1.4rem;
                font-weight: 600;
                color: var(--primary-green);
                margin-bottom: 25px;
            }

            .section-icon {
                width: 50px;
                height: 50px;
                background: linear-gradient(135deg, var(--light-green), var(--secondary-green));
                border-radius: 15px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.3rem;
            }

            .detail-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 25px;
            }

            .detail-item {
                background: var(--cream);
                padding: 20px;
                border-radius: 15px;
                transition: all 0.3s ease;
            }

            .detail-item:hover {
                transform: translateY(-3px);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }

            .detail-item.span-full {
                grid-column: 1 / -1;
            }

            .detail-label {
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 0.9rem;
                font-weight: 600;
                color: var(--soft-gray);
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin-bottom: 10px;
            }

            .detail-value {
                font-size: 1.1rem;
                font-weight: 500;
                color: var(--primary-green);
                word-break: break-word;
            }

            .contact-link {
                color: var(--accent-orange);
                text-decoration: none;
                transition: all 0.3s ease;
            }

            .contact-link:hover {
                color: var(--primary-green);
                text-decoration: underline;
            }

            .description-content {
                background: var(--cream);
                padding: 25px;
                border-radius: 15px;
                border-left: 4px solid var(--accent-orange);
            }

            .description-content p {
                font-size: 1.1rem;
                line-height: 1.7;
                color: var(--primary-green);
                margin: 0;
            }

            /* Animations */
            .fade-in {
                animation: fadeIn 0.8s ease-out;
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

            /* Dark Theme Support */
            [data-theme="dark"] .detail-container {
                background: var(--warm-white);
            }

            [data-theme="dark"] .page-title {
                color: var(--light-green);
            }

            [data-theme="dark"] .section-title {
                color: var(--light-green);
            }

            [data-theme="dark"] .detail-value {
                color: var(--light-green);
            }

            [data-theme="dark"] .description-content p {
                color: var(--light-green);
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .detail-header {
                    padding: 25px;
                }

                .detail-section {
                    padding: 20px 25px;
                }

                .profile-image {
                    width: 140px;
                    height: 140px;
                }

                .detail-name {
                    font-size: 1.8rem;
                }

                .detail-position {
                    font-size: 1.1rem;
                }

                .detail-grid {
                    grid-template-columns: 1fr;
                    gap: 15px;
                }

                .status-badges {
                    justify-content: center;
                    margin-top: 15px;
                }

                .page-header .d-flex {
                    flex-direction: column;
                    gap: 15px;
                }
            }

            /* Button Styles */
            .btn {
                border-radius: 10px;
                font-weight: 500;
                padding: 8px 16px;
                transition: all 0.3s ease;
            }

            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }

            .dropdown-menu {
                border-radius: 10px;
                border: none;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            }

            .dropdown-item {
                padding: 10px 15px;
                transition: all 0.3s ease;
            }

            .dropdown-item:hover {
                background: var(--cream);
                transform: translateX(5px);
            }
        </style>
    @endpush
@endsection
