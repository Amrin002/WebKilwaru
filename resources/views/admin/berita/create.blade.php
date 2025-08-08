{{-- Create Berita dengan Summernote - Fixed --}}
@extends('layouts.main')

@push('style')
    <style>
        /* Semua CSS yang sudah ada tetap sama... */
        /* Copy semua style dari dokumen sebelumnya */

        /* Create Berita Styles */
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

        .form-section {
            margin-bottom: 30px;
        }

        .form-section-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--cream);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        [data-theme="dark"] .form-section-title {
            color: var(--light-green);
        }

        /* Form Elements */
        .form-label {
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        [data-theme="dark"] .form-label {
            color: var(--light-green);
        }

        .form-label.required::after {
            content: '*';
            color: #dc3545;
            margin-left: 3px;
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
            outline: none;
        }

        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background: var(--warm-white);
            border-color: rgba(255, 255, 255, 0.2);
            color: #333;
        }

        .form-text {
            font-size: 0.85rem;
            color: var(--soft-gray);
            margin-top: 5px;
        }

        /* Summernote Custom Styles */
        .note-editor {
            border: 2px solid rgba(0, 0, 0, 0.1) !important;
            border-radius: 12px !important;
            overflow: hidden;
        }

        .note-editor.note-frame {
            border: 2px solid rgba(0, 0, 0, 0.1) !important;
        }

        .note-editor.note-frame.codeview {
            border: 2px solid rgba(0, 0, 0, 0.1) !important;
        }

        .note-toolbar {
            background: var(--cream) !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
            border-radius: 0 !important;
            padding: 10px 15px !important;
        }

        .note-btn-group .note-btn {
            background: transparent !important;
            border: 1px solid rgba(0, 0, 0, 0.2) !important;
            border-radius: 6px !important;
            margin: 2px !important;
            color: var(--primary-green) !important;
            padding: 6px 10px !important;
            font-size: 0.9rem !important;
        }

        .note-btn-group .note-btn:hover {
            background: var(--primary-green) !important;
            color: white !important;
        }

        .note-btn-group .note-btn.active {
            background: var(--accent-orange) !important;
            color: white !important;
            border-color: var(--accent-orange) !important;
        }

        [data-theme="dark"] .note-btn-group .note-btn {
            color: var(--light-green) !important;
        }

        .note-editable {
            background: var(--warm-white) !important;
            color: inherit !important;
            min-height: 300px !important;
            padding: 20px !important;
            line-height: 1.6 !important;
            font-size: 0.95rem !important;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
        }

        .note-statusbar {
            background: var(--cream) !important;
            border-top: 1px solid rgba(0, 0, 0, 0.1) !important;
        }

        /* Image Upload */
        .image-upload-container {
            border: 2px dashed rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            background: var(--cream);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .image-upload-container:hover {
            border-color: var(--accent-orange);
            background: rgba(255, 140, 66, 0.1);
        }

        .image-upload-container.dragover {
            border-color: var(--accent-orange);
            background: rgba(255, 140, 66, 0.15);
            transform: scale(1.02);
        }

        .upload-icon {
            font-size: 3rem;
            color: var(--soft-gray);
            margin-bottom: 15px;
        }

        .upload-text {
            color: var(--primary-green);
            font-weight: 600;
            margin-bottom: 5px;
        }

        [data-theme="dark"] .upload-text {
            color: var(--light-green);
        }

        .upload-subtext {
            color: var(--soft-gray);
            font-size: 0.85rem;
        }

        .image-preview {
            max-width: 100%;
            max-height: 300px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-top: 15px;
        }

        .image-preview-container {
            position: relative;
            display: inline-block;
        }

        .remove-image {
            position: absolute;
            top: -10px;
            right: -10px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
            transition: all 0.3s ease;
        }

        .remove-image:hover {
            background: #c82333;
            transform: scale(1.1);
        }

        /* Tags Input */
        .tags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            min-height: 45px;
            padding: 10px;
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            background: var(--warm-white);
            align-items: flex-start;
            cursor: text;
        }

        .tags-container:focus-within {
            border-color: var(--accent-orange);
            box-shadow: 0 0 0 0.2rem rgba(255, 140, 66, 0.25);
        }

        .tag-item {
            background: var(--primary-green);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 6px;
            animation: tagAppear 0.3s ease;
        }

        .tag-remove {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 0.8rem;
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
            padding: 5px;
            flex: 1;
            min-width: 100px;
            background: transparent;
            color: inherit;
        }

        @keyframes tagAppear {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            padding-top: 20px;
            border-top: 2px solid var(--cream);
            margin-top: 30px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45, 80, 22, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #8e9297);
            border: none;
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
        }

        .btn-outline-primary {
            color: var(--primary-green);
            border: 2px solid var(--primary-green);
            border-radius: 12px;
            padding: 10px 25px;
            font-weight: 600;
            background: transparent;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--primary-green);
            border-color: var(--primary-green);
            transform: translateY(-2px);
        }

        [data-theme="dark"] .btn-outline-primary {
            color: var(--light-green);
            border-color: var(--light-green);
        }

        [data-theme="dark"] .btn-outline-primary:hover {
            background: var(--light-green);
            border-color: var(--light-green);
            color: var(--primary-green);
        }

        /* Publishing Options */
        .publishing-options {
            background: var(--cream);
            border-radius: 15px;
            padding: 20px;
        }

        .form-check {
            margin-bottom: 15px;
        }

        .form-check-input {
            border-radius: 6px;
            border: 2px solid rgba(0, 0, 0, 0.2);
            padding: 10px;
        }

        .form-check-input:checked {
            background-color: var(--accent-orange);
            border-color: var(--accent-orange);
        }

        .form-check-label {
            font-weight: 500;
            color: var(--primary-green);
            margin-left: 10px;
        }

        [data-theme="dark"] .form-check-label {
            color: var(--light-green);
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

        .alert-info {
            background: rgba(23, 162, 184, 0.1);
            border-left-color: #17a2b8;
            color: #0c5460;
        }

        /* Validation Styles */
        .is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 5px;
            font-size: 0.85rem;
            color: #dc3545;
        }

        /* Preview Mode */
        .preview-container {
            background: var(--warm-white);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .preview-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 15px;
            line-height: 1.3;
        }

        [data-theme="dark"] .preview-title {
            color: var(--light-green);
        }

        .preview-meta {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--cream);
            font-size: 0.9rem;
            color: var(--soft-gray);
        }

        .preview-content {
            line-height: 1.8;
            font-size: 1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .tags-container {
                min-height: 40px;
                padding: 8px;
            }

            .image-upload-container {
                padding: 20px;
            }

            .upload-icon {
                font-size: 2rem;
            }

            .note-toolbar {
                padding: 8px 10px !important;
            }

            .note-btn-group .note-btn {
                padding: 5px 8px !important;
                font-size: 0.8rem !important;
            }
        }

        @media (max-width: 576px) {
            .page-header {
                padding: 20px;
            }

            .form-section-title {
                font-size: 1.1rem;
            }

            .preview-title {
                font-size: 1.5rem;
            }

            .preview-meta {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>

    <!-- Include Summernote CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@endpush

@section('content')
    <div class="dashboard-content">
        <!-- Page Header -->
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.berita.index') }}">Kelola Berita</a></li>
                    <li class="breadcrumb-item active">Tulis Berita Baru</li>
                </ol>
            </nav>
            <h1 class="page-title">Tulis Berita Baru</h1>
            <p class="page-subtitle">Buat dan publikasikan berita atau informasi terbaru untuk warga desa</p>
        </div>

        <!-- Alert Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Terdapat kesalahan:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" id="beritaForm">
            @csrf

            <div class="row">
                <!-- Main Form -->
                <div class="col-lg-8">
                    <div class="form-container">
                        <!-- Basic Information -->
                        <div class="form-section">
                            <h4 class="form-section-title">
                                <i class="bi bi-info-circle"></i>
                                Informasi Dasar
                            </h4>

                            <div class="mb-3">
                                <label for="judul" class="form-label required">Judul Berita</label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                    id="judul" name="judul" value="{{ old('judul', $duplicatedData['judul'] ?? '') }}"
                                    placeholder="Masukkan judul berita yang menarik...">
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Judul yang baik akan menarik perhatian pembaca</div>
                            </div>

                            <div class="mb-3">
                                <label for="slug" class="form-label">URL Slug</label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                    id="slug" name="slug" value="{{ old('slug', $duplicatedData['slug'] ?? '') }}"
                                    placeholder="url-berita-otomatis-dari-judul">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Kosongkan untuk membuat otomatis dari judul</div>
                            </div>

                            <div class="mb-3">
                                <label for="excerpt" class="form-label">Ringkasan Berita</label>
                                <textarea class="form-control @error('excerpt') is-invalid @enderror" id="excerpt" name="excerpt" rows="3"
                                    placeholder="Tulis ringkasan singkat berita (opsional)...">{{ old('excerpt', $duplicatedData['excerpt'] ?? '') }}</textarea>
                                @error('excerpt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Ringkasan akan muncul di daftar berita dan preview social media</div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="form-section">
                            <h4 class="form-section-title">
                                <i class="bi bi-file-text"></i>
                                Konten Berita
                            </h4>

                            <div class="mb-3">
                                <label for="konten" class="form-label required">Isi Berita</label>
                                <textarea class="form-control @error('konten') is-invalid @enderror" id="konten" name="konten"
                                    placeholder="Tulis isi berita lengkap di sini...">{{ old('konten', $duplicatedData['konten'] ?? '') }}</textarea>
                                @error('konten')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="form-section">
                            <h4 class="form-section-title">
                                <i class="bi bi-image"></i>
                                Gambar Berita
                            </h4>

                            <div class="mb-3">
                                <label for="gambar" class="form-label">Upload Gambar</label>
                                <div class="image-upload-container" id="imageUploadContainer">
                                    <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                                        id="gambar" name="gambar" accept="image/*" style="display: none;">

                                    <div id="uploadPlaceholder">
                                        <i class="bi bi-cloud-upload upload-icon"></i>
                                        <div class="upload-text">Klik atau drag & drop gambar</div>
                                        <div class="upload-subtext">Maksimal 2MB - Format: JPG, PNG, WEBP</div>
                                    </div>

                                    <div id="imagePreviewContainer" style="display: none;">
                                        <img id="imagePreview" class="image-preview" alt="Preview">
                                        <button type="button" class="remove-image" id="removeImage">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                </div>
                                @error('gambar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Meta Information -->
                        <div class="form-section">
                            <h4 class="form-section-title">
                                <i class="bi bi-tags"></i>
                                Informasi Tambahan
                            </H4>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="kategori" class="form-label required">Kategori</label>
                                        <select class="form-select @error('kategori') is-invalid @enderror" id="kategori"
                                            name="kategori">
                                            <option value="">Pilih Kategori</option>
                                            @foreach ($kategoriList as $kategori)
                                                <option value="{{ $kategori->slug }}"
                                                    {{ old('kategori', $duplicatedData['kategori'] ?? '') == $kategori->slug ? 'selected' : '' }}>
                                                    {{ $kategori->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kategori')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="penulis" class="form-label required">Penulis</label>
                                        <input type="text" class="form-control @error('penulis') is-invalid @enderror"
                                            id="penulis" name="penulis"
                                            value="{{ old('penulis', $duplicatedData['penulis'] ?? auth()->user()->name) }}"
                                            placeholder="Nama penulis berita">
                                        @error('penulis')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags</label>
                                <div class="tags-container" id="tagsContainer">
                                    <input type="text" class="tag-input" id="tagInput"
                                        placeholder="Ketik tag dan tekan Enter...">
                                </div>
                                <input type="hidden" name="tags" id="tagsHidden"
                                    value="{{ old('tags', is_array($duplicatedData['tags'] ?? null) ? implode(', ', $duplicatedData['tags']) : '') }}">
                                <div class="form-text">Tekan Enter atau koma untuk menambah tag</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="form-container">
                        <!-- Publishing Options -->
                        <div class="form-section">
                            <h4 class="form-section-title">
                                <i class="bi bi-gear"></i>
                                Pengaturan Publikasi
                            </h4>

                            <div class="publishing-options">
                                <div class="mb-3">
                                    <label for="status" class="form-label required">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status"
                                        name="status">
                                        <option value="draft"
                                            {{ old('status', $duplicatedData['status'] ?? 'draft') == 'draft' ? 'selected' : '' }}>
                                            Draft
                                        </option>
                                        <option value="published"
                                            {{ old('status', $duplicatedData['status'] ?? '') == 'published' ? 'selected' : '' }}>
                                            Terbitkan
                                        </option>
                                        <option value="archived"
                                            {{ old('status', $duplicatedData['status'] ?? '') == 'archived' ? 'selected' : '' }}>
                                            Arsip
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="published_at" class="form-label">Tanggal Publikasi</label>
                                    <input type="datetime-local"
                                        class="form-control @error('published_at') is-invalid @enderror" id="published_at"
                                        name="published_at"
                                        value="{{ old('published_at', $duplicatedData['published_at'] ?? '') }}">
                                    @error('published_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Kosongkan untuk publikasi sekarang</div>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured"
                                        value="1"
                                        {{ old('is_featured', $duplicatedData['is_featured'] ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        <i class="bi bi-star me-1"></i>
                                        Jadikan Berita Unggulan
                                    </label>
                                </div>
                                <div class="form-text">Berita unggulan akan tampil di slider utama</div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="form-section">
                            <h4 class="form-section-title">
                                <i class="bi bi-lightning"></i>
                                Aksi Cepat
                            </h4>

                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-outline-primary" id="previewBtn">
                                    <i class="bi bi-eye me-2"></i>Preview
                                </button>
                                <button type="button" class="btn btn-outline-primary" id="draftBtn">
                                    <i class="bi bi-file-text me-2"></i>Simpan Draft
                                </button>
                            </div>
                        </div>

                        <!-- Help -->
                        <div class="form-section">
                            <h4 class="form-section-title">
                                <i class="bi bi-question-circle"></i>
                                Bantuan
                            </h4>

                            <div class="alert alert-info">
                                <strong>Tips menulis berita:</strong>
                                <ul class="mb-0 mt-2">
                                    <li>Gunakan judul yang menarik dan informatif</li>
                                    <li>Tambahkan gambar yang relevan</li>
                                    <li>Gunakan paragraf pendek untuk kemudahan baca</li>
                                    <li>Sertakan informasi yang akurat dan terkini</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
                <button type="submit" class="btn btn-secondary" name="action" value="draft">
                    <i class="bi bi-file-text me-2"></i>Simpan Draft
                </button>
                <button type="submit" class="btn btn-primary" name="action" value="publish">
                    <i class="bi bi-send me-2"></i>Publikasikan
                </button>
            </div>
        </form>

        <!-- Preview Modal -->
        <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="previewModalLabel">
                            <i class="bi bi-eye me-2"></i>Preview Berita
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="preview-container">
                            <div id="previewContent">
                                <!-- Preview content will be loaded here -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Include Summernote JS -->

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    <script>
        // Wait for jQuery to be ready
        $(document).ready(function() {
            // Initialize all components
            initSlugGeneration();
            initImageUpload();
            initTagsInput();
            initSummernote();
            initFormActions();
            initPreview();

            // Auto-hide alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 8000);
            });
        });

        // Slug Generation
        function initSlugGeneration() {
            const judulInput = document.getElementById('judul');
            const slugInput = document.getElementById('slug');

            judulInput.addEventListener('input', function() {
                if (!slugInput.value || slugInput.dataset.auto !== 'false') {
                    const slug = this.value
                        .toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-')
                        .trim('-');

                    slugInput.value = slug;
                    slugInput.dataset.auto = 'true';
                }
            });

            slugInput.addEventListener('input', function() {
                this.dataset.auto = 'false';
            });
        }

        // Image Upload with Drag & Drop
        function initImageUpload() {
            const container = document.getElementById('imageUploadContainer');
            const input = document.getElementById('gambar');
            const placeholder = document.getElementById('uploadPlaceholder');
            const previewContainer = document.getElementById('imagePreviewContainer');
            const preview = document.getElementById('imagePreview');
            const removeBtn = document.getElementById('removeImage');

            // Click to upload
            container.addEventListener('click', function(e) {
                if (e.target !== removeBtn && !removeBtn.contains(e.target)) {
                    input.click();
                }
            });

            // Drag & Drop
            container.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });

            container.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
            });

            container.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');

                const files = e.dataTransfer.files;
                if (files.length > 0 && files[0].type.startsWith('image/')) {
                    input.files = files;
                    handleImagePreview(files[0]);
                }
            });

            // File input change
            input.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    handleImagePreview(this.files[0]);
                }
            });

            // Remove image
            removeBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                input.value = '';
                placeholder.style.display = 'block';
                previewContainer.style.display = 'none';
            });

            function handleImagePreview(file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    placeholder.style.display = 'none';
                    previewContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }

        // Tags Input
        function initTagsInput() {
            const container = document.getElementById('tagsContainer');
            const input = document.getElementById('tagInput');
            const hidden = document.getElementById('tagsHidden');
            let tags = [];

            // Load existing tags
            if (hidden.value) {
                tags = hidden.value.split(',').map(tag => tag.trim()).filter(tag => tag);
                renderTags();
            }

            // Add tag on Enter or comma
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ',') {
                    e.preventDefault();
                    addTag(this.value.trim());
                    this.value = '';
                }
            });

            // Add tag on blur
            input.addEventListener('blur', function() {
                if (this.value.trim()) {
                    addTag(this.value.trim());
                    this.value = '';
                }
            });

            function addTag(tagText) {
                if (tagText && !tags.includes(tagText) && tags.length < 10) {
                    tags.push(tagText);
                    renderTags();
                    updateHiddenInput();
                }
            }

            function removeTag(index) {
                tags.splice(index, 1);
                renderTags();
                updateHiddenInput();
            }

            function renderTags() {
                const existingTags = container.querySelectorAll('.tag-item');
                existingTags.forEach(tag => tag.remove());

                tags.forEach((tag, index) => {
                    const tagElement = document.createElement('div');
                    tagElement.className = 'tag-item';
                    tagElement.innerHTML = `
                        <span>${tag}</span>
                        <button type="button" class="tag-remove" onclick="removeTagByIndex(${index})">
                            <i class="bi bi-x"></i>
                        </button>
                    `;
                    container.insertBefore(tagElement, input);
                });
            }

            function updateHiddenInput() {
                hidden.value = tags.join(', ');
            }

            // Global function for remove button
            window.removeTagByIndex = removeTag;
        }

        // Summernote Editor
        function initSummernote() {
            // Check if jQuery is available
            if (typeof $ === 'undefined') {
                console.error('jQuery is not loaded');
                return;
            }

            // Check if summernote is available
            if (typeof $.fn.summernote === 'undefined') {
                console.error('Summernote is not loaded');
                return;
            }

            $('#konten').summernote({
                height: 350,
                lang: 'id-ID',
                placeholder: 'Tulis isi berita lengkap di sini...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['forecolor', 'backcolor']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video', 'hr']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                fontNames: [
                    'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New',
                    'Helvetica Neue', 'Helvetica', 'Impact', 'Lucida Grande',
                    'Segoe UI', 'Tahoma', 'Times New Roman', 'Verdana'
                ],
                fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '22', '24', '36', '48'],
                callbacks: {
                    onChange: function(contents, $editable) {
                        // Trigger auto-save if available
                        if (typeof autoSave === 'function') {
                            autoSave();
                        }
                    },
                    onImageUpload: function(files) {
                        // Handle image upload in editor
                        for (let i = 0; i < files.length; i++) {
                            uploadEditorImage(files[i]);
                        }
                    }
                }
            });

            // Custom function to handle image upload in editor
            function uploadEditorImage(file) {
                const data = new FormData();
                data.append("file", file);
                data.append("_token", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                // For now, just insert as base64
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#konten').summernote('insertImage', e.target.result, function(image) {
                        image.css('max-width', '100%');
                        image.css('height', 'auto');
                    });
                };
                reader.readAsDataURL(file);

                // TODO: Implement server-side upload
                // fetch('/admin/upload-editor-image', {
                //     method: 'POST',
                //     body: data
                // }).then(response => response.json())
                // .then(result => {
                //     if (result.success) {
                //         $('#konten').summernote('insertImage', result.location);
                //     }
                // });
            }
        }

        // Form Actions
        function initFormActions() {
            const form = document.getElementById('beritaForm');
            const statusSelect = document.getElementById('status');
            const publishedAtInput = document.getElementById('published_at');
            const draftBtn = document.getElementById('draftBtn');

            // Set current datetime when status is published
            statusSelect.addEventListener('change', function() {
                if (this.value === 'published' && !publishedAtInput.value) {
                    const now = new Date();
                    const offset = now.getTimezoneOffset() * 60000;
                    const localTime = new Date(now.getTime() - offset);
                    publishedAtInput.value = localTime.toISOString().slice(0, 16);
                }
            });

            // Draft button
            draftBtn.addEventListener('click', function() {
                statusSelect.value = 'draft';
                publishedAtInput.value = '';
                form.submit();
            });

            // Form submission
            form.addEventListener('submit', function(e) {
                // Basic validation
                const judul = document.getElementById('judul').value.trim();
                const konten = $('#konten').summernote('code').trim();
                const kategori = document.getElementById('kategori').value;
                const penulis = document.getElementById('penulis').value.trim();

                if (!judul || !konten || konten === '<p><br></p>' || !kategori || !penulis) {
                    e.preventDefault();
                    alert('Harap lengkapi semua field yang wajib diisi!');
                    return false;
                }

                // Show loading
                const submitBtns = form.querySelectorAll('button[type="submit"]');
                submitBtns.forEach(btn => {
                    btn.disabled = true;
                    const originalText = btn.innerHTML;
                    btn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';

                    setTimeout(() => {
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    }, 5000);
                });
            });
        }

        // Preview Function
        function initPreview() {
            const previewBtn = document.getElementById('previewBtn');
            const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
            const previewContent = document.getElementById('previewContent');

            previewBtn.addEventListener('click', function() {
                // Get form data
                const judul = document.getElementById('judul').value || 'Judul Berita';
                const excerpt = document.getElementById('excerpt').value || 'Ringkasan berita belum ditambahkan.';
                const konten = $('#konten').summernote('code') || '<p>Konten berita belum ditambahkan.</p>';
                const penulis = document.getElementById('penulis').value || 'Penulis';
                const kategori = document.getElementById('kategori');
                const kategoriText = kategori.options[kategori.selectedIndex]?.text || 'Kategori';
                const tags = document.getElementById('tagsHidden').value || '';
                const gambar = document.getElementById('imagePreview').src || '';

                // Generate preview
                const previewHTML = `
                    <article class="preview-article">
                        ${gambar ? `<img src="${gambar}" alt="${judul}" class="img-fluid rounded mb-3">` : ''}
                        
                        <h1 class="preview-title">${judul}</h1>
                        
                        <div class="preview-meta">
                            <span><i class="bi bi-person me-1"></i>${penulis}</span>
                            <span><i class="bi bi-tag me-1"></i>${kategoriText}</span>
                            <span><i class="bi bi-calendar me-1"></i>${new Date().toLocaleDateString('id-ID')}</span>
                            ${tags ? `<span><i class="bi bi-tags me-1"></i>${tags}</span>` : ''}
                        </div>
                        
                        <div class="preview-excerpt">
                            <p><em>${excerpt}</em></p>
                        </div>
                        
                        <div class="preview-content">
                            ${konten}
                        </div>
                    </article>
                `;

                previewContent.innerHTML = previewHTML;
                previewModal.show();
            });
        }

        // Character counter for excerpt
        const excerptTextarea = document.getElementById('excerpt');
        if (excerptTextarea) {
            const maxLength = 300;
            const counter = document.createElement('div');
            counter.className = 'form-text text-end';
            excerptTextarea.parentNode.appendChild(counter);

            function updateCounter() {
                const remaining = maxLength - excerptTextarea.value.length;
                counter.textContent = `${excerptTextarea.value.length}/${maxLength} karakter`;
                counter.style.color = remaining < 50 ? '#dc3545' : '#6c757d';
            }

            excerptTextarea.addEventListener('input', updateCounter);
            updateCounter();
        }

        // Auto-save draft (optional)
        let autoSaveTimer;

        function autoSave() {
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(() => {
                const formData = new FormData(document.getElementById('beritaForm'));
                formData.set('status', 'draft');
                formData.set('action', 'auto-save');
                formData.set('konten', $('#konten').summernote('code'));

                // You can implement auto-save AJAX here
                console.log('Auto-save triggered');
            }, 30000); // Auto-save every 30 seconds
        }

        // Trigger auto-save on form changes
        document.getElementById('beritaForm').addEventListener('input', autoSave);

        // Error handling for Summernote initialization
        window.onerror = function(msg, url, lineNo, columnNo, error) {
            if (msg.includes('summernote')) {
                console.error('Summernote error:', msg);
                // Fallback to regular textarea
                const kontenTextarea = document.getElementById('konten');
                if (kontenTextarea) {
                    kontenTextarea.style.display = 'block';
                    kontenTextarea.style.minHeight = '300px';
                }
            }
            return false;
        };
    </script>
@endpush
