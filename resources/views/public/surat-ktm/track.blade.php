@extends('template.main')

@section('content')
    <div class="hero-section"
        style="min-height: 40vh; background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 89, 0.8)), url('https://images.unsplash.com/photo-1586953208448-b95a79798f07?ixlib=rb-4.0.3') center/cover no-repeat;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="hero-content text-center hero-animation">
                        <h1 class="display-5 fw-bold text-white mb-3">
                            <i class="bi bi-search me-3"></i>
                            Tracking Surat KTM
                        </h1>
                        <p class="lead text-white mb-4">
                            Lacak status pengajuan surat keterangan tidak mampu Anda
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="floating-elements"></div>
    </div>

    <div class="container my-5">
        <!-- Alert Messages -->
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

        <!-- Main Content -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Header Card -->
                <div class="card border-0 shadow-lg mb-4 fade-in">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="feature-icon me-3" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </div>
                                    <div>
                                        <h4 class="mb-1 text-primary-green fw-bold">Surat Keterangan Tidak Mampu</h4>
                                        <p class="mb-0 text-muted">Tracking Code:
                                            <strong>{{ $surat->public_token }}</strong>
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

                <!-- Detail Surat -->
                <div class="card border-0 shadow-lg mb-4 fade-in">
                    <div class="card-header bg-transparent border-0 p-4">
                        <h5 class="mb-0 text-primary-green fw-bold">
                            <i class="bi bi-person-lines-fill me-2"></i>
                            Detail Pemohon
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="detail-label">Nama Lengkap</label>
                                    <div class="detail-value">{{ $surat->nama }}</div>
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
                                    <label class="detail-label">Status Pernikahan</label>
                                    <div class="detail-value">{{ $surat->status_kawin }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="detail-label">Kewarganegaraan</label>
                                    <div class="detail-value">{{ $surat->kewarganegaraan }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="detail-label">Nomor Telepon</label>
                                    <div class="detail-value">{{ $surat->nomor_telepon ?: '-' }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="detail-item">
                                    <label class="detail-label">Alamat</label>
                                    <div class="detail-value">{{ $surat->alamat }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Timeline -->
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
                                    <small class="timeline-date">{{ $surat->created_at->format('d F Y, H:i') }} WIB</small>
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

                <!-- Info Surat -->
                @if ($surat->status === 'disetujui')
                    <div class="card border-0 shadow-lg mb-4 fade-in">
                        <div class="card-header bg-transparent border-0 p-4">
                            <h5 class="mb-0 text-primary-green fw-bold">
                                <i class="bi bi-file-earmark-check me-2"></i>
                                Informasi Surat
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <label class="detail-label">Nomor Surat</label>
                                        <div class="detail-value">{{ $surat->nomor_surat }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <label class="detail-label">Tanggal Disetujui</label>
                                        <div class="detail-value">{{ $surat->updated_at->format('d F Y') }}</div>
                                    </div>
                                </div>
                                @if ($surat->keterangan)
                                    <div class="col-12">
                                        <div class="detail-item">
                                            <label class="detail-label">Keterangan</label>
                                            <div class="detail-value">{{ $surat->keterangan }}</div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="card border-0 shadow-lg mb-4 fade-in">
                    <div class="card-body p-4">
                        <div class="row g-3 justify-content-center align-items-center">
                            @if ($surat->status === 'disetujui')
                                <div
                                    class="col-md-5 col-12 d-flex justify-content-md-end justify-content-center mb-2 mb-md-0">
                                    <a href="{{ route('public.surat-ktm.export', [$surat->id, $surat->public_token]) }}"
                                        class="btn btn-primary w-100 py-3 fw-bold"
                                        style="border-radius: 50px; background: var(--accent-orange); border: none;"
                                        target="_blank">
                                        <i class="bi bi-download me-2"></i>
                                        Download Surat
                                    </a>
                                </div>
                            @endif

                            <div class="col-md-5 col-12 d-flex justify-content-md-start justify-content-center">
                                <a href="{{ route('public.surat-ktm.index') }}"
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

    <!-- Edit Modal -->
    @if ($surat->status === 'diproses' || $surat->status === 'ditolak')
        <div class="modal fade" id="editModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-pencil me-2"></i>
                            Edit Data Surat
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('public.surat-ktm.update', $surat->public_token) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama"
                                        value="{{ old('nama', $surat->nama) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="tempat_lahir"
                                        value="{{ old('tempat_lahir', $surat->tempat_lahir) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="tanggal_lahir"
                                        value="{{ old('tanggal_lahir', $surat->tanggal_lahir) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select class="form-select" name="jenis_kelamin" required>
                                        <option value="Laki-laki"
                                            {{ old('jenis_kelamin', $surat->jenis_kelamin) === 'Laki-laki' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="Perempuan"
                                            {{ old('jenis_kelamin', $surat->jenis_kelamin) === 'Perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Status Pernikahan <span class="text-danger">*</span></label>
                                    <select class="form-select" name="status_kawin" required>
                                        <option value="Belum Kawin"
                                            {{ old('status_kawin', $surat->status_kawin) === 'Belum Kawin' ? 'selected' : '' }}>
                                            Belum Kawin</option>
                                        <option value="Kawin"
                                            {{ old('status_kawin', $surat->status_kawin) === 'Kawin' ? 'selected' : '' }}>
                                            Kawin</option>
                                        <option value="Cerai Hidup"
                                            {{ old('status_kawin', $surat->status_kawin) === 'Cerai Hidup' ? 'selected' : '' }}>
                                            Cerai Hidup</option>
                                        <option value="Cerai Mati"
                                            {{ old('status_kawin', $surat->status_kawin) === 'Cerai Mati' ? 'selected' : '' }}>
                                            Cerai Mati</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kewarganegaraan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="kewarganegaraan"
                                        value="{{ old('kewarganegaraan', $surat->kewarganegaraan) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nomor Telepon <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" name="nomor_telepon"
                                        value="{{ old('nomor_telepon', $surat->nomor_telepon) }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Alamat <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="alamat" rows="3" required>{{ old('alamat', $surat->alamat) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-2"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <style>
        /* Status Badges */
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

        /* Detail Items */
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

        /* Timeline */
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

        /* Form Enhancements */
        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent-orange);
            box-shadow: 0 0 0 0.2rem rgba(255, 140, 66, 0.25);
        }

        /* Dark theme adjustments */
        [data-theme="dark"] .detail-value {
            color: var(--light-green);
        }

        [data-theme="dark"] .timeline-title {
            color: var(--light-green);
        }

        /* Responsive */
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
@endsection
