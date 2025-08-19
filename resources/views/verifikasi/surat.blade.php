@extends('template.main')

@push('styles')
    <style>
        /* Enhancement untuk halaman verifikasi */
        .verification-section {
            background: var(--cream);
            padding: 100px 0 80px;
            min-height: 100vh;
        }

        .verification-card {
            background: var(--warm-white);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 30px;
            border: none;
            animation: slideInUp 0.8s ease-out;
        }

        .verification-header {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
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
            animation: pulse 2s infinite;
        }

        .verification-icon.success {
            background: var(--accent-orange);
            color: white;
            box-shadow: 0 0 30px rgba(255, 140, 66, 0.5);
        }

        .verification-icon.error {
            background: #dc3545;
            color: white;
            box-shadow: 0 0 30px rgba(220, 53, 69, 0.5);
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
        }

        .status-badge.success {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .status-badge.error {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            border: 2px solid #dc3545;
        }

        .verification-body {
            padding: 2.5rem;
        }

        .info-row {
            display: flex;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f0f0f0;
            align-items: center;
        }

        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .info-label {
            font-weight: 600;
            color: var(--primary-green);
            width: 40%;
            font-size: 0.95rem;
        }

        .info-value {
            color: var(--soft-gray);
            width: 60%;
            font-size: 1rem;
        }

        .info-value.highlight {
            color: var(--primary-green);
            font-weight: 600;
        }

        .section-divider {
            margin: 2rem 0;
            border: none;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--light-green), transparent);
        }

        .enhanced-info-section {
            background: linear-gradient(135deg, #f8f9fa, #f1f3f4);
            padding: 2rem;
            border-radius: 15px;
            margin: 2rem 0;
            border-left: 4px solid var(--accent-orange);
        }

        .enhanced-info-section h5 {
            color: var(--primary-green);
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .real-time-info {
            background: linear-gradient(135deg, var(--accent-orange), #e07a35);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            text-align: center;
            margin: 1rem 0;
        }

        .real-time-time {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-family: 'Courier New', monospace;
            letter-spacing: 1px;
        }

        .real-time-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .stat-item {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #f0f0f0;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--accent-orange);
            display: block;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--soft-gray);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .footer-note {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #f0f0f0;
            color: var(--soft-gray);
            font-style: italic;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .verification-section {
                padding: 80px 0 60px;
            }

            .verification-body {
                padding: 2rem 1.5rem;
            }

            .enhanced-info-section {
                padding: 1.5rem;
            }

            .info-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .info-label,
            .info-value {
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .verification-icon {
                width: 80px;
                height: 80px;
                font-size: 2rem;
            }
        }

        /* Animation enhancements */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

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

        /* Loading state untuk real-time updates */
        .loading-shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
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
                            <div
                                class="verification-icon {{ ($verifikasi->status ?? 'found') == 'Approve' || ($verifikasi->status ?? 'found') == 'TERVERIFIKASI' || ($verifikasi->status ?? 'found') != 'not_found' ? 'success' : 'error' }}">
                                @if (
                                    ($verifikasi->status ?? 'found') == 'Approve' ||
                                        ($verifikasi->status ?? 'found') == 'TERVERIFIKASI' ||
                                        ($verifikasi->status ?? 'found') != 'not_found')
                                    <i class="bi bi-check-lg"></i>
                                @else
                                    <i class="bi bi-x-lg"></i>
                                @endif
                            </div>

                            <!-- Status Badge -->
                            <div
                                class="status-badge {{ ($verifikasi->status ?? 'found') == 'Approve' || ($verifikasi->status ?? 'found') == 'TERVERIFIKASI' || ($verifikasi->status ?? 'found') != 'not_found' ? 'success' : 'error' }}">
                                <i class="bi bi-shield-check me-2"></i>
                                @if (
                                    ($verifikasi->status ?? 'found') == 'Approve' ||
                                        ($verifikasi->status ?? 'found') == 'TERVERIFIKASI' ||
                                        ($verifikasi->status ?? 'found') != 'not_found')
                                    TERVERIFIKASI
                                @else
                                    TIDAK AKTIF
                                @endif
                            </div>
                        </div>

                        <!-- Body Section -->
                        <div class="verification-body">
                            <!-- Document Information -->
                            <div class="info-row">
                                <div class="info-label">Status dokumen</div>
                                <div class="info-value">
                                    @if (
                                        ($verifikasi->status ?? 'found') == 'Approve' ||
                                            ($verifikasi->status ?? 'found') == 'TERVERIFIKASI' ||
                                            ($verifikasi->status ?? 'found') != 'not_found')
                                        <span class="badge bg-success">TERVERIFIKASI</span>
                                    @else
                                        <span class="badge bg-danger">TIDAK AKTIF</span>
                                    @endif
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="info-label">No. Surat</div>
                                <div class="info-value highlight">
                                    {{ $verifikasi->no_surat ?? ($verifikasi->nomor_surat ?? 'N/A') }}
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="info-label">Nama Pemohon</div>
                                <div class="info-value">
                                    {{ $verifikasi->nama ?? ($verifikasi->nama_pemohon ?? 'N/A') }}
                                </div>
                            </div>

                            <div class="info-row">
                                <div class="info-label">Jenis Surat</div>
                                <div class="info-value">
                                    @if (isset($verifikasi->type_surat))
                                        {{ $verifikasi->type_surat }}
                                    @elseif (isset($verifikasi->jenis_surat))
                                        {{ $verifikasi->jenis_surat }}
                                    @else
                                        {{ $verifikasi->jenis_surat ?? 'SURAT KETERANGAN' }}
                                    @endif
                                </div>
                            </div>

                            <hr class="section-divider">

                            <!-- Enhanced Information Section -->
                            <div class="enhanced-info-section">
                                <h5>
                                    <i class="bi bi-info-circle"></i>
                                    Informasi Verifikasi
                                </h5>

                                <div class="info-row">
                                    <div class="info-label">Tanggal Terbit</div>
                                    <div class="info-value">
                                        {{ isset($verifikasi->tanggal_terbit) ? \Carbon\Carbon::parse($verifikasi->tanggal_terbit)->locale('id')->isoFormat('D MMMM Y') : \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">Penandatanganan</div>
                                    <div class="info-value">
                                        {{ $verifikasi->penandatangan ?? 'SIDIK RUMALOWAK, S.Pd, MMP, M.Si' }}
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="info-label">Dikeluarkan oleh</div>
                                    <div class="info-value">
                                        {{ $verifikasi->dikeluarkan_oleh ?? 'Kantor Desa Akat Fadedo' }}
                                    </div>
                                </div>

                                <!-- Real-time Information -->
                                <div class="real-time-info">
                                    <div class="real-time-time" id="waktuVerifikasi">
                                        {{ $waktuScanTerakhir ? $waktuScanTerakhir->format('H:i:s') : \Carbon\Carbon::now()->format('H:i:s') }}
                                    </div>
                                    <div class="real-time-label">Waktu Verifikasi Terakhir</div>
                                </div>

                                <!-- Enhanced Stats -->
                                <div class="stats-grid">
                                    <div class="stat-item">
                                        <span class="stat-number" id="totalVerifikasi">{{ $totalVerifikasi ?? 1 }}</span>
                                        <div class="stat-label">Total Verifikasi</div>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-number" id="ipAddress">{{ request()->ip() }}</span>
                                        <div class="stat-label">IP Verifikasi</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Note -->
                            <div class="footer-note">
                                <p class="mb-0">
                                    <i class="bi bi-shield-check me-2"></i>
                                    Dokumen ini telah diverifikasi secara digital dan memiliki kekuatan hukum yang sah.
                                    <br>
                                    Untuk penjelasan lebih lanjut, silahkan menghubungi Kantor Desa Akat Fadedo
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
            const nomorSurat = '{{ $verifikasi->no_surat ?? ($verifikasi->nomor_surat ?? '') }}';

            // Real-time clock update
            function updateWaktuVerifikasi() {
                const now = new Date();
                const timeString = now.toTimeString().split(' ')[0]; // HH:MM:SS format
                document.getElementById('waktuVerifikasi').textContent = timeString;
            }

            // Update setiap detik
            setInterval(updateWaktuVerifikasi, 1000);

            // Fetch waktu scan terakhir dari server (enhanced)
            async function fetchWaktuTerakhir() {
                if (!nomorSurat) return;

                try {
                    const response = await fetch(`/api/verifikasi/waktu/${encodeURIComponent(nomorSurat)}`);
                    const data = await response.json();

                    if (data.waktu_terakhir) {
                        document.getElementById('waktuVerifikasi').textContent = data.formatted;
                    }
                } catch (error) {
                    console.log('Error fetching latest verification time:', error);
                }
            }

            // Fetch statistik dokumen
            async function fetchStatistikDokumen() {
                if (!nomorSurat) return;

                try {
                    const response = await fetch(`/api/verifikasi/statistik/${encodeURIComponent(nomorSurat)}`);
                    const data = await response.json();

                    // Update total verifikasi
                    if (data.total_verifikasi) {
                        const totalElement = document.getElementById('totalVerifikasi');
                        animateNumber(totalElement, data.total_verifikasi);
                    }

                    // Bisa ditambah statistik lain seperti unique IPs, dll
                    console.log('Statistik dokumen:', data);
                } catch (error) {
                    console.log('Error fetching document statistics:', error);
                }
            }

            // Animate number counting
            function animateNumber(element, targetNumber) {
                const currentNumber = parseInt(element.textContent) || 0;
                const increment = Math.max(1, Math.ceil((targetNumber - currentNumber) / 20));
                let current = currentNumber;

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= targetNumber) {
                        current = targetNumber;
                        clearInterval(timer);
                    }
                    element.textContent = current;
                }, 50);
            }

            // Initial fetch
            fetchWaktuTerakhir();
            fetchStatistikDokumen();

            // Periodic update (setiap 30 detik)
            setInterval(fetchWaktuTerakhir, 30000);
            setInterval(fetchStatistikDokumen, 60000);

            // Add some interactive effects
            const verificationCard = document.querySelector('.verification-card');

            // Add subtle hover effect
            verificationCard.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.transition = 'all 0.3s ease';
            });

            verificationCard.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });

            // Add copy functionality for nomor surat
            const nomorSuratElement = document.querySelector('.info-value.highlight');
            if (nomorSuratElement) {
                nomorSuratElement.style.cursor = 'pointer';
                nomorSuratElement.title = 'Klik untuk copy nomor surat';

                nomorSuratElement.addEventListener('click', function() {
                    navigator.clipboard.writeText(this.textContent.trim()).then(() => {
                        // Show tooltip or notification
                        const originalText = this.textContent;
                        this.textContent = '✓ Disalin!';
                        this.style.color = 'var(--accent-orange)';

                        setTimeout(() => {
                            this.textContent = originalText;
                            this.style.color = '';
                        }, 2000);
                    });
                });
            }

            // Enhanced fade-in animation for mobile
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('.fade-in').forEach(el => {
                observer.observe(el);
            });

            console.log('Verifikasi surat page loaded successfully! ✅');
        });

        // Error handling untuk development
        window.addEventListener('error', function(e) {
            console.error('JavaScript error in verifikasi page:', e.error);
        });
    </script>
@endpush
