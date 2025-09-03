@extends('template.main')

@section('title', 'Layanan Surat Online - ' . config('app.village_name', 'Desa Kilwaru'))
@section('description',
    'Pilih jenis surat yang ingin Anda ajukan secara online di ' .
    config(
    'app.village_name',
    'Desa
    Kilwaru',
    ))

    @push('styles')
        <style>
            .surat-hero {
                background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 89, 0.8)),
                    url('https://images.unsplash.com/photo-1586953208448-b95a79798f07?ixlib=rb-4.0.3') center/cover;
                color: white;
                padding: 100px 0 50px;
                margin-top: -80px;
                padding-top: 160px;
            }

            .surat-card {
                background: white;
                border-radius: 20px;
                padding: 30px;
                text-align: center;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
                height: 100%;
                border: none;
                position: relative;
                overflow: hidden;
            }

            .surat-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                background: linear-gradient(135deg, var(--primary-green), var(--accent-orange));
                transform: scaleX(0);
                transition: transform 0.3s ease;
            }

            .surat-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            }

            .surat-card:hover::before {
                transform: scaleX(1);
            }

            .surat-icon {
                width: 80px;
                height: 80px;
                background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
                color: white;
                border-radius: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2rem;
                margin: 0 auto 25px;
                transition: all 0.3s ease;
                position: relative;
            }

            .surat-card:hover .surat-icon {
                transform: scale(1.1) rotate(5deg);
                background: linear-gradient(135deg, var(--accent-orange), #ff6b1a);
            }

            .btn-surat {
                background: var(--primary-green);
                border: none;
                border-radius: 50px;
                padding: 12px 30px;
                font-weight: 600;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(45, 80, 22, 0.3);
                width: 100%;
                margin-top: 20px;
            }

            .btn-surat:hover {
                background: var(--secondary-green);
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(45, 80, 22, 0.4);
            }

            .btn-surat:disabled {
                background: #6c757d;
                cursor: not-allowed;
                transform: none;
                box-shadow: none;
            }

            .badge-status {
                position: absolute;
                top: 15px;
                right: 15px;
                padding: 5px 12px;
                border-radius: 15px;
                font-size: 0.75rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .badge-available {
                background: #d4edda;
                color: #155724;
            }

            .badge-coming-soon {
                background: #fff3cd;
                color: #856404;
            }

            .badge-maintenance {
                background: #f8d7da;
                color: #721c24;
            }

            .info-section {
                background: var(--cream);
                padding: 80px 0;
            }

            .info-card {
                background: white;
                border-radius: 15px;
                padding: 30px;
                text-align: center;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
                margin-bottom: 30px;
                transition: all 0.3s ease;
            }

            .info-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
            }

            .info-icon {
                width: 60px;
                height: 60px;
                background: var(--light-green);
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                margin: 0 auto 20px;
            }

            .process-step {
                background: white;
                border-radius: 15px;
                padding: 25px;
                text-align: center;
                margin-bottom: 20px;
                position: relative;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            }

            .step-number {
                width: 50px;
                height: 50px;
                background: var(--accent-orange);
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                font-size: 1.2rem;
                margin: 0 auto 15px;
                position: relative;
                z-index: 2;
            }

            .process-step:not(:last-child)::after {
                content: '';
                position: absolute;
                bottom: -10px;
                left: 50%;
                transform: translateX(-50%);
                width: 2px;
                height: 20px;
                background: var(--light-green);
                z-index: 1;
            }

            .category-section {
                margin-bottom: 50px;
            }

            .category-title {
                color: var(--primary-green);
                font-weight: 700;
                margin-bottom: 30px;
                position: relative;
                padding-left: 20px;
            }

            .category-title::before {
                content: '';
                position: absolute;
                left: 0;
                top: 50%;
                transform: translateY(-50%);
                width: 4px;
                height: 100%;
                background: var(--accent-orange);
                border-radius: 2px;
            }

            .stats-counter {
                text-align: center;
                padding: 20px;
            }

            .stat-number {
                font-size: 2.5rem;
                font-weight: 700;
                color: var(--primary-green);
                display: block;
            }

            .stat-label {
                color: var(--soft-gray);
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 1px;
                font-size: 0.9rem;
            }

            @media (max-width: 768px) {
                .surat-hero {
                    padding: 80px 0 40px;
                    padding-top: 140px;
                }

                .surat-card {
                    padding: 25px 20px;
                    margin-bottom: 20px;
                }

                .surat-icon {
                    width: 60px;
                    height: 60px;
                    font-size: 1.5rem;
                    margin-bottom: 20px;
                }

                .info-section {
                    padding: 60px 0;
                }

                .category-title {
                    font-size: 1.5rem;
                }

                .btn-surat {
                    padding: 10px 25px;
                    font-size: 0.9rem;
                }
            }
        </style>
    @endpush

@section('content')
    <!-- Hero Section -->
    <section class="surat-hero">
        <div class="container">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-4 hero-animation">Layanan Surat Online</h1>
                <p class="lead hero-animation">Pilih jenis surat yang ingin Anda ajukan secara online dengan mudah dan cepat
                </p>
                <div class="mt-4">
                    <small class="text-white-50">
                        <i class="bi bi-clock me-2"></i>
                        Layanan tersedia 24/7 • Proses cepat dan aman
                    </small>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stats-counter fade-in">
                        <span class="stat-number" data-target="245">0</span>
                        <div class="stat-label">Total Pengajuan</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stats-counter fade-in">
                        <span class="stat-number" data-target="198">0</span>
                        <div class="stat-label">Surat Disetujui</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stats-counter fade-in">
                        <span class="stat-number" data-target="32">0</span>
                        <div class="stat-label">Sedang Diproses</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stats-counter fade-in">
                        <span class="stat-number" data-target="2">0</span>
                        <div class="stat-label">Hari Rata-rata</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <!-- Surat Keterangan -->
            <div class="category-section fade-in">
                <h2 class="category-title">Surat Keterangan</h2>
                <div class="row">
                    <!-- SKTM -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="surat-card">
                            <span class="badge-status badge-available">Tersedia</span>
                            <div class="surat-icon">
                                <i class="bi bi-file-earmark-check"></i>
                            </div>
                            <h4 class="mb-3">Surat Keterangan Tidak Mampu</h4>
                            <p class="text-muted mb-4">
                                Surat keterangan untuk menyatakan kondisi ekonomi kurang mampu.
                                Digunakan untuk beasiswa, bantuan sosial, atau keringanan biaya.
                            </p>
                            <div class="mb-3">
                                <small class="text-success">
                                    <i class="bi bi-clock me-1"></i>
                                    Proses: 1-2 hari kerja
                                </small>
                            </div>
                            <a href="{{ route('public.surat-ktm.index') }}" class="btn btn-surat text-white">
                                <i class="bi bi-arrow-right me-2"></i>
                                Ajukan Sekarang
                            </a>
                        </div>
                    </div>

                    <!-- Surat Keterangan Domisili -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="surat-card">
                            <span class="badge-status badge-coming-soon">Segera Hadir</span>
                            <div class="surat-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <h4 class="mb-3">Surat Keterangan Domisili</h4>
                            <p class="text-muted mb-4">
                                Surat keterangan tempat tinggal/domisili.
                                Digunakan untuk keperluan administrasi, pekerjaan, atau pendidikan.
                            </p>
                            <div class="mb-3">
                                <small class="text-warning">
                                    <i class="bi bi-tools me-1"></i>
                                    Dalam pengembangan
                                </small>
                            </div>
                            <button class="btn btn-surat text-white" disabled>
                                <i class="bi bi-clock me-2"></i>
                                Segera Hadir
                            </button>
                        </div>
                    </div>

                    <!-- Surat Keterangan Usaha -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="surat-card">
                            <span class="badge-status badge-available">Tersedia</span>
                            <div class="surat-icon">
                                <i class="bi bi-shop"></i>
                            </div>
                            <h4 class="mb-3">Surat Keterangan Tempat Usaha</h4>
                            <p class="text-muted mb-4">
                                Surat keterangan untuk pelaku usaha/UMKM.
                                Digunakan untuk pengajuan kredit, perizinan, atau bantuan modal.
                            </p>
                            <div class="mb-3">
                                <small class="text-success">
                                    <i class="bi bi-clock me-1"></i>
                                    Proses: 1-2 hari kerja
                                </small>
                            </div>
                            <a href="{{ route('public.surat-ktu.index') }}" class="btn btn-surat text-white">
                                <i class="bi bi-arrow-right me-2"></i>
                                Ajukan Sekarang
                            </a>
                        </div>
                    </div>
                    <!-- Surat Keterangan Penghasilan Tetap -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="surat-card">
                            <span class="badge-status badge-available">Tersedia</span>
                            <div class="surat-icon">
                                <i class="fas fa-money"></i>
                            </div>
                            <h4 class="mb-3">Surat Keterangan Penghasilan Tetap</h4>
                            <p class="text-muted mb-4">
                                Surat keterangan untuk menyatakan Penghasilan tetap.
                                Digunakan untuk pengajuan beasiswa, bantuan, atau modal.
                            </p>
                            <div class="mb-3">
                                <small class="text-success">
                                    <i class="bi bi-clock me-1"></i>
                                    Proses: 1-2 hari kerja
                                </small>
                            </div>
                            <a href="{{ route('public.surat-kpt.index') }}" class="btn btn-surat text-white">
                                <i class="bi bi-arrow-right me-2"></i>
                                Ajukan Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Surat Pengantar -->
            <div class="category-section fade-in">
                <h2 class="category-title">Surat Pengantar</h2>
                <div class="row">
                    <!-- Surat Pengantar Umum -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="surat-card">
                            <span class="badge-status badge-coming-soon">Segera Hadir</span>
                            <div class="surat-icon">
                                <i class="bi bi-envelope-paper"></i>
                            </div>
                            <h4 class="mb-3">Surat Pengantar RT/RW</h4>
                            <p class="text-muted mb-4">
                                Surat pengantar untuk berbagai keperluan administrasi
                                dari tingkat RT/RW ke instansi terkait.
                            </p>
                            <div class="mb-3">
                                <small class="text-warning">
                                    <i class="bi bi-tools me-1"></i>
                                    Dalam pengembangan
                                </small>
                            </div>
                            <button class="btn btn-surat text-white" disabled>
                                <i class="bi bi-clock me-2"></i>
                                Segera Hadir
                            </button>
                        </div>
                    </div>

                    <!-- Surat Pengantar Nikah -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="surat-card">
                            <span class="badge-status badge-coming-soon">Segera Hadir</span>
                            <div class="surat-icon">
                                <i class="bi bi-heart"></i>
                            </div>
                            <h4 class="mb-3">Surat Pengantar Nikah</h4>
                            <p class="text-muted mb-4">
                                Surat pengantar untuk keperluan pernikahan
                                ke KUA atau instansi terkait.
                            </p>
                            <div class="mb-3">
                                <small class="text-warning">
                                    <i class="bi bi-tools me-1"></i>
                                    Dalam pengembangan
                                </small>
                            </div>
                            <button class="btn btn-surat text-white" disabled>
                                <i class="bi bi-clock me-2"></i>
                                Segera Hadir
                            </button>
                        </div>
                    </div>

                    <!-- Surat Pengantar Pindah -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="surat-card">
                            <span class="badge-status badge-coming-soon">Segera Hadir</span>
                            <div class="surat-icon">
                                <i class="bi bi-truck"></i>
                            </div>
                            <h4 class="mb-3">Surat Pengantar Pindah</h4>
                            <p class="text-muted mb-4">
                                Surat pengantar untuk keperluan pindah domisili
                                atau mutasi tempat tinggal.
                            </p>
                            <div class="mb-3">
                                <small class="text-warning">
                                    <i class="bi bi-tools me-1"></i>
                                    Dalam pengembangan
                                </small>
                            </div>
                            <button class="btn btn-surat text-white" disabled>
                                <i class="bi bi-clock me-2"></i>
                                Segera Hadir
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Surat Kependudukan -->
            <div class="category-section fade-in">
                <h2 class="category-title">Surat Kependudukan</h2>
                <div class="row">
                    <!-- Surat Keterangan Lahir -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="surat-card">
                            <span class="badge-status badge-coming-soon">Segera Hadir</span>
                            <div class="surat-icon">
                                <i class="bi bi-person-plus"></i>
                            </div>
                            <h4 class="mb-3">Surat Keterangan Lahir</h4>
                            <p class="text-muted mb-4">
                                Surat keterangan kelahiran untuk keperluan
                                pembuatan akta kelahiran di Disdukcapil.
                            </p>
                            <div class="mb-3">
                                <small class="text-warning">
                                    <i class="bi bi-tools me-1"></i>
                                    Dalam pengembangan
                                </small>
                            </div>
                            <button class="btn btn-surat text-white" disabled>
                                <i class="bi bi-clock me-2"></i>
                                Segera Hadir
                            </button>
                        </div>
                    </div>

                    <!-- Surat Keterangan Meninggal -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="surat-card">
                            <span class="badge-status badge-coming-soon">Segera Hadir</span>
                            <div class="surat-icon">
                                <i class="bi bi-person-x"></i>
                            </div>
                            <h4 class="mb-3">Surat Keterangan Meninggal</h4>
                            <p class="text-muted mb-4">
                                Surat keterangan kematian untuk keperluan
                                administrasi dan pengurusan akta kematian.
                            </p>
                            <div class="mb-3">
                                <small class="text-warning">
                                    <i class="bi bi-tools me-1"></i>
                                    Dalam pengembangan
                                </small>
                            </div>
                            <button class="btn btn-surat text-white" disabled>
                                <i class="bi bi-clock me-2"></i>
                                Segera Hadir
                            </button>
                        </div>
                    </div>

                    <!-- Legalisir KK -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="surat-card">
                            <span class="badge-status badge-coming-soon">Segera Hadir</span>
                            <div class="surat-icon">
                                <i class="bi bi-patch-check"></i>
                            </div>
                            <h4 class="mb-3">Legalisir Kartu Keluarga</h4>
                            <p class="text-muted mb-4">
                                Layanan legalisir fotocopy Kartu Keluarga
                                untuk berbagai keperluan administrasi.
                            </p>
                            <div class="mb-3">
                                <small class="text-warning">
                                    <i class="bi bi-tools me-1"></i>
                                    Dalam pengembangan
                                </small>
                            </div>
                            <button class="btn btn-surat text-white" disabled>
                                <i class="bi bi-clock me-2"></i>
                                Segera Hadir
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Information Section -->
    <section class="info-section">
        <div class="container">
            <div class="row">
                <!-- Cara Penggunaan -->
                <div class="col-lg-6 mb-5">
                    <div class="text-center mb-4">
                        <h3 class="text-dark">Cara Menggunakan Layanan</h3>
                        <p class="text-muted">Ikuti langkah mudah berikut untuk mengajukan surat</p>
                    </div>

                    <div class="process-step">
                        <div class="step-number">1</div>
                        <h6 class="fw-bold">Pilih Jenis Surat</h6>
                        <p class="text-muted small mb-0">Pilih jenis surat yang ingin Anda ajukan dari daftar di atas</p>
                    </div>

                    <div class="process-step">
                        <div class="step-number">2</div>
                        <h6 class="fw-bold">Isi Formulir</h6>
                        <p class="text-muted small mb-0">Lengkapi formulir pengajuan dengan data yang akurat</p>
                    </div>

                    <div class="process-step">
                        <div class="step-number">3</div>
                        <h6 class="fw-bold">Submit Pengajuan</h6>
                        <p class="text-muted small mb-0">Kirim pengajuan dan dapatkan kode tracking untuk monitoring</p>
                    </div>

                    <div class="process-step">
                        <div class="step-number">4</div>
                        <h6 class="fw-bold">Download Surat</h6>
                        <p class="text-muted small mb-0">Unduh surat yang sudah disetujui atau ambil di kantor desa</p>
                    </div>
                </div>

                <!-- Informasi Penting -->
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <h5 class="mb-3">Keamanan Data</h5>
                                <p class="text-muted mb-0">
                                    Semua data yang Anda masukkan dijamin aman dan hanya digunakan
                                    untuk keperluan administrasi desa sesuai ketentuan yang berlaku.
                                </p>
                            </div>
                        </div>

                        <div class="col-12 mb-4">
                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <h5 class="mb-3">Jam Pelayanan</h5>
                                <div class="text-start">
                                    <p class="mb-2"><strong>Online:</strong> 24/7</p>
                                    <p class="mb-2"><strong>Offline:</strong> Senin - Jumat (08:00 - 15:00)</p>
                                    <p class="mb-0"><strong>Sabtu:</strong> 08:00 - 12:00</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-4">
                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="bi bi-headset"></i>
                                </div>
                                <h5 class="mb-3">Bantuan</h5>
                                <div class="text-start">
                                    <p class="mb-2">
                                        <i class="bi bi-telephone me-2 text-success"></i>
                                        (0123) 456-7890
                                    </p>
                                    <p class="mb-2">
                                        <i class="bi bi-whatsapp me-2 text-success"></i>
                                        +62 812-3456-7890
                                    </p>
                                    <p class="mb-0">
                                        <i class="bi bi-envelope me-2 text-info"></i>
                                        surat@desakilwaru.id
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Trigger counter animation when stats section becomes visible
            const statsSection = document.querySelector('.stats-section');
            const statsObserver = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounters();
                        statsObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.5
            });

            if (statsSection) {
                statsObserver.observe(statsSection);
            }

            // Add click tracking for analytics
            document.querySelectorAll('.btn-surat:not(:disabled)').forEach(button => {
                button.addEventListener('click', function(e) {
                    const suratType = this.closest('.surat-card').querySelector('h4').textContent;
                    console.log('Surat clicked:', suratType);

                    // Optional: Send analytics event
                    // gtag('event', 'surat_click', {
                    //     surat_type: suratType
                    // });
                });
            });

            // Show tooltip for disabled buttons
            document.querySelectorAll('.btn-surat:disabled').forEach(button => {
                button.setAttribute('title', 'Layanan ini sedang dalam pengembangan');
                button.style.cursor = 'not-allowed';
            });

            // Add smooth scroll for internal links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            console.log('Surat index page loaded successfully! 📋');
        });

        // Coming soon notification
        function showComingSoon(suratType) {
            alert(
                `Layanan ${suratType} sedang dalam pengembangan dan akan segera hadir. Terima kasih atas kesabaran Anda.`
            );
        }
    </script>
@endpush
