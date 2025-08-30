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
        .input-group-umkm {
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

        /* Responsive */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            .input-group-umkm {
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
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.umkm.index') }}">Kelola
                            UMKM</a></li>
                    <li class="breadcrumb-item active">Tambah UMKM Baru</li>
                </ol>
            </nav>
            <h1 class="page-title">Tambah UMKM Baru</h1>
            <p class="page-subtitle">Lengkapi form di bawah untuk menambahkan data UMKM baru ke sistem.</p>
        </div>

        <div class="info-card">
            <div class="info-icon">
                <i class="bi bi-info-lg"></i>
            </div>
            <h6>Petunjuk Pengisian</h6>
            <p>
                Pastikan data yang dimasukkan sesuai dengan data UMKM yang valid.
                Nomor Induk Kependudukan (NIK) pemilik UMKM harus terdaftar sebagai penduduk desa.
                Semua field yang bertanda bintang (*) wajib diisi.
            </p>
        </div>

        <div class="form-progress">
            <div class="progress-step active">
                <div class="step-number">1</div>
                <span>Data Pemilik UMKM</span>
            </div>
            <div class="progress-step">
                <div class="step-number">2</div>
                <span>Detail Usaha & Produk</span>
            </div>
            <div class="progress-step">
                <div class="step-number">3</div>
                <span>Kontak & Media Sosial</span>
            </div>
        </div>

        <div class="form-container">
            <div class="form-header">
                <div class="form-icon">
                    <i class="bi bi-shop-window"></i>
                </div>
                <h2 class="form-title">Form Tambah UMKM</h2>
                <p class="form-subtitle">Masukkan data UMKM dengan lengkap dan benar</p>
            </div>

            <form action="{{ route('admin.umkm.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        Data Pemilik UMKM
                    </h4>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nik" class="form-label">
                                NIK Pemilik <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik"
                                name="nik" value="{{ old('nik') }}" placeholder="Masukkan 16 digit NIK"
                                maxlength="16" pattern="[0-9]{16}" required>
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        Detail Usaha & Produk
                    </h4>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_umkm" class="form-label">
                                Nama UMKM <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('nama_umkm') is-invalid @enderror"
                                id="nama_umkm" name="nama_umkm" value="{{ old('nama_umkm') }}"
                                placeholder="Nama Usaha atau Bisnis" required>
                            @error('nama_umkm')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="kategori" class="form-label">
                                Kategori <span class="required">*</span>
                            </label>
                            <select class="form-select @error('kategori') is-invalid @enderror" id="kategori"
                                name="kategori" required>
                                <option value="" disabled selected>Pilih Kategori
                                </option>
                                @foreach ($kategoriOptions as $value => $label)
                                    <option value="{{ $value }}" {{ old('kategori') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_produk" class="form-label">
                                Nama Produk/Jasa <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('nama_produk') is-invalid @enderror"
                                id="nama_produk" name="nama_produk" value="{{ old('nama_produk') }}"
                                placeholder="Contoh: Keripik Singkong Renyah" required>
                            @error('nama_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="foto_produk" class="form-label">
                                Foto Produk <span class="required">*</span>
                            </label>
                            <input type="file" class="form-control @error('foto_produk') is-invalid @enderror"
                                id="foto_produk" name="foto_produk" required>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Maksimal 2MB (jpg, jpeg, png, webp)
                            </div>
                            @error('foto_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="deskripsi_produk" class="form-label">
                                Deskripsi Produk/Jasa <span class="required">*</span>
                            </label>

                            <textarea class="form-control @error('deskripsi_produk') is-invalid @enderror"                                
                                id="deskripsi_produk" name="deskripsi_produk" rows="3"                                
                                placeholder="Jelaskan produk atau jasa Anda secara detail" required>{{ old('deskripsi_produk') }}</textarea>
                            @error('deskripsi_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-link-45deg"></i>
                        </div>
                        Kontak & Media Sosial
                    </h4>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nomor_telepon" class="form-label">
                                Nomor Telepon/WhatsApp <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('nomor_telepon') is-invalid @enderror"
                                id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon') }}"
                                placeholder="Contoh: 081234567890" required>
                            @error('nomor_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="link_facebook" class="form-label">
                                Link Facebook (opsional)
                            </label>
                            <input type="url" class="form-control @error('link_facebook') is-invalid @enderror"
                                id="link_facebook" name="link_facebook" value="{{ old('link_facebook') }}"
                                placeholder="Contoh: https://facebook.com/umkmkita">
                            @error('link_facebook')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="link_instagram" class="form-label">
                                Link Instagram (opsional)
                            </label>
                            <input type="url" class="form-control @error('link_instagram') is-invalid @enderror"
                                id="link_instagram" name="link_instagram" value="{{ old('link_instagram') }}"
                                placeholder="Contoh: https://instagram.com/umkmkita">
                            @error('link_instagram')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="link_tiktok" class="form-label">
                                Link TikTok (opsional)
                            </label>
                            <input type="url" class="form-control @error('link_tiktok') is-invalid @enderror"
                                id="link_tiktok" name="link_tiktok" value="{{ old('link_tiktok') }}"
                                placeholder="Contoh: https://tiktok.com/@umkmkita">
                            @error('link_tiktok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.umkm.index') }}" class="btn btn-outline-secondary">
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

            // Format nomor telepon (hanya angka dan simbol yang diizinkan)
            const teleponInput = document.getElementById('nomor_telepon');
            teleponInput.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/[^0-9+\-\s\(\)]/g, '');
            });

            // Form validation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const nik = document.getElementById('nik').value;
                const namaUmkm = document.getElementById('nama_umkm').value.trim();
                const namaProduk = document.getElementById('nama_produk').value.trim();
                const deskripsiProduk = document.getElementById('deskripsi_produk').value.trim();
                const telepon = document.getElementById('nomor_telepon').value.trim();
                const kategori = document.getElementById('kategori').value;

                if (nik.length !== 16) {
                    e.preventDefault();
                    alert('NIK harus 16 digit!');
                    return false;
                }

                if (namaUmkm.length < 3) {
                    e.preventDefault();
                    alert('Nama UMKM minimal 3 karakter!');
                    return false;
                }

                if (namaProduk.length < 3) {
                    e.preventDefault();
                    alert('Nama produk minimal 3 karakter!');
                    return false;
                }

                if (deskripsiProduk.length < 10) {
                    e.preventDefault();
                    alert('Deskripsi produk minimal 10 karakter!');
                    return false;
                }

                if (telepon.length < 10) {
                    e.preventDefault();
                    alert('Nomor telepon minimal 10 digit!');
                    return false;
                }

                if (kategori === '') {
                    e.preventDefault();
                    alert('Kategori wajib dipilih!');
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
