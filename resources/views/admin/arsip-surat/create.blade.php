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

        .btn-secondary {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            border: none;
            border-radius: 12px;
            padding: 8px 20px;
            font-weight: 500;
            color: white;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            transform: translateY(-1px);
            color: white;
        }

        /* Category Toggle */
        .category-toggle {
            display: flex;
            background: var(--cream);
            border-radius: 15px;
            padding: 5px;
            margin-bottom: 20px;
        }

        .category-option {
            flex: 1;
            text-align: center;
            padding: 12px 20px;
            border-radius: 10px;
            background: transparent;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            color: var(--soft-gray);
        }

        .category-option.active {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(45, 80, 22, 0.3);
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

        /* Info Card */
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

        /* Auto-generation display */
        .nomor-suggestion {
            background: linear-gradient(135deg, rgba(45, 80, 22, 0.1), rgba(255, 140, 66, 0.05));
            border: 1px solid rgba(45, 80, 22, 0.2);
            border-radius: 10px;
            padding: 15px;
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nomor-suggestion .suggestion-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: var(--primary-green);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.8rem;
        }

        .suggestion-text {
            flex: 1;
            font-size: 0.85rem;
            color: var(--primary-green);
            font-weight: 500;
        }

        .suggestion-number {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: var(--accent-orange);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            .form-actions {
                flex-direction: column;
            }

            .category-toggle {
                flex-direction: column;
                gap: 5px;
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

        /* Dynamic fields visibility */
        .kategori-section {
            display: none;
        }

        .kategori-section.active {
            display: block;
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
                    <li class="breadcrumb-item">Administrasi</li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.arsip-surat.index') }}">Arsip Surat</a></li>
                    <li class="breadcrumb-item active">Tambah Arsip Baru</li>
                </ol>
            </nav>
            <h1 class="page-title">Tambah Arsip Surat Baru</h1>
            <p class="page-subtitle">Lengkapi form di bawah untuk menambahkan data arsip surat ke sistem</p>
        </div>

        <!-- Info Card -->
        <div class="info-card">
            <div class="info-icon">
                <i class="bi bi-info-lg"></i>
            </div>
            <h6>Petunjuk Pengisian</h6>
            <p>
                Pastikan data yang dimasukkan sesuai dengan dokumen surat asli.
                Pilih kategori surat (masuk/keluar) terlebih dahulu untuk menampilkan field yang sesuai.
                Nomor surat harus unik dan belum terdaftar dalam sistem.
                Tanggal surat harus sesuai dengan tanggal yang tertera pada dokumen.
            </p>
        </div>

        <!-- Progress Steps -->
        <div class="form-progress">
            <div class="progress-step active">
                <div class="step-number">1</div>
                <span>Kategori Surat</span>
            </div>
            <div class="progress-step">
                <div class="step-number">2</div>
                <span>Detail Surat</span>
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
                    <i class="bi bi-archive-fill"></i>
                </div>
                <h2 class="form-title">Form Tambah Arsip Surat</h2>
                <p class="form-subtitle">Masukkan data arsip surat dengan lengkap dan benar</p>
            </div>

            <form action="{{ route('admin.arsip-surat.store') }}" method="POST" novalidate>
                @csrf

                <!-- Section 1: Kategori dan Identitas Surat -->
                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-card-heading"></i>
                        </div>
                        Identitas Surat
                    </h4>

                    <!-- Category Selection -->
                    <div class="mb-4">
                        <label class="form-label">Kategori Surat <span class="required">*</span></label>
                        <div class="category-toggle">
                            <button type="button" class="category-option active" data-kategori="masuk">
                                <i class="bi bi-arrow-down-circle me-2"></i>Surat Masuk
                            </button>
                            <button type="button" class="category-option" data-kategori="keluar">
                                <i class="bi bi-arrow-up-circle me-2"></i>Surat Keluar
                            </button>
                        </div>
                        <input type="hidden" name="kategori" id="kategori" value="masuk" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nomor_surat" class="form-label">
                                Nomor Surat <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror"
                                id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat') }}"
                                placeholder="Masukkan nomor surat" required>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Nomor surat sesuai dokumen resmi
                            </div>
                            @error('nomor_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <!-- Auto-generate suggestion for surat keluar -->
                            <div class="nomor-suggestion" id="nomorSuggestion" style="display: none;">
                                <div class="suggestion-icon">
                                    <i class="bi bi-lightbulb"></i>
                                </div>
                                <div class="suggestion-text">
                                    Saran nomor surat: <span class="suggestion-number"
                                        id="suggestedNumber">{{ $suggestedNomor ?? '' }}</span>
                                    <button type="button" class="btn btn-secondary btn-sm ms-2" id="useNomorSuggestion">
                                        Gunakan
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tanggal_surat" class="form-label">
                                Tanggal Surat <span class="required">*</span>
                            </label>
                            <input type="date" class="form-control @error('tanggal_surat') is-invalid @enderror"
                                id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat', date('Y-m-d')) }}"
                                required>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Tanggal sesuai dokumen surat
                            </div>
                            @error('tanggal_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Dynamic Content Based on Category -->
                <!-- Surat Masuk Fields -->
                <div class="form-section kategori-section active" id="suratMasuk">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-arrow-down-circle"></i>
                        </div>
                        Detail Surat Masuk
                    </h4>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pengirim" class="form-label">
                                Pengirim <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('pengirim') is-invalid @enderror"
                                id="pengirim" name="pengirim" value="{{ old('pengirim') }}"
                                placeholder="Nama instansi/personal pengirim">
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Nama lengkap instansi atau person pengirim
                            </div>
                            @error('pengirim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="perihal" class="form-label">
                                Perihal <span class="required">*</span>
                            </label>
                            <textarea class="form-control @error('perihal') is-invalid @enderror" id="perihal" name="perihal" rows="3"
                                placeholder="Perihal/maksud dari surat masuk">{{ old('perihal') }}</textarea>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Isi singkat mengenai maksud surat
                            </div>
                            @error('perihal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Surat Keluar Fields -->
                <div class="form-section kategori-section" id="suratKeluar">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-arrow-up-circle"></i>
                        </div>
                        Detail Surat Keluar
                    </h4>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tujuan_surat" class="form-label">
                                Tujuan Surat <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('tujuan_surat') is-invalid @enderror"
                                id="tujuan_surat" name="tujuan_surat" value="{{ old('tujuan_surat') }}"
                                placeholder="Nama instansi/personal tujuan">
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Nama lengkap instansi atau person tujuan
                            </div>
                            @error('tujuan_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="tentang" class="form-label">
                                Tentang <span class="required">*</span>
                            </label>
                            <textarea class="form-control @error('tentang') is-invalid @enderror" id="tentang" name="tentang" rows="3"
                                placeholder="Tentang/isi dari surat keluar">{{ old('tentang') }}</textarea>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Isi singkat mengenai surat yang dikirim
                            </div>
                            @error('tentang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 3: Additional Information -->
                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-chat-text"></i>
                        </div>
                        Informasi Tambahan
                    </h4>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="keterangan" class="form-label">
                                Keterangan
                            </label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan"
                                rows="3" placeholder="Catatan atau keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Catatan khusus atau informasi tambahan (tidak wajib)
                            </div>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('admin.arsip-surat.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>Simpan Arsip
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Category toggle functionality
            const categoryButtons = document.querySelectorAll('.category-option');
            const kategoriInput = document.getElementById('kategori');
            const suratMasukSection = document.getElementById('suratMasuk');
            const suratKeluarSection = document.getElementById('suratKeluar');
            const nomorSuggestion = document.getElementById('nomorSuggestion');

            categoryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    categoryButtons.forEach(btn => btn.classList.remove('active'));

                    // Add active class to clicked button
                    this.classList.add('active');

                    // Get selected category
                    const selectedKategori = this.dataset.kategori;
                    kategoriInput.value = selectedKategori;

                    // Toggle sections
                    if (selectedKategori === 'masuk') {
                        suratMasukSection.classList.add('active');
                        suratKeluarSection.classList.remove('active');
                        nomorSuggestion.style.display = 'none';

                        // Clear surat keluar fields
                        document.getElementById('tujuan_surat').value = '';
                        document.getElementById('tentang').value = '';
                    } else {
                        suratMasukSection.classList.remove('active');
                        suratKeluarSection.classList.add('active');
                        nomorSuggestion.style.display = 'block';

                        // Clear surat masuk fields
                        document.getElementById('pengirim').value = '';
                        document.getElementById('perihal').value = '';

                        // Generate nomor suggestion for surat keluar
                        generateNomorSurat();
                    }

                    // Update progress step
                    updateProgressStep();
                });
            });

            // Generate nomor surat suggestion
            function generateNomorSurat() {
                const tanggalSurat = document.getElementById('tanggal_surat').value;
                if (!tanggalSurat) return;

                const date = new Date(tanggalSurat);
                const tahun = date.getFullYear();
                const bulan = date.getMonth() + 1;

                // Call AJAX to get next number
                fetch(`{{ route('admin.arsip-surat.generate-nomor') }}?tahun=${tahun}&bulan=${bulan}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('suggestedNumber').textContent = data.nomor_surat;
                    })
                    .catch(error => {
                        console.error('Error generating nomor:', error);
                    });
            }

            // Use suggested nomor
            document.getElementById('useNomorSuggestion')?.addEventListener('click', function() {
                const suggestedNumber = document.getElementById('suggestedNumber').textContent;
                document.getElementById('nomor_surat').value = suggestedNumber;
            });

            // Update nomor suggestion when date changes
            document.getElementById('tanggal_surat').addEventListener('change', function() {
                if (kategoriInput.value === 'keluar') {
                    generateNomorSurat();
                }
            });

            // Form validation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const kategori = kategoriInput.value;
                const nomorSurat = document.getElementById('nomor_surat').value.trim();
                const tanggalSurat = document.getElementById('tanggal_surat').value;

                // Basic validations
                if (!nomorSurat) {
                    e.preventDefault();
                    alert('Nomor surat wajib diisi!');
                    return false;
                }

                if (!tanggalSurat) {
                    e.preventDefault();
                    alert('Tanggal surat wajib diisi!');
                    return false;
                }

                // Category specific validations
                if (kategori === 'masuk') {
                    const pengirim = document.getElementById('pengirim').value.trim();
                    const perihal = document.getElementById('perihal').value.trim();

                    if (!pengirim) {
                        e.preventDefault();
                        alert('Pengirim wajib diisi untuk surat masuk!');
                        return false;
                    }

                    if (!perihal) {
                        e.preventDefault();
                        alert('Perihal wajib diisi untuk surat masuk!');
                        return false;
                    }
                } else if (kategori === 'keluar') {
                    const tujuanSurat = document.getElementById('tujuan_surat').value.trim();
                    const tentang = document.getElementById('tentang').value.trim();

                    if (!tujuanSurat) {
                        e.preventDefault();
                        alert('Tujuan surat wajib diisi untuk surat keluar!');
                        return false;
                    }

                    if (!tentang) {
                        e.preventDefault();
                        alert('Tentang wajib diisi untuk surat keluar!');
                        return false;
                    }
                }
            });

            // Progress step animation
            const formSections = document.querySelectorAll('.form-section');
            const progressSteps = document.querySelectorAll('.progress-step');

            function updateProgressStep() {
                // Simple progress based on form completion
                const kategori = kategoriInput.value;
                const nomorSurat = document.getElementById('nomor_surat').value.trim();
                const tanggalSurat = document.getElementById('tanggal_surat').value;

                // Reset all steps
                progressSteps.forEach(step => step.classList.remove('active'));

                // Step 1: Always active
                progressSteps[0].classList.add('active');

                // Step 2: If basic info filled
                if (kategori && nomorSurat && tanggalSurat) {
                    progressSteps[1].classList.add('active');
                }

                // Step 3: If category specific fields filled
                if (kategori === 'masuk') {
                    const pengirim = document.getElementById('pengirim').value.trim();
                    const perihal = document.getElementById('perihal').value.trim();
                    if (pengirim && perihal) {
                        progressSteps[2].classList.add('active');
                    }
                } else if (kategori === 'keluar') {
                    const tujuanSurat = document.getElementById('tujuan_surat').value.trim();
                    const tentang = document.getElementById('tentang').value.trim();
                    if (tujuanSurat && tentang) {
                        progressSteps[2].classList.add('active');
                    }
                }
            }

            // Monitor form changes for progress update
            form.addEventListener('input', updateProgressStep);
            form.addEventListener('change', updateProgressStep);

            // Intersection Observer for smooth section transitions
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1
            });

            formSections.forEach(section => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(20px)';
                section.style.transition = 'all 0.6s ease';
                observer.observe(section);
            });

            // Format input text
            const textInputs = ['pengirim', 'tujuan_surat'];
            textInputs.forEach(inputId => {
                const input = document.getElementById(inputId);
                if (input) {
                    input.addEventListener('input', function(e) {
                        // Capitalize first letter of each word
                        e.target.value = e.target.value.toLowerCase().replace(/\b\w/g, l => l
                            .toUpperCase());
                    });
                }
            });

            // Auto-resize textareas
            const textareas = document.querySelectorAll('textarea');
            textareas.forEach(textarea => {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });
            });

            // Initial setup
            updateProgressStep();

            // Show initial sections with animation
            setTimeout(() => {
                formSections.forEach((section, index) => {
                    setTimeout(() => {
                        section.style.opacity = '1';
                        section.style.transform = 'translateY(0)';
                    }, index * 200);
                });
            }, 100);

            // Add floating label effect
            const formControls = document.querySelectorAll('.form-control, .form-select');
            formControls.forEach(control => {
                control.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });

                control.addEventListener('blur', function() {
                    if (!this.value) {
                        this.parentElement.classList.remove('focused');
                    }
                });

                // Initial state
                if (control.value) {
                    control.parentElement.classList.add('focused');
                }
            });

            // Success animation on form submit
            form.addEventListener('submit', function(e) {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn && !e.defaultPrevented) {
                    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';
                    submitBtn.disabled = true;

                    // Add loading animation
                    submitBtn.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        submitBtn.style.transform = 'scale(1)';
                    }, 150);
                }
            });

            // Enhanced validation feedback
            const inputs = form.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });

                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid')) {
                        validateField(this);
                    }
                });
            });

            function validateField(field) {
                const value = field.value.trim();
                const isRequired = field.hasAttribute('required');
                let isValid = true;
                let message = '';

                // Remove previous validation
                field.classList.remove('is-invalid', 'is-valid');
                const feedback = field.parentElement.querySelector('.validation-feedback');
                if (feedback) feedback.remove();

                // Required field validation
                if (isRequired && !value) {
                    isValid = false;
                    message = 'Field ini wajib diisi';
                }

                // Specific field validations
                if (field.id === 'nomor_surat' && value) {
                    if (value.length < 3) {
                        isValid = false;
                        message = 'Nomor surat minimal 3 karakter';
                    }
                }

                if (field.id === 'tanggal_surat' && value) {
                    const selectedDate = new Date(value);
                    const today = new Date();
                    const futureLimit = new Date();
                    futureLimit.setFullYear(today.getFullYear() + 1);

                    if (selectedDate > futureLimit) {
                        isValid = false;
                        message = 'Tanggal surat tidak boleh lebih dari 1 tahun ke depan';
                    }
                }

                // Apply validation result
                if (isValid && value) {
                    field.classList.add('is-valid');
                } else if (!isValid) {
                    field.classList.add('is-invalid');

                    // Add custom feedback
                    const feedbackDiv = document.createElement('div');
                    feedbackDiv.className = 'validation-feedback invalid-feedback';
                    feedbackDiv.textContent = message;
                    field.parentElement.appendChild(feedbackDiv);
                }

                return isValid;
            }

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl + Enter to submit
                if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                    e.preventDefault();
                    form.requestSubmit();
                }

                // Escape to go back
                if (e.key === 'Escape') {
                    const backBtn = document.querySelector('.btn-outline-secondary');
                    if (backBtn && confirm('Yakin ingin kembali? Data yang belum disimpan akan hilang.')) {
                        window.location.href = backBtn.href;
                    }
                }
            });

            // Auto-save to localStorage (optional feature)
            function autoSave() {
                const formData = new FormData(form);
                const data = {};
                formData.forEach((value, key) => {
                    data[key] = value;
                });
                localStorage.setItem('arsip_surat_draft', JSON.stringify(data));
            }

            function loadDraft() {
                const draft = localStorage.getItem('arsip_surat_draft');
                if (draft && confirm('Ditemukan draft yang belum selesai. Ingin melanjutkan?')) {
                    const data = JSON.parse(draft);
                    Object.keys(data).forEach(key => {
                        const field = form.querySelector(`[name="${key}"]`);
                        if (field) {
                            field.value = data[key];
                            if (key === 'kategori') {
                                // Trigger category change
                                const categoryBtn = document.querySelector(
                                    `[data-kategori="${data[key]}"]`);
                                if (categoryBtn) categoryBtn.click();
                            }
                        }
                    });
                    updateProgressStep();
                }
            }

            // Auto-save every 30 seconds
            setInterval(autoSave, 30000);

            // Load draft on page load
            loadDraft();

            // Clear draft on successful submit
            form.addEventListener('submit', function(e) {
                if (!e.defaultPrevented) {
                    localStorage.removeItem('arsip_surat_draft');
                }
            });
        });
    </script>
@endpush
