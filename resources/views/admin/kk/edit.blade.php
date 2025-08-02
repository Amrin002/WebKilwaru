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

        .kk-info-badge {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            padding: 8px 16px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 15px;
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

        /* Input Group Styles */
        .input-group-kk {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .input-group-location {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
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

        /* Responsive */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            .input-group-kk,
            .input-group-location {
                grid-template-columns: 1fr;
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
                    <li class="breadcrumb-item">Data Penduduk</li>
                    <li class="breadcrumb-item"><a href="{{ route('kk.index') }}">Data Kartu Keluarga</a></li>
                    <li class="breadcrumb-item active">Edit KK</li>
                </ol>
            </nav>
            <h1 class="page-title">Edit Kartu Keluarga</h1>
            <p class="page-subtitle">Perbarui data kartu keluarga dengan informasi yang akurat</p>
        </div>

        <!-- Info Card -->
        <div class="info-card">
            <div class="info-icon">
                <i class="bi bi-pencil-square"></i>
            </div>
            <h6>Informasi Edit Data</h6>
            <p>
                Anda sedang mengedit data kartu keluarga. Pastikan perubahan yang dilakukan sudah sesuai
                dengan dokumen resmi terbaru. Perubahan akan tercatat dalam sistem setelah disimpan.
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
                <h2 class="form-title">Form Edit Kartu Keluarga</h2>
                <p class="form-subtitle">
                    <span class="kk-info-badge">No. KK: {{ $kk->no_kk }}</span><br>
                    Terakhir diupdate: {{ $kk->updated_at->format('d/m/Y H:i') }}
                </p>
            </div>

            <form action="{{ route('kk.update', $kk->no_kk) }}" method="POST" novalidate>
                @csrf
                @method('PUT')

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
                            <input type="text" class="form-control change-indicator @error('no_kk') is-invalid @enderror"
                                id="no_kk" name="no_kk" value="{{ old('no_kk', $kk->no_kk) }}"
                                data-original="{{ $kk->no_kk }}" placeholder="Masukkan 16 digit nomor KK" maxlength="16"
                                pattern="[0-9]{16}" required>
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
                            <textarea class="form-control change-indicator @error('alamat') is-invalid @enderror" id="alamat" name="alamat"
                                data-original="{{ $kk->alamat }}" rows="3" placeholder="Contoh: Jl. Merdeka No. 123, Perumahan Sejahtera"
                                required>{{ old('alamat', $kk->alamat) }}</textarea>
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
                            <input type="text" class="form-control change-indicator @error('rt') is-invalid @enderror"
                                id="rt" name="rt" value="{{ old('rt', $kk->rt) }}"
                                data-original="{{ $kk->rt }}" placeholder="001" maxlength="3" required>
                            @error('rt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="rw" class="form-label">
                                RW <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control change-indicator @error('rw') is-invalid @enderror"
                                id="rw" name="rw" value="{{ old('rw', $kk->rw) }}"
                                data-original="{{ $kk->rw }}" placeholder="001" maxlength="3" required>
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
                            <input type="text"
                                class="form-control change-indicator @error('desa') is-invalid @enderror" id="desa"
                                name="desa" value="{{ old('desa', $kk->desa) }}" data-original="{{ $kk->desa }}"
                                placeholder="Nama Desa/Kelurahan" required>
                            @error('desa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kecamatan" class="form-label">
                                Kecamatan <span class="required">*</span>
                            </label>
                            <input type="text"
                                class="form-control change-indicator @error('kecamatan') is-invalid @enderror"
                                id="kecamatan" name="kecamatan" value="{{ old('kecamatan', $kk->kecamatan) }}"
                                data-original="{{ $kk->kecamatan }}" placeholder="Nama Kecamatan" required>
                            @error('kecamatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kabupaten" class="form-label">
                                Kabupaten/Kota <span class="required">*</span>
                            </label>
                            <input type="text"
                                class="form-control change-indicator @error('kabupaten') is-invalid @enderror"
                                id="kabupaten" name="kabupaten" value="{{ old('kabupaten', $kk->kabupaten) }}"
                                data-original="{{ $kk->kabupaten }}" placeholder="Nama Kabupaten/Kota" required>
                            @error('kabupaten')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="provinsi" class="form-label">
                                Provinsi <span class="required">*</span>
                            </label>
                            <input type="text"
                                class="form-control change-indicator @error('provinsi') is-invalid @enderror"
                                id="provinsi" name="provinsi" value="{{ old('provinsi', $kk->provinsi) }}"
                                data-original="{{ $kk->provinsi }}" placeholder="Nama Provinsi" required>
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
                            <input type="text"
                                class="form-control change-indicator @error('kode_pos') is-invalid @enderror"
                                id="kode_pos" name="kode_pos" value="{{ old('kode_pos', $kk->kode_pos) }}"
                                data-original="{{ $kk->kode_pos }}" placeholder="12345" maxlength="5"
                                pattern="[0-9]{5}" required>
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
                    <a href="{{ route('kk.show', $kk->no_kk) }}" class="btn btn-outline-danger">
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
                    const originalValue = input.getAttribute('data-original');
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
                    'no_kk': 'Nomor KK',
                    'alamat': 'Alamat',
                    'rt': 'RT',
                    'rw': 'RW',
                    'desa': 'Desa/Kelurahan',
                    'kecamatan': 'Kecamatan',
                    'kabupaten': 'Kabupaten/Kota',
                    'provinsi': 'Provinsi',
                    'kode_pos': 'Kode Pos'
                };
                return fieldNames[name] || name;
            }

            function updateChangesSummary(changes) {
                if (changes.length > 0) {
                    changesList.innerHTML = '';
                    changes.forEach(change => {
                        const li = document.createElement('li');
                        li.textContent = `${change.field}: "${change.from}" → "${change.to}"`;
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

            // Form validation
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

                if (hasChanges) {
                    const confirmMessage = 'Apakah Anda yakin ingin menyimpan perubahan data ini?';
                    if (!confirm(confirmMessage)) {
                        e.preventDefault();
                        return false;
                    }
                }
            });

            // Warning before leaving with unsaved changes
            window.addEventListener('beforeunload', function(e) {
                if (hasChanges) {
                    e.preventDefault();
                    e.returnValue =
                        'Anda memiliki perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
                    return e.returnValue;
                }
            });

            // Initial check
            trackChanges();
        });
    </script>
@endpush
