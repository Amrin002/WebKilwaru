@extends('template.main')

@section('title', 'Syarat dan Ketentuan - Website Resmi Desa Kilwaru')
@section('description', 'Syarat dan ketentuan penggunaan Website Resmi Desa Kilwaru')

@push('styles')
    <style>
        .header-syarat {
            position: relative;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            background-attachment: fixed;
            display: flex;
            min-height: 40vh;
            color: white;
            padding-top: 65px;
            background-size: cover;
        }

        .header-syarat::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(0, 0, 0, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);

        }

        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .text-white-75 {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .hover-opacity-100:hover {
            opacity: 1 !important;
            transition: opacity 0.3s ease;
        }

        .min-vh-25 {
            min-height: 25vh;
        }

        /* Floating Animation */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-syarat {
                min-height: 50vh;
                background-attachment: scroll;
            }

            .display-4 {
                font-size: 2.5rem;
            }

            .lead {
                font-size: 1.1rem;
            }

            .header-syarat .col-lg-4 {
                margin-top: 2rem;
            }

            .header-syarat .position-absolute {
                position: relative !important;
            }
        }

        @media (max-width: 576px) {
            .header-syarat {
                min-height: 40vh;
            }

            .display-4 {
                font-size: 2rem;
            }

            .d-flex.gap-3 {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Header Section -->
    <section class="header-syarat ">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold mb-3">Syarat dan Ketentuan</h1>
                    <p class="lead">Ketentuan penggunaan Website Resmi Desa Kilwaru</p>
                    <small class="opacity-75">Terakhir diperbarui: {{ date('d F Y') }}</small>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="bi bi-file-text" style="font-size: 6rem; opacity: 0.7;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Terms Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-5">

                            <div class="mb-5">
                                <h3 class="h4 fw-bold mb-3" style="color: var(--primary-green);">1. Penerimaan Ketentuan
                                </h3>
                                <p>Dengan mengakses dan menggunakan Website Resmi Desa Kilwaru, Anda menyetujui untuk
                                    terikat oleh syarat dan ketentuan yang ditetapkan di bawah ini. Jika Anda tidak
                                    menyetujui ketentuan ini, mohon untuk tidak menggunakan website ini.</p>
                            </div>

                            <div class="mb-5">
                                <h3 class="h4 fw-bold mb-3" style="color: var(--primary-green);">2. Penggunaan Website</h3>
                                <p>Website ini disediakan untuk memberikan informasi tentang Desa Kilwaru dan
                                    layanan-layanan yang tersedia. Anda diperbolehkan untuk:</p>
                                <ul class="list-unstyled ms-3">
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Mengakses
                                        informasi publik yang tersedia</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Menggunakan
                                        layanan online yang disediakan</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Menghubungi
                                        pemerintah desa melalui formulir kontak</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Mendaftar akun
                                        untuk mengakses layanan khusus</li>
                                </ul>
                            </div>

                            <div class="mb-5">
                                <h3 class="h4 fw-bold mb-3" style="color: var(--primary-green);">3. Larangan Penggunaan</h3>
                                <p>Anda dilarang untuk:</p>
                                <ul class="list-unstyled ms-3">
                                    <li class="mb-2"><i class="bi bi-x-circle text-danger me-2"></i>Menggunakan website
                                        untuk tujuan ilegal atau tidak sah</li>
                                    <li class="mb-2"><i class="bi bi-x-circle text-danger me-2"></i>Mengganggu atau
                                        merusak fungsi website</li>
                                    <li class="mb-2"><i class="bi bi-x-circle text-danger me-2"></i>Menyebarkan virus,
                                        malware, atau kode berbahaya lainnya</li>
                                    <li class="mb-2"><i class="bi bi-x-circle text-danger me-2"></i>Menggunakan informasi
                                        untuk kepentingan komersial tanpa izin</li>
                                    <li class="mb-2"><i class="bi bi-x-circle text-danger me-2"></i>Melakukan tindakan
                                        yang dapat merugikan reputasi desa</li>
                                    <li class="mb-2"><i class="bi bi-x-circle text-danger me-2"></i>Mengakses area yang
                                        tidak diizinkan atau melakukan hacking</li>
                                </ul>
                            </div>

                            <div class="mb-5">
                                <h3 class="h4 fw-bold mb-3" style="color: var(--primary-green);">4. Akun Pengguna</h3>
                                <p>Untuk mengakses layanan tertentu, Anda perlu membuat akun. Anda bertanggung jawab untuk:
                                </p>
                                <ul class="list-unstyled ms-3">
                                    <li class="mb-2"><i class="bi bi-arrow-right text-primary me-2"></i>Memberikan
                                        informasi yang akurat dan terkini</li>
                                    <li class="mb-2"><i class="bi bi-arrow-right text-primary me-2"></i>Menjaga
                                        kerahasiaan password akun Anda</li>
                                    <li class="mb-2"><i class="bi bi-arrow-right text-primary me-2"></i>Segera melaporkan
                                        jika akun Anda disalahgunakan</li>
                                    <li class="mb-2"><i class="bi bi-arrow-right text-primary me-2"></i>Memperbarui
                                        informasi profil secara berkala</li>
                                </ul>
                            </div>

                            <div class="mb-5">
                                <h3 class="h4 fw-bold mb-3" style="color: var(--primary-green);">5. Privasi dan Perlindungan
                                    Data</h3>
                                <p>Kami menghormati privasi Anda dan berkomitmen untuk melindungi data pribadi yang Anda
                                    berikan. Informasi yang kami kumpulkan akan digunakan untuk:</p>
                                <ul class="list-unstyled ms-3">
                                    <li class="mb-2"><i class="bi bi-shield-check text-info me-2"></i>Memberikan layanan
                                        yang Anda minta</li>
                                    <li class="mb-2"><i class="bi bi-shield-check text-info me-2"></i>Komunikasi terkait
                                        layanan desa</li>
                                    <li class="mb-2"><i class="bi bi-shield-check text-info me-2"></i>Perbaikan dan
                                        pengembangan layanan</li>
                                    <li class="mb-2"><i class="bi bi-shield-check text-info me-2"></i>Keperluan
                                        administratif yang sah</li>
                                </ul>
                            </div>

                            <div class="mb-5">
                                <h3 class="h4 fw-bold mb-3" style="color: var(--primary-green);">6. Konten dan Hak Kekayaan
                                    Intelektual</h3>
                                <p>Semua konten yang terdapat dalam website ini, termasuk namun tidak terbatas pada teks,
                                    gambar, logo, dan desain, adalah milik Pemerintah Desa Kilwaru atau pihak ketiga yang
                                    telah memberikan izin penggunaan.</p>
                                <div class="alert alert-warning" role="alert">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    <strong>Perhatian:</strong> Penggunaan konten untuk keperluan komersial tanpa izin
                                    tertulis adalah melanggar hukum.
                                </div>
                            </div>

                            <div class="mb-5">
                                <h3 class="h4 fw-bold mb-3" style="color: var(--primary-green);">7. Layanan Pihak Ketiga
                                </h3>
                                <p>Website ini mungkin menggunakan layanan pihak ketiga seperti Google Maps, sistem
                                    pembayaran, atau platform media sosial. Penggunaan layanan tersebut tunduk pada syarat
                                    dan ketentuan masing-masing penyedia layanan.</p>
                            </div>

                            <div class="mb-5">
                                <h3 class="h4 fw-bold mb-3" style="color: var(--primary-green);">8. Pembatasan Tanggung
                                    Jawab</h3>
                                <p>Pemerintah Desa Kilwaru tidak bertanggung jawab atas:</p>
                                <ul class="list-unstyled ms-3">
                                    <li class="mb-2"><i class="bi bi-exclamation-circle text-warning me-2"></i>Kerugian
                                        yang timbul akibat penggunaan website</li>
                                    <li class="mb-2"><i class="bi bi-exclamation-circle text-warning me-2"></i>Gangguan
                                        teknis atau ketidaktersediaan layanan</li>
                                    <li class="mb-2"><i class="bi bi-exclamation-circle text-warning me-2"></i>Kesalahan
                                        informasi yang bersumber dari pihak ketiga</li>
                                    <li class="mb-2"><i class="bi bi-exclamation-circle text-warning me-2"></i>Kerusakan
                                        sistem akibat virus atau malware</li>
                                </ul>
                            </div>

                            <div class="mb-5">
                                <h3 class="h4 fw-bold mb-3" style="color: var(--primary-green);">9. Perubahan Ketentuan</h3>
                                <p>Pemerintah Desa Kilwaru berhak untuk mengubah syarat dan ketentuan ini sewaktu-waktu
                                    tanpa pemberitahuan sebelumnya. Perubahan akan berlaku sejak dipublikasikan di website
                                    ini. Kami menyarankan Anda untuk memeriksa halaman ini secara berkala.</p>
                            </div>

                            <div class="mb-5">
                                <h3 class="h4 fw-bold mb-3" style="color: var(--primary-green);">10. Penyelesaian Sengketa
                                </h3>
                                <p>Segala sengketa yang timbul terkait penggunaan website ini akan diselesaikan melalui:</p>
                                <ol class="list-unstyled ms-3">
                                    <li class="mb-2"><strong>1.</strong> Musyawarah dan mufakat</li>
                                    <li class="mb-2"><strong>2.</strong> Mediasi oleh pihak yang berwenang</li>
                                    <li class="mb-2"><strong>3.</strong> Pengadilan yang berwenang sesuai hukum Indonesia
                                    </li>
                                </ol>
                            </div>

                            <div class="mb-5">
                                <h3 class="h4 fw-bold mb-3" style="color: var(--primary-green);">11. Kontak</h3>
                                <p>Jika Anda memiliki pertanyaan tentang syarat dan ketentuan ini, silakan hubungi kami
                                    melalui:</p>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-envelope text-primary me-2"></i>
                                            <span>Email: admin@desakilwaru.id</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-telephone text-primary me-2"></i>
                                            <span>Telepon: (0123) 456-7890</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-geo-alt text-primary me-2"></i>
                                            <span>Kantor Desa Kilwaru</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-clock text-primary me-2"></i>
                                            <span>Senin - Jumat, 08:00 - 16:00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info" role="alert">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Catatan:</strong> Dengan mendaftar akun atau menggunakan layanan di website ini,
                                Anda dianggap telah membaca, memahami, dan menyetujui seluruh syarat dan ketentuan yang
                                berlaku.
                            </div>

                            <div class="text-center mt-5">
                                <a href="{{ url('/') }}" class="btn btn-primary me-3">
                                    <i class="bi bi-house me-2"></i>Kembali ke Beranda
                                </a>
                                <a href="#" class="btn btn-outline-primary">
                                    <i class="bi bi-envelope me-2"></i>Hubungi Kami
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Links -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-4">
                <h3 class="h4 fw-bold" style="color: var(--primary-green);">Dokumen Terkait</h3>
                <p class="text-muted">Baca juga dokumen penting lainnya</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="bi bi-shield-lock text-primary" style="font-size: 2rem;"></i>
                            <h6 class="card-title mt-3">Kebijakan Privasi</h6>
                            <a href="#" class="btn btn-sm btn-outline-primary">Baca</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="bi bi-question-circle text-primary" style="font-size: 2rem;"></i>
                            <h6 class="card-title mt-3">FAQ</h6>
                            <a href="#" class="btn btn-sm btn-outline-primary">Baca</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="bi bi-book text-primary" style="font-size: 2rem;"></i>
                            <h6 class="card-title mt-3">Panduan Layanan</h6>
                            <a href="#" class="btn btn-sm btn-outline-primary">Baca</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="bi bi-telephone text-primary" style="font-size: 2rem;"></i>
                            <h6 class="card-title mt-3">Kontak Bantuan</h6>
                            <a href="#" class="btn btn-sm btn-outline-primary">Hubungi</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Smooth scrolling for internal links
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

        // Add scroll progress indicator
        const progressBar = document.createElement('div');
        progressBar.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 3px;
        background: var(--accent-orange);
        z-index: 9999;
        transition: width 0.1s ease;
    `;
        document.body.appendChild(progressBar);

        window.addEventListener('scroll', () => {
            const scrolled = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
            progressBar.style.width = scrolled + '%';
        });
    </script>
@endpush
