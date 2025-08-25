{{-- Create Kategori Berita --}}
@extends('layouts.main')

@push('style')
    <style>
        /* Create Form Styles */
        .page-header {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 10px;
        }

        [data-theme="dark"] .page-title {
            color: var(--light-green);
        }

        .page-subtitle {
            color: var(--soft-gray);
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
            font-size: 0.9rem;
        }

        .breadcrumb-item a {
            color: var(--primary-green);
            text-decoration: none;
        }

        [data-theme="dark"] .breadcrumb-item a {
            color: var(--light-green);
        }

        .breadcrumb-item.active {
            color: var(--soft-gray);
        }

        /* Form Container */
        .form-container {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Form Sections */
        .form-section {
            margin-bottom: 35px;
            padding: 25px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 15px;
            background: var(--cream);
            transition: all 0.3s ease;
        }

        .form-section:hover {
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid rgba(0, 0, 0, 0.1);
        }

        [data-theme="dark"] .section-title {
            color: var(--light-green);
        }

        .section-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
        }

        /* Form Controls */
        .form-label {
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        [data-theme="dark"] .form-label {
            color: var(--light-green);
        }

        .required {
            color: #dc3545;
            margin-left: 3px;
        }

        .form-control,
        .form-select,
        .form-textarea {
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 12px 16px;
            transition: all 0.3s ease;
            background: var(--warm-white);
            color: inherit;
            font-size: 0.95rem;
        }

        .form-control:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: var(--accent-orange);
            box-shadow: 0 0 0 0.2rem rgba(255, 140, 66, 0.25);
            background: var(--warm-white);
        }

        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select,
        [data-theme="dark"] .form-textarea {
            background: var(--warm-white);
            border-color: rgba(255, 255, 255, 0.2);
            color: #333;
        }

        .form-text {
            color: var(--soft-gray);
            font-size: 0.85rem;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Color Picker */
        .color-picker-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .color-input {
            width: 60px;
            height: 45px;
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .color-input:hover {
            transform: scale(1.05);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .color-preview {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .color-sample {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: 2px solid rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        /* Icon Selector */
        .icon-selector {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(50px, 1fr));
            gap: 10px;
            max-height: 200px;
            overflow-y: auto;
            padding: 15px;
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            background: var(--warm-white);
        }

        .icon-option {
            width: 50px;
            height: 50px;
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: var(--warm-white);
            font-size: 1.2rem;
            color: var(--primary-green);
        }

        .icon-option:hover {
            border-color: var(--accent-orange);
            background: var(--cream);
            transform: scale(1.05);
        }

        .icon-option.selected {
            border-color: var(--accent-orange);
            background: var(--accent-orange);
            color: white;
        }

        [data-theme="dark"] .icon-option {
            color: var(--light-green);
        }

        /* Preview Section */
        .preview-section {
            background: var(--warm-white);
            border: 2px dashed rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
        }

        .kategori-preview {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            color: white;
            margin-bottom: 10px;
        }

        .preview-text {
            color: var(--soft-gray);
            font-size: 0.9rem;
        }

        /* Input Groups */
        .input-group-kategori {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .input-group-display {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            align-items: start;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px;
            background: var(--cream);
            border-radius: 15px;
            margin-top: 30px;
            gap: 15px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45, 80, 22, 0.3);
        }

        .btn-outline-secondary {
            color: var(--soft-gray);
            border: 2px solid var(--soft-gray);
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            background: transparent;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background: var(--soft-gray);
            border-color: var(--soft-gray);
            color: white;
            transform: translateY(-2px);
        }

        /* Switch Toggle */
        .form-switch {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .form-switch .form-check-input {
            width: 50px;
            height: 25px;
            border-radius: 15px;
            border: 2px solid rgba(0, 0, 0, 0.2);
            background: rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .form-switch .form-check-input:checked {
            background-color: var(--accent-orange);
            border-color: var(--accent-orange);
        }

        .form-switch .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(255, 140, 66, 0.25);
        }

        /* Validation Styles */
        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.85rem;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .is-valid {
            border-color: #28a745;
        }

        .valid-feedback {
            color: #28a745;
            font-size: 0.85rem;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Alert Messages */
        .alert {
            border: none;
            border-radius: 15px;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-left: 4px solid;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            border-left-color: #dc3545;
            color: #721c24;
        }

        .alert-warning {
            background: rgba(255, 193, 7, 0.1);
            border-left-color: #ffc107;
            color: #856404;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            .form-section {
                padding: 20px;
            }

            .input-group-kategori,
            .input-group-display {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .form-actions {
                flex-direction: column;
                gap: 10px;
            }

            .form-actions .btn {
                width: 100%;
            }

            .color-picker-wrapper {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .icon-selector {
                grid-template-columns: repeat(auto-fill, minmax(45px, 1fr));
                gap: 8px;
            }

            .icon-option {
                width: 45px;
                height: 45px;
                font-size: 1.1rem;
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
                    <li class="breadcrumb-item">Berita & Info</li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.kategori-berita.index') }}">Kategori Berita</a>
                    </li>
                    <li class="breadcrumb-item active">Buat Kategori</li>
                </ol>
            </nav>
            <h1 class="page-title">Buat Kategori Berita</h1>
            <p class="page-subtitle">Tambahkan kategori baru untuk mengorganisir berita</p>
        </div>

        <!-- Alert Messages -->
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Terdapat kesalahan pada form:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Container -->
        <div class="form-container">
            <form action="{{ route('admin.kategori-berita.store') }}" method="POST" id="kategoriForm">
                @csrf

                <!-- Section 1: Informasi Dasar -->
                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-info-circle"></i>
                        </div>
                        Informasi Dasar Kategori
                    </h4>

                    <div class="input-group-kategori">
                        <div class="mb-3">
                            <label for="nama" class="form-label">
                                Nama Kategori <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                name="nama" value="{{ old('nama') }}"
                                placeholder="Contoh: Pengumuman, Berita Desa, Event" required maxlength="255">
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Nama kategori akan ditampilkan pada daftar berita
                            </div>
                            @error('nama')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">
                                Slug URL
                            </label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                name="slug" value="{{ old('slug') }}" placeholder="pengumuman-desa (opsional)"
                                maxlength="255">
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Kosongkan untuk generate otomatis dari nama kategori
                            </div>
                            @error('slug')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">
                            Deskripsi Kategori
                        </label>
                        <textarea class="form-control form-textarea @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi"
                            rows="4" placeholder="Deskripsi singkat tentang kategori ini..." maxlength="500">{{ old('deskripsi') }}</textarea>
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Maksimal 500 karakter. Deskripsi akan ditampilkan sebagai keterangan kategori
                        </div>
                        @error('deskripsi')
                            <div class="invalid-feedback">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="input-group-kategori">
                        <div class="mb-3">
                            <label for="urutan" class="form-label">
                                Urutan Tampilan <span class="required">*</span>
                            </label>
                            <input type="number" class="form-control @error('urutan') is-invalid @enderror" id="urutan"
                                name="urutan" value="{{ old('urutan', $nextUrutan) }}" min="0" max="999"
                                required>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Angka kecil akan tampil lebih dulu. Urutan berikutnya: {{ $nextUrutan }}
                            </div>
                            @error('urutan')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Status Kategori
                            </label>
                            <div class="form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active"
                                    name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    <span id="statusLabel">Kategori Aktif</span>
                                </label>
                            </div>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Hanya kategori aktif yang dapat digunakan untuk berita
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Tampilan & Visual -->
                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-palette"></i>
                        </div>
                        Tampilan & Visual
                    </h4>

                    <div class="input-group-display">
                        <div>
                            <div class="mb-3">
                                <label for="warna" class="form-label">
                                    Warna Kategori <span class="required">*</span>
                                </label>
                                <div class="color-picker-wrapper">
                                    <input type="color" class="color-input @error('warna') is-invalid @enderror"
                                        id="warna" name="warna" value="{{ old('warna', '#4a7c59') }}" required>
                                    <div class="color-preview">
                                        <div class="color-sample" id="colorSample"
                                            style="background-color: {{ old('warna', '#4a7c59') }};">
                                            <i class="bi bi-tag" id="iconPreview"></i>
                                        </div>
                                        <div>
                                            <div class="form-text mb-0">Preview warna kategori</div>
                                            <small class="text-muted"
                                                id="colorCode">{{ old('warna', '#4a7c59') }}</small>
                                        </div>
                                    </div>
                                </div>
                                @error('warna')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="icon" class="form-label">
                                    Ikon Kategori
                                </label>
                                <input type="hidden" id="icon" name="icon"
                                    value="{{ old('icon', 'bi bi-tag') }}">
                                <div class="icon-selector" id="iconSelector">
                                    @php
                                        $icons = [
                                            'fas fa-tag',
                                            'fas fa-newspaper',
                                            'fas fa-bullhorn',
                                            'fas fa-info-circle',
                                            'fas fa-calendar-day',
                                            'fas fa-users',
                                            'fas fa-home',
                                            'fas fa-map-marker-alt',
                                            'fas fa-briefcase',
                                            'fas fa-heart',
                                            'fas fa-star',
                                            'fas fa-trophy',
                                            'fas fa-camera',
                                            'fas fa-music',
                                            'fas fa-book',
                                            'fas fa-lightbulb',
                                            'fas fa-shield-alt',
                                            'fas fa-tools',
                                            'fas fa-tree',
                                            'fas fa-seedling',
                                            'fas fa-sun',
                                            'fas fa-moon',
                                            'fas fa-cloud',
                                            'fas fa-fire',
                                            'fas fa-tint',
                                            'fas fa-mountain',
                                            'fas fa-building',
                                            'fas fa-hospital',
                                            'fas fa-university',
                                            'fas fa-store',
                                            'fas fa-truck',
                                            'fas fa-plane',
                                        ];
                                    @endphp
                                    @foreach ($icons as $iconClass)
                                        <div class="icon-option {{ old('icon', 'bi bi-tag') == $iconClass ? 'selected' : '' }}"
                                            data-icon="{{ $iconClass }}">
                                            <i class="{{ $iconClass }}"></i>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Pilih ikon yang mewakili kategori ini
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="form-label">Preview Kategori</label>
                            <div class="preview-section">
                                <div class="kategori-preview" id="kategoriPreview"
                                    style="background-color: {{ old('warna', '#4a7c59') }};">
                                    <i class="{{ old('icon', 'bi bi-tag') }}" id="previewIcon"></i>
                                    <span id="previewName">{{ old('nama', 'Nama Kategori') }}</span>
                                </div>
                                <div class="preview-text">
                                    Begini tampilan kategori di website
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('admin.kategori-berita.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                            <i class="bi bi-arrow-clockwise me-2"></i>Reset Form
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>Simpan Kategori
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initKategoriForm();
        });

        function initKategoriForm() {
            initSlugGeneration();
            initColorPicker();
            initIconSelector();
            initPreviewUpdater();
            initStatusToggle();
            initFormValidation();
        }

        // Auto generate slug from nama
        function initSlugGeneration() {
            const namaInput = document.getElementById('nama');
            const slugInput = document.getElementById('slug');

            namaInput.addEventListener('input', function() {
                if (!slugInput.dataset.userModified) {
                    const slug = generateSlug(this.value);
                    slugInput.value = slug;
                }
                updatePreview();
            });

            slugInput.addEventListener('input', function() {
                this.dataset.userModified = 'true';
            });
        }

        function generateSlug(text) {
            return text
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
        }

        // Color picker functionality
        function initColorPicker() {
            const colorInput = document.getElementById('warna');
            const colorSample = document.getElementById('colorSample');
            const colorCode = document.getElementById('colorCode');

            colorInput.addEventListener('input', function() {
                const color = this.value;
                colorSample.style.backgroundColor = color;
                colorCode.textContent = color;
                updatePreview();
            });
        }

        // Icon selector functionality
        function initIconSelector() {
            const iconOptions = document.querySelectorAll('.icon-option');
            const iconInput = document.getElementById('icon');

            iconOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove selected class from all options
                    iconOptions.forEach(opt => opt.classList.remove('selected'));

                    // Add selected class to clicked option
                    this.classList.add('selected');

                    // Update hidden input
                    const iconClass = this.dataset.icon;
                    iconInput.value = iconClass;

                    // Update preview
                    updateIconPreview(iconClass);
                });
            });
        }

        function updateIconPreview(iconClass) {
            const iconPreview = document.getElementById('iconPreview');
            const previewIcon = document.getElementById('previewIcon');

            // Update preview icons
            iconPreview.className = iconClass;
            previewIcon.className = iconClass;
        }

        // Preview updater
        function initPreviewUpdater() {
            const namaInput = document.getElementById('nama');

            namaInput.addEventListener('input', updatePreview);

            // Initial preview update
            updatePreview();
        }

        function updatePreview() {
            const nama = document.getElementById('nama').value || 'Nama Kategori';
            const warna = document.getElementById('warna').value;
            const icon = document.getElementById('icon').value;

            const previewName = document.getElementById('previewName');
            const kategoriPreview = document.getElementById('kategoriPreview');
            const previewIcon = document.getElementById('previewIcon');

            previewName.textContent = nama;
            kategoriPreview.style.backgroundColor = warna;
            previewIcon.className = icon;
        }

        // Status toggle
        function initStatusToggle() {
            const statusToggle = document.getElementById('is_active');
            const statusLabel = document.getElementById('statusLabel');

            statusToggle.addEventListener('change', function() {
                statusLabel.textContent = this.checked ? 'Kategori Aktif' : 'Kategori Non-Aktif';
            });
        }

        // Form validation
        function initFormValidation() {
            const form = document.getElementById('kategoriForm');

            form.addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    return false;
                }

                // Add loading state to submit button
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';
                submitBtn.disabled = true;

                // Reset button if form submission fails
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 3000);
            });
        }

        function validateForm() {
            let isValid = true;

            // Validate required fields
            const requiredFields = ['nama', 'warna', 'urutan'];

            requiredFields.forEach(fieldName => {
                const field = document.getElementById(fieldName);
                const value = field.value.trim();

                if (!value) {
                    showFieldError(field, 'Field ini wajib diisi');
                    isValid = false;
                } else {
                    clearFieldError(field);
                }
            });

            // Validate specific fields
            const namaField = document.getElementById('nama');
            if (namaField.value.length > 255) {
                showFieldError(namaField, 'Nama kategori maksimal 255 karakter');
                isValid = false;
            }

            const deskripsiField = document.getElementById('deskripsi');
            if (deskripsiField.value.length > 500) {
                showFieldError(deskripsiField, 'Deskripsi maksimal 500 karakter');
                isValid = false;
            }

            const urutanField = document.getElementById('urutan');
            const urutanValue = parseInt(urutanField.value);
            if (isNaN(urutanValue) || urutanValue < 0 || urutanValue > 999) {
                showFieldError(urutanField, 'Urutan harus antara 0-999');
                isValid = false;
            }

            const warnaField = document.getElementById('warna');
            const warnaPattern = /^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/;
            if (!warnaPattern.test(warnaField.value)) {
                showFieldError(warnaField, 'Format warna tidak valid');
                isValid = false;
            }

            return isValid;
        }

        function showFieldError(field, message) {
            field.classList.add('is-invalid');
            field.classList.remove('is-valid');

            // Remove existing dynamic error message (not server validation)
            const existingError = field.parentNode.querySelector('.invalid-feedback.dynamic-error');
            if (existingError) {
                existingError.remove();
            }

            // Add new error message if not from server validation
            if (!field.parentNode.querySelector('.invalid-feedback:not(.dynamic-error)')) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback dynamic-error';
                errorDiv.innerHTML = `<i class="bi bi-exclamation-circle me-1"></i>${message}`;
                field.parentNode.appendChild(errorDiv);
            }
        }

        function clearFieldError(field) {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');

            // Remove only dynamic error messages (keep server validation messages)
            const dynamicError = field.parentNode.querySelector('.invalid-feedback.dynamic-error');
            if (dynamicError) {
                dynamicError.remove();
            }
        }

        // Reset form function
        function resetForm() {
            if (confirm('Yakin ingin reset form? Semua data yang telah diisi akan hilang.')) {
                const form = document.getElementById('kategoriForm');
                form.reset();

                // Reset preview
                document.getElementById('previewName').textContent = 'Nama Kategori';
                document.getElementById('kategoriPreview').style.backgroundColor = '#4a7c59';
                document.getElementById('previewIcon').className = 'bi bi-tag';
                document.getElementById('iconPreview').className = 'bi bi-tag';

                // Reset color sample
                document.getElementById('colorSample').style.backgroundColor = '#4a7c59';
                document.getElementById('colorCode').textContent = '#4a7c59';

                // Reset icon selection
                document.querySelectorAll('.icon-option').forEach(opt => opt.classList.remove('selected'));
                document.querySelector('.icon-option[data-icon="bi bi-tag"]').classList.add('selected');

                // Reset status label
                document.getElementById('statusLabel').textContent = 'Kategori Aktif';

                // Clear validation states
                document.querySelectorAll('.form-control, .form-select, .form-textarea').forEach(field => {
                    field.classList.remove('is-valid', 'is-invalid');
                });

                // Remove dynamic error messages
                document.querySelectorAll('.invalid-feedback.dynamic-error').forEach(error => {
                    error.remove();
                });

                // Reset user modified flag for slug
                document.getElementById('slug').removeAttribute('data-user-modified');
            }
        }

        // Real-time validation
        document.getElementById('nama').addEventListener('blur', function() {
            if (this.value.trim()) {
                clearFieldError(this);
            }
        });

        document.getElementById('warna').addEventListener('blur', function() {
            const warnaPattern = /^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/;
            if (warnaPattern.test(this.value)) {
                clearFieldError(this);
            }
        });

        document.getElementById('urutan').addEventListener('blur', function() {
            const value = parseInt(this.value);
            if (!isNaN(value) && value >= 0 && value <= 999) {
                clearFieldError(this);
            }
        });

        // Character counter for textarea
        const deskripsiField = document.getElementById('deskripsi');
        const deskripsiCounter = document.createElement('div');
        deskripsiCounter.className = 'form-text text-end';
        deskripsiCounter.style.marginTop = '5px';
        deskripsiField.parentNode.appendChild(deskripsiCounter);

        function updateCharCounter() {
            const current = deskripsiField.value.length;
            const max = 500;
            deskripsiCounter.innerHTML = `${current}/${max} karakter`;

            if (current > max) {
                deskripsiCounter.style.color = '#dc3545';
                showFieldError(deskripsiField, 'Deskripsi maksimal 500 karakter');
            } else {
                deskripsiCounter.style.color = 'var(--soft-gray)';
                if (current > 0) {
                    clearFieldError(deskripsiField);
                }
            }
        }

        deskripsiField.addEventListener('input', updateCharCounter);
        updateCharCounter(); // Initial count

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl+S or Cmd+S to save
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                document.getElementById('kategoriForm').submit();
            }

            // Ctrl+R or Cmd+R to reset (with confirmation)
            if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
                e.preventDefault();
                resetForm();
            }
        });

        // Auto-save draft functionality (optional)
        let autoSaveTimer;
        const formFields = document.querySelectorAll('#kategoriForm input, #kategoriForm textarea, #kategoriForm select');

        formFields.forEach(field => {
            field.addEventListener('input', function() {
                clearTimeout(autoSaveTimer);
                autoSaveTimer = setTimeout(saveDraft, 2000); // Save after 2 seconds of inactivity
            });
        });

        function saveDraft() {
            const formData = new FormData(document.getElementById('kategoriForm'));
            const draftData = {};

            for (let [key, value] of formData.entries()) {
                draftData[key] = value;
            }

            localStorage.setItem('kategori_draft', JSON.stringify(draftData));

            // Show subtle notification
            const notification = document.createElement('div');
            notification.textContent = 'Draft tersimpan';
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: var(--accent-orange);
                color: white;
                padding: 8px 16px;
                border-radius: 6px;
                font-size: 0.9rem;
                z-index: 9999;
                opacity: 0;
                transition: opacity 0.3s ease;
            `;

            document.body.appendChild(notification);
            setTimeout(() => notification.style.opacity = '1', 100);
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(), 300);
            }, 2000);
        }

        // Load draft on page load
        function loadDraft() {
            const draft = localStorage.getItem('kategori_draft');
            if (draft && confirm('Ditemukan draft yang tersimpan. Ingin memuat draft tersebut?')) {
                const draftData = JSON.parse(draft);

                Object.keys(draftData).forEach(key => {
                    const field = document.querySelector(`[name="${key}"]`);
                    if (field) {
                        if (field.type === 'checkbox') {
                            field.checked = draftData[key] === '1';
                        } else {
                            field.value = draftData[key];
                        }
                    }
                });

                // Update preview and other UI elements
                updatePreview();
                updateCharCounter();

                // Update icon selection
                const selectedIcon = draftData.icon || 'bi bi-tag';
                document.querySelectorAll('.icon-option').forEach(opt => {
                    opt.classList.toggle('selected', opt.dataset.icon === selectedIcon);
                });

                // Update color preview
                const warna = draftData.warna || '#4a7c59';
                document.getElementById('colorSample').style.backgroundColor = warna;
                document.getElementById('colorCode').textContent = warna;

                // Update status label
                const isActive = draftData.is_active === '1';
                document.getElementById('statusLabel').textContent = isActive ? 'Kategori Aktif' : 'Kategori Non-Aktif';
            }
        }

        // Clear draft when form is successfully submitted
        window.addEventListener('beforeunload', function() {
            // Only clear draft if form was submitted successfully
            if (document.querySelector('.alert-success')) {
                localStorage.removeItem('kategori_draft');
            }
        });

        // Load draft after DOM is ready
        setTimeout(loadDraft, 500);
    </script>
@endpush
