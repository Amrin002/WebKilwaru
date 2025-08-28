@extends('template.main')

@section('title', '404 - Halaman Tidak Ditemukan | ' . config('app.village_name', 'Desa Kilwaru'))
@section('description',
    'Maaf, halaman yang Anda cari tidak dapat ditemukan. Silakan kembali ke beranda atau gunakan
    menu navigasi.')

    @push('styles')
        <style>
            .error-section {
                background:
                    linear-gradient(rgba(45, 80, 22, 0.1), rgba(74, 124, 89, 0.1)),
                    var(--cream);
                min-height: calc(100vh - 200px);
                display: flex;
                align-items: center;
                padding: 80px 0;
                position: relative;
                overflow: hidden;
            }

            .error-section::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><circle cx="200" cy="200" r="3" fill="%234a7c59" opacity="0.3"/><circle cx="800" cy="150" r="2" fill="%23ff8c42" opacity="0.4"/><circle cx="150" cy="800" r="2" fill="%232d5016" opacity="0.3"/><circle cx="900" cy="700" r="3" fill="%238fbc8f" opacity="0.5"/></svg>');
                opacity: 0.3;
            }

            .error-content {
                position: relative;
                z-index: 2;
                text-align: center;
            }

            .error-number {
                font-size: 12rem;
                font-weight: 900;
                color: var(--primary-green);
                line-height: 0.8;
                margin-bottom: 20px;
                background: linear-gradient(45deg, var(--primary-green), var(--secondary-green));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                animation: bounce 2s infinite;
                text-shadow: 0 10px 30px rgba(45, 80, 22, 0.3);
            }

            .error-title {
                font-size: 2.5rem;
                font-weight: 700;
                color: var(--primary-green);
                margin-bottom: 20px;
                animation: fadeInUp 1s ease-out 0.5s both;
            }

            .error-message {
                font-size: 1.2rem;
                color: var(--soft-gray);
                margin-bottom: 40px;
                max-width: 500px;
                margin-left: auto;
                margin-right: auto;
                line-height: 1.6;
                animation: fadeInUp 1s ease-out 0.7s both;
            }

            .error-actions {
                animation: fadeInUp 1s ease-out 0.9s both;
            }

            .btn-home {
                background: linear-gradient(45deg, var(--primary-green), var(--secondary-green));
                color: white;
                padding: 15px 30px;
                border: none;
                border-radius: 50px;
                font-weight: 600;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 10px;
                transition: all 0.3s ease;
                box-shadow: 0 5px 20px rgba(45, 80, 22, 0.3);
                margin-right: 15px;
            }

            .btn-home:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 30px rgba(45, 80, 22, 0.4);
                color: white;
            }

            .btn-back {
                background: transparent;
                color: var(--soft-gray);
                padding: 15px 30px;
                border: 2px solid var(--soft-gray);
                border-radius: 50px;
                font-weight: 600;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 10px;
                transition: all 0.3s ease;
            }

            .btn-back:hover {
                color: var(--primary-green);
                border-color: var(--primary-green);
                background: rgba(45, 80, 22, 0.05);
            }

            .error-illustration {
                max-width: 300px;
                margin: 0 auto 40px;
                opacity: 0.8;
                animation: float 3s ease-in-out infinite;
            }

            .search-box {
                max-width: 400px;
                margin: 30px auto 0;
                position: relative;
                animation: fadeInUp 1s ease-out 1.1s both;
            }

            .search-input {
                width: 100%;
                padding: 15px 50px 15px 20px;
                border: 2px solid rgba(45, 80, 22, 0.2);
                border-radius: 50px;
                font-size: 1rem;
                background: var(--warm-white);
                color: var(--primary-green);
                transition: all 0.3s ease;
            }

            .search-input:focus {
                outline: none;
                border-color: var(--primary-green);
                box-shadow: 0 0 0 3px rgba(45, 80, 22, 0.1);
            }

            .search-btn {
                position: absolute;
                right: 5px;
                top: 50%;
                transform: translateY(-50%);
                background: var(--primary-green);
                color: white;
                border: none;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
            }

            .search-btn:hover {
                background: var(--secondary-green);
                transform: translateY(-50%) scale(1.1);
            }

            /* Animations */
            @keyframes bounce {

                0%,
                20%,
                50%,
                80%,
                100% {
                    transform: translateY(0);
                }

                40% {
                    transform: translateY(-20px);
                }

                60% {
                    transform: translateY(-10px);
                }
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes float {

                0%,
                100% {
                    transform: translateY(0px);
                }

                50% {
                    transform: translateY(-20px);
                }
            }

            /* Responsive */
            @media (max-width: 768px) {
                .error-number {
                    font-size: 8rem;
                }

                .error-title {
                    font-size: 2rem;
                }

                .error-message {
                    font-size: 1.1rem;
                    padding: 0 20px;
                }

                .btn-home,
                .btn-back {
                    padding: 12px 25px;
                    font-size: 0.9rem;
                    margin: 5px;
                    display: block;
                    margin-bottom: 10px;
                }

                .search-box {
                    margin: 30px 20px 0;
                }
            }

            @media (max-width: 480px) {
                .error-number {
                    font-size: 6rem;
                }

                .error-title {
                    font-size: 1.8rem;
                }

                .error-actions {
                    flex-direction: column;
                    gap: 10px;
                }
            }
        </style>
    @endpush

@section('content')
    <section class="error-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="error-content">
                        <!-- Error Illustration -->
                        <div class="error-illustration">
                            <svg viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg">
                                <!-- Background -->
                                <rect width="400" height="300" fill="transparent" />

                                <!-- Mountains -->
                                <path d="M0,200 L80,120 L160,180 L240,100 L320,160 L400,140 L400,300 L0,300 Z"
                                    fill="#8fbc8f" opacity="0.3" />
                                <path d="M0,220 L60,160 L140,200 L200,140 L280,180 L400,160 L400,300 L0,300 Z"
                                    fill="#4a7c59" opacity="0.4" />

                                <!-- Sun -->
                                <circle cx="320" cy="80" r="25" fill="#ff8c42" opacity="0.6" />

                                <!-- Trees -->
                                <rect x="100" y="180" width="8" height="40" fill="#2d5016" />
                                <circle cx="104" cy="175" r="15" fill="#4a7c59" opacity="0.7" />

                                <rect x="280" y="190" width="6" height="30" fill="#2d5016" />
                                <circle cx="283" cy="185" r="12" fill="#4a7c59" opacity="0.7" />

                                <!-- Path/Road -->
                                <path d="M0,250 Q200,230 400,250" stroke="#6c757d" stroke-width="3" fill="none"
                                    opacity="0.3" stroke-dasharray="10,5" />
                            </svg>
                        </div>

                        <!-- Error Number -->
                        <div class="error-number">404</div>

                        <!-- Error Title -->
                        <h1 class="error-title">Halaman Tidak Ditemukan</h1>

                        <!-- Error Message -->
                        <p class="error-message">
                            Maaf, halaman yang Anda cari tidak dapat ditemukan. Mungkin halaman telah dipindahkan,
                            dihapus, atau Anda salah mengetikkan alamat URL.
                        </p>

                        <!-- Search Box -->
                        <div class="search-box">
                            <form action="{{ route('home') }}" method="GET" class="d-flex">
                                <input type="text" name="search" class="search-input"
                                    placeholder="Cari halaman yang Anda inginkan...">
                                <button type="submit" class="search-btn">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Action Buttons -->
                        <div class="error-actions mt-4">
                            <a href="{{ route('home') }}" class="btn-home">
                                <i class="fas fa-home"></i>
                                Kembali ke Beranda
                            </a>
                            <a href="javascript:history.back()" class="btn-back">
                                <i class="fas fa-arrow-left"></i>
                                Halaman Sebelumnya
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Additional Help Section -->
    <section class="bg-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h3 class="mb-4" style="color: var(--primary-green);">
                        <i class="fas fa-compass me-2"></i>
                        Butuh Bantuan Navigasi?
                    </h3>
                    <p class="lead mb-4" style="color: var(--soft-gray);">
                        Berikut adalah beberapa halaman populer yang mungkin Anda cari:
                    </p>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="{{ route('home') }}#tentang" class="text-decoration-none">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <i class="fas fa-info-circle fa-2x mb-3" style="color: var(--primary-green);"></i>
                                        <h5 style="color: var(--primary-green);">Tentang Desa</h5>
                                        <p class="text-muted small">Profil dan sejarah Desa Kilwaru</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('berita.index') }}" class="text-decoration-none">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <i class="fas fa-newspaper fa-2x mb-3" style="color: var(--accent-orange);"></i>
                                        <h5 style="color: var(--primary-green);">Berita</h5>
                                        <p class="text-muted small">Informasi dan berita terkini</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('home') }}#layanan" class="text-decoration-none">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body text-center">
                                        <i class="fas fa-concierge-bell fa-2x mb-3"
                                            style="color: var(--secondary-green);"></i>
                                        <h5 style="color: var(--primary-green);">Layanan</h5>
                                        <p class="text-muted small">Layanan publik untuk warga</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="mt-4">
                        <p class="text-muted">
                            Masih belum menemukan yang Anda cari?
                            <a href="mailto:info@desakilwaru.id" style="color: var(--primary-green);">
                                <i class="fas fa-envelope me-1"></i>
                                Hubungi kami
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto focus pada search input setelah 2 detik
            setTimeout(function() {
                const searchInput = document.querySelector('.search-input');
                if (searchInput) {
                    searchInput.focus();
                }
            }, 2000);

            // Handle search form submission
            const searchForm = document.querySelector('.search-box form');
            if (searchForm) {
                searchForm.addEventListener('submit', function(e) {
                    const searchInput = this.querySelector('.search-input');
                    if (!searchInput.value.trim()) {
                        e.preventDefault();
                        searchInput.focus();
                        searchInput.setAttribute('placeholder', 'Masukkan kata kunci pencarian...');
                    }
                });
            }

            // Tambahkan efek ripple pada tombol
            const buttons = document.querySelectorAll('.btn-home, .btn-back');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.style.position = 'absolute';
                    ripple.style.borderRadius = '50%';
                    ripple.style.background = 'rgba(255, 255, 255, 0.3)';
                    ripple.style.transform = 'scale(0)';
                    ripple.style.animation = 'ripple 0.6s linear';
                    ripple.style.pointerEvents = 'none';

                    this.style.position = 'relative';
                    this.style.overflow = 'hidden';
                    this.appendChild(ripple);

                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });

            // Tambahkan CSS untuk animasi ripple
            const style = document.createElement('style');
            style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(2);
                    opacity: 0;
                }
            }
        `;
            document.head.appendChild(style);
        });
    </script>
@endpush
