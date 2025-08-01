@extends('template.main')

@section('title', 'Beranda - ' . config('app.village_name', 'Desa Kilwaru'))
@section('description',
    'Website resmi ' .
    config('app.village_name', 'Desa Kilwaru') .
    ' - Membangun masa depan yang
    lebih baik melalui transparansi, inovasi, dan pelayanan berkualitas')

    @push('head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush

@section('content')
    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="floating-elements"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content hero-animation">
                        <h1 class="display-4 fw-bold mb-4">
                            Selamat Datang di <span style="color: var(--accent-orange);">Desa Kilwaru</span>
                        </h1>
                        <p class="lead mb-4">
                            Membangun masa depan yang lebih baik melalui transparansi, inovasi, dan pelayanan yang
                            berkualitas untuk seluruh warga desa.
                        </p>
                        <div class="d-flex flex-column flex-sm-row gap-3">
                            <a href="#about" class="btn btn-primary btn-lg">
                                <i class="bi bi-arrow-right-circle me-2"></i>Jelajahi Desa
                            </a>
                            <a href="#contact" class="btn btn-outline-light btn-lg">
                                <i class="bi bi-envelope me-2"></i>Hubungi Kami
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <div
                            style="background: rgba(255,255,255,0.1); border-radius: 50%; padding: 60px; backdrop-filter: blur(10px);">
                            <i class="bi bi-geo-alt-fill" style="font-size: 8rem; color: var(--accent-orange);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="stat-item fade-in">
                        <span class="stat-number">2,847</span>
                        <span class="stat-label">Penduduk</span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item fade-in">
                        <span class="stat-number">847</span>
                        <span class="stat-label">Kepala Keluarga</span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item fade-in">
                        <span class="stat-number">15</span>
                        <span class="stat-label">Dusun</span>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-item fade-in">
                        <span class="stat-number">12</span>
                        <span class="stat-label">Layanan Publik</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="fade-in">
                        <h2 class="section-title">Tentang Desa Kilwaru</h2>
                        <p class="lead mb-4">
                            Desa Kilwaru adalah sebuah desa yang berkomitmen untuk memberikan pelayanan terbaik bagi
                            seluruh warganya melalui transparansi, inovasi, dan partisipasi aktif masyarakat.
                        </p>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill text-success me-3" style="font-size: 1.5rem;"></i>
                                    <span>Pelayanan 24/7</span>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill text-success me-3" style="font-size: 1.5rem;"></i>
                                    <span>Transparansi Penuh</span>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill text-success me-3" style="font-size: 1.5rem;"></i>
                                    <span>Digital Innovation</span>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill text-success me-3" style="font-size: 1.5rem;"></i>
                                    <span>Partisipasi Aktif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center fade-in">
                        <div class="card border-0 shadow-lg">
                            <div class="card-body p-5">
                                <i class="bi bi-people-fill" style="font-size: 4rem; color: var(--secondary-green);"></i>
                                <h4 class="mt-3 mb-3">Visi Desa</h4>
                                <p class="text-muted">
                                    "Menjadi desa yang mandiri, Kilwaru, dan berkelanjutan dengan memanfaatkan
                                    teknologi dan kearifan lokal untuk keKilwaruan bersama."
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Layanan Publik</h2>
                <p class="lead">Beragam layanan yang kami sediakan untuk kemudahan warga desa</p>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 fade-in">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <h5 class="card-title">Administrasi Kependudukan</h5>
                            <p class="card-text">Layanan pembuatan dan pengurusan dokumen kependudukan seperti KTP, KK,
                                dan akta kelahiran.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 fade-in">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="bi bi-briefcase"></i>
                            </div>
                            <h5 class="card-title">Surat Keterangan</h5>
                            <p class="card-text">Penerbitan berbagai surat keterangan seperti surat keterangan usaha,
                                domisili, dan lainnya.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 fade-in">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="bi bi-heart-pulse"></i>
                            </div>
                            <h5 class="card-title">Kesehatan</h5>
                            <p class="card-text">Pelayanan kesehatan dasar, posyandu, dan program kesehatan masyarakat
                                desa.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 fade-in">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="bi bi-book"></i>
                            </div>
                            <h5 class="card-title">Pendidikan</h5>
                            <p class="card-text">Program pendidikan dan pelatihan untuk meningkatkan kapasitas warga
                                desa.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 fade-in">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="bi bi-cash-coin"></i>
                            </div>
                            <h5 class="card-title">Bantuan Sosial</h5>
                            <p class="card-text">Program bantuan sosial dan pemberdayaan masyarakat untuk kesejahteraan
                                bersama.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 fade-in">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="bi bi-globe"></i>
                            </div>
                            <h5 class="card-title">Layanan Digital</h5>
                            <p class="card-text">Platform digital untuk memudahkan akses layanan dan informasi desa
                                secara online.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section id="news" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Berita Terkini</h2>
                <p class="lead">Informasi terbaru seputar kegiatan dan perkembangan desa</p>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="news-card fade-in">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="news-date">15 Juli 2025</span>
                                <i class="bi bi-bookmark text-muted"></i>
                            </div>
                            <h5 class="card-title">Pembangunan Jalan Desa Tahap 2</h5>
                            <p class="card-text">Pemerintah desa melanjutkan pembangunan infrastruktur jalan untuk
                                meningkatkan konektivitas antar dusun.</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="news-card fade-in">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="news-date">12 Juli 2025</span>
                                <i class="bi bi-bookmark text-muted"></i>
                            </div>
                            <h5 class="card-title">Program Pelatihan UMKM</h5>
                            <p class="card-text">Desa menyelenggarakan pelatihan kewirausahaan untuk meningkatkan
                                ekonomi kreatif warga.</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="news-card fade-in">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="news-date">10 Juli 2025</span>
                                <i class="bi bi-bookmark text-muted"></i>
                            </div>
                            <h5 class="card-title">Gotong Royong Bersih Desa</h5>
                            <p class="card-text">Kegiatan gotong royong bulanan untuk menjaga kebersihan dan keindahan
                                lingkungan desa.</p>
                            <a href="#" class="btn btn-sm btn-outline-primary">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Hubungi Kami</h2>
                <p class="lead">Kami siap melayani dan menjawab pertanyaan Anda</p>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="text-center fade-in">
                                <div class="feature-icon mb-3">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <h6>Alamat</h6>
                                <p class="text-muted">Jl. Raya Desa No. 123<br>Kecamatan Kilwaru<br>Kabupaten Makmur
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="text-center fade-in">
                                <div class="feature-icon mb-3">
                                    <i class="bi bi-telephone"></i>
                                </div>
                                <h6>Telepon</h6>
                                <p class="text-muted">(0123) 456-7890<br>+62 812-3456-7890</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="text-center fade-in">
                                <div class="feature-icon mb-3">
                                    <i class="bi bi-envelope"></i>
                                </div>
                                <h6>Email</h6>
                                <p class="text-muted">info@desaKilwaru.id<br>admin@desaKilwaru.id</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
