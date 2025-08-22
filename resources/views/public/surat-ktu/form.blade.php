@extends('template.main')

@section('title', 'Surat Keterangan Usaha - ' . config('app.village_name', 'Desa Kilwaru'))
@section('description', 'Layanan pengajuan Surat Keterangan Usaha online untuk warga ' . config('app.village_name',
    'Desa Kilwaru'))

    @push('styles')
        <style>
            /* CSS Disesuaikan dari Surat KTM ke Surat KTU */
            .sktu-hero {
                background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 89, 0.8)),
                    url('https://images.unsplash.com/photo-1450101499163-c8848c66ca85?ixlib=rb-4.0.3') center/cover;
                color: white;
                padding: 100px 0 50px;
                margin-top: -80px;
                padding-top: 160px;
            }

            .service-card {
                background: white;
                border-radius: 20px;
                padding: 40px 30px;
                text-align: center;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
                height: 100%;
                border: none;
            }

            .service-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            }

            .service-icon {
                width: 80px;
                height: 80px;
                background: linear-gradient(135deg, var(--accent-orange), #ff6b1a);
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2rem;
                margin: 0 auto 25px;
                transition: all 0.3s ease;
            }

            .service-card:hover .service-icon {
                transform: scale(1.1) rotate(5deg);
            }

            .btn-service {
                background: var(--primary-green);
                border: none;
                border-radius: 50px;
                padding: 15px 35px;
                font-weight: 600;
                font-size: 1.1rem;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(45, 80, 22, 0.3);
                width: 100%;
                margin-top: 20px;
            }

            .btn-service:hover {
                background: var(--secondary-green);
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(45, 80, 22, 0.4);
            }

            .btn-track {
                background: var(--accent-orange);
                border: none;
                border-radius: 50px;
                padding: 15px 35px;
                font-weight: 600;
                font-size: 1.1rem;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(255, 140, 66, 0.3);
                width: 100%;
                margin-top: 20px;
            }

            .btn-track:hover {
                background: #e07a35;
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(255, 140, 66, 0.4);
            }

            .track-form {
                background: white;
                border-radius: 20px;
                padding: 30px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                max-width: 500px;
                margin: 30px auto 0;
            }

            .track-input {
                border: 2px solid #e0e0e0;
                border-radius: 15px;
                padding: 15px 20px;
                font-size: 16px;
                transition: all 0.3s ease;
                margin-bottom: 20px;
            }

            .track-input:focus {
                border-color: var(--accent-orange);
                box-shadow: 0 0 0 0.2rem rgba(255, 140, 66, 0.25);
            }

            .info-section {
                background: var(--cream);
                padding: 80px 0;
            }

            .info-card {
                background: white;
                border-radius: 15px;
                padding: 30px;
                text-align: center;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
                margin-bottom: 30px;
                transition: all 0.3s ease;
            }

            .info-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
            }

            .info-icon {
                width: 60px;
                height: 60px;
                background: var(--light-green);
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                margin: 0 auto 20px;
            }

            .step-number {
                width: 50px;
                height: 50px;
                background: var(--accent-orange);
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                font-size: 1.2rem;
                margin: 0 auto 15px;
            }

            .requirements-list {
                list-style: none;
                padding: 0;
            }

            .requirements-list li {
                padding: 10px 0;
                border-bottom: 1px solid #f0f0f0;
                position: relative;
                padding-left: 30px;
            }

            .requirements-list li:before {
                content: '✓';
                position: absolute;
                left: 0;
                color: var(--primary-green);
                font-weight: bold;
            }

            .requirements-list li:last-child {
                border-bottom: none;
            }

            .modal-content {
                border-radius: 20px;
                border: none;
            }

            .modal-header {
                background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
                color: white;
                border-radius: 20px 20px 0 0;
            }

            .stats-counter {
                text-align: center;
                padding: 20px;
            }

            .stat-number {
                font-size: 2.5rem;
                font-weight: 700;
                color: var(--primary-green);
                display: block;
            }

            .stat-label {
                color: var(--soft-gray);
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 1px;
                font-size: 0.9rem;
            }

            @media (max-width: 768px) {
                .sktu-hero {
                    padding: 80px 0 40px;
                    padding-top: 140px;
                }

                .service-card {
                    padding: 30px 20px;
                    margin-bottom: 20px;
                }

                .track-form {
                    margin: 20px 15px 0;
                    padding: 25px 20px;
                }

                .info-section {
                    padding: 60px 0;
                }

                .btn-service,
                .btn-track {
                    padding: 12px 25px;
                    font-size: 1rem;
                }
            }
        </style>
    @endpush

