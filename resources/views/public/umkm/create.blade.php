@extends('template.main')

@section('title', 'Daftar UMKM Baru - ' . config('app.village_name', 'Desa Kilwaru'))
@section('description',
    'Formulir pendaftaran UMKM online untuk warga ' .
    config('app.village_name', 'Desa Kilwaru') .
    '
    agar dapat mempromosikan usahanya.')

    @push('styles')
        <style>
            /* Gaya Konsisten dengan Halaman Surat KTU */
            .umkm-hero {
                background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 89, 0.8)),
                    url('https://images.unsplash.com/photo-1556761175-5973dc0f32e7?ixlib=rb-4.0.3') center/cover;
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

            .form-control,
            .form-select,
            .input-group-text {
                border-radius: 15px;
                padding: 12px 20px;
            }

            .form-label {
                font-weight: 600;
                color: var(--primary-green);
            }
        </style>
    @endpush

@section('content')
    <section class="umkm-hero" id="umkmHero">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="hero-content text-center hero-animation">
                        <h1 class="display-5 fw-bold text-white mb-3">
                            <i class="bi bi-shop me-3"></i>
                            Pendaftaran UMKM Desa
                        </h1>
                        <p class="lead text-white mb-4">
                            Daftarkan usaha Anda dan jadilah bagian dari ekosistem bisnis desa kami!
                        </p>
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <div class="feature-badge">
                                <i class="bi bi-speedometer2 me-2"></i>
                                Proses Cepat
                            </div>
                            <div class="feature-badge">
                                <i class="bi bi-check-circle me-2"></i>
                                Gratis
                            </div>
                            <div class="feature-badge">
                                <i class="bi bi-megaphone me-2"></i>
                                Promosi Luas
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <form action="{{ route('umkm.store') }}" method="POST" id="umkmForm" enctype="multipart/form-data">
                    @csrf

                    <div class="card border-0 shadow-lg mb-4 fade-in">
                        <div class="card-header bg-transparent border-0 p-4">
                            <h5 class="mb-0 text-primary-green fw-bold">
                                <i class="bi bi-person-fill me-2"></i>
                                Data Pemilik UMKM
                            </h5>
                            <p class="text-muted mb-0 mt-2">Lengkapi data pribadi pemilik UMKM sesuai KTP</p>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nik" class="form-label">
                                        Nomor Induk Kependudukan (NIK) <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                        id="nik" name="nik" value="{{ old('nik') }}"
                                        placeholder="Masukkan 16 digit NIK" required pattern="[0-9]{16}"
                                        title="NIK harus terdiri dari 16 digit angka.">
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        NIK harus terdaftar sebagai warga desa.
                                    </div>
                                    @error('nik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="nama_lengkap" class="form-label">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" value="{{ old('nama_lengkap') }}"
                                        placeholder="Akan terisi otomatis setelah NIK valid" readonly disabled>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Nama akan terisi otomatis berdasarkan NIK.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-lg mb-4 fade-in">
                        <div class="card-header bg-transparent border-0 p-4">
                            <h5 class="mb-0 text-primary-green fw-bold">
                                <i class="bi bi-shop-fill me-2"></i>
                                Informasi Usaha
                            </h5>
                            <p class="text-muted mb-0 mt-2">Masukkan detail tentang usaha Anda</p>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nama_umkm" class="form-label">
                                        Nama UMKM <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('nama_umkm') is-invalid @enderror"
                                        id="nama_umkm" name="nama_umkm" value="{{ old('nama_umkm') }}"
                                        placeholder="Contoh: Toko Berkah" required>
                                    @error('nama_umkm')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="kategori" class="form-label">
                                        Kategori Usaha <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('kategori') is-invalid @enderror" id="kategori"
                                        name="kategori" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($kategoriOptions as $key => $value)
                                            <option value="{{ $key }}"
                                                {{ old('kategori') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="nama_produk" class="form-label">
                                        Nama Produk / Jasa <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control @error('nama_produk') is-invalid @enderror"
                                        id="nama_produk" name="nama_produk" value="{{ old('nama_produk') }}"
                                        placeholder="Contoh: Kue Kering Lebaran, Jasa Jahit Baju" required>
                                    @error('nama_produk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label for="deskripsi_produk" class="form-label">
                                        Deskripsi Produk / Jasa <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('deskripsi_produk') is-invalid @enderror" id="deskripsi_produk"
                                        name="deskripsi_produk" rows="4" required>{{ old('deskripsi_produk') }}</textarea>
                                    @error('deskripsi_produk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-lg mb-4 fade-in">
                        <div class="card-header bg-transparent border-0 p-4">
                            <h5 class="mb-0 text-primary-green fw-bold">
                                <i class="bi bi-camera me-2"></i>
                                Media & Kontak
                            </h5>
                            <p class="text-muted mb-0 mt-2">Tambahkan foto produk dan info kontak</p>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="foto_produk" class="form-label">
                                        Foto Produk (Opsional)
                                    </label>
                                    <input class="form-control @error('foto_produk') is-invalid @enderror" type="file"
                                        id="foto_produk" name="foto_produk" accept="image/*">
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Maksimal 2MB. Format: JPG, JPEG, PNG, WebP.
                                    </div>
                                    @error('foto_produk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="mt-3">
                                        <img id="image-preview" src="#" alt="Pratinjau Foto"
                                            style="display: none; max-width: 100%; height: auto; border-radius: 8px;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="nomor_telepon" class="form-label">
                                        Nomor Telepon / WhatsApp <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-whatsapp"></i></span>
                                        <input type="tel"
                                            class="form-control @error('nomor_telepon') is-invalid @enderror"
                                            id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon') }}"
                                            placeholder="Contoh: 08123456789" required>
                                        @error('nomor_telepon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="link_facebook" class="form-label">
                                        Link Facebook (Opsional)
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-facebook"></i></span>
                                        <input type="url"
                                            class="form-control @error('link_facebook') is-invalid @enderror"
                                            id="link_facebook" name="link_facebook" value="{{ old('link_facebook') }}"
                                            placeholder="https://facebook.com/nama-anda">
                                        @error('link_facebook')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="link_instagram" class="form-label">
                                        Link Instagram (Opsional)
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-instagram"></i></span>
                                        <input type="url"
                                            class="form-control @error('link_instagram') is-invalid @enderror"
                                            id="link_instagram" name="link_instagram"
                                            value="{{ old('link_instagram') }}"
                                            placeholder="https://instagram.com/nama-anda">
                                        @error('link_instagram')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="link_tiktok" class="form-label">
                                        Link TikTok (Opsional)
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-tiktok"></i></span>
                                        <input type="url"
                                            class="form-control @error('link_tiktok') is-invalid @enderror"
                                            id="link_tiktok" name="link_tiktok" value="{{ old('link_tiktok') }}"
                                            placeholder="https://tiktok.com/@nama-anda">
                                        @error('link_tiktok')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-lg mb-4 fade-in">
                        <div class="card-body p-4 text-center">
                            <div class="form-check text-start mb-3">
                                <input class="form-check-input" type="checkbox" id="persetujuan" required>
                                <label class="form-check-label" for="persetujuan">
                                    Saya menyatakan bahwa data yang saya masukkan adalah <strong>benar dan sesuai</strong>
                                    dengan kondisi
                                    sebenarnya. Saya memahami bahwa data ini akan dipublikasikan.
                                </label>
                            </div>

                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                <a href="{{ route('umkm.index') }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="bi bi-arrow-left me-2"></i>Kembali
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg" id="submitBtn" disabled>
                                    <i class="bi bi-send-fill me-2"></i>Ajukan Pendaftaran
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('umkmForm');
            const submitBtn = document.getElementById('submitBtn');
            const persetujuanCheckbox = document.getElementById('persetujuan');
            const nikInput = document.getElementById('nik');
            const namaLengkapInput = document.querySelector('input[name="nama_lengkap"]');
            const fotoProdukInput = document.getElementById('foto_produk');
            const imagePreview = document.getElementById('image-preview');

            // Fungsi untuk mengaktifkan/menonaktifkan tombol submit
            function toggleSubmitButton() {
                submitBtn.disabled = !persetujuanCheckbox.checked;
            }

            // Awalnya tombol submit dinonaktifkan
            toggleSubmitButton();

            // Event listener untuk checkbox persetujuan
            persetujuanCheckbox.addEventListener('change', toggleSubmitButton);

            // Pratinjau gambar saat file dipilih
            fotoProdukInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    imagePreview.src = '#';
                    imagePreview.style.display = 'none';
                }
            });

            // Mengubah style tombol saat dicentang
            persetujuanCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    submitBtn.classList.remove('btn-outline-secondary');
                    submitBtn.classList.add('btn-primary');
                } else {
                    submitBtn.classList.remove('btn-primary');
                    submitBtn.classList.add('btn-outline-secondary');
                }
            });

            // Logika validasi NIK dan auto-fill nama
            let nikValidationTimeout;
            nikInput.addEventListener('input', function() {
                clearTimeout(nikValidationTimeout);
                const nik = this.value;
                if (nik.length === 16 && /^\d{16}$/.test(nik)) {
                    nikValidationTimeout = setTimeout(() => {
                        // Di sini Anda bisa menambahkan AJAX call ke endpoint
                        // untuk validasi NIK dan mengambil data nama.
                        // Karena kita tidak memiliki endpoint, ini hanya contoh statis.

                        // Contoh: Pura-pura validasi berhasil dan mengisi nama
                        console.log('NIK valid, mencari data...');
                        // const dummyName = 'Nama Warga Sesuai NIK';
                        // namaLengkapInput.value = dummyName;
                        // namaLengkapInput.disabled = false;
                    }, 500); // Debounce
                } else {
                    namaLengkapInput.value = '';
                }
            });

            // Form submission
            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span>Memproses...</span>
                `;
            });
        });
    </script>
@endpush
