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
        .input-group-kk {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .input-group-address {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 15px;
        }

        .input-group-location {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
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

        /* Responsive */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            .input-group-kk,
            .input-group-address,
            .input-group-location {
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
                    <li class="breadcrumb-item"><a href="{{ route('kk.index') }}">Data Kartu Keluarga</a></li>
                    <li class="breadcrumb-item active">Tambah KK Baru</li>
                </ol>
            </nav>
            <h1 class="page-title">Tambah Kartu Keluarga Baru</h1>
            <p class="page-subtitle">Lengkapi form di bawah untuk menambahkan data kartu keluarga baru ke sistem</p>
        </div>

        <!-- Info Card -->
        <div class="info-card">
            <div class="info-icon">
                <i class="bi bi-info-lg"></i>
            </div>
            <h6>Petunjuk Pengisian</h6>
            <p>
                Pastikan data yang dimasukkan sesuai dengan dokumen kartu keluarga asli.
                Nomor KK harus 16 digit dan belum terdaftar dalam sistem.
                Semua field yang bertanda bintang (*) wajib diisi.
            </p>
        </div>

        <!-- Progress Steps -->
        <div class="form-progress">
            <div class="progress-step active">
                <div class="step-number">1</div>
                <span>Identitas KK</span>
            </div>
            <div class="progress-step">
                <div class="step-number">2</div>
                <span>Alamat Detail</span>
            </div>
            <div class="progress-step">
                <div class="step-number">3</div>
                <span>Konfirmasi</span>
            </div>
        </div>

        <!-- Main Form -->
        <div class="form-container">
            <div class="form-header">
                <div class="form-icon">
                    <i class="bi bi-house-door-fill"></i>
                </div>
                <h2 class="form-title">Form Tambah Kartu Keluarga</h2>
                <p class="form-subtitle">Masukkan data kartu keluarga dengan lengkap dan benar</p>
            </div>

            <form action="{{ route('kk.store') }}" method="POST" novalidate>
                @csrf

                <!-- Section 1: Identitas KK -->
                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-card-text"></i>
                        </div>
                        Identitas Kartu Keluarga
                    </h4>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="no_kk" class="form-label">
                                Nomor Kartu Keluarga <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('no_kk') is-invalid @enderror" id="no_kk"
                                name="no_kk" value="{{ old('no_kk') }}" placeholder="Masukkan 16 digit nomor KK"
                                maxlength="16" pattern="[0-9]{16}" required>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Nomor KK harus 16 digit angka sesuai dokumen resmi
                            </div>
                            @error('no_kk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Alamat Detail -->
                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        Detail Alamat
                    </h4>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="alamat" class="form-label">
                                Alamat Lengkap <span class="required">*</span>
                            </label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
                                placeholder="Contoh: Jl. Merdeka No. 123, Perumahan Sejahtera" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="input-group-kk">
                        <div class="mb-3">
                            <label for="rt" class="form-label">
                                RT <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('rt') is-invalid @enderror" id="rt"
                                name="rt" value="{{ old('rt') }}" placeholder="001" maxlength="3" required>
                            @error('rt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="rw" class="form-label">
                                RW <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('rw') is-invalid @enderror" id="rw"
                                name="rw" value="{{ old('rw') }}" placeholder="001" maxlength="3" required>
                            @error('rw')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 3: Wilayah Administratif -->
                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-signpost"></i>
                        </div>
                        Wilayah Administratif
                    </h4>

                    <div class="input-group-location">
                        <div class="mb-3">
                            <label for="desa" class="form-label">
                                Desa/Kelurahan <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('desa') is-invalid @enderror" id="desa"
                                name="desa" value="{{ old('desa') }}" placeholder="Nama Desa/Kelurahan" required>
                            @error('desa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kecamatan" class="form-label">
                                Kecamatan <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('kecamatan') is-invalid @enderror"
                                id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}"
                                placeholder="Nama Kecamatan" required>
                            @error('kecamatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kabupaten" class="form-label">
                                Kabupaten/Kota <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('kabupaten') is-invalid @enderror"
                                id="kabupaten" name="kabupaten" value="{{ old('kabupaten') }}"
                                placeholder="Nama Kabupaten/Kota" required>
                            @error('kabupaten')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="provinsi" class="form-label">
                                Provinsi <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('provinsi') is-invalid @enderror"
                                id="provinsi" name="provinsi" value="{{ old('provinsi') }}"
                                placeholder="Nama Provinsi" required>
                            @error('provinsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="kode_pos" class="form-label">
                                Kode Pos <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('kode_pos') is-invalid @enderror"
                                id="kode_pos" name="kode_pos" value="{{ old('kode_pos') }}" placeholder="12345"
                                maxlength="5" pattern="[0-9]{5}" required>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                5 digit kode pos sesuai wilayah
                            </div>
                            @error('kode_pos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('kk.index') }}" class="btn btn-outline-secondary">
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
            // Format nomor KK (hanya angka)
            const noKkInput = document.getElementById('no_kk');
            noKkInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');
            });

            // Format kode pos (hanya angka)
            const kodePosInput = document.getElementById('kode_pos');
            kodePosInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');
            });

            // Auto uppercase untuk wilayah
            const locationInputs = ['desa', 'kecamatan', 'kabupaten', 'provinsi'];
            locationInputs.forEach(inputId => {
                const input = document.getElementById(inputId);
                input.addEventListener('input', function(e) {
                    // Capitalize first letter of each word
                    e.target.value = e.target.value.toLowerCase().replace(/\b\w/g, l => l
                        .toUpperCase());
                });
            });

            // Form validation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const noKk = document.getElementById('no_kk').value;
                const kodePos = document.getElementById('kode_pos').value;

                if (noKk.length !== 16) {
                    e.preventDefault();
                    alert('Nomor KK harus 16 digit!');
                    return false;
                }

                if (kodePos.length !== 5) {
                    e.preventDefault();
                    alert('Kode pos harus 5 digit!');
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
        });
    </script>
@endpush
