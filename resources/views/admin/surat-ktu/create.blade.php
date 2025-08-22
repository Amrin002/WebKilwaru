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
                    <li class="breadcrumb-item"><a href="{{ route('admin.surat-ktu.index') }}">Surat KTU</a></li>
                    <li class="breadcrumb-item active">Buat Surat Baru</li>
                </ol>
            </nav>
            <h1 class="page-title">Buat Surat Keterangan Usaha</h1>
            <p class="page-subtitle">Lengkapi form di bawah untuk membuat surat KTU baru dalam sistem</p>
        </div>

        <div class="info-card">
            <div class="info-icon">
                <i class="bi bi-info-lg"></i>
            </div>
            <h6>Petunjuk Pengisian</h6>
            <p>
                Sebagai admin, Anda dapat membuat surat KTU untuk pengguna terdaftar atau sebagai guest (tanpa akun).
                Pastikan data yang dimasukkan sesuai dengan dokumen identitas dan data usaha yang valid.
                Anda juga dapat langsung menentukan status surat dan memberikan nomor surat jika sudah disetujui.
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
                <span>Data Usaha</span>
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
                <h2 class="form-title">Form Buat Surat KTU</h2>
                <p class="form-subtitle">Masukkan data surat keterangan usaha dengan lengkap dan benar</p>
            </div>

            <form action="{{ route('admin.surat-ktu.store') }}" method="POST" novalidate>
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
                            <div class="toggle-btn active" data-type="user">
                                <i class="bi bi-person-check me-2"></i>
                                Pengguna Terdaftar
                            </div>
                            <div class="toggle-btn" data-type="guest">
                                <i class="bi bi-person-plus me-2"></i>
                                Guest (Tanpa Akun)
                            </div>
                        </div>

                        <div class="user-select-container active" id="user-container">
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

                        <div class="user-select-container" id="guest-container">
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
                            <i class="bi bi-person-vcard"></i>
                        </div>
                        Data Pemohon
                    </h4>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="nama" class="form-label">
                                Nama Lengkap <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                name="nama" value="{{ old('nama') }}" placeholder="Nama lengkap pemohon"
                                maxlength="100" required>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Nama lengkap sesuai KTP/identitas resmi
                            </div>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="jenis_kelamin" class="form-label">
                                Jenis Kelamin <span class="required">*</span>
                            </label>
                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin"
                                name="jenis_kelamin" required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                                    Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
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
                                placeholder="Kota/Kabupaten tempat lahir" maxlength="100" required>
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
                        <div class="col-md-4 mb-3">
                            <label for="kewarganegaraan" class="form-label">
                                Kewarganegaraan <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('kewarganegaraan') is-invalid @enderror"
                                id="kewarganegaraan" name="kewarganegaraan"
                                value="{{ old('kewarganegaraan', 'Indonesia') }}" placeholder="Kewarganegaraan"
                                maxlength="50" required>
                            @error('kewarganegaraan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="agama" class="form-label">
                                Agama <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('agama') is-invalid @enderror"
                                id="agama" name="agama" value="{{ old('agama') }}" placeholder="Agama"
                                maxlength="50" required>
                            @error('agama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="pekerjaan" class="form-label">
                                Pekerjaan <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror"
                                id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}" placeholder="Pekerjaan"
                                maxlength="50" required>
                            @error('pekerjaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="alamat" class="form-label">
                                Alamat Lengkap <span class="required">*</span>
                            </label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
                                placeholder="Alamat lengkap tempat tinggal saat ini" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
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
                            <i class="bi bi-shop"></i>
                        </div>
                        Data Usaha
                    </h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_usaha" class="form-label">
                                Nama Usaha <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('nama_usaha') is-invalid @enderror"
                                id="nama_usaha" name="nama_usaha" value="{{ old('nama_usaha') }}"
                                placeholder="Contoh: Warung Sembako Barokah" maxlength="100" required>
                            @error('nama_usaha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="jenis_usaha" class="form-label">
                                Jenis Usaha <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('jenis_usaha') is-invalid @enderror"
                                id="jenis_usaha" name="jenis_usaha" value="{{ old('jenis_usaha') }}"
                                placeholder="Contoh: Perdagangan" maxlength="100" required>
                            @error('jenis_usaha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pemilik_usaha" class="form-label">
                                Nama Pemilik Usaha <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('pemilik_usaha') is-invalid @enderror"
                                id="pemilik_usaha" name="pemilik_usaha" value="{{ old('pemilik_usaha') }}"
                                placeholder="Nama pemilik usaha" maxlength="100" required>
                            @error('pemilik_usaha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="alamat_usaha" class="form-label">
                                Alamat Usaha <span class="required">*</span>
                            </label>
                            <textarea class="form-control @error('alamat_usaha') is-invalid @enderror" id="alamat_usaha" name="alamat_usaha"
                                rows="3" placeholder="Alamat lengkap lokasi usaha" required>{{ old('alamat_usaha') }}</textarea>
                            @error('alamat_usaha')
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

                            <div class="col-md-8 mb-3" id="nomor-surat-container" style="display: none;">
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
                    <a href="{{ route('admin.surat-ktu.index') }}" class="btn btn-outline-secondary">
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
            const phoneContainer = document.getElementById('phone-container');
            const phoneRequired = document.getElementById('phone-required');
            const phoneText = document.getElementById('phone-text');
            const phoneInput = document.getElementById('nomor_telepon');
            const statusSelect = document.getElementById('status');
            const nomorSuratContainer = document.getElementById('nomor-surat-container');

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
                        phoneRequired.style.display = 'none';
                        phoneText.textContent = 'Opsional untuk pengguna terdaftar';
                        phoneInput.required = false;
                    } else {
                        userContainer.classList.remove('active');
                        guestContainer.classList.add('active');
                        userSelect.required = false;
                        userSelect.value = '';
                        phoneRequired.style.display = 'inline';
                        phoneText.textContent = 'Wajib diisi untuk guest (tracking surat)';
                        phoneInput.required = true;
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

            // Format nama (hanya huruf dan spasi)
            const namaInput = document.getElementById('nama');
            namaInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/[^a-zA-Z\s]/g, '');
                e.target.value = e.target.value.toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
            });

            // Format tempat lahir
            const tempatLahirInput = document.getElementById('tempat_lahir');
            tempatLahirInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/[^a-zA-Z\s]/g, '');
                e.target.value = e.target.value.toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
            });

            // Format kewarganegaraan
            const kewarganegaraanInput = document.getElementById('kewarganegaraan');
            kewarganegaraanInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/[^a-zA-Z\s]/g, '');
                e.target.value = e.target.value.toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
            });

            // Format pekerjaan
            const pekerjaanInput = document.getElementById('pekerjaan');
            pekerjaanInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/[^a-zA-Z\s]/g, '');
                e.target.value = e.target.value.toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
            });

            // Format nomor telepon (hanya angka)
            phoneInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');

                // Auto format dengan awalan 08 jika user mulai dengan 8
                if (e.target.value.startsWith('8') && e.target.value.length === 1) {
                    e.target.value = '08';
                }
            });

            // Validasi tanggal lahir (tidak boleh masa depan)
            const tanggalLahirInput = document.getElementById('tanggal_lahir');
            tanggalLahirInput.addEventListener('change', function(e) {
                const today = new Date();
                const birthDate = new Date(e.target.value);

                if (birthDate > today) {
                    alert('Tanggal lahir tidak boleh di masa depan!');
                    e.target.value = '';
                }

                // Validasi usia minimal 1 tahun
                const minDate = new Date();
                minDate.setFullYear(today.getFullYear() - 100);

                if (birthDate < minDate) {
                    alert('Tanggal lahir tidak valid!');
                    e.target.value = '';
                }
            });

            // Set max date untuk tanggal lahir
            const today = new Date().toISOString().split('T')[0];
            tanggalLahirInput.setAttribute('max', today);

            // Form validation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                let isValid = true;
                let errorMessage = '';

                // Validate user selection
                const isUserMode = document.querySelector('.toggle-btn[data-type="user"]').classList
                    .contains('active');

                if (isUserMode && !userSelect.value) {
                    isValid = false;
                    errorMessage = 'Pilih pengguna terdaftar atau ubah ke mode guest!';
                }

                if (!isUserMode && !phoneInput.value.trim()) {
                    isValid = false;
                    errorMessage = 'Nomor telepon wajib diisi untuk guest!';
                }

                // Validate nama
                const nama = namaInput.value.trim();
                if (nama.length < 2) {
                    isValid = false;
                    errorMessage = 'Nama lengkap harus minimal 2 karakter!';
                }

                if (!/^[a-zA-Z\s]+$/.test(nama)) {
                    isValid = false;
                    errorMessage = 'Nama hanya boleh berisi huruf dan spasi!';
                }

                // Validate phone number format for guest
                if (!isUserMode && phoneInput.value) {
                    const phone = phoneInput.value;
                    if (phone.length < 10 || phone.length > 15) {
                        isValid = false;
                        errorMessage = 'Nomor telepon harus 10-15 digit!';
                    }
                }

                // Validate tanggal lahir
                if (!tanggalLahirInput.value) {
                    isValid = false;
                    errorMessage = 'Tanggal lahir wajib diisi!';
                }

                if (!isValid) {
                    e.preventDefault();
                    alert(errorMessage);
                    return false;
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
                threshold: 0.5
            });

            formSections.forEach(section => {
                observer.observe(section);
            });

            // Auto-fill user data when user is selected
            userSelect.addEventListener('change', function() {
                if (this.value) {
                    // In real implementation, you might want to fetch user data via AJAX
                    // For now, we'll just clear the phone requirement
                    phoneInput.required = false;
                    phoneRequired.style.display = 'none';
                } else {
                    phoneInput.required = false;
                    phoneRequired.style.display = 'none';
                }
            });
        });
    </script>
@endpush
