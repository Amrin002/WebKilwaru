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
        .input-group-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        @media (max-width: 768px) {
            .input-group-grid {
                grid-template-columns: 1fr;
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
                    <li class="breadcrumb-item"><a href="{{ route('admin.apbdes.index') }}">Kelola APBDes</a></li>
                    <li class="breadcrumb-item active">Tambah APBDes</li>
                </ol>
            </nav>
            <h1 class="page-title">Tambah Data APBDes</h1>
            <p class="page-subtitle">Lengkapi form di bawah untuk menambahkan data APBDes tahunan.</p>
        </div>

        <div class="info-card">
            <div class="info-icon">
                <i class="bi bi-info-lg"></i>
            </div>
            <h6>Petunjuk Pengisian</h6>
            <p>
                Pastikan data anggaran dimasukkan dalam bentuk angka (rupiah tanpa titik atau koma).
                Untuk dokumen, pastikan file berformat PDF dan tidak lebih dari 5MB.
                Untuk gambar baliho, pastikan file berformat JPEG/PNG/JPG dan tidak lebih dari 3MB.
                Semua field yang bertanda bintang (*) wajib diisi.
            </p>
            @if ($hasCurrentYear)
                <p class="mt-3 text-danger">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                    Catatan: APBDes untuk tahun {{ $currentYear }} sudah ada. Anda tidak bisa menambahkannya lagi.
                </p>
            @endif
        </div>

        <div class="form-container">
            <div class="form-header">
                <div class="form-icon">
                    <i class="bi bi-receipt-cutoff"></i>
                </div>
                <h2 class="form-title">Form Tambah APBDes</h2>
                <p class="form-subtitle">Masukkan data APBDes untuk tahun anggaran baru.</p>
            </div>

            <form action="{{ route('admin.apbdes.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                        Data Anggaran
                    </h4>

                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun Anggaran <span class="required">*</span></label>
                        {{-- Logika untuk readonly hanya jika tahun sekarang sudah ada --}}
                        <input type="number" class="form-control @error('tahun') is-invalid @enderror" id="tahun"
                            name="tahun" value="{{ old('tahun', $currentYear) }}" min="2020" max="2050" required>
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Tahun anggaran APBDes (contoh: {{ $currentYear }})
                        </div>
                        @error('tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group-grid">
                        <div class="mb-3">
                            <label for="pemerintahan_desa" class="form-label">
                                Pemerintahan Desa <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('pemerintahan_desa') is-invalid @enderror"
                                id="pemerintahan_desa" name="pemerintahan_desa" value="{{ old('pemerintahan_desa') }}"
                                placeholder="Masukkan jumlah dalam Rupiah" required>
                            @error('pemerintahan_desa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="pembangunan_desa" class="form-label">
                                Pembangunan Desa <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('pembangunan_desa') is-invalid @enderror"
                                id="pembangunan_desa" name="pembangunan_desa" value="{{ old('pembangunan_desa') }}"
                                placeholder="Masukkan jumlah dalam Rupiah" required>
                            @error('pembangunan_desa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="kemasyarakatan" class="form-label">
                                Pembinaan Kemasyarakatan <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('kemasyarakatan') is-invalid @enderror"
                                id="kemasyarakatan" name="kemasyarakatan" value="{{ old('kemasyarakatan') }}"
                                placeholder="Masukkan jumlah dalam Rupiah" required>
                            @error('kemasyarakatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="pemberdayaan" class="form-label">
                                Pemberdayaan Masyarakat <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('pemberdayaan') is-invalid @enderror"
                                id="pemberdayaan" name="pemberdayaan" value="{{ old('pemberdayaan') }}"
                                placeholder="Masukkan jumlah dalam Rupiah" required>
                            @error('pemberdayaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="bencana_darurat" class="form-label">
                                Bencana, Darurat & Mendesak <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('bencana_darurat') is-invalid @enderror"
                                id="bencana_darurat" name="bencana_darurat" value="{{ old('bencana_darurat') }}"
                                placeholder="Masukkan jumlah dalam Rupiah" required>
                            @error('bencana_darurat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-file-earmark-arrow-up"></i>
                        </div>
                        Dokumen & Baliho
                    </h4>
                    <div class="mb-3">
                        <label for="pdf_dokumen" class="form-label">Dokumen PDF APBDes</label>
                        <input type="file" class="form-control @error('pdf_dokumen') is-invalid @enderror"
                            id="pdf_dokumen" name="pdf_dokumen" accept="application/pdf">
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Opsional. Maks. 5MB. Format: PDF.
                        </div>
                        @error('pdf_dokumen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="baliho_image" class="form-label">Gambar Baliho APBDes</label>
                        <input type="file" class="form-control @error('baliho_image') is-invalid @enderror"
                            id="baliho_image" name="baliho_image" accept="image/jpeg,image/png,image/jpg">
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Opsional. Maks. 3MB. Format: JPG, JPEG, PNG.
                        </div>
                        @error('baliho_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.apbdes.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary" id="submitButton">
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
            // Function to format input as Rupiah without currency symbol
            function formatRupiah(input) {
                let value = input.value.replace(/\D/g, ''); // Remove all non-numeric characters
                if (value === '') return '';
                value = parseInt(value, 10);
                if (isNaN(value)) {
                    value = '';
                }
                input.value = value;
            }

            const anggaranInputs = [
                'pemerintahan_desa',
                'pembangunan_desa',
                'kemasyarakatan',
                'pemberdayaan',
                'bencana_darurat'
            ];

            anggaranInputs.forEach(inputId => {
                const input = document.getElementById(inputId);
                if (input) {
                    input.addEventListener('input', (e) => formatRupiah(e.target));
                }
            });

            // Form validation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const tahunInput = document.getElementById('tahun');
                const tahunValue = tahunInput.value;

                if (tahunValue.length !== 4 || parseInt(tahunValue) < 2020 || parseInt(tahunValue) > 2050) {
                    e.preventDefault();
                    alert('Tahun harus 4 digit angka, antara 2020 dan 2050.');
                    return false;
                }

                // Periksa apakah ada file yang diunggah dan ukurannya tidak nol
                const pdfInput = document.getElementById('pdf_dokumen');
                const balihoInput = document.getElementById('baliho_image');

                if (pdfInput.files.length > 0 && pdfInput.files[0].size === 0) {
                    e.preventDefault();
                    alert('File PDF yang diunggah tidak valid atau kosong.');
                    return false;
                }

                if (balihoInput.files.length > 0 && balihoInput.files[0].size === 0) {
                    e.preventDefault();
                    alert('File gambar baliho yang diunggah tidak valid atau kosong.');
                    return false;
                }
            });
        });
    </script>
@endpush
