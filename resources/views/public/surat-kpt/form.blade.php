@extends('template.main')

@section('title', 'Surat Keterangan Pengantar - ' . config('app.village_name', 'Desa Kilwaru'))
@section('description', 'Layanan pengajuan Surat Keterangan Pengantar online untuk warga ' . config('app.village_name',
    'Desa Kilwaru'))

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
                .skpt-hero {
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
        style="min-height: 40vh; background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 89, 0.8)), url('https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?ixlib=rb-4.0.3') center/cover no-repeat;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="hero-content text-center hero-animation">
                        <h1 class="display-5 fw-bold text-white mb-3">
                            <i class="bi bi-file-earmark-arrow-up me-3"></i>
                            Pengajuan Surat Keterangan Pengantar
                        </h1>
                        <p class="lead text-white mb-4">
                            Ajukan permohonan surat keterangan pengantar secara online
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
                <form action="{{ route('public.surat-kpt.store') }}" method="POST" id="suratForm">
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
                                    <label for="nama_yang_bersangkutan" class="form-label">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control @error('nama_yang_bersangkutan') is-invalid @enderror"
                                        id="nama_yang_bersangkutan" name="nama_yang_bersangkutan"
                                        value="{{ old('nama_yang_bersangkutan') }}"
                                        placeholder="Masukkan nama lengkap sesuai KTP" required>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Sesuai dengan Kartu Tanda Penduduk (KTP)
                                    </div>
                                    @error('nama_yang_bersangkutan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="nik" class="form-label">
                                        NIK (Nomor Induk Kependudukan) <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                        id="nik" name="nik" value="{{ old('nik') }}"
                                        placeholder="Masukkan 16 digit NIK" maxlength="16" required>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        16 digit sesuai KTP
                                    </div>
                                    @error('nik')
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
                                    <input type="date"
                                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                        id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                        required>
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
                                    <label for="agama" class="form-label">
                                        Agama <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('agama') is-invalid @enderror" id="agama"
                                        name="agama" required>
                                        <option value="">Pilih Agama</option>
                                        <option value="Islam" {{ old('agama') === 'Islam' ? 'selected' : '' }}>Islam
                                        </option>
                                        <option value="Kristen Protestan"
                                            {{ old('agama') === 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan
                                        </option>
                                        <option value="Kristen Katolik"
                                            {{ old('agama') === 'Kristen Katolik' ? 'selected' : '' }}>Kristen Katolik
                                        </option>
                                        <option value="Hindu" {{ old('agama') === 'Hindu' ? 'selected' : '' }}>Hindu
                                        </option>
                                        <option value="Buddha" {{ old('agama') === 'Buddha' ? 'selected' : '' }}>Buddha
                                        </option>
                                        <option value="Konghucu" {{ old('agama') === 'Konghucu' ? 'selected' : '' }}>
                                            Konghucu</option>
                                    </select>
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

                                <div class="col-12">
                                    <label for="alamat_yang_bersangkutan" class="form-label">
                                        Alamat Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('alamat_yang_bersangkutan') is-invalid @enderror" id="alamat_yang_bersangkutan"
                                        name="alamat_yang_bersangkutan" rows="4"
                                        placeholder="Masukkan alamat lengkap sesuai domisili saat ini (RT/RW, Kelurahan/Desa, Kecamatan, Kota/Kabupaten)"
                                        required>{{ old('alamat_yang_bersangkutan') }}</textarea>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Alamat domisili lengkap dengan RT/RW
                                    </div>
                                    @error('alamat_yang_bersangkutan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                            <p class="text-muted mb-0 mt-2">Lengkapi data orang tua sesuai dokumen resmi</p>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nama_ayah" class="form-label">
                                        Nama Ayah <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror"
                                        id="nama_ayah" name="nama_ayah" value="{{ old('nama_ayah') }}"
                                        placeholder="Masukkan nama ayah" required>
                                    @error('nama_ayah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="nama_ibu" class="form-label">
                                        Nama Ibu <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror"
                                        id="nama_ibu" name="nama_ibu" value="{{ old('nama_ibu') }}"
                                        placeholder="Masukkan nama ibu" required>
                                    @error('nama_ibu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="pekerjaan_orang_tua" class="form-label">
                                        Pekerjaan Orang Tua <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control @error('pekerjaan_orang_tua') is-invalid @enderror"
                                        id="pekerjaan_orang_tua" name="pekerjaan_orang_tua"
                                        value="{{ old('pekerjaan_orang_tua') }}" placeholder="Contoh: Petani / Pedagang"
                                        required>
                                    @error('pekerjaan_orang_tua')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="penghasilan_per_bulan" class="form-label">
                                        Penghasilan Per Bulan <span class="text-danger">*</span>
                                    </label>
                                    <input type="number"
                                        class="form-control @error('penghasilan_per_bulan') is-invalid @enderror"
                                        id="penghasilan_per_bulan" name="penghasilan_per_bulan"
                                        value="{{ old('penghasilan_per_bulan') }}"
                                        placeholder="Masukkan penghasilan dalam rupiah" min="0" required>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Masukkan dalam rupiah tanpa tanda titik atau koma
                                    </div>
                                    @error('penghasilan_per_bulan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                            <p class="text-muted mb-0 mt-2">Informasi keperluan dan kontak</p>
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

                                <div class="col-md-6">
                                    <label for="tanggal_surat" class="form-label">
                                        Tanggal Surat <span class="text-danger">*</span>
                                    </label>
                                    <input type="date"
                                        class="form-control @error('tanggal_surat') is-invalid @enderror"
                                        id="tanggal_surat" name="tanggal_surat"
                                        value="{{ old('tanggal_surat', date('Y-m-d')) }}" required>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Tanggal pembuatan surat
                                    </div>
                                    @error('tanggal_surat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="keperluan" class="form-label">
                                        Keperluan <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('keperluan') is-invalid @enderror" id="keperluan" name="keperluan"
                                        rows="4" placeholder="Jelaskan keperluan pembuatan surat ini" required>{{ old('keperluan') }}</textarea>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Jelaskan secara lengkap untuk keperluan apa surat ini dibuat
                                    </div>
                                    @error('keperluan')
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
                                <a href="{{ route('public.surat-kpt.index') }}" class="btn btn-outline-secondary btn-lg">
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
            const namaInputs = [
                document.getElementById('nama_yang_bersangkutan'),
                document.getElementById('nama_ayah'),
                document.getElementById('nama_ibu'),
                document.getElementById('tempat_lahir')
            ];

            namaInputs.forEach(input => {
                if (input) {
                    input.addEventListener('input', function(e) {
                        e.target.value = e.target.value.replace(/\b\w/g, l => l.toUpperCase());
                    });
                }
            });

            // NIK validation
            const nikInput = document.getElementById('nik');
            nikInput.addEventListener('input', function(e) {
                // Only allow numbers
                e.target.value = e.target.value.replace(/\D/g, '');

                // Limit to 16 characters
                if (e.target.value.length > 16) {
                    e.target.value = e.target.value.slice(0, 16);
                }
            });

            // Format currency for penghasilan
            const penghasilanInput = document.getElementById('penghasilan_per_bulan');
            penghasilanInput.addEventListener('input', function(e) {
                // Remove non-numeric characters
                let value = e.target.value.replace(/\D/g, '');

                // Format with thousand separator for display
                if (value) {
                    const formatted = new Intl.NumberFormat('id-ID').format(value);
                    // Store the original number in a data attribute for form submission
                    e.target.setAttribute('data-raw-value', value);
                    // Display formatted value
                    e.target.value = formatted;
                } else {
                    e.target.removeAttribute('data-raw-value');
                }
            });

            // Before form submission, ensure raw values are used
            form.addEventListener('submit', function(e) {
                const penghasilanInput = document.getElementById('penghasilan_per_bulan');
                const rawValue = penghasilanInput.getAttribute('data-raw-value');
                if (rawValue) {
                    penghasilanInput.value = rawValue;
                }
            });

            // Date validation - ensure tanggal_lahir is not in the future
            const tanggalLahirInput = document.getElementById('tanggal_lahir');
            const today = new Date().toISOString().split('T')[0];
            tanggalLahirInput.setAttribute('max', today);

            // Set default tanggal_surat to today if empty
            const tanggalSuratInput = document.getElementById('tanggal_surat');
            if (!tanggalSuratInput.value) {
                tanggalSuratInput.value = today;
            }
        });
    </script>
@endpush
