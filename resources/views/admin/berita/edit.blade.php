{{-- Edit Berita --}}
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

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
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

        /* Image Upload */
        .image-upload-container {
            border: 2px dashed rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            background: var(--cream);
        }

        .image-upload-container:hover {
            border-color: var(--accent-orange);
            background: rgba(255, 140, 66, 0.05);
        }

        .image-preview {
            max-width: 200px;
            max-height: 200px;
            border-radius: 12px;
            margin: 15px auto;
            display: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .current-image {
            max-width: 200px;
            max-height: 200px;
            border-radius: 12px;
            margin: 15px auto;
            display: block;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .upload-icon {
            font-size: 3rem;
            color: var(--accent-orange);
            margin-bottom: 15px;
        }

        .upload-text {
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 10px;
        }

        [data-theme="dark"] .upload-text {
            color: var(--light-green);
        }

        /* Tags Input */
        .tags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 8px;
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            background: var(--warm-white);
            min-height: 48px;
            align-items: center;
        }

        .tag-item {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .tag-remove {
            background: none;
            border: none;
            color: white;
            font-size: 0.8rem;
            cursor: pointer;
            padding: 0;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .tag-remove:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .tag-input {
            border: none;
            outline: none;
            background: transparent;
            flex: 1;
            min-width: 100px;
            font-size: 0.9rem;
        }

        /* Publishing Options */
        .publishing-options {
            background: var(--cream);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .options-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .option-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            border: 2px solid rgba(0, 0, 0, 0.2);
        }

        .form-check-input:checked {
            background-color: var(--accent-orange);
            border-color: var(--accent-orange);
        }

        .form-check-label {
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 0;
        }

        [data-theme="dark"] .form-check-label {
            color: var(--light-green);
        }

        /* Character Counter */
        .char-counter {
            text-align: right;
            font-size: 0.75rem;
            color: var(--soft-gray);
            margin-top: 5px;
        }

        .char-counter.warning {
            color: var(--accent-orange);
        }

        .char-counter.danger {
            color: #dc3545;
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
            flex-wrap: wrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            min-width: 140px;
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

        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            min-width: 140px;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            border: none;
            border-radius: 12px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            min-width: 120px;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 140, 66, 0.3);
        }

        /* Status Badge */
        .current-status {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .status-published {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .status-draft {
            background: rgba(255, 140, 66, 0.1);
            color: var(--accent-orange);
            border: 1px solid rgba(255, 140, 66, 0.3);
        }

        .status-archived {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
            border: 1px solid rgba(108, 117, 125, 0.3);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn-primary,
            .btn-outline-secondary,
            .btn-success,
            .btn-warning {
                width: 100%;
            }

            .options-grid {
                grid-template-columns: 1fr;
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
    </style>
@endpush

@section('content')
    <div class="dashboard-content">
        <!-- Page Header -->
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Konten</li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.berita.index') }}">Kelola Berita</a></li>
                    <li class="breadcrumb-item active">Edit Berita</li>
                </ol>
            </nav>
            <h1 class="page-title">Edit Berita</h1>
            <p class="page-subtitle">Perbarui informasi berita <strong>{{ $berita->judul }}</strong></p>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Main Form -->
        <div class="form-container">
            <div class="form-header">
                <div class="form-icon">
                    <i class="bi bi-pencil-fill"></i>
                </div>
                <h2 class="form-title">Form Edit Berita</h2>
                <p class="form-subtitle">Perbarui informasi berita dengan data yang akurat</p>

                <!-- Current Status -->
                <div class="current-status status-{{ $berita->status }}">
                    <i class="bi bi-circle-fill me-2"></i>
                    Status: {{ ucfirst($berita->status) }}
                    @if ($berita->is_featured)
                        <i class="bi bi-star-fill ms-2 text-warning"></i>
                    @endif
                </div>
            </div>

            <form action="{{ route('admin.berita.update', $berita->slug) }}" method="POST" enctype="multipart/form-data"
                novalidate id="editForm">
                @csrf
                @method('PUT')

                <!-- Section 1: Informasi Dasar -->
                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-info-circle"></i>
                        </div>
                        Informasi Dasar
                    </h4>

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="judul" class="form-label">
                                Judul Berita <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul"
                                name="judul" value="{{ old('judul', $berita->judul) }}" maxlength="255" required>
                            <div class="char-counter">
                                <span id="judulCounter">{{ strlen($berita->judul) }}</span>/255 karakter
                            </div>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="slug" class="form-label">
                                Slug URL
                            </label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                                name="slug" value="{{ old('slug', $berita->slug) }}" maxlength="255">
                            <div class="form-text">Kosongkan untuk generate otomatis dari judul</div>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="kategori" class="form-label">
                                Kategori <span class="required">*</span>
                            </label>
                            <select class="form-select @error('kategori') is-invalid @enderror" id="kategori"
                                name="kategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategoriList as $kategori)
                                    <option value="{{ $kategori->slug }}"
                                        {{ old('kategori', $berita->kategori) == $kategori->slug ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="excerpt" class="form-label">
                                Ringkasan/Excerpt
                            </label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" id="excerpt" name="excerpt" rows="3"
                                maxlength="500">{{ old('excerpt', $berita->excerpt) }}</textarea>
                            <div class="char-counter">
                                <span id="excerptCounter">{{ strlen($berita->excerpt ?? '') }}</span>/500 karakter
                            </div>
                            <div class="form-text">Ringkasan singkat yang akan ditampilkan di halaman utama</div>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Konten -->
                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-file-text"></i>
                        </div>
                        Konten Berita
                    </h4>

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="konten" class="form-label">
                                Konten <span class="required">*</span>
                            </label>
                            <textarea class="form-control @error('konten') is-invalid @enderror" id="konten" name="konten" rows="15"
                                required>{{ old('konten', $berita->konten) }}</textarea>
                            <div class="form-text">Tulis konten berita lengkap dengan format yang menarik</div>
                            @error('konten')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 3: Media -->
                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-image"></i>
                        </div>
                        Gambar Utama
                    </h4>

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="gambar" class="form-label">
                                Upload Gambar Baru
                            </label>

                            @if ($berita->gambar)
                                <div class="mb-3">
                                    <p class="form-text mb-2">Gambar saat ini:</p>
                                    <img src="{{ $berita->gambar_url }}" alt="Current Image" class="current-image">
                                </div>
                            @endif

                            <div class="image-upload-container">
                                <div class="upload-icon">
                                    <i class="bi bi-cloud-upload"></i>
                                </div>
                                <div class="upload-text">Klik atau drag gambar ke sini</div>
                                <div class="form-text">Format: JPG, PNG, WEBP (Max: 2MB)</div>
                                <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                                    id="gambar" name="gambar" accept=".jpg,.jpeg,.png,.webp" style="display: none;"
                                    onchange="previewImage(this)">
                                <img id="imagePreview" class="image-preview" alt="Preview">
                            </div>
                            @error('gambar')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 4: Metadata -->
                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-tags"></i>
                        </div>
                        Metadata & Tags
                    </h4>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="penulis" class="form-label">
                                Penulis <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('penulis') is-invalid @enderror"
                                id="penulis" name="penulis" value="{{ old('penulis', $berita->penulis) }}"
                                maxlength="255" required>
                            @error('penulis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="published_at" class="form-label">
                                Tanggal Publikasi
                            </label>
                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                                id="published_at" name="published_at"
                                value="{{ old('published_at', $berita->published_at ? $berita->published_at->format('Y-m-d\TH:i') : '') }}">
                            <div class="form-text">Kosongkan untuk set otomatis saat publish</div>
                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="tags" class="form-label">
                                Tags
                            </label>
                            <input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags"
                                name="tags"
                                value="{{ old('tags', is_array($berita->tags) ? implode(', ', $berita->tags) : '') }}"
                                placeholder="Pisahkan dengan koma (,)">
                            <div class="form-text">Contoh: kesehatan, pendidikan, ekonomi</div>
                            @error('tags')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 5: Publishing Options -->
                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-gear"></i>
                        </div>
                        Opsi Publikasi
                    </h4>

                    <div class="publishing-options">
                        <div class="options-grid">
                            <div class="option-item">
                                <label for="status" class="form-label">Status Publikasi</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="draft"
                                        {{ old('status', $berita->status) == 'draft' ? 'selected' : '' }}>
                                        Draft
                                    </option>
                                    <option value="published"
                                        {{ old('status', $berita->status) == 'published' ? 'selected' : '' }}>
                                        Published
                                    </option>
                                    <option value="archived"
                                        {{ old('status', $berita->status) == 'archived' ? 'selected' : '' }}>
                                        Archived
                                    </option>
                                </select>
                            </div>

                            <div class="option-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured"
                                        value="1" {{ old('is_featured', $berita->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        <i class="bi bi-star me-2"></i>
                                        Jadikan Featured
                                    </label>
                                </div>
                                <div class="form-text">Berita akan ditampilkan di area khusus</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" name="action" value="update">
                        <i class="bi bi-check-lg me-2"></i>
                        Update Berita
                    </button>
                    <button type="submit" class="btn btn-success" name="action" value="update_and_publish"
                        style="display: {{ $berita->status != 'published' ? 'inline-block' : 'none' }}">
                        <i class="bi bi-send me-2"></i>
                        Update & Publish
                    </button>
                    <a href="{{ route('admin.berita.show', $berita->slug) }}" class="btn btn-warning">
                        <i class="bi bi-eye me-2"></i>
                        Preview
                    </a>
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Character counters
            initCharacterCounters();

            // Image upload
            initImageUpload();

            // Slug generator
            initSlugGenerator();

            // Form validation
            initFormValidation();
        });

        function initCharacterCounters() {
            const judul = document.getElementById('judul');
            const excerpt = document.getElementById('excerpt');
            const judulCounter = document.getElementById('judulCounter');
            const excerptCounter = document.getElementById('excerptCounter');

            if (judul && judulCounter) {
                judul.addEventListener('input', function() {
                    const length = this.value.length;
                    judulCounter.textContent = length;
                    judulCounter.parentElement.className = length > 200 ? 'char-counter warning' :
                        length > 240 ? 'char-counter danger' : 'char-counter';
                });
            }

            if (excerpt && excerptCounter) {
                excerpt.addEventListener('input', function() {
                    const length = this.value.length;
                    excerptCounter.textContent = length;
                    excerptCounter.parentElement.className = length > 400 ? 'char-counter warning' :
                        length > 450 ? 'char-counter danger' : 'char-counter';
                });
            }
        }

        function initImageUpload() {
            const container = document.querySelector('.image-upload-container');
            const input = document.getElementById('gambar');

            if (container && input) {
                container.addEventListener('click', () => input.click());

                container.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    container.style.borderColor = 'var(--accent-orange)';
                });

                container.addEventListener('dragleave', () => {
                    container.style.borderColor = 'rgba(0, 0, 0, 0.1)';
                });

                container.addEventListener('drop', (e) => {
                    e.preventDefault();
                    container.style.borderColor = 'rgba(0, 0, 0, 0.1)';
                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        input.files = files;
                        previewImage(input);
                    }
                });
            }
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                const preview = document.getElementById('imagePreview');

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        function initSlugGenerator() {
            const judulInput = document.getElementById('judul');
            const slugInput = document.getElementById('slug');

            if (judulInput && slugInput) {
                judulInput.addEventListener('input', function() {
                    if (!slugInput.value || slugInput.dataset.auto !== 'false') {
                        const slug = this.value
                            .toLowerCase()
                            .trim()
                            .replace(/[^a-z0-9\s-]/g, '')
                            .replace(/\s+/g, '-')
                            .replace(/-+/g, '-');
                        slugInput.value = slug;
                    }
                });

                slugInput.addEventListener('input', function() {
                    this.dataset.auto = 'false';
                });
            }
        }

        function initFormValidation() {
            const form = document.getElementById('editForm');

            if (form) {
                form.addEventListener('submit', function(e) {
                    const judul = document.getElementById('judul').value.trim();
                    const konten = document.getElementById('konten').value.trim();
                    const kategori = document.getElementById('kategori').value;
                    const penulis = document.getElementById('penulis').value.trim();

                    if (!judul || !konten || !kategori || !penulis) {
                        e.preventDefault();
                        alert('Mohon lengkapi semua field yang wajib diisi!');
                        return false;
                    }

                    // Show loading state
                    const submitBtn = form.querySelector('button[type="submit"]:focus') ||
                        form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';
                    }
                });
            }
        }

        // Auto-hide alerts
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
@endpush
