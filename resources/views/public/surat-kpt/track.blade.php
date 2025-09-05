@extends('template.main')

@section('title', 'Tracking Surat Keterangan Penghasilan Tetap - ' . config('app.village_name', 'Desa Kilwaru'))
@section('description', 'Lacak status pengajuan Surat Keterangan Pengantar online untuk warga ' .
    config('app.village_name', 'Desa Kilwaru'))

    @push('styles')
        <style>
            /* CSS Disesuaikan dari Surat KTU ke Surat KPT */
            .skpt-hero {
                background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 89, 0.8)),
                    url('https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?ixlib=rb-4.0.3') center/cover;
                color: white;
                padding: 100px 0 50px;
                margin-top: -80px;
                padding-top: 160px;
            }

            .status-badge {
                display: inline-block;
                padding: 8px 16px;
                border-radius: 20px;
                font-weight: 600;
                font-size: 0.9rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .status-diproses {
                background: linear-gradient(135deg, #ffc107, #ffca2c);
                color: #8a6914;
            }

            .status-disetujui {
                background: linear-gradient(135deg, #28a745, #34ce57);
                color: white;
            }

            .status-ditolak {
                background: linear-gradient(135deg, #dc3545, #e4606d);
                color: white;
            }

            .detail-item {
                margin-bottom: 1rem;
            }

            .detail-label {
                font-size: 0.9rem;
                font-weight: 600;
                color: var(--soft-gray);
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin-bottom: 5px;
                display: block;
            }

            .detail-value {
                font-size: 1.1rem;
                font-weight: 500;
                color: var(--primary-green);
                padding: 8px 0;
                border-bottom: 2px solid var(--cream);
            }

            .timeline {
                position: relative;
                padding: 20px 0 20px 60px;
            }

            .timeline::before {
                content: '';
                position: absolute;
                left: 30px;
                top: 20px;
                bottom: 20px;
                width: 3px;
                background: linear-gradient(180deg, var(--light-green), var(--secondary-green));
                border-radius: 2px;
            }

            .timeline-item {
                position: relative;
                margin-bottom: 40px;
                background: white;
                border-radius: 15px;
                padding: 20px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
                border: 1px solid rgba(0, 0, 0, 0.05);
                transition: all 0.3s ease;
            }

            .timeline-item:hover {
                transform: translateX(5px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
            }

            .timeline-item:last-child {
                margin-bottom: 0;
            }

            .timeline-marker {
                position: absolute;
                left: -50px;
                top: 25px;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: #e9ecef;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #6c757d;
                font-size: 1.1rem;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                border: 3px solid white;
                z-index: 2;
            }

            .timeline-item.active .timeline-marker {
                background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
                color: white;
                box-shadow: 0 6px 15px rgba(45, 80, 22, 0.3);
            }

            .timeline-title {
                font-weight: 700;
                color: var(--primary-green);
                margin-bottom: 8px;
                font-size: 1.1rem;
            }

            .timeline-text {
                color: var(--soft-gray);
                margin-bottom: 10px;
                line-height: 1.6;
            }

            .timeline-date {
                color: #adb5bd;
                font-size: 0.9rem;
                font-weight: 500;
                display: inline-block;
                background: var(--cream);
                padding: 4px 12px;
                border-radius: 12px;
            }

            .form-control:focus,
            .form-select:focus {
                border-color: var(--accent-orange);
                box-shadow: 0 0 0 0.2rem rgba(255, 140, 66, 0.25);
            }

            [data-theme="dark"] .detail-value {
                color: var(--light-green);
            }

            [data-theme="dark"] .timeline-title {
                color: var(--light-green);
            }

            /* Copy Button */
            .copy-btn {
                background: none;
                border: none;
                color: var(--soft-gray);
                cursor: pointer;
                padding: 5px;
                border-radius: 5px;
                transition: all 0.3s ease;
            }

            .copy-btn:hover {
                color: var(--accent-orange);
                background: rgba(255, 140, 66, 0.1);
            }

            .copy-success {
                color: #28a745 !important;
            }

            .currency-format {
                color: var(--accent-orange);
                font-weight: 600;
            }

            @media (max-width: 768px) {
                .detail-value {
                    font-size: 1rem;
                }

                .timeline {
                    padding: 15px 0 15px 45px;
                }

                .timeline::before {
                    left: 22px;
                }

                .timeline-marker {
                    left: -40px;
                    width: 35px;
                    height: 35px;
                    font-size: 1rem;
                    top: 20px;
                }

                .timeline-item {
                    margin-bottom: 30px;
                    padding: 15px;
                }

                .timeline-title {
                    font-size: 1rem;
                }

                .timeline-text {
                    font-size: 0.9rem;
                }

                .timeline-date {
                    font-size: 0.8rem;
                }
            }
        </style>
    @endpush

@section('content')
    <div class="hero-section"
        style="min-height: 40vh; background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 89, 0.8)), url('https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?ixlib=rb-4.0.3') center/cover no-repeat;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="hero-content text-center hero-animation">
                        <h1 class="display-5 fw-bold text-white mb-3">
                            <i class="bi bi-search me-3"></i>
                            Tracking Surat Keterangan Penghasilan Tetap
                        </h1>
                        <p class="lead text-white mb-4">
                            Lacak status pengajuan surat keterangan penghasilan tetap Anda
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="floating-elements"></div>
    </div>

    <div class="container my-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show fade-in" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show fade-in" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg mb-4 fade-in">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="feature-icon me-3" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                        <i class="bi bi-file-earmark-arrow-up"></i>
                                    </div>
                                    <div>
                                        <h4 class="mb-1 text-primary-green fw-bold">Surat Keterangan Pengantar</h4>
                                        <p class="mb-0 text-muted">Tracking Code:
                                            <strong>{{ $surat->public_token }}</strong>
                                            <button class="copy-btn ms-2"
                                                onclick="copyToClipboard('{{ $surat->public_token }}', this)"
                                                title="Salin kode tracking">
                                                <i class="bi bi-copy"></i>
                                            </button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <div class="status-badge status-{{ $surat->status }}">
                                    <i
                                        class="bi bi-{{ $surat->status === 'diproses' ? 'clock' : ($surat->status === 'disetujui' ? 'check-circle' : 'x-circle') }}"></i>
                                    {{ ucfirst($surat->status) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-lg mb-4 fade-in">
                    <div class="card-header bg-transparent border-0 p-4">
                        <h5 class="mb-0 text-primary-green fw-bold">
                            <i class="bi bi-person-fill me-2"></i>
                            Data Pribadi
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="detail-label">Nama Lengkap</label>
                                    <div class="detail-value">{{ $surat->nama_yang_bersangkutan }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="detail-label">NIK</label>
                                    <div class="detail-value">{{ $surat->nik }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="detail-label">Tempat, Tanggal Lahir</label>
                                    <div class="detail-value">{{ $surat->tempat_lahir }},
                                        {{ \Carbon\Carbon::parse($surat->tanggal_lahir)->format('d F Y') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="detail-label">Jenis Kelamin</label>
                                    <div class="detail-value">{{ $surat->jenis_kelamin }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="detail-label">Agama</label>
                                    <div class="detail-value">{{ $surat->agama }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="detail-label">Pekerjaan</label>
                                    <div class="detail-value">{{ $surat->pekerjaan }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="detail-item">
                                    <label class="detail-label">Alamat</label>
                                    <div class="detail-value">{{ $surat->alamat_yang_bersangkutan }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-lg mb-4 fade-in">
                    <div class="card-header bg-transparent border-0 p-4">
                        <h5 class="mb-0 text-primary-green fw-bold">
                            <i class="bi bi-people-fill me-2"></i>
                            Data Orang Tua
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="detail-label">Nama Ayah</label>
                                    <div class="detail-value">{{ $surat->nama_ayah }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="detail-label">Nama Ibu</label>
                                    <div class="detail-value">{{ $surat->nama_ibu }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="detail-label">Pekerjaan Orang Tua</label>
                                    <div class="detail-value">{{ $surat->pekerjaan_orang_tua }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="detail-label">Penghasilan Per Bulan</label>
                                    <div class="detail-value">
                                        <span class="currency-format">Rp
                                            {{ number_format($surat->penghasilan_per_bulan, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-lg mb-4 fade-in">
                    <div class="card-header bg-transparent border-0 p-4">
                        <h5 class="mb-0 text-primary-green fw-bold">
                            <i class="bi bi-file-text me-2"></i>
                            Detail Surat
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="detail-label">Tanggal Surat</label>
                                    <div class="detail-value">
                                        {{ \Carbon\Carbon::parse($surat->tanggal_surat)->format('d F Y') }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="detail-label">Nomor Telepon</label>
                                    <div class="detail-value">{{ $surat->nomor_telepon }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="detail-item">
                                    <label class="detail-label">Keperluan</label>
                                    <div class="detail-value">{{ $surat->keperluan }}</div>
                                </div>
                            </div>
                            @if ($surat->nomor_surat)
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <label class="detail-label">Nomor Surat</label>
                                        <div class="detail-value text-primary fw-bold">{{ $surat->nomor_surat }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-lg mb-4 fade-in">
                    <div class="card-header bg-transparent border-0 p-4">
                        <h5 class="mb-0 text-primary-green fw-bold">
                            <i class="bi bi-clock-history me-2"></i>
                            Timeline Status
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="timeline">
                            <div class="timeline-item active">
                                <div class="timeline-marker">
                                    <i class="bi bi-plus-circle"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Pengajuan Dibuat</h6>
                                    <p class="timeline-text">Surat berhasil diajukan ke sistem</p>
                                    <small class="timeline-date">{{ $surat->created_at->format('d F Y, H:i') }}
                                        WIB</small>
                                </div>
                            </div>
                            <div class="timeline-item {{ $surat->status !== 'diproses' ? 'active' : '' }}">
                                <div class="timeline-marker">
                                    <i
                                        class="bi bi-{{ $surat->status === 'diproses' ? 'clock' : ($surat->status === 'disetujui' ? 'check-circle' : 'x-circle') }}"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">
                                        @if ($surat->status === 'diproses')
                                            Sedang Diproses
                                        @elseif($surat->status === 'disetujui')
                                            Surat Disetujui
                                        @else
                                            Surat Ditolak
                                        @endif
                                    </h6>
                                    <p class="timeline-text">
                                        @if ($surat->status === 'diproses')
                                            Surat sedang dalam tahap review dan verifikasi
                                        @elseif($surat->status === 'disetujui')
                                            Surat telah disetujui dan dapat diunduh
                                        @else
                                            Surat ditolak dengan alasan: {{ $surat->keterangan ?: 'Tidak ada keterangan' }}
                                        @endif
                                    </p>
                                    @if ($surat->status !== 'diproses')
                                        <small class="timeline-date">{{ $surat->updated_at->format('d F Y, H:i') }}
                                            WIB</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-lg mb-4 fade-in">
                    <div class="card-body p-4">
                        <div class="row g-3 justify-content-center align-items-center">
                            @if ($surat->status === 'disetujui')
                                <div
                                    class="col-md-5 col-12 d-flex justify-content-md-end justify-content-center mb-2 mb-md-0">
                                    <a href="{{ route('public.surat-kpt.export', [$surat->id, $surat->public_token]) }}"
                                        class="btn btn-primary w-100 py-3 fw-bold"
                                        style="border-radius: 50px; background: var(--accent-orange); border: none;"
                                        target="_blank">
                                        <i class="bi bi-download me-2"></i>
                                        Download Surat
                                    </a>
                                </div>
                            @endif
                            <div class="col-md-5 col-12 d-flex justify-content-md-start justify-content-center">
                                <a href="{{ route('public.surat-kpt.index') }}"
                                    class="btn btn-outline-secondary w-100 py-3 fw-bold" style="border-radius: 50px;">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Copy to clipboard function
        function copyToClipboard(text, button) {
            if (!navigator.clipboard || !navigator.clipboard.writeText) {
                // Fallback for older browsers
                const textarea = document.createElement('textarea');
                textarea.value = text;
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    const successful = document.execCommand('copy');
                    const msg = successful ? 'Berhasil disalin!' : 'Gagal menyalin.';
                    console.log(msg);
                    showToast(msg, 'success');
                } catch (err) {
                    console.error('Failed to copy fallback: ', err);
                    showToast('Gagal menyalin ke clipboard', 'error');
                }
                document.body.removeChild(textarea);
                return;
            }

            navigator.clipboard.writeText(text).then(function() {
                // Change icon to success
                const icon = button.querySelector('i');
                const originalClass = icon.className;

                icon.className = 'bi bi-check';
                button.classList.add('copy-success');
                button.title = 'Tersalin!';

                // Show toast notification
                const toast = document.createElement('div');
                toast.classList.add('toast', 'align-items-center', 'text-white', 'bg-success', 'border-0',
                    'fade-in-up');
                toast.setAttribute('role', 'alert');
                toast.setAttribute('aria-live', 'assertive');
                toast.setAttribute('aria-atomic', 'true');
                toast.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">
                            Berhasil disalin ke clipboard!
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                `;
                document.body.appendChild(toast);
                const bsToast = new bootstrap.Toast(toast);
                bsToast.show();

                // Reset after 2 seconds
                setTimeout(() => {
                    icon.className = originalClass;
                    button.classList.remove('copy-success');
                    button.title = 'Salin kode tracking';
                    if (document.body.contains(toast)) {
                        document.body.removeChild(toast);
                    }
                }, 2000);

            }).catch(function(err) {
                console.error('Failed to copy: ', err);
                showToast('Gagal menyalin ke clipboard', 'error');
            });
        }

        // Toast notification function
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            const bgColor = type === 'success' ? '#28a745' : '#dc3545';
            const iconClass = type === 'success' ? 'bi bi-check-circle' : 'bi bi-exclamation-triangle';

            toast.style.cssText = `
                position: fixed;
                bottom: 20px;
                left: 50%;
                transform: translateX(-50%);
                background: ${bgColor};
                color: white;
                padding: 12px 20px;
                border-radius: 12px;
                z-index: 99999;
                font-size: 0.9rem;
                font-weight: 600;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
                animation: fadeInUp 0.3s ease-out;
                opacity: 0;
                display: flex;
                align-items: center;
                gap: 10px;
            `;
            toast.innerHTML = `<i class="${iconClass}"></i> ${message}`;

            document.body.appendChild(toast);

            // Animate in
            setTimeout(() => {
                toast.style.opacity = '1';
                toast.style.transform = 'translate(-50%, 0)';
            }, 10);

            // Animate out after 3 seconds
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translate(-50%, 20px)';
                setTimeout(() => {
                    if (document.body.contains(toast)) {
                        document.body.removeChild(toast);
                    }
                }, 300);
            }, 3000);
        }
    </script>
@endpush
