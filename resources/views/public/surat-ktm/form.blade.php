@extends('template.main')

@section('content')
    <div class="hero-section"
        style="min-height: 40vh; background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 89, 0.8)), url('https://images.unsplash.com/photo-1450101499163-c8848c66ca85?ixlib=rb-4.0.3') center/cover no-repeat;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="hero-content text-center hero-animation">
                        <h1 class="display-5 fw-bold text-white mb-3">
                            <i class="bi bi-file-earmark-plus me-3"></i>
                            Pengajuan Surat KTM
                        </h1>
                        <p class="lead text-white mb-4">
                            Ajukan permohonan surat keterangan tidak mampu secara online
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <div class="feature-badge">
                                <i class="bi bi-clock me-2"></i>
                                Proses Cepat
                            </div>
                            <div class="feature-badge">
                                <i class="bi bi-shield-check me-2"></i>
                                Data Aman
                            </div>
                            <div class="feature-badge">
                                <i class="bi bi-phone me-2"></i>
                                Tracking Online
                            </div>
                        </div>
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

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show fade-in" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Terdapat kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Info Card -->
        <div class="row justify-content-center mb-4">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg fade-in">
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="mb-2 text-primary-green fw-bold">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Syarat dan Ketentuan
                                </h5>
                                <p class="mb-0 text-muted">
                                    Pastikan data yang Anda masukkan benar dan sesuai dengan dokumen resmi.
                                    Setelah pengajuan, Anda akan mendapat kode tracking untuk memantau status surat.
                                </p>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <div class="info-badge">
                                    <i class="bi bi-clock-history me-2"></i>
                                    Estimasi: 3-7 Hari
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Form -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <form action="{{ route('public.surat-ktm.store') }}" method="POST" id="suratForm">
                    @csrf

                    <!-- Data Pribadi -->
                    <div class="card border-0 shadow-lg mb-4 fade-in">
                        <div class="card-header bg-transparent border-0 p-4">
                            <h5 class="mb-0 text-primary-green fw-bold">
                                <i class="bi bi-person-fill me-2"></i>
                                Data Pribadi
                            </h5>
                            <p class="text-muted mb-0 mt-2">Lengkapi data pribadi sesuai dengan KTP/dokumen resmi</p>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nama" class="form-label">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        id="nama" name="nama" value="{{ old('nama') }}"
                                        placeholder="Masukkan nama lengkap sesuai KTP" required>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Sesuai dengan Kartu Tanda Penduduk (KTP)
                                    </div>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="tempat_lahir" class="form-label">
                                        Tempat Lahir <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                        id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                        placeholder="Contoh: Jakarta" required>
                                    @error('tempat_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="tanggal_lahir" class="form-label">
                                        Tanggal Lahir <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                        id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="jenis_kelamin" class="form-label">
                                        Jenis Kelamin <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                        id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki"
                                            {{ old('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="Perempuan"
                                            {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="status_kawin" class="form-label">
                                        Status Pernikahan <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('status_kawin') is-invalid @enderror"
                                        id="status_kawin" name="status_kawin" required>
                                        <option value="">Pilih Status Pernikahan</option>
                                        <option value="Belum Kawin"
                                            {{ old('status_kawin') === 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin
                                        </option>
                                        <option value="Kawin" {{ old('status_kawin') === 'Kawin' ? 'selected' : '' }}>
                                            Kawin</option>
                                        <option value="Cerai Hidup"
                                            {{ old('status_kawin') === 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup
                                        </option>
                                        <option value="Cerai Mati"
                                            {{ old('status_kawin') === 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati
                                        </option>
                                    </select>
                                    @error('status_kawin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="kewarganegaraan" class="form-label">
                                        Kewarganegaraan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control @error('kewarganegaraan') is-invalid @enderror"
                                        id="kewarganegaraan" name="kewarganegaraan"
                                        value="{{ old('kewarganegaraan', 'Indonesia') }}" placeholder="Indonesia"
                                        required>
                                    @error('kewarganegaraan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kontak & Alamat -->
                    <div class="card border-0 shadow-lg mb-4 fade-in">
                        <div class="card-header bg-transparent border-0 p-4">
                            <h5 class="mb-0 text-primary-green fw-bold">
                                <i class="bi bi-geo-alt-fill me-2"></i>
                                Kontak & Alamat
                            </h5>
                            <p class="text-muted mb-0 mt-2">Informasi kontak dan alamat domisili saat ini</p>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nomor_telepon" class="form-label">
                                        Nomor Telepon <span class="text-danger">*</span>
                                    </label>
                                    <input type="tel"
                                        class="form-control @error('nomor_telepon') is-invalid @enderror"
                                        id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon') }}"
                                        placeholder="Contoh: 08123456789" required>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Nomor yang aktif untuk dihubungi
                                    </div>
                                    @error('nomor_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="alamat" class="form-label">
                                        Alamat Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="4"
                                        placeholder="Masukkan alamat lengkap sesuai domisili saat ini (RT/RW, Kelurahan/Desa, Kecamatan, Kota/Kabupaten)"
                                        required>{{ old('alamat') }}</textarea>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Alamat domisili lengkap dengan RT/RW
                                    </div>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Persetujuan -->
                    <div class="card border-0 shadow-lg mb-4 fade-in">
                        <div class="card-body p-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="persetujuan" required>
                                <label class="form-check-label" for="persetujuan">
                                    Saya menyatakan bahwa data yang saya masukkan adalah <strong>benar dan sesuai</strong>
                                    dengan dokumen resmi yang saya miliki. Saya memahami bahwa memberikan informasi yang
                                    salah dapat berakibat pada penolakan permohonan surat.
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="card border-0 shadow-lg mb-4 fade-in">
                        <div class="card-body p-4 text-center">
                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                <a href="{{ route('public.surat-ktm.index') }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Kembali
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                    <i class="bi bi-send-fill me-2"></i>
                                    Ajukan Permohonan
                                </button>
                            </div>
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="bi bi-shield-check me-1"></i>
                                    Data Anda akan diproses dengan aman dan terjaga kerahasiaannya
                                </small>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Help Section -->
        <div class="row justify-content-center mt-5">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg fade-in"
                    style="background: linear-gradient(135deg, var(--cream), var(--warm-white));">
                    <div class="card-body p-4 text-center">
                        <h5 class="mb-3 text-primary-green fw-bold">
                            <i class="bi bi-question-circle me-2"></i>
                            Butuh Bantuan?
                        </h5>
                        <p class="text-muted mb-3">
                            Jika Anda mengalami kesulitan dalam pengisian form atau membutuhkan informasi lebih lanjut,
                            silakan hubungi kantor desa.
                        </p>
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <div class="contact-item">
                                <i class="bi bi-telephone-fill text-primary-green me-2"></i>
                                <strong>Telepon:</strong> (021) 123-4567
                            </div>
                            <div class="contact-item">
                                <i class="bi bi-envelope-fill text-primary-green me-2"></i>
                                <strong>Email:</strong> info@desakilwaru.id
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Feature Badges */
        .feature-badge {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Info Badge */
        .info-badge {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            color: white;
            padding: 8px 16px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-block;
        }

        /* Form Enhancements */
        .form-control,
        .form-select {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent-orange);
            box-shadow: 0 0 0 0.2rem rgba(255, 140, 66, 0.25);
            transform: translateY(-2px);
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 8px;
        }

        .form-text {
            color: var(--soft-gray);
            font-size: 0.85rem;
            margin-top: 5px;
        }

        /* Card Enhancements */
        .card-header {
            background: linear-gradient(135deg, rgba(45, 80, 22, 0.05), rgba(74, 124, 89, 0.05)) !important;
        }

        /* Submit Button Loading State */
        .btn.loading {
            position: relative;
            color: transparent !important;
        }

        .btn.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            width: 20px;
            height: 20px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Form Check */
        .form-check-input {
            width: 1.25em;
            height: 1.25em;
            border: 2px solid var(--primary-green);
        }

        .form-check-input:checked {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .form-check-label {
            padding-left: 10px;
            line-height: 1.6;
        }

        /* Contact Items */
        .contact-item {
            color: var(--soft-gray);
            font-size: 0.95rem;
        }

        /* Required Indicator */
        .text-danger {
            color: #e74c3c !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section .display-5 {
                font-size: 1.8rem;
            }

            .feature-badge {
                font-size: 0.8rem;
                padding: 6px 12px;
            }

            .form-control,
            .form-select {
                font-size: 0.95rem;
                padding: 10px 14px;
            }

            .contact-item {
                font-size: 0.9rem;
                margin-bottom: 10px;
            }
        }

        /* Dark theme support */
        [data-theme="dark"] .form-label {
            color: var(--light-green);
        }

        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('suratForm');
            const submitBtn = document.getElementById('submitBtn');
            const persetujuanCheckbox = document.getElementById('persetujuan');

            // Enable/disable submit button based on checkbox
            persetujuanCheckbox.addEventListener('change', function() {
                submitBtn.disabled = !this.checked;
                if (this.checked) {
                    submitBtn.classList.remove('btn-outline-primary');
                    submitBtn.classList.add('btn-primary');
                } else {
                    submitBtn.classList.remove('btn-primary');
                    submitBtn.classList.add('btn-outline-primary');
                }
            });

            // Initial state
            submitBtn.disabled = true;
            submitBtn.classList.add('btn-outline-primary');

            // Form submission
            form.addEventListener('submit', function(e) {
                submitBtn.disabled = true;
                submitBtn.classList.add('loading');
                submitBtn.innerHTML = '<span>Memproses...</span>';
            });

            // Input animations
            document.querySelectorAll('.form-control, .form-select').forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });

            // Auto format phone number
            const phoneInput = document.getElementById('nomor_telepon');
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.startsWith('0')) {
                    value = value;
                } else if (value.startsWith('62')) {
                    value = '0' + value.substring(2);
                }
                e.target.value = value;
            });

            // Auto capitalize nama
            const namaInput = document.getElementById('nama');
            namaInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\b\w/g, l => l.toUpperCase());
            });

            // Auto capitalize tempat lahir
            const tempatLahirInput = document.getElementById('tempat_lahir');
            tempatLahirInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\b\w/g, l => l.toUpperCase());
            });
        });
    </script>
@endsection
