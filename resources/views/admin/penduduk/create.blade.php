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
        .input-group-personal {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 15px;
        }

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

        /* Progress Steps */
        .form-progress {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            gap: 10px;
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

        /* KK Selection Card */
        .kk-selection-card {
            background: linear-gradient(135deg, rgba(255, 140, 66, 0.1), rgba(45, 80, 22, 0.05));
            border: 1px solid rgba(255, 140, 66, 0.2);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .kk-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .kk-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: var(--accent-orange);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.3rem;
        }

        .kk-details h6 {
            color: var(--primary-green);
            font-weight: 600;
            margin-bottom: 5px;
        }

        [data-theme="dark"] .kk-details h6 {
            color: var(--light-green);
        }

        .kk-details p {
            color: var(--soft-gray);
            margin: 0;
            font-size: 0.9rem;
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

        /* Responsive */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            .input-group-personal,
            .input-group-birth,
            .input-group-identity,
            .input-group-parents {
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

            .form-header {
                margin-bottom: 20px;
            }

            .form-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .kk-info {
                flex-direction: column;
                text-align: center;
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
        <!-- Page Header -->
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Data Penduduk</li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.penduduk.index') }}">Data Penduduk</a></li>
                    <li class="breadcrumb-item active">Tambah Penduduk Baru</li>
                </ol>
            </nav>
            <h1 class="page-title">Tambah Penduduk Baru</h1>
            <p class="page-subtitle">Lengkapi form di bawah untuk menambahkan data penduduk baru ke sistem</p>
        </div>

        <!-- Progress Steps -->
        <div class="form-progress">
            <div class="progress-step active">
                <div class="step-number">1</div>
                <span>Data Pribadi</span>
            </div>
            <div class="progress-step">
                <div class="step-number">2</div>
                <span>Identitas & KK</span>
            </div>
            <div class="progress-step">
                <div class="step-number">3</div>
                <span>Data Keluarga</span>
            </div>
            <div class="progress-step">
                <div class="step-number">4</div>
                <span>Konfirmasi</span>
            </div>
        </div>

        <!-- KK Selection Info -->
        <div class="kk-selection-card">
            <div class="kk-info">
                <div class="kk-icon">
                    <i class="bi bi-house-door"></i>
                </div>
                <div class="kk-details">
                    <h6>Pilih Kartu Keluarga</h6>
                    <p>Penduduk akan ditambahkan ke dalam salah satu KK yang sudah ada di sistem</p>
                </div>
            </div>
        </div>

        <!-- Main Form -->
        <div class="form-container">
            <div class="form-header">
                <div class="form-icon">
                    <i class="bi bi-person-plus-fill"></i>
                </div>
                <h2 class="form-title">Form Tambah Penduduk</h2>
                <p class="form-subtitle">Masukkan data penduduk dengan lengkap dan benar</p>
            </div>

            <form action="{{ route('admin.penduduk.store') }}" method="POST" novalidate>
                @csrf

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
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik"
                                name="nik" value="{{ old('nik') }}" placeholder="Masukkan 16 digit NIK"
                                maxlength="16" pattern="[0-9]{16}" required>
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

                                <select class="form-select d-none @error('no_kk') is-invalid @enderror" id="no_kk"
                                    name="no_kk" required>
                                    <option value="">Pilih Nomor KK</option>
                                    @foreach ($kkList as $kk)
                                        <option value="{{ $kk->no_kk }}" data-nama="{{ $kk->nama_kepala_keluarga }}"
                                            data-alamat="{{ $kk->alamat }}" data-desa="{{ $kk->desa }}"
                                            {{ old('no_kk') == $kk->no_kk ? 'selected' : '' }}>
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
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                placeholder="Masukkan nama lengkap sesuai KTP" maxlength="255" required>
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
                            <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                placeholder="Kota/Kabupaten lahir" required>
                            @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">
                                Tanggal Lahir <span class="required">*</span>
                            </label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                max="{{ date('Y-m-d') }}" required>
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
                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin"
                                name="jenis_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
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
                            <select class="form-select @error('agama') is-invalid @enderror" id="agama"
                                name="agama" required>
                                <option value="">Pilih Agama</option>
                                <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu
                                </option>
                            </select>
                            @error('agama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="golongan_darah" class="form-label">
                                Golongan Darah
                            </label>
                            <select class="form-select @error('golongan_darah') is-invalid @enderror" id="golongan_darah"
                                name="golongan_darah">
                                <option value="">Pilih Golongan Darah</option>
                                <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                                <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                                <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                            </select>
                            @error('golongan_darah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kewarganegaraan" class="form-label">
                                Kewarganegaraan <span class="required">*</span>
                            </label>
                            <select class="form-select @error('kewarganegaraan') is-invalid @enderror"
                                id="kewarganegaraan" name="kewarganegaraan" required>
                                <option value="">Pilih Kewarganegaraan</option>
                                <option value="WNI" {{ old('kewarganegaraan') == 'WNI' ? 'selected' : '' }}>WNI (Warga
                                    Negara Indonesia)</option>
                                <option value="WNA" {{ old('kewarganegaraan') == 'WNA' ? 'selected' : '' }}>WNA (Warga
                                    Negara Asing)</option>
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
                            <select class="form-select @error('pendidikan') is-invalid @enderror" id="pendidikan"
                                name="pendidikan" required>
                                <option value="">Pilih Pendidikan</option>
                                <option value="Tidak/Belum Sekolah"
                                    {{ old('pendidikan') == 'Tidak/Belum Sekolah' ? 'selected' : '' }}>Tidak/Belum Sekolah
                                </option>
                                <option value="Belum Tamat SD/Sederajat"
                                    {{ old('pendidikan') == 'Belum Tamat SD/Sederajat' ? 'selected' : '' }}>Belum Tamat
                                    SD/Sederajat</option>
                                <option value="Tamat SD/Sederajat"
                                    {{ old('pendidikan') == 'Tamat SD/Sederajat' ? 'selected' : '' }}>Tamat SD/Sederajat
                                </option>
                                <option value="SLTP/Sederajat"
                                    {{ old('pendidikan') == 'SLTP/Sederajat' ? 'selected' : '' }}>SLTP/Sederajat</option>
                                <option value="SLTA/Sederajat"
                                    {{ old('pendidikan') == 'SLTA/Sederajat' ? 'selected' : '' }}>SLTA/Sederajat</option>
                                <option value="Diploma I/II" {{ old('pendidikan') == 'Diploma I/II' ? 'selected' : '' }}>
                                    Diploma I/II</option>
                                <option value="Akademi/Diploma III/S.Muda"
                                    {{ old('pendidikan') == 'Akademi/Diploma III/S.Muda' ? 'selected' : '' }}>
                                    Akademi/Diploma III/S.Muda</option>
                                <option value="Diploma IV/Strata I"
                                    {{ old('pendidikan') == 'Diploma IV/Strata I' ? 'selected' : '' }}>Diploma IV/Strata I
                                </option>
                                <option value="Strata II" {{ old('pendidikan') == 'Strata II' ? 'selected' : '' }}>Strata
                                    II</option>
                                <option value="Strata III" {{ old('pendidikan') == 'Strata III' ? 'selected' : '' }}>
                                    Strata III</option>
                            </select>
                            @error('pendidikan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pekerjaan" class="form-label">
                                Pekerjaan <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror"
                                id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}"
                                placeholder="Contoh: Petani, Guru, Wiraswasta" required>
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
                            <select class="form-select @error('status') is-invalid @enderror" id="status"
                                name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="Belum Kawin" {{ old('status') == 'Belum Kawin' ? 'selected' : '' }}>Belum
                                    Kawin</option>
                                <option value="Kawin" {{ old('status') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                <option value="Cerai Hidup" {{ old('status') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai
                                    Hidup</option>
                                <option value="Cerai Mati" {{ old('status') == 'Cerai Mati' ? 'selected' : '' }}>Cerai
                                    Mati</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status_keluarga" class="form-label">
                                Status dalam Keluarga <span class="required">*</span>
                            </label>
                            <select class="form-select @error('status_keluarga') is-invalid @enderror"
                                id="status_keluarga" name="status_keluarga" required>
                                <option value="">Pilih Status Keluarga</option>
                                <option value="Kepala Keluarga"
                                    {{ old('status_keluarga') == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga
                                </option>
                                <option value="Istri" {{ old('status_keluarga') == 'Istri' ? 'selected' : '' }}>Istri
                                </option>
                                <option value="Anak" {{ old('status_keluarga') == 'Anak' ? 'selected' : '' }}>Anak
                                </option>
                                <option value="Menantu" {{ old('status_keluarga') == 'Menantu' ? 'selected' : '' }}>
                                    Menantu</option>
                                <option value="Cucu" {{ old('status_keluarga') == 'Cucu' ? 'selected' : '' }}>Cucu
                                </option>
                                <option value="Orangtua" {{ old('status_keluarga') == 'Orangtua' ? 'selected' : '' }}>
                                    Orangtua</option>
                                <option value="Mertua" {{ old('status_keluarga') == 'Mertua' ? 'selected' : '' }}>Mertua
                                </option>
                                <option value="Famili Lain"
                                    {{ old('status_keluarga') == 'Famili Lain' ? 'selected' : '' }}>Famili Lain</option>
                                <option value="Pembantu" {{ old('status_keluarga') == 'Pembantu' ? 'selected' : '' }}>
                                    Pembantu</option>
                                <option value="Lainnya" {{ old('status_keluarga') == 'Lainnya' ? 'selected' : '' }}>
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
                            <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror"
                                id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah') }}"
                                placeholder="Nama lengkap ayah" required>
                            @error('nama_ayah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama_ibu" class="form-label">
                                Nama Ibu <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror"
                                id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu') }}"
                                placeholder="Nama lengkap ibu" required>
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
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Format NIK (hanya angka)
            const nikInput = document.getElementById('nik');
            nikInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');
            });

            //Pencarian KK
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

                    // Trigger change event
                    hiddenSelect.dispatchEvent(new Event('change'));
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

            // Initialize with old value if exists
            if (hiddenSelect.value) {
                const selectedOption = hiddenSelect.options[hiddenSelect.selectedIndex];
                if (selectedOption) {
                    searchInput.value = selectedOption.text;
                }
            }

            // Character counter for nama_lengkap
            const namaInput = document.getElementById('nama_lengkap');
            const namaCounter = document.getElementById('namaCounter');

            namaInput.addEventListener('input', function(e) {
                const length = e.target.value.length;
                const maxLength = 255;
                namaCounter.textContent = `${length}/${maxLength}`;

                if (length > maxLength * 0.9) {
                    namaCounter.classList.add('danger');
                    namaCounter.classList.remove('warning');
                } else if (length > maxLength * 0.7) {
                    namaCounter.classList.add('warning');
                    namaCounter.classList.remove('danger');
                } else {
                    namaCounter.classList.remove('warning', 'danger');
                }
            });

            // Age calculator
            const birthDateInput = document.getElementById('tanggal_lahir');
            const ageDisplay = document.getElementById('ageDisplay');
            const ageText = document.getElementById('ageText');

            birthDateInput.addEventListener('change', function(e) {
                const birthDate = new Date(e.target.value);
                const today = new Date();

                if (birthDate) {
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
            });

            // Auto capitalize names
            const nameInputs = ['nama_lengkap', 'tempat_lahir', 'nama_ayah', 'nama_ibu'];
            nameInputs.forEach(inputId => {
                const input = document.getElementById(inputId);
                if (input) {
                    input.addEventListener('input', function(e) {
                        // Capitalize first letter of each word
                        e.target.value = e.target.value.toLowerCase().replace(/\b\w/g, l => l
                            .toUpperCase());
                    });
                }
            });

            // Form validation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const nik = document.getElementById('nik').value;
                const noKk = document.getElementById('no_kk').value;
                const birthDate = document.getElementById('tanggal_lahir').value;

                // Validate NIK
                if (nik.length !== 16) {
                    e.preventDefault();
                    alert('NIK harus 16 digit!');
                    document.getElementById('nik').focus();
                    return false;
                }

                // Validate KK selection
                if (!noKk) {
                    e.preventDefault();
                    alert('Pilih Kartu Keluarga terlebih dahulu!');
                    document.getElementById('no_kk').focus();
                    return false;
                }

                // Validate birth date
                if (birthDate) {
                    const birthDateObj = new Date(birthDate);
                    const today = new Date();
                    if (birthDateObj > today) {
                        e.preventDefault();
                        alert('Tanggal lahir tidak boleh di masa depan!');
                        document.getElementById('tanggal_lahir').focus();
                        return false;
                    }
                }
            });

            // Progress step animation
            const formSections = document.querySelectorAll('.form-section');
            const progressSteps = document.querySelectorAll('.progress-step');

            // Intersection Observer for progress steps
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const index = Array.from(formSections).indexOf(entry.target);

                        // Reset all steps
                        progressSteps.forEach(step => step.classList.remove('active'));

                        // Activate current step
                        if (progressSteps[index]) {
                            progressSteps[index].classList.add('active');
                        }
                    }
                });
            }, {
                threshold: 0.5,
                rootMargin: '-100px 0px -100px 0px'
            });

            formSections.forEach(section => {
                observer.observe(section);
            });

            // Auto-suggest for pekerjaan
            const pekerjaanInput = document.getElementById('pekerjaan');
            const commonJobs = [
                'Petani', 'Buruh Tani', 'Nelayan', 'Pedagang', 'Wiraswasta',
                'Guru', 'Dosen', 'Dokter', 'Perawat', 'Bidan',
                'PNS', 'TNI', 'Polri', 'Pegawai Swasta', 'Karyawan BUMN',
                'Sopir', 'Tukang', 'Montir', 'Mekanik', 'Teknisi',
                'Ibu Rumah Tangga', 'Pelajar/Mahasiswa', 'Pensiunan',
                'Tidak/Belum Bekerja'
            ];

            pekerjaanInput.addEventListener('input', function(e) {
                const value = e.target.value.toLowerCase();
                // Simple auto-suggest logic can be added here
            });

            // Smart defaults based on birth date
            birthDateInput.addEventListener('change', function(e) {
                const birthDate = new Date(e.target.value);
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();

                const statusSelect = document.getElementById('status');
                const pendidikanSelect = document.getElementById('pendidikan');
                const pekerjaanInput = document.getElementById('pekerjaan');

                // Auto-suggest status based on age
                if (age < 17) {
                    statusSelect.value = 'Belum Kawin';
                    pendidikanSelect.value = age < 6 ? 'Tidak/Belum Sekolah' :
                        age < 12 ? 'Belum Tamat SD/Sederajat' :
                        age < 15 ? 'Tamat SD/Sederajat' : 'SLTP/Sederajat';
                    pekerjaanInput.value = age < 16 ? 'Pelajar/Mahasiswa' : '';
                }
            });

            // KK selection change handler
            const kkSelect = document.getElementById('no_kk');
            kkSelect.addEventListener('change', function(e) {
                const selectedOption = e.target.selectedOptions[0];
                if (selectedOption && selectedOption.value) {
                    // You can add logic here to show KK details
                    console.log('Selected KK:', selectedOption.text);
                }
            });

            // Keyboard navigation improvements
            document.addEventListener('keydown', function(e) {
                // Enter key to move to next field
                if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA' && e.target.type !== 'submit') {
                    e.preventDefault();
                    const formElements = Array.from(form.querySelectorAll('input, select, textarea'));
                    const currentIndex = formElements.indexOf(e.target);
                    const nextElement = formElements[currentIndex + 1];
                    if (nextElement) {
                        nextElement.focus();
                    }
                }
            });

            // Initialize character counter
            if (namaInput.value) {
                namaInput.dispatchEvent(new Event('input'));
            }

            // Initialize age calculator
            if (birthDateInput.value) {
                birthDateInput.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endpush
