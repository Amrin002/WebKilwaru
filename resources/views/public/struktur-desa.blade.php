@extends('template.main')

@section('title', 'Struktur Desa - ' . config('app.village_name', 'Desa Kilwaru'))
@section('description', 'Struktur organisasi dan pejabat ' . config('app.village_name', 'Desa Kilwaru'))

@push('styles')
    <style>
        /* Header Section */
        .struktur-header {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            color: white;
            padding: 120px 0 60px;
            margin-top: -76px;
            position: relative;
            overflow: hidden;
        }

        .struktur-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><path d="M0,300 C300,200 700,400 1000,300 L1000,1000 L0,1000 Z" fill="%23ffffff08"/></svg>');
            opacity: 0.2;
        }

        .struktur-header .container {
            position: relative;
            z-index: 2;
        }

        /* Struktur Cards */
        .struktur-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
        }

        .struktur-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .struktur-card .card-img-wrapper {
            height: 280px;
            overflow: hidden;
            background: linear-gradient(135deg, var(--light-green), var(--secondary-green));
            position: relative;
        }

        .struktur-card .card-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .struktur-card:hover .card-img-wrapper img {
            transform: scale(1.1);
        }

        .struktur-card .no-image-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f0f0f0, #e0e0e0);
        }

        .struktur-card .no-image-placeholder i {
            font-size: 5rem;
            color: rgba(0, 0, 0, 0.2);
        }

        .struktur-card .card-body {
            padding: 1.5rem;
        }

        .struktur-card .jabatan-badge {
            display: inline-block;
            background: var(--accent-orange);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .struktur-card .nama-pejabat {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 5px;
        }

        .struktur-card .posisi-pejabat {
            color: var(--soft-gray);
            font-size: 0.95rem;
            margin-bottom: 15px;
        }

        .struktur-card .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .struktur-card .info-list li {
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.9rem;
            color: #666;
        }

        .struktur-card .info-list li:last-child {
            border-bottom: none;
        }

        .struktur-card .info-list i {
            color: var(--secondary-green);
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Category Section */
        .kategori-section {
            margin-bottom: 60px;
        }

        .kategori-title {
            color: var(--primary-green);
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid var(--accent-orange);
            position: relative;
        }

        /* Social Links */
        .social-links {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #f0f0f0;
        }

        .social-links a {
            display: inline-block;
            width: 35px;
            height: 35px;
            background: rgba(74, 124, 89, 0.1);
            color: var(--secondary-green);
            border-radius: 50%;
            text-align: center;
            line-height: 35px;
            margin-right: 10px;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--secondary-green);
            color: white;
            transform: translateY(-3px);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: #f8f9fa;
            border-radius: 20px;
        }

        .empty-state i {
            font-size: 5rem;
            color: #dee2e6;
            margin-bottom: 20px;
        }

        .empty-state h4 {
            color: var(--soft-gray);
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #adb5bd;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .struktur-header {
                padding: 100px 0 40px;
            }

            .struktur-card .card-img-wrapper {
                height: 220px;
            }

            .kategori-title {
                font-size: 1.5rem;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Header Section -->
    <section class="struktur-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold mb-3 fade-in">Struktur Organisasi Desa</h1>
                    <p class="lead fade-in">Mengenal pejabat dan struktur pemerintahan
                        {{ config('app.village_name', 'Desa Kilwaru') }}</p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="bi bi-diagram-3" style="font-size: 6rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            @if ($strukturDesa->isEmpty())
                <div class="empty-state fade-in">
                    <i class="bi bi-people"></i>
                    <h4>Belum Ada Data Struktur Desa</h4>
                    <p>Data struktur organisasi desa belum tersedia.</p>
                </div>
            @else
                @php
                    $kategoriOrder = [
                        'kepala_desa' => 'Kepala Desa',
                        'sekretaris' => 'Sekretaris Desa',
                        'kaur_umum' => 'Kaur Umum & Perencanaan',
                        'kaur_keuangan' => 'Kaur Keuangan',
                        'kasi_pemerintahan' => 'Kasi Pemerintahan',
                        'kasi_kesejahteraan' => 'Kasi Kesejahteraan',
                        'kasi_pelayanan' => 'Kasi Pelayanan',
                        'kadus' => 'Kepala Dusun',
                        'bpd' => 'Badan Permusyawaratan Desa',
                        'lainnya' => 'Lainnya',
                    ];
                @endphp

                @foreach ($kategoriOrder as $key => $label)
                    @if (isset($strukturDesa[$key]) && $strukturDesa[$key]->count() > 0)
                        <div class="kategori-section fade-in">
                            <h2 class="kategori-title">{{ $label }}</h2>

                            <div class="row">
                                @foreach ($strukturDesa[$key] as $pejabat)
                                    <div class="col-lg-4 col-md-6 mb-4">
                                        <div class="struktur-card">
                                            <div class="card-img-wrapper">
                                                @if ($pejabat->image)
                                                    <img src="{{ $pejabat->image_url }}" alt="{{ $pejabat->nama }}"
                                                        onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'no-image-placeholder\'><i class=\'bi bi-person-circle\'></i></div>';">
                                                @else
                                                    <div class="no-image-placeholder">
                                                        <i class="bi bi-person-circle"></i>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="card-body">
                                                <span class="jabatan-badge">{{ $pejabat->kategori_display }}</span>
                                                <h5 class="nama-pejabat">{{ $pejabat->nama }}</h5>
                                                <p class="posisi-pejabat">{{ $pejabat->posisi }}</p>

                                                <ul class="info-list">
                                                    @if ($pejabat->nip)
                                                        <li>
                                                            <i class="bi bi-card-text"></i>
                                                            NIP: {{ $pejabat->nip }}
                                                        </li>
                                                    @endif

                                                    @if ($pejabat->telepon)
                                                        <li>
                                                            <i class="bi bi-telephone"></i>
                                                            {{ $pejabat->telepon }}
                                                        </li>
                                                    @endif

                                                    @if ($pejabat->email)
                                                        <li>
                                                            <i class="bi bi-envelope"></i>
                                                            {{ $pejabat->email }}
                                                        </li>
                                                    @endif

                                                    @if ($pejabat->mulai_menjabat)
                                                        <li>
                                                            <i class="bi bi-calendar-check"></i>
                                                            Menjabat: {{ $pejabat->mulai_menjabat->format('d M Y') }}
                                                        </li>
                                                    @endif

                                                    @if ($pejabat->pendidikan_terakhir)
                                                        <li>
                                                            <i class="bi bi-mortarboard"></i>
                                                            {{ $pejabat->pendidikan_terakhir }}
                                                        </li>
                                                    @endif
                                                </ul>

                                                @if ($pejabat->twitter || $pejabat->facebook || $pejabat->instagram)
                                                    <div class="social-links">
                                                        @if ($pejabat->twitter)
                                                            <a href="https://twitter.com/{{ $pejabat->twitter }}"
                                                                target="_blank" rel="noopener noreferrer" title="Twitter">
                                                                <i class="bi bi-twitter"></i>
                                                            </a>
                                                        @endif

                                                        @if ($pejabat->facebook)
                                                            <a href="https://facebook.com/{{ $pejabat->facebook }}"
                                                                target="_blank" rel="noopener noreferrer" title="Facebook">
                                                                <i class="bi bi-facebook"></i>
                                                            </a>
                                                        @endif

                                                        @if ($pejabat->instagram)
                                                            <a href="https://instagram.com/{{ $pejabat->instagram }}"
                                                                target="_blank" rel="noopener noreferrer" title="Instagram">
                                                                <i class="bi bi-instagram"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </section>

    <!-- Statistics Section (Optional) -->
    @if ($strukturDesa->isNotEmpty())
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-4">
                    <h3 class="section-title">Statistik Struktur Desa</h3>
                </div>
                <div class="row text-center">
                    <div class="col-md-3 col-6 mb-3">
                        <div class="stat-item fade-in">
                            <span class="stat-number">{{ $strukturDesa->flatten()->count() }}</span>
                            <span class="stat-label">Total Pejabat</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="stat-item fade-in">
                            <span class="stat-number">{{ $strukturDesa->count() }}</span>
                            <span class="stat-label">Kategori Jabatan</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="stat-item fade-in">
                            <span
                                class="stat-number">{{ $strukturDesa->flatten()->where('kategori', 'kadus')->count() }}</span>
                            <span class="stat-label">Kepala Dusun</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <div class="stat-item fade-in">
                            <span
                                class="stat-number">{{ $strukturDesa->flatten()->where('kategori', 'bpd')->count() }}</span>
                            <span class="stat-label">Anggota BPD</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection

@push('scripts')
    <script>
        // Animate struktur cards on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.struktur-card');

            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.style.opacity = '0';
                            entry.target.style.transform = 'translateY(30px)';
                            entry.target.style.transition = 'all 0.6s ease';

                            setTimeout(() => {
                                entry.target.style.opacity = '1';
                                entry.target.style.transform = 'translateY(0)';
                            }, index * 100);
                        }, 100);

                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            cards.forEach(card => {
                card.style.opacity = '0';
                observer.observe(card);
            });

            // Smooth scroll for anchor links if any
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
        });
    </script>
@endpush
