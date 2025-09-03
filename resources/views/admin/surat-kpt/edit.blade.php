{{-- Surat KPT Edit Form --}}
@extends('layouts.main')

@push('style')
    <style>
        /* Form Styles - Same as KTM edit but adapted for Surat KPT */
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
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
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

        .surat-info-badge {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            padding: 8px 16px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-block;
            margin: 5px;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-diproses {
            background: #fff3cd;
            color: #856404;
        }

        .status-disetujui {
            background: #d1edff;
            color: #0c5460;
        }

        .status-ditolak {
            background: #f8d7da;
            color: #721c24;
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
            flex-wrap: wrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            min-width: 120px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 140, 66, 0.3);
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

        .btn-outline-danger {
            color: #dc3545;
            border: 2px solid #dc3545;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            background: transparent;
            transition: all 0.3s ease;
            min-width: 120px;
        }

        .btn-outline-danger:hover {
            background: #dc3545;
            border-color: #dc3545;
            color: white;
            transform: translateY(-2px);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            min-width: 120px;
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45, 80, 22, 0.3);
        }

        /* Input Group Styles */
        .input-group-personal,
        .input-group-birth {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .input-group-other {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
        }

        .input-group-status {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        /* Info Card */
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

        /* Change Tracking */
        .change-indicator {
            position: relative;
        }

        .change-indicator.modified::after {
            content: '●';
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--accent-orange);
            font-size: 0.8rem;
        }

        .changes-summary {
            background: rgba(255, 140, 66, 0.1);
            border: 1px solid rgba(255, 140, 66, 0.3);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            display: none;
        }

        .changes-summary.show {
            display: block;
        }

        .changes-summary h6 {
            color: var(--accent-orange);
            margin-bottom: 10px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .changes-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .changes-list li {
            font-size: 0.8rem;
            color: var(--soft-gray);
            margin-bottom: 5px;
            padding-left: 15px;
            position: relative;
        }

        .changes-list li::before {
            content: '→';
            position: absolute;
            left: 0;
            color: var(--accent-orange);
        }

        /* Status Management Section */
        .status-management {
            background: rgba(45, 80, 22, 0.05);
            border: 1px solid rgba(45, 80, 22, 0.2);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .nomor-surat-group {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-top: 15px;
        }

        .generate-nomor-btn {
            background: linear-gradient(135deg, var(--secondary-green), var(--primary-green));
            border: none;
            border-radius: 8px;
            padding: 8px 15px;
            color: white;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .generate-nomor-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(45, 80, 22, 0.3);
        }

        /* User Selection */
        .user-selection {
            background: #e3f2fd;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            .input-group-personal,
            .input-group-birth,
            .input-group-status,
            .input-group-other {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-header {
                margin-bottom: 20px;
            }

            .form-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
        }

        @media (max-width: 576px) {

            .btn-primary,
            .btn-outline-secondary,
            .btn-outline-danger,
            .btn-success {
                width: 100%;
                margin-bottom: 10px;
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
                    <li class="breadcrumb-item">Surat-Menyurat</li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.surat-kpt.index') }}">Surat KPT</a></li>
                    <li class="breadcrumb-item active">Edit Surat</li>
                </ol>
            </nav>
            <h1 class="page-title">Edit Surat Keterangan Penghasilan Tetap</h1>
            <p class="page-subtitle">Perbarui data surat keterangan penghasilan tetap</p>
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
                <i class="bi bi-pencil-square"></i>
            </div>
            <h6>Informasi Edit Surat</h6>
            <p>
                Anda sedang mengedit data surat Keterangan Penghasilan Tetap. Sebagai admin, Anda dapat mengubah semua data
                termasuk status surat.
                Pastikan data yang diubah sudah sesuai dengan kebutuhan pemohon.
            </p>
        </div>

        <div class="changes-summary" id="changesSummary">
            <h6><i class="bi bi-exclamation-circle me-2"></i>Data yang Diubah:</h6>
            <ul class="changes-list" id="changesList"></ul>
        </div>

        <div class="form-container">
            <div class="form-header">
                <div class="form-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <h2 class="form-title">Form Edit Surat KPT</h2>
                <p class="form-subtitle">
                    <span class="surat-info-badge">ID: #{{ $surat->id }}</span>
                    <span class="status-badge status-{{ $surat->status }}">{{ ucfirst($surat->status) }}</span>
                    @if ($surat->nomor_surat)
                        <span class="surat-info-badge">No. Surat: {{ $surat->nomor_surat }}</span>
                    @endif
                    <br>
                    Dibuat: {{ $surat->created_at->format('d/m/Y H:i') }} |
                    Update: {{ $surat->updated_at->format('d/m/Y H:i') }}
                </p>
            </div>

            <form action="{{ route('admin.surat-kpt.update', $surat->id) }}" method="POST" novalidate>
                @csrf
                @method('PUT')

                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-person-gear"></i>
                        </div>
                        Penugasan User
                    </h4>

                    <div class="user-selection">
                        <label for="user_id" class="form-label">
                            Assign ke User Terdaftar
                        </label>
                        <select class="form-select change-indicator @error('user_id') is-invalid @enderror" id="user_id"
                            name="user_id" data-original="{{ old('user_id', $surat->user_id) }}">
                            <option value="">-- Guest/Tidak terdaftar --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('user_id', $surat->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Pilih user jika surat ini milik user terdaftar, kosongkan untuk guest
                        </div>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        Data Pihak yang Bersangkutan
                    </h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_yang_bersangkutan" class="form-label">
                                Nama Lengkap <span class="required">*</span>
                            </label>
                            <input type="text"
                                class="form-control change-indicator @error('nama_yang_bersangkutan') is-invalid @enderror"
                                id="nama_yang_bersangkutan" name="nama_yang_bersangkutan"
                                value="{{ old('nama_yang_bersangkutan', $surat->nama_yang_bersangkutan) }}"
                                data-original="{{ $surat->nama_yang_bersangkutan }}"
                                placeholder="Nama lengkap pihak yang bersangkutan" maxlength="255" required>
                            @error('nama_yang_bersangkutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nik" class="form-label">
                                NIK <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control change-indicator @error('nik') is-invalid @enderror"
                                id="nik" name="nik" value="{{ old('nik', $surat->nik) }}"
                                data-original="{{ $surat->nik }}" placeholder="Nomor Induk Kependudukan" maxlength="255"
                                required>
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
                            <input type="text"
                                class="form-control change-indicator @error('tempat_lahir') is-invalid @enderror"
                                id="tempat_lahir" name="tempat_lahir"
                                value="{{ old('tempat_lahir', $surat->tempat_lahir) }}"
                                data-original="{{ $surat->tempat_lahir }}" placeholder="Kota/Kabupaten tempat lahir"
                                maxlength="255" required>
                            @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">
                                Tanggal Lahir <span class="required">*</span>
                            </label>
                            <input type="date"
                                class="form-control change-indicator @error('tanggal_lahir') is-invalid @enderror"
                                id="tanggal_lahir" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir', $surat->tanggal_lahir_for_form) }}"
                                data-original="{{ $surat->tanggal_lahir_for_form }}" required>
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
                            <select class="form-select change-indicator @error('jenis_kelamin') is-invalid @enderror"
                                id="jenis_kelamin" name="jenis_kelamin" data-original="{{ $surat->jenis_kelamin }}"
                                required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki"
                                    {{ old('jenis_kelamin', $surat->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="Perempuan"
                                    {{ old('jenis_kelamin', $surat->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
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
                            <input type="text"
                                class="form-control change-indicator @error('agama') is-invalid @enderror" id="agama"
                                name="agama" value="{{ old('agama', $surat->agama) }}"
                                data-original="{{ $surat->agama }}" placeholder="Agama" maxlength="255" required>
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
                            <input type="text"
                                class="form-control change-indicator @error('pekerjaan') is-invalid @enderror"
                                id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan', $surat->pekerjaan) }}"
                                data-original="{{ $surat->pekerjaan }}" placeholder="Pekerjaan" maxlength="255"
                                required>
                            @error('pekerjaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="alamat_yang_bersangkutan" class="form-label">
                                Alamat <span class="required">*</span>
                            </label>
                            <textarea class="form-control change-indicator @error('alamat_yang_bersangkutan') is-invalid @enderror"
                                id="alamat_yang_bersangkutan" name="alamat_yang_bersangkutan"
                                data-original="{{ $surat->alamat_yang_bersangkutan }}" rows="3"
                                placeholder="Alamat lengkap pihak yang bersangkutan" required>{{ old('alamat_yang_bersangkutan', $surat->alamat_yang_bersangkutan) }}</textarea>
                            @error('alamat_yang_bersangkutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row" id="nomor_telepon_group">
                        <div class="col-md-12 mb-3">
                            <label for="nomor_telepon" class="form-label">
                                Nomor Telepon <span class="required nomor_telepon_required"
                                    style="{{ $surat->user_id ? 'display: none;' : '' }}">*</span>
                            </label>
                            <input type="tel"
                                class="form-control change-indicator @error('nomor_telepon') is-invalid @enderror"
                                id="nomor_telepon" name="nomor_telepon"
                                value="{{ old('nomor_telepon', $surat->nomor_telepon) }}"
                                data-original="{{ $surat->nomor_telepon }}" placeholder="08xxxxxxxxxx" maxlength="20">
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                <span
                                    class="nomor_telepon_note">{{ $surat->user_id ? 'Opsional untuk user terdaftar' : 'Wajib diisi untuk guest' }}</span>
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
                            <input type="text"
                                class="form-control change-indicator @error('nama_ayah') is-invalid @enderror"
                                id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah', $surat->nama_ayah) }}"
                                data-original="{{ $surat->nama_ayah }}" placeholder="Nama ayah kandung" maxlength="255"
                                required>
                            @error('nama_ayah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nama_ibu" class="form-label">
                                Nama Ibu <span class="required">*</span>
                            </label>
                            <input type="text"
                                class="form-control change-indicator @error('nama_ibu') is-invalid @enderror"
                                id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu', $surat->nama_ibu) }}"
                                data-original="{{ $surat->nama_ibu }}" placeholder="Nama ibu kandung" maxlength="255"
                                required>
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
                            <input type="text"
                                class="form-control change-indicator @error('pekerjaan_orang_tua') is-invalid @enderror"
                                id="pekerjaan_orang_tua" name="pekerjaan_orang_tua"
                                value="{{ old('pekerjaan_orang_tua', $surat->pekerjaan_orang_tua) }}"
                                data-original="{{ $surat->pekerjaan_orang_tua }}" placeholder="Pekerjaan orang tua"
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
                                class="form-control change-indicator @error('penghasilan_per_bulan') is-invalid @enderror"
                                id="penghasilan_per_bulan" name="penghasilan_per_bulan"
                                value="{{ old('penghasilan_per_bulan', $surat->penghasilan_per_bulan) }}"
                                data-original="{{ $surat->penghasilan_per_bulan }}"
                                placeholder="Penghasilan rata-rata per bulan" required>
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
                            <textarea class="form-control change-indicator @error('keperluan') is-invalid @enderror" id="keperluan"
                                name="keperluan" data-original="{{ $surat->keperluan }}" rows="3"
                                placeholder="Jelaskan keperluan pengajuan surat ini" required>{{ old('keperluan', $surat->keperluan) }}</textarea>
                            @error('keperluan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>

                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-gear"></i>
                        </div>
                        Status & Administrasi Surat
                    </h4>

                    <div class="status-management">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">
                                    Status Surat <span class="required">*</span>
                                </label>
                                <select class="form-select change-indicator @error('status') is-invalid @enderror"
                                    id="status" name="status" data-original="{{ $surat->status }}" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="diproses"
                                        {{ old('status', $surat->status) == 'diproses' ? 'selected' : '' }}>
                                        Diproses
                                    </option>
                                    <option value="disetujui"
                                        {{ old('status', $surat->status) == 'disetujui' ? 'selected' : '' }}>
                                        Disetujui
                                    </option>
                                    <option value="ditolak"
                                        {{ old('status', $surat->status) == 'ditolak' ? 'selected' : '' }}>
                                        Ditolak
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <div class="nomor-surat-group" id="nomorSuratGroup"
                                    style="display: {{ old('status', $surat->status) == 'disetujui' ? 'block' : 'none' }};">
                                    <label for="nomor_surat" class="form-label">
                                        Nomor Surat
                                    </label>
                                    <div class="input-group">
                                        <input type="text"
                                            class="form-control change-indicator @error('nomor_surat') is-invalid @enderror"
                                            id="nomor_surat" name="nomor_surat"
                                            value="{{ old('nomor_surat', $surat->nomor_surat) }}"
                                            data-original="{{ $surat->nomor_surat }}"
                                            placeholder="Auto generate atau input manual">
                                        <button type="button" class="btn generate-nomor-btn" id="generateNomorBtn">
                                            <i class="bi bi-lightning"></i> Generate
                                        </button>
                                    </div>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Nomor surat otomatis dibuat saat status disetujui
                                    </div>
                                    @error('nomor_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">
                                Keterangan/Catatan
                            </label>
                            <textarea class="form-control change-indicator @error('keterangan') is-invalid @enderror" id="keterangan"
                                name="keterangan" data-original="{{ $surat->keterangan }}" rows="3"
                                placeholder="Keterangan admin (opsional)">{{ old('keterangan', $surat->keterangan) }}</textarea>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Catatan internal admin atau alasan penolakan
                            </div>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.surat-kpt.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="{{ route('admin.surat-kpt.show', $surat->id) }}" class="btn btn-outline-danger">
                        <i class="bi bi-eye me-2"></i>Lihat Detail
                    </a>
                    @if ($surat->status === 'disetujui' && $surat->nomor_surat)
                        <a href="{{ route('admin.surat-kpt.download', $surat->id) }}" class="btn btn-success"
                            target="_blank">
                            <i class="bi bi-download me-2"></i>Download PDF
                        </a>
                    @endif
                    <button type="submit" class="btn btn-primary" id="saveBtn">
                        <i class="bi bi-check-lg me-2"></i>Update Surat
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const changesSummary = document.getElementById('changesSummary');
            const changesList = document.getElementById('changesList');
            const saveBtn = document.getElementById('saveBtn');
            const statusSelect = document.getElementById('status');
            const nomorSuratGroup = document.getElementById('nomorSuratGroup');
            const generateNomorBtn = document.getElementById('generateNomorBtn');
            const userSelect = document.getElementById('user_id');
            const nomorTeleponInput = document.getElementById('nomor_telepon');
            const nomorTeleponRequired = document.querySelector('.nomor_telepon_required');
            const nomorTeleponNote = document.querySelector('.nomor_telepon_note');
            let hasChanges = false;

            // Initialize form state
            toggleNomorSuratGroup();
            toggleNomorTeleponRequirement();

            // Handle status change
            statusSelect.addEventListener('change', function() {
                toggleNomorSuratGroup();
                trackChanges();
            });

            // Handle user selection change
            userSelect.addEventListener('change', function() {
                toggleNomorTeleponRequirement();
                trackChanges();
            });

            // Generate nomor surat
            generateNomorBtn.addEventListener('click', function() {
                this.disabled = true;
                this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Generating...';

                fetch('{{ route('admin.surat-kpt.generate-nomor') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('nomor_surat').value = data.nomor_surat;
                            trackChanges();
                            alert('Nomor surat berhasil di-generate: ' + data.nomor_surat);
                        } else {
                            alert('Gagal generate nomor surat: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat generate nomor surat');
                    })
                    .finally(() => {
                        this.disabled = false;
                        this.innerHTML = '<i class="bi bi-lightning"></i> Generate';
                    });
            });

            function toggleNomorSuratGroup() {
                const status = statusSelect.value;
                if (status === 'disetujui') {
                    nomorSuratGroup.style.display = 'block';
                } else {
                    nomorSuratGroup.style.display = 'none';
                }
            }

            function toggleNomorTeleponRequirement() {
                const userId = userSelect.value;
                if (userId) {
                    // User terdaftar - nomor telepon opsional
                    nomorTeleponInput.removeAttribute('required');
                    nomorTeleponRequired.style.display = 'none';
                    nomorTeleponNote.textContent = 'Opsional untuk user terdaftar';
                } else {
                    // Guest - nomor telepon wajib
                    nomorTeleponInput.setAttribute('required', 'required');
                    nomorTeleponRequired.style.display = 'inline';
                    nomorTeleponNote.textContent = 'Wajib diisi untuk guest';
                }
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

            nomorTeleponInput.addEventListener('input', (e) => {
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



            // Track changes
            const trackableInputs = document.querySelectorAll('.change-indicator');
            trackableInputs.forEach(input => {
                input.addEventListener('input', function() {
                    trackChanges();
                });
                input.addEventListener('change', function() {
                    trackChanges();
                });
            });

            function trackChanges() {
                const changes = [];
                hasChanges = false;

                trackableInputs.forEach(input => {
                    const currentValue = input.type === 'checkbox' ? input.checked.toString() : input.value
                        .trim();
                    const originalValue = input.getAttribute('data-original') || '';
                    const fieldName = getFieldName(input.name);

                    if (currentValue !== originalValue) {
                        input.classList.add('modified');
                        changes.push({
                            field: fieldName,
                            from: originalValue,
                            to: currentValue
                        });
                        hasChanges = true;
                    } else {
                        input.classList.remove('modified');
                    }
                });

                updateChangesSummary(changes);
                updateSaveButton();
            }

            function getFieldName(name) {
                const fieldNames = {
                    'user_id': 'Assign User',
                    'nama_yang_bersangkutan': 'Nama Lengkap',
                    'nik': 'NIK',
                    'tempat_lahir': 'Tempat Lahir',
                    'tanggal_lahir': 'Tanggal Lahir',
                    'jenis_kelamin': 'Jenis Kelamin',
                    'agama': 'Agama',
                    'pekerjaan': 'Pekerjaan',
                    'alamat_yang_bersangkutan': 'Alamat',
                    'nama_ayah': 'Nama Ayah',
                    'nama_ibu': 'Nama Ibu',
                    'pekerjaan_orang_tua': 'Pekerjaan Orang Tua',
                    'penghasilan_per_bulan': 'Penghasilan Per Bulan',
                    'keperluan': 'Keperluan',
                    'tanggal_surat': 'Tanggal Surat',
                    'nomor_telepon': 'Nomor Telepon',
                    'status': 'Status Surat',
                    'nomor_surat': 'Nomor Surat',
                    'keterangan': 'Keterangan'
                };
                return fieldNames[name] || name;
            }

            function updateChangesSummary(changes) {
                if (changes.length > 0) {
                    changesList.innerHTML = '';
                    changes.forEach(change => {
                        const li = document.createElement('li');
                        let fromText = change.from || '(kosong)';
                        let toText = change.to || '(kosong)';

                        if (change.field === 'Assign User') {
                            const userOption = userSelect.querySelector(`option[value="${change.to}"]`);
                            toText = userOption ? userOption.textContent : '(Guest)';
                            const originalUserOption = userSelect.querySelector(
                                `option[value="${change.from}"]`);
                            fromText = originalUserOption ? originalUserOption.textContent : '(Guest)';
                        }

                        if (change.field === 'Jenis Kelamin') {
                            const selectedOption = document.querySelector(
                                `#jenis_kelamin option[value="${change.to}"]`);
                            toText = selectedOption ? selectedOption.textContent : change.to;
                            const originalOption = document.querySelector(
                                `#jenis_kelamin option[value="${change.from}"]`);
                            fromText = originalOption ? originalOption.textContent : change.from;
                        }

                        if (change.field === 'Status Surat') {
                            const selectedOption = document.querySelector(
                                `#status option[value="${change.to}"]`);
                            toText = selectedOption ? selectedOption.textContent : change.to;
                            const originalOption = document.querySelector(
                                `#status option[value="${change.from}"]`);
                            fromText = originalOption ? originalOption.textContent : change.from;
                        }

                        li.textContent = `${change.field}: "${fromText}" → "${toText}"`;
                        changesList.appendChild(li);
                    });
                    changesSummary.classList.add('show');
                } else {
                    changesSummary.classList.remove('show');
                }
            }

            function updateSaveButton() {
                if (hasChanges) {
                    saveBtn.innerHTML = '<i class="bi bi-check-lg me-2"></i>Simpan Perubahan';
                    saveBtn.classList.remove('btn-primary');
                    saveBtn.classList.add('btn-warning');
                } else {
                    saveBtn.innerHTML = '<i class="bi bi-check-lg me-2"></i>Update Surat';
                    saveBtn.classList.remove('btn-warning');
                    saveBtn.classList.add('btn-primary');
                }
            }

            // Form validation
            form.addEventListener('submit', function(e) {
                const userId = document.getElementById('user_id').value;
                const nomorTelepon = document.getElementById('nomor_telepon').value.trim();

                if (!userId && !nomorTelepon) {
                    e.preventDefault();
                    alert('Nomor telepon wajib diisi untuk guest!');
                    return false;
                }

                if (nomorTelepon && nomorTelepon.length < 10) {
                    e.preventDefault();
                    alert('Nomor telepon minimal 10 digit!');
                    return false;
                }

                if (hasChanges) {
                    const confirmMessage = 'Apakah Anda yakin ingin menyimpan perubahan data surat ini?';
                    if (!confirm(confirmMessage)) {
                        e.preventDefault();
                        return false;
                    }
                }

                // Show loading state
                saveBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';
                saveBtn.disabled = true;
            });

            // Warning before leaving with unsaved changes
            window.addEventListener('beforeunload', function(e) {
                if (hasChanges) {
                    e.preventDefault();
                    e.returnValue =
                        'Anda memiliki perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
                    return e.returnValue;
                }
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                    e.preventDefault();
                    form.requestSubmit();
                }

                if (e.key === 'Escape') {
                    const backBtn = document.querySelector('.btn-outline-secondary');
                    if (backBtn && confirm('Yakin ingin kembali? Data yang belum disimpan akan hilang.')) {
                        window.location.href = backBtn.href;
                    }
                }
            });

            // Auto-focus on first input
            const firstInput = form.querySelector('input:not([type="hidden"]), select, textarea');
            if (firstInput) {
                firstInput.focus();
            }

            // Initial check
            trackChanges();
        });
    </script>
@endpush