@section('content')
    <section class="hero-section"
        style="min-height: 40vh; background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 89, 0.8)), url('https://images.unsplash.com/photo-1450101499163-c8848c66ca85?ixlib=rb-4.0.3') center/cover no-repeat;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="hero-content text-center hero-animation">
                        <h1 class="display-5 fw-bold text-white mb-3">
                            <i class="bi bi-file-earmark-plus me-3"></i>
                            Pengajuan Surat Keterangan Usaha
                        </h1>
                        <p class="lead text-white mb-4">
                            Ajukan permohonan surat keterangan usaha secara online
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
    </section>

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

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <form action="{{ route('public.surat-ktu.store') }}" method="POST" id="suratForm">
                    @csrf

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

                                <div class="col-md-6">
                                    <label for="agama" class="form-label">
                                        Agama <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('agama') is-invalid @enderror"
                                        id="agama" name="agama" value="{{ old('agama') }}"
                                        placeholder="Contoh: Islam" required>
                                    @error('agama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="pekerjaan" class="form-label">
                                        Pekerjaan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror"
                                        id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}"
                                        placeholder="Contoh: Wiraswasta" required>
                                    @error('pekerjaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-lg mb-4 fade-in">
                        <div class="card-header bg-transparent border-0 p-4">
                            <h5 class="mb-0 text-primary-green fw-bold">
                                <i class="bi bi-shop me-2"></i>
                                Data Usaha
                            </h5>
                            <p class="text-muted mb-0 mt-2">Lengkapi data usaha Anda dengan benar</p>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nama_usaha" class="form-label">
                                        Nama Usaha <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('nama_usaha') is-invalid @enderror"
                                        id="nama_usaha" name="nama_usaha" value="{{ old('nama_usaha') }}"
                                        placeholder="Masukkan nama usaha" required>
                                    @error('nama_usaha')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="jenis_usaha" class="form-label">
                                        Jenis Usaha <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('jenis_usaha') is-invalid @enderror"
                                        id="jenis_usaha" name="jenis_usaha" value="{{ old('jenis_usaha') }}"
                                        placeholder="Contoh: Warung Sembako" required>
                                    @error('jenis_usaha')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="pemilik_usaha" class="form-label">
                                        Nama Pemilik Usaha <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control @error('pemilik_usaha') is-invalid @enderror"
                                        id="pemilik_usaha" name="pemilik_usaha" value="{{ old('pemilik_usaha') }}"
                                        placeholder="Nama pemilik usaha" required>
                                    @error('pemilik_usaha')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="alamat_usaha" class="form-label">
                                        Alamat Usaha <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('alamat_usaha') is-invalid @enderror" id="alamat_usaha" name="alamat_usaha"
                                        rows="3" placeholder="Alamat lengkap lokasi usaha" required>{{ old('alamat_usaha') }}</textarea>
                                    @error('alamat_usaha')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

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

                    <div class="card border-0 shadow-lg mb-4 fade-in">
                        <div class="card-body p-4 text-center">
                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                <a href="{{ route('public.surat-ktu.index') }}" class="btn btn-outline-secondary btn-lg">
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
@endsection

@push('scripts')
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
@endpush
