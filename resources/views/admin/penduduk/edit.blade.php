@extends('layouts.main')

@push('style')
    <style>
        /* Edit Form Styles */
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

        /* Input Group Styles */
        .input-group-birth {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .input-group-identity {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .input-group-parents {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        /* Age Calculator */
        .age-display {
            background: rgba(45, 80, 22, 0.1);
            border: 1px solid rgba(45, 80, 22, 0.2);
            border-radius: 10px;
            padding: 10px 15px;
            margin-top: 5px;
            display: none;
        }

        .age-display.show {
            display: block;
        }

        .age-text {
            color: var(--primary-green);
            font-weight: 600;
            font-size: 0.9rem;
        }

        [data-theme="dark"] .age-text {
            color: var(--light-green);
        }

        /* Character Counter */
        .char-counter {
            text-align: right;
            font-size: 0.75rem;
            color: var(--soft-gray);
            margin-top: 5px;
        }

        .char-counter.warning {
            color: var(--accent-orange);
        }

        .char-counter.danger {
            color: #dc3545;
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

        .btn-warning {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            min-width: 120px;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 140, 66, 0.3);
        }

        /* Change Indicator */
        .change-indicator {
            position: relative;
        }

        .change-indicator.changed::after {
            content: '';
            position: absolute;
            top: 5px;
            right: 5px;
            width: 8px;
            height: 8px;
            background: var(--accent-orange);
            border-radius: 50%;
        }

        /* Page Header Styles */
        .page-header {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 10px;
        }

        [data-theme="dark"] .page-title {
            color: var(--light-green);
        }

        .page-subtitle {
            color: var(--soft-gray);
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
            font-size: 0.9rem;
        }

        .breadcrumb-item a {
            color: var(--primary-green);
            text-decoration: none;
        }

        [data-theme="dark"] .breadcrumb-item a {
            color: var(--light-green);
        }

        .breadcrumb-item.active {
            color: var(--soft-gray);
        }

        /* Alert Messages */
        .alert {
            border: none;
            border-radius: 15px;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-left: 4px solid;
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.1);
            border-left-color: #28a745;
            color: #155724;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            border-left-color: #dc3545;
            color: #721c24;
        }

        .alert-warning {
            background: rgba(255, 193, 7, 0.1);
            border-left-color: #ffc107;
            color: #856404;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            .input-group-birth,
            .input-group-identity,
            .input-group-parents {
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
            .btn-warning {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-content">
        <!-- Page Header -->
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Data Penduduk</li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.penduduk.index') }}">Data Penduduk</a></li>
                    <li class="breadcrumb-item active">Edit Penduduk</li>
                </ol>
            </nav>
            <h1 class="page-title">Edit Data Penduduk</h1>
            <p class="page-subtitle">Perbarui informasi data penduduk <strong>{{ $penduduk->nama_lengkap }}</strong></p>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Main Form -->
        <div class="form-container">
            <div class="form-header">
                <div class="form-icon">
                    <i class="bi bi-pencil-fill"></i>
                </div>
                <h2 class="form-title">Form Edit Penduduk</h2>
                <p class="form-subtitle">Perbarui data penduduk dengan informasi yang benar</p>
            </div>

            <form action="{{ route('admin.penduduk.update', $penduduk->nik) }}" method="POST" novalidate id="editForm">
                @csrf
                @method('PUT')

                <!-- Section 1: Identitas & KK -->
                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-card-text"></i>
                        </div>
                        Identitas & Kartu Keluarga
                    </h4>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nik" class="form-label">
                                NIK <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror change-indicator"
                                id="nik" name="nik" value="{{ old('nik', $penduduk->nik) }}"
                                placeholder="Masukkan 16 digit NIK" maxlength="16" pattern="[0-9]{16}" required
                                data-original="{{ $penduduk->nik }}">
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                NIK harus 16 digit angka sesuai KTP
                            </div>
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="no_kk" class="form-label">
                                Pilih Kartu Keluarga <span class="required">*</span>
                            </label>

                            <!-- Searchable Select -->
                            <div class="position-relative">
                                <input type="text" class="form-control @error('no_kk') is-invalid @enderror"
                                    id="kk_search" placeholder="Ketik nama kepala keluarga atau nomor KK..."
                                    autocomplete="off">

                                <select class="form-select d-none @error('no_kk') is-invalid @enderror change-indicator"
                                    id="no_kk" name="no_kk" required data-original="{{ $penduduk->no_kk }}">
                                    <option value="">Pilih Nomor KK</option>
                                    @foreach ($kkList as $kk)
                                        <option value="{{ $kk->no_kk }}" data-nama="{{ $kk->nama_kepala_keluarga }}"
                                            data-alamat="{{ $kk->alamat }}" data-desa="{{ $kk->desa }}"
                                            {{ old('no_kk', $penduduk->no_kk) == $kk->no_kk ? 'selected' : '' }}>
                                            {{ $kk->no_kk }} - {{ $kk->nama_kepala_keluarga }} ({{ $kk->desa }})
                                        </option>
                                    @endforeach
                                </select>

                                <!-- Dropdown Results -->
                                <div class="dropdown-menu w-100" id="kk_dropdown"
                                    style="max-height: 300px; overflow-y: auto;">
                                    @foreach ($kkList as $kk)
                                        <button type="button" class="dropdown-item kk-option"
                                            data-value="{{ $kk->no_kk }}"
                                            data-search="{{ strtolower($kk->nama_kepala_keluarga . ' ' . $kk->no_kk . ' ' . $kk->desa) }}">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <strong>{{ $kk->nama_kepala_keluarga }}</strong><br>
                                                    <small class="text-muted">{{ $kk->no_kk }}</small>
                                                </div>
                                                <div class="text-end">
                                                    <small class="text-primary">{{ $kk->desa }}</small>
                                                </div>
                                            </div>
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Pilih KK berdasarkan nama kepala keluarga dan desa
                            </div>
                            @error('no_kk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Data Pribadi -->
                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        Data Pribadi
                    </h4>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nama_lengkap" class="form-label">
                                Nama Lengkap <span class="required">*</span>
                            </label>
                            <input type="text"
                                class="form-control @error('nama_lengkap') is-invalid @enderror change-indicator"
                                id="nama_lengkap" name="nama_lengkap"
                                value="{{ old('nama_lengkap', $penduduk->nama_lengkap) }}"
                                placeholder="Masukkan nama lengkap sesuai KTP" maxlength="255" required
                                data-original="{{ $penduduk->nama_lengkap }}">
                            <div class="char-counter" id="namaCounter">0/255</div>
                            @error('nama_lengkap')
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
                                class="form-control @error('tempat_lahir') is-invalid @enderror change-indicator"
                                id="tempat_lahir" name="tempat_lahir"
                                value="{{ old('tempat_lahir', $penduduk->tempat_lahir) }}"
                                placeholder="Kota/Kabupaten lahir" required
                                data-original="{{ $penduduk->tempat_lahir }}">
                            @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">
                                Tanggal Lahir <span class="required">*</span>
                            </label>
                            <input type="date"
                                class="form-control @error('tanggal_lahir') is-invalid @enderror change-indicator"
                                id="tanggal_lahir" name="tanggal_lahir"
                                value="{{ old('tanggal_lahir', $penduduk->tanggal_lahir) }}" max="{{ date('Y-m-d') }}"
                                required data-original="{{ $penduduk->tanggal_lahir }}">
                            <div class="age-display" id="ageDisplay">
                                <div class="age-text" id="ageText"></div>
                            </div>
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="input-group-identity">
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">
                                Jenis Kelamin <span class="required">*</span>
                            </label>
                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror change-indicator"
                                id="jenis_kelamin" name="jenis_kelamin" required
                                data-original="{{ $penduduk->jenis_kelamin }}">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki"
                                    {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="Perempuan"
                                    {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="agama" class="form-label">
                                Agama <span class="required">*</span>
                            </label>
                            <select class="form-select @error('agama') is-invalid @enderror change-indicator"
                                id="agama" name="agama" required data-original="{{ $penduduk->agama }}">
                                <option value="">Pilih Agama</option>
                                <option value="Islam" {{ old('agama', $penduduk->agama) == 'Islam' ? 'selected' : '' }}>
                                    Islam</option>
                                <option value="Kristen"
                                    {{ old('agama', $penduduk->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik"
                                    {{ old('agama', $penduduk->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('agama', $penduduk->agama) == 'Hindu' ? 'selected' : '' }}>
                                    Hindu</option>
                                <option value="Buddha" {{ old('agama', $penduduk->agama) == 'Buddha' ? 'selected' : '' }}>
                                    Buddha</option>
                                <option value="Konghucu"
                                    {{ old('agama', $penduduk->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                            @error('agama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="golongan_darah" class="form-label">
                                Golongan Darah
                            </label>
                            <select class="form-select @error('golongan_darah') is-invalid @enderror change-indicator"
                                id="golongan_darah" name="golongan_darah"
                                data-original="{{ $penduduk->golongan_darah }}">
                                <option value="">Pilih Golongan Darah</option>
                                <option value="A"
                                    {{ old('golongan_darah', $penduduk->golongan_darah) == 'A' ? 'selected' : '' }}>A
                                </option>
                                <option value="B"
                                    {{ old('golongan_darah', $penduduk->golongan_darah) == 'B' ? 'selected' : '' }}>B
                                </option>
                                <option value="AB"
                                    {{ old('golongan_darah', $penduduk->golongan_darah) == 'AB' ? 'selected' : '' }}>AB
                                </option>
                                <option value="O"
                                    {{ old('golongan_darah', $penduduk->golongan_darah) == 'O' ? 'selected' : '' }}>O
                                </option>
                            </select>
                            @error('golongan_darah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kewarganegaraan" class="form-label">
                                Kewarganegaraan <span class="required">*</span>
                            </label>
                            <select class="form-select @error('kewarganegaraan') is-invalid @enderror change-indicator"
                                id="kewarganegaraan" name="kewarganegaraan" required
                                data-original="{{ $penduduk->kewarganegaraan }}">
                                <option value="">Pilih Kewarganegaraan</option>
                                <option value="WNI"
                                    {{ old('kewarganegaraan', $penduduk->kewarganegaraan) == 'WNI' ? 'selected' : '' }}>WNI
                                    (Warga Negara Indonesia)</option>
                                <option value="WNA"
                                    {{ old('kewarganegaraan', $penduduk->kewarganegaraan) == 'WNA' ? 'selected' : '' }}>WNA
                                    (Warga Negara Asing)</option>
                            </select>
                            @error('kewarganegaraan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 3: Pendidikan & Pekerjaan -->
                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-mortarboard"></i>
                        </div>
                        Pendidikan & Pekerjaan
                    </h4>

                    <div class="input-group-identity">
                        <div class="mb-3">
                            <label for="pendidikan" class="form-label">
                                Pendidikan Terakhir <span class="required">*</span>
                            </label>
                            <select class="form-select @error('pendidikan') is-invalid @enderror change-indicator"
                                id="pendidikan" name="pendidikan" required data-original="{{ $penduduk->pendidikan }}">
                                <option value="">Pilih Pendidikan</option>
                                <option value="Tidak/Belum Sekolah"
                                    {{ old('pendidikan', $penduduk->pendidikan) == 'Tidak/Belum Sekolah' ? 'selected' : '' }}>
                                    Tidak/Belum Sekolah</option>
                                <option value="Belum Tamat SD/Sederajat"
                                    {{ old('pendidikan', $penduduk->pendidikan) == 'Belum Tamat SD/Sederajat' ? 'selected' : '' }}>
                                    Belum Tamat SD/Sederajat</option>
                                <option value="Tamat SD/Sederajat"
                                    {{ old('pendidikan', $penduduk->pendidikan) == 'Tamat SD/Sederajat' ? 'selected' : '' }}>
                                    Tamat SD/Sederajat</option>
                                <option value="SLTP/Sederajat"
                                    {{ old('pendidikan', $penduduk->pendidikan) == 'SLTP/Sederajat' ? 'selected' : '' }}>
                                    SLTP/Sederajat</option>
                                <option value="SLTA/Sederajat"
                                    {{ old('pendidikan', $penduduk->pendidikan) == 'SLTA/Sederajat' ? 'selected' : '' }}>
                                    SLTA/Sederajat</option>
                                <option value="Diploma I/II"
                                    {{ old('pendidikan', $penduduk->pendidikan) == 'Diploma I/II' ? 'selected' : '' }}>
                                    Diploma I/II</option>
                                <option value="Akademi/Diploma III/S.Muda"
                                    {{ old('pendidikan', $penduduk->pendidikan) == 'Akademi/Diploma III/S.Muda' ? 'selected' : '' }}>
                                    Akademi/Diploma III/S.Muda</option>
                                <option value="Diploma IV/Strata I"
                                    {{ old('pendidikan', $penduduk->pendidikan) == 'Diploma IV/Strata I' ? 'selected' : '' }}>
                                    Diploma IV/Strata I</option>
                                <option value="Strata II"
                                    {{ old('pendidikan', $penduduk->pendidikan) == 'Strata II' ? 'selected' : '' }}>Strata
                                    II</option>
                                <option value="Strata III"
                                    {{ old('pendidikan', $penduduk->pendidikan) == 'Strata III' ? 'selected' : '' }}>Strata
                                    III</option>
                            </select>
                            @error('pendidikan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pekerjaan" class="form-label">
                                Pekerjaan <span class="required">*</span>
                            </label>
                            <input type="text"
                                class="form-control @error('pekerjaan') is-invalid @enderror change-indicator"
                                id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan', $penduduk->pekerjaan) }}"
                                placeholder="Contoh: Petani, Guru, Wiraswasta" required
                                data-original="{{ $penduduk->pekerjaan }}">
                            @error('pekerjaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 4: Status & Keluarga -->
                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        Status & Data Keluarga
                    </h4>

                    <div class="input-group-identity">
                        <div class="mb-3">
                            <label for="status" class="form-label">
                                Status Perkawinan <span class="required">*</span>
                            </label>
                            <select class="form-select @error('status') is-invalid @enderror change-indicator"
                                id="status" name="status" required data-original="{{ $penduduk->status }}">
                                <option value="">Pilih Status</option>
                                <option value="Belum Kawin"
                                    {{ old('status', $penduduk->status) == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin
                                </option>
                                <option value="Kawin"
                                    {{ old('status', $penduduk->status) == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                <option value="Cerai Hidup"
                                    {{ old('status', $penduduk->status) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup
                                </option>
                                <option value="Cerai Mati"
                                    {{ old('status', $penduduk->status) == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status_keluarga" class="form-label">
                                Status dalam Keluarga <span class="required">*</span>
                            </label>
                            <select class="form-select @error('status_keluarga') is-invalid @enderror change-indicator"
                                id="status_keluarga" name="status_keluarga" required
                                data-original="{{ $penduduk->status_keluarga }}">
                                <option value="">Pilih Status Keluarga</option>
                                <option value="Kepala Keluarga"
                                    {{ old('status_keluarga', $penduduk->status_keluarga) == 'Kepala Keluarga' ? 'selected' : '' }}>
                                    Kepala Keluarga</option>
                                <option value="Istri"
                                    {{ old('status_keluarga', $penduduk->status_keluarga) == 'Istri' ? 'selected' : '' }}>
                                    Istri</option>
                                <option value="Anak"
                                    {{ old('status_keluarga', $penduduk->status_keluarga) == 'Anak' ? 'selected' : '' }}>
                                    Anak</option>
                                <option value="Menantu"
                                    {{ old('status_keluarga', $penduduk->status_keluarga) == 'Menantu' ? 'selected' : '' }}>
                                    Menantu</option>
                                <option value="Cucu"
                                    {{ old('status_keluarga', $penduduk->status_keluarga) == 'Cucu' ? 'selected' : '' }}>
                                    Cucu</option>
                                <option value="Orangtua"
                                    {{ old('status_keluarga', $penduduk->status_keluarga) == 'Orangtua' ? 'selected' : '' }}>
                                    Orangtua</option>
                                <option value="Mertua"
                                    {{ old('status_keluarga', $penduduk->status_keluarga) == 'Mertua' ? 'selected' : '' }}>
                                    Mertua</option>
                                <option value="Famili Lain"
                                    {{ old('status_keluarga', $penduduk->status_keluarga) == 'Famili Lain' ? 'selected' : '' }}>
                                    Famili Lain</option>
                                <option value="Pembantu"
                                    {{ old('status_keluarga', $penduduk->status_keluarga) == 'Pembantu' ? 'selected' : '' }}>
                                    Pembantu</option>
                                <option value="Lainnya"
                                    {{ old('status_keluarga', $penduduk->status_keluarga) == 'Lainnya' ? 'selected' : '' }}>
                                    Lainnya</option>
                            </select>
                            @error('status_keluarga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="input-group-parents">
                        <div class="mb-3">
                            <label for="nama_ayah" class="form-label">
                                Nama Ayah <span class="required">*</span>
                            </label>
                            <input type="text"
                                class="form-control @error('nama_ayah') is-invalid @enderror change-indicator"
                                id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah', $penduduk->nama_ayah) }}"
                                placeholder="Nama lengkap ayah" required data-original="{{ $penduduk->nama_ayah }}">
                            @error('nama_ayah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_ibu" class="form-label">
                                Nama Ibu <span class="required">*</span>
                            </label>
                            <input type="text"
                                class="form-control @error('nama_ibu') is-invalid @enderror change-indicator"
                                id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu', $penduduk->nama_ibu) }}"
                                placeholder="Nama lengkap ibu" required data-original="{{ $penduduk->nama_ibu }}">
                            @error('nama_ibu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('admin.penduduk.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="{{ route('admin.penduduk.show', $penduduk->nik) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-eye me-2"></i>Lihat Detail
                    </a>
                    <button type="button" class="btn btn-warning" onclick="resetForm()">
                        <i class="bi bi-arrow-clockwise me-2"></i>Reset
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="bi bi-check-lg me-2"></i>Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Perubahan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menyimpan perubahan data penduduk ini?</p>
                    <div id="changesList" class="alert alert-info">
                        <strong>Perubahan yang akan disimpan:</strong>
                        <ul id="changesUl"></ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="confirmSave()">
                        <i class="bi bi-check-lg me-2"></i>Ya, Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        let hasChanges = false;
        let originalData = {};

        document.addEventListener('DOMContentLoaded', function() {
            // Store original data
            storeOriginalData();

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    if (alert.querySelector('.btn-close')) {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }
                }, 5000);
            });

            // Initialize form functionality
            initFormValidation();
            initChangeTracking();
            initCharacterCounter();
            initAgeCalculator();
            initNameCapitalization();
            initNIKFormatting();
            initKKSearchableDropdown();
        });
        // Initialize searchable KK dropdown
        function initKKSearchableDropdown() {
            const searchInput = document.getElementById('kk_search');
            const hiddenSelect = document.getElementById('no_kk');
            const dropdown = document.getElementById('kk_dropdown');
            const options = document.querySelectorAll('.kk-option');

            // Show dropdown on focus
            searchInput.addEventListener('focus', function() {
                dropdown.classList.add('show');
                filterOptions('');
            });

            // Hide dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.position-relative')) {
                    dropdown.classList.remove('show');
                }
            });

            // Filter options based on search
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                filterOptions(searchTerm);
            });

            // Handle option selection
            options.forEach(option => {
                option.addEventListener('click', function() {
                    const value = this.dataset.value;
                    const text = this.querySelector('strong').textContent;
                    const noKk = this.querySelector('.text-muted').textContent;

                    searchInput.value = `${text} - ${noKk}`;
                    hiddenSelect.value = value;
                    dropdown.classList.remove('show');

                    // Trigger change event for change tracking
                    hiddenSelect.dispatchEvent(new Event('change'));
                    checkForChanges(hiddenSelect);
                });
            });

            function filterOptions(searchTerm) {
                options.forEach(option => {
                    const searchData = option.dataset.search;
                    if (searchData.includes(searchTerm)) {
                        option.style.display = 'block';
                    } else {
                        option.style.display = 'none';
                    }
                });
            }

            // Initialize with current value if exists
            if (hiddenSelect.value) {
                const selectedOption = hiddenSelect.options[hiddenSelect.selectedIndex];
                if (selectedOption) {
                    searchInput.value = selectedOption.text;
                }
            }

            // Track changes in search input
            searchInput.addEventListener('input', function() {
                // Mark as changed if search input differs from selected option
                const selectedOption = hiddenSelect.options[hiddenSelect.selectedIndex];
                const expectedText = selectedOption ? selectedOption.text : '';

                if (this.value !== expectedText) {
                    this.classList.add('changed');
                } else {
                    this.classList.remove('changed');
                }
            });
        }
        // Store original form data
        function storeOriginalData() {
            const formElements = document.querySelectorAll('.change-indicator');
            formElements.forEach(element => {
                const original = element.dataset.original || '';
                originalData[element.name] = original;
            });
        }

        // Track changes in form fields
        function initChangeTracking() {
            const formElements = document.querySelectorAll('.change-indicator');

            formElements.forEach(element => {
                element.addEventListener('input', function() {
                    checkForChanges(this);
                });

                element.addEventListener('change', function() {
                    checkForChanges(this);
                });
            });
        }

        // Check if field has changed
        function checkForChanges(element) {
            const original = originalData[element.name] || '';
            const current = element.value;

            if (current !== original) {
                element.classList.add('changed');
                hasChanges = true;
            } else {
                element.classList.remove('changed');
            }

            // Check if any changes exist
            updateChangeStatus();
        }

        // Update overall change status
        function updateChangeStatus() {
            const changedElements = document.querySelectorAll('.change-indicator.changed');
            hasChanges = changedElements.length > 0;

            const submitBtn = document.getElementById('submitBtn');
            if (hasChanges) {
                submitBtn.innerHTML = '<i class="bi bi-exclamation-circle me-2"></i>Simpan Perubahan';
                submitBtn.classList.add('btn-warning');
                submitBtn.classList.remove('btn-primary');
            } else {
                submitBtn.innerHTML = '<i class="bi bi-check-lg me-2"></i>Perbarui Data';
                submitBtn.classList.add('btn-primary');
                submitBtn.classList.remove('btn-warning');
            }
        }

        // Character counter for nama_lengkap
        function initCharacterCounter() {
            const namaInput = document.getElementById('nama_lengkap');
            const namaCounter = document.getElementById('namaCounter');

            function updateCounter() {
                const length = namaInput.value.length;
                const maxLength = 255;
                namaCounter.textContent = `${length}/${maxLength}`;

                namaCounter.classList.remove('warning', 'danger');
                if (length > maxLength * 0.9) {
                    namaCounter.classList.add('danger');
                } else if (length > maxLength * 0.7) {
                    namaCounter.classList.add('warning');
                }
            }

            namaInput.addEventListener('input', updateCounter);
            updateCounter(); // Initialize
        }

        // Age calculator
        function initAgeCalculator() {
            const birthDateInput = document.getElementById('tanggal_lahir');
            const ageDisplay = document.getElementById('ageDisplay');
            const ageText = document.getElementById('ageText');

            function calculateAge() {
                const birthDate = new Date(birthDateInput.value);
                const today = new Date();

                if (birthDate && !isNaN(birthDate)) {
                    let age = today.getFullYear() - birthDate.getFullYear();
                    const monthDiff = today.getMonth() - birthDate.getMonth();

                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }

                    if (age >= 0) {
                        ageText.textContent = `Umur: ${age} tahun`;
                        ageDisplay.classList.add('show');
                    } else {
                        ageDisplay.classList.remove('show');
                    }
                } else {
                    ageDisplay.classList.remove('show');
                }
            }

            birthDateInput.addEventListener('change', calculateAge);
            calculateAge(); // Initialize
        }

        // Auto capitalize names
        function initNameCapitalization() {
            const nameInputs = ['nama_lengkap', 'tempat_lahir', 'nama_ayah', 'nama_ibu'];
            nameInputs.forEach(inputId => {
                const input = document.getElementById(inputId);
                if (input) {
                    input.addEventListener('input', function(e) {
                        e.target.value = e.target.value.toLowerCase().replace(/\b\w/g, l => l
                            .toUpperCase());
                    });
                }
            });
        }

        // Format NIK (numbers only)
        function initNIKFormatting() {
            const nikInput = document.getElementById('nik');
            nikInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');
            });
        }

        // Form validation
        function initFormValidation() {
            const form = document.getElementById('editForm');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                if (validateForm()) {
                    if (hasChanges) {
                        showConfirmationModal();
                    } else {
                        // No changes, show info and don't submit
                        alert('Tidak ada perubahan yang dibuat.');
                    }
                }
            });
        }

        // Validate form
        function validateForm() {
            const nik = document.getElementById('nik').value;
            const noKk = document.getElementById('no_kk').value;
            const birthDate = document.getElementById('tanggal_lahir').value;

            // Validate NIK
            if (nik.length !== 16) {
                alert('NIK harus 16 digit!');
                document.getElementById('nik').focus();
                return false;
            }

            // Validate KK selection
            if (!noKk) {
                alert('Pilih Kartu Keluarga terlebih dahulu!');
                document.getElementById('no_kk').focus();
                return false;
            }

            // Validate birth date
            if (birthDate) {
                const birthDateObj = new Date(birthDate);
                const today = new Date();
                if (birthDateObj > today) {
                    alert('Tanggal lahir tidak boleh di masa depan!');
                    document.getElementById('tanggal_lahir').focus();
                    return false;
                }
            }

            return true;
        }

        // Show confirmation modal with changes
        function showConfirmationModal() {
            const changedElements = document.querySelectorAll('.change-indicator.changed');
            const changesList = document.getElementById('changesUl');
            changesList.innerHTML = '';

            changedElements.forEach(element => {
                const label = element.closest('.mb-3').querySelector('.form-label').textContent.replace(' *', '');
                const original = originalData[element.name] || '(kosong)';
                const current = element.value || '(kosong)';

                const li = document.createElement('li');
                li.innerHTML = `<strong>${label}:</strong> "${original}" → "${current}"`;
                changesList.appendChild(li);
            });

            const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
            modal.show();
        }

        // Confirm save
        function confirmSave() {
            const modal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
            modal.hide();

            // Add loading state
            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';
            submitBtn.disabled = true;

            // Submit form
            document.getElementById('editForm').submit();
        }

        // Reset form to original values
        function resetForm() {
            if (hasChanges) {
                if (confirm('Apakah Anda yakin ingin membatalkan semua perubahan?')) {
                    const formElements = document.querySelectorAll('.change-indicator');
                    formElements.forEach(element => {
                        const original = originalData[element.name] || '';
                        element.value = original;
                        element.classList.remove('changed');
                    });

                    hasChanges = false;
                    updateChangeStatus();

                    // Recalculate age
                    const ageCalculator = document.getElementById('tanggal_lahir');
                    if (ageCalculator) {
                        ageCalculator.dispatchEvent(new Event('change'));
                    }

                    // Update character counter
                    const namaInput = document.getElementById('nama_lengkap');
                    if (namaInput) {
                        namaInput.dispatchEvent(new Event('input'));
                    }
                }
            } else {
                alert('Tidak ada perubahan untuk direset.');
            }
        }

        // Warn before leaving if there are unsaved changes
        window.addEventListener('beforeunload', function(e) {
            if (hasChanges) {
                e.preventDefault();
                e.returnValue = '';
                return 'Anda memiliki perubahan yang belum disimpan. Yakin ingin meninggalkan halaman ini?';
            }
        });

        // Handle browser back button
        window.addEventListener('popstate', function(e) {
            if (hasChanges) {
                if (confirm('Anda memiliki perubahan yang belum disimpan. Yakin ingin kembali?')) {
                    return true;
                } else {
                    history.pushState(null, null, location.href);
                    return false;
                }
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl + S to save
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                if (hasChanges) {
                    document.getElementById('editForm').dispatchEvent(new Event('submit'));
                }
            }

            // Ctrl + R to reset
            if (e.ctrlKey && e.key === 'r') {
                e.preventDefault();
                resetForm();
            }

            // Escape to go back
            if (e.key === 'Escape') {
                if (!hasChanges || confirm('Anda memiliki perubahan yang belum disimpan. Yakin ingin kembali?')) {
                    window.location.href = '{{ route('admin.penduduk.index') }}';
                }
            }
        });

        // Auto-save draft (optional feature)
        function autoSaveDraft() {
            if (hasChanges) {
                const formData = new FormData(document.getElementById('editForm'));
                const data = Object.fromEntries(formData);
                localStorage.setItem('penduduk_edit_draft_{{ $penduduk->nik }}', JSON.stringify(data));
                console.log('Draft saved automatically');
            }
        }

        // Auto-save every 30 seconds
        setInterval(autoSaveDraft, 30000);

        // Load draft on page load
        function loadDraft() {
            const draft = localStorage.getItem('penduduk_edit_draft_{{ $penduduk->nik }}');
            if (draft) {
                const data = JSON.parse(draft);
                const loadDraftBtn = document.createElement('button');
                loadDraftBtn.type = 'button';
                loadDraftBtn.className = 'btn btn-sm btn-info me-2';
                loadDraftBtn.innerHTML = '<i class="bi bi-cloud-download me-1"></i>Muat Draft';
                loadDraftBtn.onclick = function() {
                    if (confirm('Muat draft yang tersimpan? Ini akan mengganti data form saat ini.')) {
                        Object.keys(data).forEach(key => {
                            const element = document.querySelector(`[name="${key}"]`);
                            if (element) {
                                element.value = data[key];
                                checkForChanges(element);
                            }
                        });

                        // Trigger recalculations
                        document.getElementById('tanggal_lahir').dispatchEvent(new Event('change'));
                        document.getElementById('nama_lengkap').dispatchEvent(new Event('input'));
                    }
                };

                const formActions = document.querySelector('.form-actions');
                formActions.insertBefore(loadDraftBtn, formActions.firstChild);
            }
        }

        // Load draft after DOM is ready
        setTimeout(loadDraft, 100);

        // Clear draft after successful save
        window.addEventListener('beforeunload', function() {
            if (!hasChanges) {
                localStorage.removeItem('penduduk_edit_draft_{{ $penduduk->nik }}');
            }
        });
    </script>
@endpush
