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

    {{-- Chart.js untuk halaman landing saja --}}
    @push('chart-scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.min.js"></script>
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

    <!-- Struktur Desa Section -->
    <section id="struktur" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Struktur Pemerintahan Desa</h2>
                <p class="lead">Mengenal pejabat dan aparatur {{ config('app.village_name', 'Desa Kilwaru') }}</p>
            </div>

            @if (isset($strukturDesa) && $strukturDesa->isNotEmpty())
                <!-- Kepala Desa & Sekretaris Row -->
                @if (isset($strukturDesa['kepala_desa']) || isset($strukturDesa['sekretaris']))
                    <div class="row mb-5">
                        @if (isset($strukturDesa['kepala_desa']) && $strukturDesa['kepala_desa']->first())
                            @php $kepalaDesa = $strukturDesa['kepala_desa']->first(); @endphp
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100 shadow-lg border-0 fade-in">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            @if ($kepalaDesa->image)
                                                <img src="{{ $kepalaDesa->image_url }}" alt="{{ $kepalaDesa->nama }}"
                                                    class="img-fluid rounded-start h-100"
                                                    style="object-fit: cover; min-height: 200px;">
                                            @else
                                                <div class="h-100 d-flex align-items-center justify-content-center bg-light rounded-start"
                                                    style="min-height: 200px;">
                                                    <i class="bi bi-person-circle"
                                                        style="font-size: 4rem; color: #dee2e6;"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <span class="badge bg-primary mb-2">Kepala Desa</span>
                                                <h5 class="card-title fw-bold" style="color: var(--primary-green);">
                                                    {{ $kepalaDesa->nama }}</h5>
                                                <p class="card-text text-muted mb-2">{{ $kepalaDesa->posisi }}</p>
                                                @if ($kepalaDesa->telepon)
                                                    <p class="mb-1 small"><i
                                                            class="bi bi-telephone me-2 text-success"></i>{{ $kepalaDesa->telepon }}
                                                    </p>
                                                @endif
                                                @if ($kepalaDesa->email)
                                                    <p class="mb-1 small"><i
                                                            class="bi bi-envelope me-2 text-info"></i>{{ $kepalaDesa->email }}
                                                    </p>
                                                @endif
                                                @if ($kepalaDesa->mulai_menjabat)
                                                    <p class="mb-0 small"><i
                                                            class="bi bi-calendar-check me-2 text-warning"></i>Menjabat
                                                        sejak {{ $kepalaDesa->mulai_menjabat->format('Y') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (isset($strukturDesa['sekretaris']) && $strukturDesa['sekretaris']->first())
                            @php $sekretaris = $strukturDesa['sekretaris']->first(); @endphp
                            <div class="col-lg-6 mb-4">
                                <div class="card h-100 shadow-lg border-0 fade-in">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            @if ($sekretaris->image)
                                                <img src="{{ $sekretaris->image_url }}" alt="{{ $sekretaris->nama }}"
                                                    class="img-fluid rounded-start h-100"
                                                    style="object-fit: cover; min-height: 200px;">
                                            @else
                                                <div class="h-100 d-flex align-items-center justify-content-center bg-light rounded-start"
                                                    style="min-height: 200px;">
                                                    <i class="bi bi-person-circle"
                                                        style="font-size: 4rem; color: #dee2e6;"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <span class="badge bg-success mb-2">Sekretaris Desa</span>
                                                <h5 class="card-title fw-bold" style="color: var(--primary-green);">
                                                    {{ $sekretaris->nama }}</h5>
                                                <p class="card-text text-muted mb-2">{{ $sekretaris->posisi }}</p>
                                                @if ($sekretaris->telepon)
                                                    <p class="mb-1 small"><i
                                                            class="bi bi-telephone me-2 text-success"></i>{{ $sekretaris->telepon }}
                                                    </p>
                                                @endif
                                                @if ($sekretaris->email)
                                                    <p class="mb-1 small"><i
                                                            class="bi bi-envelope me-2 text-info"></i>{{ $sekretaris->email }}
                                                    </p>
                                                @endif
                                                @if ($sekretaris->mulai_menjabat)
                                                    <p class="mb-0 small"><i
                                                            class="bi bi-calendar-check me-2 text-warning"></i>Menjabat
                                                        sejak {{ $sekretaris->mulai_menjabat->format('Y') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Other Officials Grid -->
                <div class="row">
                    @php
                        $otherOfficials = collect();
                        $categories = [
                            'kaur_umum',
                            'kaur_keuangan',
                            'kasi_pemerintahan',
                            'kasi_kesejahteraan',
                            'kasi_pelayanan',
                            'kadus',
                        ];
                        foreach ($categories as $cat) {
                            if (isset($strukturDesa[$cat])) {
                                $otherOfficials = $otherOfficials->merge($strukturDesa[$cat]);
                            }
                        }
                    @endphp

                    @foreach ($otherOfficials->take(6) as $pejabat)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 fade-in">
                                <div class="card-body text-center p-4">
                                    @if ($pejabat->image)
                                        <img src="{{ $pejabat->image_url }}" alt="{{ $pejabat->nama }}"
                                            class="rounded-circle mb-3"
                                            style="width: 100px; height: 100px; object-fit: cover; border: 3px solid var(--light-green);">
                                    @else
                                        <div class="feature-icon mb-3">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    @endif
                                    <h6 class="fw-bold" style="color: var(--primary-green);">{{ $pejabat->nama }}</h6>
                                    <p class="text-muted small mb-2">{{ $pejabat->posisi }}</p>
                                    <span class="badge"
                                        style="background-color: var(--light-green); color: var(--primary-green);">
                                        {{ $pejabat->kategori_display }}
                                    </span>
                                    @if ($pejabat->telepon)
                                        <p class="mb-0 small mt-2"><i
                                                class="bi bi-telephone me-1"></i>{{ $pejabat->telepon }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('struktur-desa.public') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-diagram-3 me-2"></i>Lihat Struktur Lengkap
                    </a>
                </div>
            @else
                <!-- Fallback Display if no data from database -->
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 fade-in">
                            <div class="card-body text-center p-4">
                                <div class="feature-icon mb-3">
                                    <i class="bi bi-person-badge"></i>
                                </div>
                                <h5 class="card-title">Kepala Desa</h5>
                                <p class="card-text">Memimpin penyelenggaraan pemerintahan desa dan pembangunan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 fade-in">
                            <div class="card-body text-center p-4">
                                <div class="feature-icon mb-3">
                                    <i class="bi bi-people"></i>
                                </div>
                                <h5 class="card-title">Perangkat Desa</h5>
                                <p class="card-text">Membantu kepala desa dalam pelaksanaan tugas pemerintahan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 fade-in">
                            <div class="card-body text-center p-4">
                                <div class="feature-icon mb-3">
                                    <i class="bi bi-bank"></i>
                                </div>
                                <h5 class="card-title">BPD</h5>
                                <p class="card-text">Lembaga permusyawaratan desa yang demokratis</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('struktur-desa.public') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-diagram-3 me-2"></i>Lihat Struktur Organisasi
                    </a>
                </div>
            @endif
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
                {{-- Layanana surat --}}
                <!-- Layanan Surat -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 fade-in">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <h5 class="card-title">Layanan Surat</h5>
                            <p class="card-text">Pembuatan surat keterangan, surat pengantar, dan dokumen administrasi
                                lainnya secara online.</p>
                            <a href="{{ route('public.surat.index') }}" class="btn btn-primary mt-auto">
                                <i class="bi bi-arrow-right me-2"></i>Lihat Layanan
                            </a>
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
                @forelse($latestBerita as $berita)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="news-card fade-in">
                            @if ($berita->gambar)
                                <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}" class="card-img-top"
                                    style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <span class="news-date">{{ $berita->published_at->format('d M Y') }}</span>
                                    @if ($berita->kategoriBeri)
                                        <span class="badge"
                                            style="background-color: {{ $berita->kategoriBeri->warna }}">
                                            {{ $berita->kategoriBeri->nama }}
                                        </span>
                                    @endif
                                </div>
                                <h5 class="card-title">{{ $berita->judul }}</h5>
                                <p class="card-text">{{ $berita->excerpt_formatted }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('berita.show', $berita->slug) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        Baca Selengkapnya
                                    </a>
                                    <small class="text-muted">
                                        <i class="bi bi-eye"></i> {{ $berita->views }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="bi bi-newspaper" style="font-size: 4rem; color: var(--soft-gray);"></i>
                            <p class="mt-3 text-muted">Belum ada berita terbaru</p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($latestBerita->count() > 0)
                <div class="text-center mt-4">
                    <a href="{{ route('berita.index') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-right me-2"></i>Lihat Semua Berita
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- Demographics Section - Optional, jika ada chart --}}
    @if (isset($showDemographics) && $showDemographics)
        <section class="py-5 bg-light demographics-section">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title">Data Demografis</h2>
                    <p class="lead">Statistik penduduk Desa Kilwaru</p>
                </div>
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title text-center mb-4">Distribusi Usia</h5>
                                <div style="height: 300px;">
                                    <canvas id="ageChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title text-center mb-4">Distribusi Gender</h5>
                                <div style="height: 300px;">
                                    <canvas id="genderChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

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
                                <p class="text-muted">info@desakilwaru.id<br>admin@desakilwaru.id</p>
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
        // Counter animation for statistics (Landing page only)
        function animateCounters() {
            const counters = document.querySelectorAll('.stat-number');
            const speed = 200;

            counters.forEach(counter => {
                const animate = () => {
                    const value = +counter.getAttribute('data-target') || +counter.innerText.replace(/,/g, '');
                    const data = +counter.innerText.replace(/,/g, '') || 0;
                    const time = value / speed;

                    if (data < value) {
                        counter.innerText = Math.ceil(data + time).toLocaleString();
                        setTimeout(animate, 1);
                    } else {
                        counter.innerText = value.toLocaleString();
                    }
                };
                // Set target values and start animation when visible
                if (!counter.getAttribute('data-target')) {
                    const originalValue = counter.innerText.replace(/,/g, '');
                    counter.setAttribute('data-target', originalValue);
                    counter.innerText = '0';
                }
                animate();
            });
        }

        // Trigger counter animation when stats section is visible (Landing page)
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

        // Parallax effect for hero section (Landing page only)
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.floating-elements');
            const speed = scrolled * 0.5;

            parallaxElements.forEach(element => {
                element.style.transform = `translateY(${speed}px)`;
            });
        });

        // Typing effect for hero title (Landing page only)
        function typeWriter(element, text, speed = 100) {
            let i = 0;
            element.innerHTML = '';

            function type() {
                if (i < text.length) {
                    element.innerHTML += text.charAt(i);
                    i++;
                    setTimeout(type, speed);
                }
            }
            type();
        }

        // Initialize typing effect after page load (Landing page)
        window.addEventListener('load', () => {
            setTimeout(() => {
                const heroTitle = document.querySelector('.hero-content h1');
                if (heroTitle) {
                    const originalText = heroTitle.innerText;
                    typeWriter(heroTitle, originalText, 50);
                }
            }, 500);
        });

        // Particle effect for hero section (Landing page only)
        function createParticles() {
            const hero = document.querySelector('.hero-section');
            if (!hero) return;

            const particleCount = 20;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.style.cssText = `
                    position: absolute; width: 4px; height: 4px; background: rgba(255, 255, 255, 0.3); border-radius: 50%;
                    animation: float ${3 + Math.random() * 4}s ease-in-out infinite; animation-delay: ${Math.random() * 2}s;
                    left: ${Math.random() * 100}%; top: ${Math.random() * 100}%; pointer-events: none;
                `;
                hero.appendChild(particle);
            }
            // Add float animation CSS
            const floatStyle = document.createElement('style');
            floatStyle.textContent = `
                @keyframes float {
                    0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 1; }
                    33% { transform: translateY(-20px) rotate(120deg); opacity: 0.7; }
                    66% { transform: translateY(20px) rotate(240deg); opacity: 0.4; }
                }
            `;
            document.head.appendChild(floatStyle);
        }
        // Initialize particles (Landing page)
        createParticles();

        // Chart initialization for demographics (Landing page only)
        function initCharts() {
            // Age Distribution Chart
            const ageCtx = document.getElementById('ageChart');
            if (ageCtx) {
                const ageChart = new Chart(ageCtx.getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: [
                            '0-17 Tahun',
                            '18-35 Tahun',
                            '36-50 Tahun',
                            '51-65 Tahun',
                            '65+ Tahun'
                        ],
                        datasets: [{
                            data: [642, 1089, 736, 285, 95],
                            backgroundColor: ['#4a7c59', '#8fbc8f', '#ff8c42', '#2d5016', '#6c757d'],
                            borderColor: '#fff',
                            borderWidth: 3,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    font: {
                                        size: 12,
                                        family: 'Segoe UI'
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((context.parsed / total) * 100).toFixed(1);
                                        return context.label + ': ' + context.parsed + ' orang (' + percentage +
                                            '%)';
                                    }
                                }
                            }
                        },
                        animation: {
                            animateScale: true,
                            animateRotate: true,
                            duration: 1500
                        }
                    }
                });
            }

            // Gender Distribution Chart
            const genderCtx = document.getElementById('genderChart');
            if (genderCtx) {
                const genderChart = new Chart(genderCtx.getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: ['Laki-laki', 'Perempuan'],
                        datasets: [{
                            data: [1456, 1391],
                            backgroundColor: [
                                '#4a7c59',
                                '#ff8c42'
                            ],
                            borderColor: '#fff',
                            borderWidth: 3,
                            hoverOffset: 15
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    font: {
                                        size: 14,
                                        family: 'Segoe UI'
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((context.parsed / total) * 100).toFixed(1);
                                        return context.label + ': ' + context.parsed + ' orang (' + percentage +
                                            '%)';
                                    }
                                }
                            }
                        },
                        animation: {
                            animateScale: true,
                            animateRotate: true,
                            duration: 1500
                        }
                    }
                });
            }
        }

        // Initialize charts when demographic section becomes visible (Landing page)
        const chartSection = document.querySelector('.demographics-section, .charts-section');
        if (chartSection) {
            const chartObserver = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        setTimeout(initCharts, 500); // Small delay for better effect
                        chartObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.3
            });

            chartObserver.observe(chartSection);
        }

        // Hero section specific animations (Landing page)
        const heroElements = document.querySelectorAll('.hero-animation');
        heroElements.forEach((element, index) => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(50px)';
            element.style.transition = 'all 0.8s ease';

            setTimeout(() => {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }, 200 + (index * 200));
        });

        // Landing page specific news refresh (if needed)
        if (typeof refreshNews === 'undefined') {
            window.refreshNews = function() {
                // Auto refresh berita setiap 5 menit - hanya di landing page
                setInterval(function() {
                    const newsSection = document.querySelector('#news');
                    if (newsSection && window.location.pathname === '/') {
                        fetch('/api/berita/latest?limit=3')
                            .then(response => response.json())
                            .then(data => {
                                console.log('Checking for new articles...');
                                // Logic untuk update berita bisa ditambahkan di sini
                            })
                            .catch(error => console.log('News refresh error:', error));
                    }
                }, 300000); // 5 menit
            };

            // Initialize news refresh
            refreshNews();
        }

        console.log('Desa Kilwaru landing page scripts loaded successfully! 🏡');
    </script>
@endpush
