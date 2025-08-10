@extends('layouts.main')

@push('style')
    <style>
        /* Form Styles - Same as create but with edit-specific modifications */
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
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
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

        .arsip-info-badge {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            padding: 8px 16px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 15px;
        }

        .category-badge {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            color: white;
            padding: 4px 12px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.8rem;
            margin-left: 10px;
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
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            min-width: 120px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 140, 66, 0.3);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffc107, #ffab00);
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            min-width: 120px;
            color: white;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3);
            color: white;
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

        .btn-outline-danger {
            color: #dc3545;
            border: 2px solid #dc3545;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            background: transparent;
            transition: all 0.3s ease;
            min-width: 120px;
        }

        .btn-outline-danger:hover {
            background: #dc3545;
            border-color: #dc3545;
            color: white;
            transform: translateY(-2px);
        }

        /* Category Toggle (Read-only for edit) */
        .category-display {
            background: var(--cream);
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
        }

        .category-display .category-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .category-display h6 {
            color: var(--primary-green);
            font-weight: 600;
            margin: 0;
        }

        [data-theme="dark"] .category-display h6 {
            color: var(--light-green);
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

        /* Change Tracking */
        .change-indicator {
            position: relative;
        }

        .change-indicator.modified::after {
            content: '●';
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--accent-orange);
            font-size: 0.8rem;
        }

        .changes-summary {
            background: rgba(255, 140, 66, 0.1);
            border: 1px solid rgba(255, 140, 66, 0.3);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            display: none;
        }

        .changes-summary.show {
            display: block;
        }

        .changes-summary h6 {
            color: var(--accent-orange);
            margin-bottom: 10px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .changes-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .changes-list li {
            font-size: 0.8rem;
            color: var(--soft-gray);
            margin-bottom: 5px;
            padding-left: 15px;
            position: relative;
        }

        .changes-list li::before {
            content: '→';
            position: absolute;
            left: 0;
            color: var(--accent-orange);
        }

        /* Dynamic fields visibility */
        .kategori-section {
            display: none;
        }

        .kategori-section.active {
            display: block;
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
            .btn-warning,
            .btn-outline-secondary,
            .btn-outline-danger {
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
                    <li class="breadcrumb-item">Administrasi</li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.arsip-surat.index') }}">Arsip Surat</a></li>
                    <li class="breadcrumb-item active">Edit Arsip</li>
                </ol>
            </nav>
            <h1 class="page-title">Edit Arsip Surat</h1>
            <p class="page-subtitle">Perbarui data arsip surat dengan informasi yang akurat</p>
        </div>

        <!-- Info Card -->
        <div class="info-card">
            <div class="info-icon">
                <i class="bi bi-pencil-square"></i>
            </div>
            <h6>Informasi Edit Data</h6>
            <p>
                Anda sedang mengedit data arsip surat. Pastikan perubahan yang dilakukan sudah sesuai
                dengan dokumen surat asli. Perubahan akan tercatat dalam sistem setelah disimpan.
            </p>
        </div>

        <!-- Changes Summary -->
        <div class="changes-summary" id="changesSummary">
            <h6><i class="bi bi-exclamation-circle me-2"></i>Data yang Diubah:</h6>
            <ul class="changes-list" id="changesList"></ul>
        </div>

        <!-- Main Form -->
        <div class="form-container">
            <div class="form-header">
                <div class="form-icon">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <h2 class="form-title">Form Edit Arsip Surat</h2>
                <p class="form-subtitle">
                    <span class="arsip-info-badge">{{ $arsipSurat->nomor_surat }}</span>
                    <span class="category-badge">{{ ucfirst($arsipSurat->kategori_surat) }}</span><br>
                    Terakhir diupdate: {{ $arsipSurat->updated_at->format('d/m/Y H:i') }}
                </p>
            </div>

            <!-- Category Display (Read-only) -->
            <div class="category-display">
                <div class="category-icon">
                    @if ($arsipSurat->kategori_surat === 'masuk')
                        <i class="bi bi-arrow-down-circle"></i>
                    @else
                        <i class="bi bi-arrow-up-circle"></i>
                    @endif
                </div>
                <h6>Surat {{ ucfirst($arsipSurat->kategori_surat) }}</h6>
            </div>

            <form action="{{ route('admin.arsip-surat.update', $arsipSurat->id) }}" method="POST" novalidate>
                @csrf
                @method('PUT')

                <!-- Hidden kategori field -->
                <input type="hidden" name="kategori" value="{{ $arsipSurat->kategori_surat }}">

                <!-- Section 1: Identitas Surat -->
                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-card-heading"></i>
                        </div>
                        Identitas Surat
                    </h4>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nomor_surat" class="form-label">
                                Nomor Surat <span class="required">*</span>
                            </label>
                            <input type="text"
                                class="form-control change-indicator @error('nomor_surat') is-invalid @enderror"
                                id="nomor_surat" name="nomor_surat"
                                value="{{ old('nomor_surat', $arsipSurat->nomor_surat) }}"
                                data-original="{{ $arsipSurat->nomor_surat }}" placeholder="Masukkan nomor surat" required>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Nomor surat sesuai dokumen resmi
                            </div>
                            @error('nomor_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tanggal_surat" class="form-label">
                                Tanggal Surat <span class="required">*</span>
                            </label>
                            <input type="date"
                                class="form-control change-indicator @error('tanggal_surat') is-invalid @enderror"
                                id="tanggal_surat" name="tanggal_surat"
                                value="{{ old('tanggal_surat', $arsipSurat->tanggal_surat->format('Y-m-d')) }}"
                                data-original="{{ $arsipSurat->tanggal_surat->format('Y-m-d') }}" required>
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
                @if ($arsipSurat->kategori_surat === 'masuk')
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
                                <input type="text"
                                    class="form-control change-indicator @error('pengirim') is-invalid @enderror"
                                    id="pengirim" name="pengirim" value="{{ old('pengirim', $arsipSurat->pengirim) }}"
                                    data-original="{{ $arsipSurat->pengirim }}"
                                    placeholder="Nama instansi/personal pengirim" required>
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
                                <textarea class="form-control change-indicator @error('perihal') is-invalid @enderror" id="perihal" name="perihal"
                                    rows="3" data-original="{{ $arsipSurat->perihal }}" placeholder="Perihal/maksud dari surat masuk"
                                    required>{{ old('perihal', $arsipSurat->perihal) }}</textarea>
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
                @else
                    <!-- Surat Keluar Fields -->
                    <div class="form-section kategori-section active" id="suratKeluar">
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
                                <input type="text"
                                    class="form-control change-indicator @error('tujuan_surat') is-invalid @enderror"
                                    id="tujuan_surat" name="tujuan_surat"
                                    value="{{ old('tujuan_surat', $arsipSurat->tujuan_surat) }}"
                                    data-original="{{ $arsipSurat->tujuan_surat }}"
                                    placeholder="Nama instansi/personal tujuan" required>
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
                                <textarea class="form-control change-indicator @error('tentang') is-invalid @enderror" id="tentang" name="tentang"
                                    rows="3" data-original="{{ $arsipSurat->tentang }}" placeholder="Tentang/isi dari surat keluar" required>{{ old('tentang', $arsipSurat->tentang) }}</textarea>
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
                @endif

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
                            <textarea class="form-control change-indicator @error('keterangan') is-invalid @enderror" id="keterangan"
                                name="keterangan" rows="3" data-original="{{ $arsipSurat->keterangan }}"
                                placeholder="Catatan atau keterangan tambahan (opsional)">{{ old('keterangan', $arsipSurat->keterangan) }}</textarea>
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
                    <a href="{{ route('admin.arsip-surat.show', $arsipSurat->id) }}" class="btn btn-outline-danger">
                        <i class="bi bi-eye me-2"></i>Lihat Detail
                    </a>
                    <button type="submit" class="btn btn-primary" id="saveBtn">
                        <i class="bi bi-check-lg me-2"></i>Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const changesSummary = document.getElementById('changesSummary');
            const changesList = document.getElementById('changesList');
            const saveBtn = document.getElementById('saveBtn');
            let hasChanges = false;

            // Track changes
            const trackableInputs = document.querySelectorAll('.change-indicator');
            trackableInputs.forEach(input => {
                input.addEventListener('input', function() {
                    trackChanges();
                });
            });

            function trackChanges() {
                const changes = [];
                hasChanges = false;

                trackableInputs.forEach(input => {
                    const currentValue = input.value.trim();
                    const originalValue = input.getAttribute('data-original') || '';
                    const fieldName = getFieldName(input.name);

                    if (currentValue !== originalValue) {
                        input.classList.add('modified');
                        changes.push({
                            field: fieldName,
                            from: originalValue,
                            to: currentValue
                        });
                        hasChanges = true;
                    } else {
                        input.classList.remove('modified');
                    }
                });

                updateChangesSummary(changes);
                updateSaveButton();
            }

            function getFieldName(name) {
                const fieldNames = {
                    'nomor_surat': 'Nomor Surat',
                    'tanggal_surat': 'Tanggal Surat',
                    'pengirim': 'Pengirim',
                    'perihal': 'Perihal',
                    'tujuan_surat': 'Tujuan Surat',
                    'tentang': 'Tentang',
                    'keterangan': 'Keterangan'
                };
                return fieldNames[name] || name;
            }

            function updateChangesSummary(changes) {
                if (changes.length > 0) {
                    changesList.innerHTML = '';
                    changes.forEach(change => {
                        const li = document.createElement('li');
                        const fromText = change.from || '[kosong]';
                        const toText = change.to || '[kosong]';
                        li.textContent = `${change.field}: "${fromText}" → "${toText}"`;
                        changesList.appendChild(li);
                    });
                    changesSummary.classList.add('show');
                } else {
                    changesSummary.classList.remove('show');
                }
            }

            function updateSaveButton() {
                if (hasChanges) {
                    saveBtn.innerHTML = '<i class="bi bi-check-lg me-2"></i>Simpan Perubahan';
                    saveBtn.classList.remove('btn-primary');
                    saveBtn.classList.add('btn-warning');
                } else {
                    saveBtn.innerHTML = '<i class="bi bi-check-lg me-2"></i>Update Data';
                    saveBtn.classList.remove('btn-warning');
                    saveBtn.classList.add('btn-primary');
                }
            }

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

                // Initial resize
                textarea.style.height = 'auto';
                textarea.style.height = (textarea.scrollHeight) + 'px';
            });

            // Form validation
            form.addEventListener('submit', function(e) {
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
                const kategori = '{{ $arsipSurat->kategori_surat }}';
                if (kategori === 'masuk') {
                    const pengirim = document.getElementById('pengirim')?.value.trim();
                    const perihal = document.getElementById('perihal')?.value.trim();

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
                    const tujuanSurat = document.getElementById('tujuan_surat')?.value.trim();
                    const tentang = document.getElementById('tentang')?.value.trim();

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

                if (hasChanges) {
                    const confirmMessage =
                        'Apakah Anda yakin ingin menyimpan perubahan data arsip surat ini?';
                    if (!confirm(confirmMessage)) {
                        e.preventDefault();
                        return false;
                    }
                }

                // Show loading state
                saveBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';
                saveBtn.disabled = true;
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

            // Warning before leaving with unsaved changes
            window.addEventListener('beforeunload', function(e) {
                if (hasChanges) {
                    e.preventDefault();
                    e.returnValue =
                        'Anda memiliki perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
                    return e.returnValue;
                }
            });

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

            // Auto-save to localStorage (optional feature)
            function autoSave() {
                if (hasChanges) {
                    const formData = new FormData(form);
                    const data = {};
                    formData.forEach((value, key) => {
                        data[key] = value;
                    });
                    data.originalId = '{{ $arsipSurat->id }}';
                    localStorage.setItem('arsip_surat_edit_draft', JSON.stringify(data));
                }
            }

            function loadDraft() {
                const draft = localStorage.getItem('arsip_surat_edit_draft');
                if (draft) {
                    const data = JSON.parse(draft);
                    if (data.originalId === '{{ $arsipSurat->id }}' && confirm(
                            'Ditemukan draft perubahan yang belum selesai. Ingin melanjutkan?')) {
                        Object.keys(data).forEach(key => {
                            if (key !== 'originalId') {
                                const field = form.querySelector(`[name="${key}"]`);
                                if (field) {
                                    field.value = data[key];
                                }
                            }
                        });
                        trackChanges();
                    }
                }
            }

            // Auto-save every 30 seconds
            setInterval(autoSave, 30000);

            // Load draft on page load
            loadDraft();

            // Clear draft on successful submit
            form.addEventListener('submit', function(e) {
                if (!e.defaultPrevented) {
                    localStorage.removeItem('arsip_surat_edit_draft');
                }
            });

            // Smooth section transitions
            const formSections = document.querySelectorAll('.form-section');
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

            // Show sections with animation
            setTimeout(() => {
                formSections.forEach((section, index) => {
                    setTimeout(() => {
                        section.style.opacity = '1';
                        section.style.transform = 'translateY(0)';
                    }, index * 200);
                });
            }, 100);

            // Highlight changed fields with subtle animation
            function highlightChangedField(field) {
                field.style.borderColor = 'var(--accent-orange)';
                field.style.boxShadow = '0 0 0 0.2rem rgba(255, 140, 66, 0.25)';

                setTimeout(() => {
                    field.style.borderColor = '';
                    field.style.boxShadow = '';
                }, 2000);
            }

            // Enhanced change tracking with animation
            trackableInputs.forEach(input => {
                input.addEventListener('change', function() {
                    if (this.classList.contains('modified')) {
                        highlightChangedField(this);
                    }
                });
            });

            // Initial setup
            trackChanges();

            // Success message display helper
            function showSuccessMessage(message) {
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success alert-dismissible fade show';
                alertDiv.innerHTML = `
                    <i class="bi bi-check-circle-fill me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;

                const container = document.querySelector('.dashboard-content');
                container.insertBefore(alertDiv, container.firstChild);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    if (alertDiv.parentElement) {
                        alertDiv.remove();
                    }
                }, 5000);
            }

            // Form reset functionality
            function resetForm() {
                trackableInputs.forEach(input => {
                    const originalValue = input.getAttribute('data-original') || '';
                    input.value = originalValue;
                    input.classList.remove('modified');
                });
                trackChanges();
            }

            // Add reset button functionality (if needed)
            const resetBtn = document.getElementById('resetBtn');
            if (resetBtn) {
                resetBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (confirm('Yakin ingin mengembalikan semua perubahan ke data asli?')) {
                        resetForm();
                    }
                });
            }

            // Tooltip initialization for help text
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
