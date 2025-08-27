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

        .img-preview {
            max-width: 150px;
            max-height: 150px;
            margin-top: 10px;
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
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
                    <li class="breadcrumb-item active">Edit UMKM</li>
                </ol>
            </nav>
            <h1 class="page-title">{{ $titleHeader }}</h1>
            <p class="page-subtitle">Ubah data UMKM dengan lengkap dan benar.</p>
        </div>

        <div class="form-container">
            <div class="form-header">
                <div class="form-icon">
                    <i class="bi bi-shop-window"></i>
                </div>
                <h2 class="form-title">Form Edit UMKM</h2>
                <p class="form-subtitle">Ubah detail UMKM: {{ $umkm->nama_umkm }}</p>
            </div>

            <form action="{{ route('admin.umkm.update', $umkm->id) }}" method="POST" enctype="multipart/form-data"
                novalidate>
                @csrf
                @method('PUT')

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
                                name="nik" value="{{ old('nik', $umkm->nik) }}" placeholder="Masukkan 16 digit NIK"
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
                                id="nama_umkm" name="nama_umkm" value="{{ old('nama_umkm', $umkm->nama_umkm) }}"
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
                                <option value="" disabled>Pilih Kategori</option>
                                @foreach ($kategoriOptions as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('kategori', $umkm->kategori) == $value ? 'selected' : '' }}>
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
                                id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $umkm->nama_produk) }}"
                                placeholder="Contoh: Keripik Singkong Renyah" required>
                            @error('nama_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="foto_produk" class="form-label">
                                Ganti Foto Produk
                            </label>
                            <input type="file" class="form-control @error('foto_produk') is-invalid @enderror"
                                id="foto_produk" name="foto_produk">
                            <div class="form-text">
                                Biarkan kosong jika tidak ingin mengubah foto. Maksimal 2MB
                                (jpg, jpeg, png, webp).
                            </div>
                            @error('foto_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($umkm->foto_produk)
                                <img src="{{ asset('storage/umkm-photos/' . $umkm->foto_produk) }}"
                                    alt="Foto Produk Saat Ini" class="img-preview">
                            @endif

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="deskripsi_produk" class="form-label">
                                Deskripsi Produk/Jasa <span class="required">*</span>
                            </label>

                            <textarea class="form-control @error('deskripsi_produk') is-invalid @enderror"                                
                                id="deskripsi_produk" name="deskripsi_produk" rows="3"                                
                                placeholder="Jelaskan produk atau jasa Anda secara detail"                                 required>{{ old('deskripsi_produk', $umkm->deskripsi_produk) }}</textarea>
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
                                id="nomor_telepon" name="nomor_telepon"
                                value="{{ old('nomor_telepon', $umkm->nomor_telepon) }}"
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
                                id="link_facebook" name="link_facebook"
                                value="{{ old('link_facebook', $umkm->link_facebook) }}"
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
                                id="link_instagram" name="link_instagram"
                                value="{{ old('link_instagram', $umkm->link_instagram) }}"
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
                                id="link_tiktok" name="link_tiktok" value="{{ old('link_tiktok', $umkm->link_tiktok) }}"
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
                        <i class="bi bi-check-lg me-2"></i>Simpan Perubahan
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
        });
    </script>
@endpush
