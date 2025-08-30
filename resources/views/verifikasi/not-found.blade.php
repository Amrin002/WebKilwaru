@extends('template.main')

@push('styles')
    <style>
        /* Enhancement untuk halaman verifikasi not found */
        .verification-section {
            background: var(--cream);
            padding: 100px 0 80px;
            min-height: 100vh;
        }

        .verification-card {
            background: var(--warm-white);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(220, 53, 69, 0.15);
            overflow: hidden;
            margin-bottom: 30px;
            border: none;
            animation: slideInUp 0.8s ease-out;
        }

        .verification-header {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .verification-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="white" opacity="0.1"/><circle cx="80" cy="40" r="1.5" fill="white" opacity="0.1"/></svg>');
            pointer-events: none;
        }

        .verification-icon {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2.5rem;
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.3);
            animation: shake 2s infinite;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .verification-body {
            padding: 2.5rem;
        }

        /* Not Found Specific Styles */
        .not-found-message {
            text-align: center;
            margin: 2rem 0;
        }

        .not-found-icon {
            font-size: 4rem;
            color: #dc3545;
            margin-bottom: 1rem;
            animation: bounce 2s infinite;
        }

        .not-found-title {
            color: #dc3545;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .not-found-description {
            color: var(--soft-gray);
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        /* QR Input Section */
        .qr-input-section {
            background: linear-gradient(135deg, #f8f9fa, #f1f3f4);
            padding: 2rem;
            border-radius: 15px;
            margin: 2rem 0;
            border-left: 4px solid #fd7e14;
        }

        .qr-input-section h5 {
            color: var(--primary-green);
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.2rem rgba(46, 139, 87, 0.25);
        }

        .btn-verify {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-verify:hover {
            background: linear-gradient(135deg, var(--secondary-green), var(--primary-green));
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 139, 87, 0.3);
            color: white;
        }

        .btn-verify:disabled {
            opacity: 0.7;
            pointer-events: none;
            transform: none;
        }

        /* Information Cards */
        .info-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .info-card {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #f0f0f0;
            text-align: center;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .info-card-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .info-card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 0.5rem;
        }

        .info-card-description {
            color: var(--soft-gray);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* Contact Section */
        .contact-section {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin: 2rem 0;
            text-align: center;
        }

        .contact-section h5 {
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .contact-info {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
        }

        .footer-note {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #f0f0f0;
            color: var(--soft-gray);
            font-style: italic;
        }

        /* Loading state */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s ease-in-out infinite;
        }

        /* Animations */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .verification-section {
                padding: 80px 0 60px;
            }

            .verification-body {
                padding: 2rem 1.5rem;
            }

            .qr-input-section {
                padding: 1.5rem;
            }

            .verification-icon {
                width: 80px;
                height: 80px;
                font-size: 2rem;
            }

            .not-found-title {
                font-size: 1.5rem;
            }

            .not-found-icon {
                font-size: 3rem;
            }

            .contact-info {
                flex-direction: column;
                align-items: center;
            }

            .info-cards {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <section class="verification-section fade-in">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7">
                    <div class="verification-card">
                        <!-- Header Section -->
                        <div class="verification-header">
                            <div class="row mb-4">
                                <div class="col-12 text-center">
                                    <img src="{{ asset('asset/img/logo_sbt.png') }}" alt="Logo Desa"
                                        style="max-height: 80px;">
                                    <h4 class="mt-3 fw-bold">VERIFIKASI DOKUMEN RESMI</h4>
                                    <h5>Desa Akat Fadedo</h5>
                                </div>
                            </div>

                            <!-- Status Icon -->
                            <div class="verification-icon">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>

                            <!-- Status Badge -->
                            <div class="status-badge">
                                <i class="bi bi-x-circle me-2"></i>
                                DOKUMEN TIDAK DITEMUKAN
                            </div>
                        </div>

                        <!-- Body Section -->
                        <div class="verification-body">
                            <!-- Not Found Message -->
                            <div class="not-found-message">
                                <div class="not-found-icon">
                                    <i class="bi bi-file-earmark-x"></i>
                                </div>
                                <h3 class="not-found-title">Dokumen Tidak Ditemukan</h3>
                                <p class="not-found-description">
                                    Maaf, dokumen dengan kode QR yang Anda scan tidak ditemukan dalam sistem kami.
                                    Hal ini bisa terjadi karena beberapa alasan di bawah ini.
                                </p>
                            </div>

                            <!-- Document Info Section (Not Found) -->
                            <div class="qr-input-section">
                                <h5>
                                    <i class="bi bi-file-earmark-x"></i>
                                    Informasi Dokumen
                                </h5>

                                <div class="info-row">
                                    <div class="info-label">Status dokumen</div>
                                    <div class="info-value">
                                        <span class="badge bg-danger">TIDAK DITEMUKAN</span>
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">No. Surat</div>
                                    <div class="info-value highlight">
                                        Data tidak tersedia
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">Nama Pemohon</div>
                                    <div class="info-value">
                                        Data tidak tersedia
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">Jenis Surat</div>
                                    <div class="info-value">
                                        Data tidak tersedia
                                    </div>
                                </div>
                            </div>

                            <!-- Information Cards -->
                            <div class="info-cards">
                                <div class="info-card">
                                    <div class="info-card-icon" style="color: #fd7e14;">
                                        <i class="bi bi-clock"></i>
                                    </div>
                                    <div class="info-card-title">Dokumen Belum Diproses</div>
                                    <div class="info-card-description">
                                        Surat mungkin masih dalam tahap proses persetujuan di kantor desa
                                    </div>
                                </div>

                                <div class="info-card">
                                    <div class="info-card-icon" style="color: #dc3545;">
                                        <i class="bi bi-shield-x"></i>
                                    </div>
                                    <div class="info-card-title">Kode QR Tidak Valid</div>
                                    <div class="info-card-description">
                                        QR Code rusak, tidak terbaca, atau bukan dari sistem resmi desa
                                    </div>
                                </div>

                                <div class="info-card">
                                    <div class="info-card-icon" style="color: var(--primary-green);">
                                        <i class="bi bi-calendar-x"></i>
                                    </div>
                                    <div class="info-card-title">Dokumen Kedaluwarsa</div>
                                    <div class="info-card-description">
                                        Masa berlaku dokumen telah habis atau sudah tidak aktif
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Section -->
                            <div class="contact-section">
                                <h5>
                                    <i class="bi bi-telephone me-2"></i>
                                    Butuh Bantuan?
                                </h5>
                                <p class="mb-0">Hubungi kami untuk verifikasi manual atau informasi lebih lanjut</p>
                                <div class="contact-info">
                                    <div class="contact-item">
                                        <i class="bi bi-geo-alt"></i>
                                        Kantor Desa Akat Fadedo
                                    </div>
                                    <div class="contact-item">
                                        <i class="bi bi-telephone"></i>
                                        (0123) 456-7890
                                    </div>
                                    <div class="contact-item">
                                        <i class="bi bi-envelope"></i>
                                        desa@akatfadedo.go.id
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Note -->
                            <div class="footer-note">
                                <p class="mb-0">
                                    <i class="bi bi-shield-check me-2"></i>
                                    Sistem Verifikasi Digital Desa Akat Fadedo
                                    <br>
                                    <small>
                                        Waktu scan: <span
                                            id="waktuScan">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('DD MMMM YYYY, HH:mm:ss') }}</span>
                                        |
                                        IP: <span id="ipAddress">{{ request()->ip() }}</span>
                                    </small>
                                </p>
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
            const form = document.getElementById('verificationForm');
            const btnVerify = document.getElementById('btnVerify');
            const btnText = btnVerify.querySelector('.btn-text');
            const spinner = btnVerify.querySelector('.spinner');
            const nomorSuratInput = document.getElementById('nomorSurat');

            // Auto focus removed for not found page
            // nomorSuratInput.focus();

            // Real-time clock update
            function updateWaktuScan() {
                const now = new Date();
                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                };
                document.getElementById('waktuScan').textContent = now.toLocaleString('id-ID', options);
            }

            // Update setiap detik
            setInterval(updateWaktuScan, 1000);

            // Enhanced animations on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                    }
                });
            }, observerOptions);

            // Observe all animated elements
            document.querySelectorAll('.info-card').forEach(card => {
                observer.observe(card);
            });

            // Add hover effects for better UX
            document.querySelectorAll('.info-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-8px)';
                    this.style.transition = 'all 0.3s ease';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            console.log('Verifikasi Not Found page loaded successfully!');
        });

        // Error handling untuk development
        window.addEventListener('error', function(e) {
            console.error('JavaScript error in verifikasi not found page:', e.error);
        });
    </script>
@endpush
