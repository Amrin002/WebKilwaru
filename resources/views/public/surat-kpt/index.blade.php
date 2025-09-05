@extends('template.main')

@section('title', 'Surat Keterangan Penghasilan Tetap - ' . config('app.village_name', 'Desa Kilwaru'))
@section('description', 'Layanan pengajuan Surat Keterangan Penghasilan Tetap online untuk warga ' .
    config('app.village_name', 'Desa Kilwaru'))

    @push('styles')
        <style>
            .skpt-hero {
                background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 89, 0.8)),
                    url('https://images.unsplash.com/photo-1450101499163-c8848c66ca85?ixlib=rb-4.0.3') center/cover;
                color: white;
                padding: 100px 0 50px;
                margin-top: -80px;
                padding-top: 160px;
            }

            .service-card {
                background: white;
                border-radius: 20px;
                padding: 40px 30px;
                text-align: center;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
                height: 100%;
                border: none;
            }

            .service-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            }

            .service-icon {
                width: 80px;
                height: 80px;
                background: linear-gradient(135deg, var(--accent-orange), #ff6b1a);
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2rem;
                margin: 0 auto 25px;
                transition: all 0.3s ease;
            }

            .service-card:hover .service-icon {
                transform: scale(1.1) rotate(5deg);
            }

            .btn-service {
                background: var(--primary-green);
                border: none;
                border-radius: 50px;
                padding: 15px 35px;
                font-weight: 600;
                font-size: 1.1rem;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(45, 80, 22, 0.3);
                width: 100%;
                margin-top: 20px;
            }

            .btn-service:hover {
                background: var(--secondary-green);
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(45, 80, 22, 0.4);
            }

            .btn-track {
                background: var(--accent-orange);
                border: none;
                border-radius: 50px;
                padding: 15px 35px;
                font-weight: 600;
                font-size: 1.1rem;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(255, 140, 66, 0.3);
                width: 100%;
                margin-top: 20px;
            }

            .btn-track:hover {
                background: #e07a35;
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(255, 140, 66, 0.4);
            }

            .track-form {
                background: white;
                border-radius: 20px;
                padding: 30px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                max-width: 500px;
                margin: 30px auto 0;
            }

            .track-input {
                border: 2px solid #e0e0e0;
                border-radius: 15px;
                padding: 15px 20px;
                font-size: 16px;
                transition: all 0.3s ease;
                margin-bottom: 20px;
            }

            .track-input:focus {
                border-color: var(--accent-orange);
                box-shadow: 0 0 0 0.2rem rgba(255, 140, 66, 0.25);
            }

            .info-section {
                background: #f8f9fa;
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
                background: #d4eaf5;
                color: #185a9d;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                margin: 0 auto 20px;
            }

            .step-number {
                width: 50px;
                height: 50px;
                background: #ff6b1a;
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                font-size: 1.2rem;
                margin: 0 auto 15px;
            }

            .requirements-list {
                list-style: none;
                padding: 0;
            }

            .requirements-list li {
                padding: 10px 0;
                border-bottom: 1px solid #f0f0f0;
                position: relative;
                padding-left: 30px;
            }

            .requirements-list li:before {
                content: '✓';
                position: absolute;
                left: 0;
                color: #185a9d;
                font-weight: bold;
            }

            .requirements-list li:last-child {
                border-bottom: none;
            }

            .modal-content {
                border-radius: 20px;
                border: none;
            }

            .modal-header {
                background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
                color: white;
                border-radius: 20px 20px 0 0;
            }

            .stats-section {
                background: #eef4f9;
                padding: 80px 0;
            }

            .stats-counter {
                text-align: center;
                padding: 20px;
            }

            .stat-number {
                font-size: 2.5rem;
                font-weight: 700;
                color: #185a9d;
                display: block;
            }

            .stat-label {
                color: #6c757d;
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 1px;
                font-size: 0.9rem;
            }

            @media (max-width: 768px) {
                .skpt-hero {
                    padding: 80px 0 40px;
                    padding-top: 140px;
                }

                .service-card {
                    padding: 30px 20px;
                    margin-bottom: 20px;
                }

                .track-form {
                    margin: 20px 15px 0;
                    padding: 25px 20px;
                }

                .info-section {
                    padding: 60px 0;
                }

                .btn-service,
                .btn-track {
                    padding: 12px 25px;
                    font-size: 1rem;
                }
            }
        </style>
    @endpush

@section('content')
    <section class="skpt-hero" id="skptHero">
        <div class="container">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-4 hero-animation">Surat Keterangan Penghasilan Tetap</h1>
                <p class="lead hero-animation">Layanan pengajuan SKPT online untuk kemudahan warga
                    {{ config('app.village_name', 'Desa Kilwaru') }}</p>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6 mb-4">
                    <div class="service-card fade-in">
                        <div class="service-icon">
                            <i class="bi bi-file-earmark-plus"></i>
                        </div>
                        <h3 class="mb-3">Buat Pengajuan Baru</h3>
                        <p class="text-muted mb-4">
                            Ajukan permohonan Surat Keterangan Penghasilan Tetap secara online dengan mudah dan cepat.
                            Pastikan data yang diisi sudah benar dan lengkap.
                        </p>
                        <a href="{{ route('public.surat-kpt.form') }}" class="btn btn-service text-white">
                            <i class="bi bi-plus-circle me-2"></i>
                            Buat Pengajuan
                        </a>
                    </div>
                </div>

                <div class="col-lg-5 col-md-6 mb-4">
                    <div class="service-card fade-in">
                        <div class="service-icon">
                            <i class="bi bi-search"></i>
                        </div>
                        <h3 class="mb-3">Lacak Status Surat</h3>
                        <p class="text-muted mb-4">
                            Cek status pengajuan surat Anda menggunakan kode tracking yang diberikan setelah pengajuan.
                        </p>
                        <button type="button" class="btn btn-track text-white" data-bs-toggle="modal"
                            data-bs-target="#trackModal">
                            <i class="bi bi-binoculars me-2"></i>
                            Lacak Status
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="stats-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title fade-in">Statistik Layanan SKPT</h2>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stats-counter fade-in">
                        <span class="stat-number" data-target="{{ $statistik['total'] ?? 0 }}">0</span>
                        <div class="stat-label">Total Pengajuan</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stats-counter fade-in">
                        <span class="stat-number" data-target="{{ $statistik['disetujui'] ?? 0 }}">0</span>
                        <div class="stat-label">Surat Disetujui</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stats-counter fade-in">
                        <span class="stat-number" data-target="{{ $statistik['diproses'] ?? 0 }}">0</span>
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

    <section class="info-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="info-card fade-in">
                        <div class="info-icon">
                            <i class="bi bi-clipboard-check"></i>
                        </div>
                        <h4 class="mb-3">Persyaratan</h4>
                        <ul class="requirements-list text-start">
                            <li>KTP yang masih berlaku</li>
                            <li>Kartu Keluarga (KK)</li>
                            <li>Surat pengantar dari RT/RW</li>
                            <li>Surat Keterangan Gaji/Penghasilan dari atasan/pemberi kerja</li>
                            <li>Identitas lain yang relevan (jika diperlukan)</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="info-card fade-in">
                        <div class="info-icon">
                            <i class="bi bi-list-ol"></i>
                        </div>
                        <h4 class="mb-3">Alur Proses</h4>
                        <div class="text-start">
                            <div class="d-flex align-items-center mb-3">
                                <div class="step-number me-3">1</div>
                                <span>Isi formulir online</span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="step-number me-3">2</div>
                                <span>Submit pengajuan</span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="step-number me-3">3</div>
                                <span>Verifikasi data oleh petugas</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="step-number me-3">4</div>
                                <span>Surat dapat diambil</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="info-card fade-in">
                        <div class="info-icon">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <h4 class="mb-3">Bantuan</h4>
                        <div class="text-start">
                            <p><strong>Jam Pelayanan:</strong><br>
                                Senin - Jumat: 08:00 - 15:00<br>
                                Sabtu: 08:00 - 12:00</p>
                            <p><strong>Kontak:</strong><br>
                                Telp: (0123) 456-7890<br>
                                WhatsApp: +62 812-3456-7890</p>
                            <p><strong>Lokasi:</strong><br>
                                Kantor Desa {{ config('app.village_name', 'Kilwaru') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="trackModal" tabindex="-1" aria-labelledby="trackModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="trackModalLabel">
                        <i class="bi bi-search me-2"></i>
                        Lacak Status Surat
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="trackingForm" method="GET" action="{{ route('public.surat-kpt.index') }}">
                        <div class="mb-3">
                            <label for="trackingToken" class="form-label">Kode Tracking</label>
                            <input type="text" class="form-control track-input" id="trackingToken" name="token"
                                placeholder="Masukkan kode tracking Anda (contoh: 1234567890Aqwerty)" required
                                maxlength="32">
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Kode tracking diberikan setelah pengajuan surat berhasil dibuat.
                                Salin dan tempel kode dari WhatsApp/SMS yang Anda terima.
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-track text-white">
                                <i class="bi bi-search me-2"></i>
                                Cari Status Surat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
            const trackForm = document.querySelector('#trackingForm');
            const trackingInput = document.getElementById('trackingToken');

            if (trackForm) {
                trackForm.addEventListener('submit', function(e) {
                    const token = trackingInput.value.trim();

                    // Basic validation
                    if (token.length < 10) {
                        e.preventDefault();
                        showTrackingError('Kode tracking minimal 10 karakter');
                        return false;
                    }

                    // Modify form action to redirect to the correct track route
                    const trackUrl = "{{ route('public.surat-kpt.track', ':token') }}".replace(':token',
                        token);

                    // Set loading state
                    const submitButton = this.querySelector('button[type="submit"]');
                    submitButton.innerHTML =
                        '<i class="spinner-border spinner-border-sm me-2"></i>Mencari...';
                    submitButton.disabled = true;

                    // Redirect manually
                    e.preventDefault();
                    window.location.href = trackUrl;
                });

                // Clear error when user types
                trackingInput.addEventListener('input', function() {
                    clearTrackingError();
                });
            }

            // Helper functions
            function showTrackingError(message) {
                trackingInput.classList.add('is-invalid');

                const existingFeedback = trackingInput.parentNode.querySelector('.invalid-feedback');
                if (existingFeedback) {
                    existingFeedback.remove();
                }

                const errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback';
                errorDiv.textContent = message;
                trackingInput.parentNode.appendChild(errorDiv);

                trackingInput.focus();
            }

            function clearTrackingError() {
                trackingInput.classList.remove('is-invalid');
                const feedback = trackingInput.parentNode.querySelector('.invalid-feedback');
                if (feedback) {
                    feedback.remove();
                }
            }

            // Format tracking input
            if (trackingInput) {
                trackingInput.addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
                });

                trackingInput.addEventListener('paste', function(e) {
                    setTimeout(() => {
                        this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
                    }, 10);
                });
            }

            console.log('SKPT public page scripts loaded successfully! 📄');
        });

        // Handle URL with tracking token (if redirected from another page)
        const urlParams = new URLSearchParams(window.location.search);
        const autoTrack = urlParams.get('track');
        if (autoTrack) {
            // Auto-open modal and fill token
            const trackModal = new bootstrap.Modal(document.getElementById('trackModal'));
            trackModal.show();
            document.getElementById('trackingToken').value = autoTrack;
        }
    </script>
@endpush
