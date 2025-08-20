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

        /* Photo Upload Section */
        .photo-upload-container {
            background: var(--cream);
            border: 2px dashed rgba(45, 80, 22, 0.3);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .photo-upload-container:hover {
            border-color: var(--primary-green);
            background: rgba(45, 80, 22, 0.05);
        }

        .photo-upload-container.dragover {
            border-color: var(--accent-orange);
            background: rgba(255, 140, 66, 0.1);
            transform: scale(1.02);
        }

        .upload-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: white;
            transition: all 0.3s ease;
        }

        .photo-upload-container:hover .upload-icon {
            transform: scale(1.1);
        }

        .upload-text {
            color: var(--primary-green);
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 10px;
        }

        [data-theme="dark"] .upload-text {
            color: var(--light-green);
        }

        .upload-subtext {
            color: var(--soft-gray);
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .file-input-hidden {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .btn-choose-file {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            border: none;
            color: white;
            padding: 10px 25px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-choose-file:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45, 80, 22, 0.3);
        }

        /* Photo Preview */
        .photo-preview-container {
            display: none;
            text-align: center;
            margin-top: 20px;
        }

        .photo-preview {
            max-width: 400px;
            max-height: 400px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border: 3px solid var(--primary-green);
            margin: 0 auto 15px;
            display: block;
        }

        .photo-info {
            background: rgba(45, 80, 22, 0.1);
            border-radius: 10px;
            padding: 15px;
            margin-top: 15px;
        }

        .photo-info h6 {
            color: var(--primary-green);
            font-weight: 600;
            margin-bottom: 10px;
        }

        [data-theme="dark"] .photo-info h6 {
            color: var(--light-green);
        }

        .photo-details {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 15px;
        }

        .photo-detail-item {
            text-align: center;
        }

        .photo-detail-label {
            font-size: 0.8rem;
            color: var(--soft-gray);
            margin-bottom: 5px;
        }

        .photo-detail-value {
            font-weight: 600;
            color: var(--primary-green);
        }

        [data-theme="dark"] .photo-detail-value {
            color: var(--light-green);
        }

        .btn-change-photo {
            background: linear-gradient(135deg, var(--accent-orange), #ffa726);
            border: none;
            color: white;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-top: 15px;
            transition: all 0.3s ease;
        }

        .btn-change-photo:hover {
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(255, 140, 66, 0.3);
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

        /* Responsive */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            .photo-upload-container {
                padding: 20px;
            }

            .upload-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .photo-preview {
                max-width: 100%;
                max-height: 300px;
            }

            .photo-details {
                flex-direction: column;
                gap: 10px;
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

        /* Loading Animation */
        .processing-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            z-index: 10;
        }

        .processing-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid var(--cream);
            border-top: 4px solid var(--primary-green);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 15px;
        }

        .processing-text {
            color: var(--primary-green);
            font-weight: 600;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
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
                    <li class="breadcrumb-item"><a href="{{ route('admin.galeri.index') }}">Galeri Foto</a></li>
                    <li class="breadcrumb-item active">Upload Foto Baru</li>
                </ol>
            </nav>
            <h1 class="page-title">Upload Foto Galeri Baru</h1>
            <p class="page-subtitle">Lengkapi form di bawah untuk menambahkan foto baru ke galeri desa</p>
        </div>

        <!-- Info Card -->
        <div class="info-card">
            <div class="info-icon">
                <i class="bi bi-info-lg"></i>
            </div>
            <h6>Petunjuk Upload Foto</h6>
            <p>
                Upload foto dengan kualitas terbaik untuk hasil yang optimal.
                Foto akan otomatis dipotong menjadi ukuran 600x600 pixel untuk konsistensi tampilan galeri.
                Format yang didukung: JPG, JPEG, PNG (maksimal 5MB per file).
                Pastikan nama kegiatan dan keterangan diisi dengan jelas dan informatif.
            </p>
        </div>

        <!-- Progress Steps -->
        <div class="form-progress">
            <div class="progress-step active">
                <div class="step-number">1</div>
                <span>Upload Foto</span>
            </div>
            <div class="progress-step">
                <div class="step-number">2</div>
                <span>Detail Kegiatan</span>
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
                    <i class="bi bi-camera-fill"></i>
                </div>
                <h2 class="form-title">Form Upload Foto Galeri</h2>
                <p class="form-subtitle">Upload dan tambahkan detail foto untuk galeri desa</p>
            </div>

            <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                <!-- Section 1: Upload Foto -->
                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-cloud-upload"></i>
                        </div>
                        Upload Foto Kegiatan
                    </h4>

                    <div class="photo-upload-container" id="photoUploadContainer">
                        <div class="processing-overlay" id="processingOverlay">
                            <div class="processing-spinner"></div>
                            <div class="processing-text">Memproses foto...</div>
                        </div>

                        <div class="upload-icon">
                            <i class="bi bi-cloud-upload"></i>
                        </div>
                        <div class="upload-text">Drag & Drop foto di sini</div>
                        <div class="upload-subtext">atau klik untuk memilih file</div>
                        <button type="button" class="btn-choose-file"
                            onclick="document.getElementById('fotoInput').click()">
                            <i class="bi bi-folder2-open me-2"></i>Pilih Foto
                        </button>

                        <input type="file" class="file-input-hidden galeri-image" id="fotoInput" name="foto"
                            accept="image/jpeg,image/jpg,image/png" data-target="photoPreview" required>

                        @error('foto')
                            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="photo-preview-container" id="photoPreviewContainer">
                        <img id="photoPreview" src="" alt="Preview" class="photo-preview">
                        <button type="button" class="btn-change-photo"
                            onclick="document.getElementById('fotoInput').click()">
                            <i class="bi bi-arrow-repeat me-2"></i>Ganti Foto
                        </button>

                        <div class="photo-info">
                            <h6><i class="bi bi-info-circle me-2"></i>Informasi Foto</h6>
                            <div class="photo-details">
                                <div class="photo-detail-item">
                                    <div class="photo-detail-label">Ukuran Asli</div>
                                    <div class="photo-detail-value" id="originalSize">-</div>
                                </div>
                                <div class="photo-detail-item">
                                    <div class="photo-detail-label">Ukuran File</div>
                                    <div class="photo-detail-value" id="fileSize">-</div>
                                </div>
                                <div class="photo-detail-item">
                                    <div class="photo-detail-label">Ukuran Hasil</div>
                                    <div class="photo-detail-value">600 x 600 px</div>
                                </div>
                                <div class="photo-detail-item">
                                    <div class="photo-detail-label">Format</div>
                                    <div class="photo-detail-value">JPEG</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Detail Kegiatan -->
                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-card-text"></i>
                        </div>
                        Detail Kegiatan
                    </h4>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nama_kegiatan" class="form-label">
                                Nama Kegiatan <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror"
                                id="nama_kegiatan" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}"
                                placeholder="Contoh: Gotong Royong Membersihkan Desa" maxlength="255" required>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Berikan nama kegiatan yang jelas dan deskriptif
                            </div>
                            @error('nama_kegiatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="keterangan" class="form-label">
                                Keterangan Kegiatan
                            </label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan"
                                rows="4"
                                placeholder="Contoh: Kegiatan gotong royong rutin yang dilaksanakan setiap hari Minggu pagi untuk membersihkan lingkungan desa dan mempererat tali silaturahmi antar warga..."
                                maxlength="1000">{{ old('keterangan') }}</textarea>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Jelaskan detail kegiatan, waktu pelaksanaan, dan hal menarik lainnya (opsional)
                            </div>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('admin.galeri.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="bi bi-check-lg me-2"></i>Simpan Foto
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto crop and preview script for galeri images
            const galeriImageInput = document.querySelector('.galeri-image');
            const photoUploadContainer = document.getElementById('photoUploadContainer');
            const photoPreviewContainer = document.getElementById('photoPreviewContainer');
            const processingOverlay = document.getElementById('processingOverlay');

            if (galeriImageInput) {
                galeriImageInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (!file) return;

                    // Show processing overlay
                    processingOverlay.style.display = 'flex';

                    // Validate file type
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Format file tidak didukung! Gunakan JPG, JPEG, atau PNG.');
                        resetUpload();
                        return;
                    }

                    // Validate file size (5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('Ukuran file terlalu besar! Maksimal 5MB.');
                        resetUpload();
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = new Image();
                        img.src = e.target.result;
                        img.onload = function() {
                            // Update original size info
                            document.getElementById('originalSize').textContent = img.width +
                                ' x ' + img.height + ' px';
                            document.getElementById('fileSize').textContent = formatFileSize(file
                                .size);

                            // Create canvas for cropping
                            const canvas = document.createElement('canvas');
                            const ctx = canvas.getContext('2d');

                            // Set crop size (600x600)
                            canvas.width = 600;
                            canvas.height = 600;

                            // Get center area of image
                            const minSize = Math.min(img.width, img.height);
                            const sx = (img.width - minSize) / 2;
                            const sy = (img.height - minSize) / 2;

                            ctx.drawImage(img, sx, sy, minSize, minSize, 0, 0, 600, 600);

                            // Convert to Blob (JPEG)
                            canvas.toBlob(function(blob) {
                                const croppedFile = new File([blob], "cropped.jpg", {
                                    type: "image/jpeg"
                                });

                                // Update input file with cropped image
                                const dataTransfer = new DataTransfer();
                                dataTransfer.items.add(croppedFile);
                                event.target.files = dataTransfer.files;

                                // Show preview
                                const preview = document.getElementById('photoPreview');
                                if (preview) {
                                    preview.src = URL.createObjectURL(blob);
                                    photoPreviewContainer.style.display = 'block';

                                    // Hide upload container, show preview
                                    photoUploadContainer.style.display = 'none';
                                }

                                // Hide processing overlay
                                processingOverlay.style.display = 'none';

                                // Update progress step
                                updateProgressStep(2);

                            }, "image/jpeg", 0.9);
                        };
                    };
                    reader.readAsDataURL(file);
                });
            }

            // Drag and drop functionality
            photoUploadContainer.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.add('dragover');
            });

            photoUploadContainer.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.remove('dragover');
            });

            photoUploadContainer.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                this.classList.remove('dragover');

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    galeriImageInput.files = files;
                    galeriImageInput.dispatchEvent(new Event('change'));
                }
            });

            // Form validation
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('submitBtn');

            form.addEventListener('submit', function(e) {
                const namaKegiatan = document.getElementById('nama_kegiatan').value.trim();
                const foto = galeriImageInput.files[0];

                if (!foto) {
                    e.preventDefault();
                    alert('Silakan upload foto terlebih dahulu!');
                    return false;
                }

                if (namaKegiatan.length < 3) {
                    e.preventDefault();
                    alert('Nama kegiatan harus minimal 3 karakter!');
                    return false;
                }

                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML =
                    '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
            });

            // Progress step functionality
            const formSections = document.querySelectorAll('.form-section');
            const progressSteps = document.querySelectorAll('.progress-step');

            function updateProgressStep(stepNumber) {
                progressSteps.forEach((step, index) => {
                    if (index < stepNumber) {
                        step.classList.add('active');
                    } else {
                        step.classList.remove('active');
                    }
                });
            }

            // Intersection Observer for progress steps
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const index = Array.from(formSections).indexOf(entry.target);
                        updateProgressStep(index + 1);
                    }
                });
            }, {
                threshold: 0.5
            });

            formSections.forEach(section => {
                observer.observe(section);
            });

            // Format file size helper
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Reset upload function
            function resetUpload() {
                galeriImageInput.value = '';
                photoPreviewContainer.style.display = 'none';
                photoUploadContainer.style.display = 'block';
                processingOverlay.style.display = 'none';
                updateProgressStep(1);

                // Reset file info
                document.getElementById('originalSize').textContent = '-';
                document.getElementById('fileSize').textContent = '-';
            }

            // Auto capitalize nama kegiatan
            const namaKegiatanInput = document.getElementById('nama_kegiatan');
            namaKegiatanInput.addEventListener('input', function(e) {
                // Capitalize first letter of each word
                e.target.value = e.target.value.toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
            });

            // Character counter for keterangan
            const keteranganInput = document.getElementById('keterangan');
            const maxLength = 1000;

            // Create character counter
            const counterDiv = document.createElement('div');
            counterDiv.className = 'form-text text-end';
            counterDiv.style.marginTop = '5px';
            keteranganInput.parentNode.appendChild(counterDiv);

            function updateCounter() {
                const remaining = maxLength - keteranganInput.value.length;
                counterDiv.innerHTML =
                    `<i class="bi bi-pencil-square me-1"></i>${keteranganInput.value.length}/${maxLength} karakter`;

                if (remaining < 100) {
                    counterDiv.style.color = '#ffc107';
                } else if (remaining < 50) {
                    counterDiv.style.color = '#dc3545';
                } else {
                    counterDiv.style.color = 'var(--soft-gray)';
                }
            }

            keteranganInput.addEventListener('input', updateCounter);
            updateCounter(); // Initial call

            // Keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl + S = Submit form
                if (e.ctrlKey && e.key === 's') {
                    e.preventDefault();
                    if (!submitBtn.disabled) {
                        form.submit();
                    }
                }

                // Escape = Reset upload
                if (e.key === 'Escape' && photoPreviewContainer.style.display === 'block') {
                    resetUpload();
                }
            });

            // Paste image from clipboard
            document.addEventListener('paste', function(e) {
                const items = e.clipboardData.items;
                for (let i = 0; i < items.length; i++) {
                    if (items[i].type.indexOf('image') !== -1) {
                        const blob = items[i].getAsFile();
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(blob);
                        galeriImageInput.files = dataTransfer.files;
                        galeriImageInput.dispatchEvent(new Event('change'));
                        break;
                    }
                }
            });

            // Auto-save draft functionality (optional)
            let draftTimer;

            function saveDraft() {
                const draftData = {
                    nama_kegiatan: namaKegiatanInput.value,
                    keterangan: keteranganInput.value,
                    timestamp: new Date().toISOString()
                };
                localStorage.setItem('galeri_draft', JSON.stringify(draftData));
            }

            function loadDraft() {
                const draft = localStorage.getItem('galeri_draft');
                if (draft) {
                    const draftData = JSON.parse(draft);
                    // Check if draft is less than 24 hours old
                    const draftTime = new Date(draftData.timestamp);
                    const now = new Date();
                    const hoursDiff = (now - draftTime) / (1000 * 60 * 60);

                    if (hoursDiff < 24 && (draftData.nama_kegiatan || draftData.keterangan)) {
                        if (confirm('Ditemukan draft yang belum disimpan. Muat draft tersebut?')) {
                            namaKegiatanInput.value = draftData.nama_kegiatan || '';
                            keteranganInput.value = draftData.keterangan || '';
                            updateCounter();
                        }
                    }
                }
            }

            // Auto-save every 30 seconds
            function startAutoSave() {
                draftTimer = setInterval(saveDraft, 30000);
            }

            // Clear draft on successful submit
            form.addEventListener('submit', function() {
                localStorage.removeItem('galeri_draft');
                clearInterval(draftTimer);
            });

            // Load draft on page load
            loadDraft();
            startAutoSave();

            // Clean up on page unload
            window.addEventListener('beforeunload', function() {
                clearInterval(draftTimer);
            });

            // Image quality preview
            function showImageQualityTip() {
                const tip = document.createElement('div');
                tip.className = 'alert alert-info mt-3';
                tip.innerHTML = `
                    <i class="bi bi-lightbulb me-2"></i>
                    <strong>Tips untuk foto berkualitas:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Gunakan pencahayaan yang cukup</li>
                        <li>Hindari foto yang blur atau gelap</li>
                        <li>Pastikan objek utama terlihat jelas</li>
                        <li>Foto akan dipotong menjadi bentuk persegi</li>
                    </ul>
                `;

                const uploadContainer = document.querySelector('.photo-upload-container');
                uploadContainer.parentNode.insertBefore(tip, uploadContainer.nextSibling);

                setTimeout(() => {
                    tip.remove();
                }, 10000);
            }

            // Show tip after 3 seconds if no image uploaded
            setTimeout(() => {
                if (!galeriImageInput.files[0]) {
                    showImageQualityTip();
                }
            }, 3000);

            // Toast notification for successful operations
            function showToast(message, type = 'success') {
                const toast = document.createElement('div');
                toast.className = `alert alert-${type} position-fixed`;
                toast.style.top = '20px';
                toast.style.right = '20px';
                toast.style.zIndex = '9999';
                toast.style.minWidth = '300px';
                toast.innerHTML = `
                    <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
                `;

                document.body.appendChild(toast);

                setTimeout(() => {
                    if (toast.parentElement) {
                        toast.remove();
                    }
                }, 5000);
            }

            // Global function to reset upload (accessible from buttons)
            window.resetUpload = resetUpload;
        });
    </script>
@endpush
