{{-- Surat KPT Create Form --}}
@extends('layouts.main')

@push('style')
    <style>
        /* Form Styles */
        .form-container {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--cream);
        }

        .form-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: white;
        }

        .form-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 10px;
        }

        [data-theme="dark"] .form-title {
            color: var(--light-green);
        }

        .form-subtitle {
            color: var(--soft-gray);
            font-size: 1rem;
            margin-bottom: 0;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--cream);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        [data-theme="dark"] .section-title {
            color: var(--light-green);
        }

        .section-icon {
            width: 35px;
            height: 35px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        [data-theme="dark"] .form-label {
            color: var(--light-green);
        }

        .required {
            color: #dc3545;
        }

        .form-control,
        .form-select {
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 12px 16px;
            transition: all 0.3s ease;
            background: var(--warm-white);
            color: inherit;
            font-size: 0.95rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent-orange);
            box-shadow: 0 0 0 0.2rem rgba(255, 140, 66, 0.25);
            background: var(--warm-white);
        }

        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background: var(--warm-white);
            border-color: rgba(255, 255, 255, 0.2);
            color: #333;
        }

        .form-text {
            font-size: 0.8rem;
            color: var(--soft-gray);
            margin-top: 5px;
        }

        .invalid-feedback {
            font-size: 0.8rem;
            color: #dc3545;
            margin-top: 5px;
            display: block;
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: #dc3545;
        }

        /* Button Styles */
        .form-actions {
            background: var(--cream);
            border-radius: 15px;
            padding: 20px;
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            min-width: 120px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45, 80, 22, 0.3);
        }

        .btn-outline-secondary {
            color: var(--soft-gray);
            border: 2px solid var(--soft-gray);
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            background: transparent;
            transition: all 0.3s ease;
            min-width: 120px;
        }

        .btn-outline-secondary:hover {
            background: var(--soft-gray);
            border-color: var(--soft-gray);
            transform: translateY(-2px);
        }

        /* Input Group Styles */
        .input-group-personal,
        .input-group-usaha {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .input-group-birth {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .input-group-status {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        /* Progress Steps */
        .form-progress {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .progress-step {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--soft-gray);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .progress-step.active {
            color: var(--primary-green);
        }

        .progress-step::after {
            content: '→';
            margin-left: 15px;
            color: var(--soft-gray);
        }

        .progress-step:last-child::after {
            display: none;
        }

        .step-number {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--cream);
            border: 2px solid var(--soft-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .progress-step.active .step-number {
            background: var(--primary-green);
            border-color: var(--primary-green);
            color: white;
        }

        /* Card Info */
        .info-card {
            background: linear-gradient(135deg, rgba(255, 140, 66, 0.1), rgba(45, 80, 22, 0.05));
            border: 1px solid rgba(255, 140, 66, 0.2);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .info-card .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--accent-orange);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .info-card h6 {
            color: var(--primary-green);
            font-weight: 600;
            margin-bottom: 10px;
        }

        [data-theme="dark"] .info-card h6 {
            color: var(--light-green);
        }

        .info-card p {
            color: var(--soft-gray);
            margin-bottom: 0;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        /* User Selection Card */
        .user-selection-card {
            background: var(--cream);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .selection-toggle {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .toggle-btn {
            flex: 1;
            padding: 12px 20px;
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            background: var(--warm-white);
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .toggle-btn.active {
            background: var(--primary-green);
            border-color: var(--primary-green);
            color: white;
        }

        .user-select-container {
            display: none;
        }

        .user-select-container.active {
            display: block;
        }

        /* Status Management */
        .status-management {
            background: rgba(45, 80, 22, 0.05);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-diproses {
            background: #fef3c7;
            color: #d97706;
        }

        .status-disetujui {
            background: #dcfce7;
            color: #16a34a;
        }

        .status-ditolak {
            background: #fee2e2;
            color: #dc2626;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            .input-group-personal,
            .input-group-birth,
            .input-group-status,
            .input-group-usaha {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-progress {
                flex-direction: column;
                gap: 10px;
            }

            .progress-step::after {
                content: '↓';
                margin-left: 0;
                margin-top: 5px;
            }

            .selection-toggle {
                flex-direction: column;
            }
        }

        @media (max-width: 576px) {

            .btn-primary,
            .btn-outline-secondary {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-content">
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Pelayanan Surat</li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.surat-kpt.index') }}">Surat KPT</a></li>
                    <li class="breadcrumb-item active">Buat Surat Baru</li>
                </ol>
            </nav>
            <h1 class="page-title">Buat Surat Pengantar Penghasilan Tetap</h1>
            <p class="page-subtitle">Lengkapi form di bawah untuk membuat surat baru dalam sistem</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Terjadi kesalahan saat pengisian formulir:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="info-card">
            <div class="info-icon">
                <i class="bi bi-info-lg"></i>
            </div>
            <h6>Petunjuk Pengisian</h6>
            <p>
                Sebagai admin, Anda dapat membuat surat pengantar untuk pengguna terdaftar atau sebagai guest (tanpa akun).
                Pastikan data yang dimasukkan adalah data dari **pihak yang bersangkutan (pemohon)**.
                Data penanda tangan surat (Kepala Desa) akan diisi secara otomatis oleh sistem.
                Semua field yang bertanda bintang (*) wajib diisi.
            </p>
        </div>

        <div class="form-progress">
            <div class="progress-step active">
                <div class="step-number">1</div>
                <span>Jenis Pemohon</span>
            </div>
            <div class="progress-step">
                <div class="step-number">2</div>
                <span>Data Pemohon</span>
            </div>
            <div class="progress-step">
                <div class="step-number">3</div>
                <span>Detail Surat</span>
            </div>
            <div class="progress-step">
                <div class="step-number">4</div>
                <span>Status Surat</span>
            </div>
        </div>

        <div class="form-container">
            <div class="form-header">
                <div class="form-icon">
                    <i class="bi bi-file-earmark-text-fill"></i>
                </div>
                <h2 class="form-title">Form Buat Surat KPT</h2>
                <p class="form-subtitle">Masukkan data surat pengantar dengan lengkap dan benar</p>
            </div>

            <form action="{{ route('admin.surat-kpt.store') }}" method="POST" novalidate>
                @csrf

                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-person-gear"></i>
                        </div>
                        Jenis Pemohon
                    </h4>
                    <div class="user-selection-card">
                        <div class="selection-toggle">
                            <div class="toggle-btn {{ old('user_id') !== null ? 'active' : '' }}" data-type="user">
                                <i class="bi bi-person-check me-2"></i>
                                Pengguna Terdaftar
                            </div>
                            <div class="toggle-btn {{ old('user_id') === null ? 'active' : '' }}" data-type="guest">
                                <i class="bi bi-person-plus me-2"></i>
                                Guest (Tanpa Akun)
                            </div>
                        </div>

                        <div class="user-select-container {{ old('user_id') !== null ? 'active' : '' }}"
                            id="user-container">
                            <label for="user_id" class="form-label">
                                Pilih Pengguna Terdaftar <span class="required">*</span>
                            </label>
                            <select class="form-select @error('user_id') is-invalid @enderror" id="user_id"
                                name="user_id">
                                <option value="">-- Pilih Pengguna --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Pilih dari daftar pengguna yang sudah terdaftar di sistem
                            </div>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="user-select-container {{ old('user_id') === null ? 'active' : '' }}"
                            id="guest-container">
                            <p class="text-muted mb-0">
                                <i class="bi bi-info-circle me-1"></i>
                                Surat akan dibuat untuk guest (tanpa akun pengguna).
                                Pastikan nomor telepon diisi dengan benar untuk tracking.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        Data Pemohon
                    </h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_yang_bersangkutan" class="form-label">
                                Nama Lengkap <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('nama_yang_bersangkutan') is-invalid @enderror"
                                id="nama_yang_bersangkutan" name="nama_yang_bersangkutan"
                                value="{{ old('nama_yang_bersangkutan') }}" placeholder="Nama lengkap pemohon"
                                maxlength="255" required>
                            @error('nama_yang_bersangkutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nik" class="form-label">
                                NIK <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik"
                                name="nik" value="{{ old('nik') }}" placeholder="Nomor Induk Kependudukan"
                                maxlength="255" required>
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="input-group-birth">
                        <div class="mb-3">
                            <label for="tempat_lahir" class="form-label">
                                Tempat Lahir <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                placeholder="Kota/Kabupaten tempat lahir" maxlength="255" required>
                            @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">
                                Tanggal Lahir <span class="required">*</span>
                            </label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jenis_kelamin" class="form-label">
                                Jenis Kelamin <span class="required">*</span>
                            </label>
                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin"
                                name="jenis_kelamin" required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="agama" class="form-label">
                                Agama <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('agama') is-invalid @enderror"
                                id="agama" name="agama" value="{{ old('agama') }}" placeholder="Agama"
                                maxlength="255" required>
                            @error('agama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pekerjaan" class="form-label">
                                Pekerjaan <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror"
                                id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}" placeholder="Pekerjaan"
                                maxlength="255" required>
                            @error('pekerjaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="alamat_yang_bersangkutan" class="form-label">
                                Alamat <span class="required">*</span>
                            </label>
                            <textarea class="form-control @error('alamat_yang_bersangkutan') is-invalid @enderror" id="alamat_yang_bersangkutan"
                                name="alamat_yang_bersangkutan" rows="3" placeholder="Alamat lengkap pemohon" required>{{ old('alamat_yang_bersangkutan') }}</textarea>
                            @error('alamat_yang_bersangkutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3" id="phone-container">
                            <label for="nomor_telepon" class="form-label">
                                Nomor Telepon <span class="required" id="phone-required">*</span>
                            </label>
                            <input type="tel" class="form-control @error('nomor_telepon') is-invalid @enderror"
                                id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon') }}"
                                placeholder="08xxxxxxxxxx" maxlength="20">
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                <span id="phone-text">Wajib diisi untuk guest, opsional untuk pengguna terdaftar</span>
                            </div>
                            @error('nomor_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        Detail Surat
                    </h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_ayah" class="form-label">
                                Nama Ayah <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror"
                                id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah') }}"
                                placeholder="Nama ayah kandung" maxlength="255" required>
                            @error('nama_ayah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nama_ibu" class="form-label">
                                Nama Ibu <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror"
                                id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu') }}"
                                placeholder="Nama ibu kandung" maxlength="255" required>
                            @error('nama_ibu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pekerjaan_orang_tua" class="form-label">
                                Pekerjaan Orang Tua <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('pekerjaan_orang_tua') is-invalid @enderror"
                                id="pekerjaan_orang_tua" name="pekerjaan_orang_tua"
                                value="{{ old('pekerjaan_orang_tua') }}" placeholder="Pekerjaan orang tua"
                                maxlength="255" required>
                            @error('pekerjaan_orang_tua')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="penghasilan_per_bulan" class="form-label">
                                Penghasilan Per Bulan <span class="required">*</span>
                            </label>
                            <input type="number"
                                class="form-control @error('penghasilan_per_bulan') is-invalid @enderror"
                                id="penghasilan_per_bulan" name="penghasilan_per_bulan"
                                value="{{ old('penghasilan_per_bulan') }}" placeholder="Penghasilan rata-rata per bulan"
                                required>
                            @error('penghasilan_per_bulan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="keperluan" class="form-label">
                                Keperluan Surat <span class="required">*</span>
                            </label>
                            <textarea class="form-control @error('keperluan') is-invalid @enderror" id="keperluan" name="keperluan"
                                rows="3" placeholder="Jelaskan keperluan pengajuan surat ini" required>{{ old('keperluan') }}</textarea>
                            @error('keperluan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-clipboard-check"></i>
                        </div>
                        Status dan Keterangan Surat
                    </h4>
                    <div class="status-management">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label">
                                    Status Surat <span class="required">*</span>
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="diproses"
                                        {{ old('status', 'diproses') == 'diproses' ? 'selected' : '' }}>
                                        Sedang Diproses
                                    </option>
                                    <option value="disetujui" {{ old('status') == 'disetujui' ? 'selected' : '' }}>
                                        Disetujui
                                    </option>
                                    <option value="ditolak" {{ old('status') == 'ditolak' ? 'selected' : '' }}>
                                        Ditolak
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-8 mb-3" id="nomor-surat-container"
                                style="display: {{ old('status') == 'disetujui' ? 'block' : 'none' }};">
                                <label for="nomor_surat" class="form-label">
                                    Nomor Surat
                                </label>
                                <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror"
                                    id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat') }}"
                                    placeholder="Nomor surat (otomatis jika dikosongkan)">
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Kosongkan untuk generate otomatis saat status disetujui
                                </div>
                                @error('nomor_surat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="keterangan" class="form-label">
                                    Keterangan
                                </label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan"
                                    rows="3" placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Catatan tambahan untuk pemohon atau admin lain
                                </div>
                                @error('keterangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.surat-kpt.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>Simpan Surat
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const toggleBtns = document.querySelectorAll('.toggle-btn');
            const userContainer = document.getElementById('user-container');
            const guestContainer = document.getElementById('guest-container');
            const userSelect = document.getElementById('user_id');
            const phoneInput = document.getElementById('nomor_telepon');
            const phoneRequired = document.getElementById('phone-required');
            const statusSelect = document.getElementById('status');
            const nomorSuratContainer = document.getElementById('nomor-surat-container');
            const form = document.querySelector('form');

            // Initial state based on old input
            const isUserMode = userSelect.value !== '';
            if (isUserMode) {
                document.querySelector('.toggle-btn[data-type="user"]').classList.add('active');
                userContainer.classList.add('active');
                phoneRequired.style.display = 'none';
                phoneInput.required = false;
            } else {
                document.querySelector('.toggle-btn[data-type="guest"]').classList.add('active');
                guestContainer.classList.add('active');
                phoneRequired.style.display = 'inline';
                phoneInput.required = true;
            }

            // Toggle between user types
            toggleBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const type = this.dataset.type;

                    // Update active state
                    toggleBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    // Show/hide containers
                    if (type === 'user') {
                        userContainer.classList.add('active');
                        guestContainer.classList.remove('active');
                        userSelect.required = true;
                        phoneInput.required = false;
                        phoneRequired.style.display = 'none';
                        phoneInput.value = ''; // Clear phone number for user mode
                    } else {
                        userContainer.classList.remove('active');
                        guestContainer.classList.add('active');
                        userSelect.required = false;
                        userSelect.value = '';
                        phoneInput.required = true;
                        phoneRequired.style.display = 'inline';
                    }
                });
            });

            // Status change handler
            statusSelect.addEventListener('change', function() {
                if (this.value === 'disetujui') {
                    nomorSuratContainer.style.display = 'block';
                } else {
                    nomorSuratContainer.style.display = 'none';
                }
            });

            // Initial status check
            if (statusSelect.value === 'disetujui') {
                nomorSuratContainer.style.display = 'block';
            }

            // Form validation and formatting
            const namaYangBersangkutanInput = document.getElementById('nama_yang_bersangkutan');
            const tempatLahirInput = document.getElementById('tempat_lahir');
            const agamaInput = document.getElementById('agama');
            const pekerjaanInput = document.getElementById('pekerjaan');
            const pekerjaanOrangTuaInput = document.getElementById('pekerjaan_orang_tua');
            const namaAyahInput = document.getElementById('nama_ayah');
            const namaIbuInput = document.getElementById('nama_ibu');

            // Function to capitalize each word
            function capitalizeWords(input) {
                input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
                input.value = input.value.toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
            }

            namaYangBersangkutanInput.addEventListener('input', (e) => capitalizeWords(e.target));
            tempatLahirInput.addEventListener('input', (e) => capitalizeWords(e.target));
            agamaInput.addEventListener('input', (e) => capitalizeWords(e.target));
            pekerjaanInput.addEventListener('input', (e) => capitalizeWords(e.target));
            pekerjaanOrangTuaInput.addEventListener('input', (e) => capitalizeWords(e.target));
            namaAyahInput.addEventListener('input', (e) => capitalizeWords(e.target));
            namaIbuInput.addEventListener('input', (e) => capitalizeWords(e.target));

            // NIK and Phone input validation
            const nikInput = document.getElementById('nik');
            nikInput.addEventListener('input', (e) => {
                e.target.value = e.target.value.replace(/\D/g, '');
            });

            phoneInput.addEventListener('input', (e) => {
                e.target.value = e.target.value.replace(/\D/g, '');
            });

            // Date validation (not in the future)
            const tanggalLahirInput = document.getElementById('tanggal_lahir');

            const today = new Date().toISOString().split('T')[0];
            tanggalLahirInput.setAttribute('max', today);

            tanggalLahirInput.addEventListener('change', function(e) {
                const birthDate = new Date(e.target.value);
                const minDate = new Date();
                minDate.setFullYear(new Date().getFullYear() - 100);

                if (birthDate > new Date() || birthDate < minDate) {
                    alert('Tanggal lahir tidak valid!');
                    e.target.value = '';
                }
            });



            // Form submission validation
            form.addEventListener('submit', function(e) {
                const isUserMode = document.querySelector('.toggle-btn[data-type="user"]').classList
                    .contains('active');
                if (isUserMode && !userSelect.value) {
                    e.preventDefault();
                    alert('Pilih pengguna terdaftar atau ubah ke mode guest!');
                }
                if (!isUserMode && !phoneInput.value.trim()) {
                    e.preventDefault();
                    alert('Nomor telepon wajib diisi untuk guest!');
                }
            });

            // Intersection Observer for progress steps
            const formSections = document.querySelectorAll('.form-section');
            const progressSteps = document.querySelectorAll('.progress-step');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const index = Array.from(formSections).indexOf(entry.target);
                        progressSteps.forEach(step => step.classList.remove('active'));
                        if (progressSteps[index]) {
                            progressSteps[index].classList.add('active');
                        }
                    }
                });
            }, {
                threshold: 0.5
            });

            formSections.forEach(section => {
                observer.observe(section);
            });
        });
    </script>
@endpush
