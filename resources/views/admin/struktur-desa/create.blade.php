@extends('layouts.main')

@section('content')
    <div class="dashboard-content">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.struktur-desa.index') }}" class="text-decoration-none">
                                Struktur Desa
                            </a>
                        </li>
                        <li class="breadcrumb-item active">{{ $titleHeader }}</li>
                    </ol>
                </nav>
                <h2 class="header-title mb-2">{{ $titleHeader }}</h2>
                <p class="text-muted mb-0">Tambahkan pejabat baru ke dalam struktur organisasi desa</p>
            </div>
            <div>
                <a href="{{ route('admin.struktur-desa.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Form Card -->
        <div class="row">
            <div class="col-lg-8">
                <div class="activity-card">
                    <div class="d-flex align-items-center mb-4">
                        <div class="stat-icon population me-3">
                            <i class="bi bi-person-plus"></i>
                        </div>
                        <div>
                            <h5 class="chart-title mb-1">Informasi Pejabat</h5>
                            <p class="text-muted mb-0">Lengkapi data pejabat desa dengan benar</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.struktur-desa.store') }}" method="POST" enctype="multipart/form-data"
                        id="strukturDesaForm" onsubmit="console.log('Form submitted with enctype:', this.enctype);">
                        @csrf

                        <!-- Data Pribadi Section -->
                        <div class="form-section mb-4">
                            <h6 class="section-title">
                                <i class="bi bi-person-circle text-primary me-2"></i>
                                Data Pribadi
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label required">Nama Lengkap</label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" value="{{ old('nama') }}" required>
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="posisi" class="form-label required">Posisi/Jabatan</label>
                                        <input type="text" class="form-control @error('posisi') is-invalid @enderror"
                                            id="posisi" name="posisi" value="{{ old('posisi') }}"
                                            placeholder="Contoh: Kepala Desa, Sekretaris Desa" required>
                                        @error('posisi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nik" class="form-label">NIK</label>
                                        <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                            id="nik" name="nik" value="{{ old('nik') }}" maxlength="16"
                                            placeholder="16 digit NIK">
                                        @error('nik')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nip" class="form-label">NIP</label>
                                        <input type="text" class="form-control @error('nip') is-invalid @enderror"
                                            id="nip" name="nip" value="{{ old('nip') }}"
                                            placeholder="Nomor Induk Pegawai (jika ada)">
                                        @error('nip')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3"
                                            placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                                        <input type="text"
                                            class="form-control @error('pendidikan_terakhir') is-invalid @enderror"
                                            id="pendidikan_terakhir" name="pendidikan_terakhir"
                                            value="{{ old('pendidikan_terakhir') }}"
                                            placeholder="Contoh: S1 Administrasi Negara">
                                        @error('pendidikan_terakhir')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Jabatan Section -->
                        <div class="form-section mb-4">
                            <h6 class="section-title">
                                <i class="bi bi-award text-success me-2"></i>
                                Informasi Jabatan
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="kategori" class="form-label required">Kategori Jabatan</label>
                                        <select class="form-select @error('kategori') is-invalid @enderror" id="kategori"
                                            name="kategori" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach ($kategoriList as $key => $value)
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
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="urutan" class="form-label required">Urutan Tampil</label>
                                        <input type="number" class="form-control @error('urutan') is-invalid @enderror"
                                            id="urutan" name="urutan" value="{{ old('urutan', 0) }}" min="0"
                                            required>
                                        <div class="form-text">Urutan untuk menampilkan dalam struktur organisasi</div>
                                        @error('urutan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="mulai_menjabat" class="form-label">Mulai Menjabat</label>
                                        <input type="date"
                                            class="form-control @error('mulai_menjabat') is-invalid @enderror"
                                            id="mulai_menjabat" name="mulai_menjabat"
                                            value="{{ old('mulai_menjabat') }}">
                                        @error('mulai_menjabat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="selesai_menjabat" class="form-label">Selesai Menjabat</label>
                                        <input type="date"
                                            class="form-control @error('selesai_menjabat') is-invalid @enderror"
                                            id="selesai_menjabat" name="selesai_menjabat"
                                            value="{{ old('selesai_menjabat') }}">
                                        <div class="form-text">Kosongkan jika masih menjabat</div>
                                        @error('selesai_menjabat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi/Tugas Pokok</label>
                                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi"
                                            rows="4" placeholder="Deskripsi singkat tentang tugas dan tanggung jawab">{{ old('deskripsi') }}</textarea>
                                        @error('deskripsi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="aktif"
                                                name="aktif" value="1" {{ old('aktif', true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="aktif">
                                                Pejabat sedang aktif menjabat
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kontak Section -->
                        <div class="form-section mb-4">
                            <h6 class="section-title">
                                <i class="bi bi-telephone text-info me-2"></i>
                                Informasi Kontak
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="telepon" class="form-label">Nomor Telepon</label>
                                        <input type="tel" class="form-control @error('telepon') is-invalid @enderror"
                                            id="telepon" name="telepon" value="{{ old('telepon') }}"
                                            placeholder="08xxxxxxxxxx">
                                        @error('telepon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}"
                                            placeholder="nama@example.com">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="twitter" class="form-label">Twitter</label>
                                        <div class="input-group">
                                            <span class="input-group-text">@</span>
                                            <input type="text"
                                                class="form-control @error('twitter') is-invalid @enderror"
                                                id="twitter" name="twitter" value="{{ old('twitter') }}"
                                                placeholder="username">
                                        </div>
                                        @error('twitter')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="facebook" class="form-label">Facebook</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-facebook"></i></span>
                                            <input type="text"
                                                class="form-control @error('facebook') is-invalid @enderror"
                                                id="facebook" name="facebook" value="{{ old('facebook') }}"
                                                placeholder="profile.url">
                                        </div>
                                        @error('facebook')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="instagram" class="form-label">Instagram</label>
                                        <div class="input-group">
                                            <span class="input-group-text">@</span>
                                            <input type="text"
                                                class="form-control @error('instagram') is-invalid @enderror"
                                                id="instagram" name="instagram" value="{{ old('instagram') }}"
                                                placeholder="username">
                                        </div>
                                        @error('instagram')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.struktur-desa.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success" id="submitBtn">
                                <i class="bi bi-check-circle"></i> Simpan Pejabat
                            </button>
                        </div>

                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="col-lg-4">
                <!-- Photo Upload Card -->
                <div class="activity-card mb-4">
                    <h6 class="chart-title mb-3">
                        <i class="bi bi-camera text-warning me-2"></i>
                        Foto Profil
                    </h6>

                    <div class="text-center">
                        <div class="photo-preview mb-3">
                            <img src="{{ asset('images/default-avatar.png') }}" alt="Preview" id="photoPreview"
                                class="rounded-circle"
                                style="width: 150px; height: 150px; object-fit: cover; border: 3px solid var(--cream);">
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Upload Foto</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                id="image" name="image" accept="image/*"
                                onchange="console.log('File selected:', this.files[0]);">
                            <div class="form-text">
                                Format: JPG, PNG, GIF. Maksimal 2MB.
                            </div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    </form>
                </div>

                <!-- Help Card -->
                <div class="activity-card">
                    <h6 class="chart-title mb-3">
                        <i class="bi bi-info-circle text-primary me-2"></i>
                        Panduan Pengisian
                    </h6>

                    <div class="help-content">
                        <div class="help-item mb-3">
                            <h6 class="small mb-1"><i class="bi bi-asterisk text-danger"></i> Field Wajib</h6>
                            <p class="small text-muted">Nama, Posisi, Kategori, dan Urutan wajib diisi</p>
                        </div>

                        <div class="help-item mb-3">
                            <h6 class="small mb-1"><i class="bi bi-sort-numeric-up"></i> Urutan</h6>
                            <p class="small text-muted">Semakin kecil angka, semakin atas posisinya dalam struktur</p>
                        </div>

                        <div class="help-item mb-3">
                            <h6 class="small mb-1"><i class="bi bi-calendar"></i> Periode Jabatan</h6>
                            <p class="small text-muted">Kosongkan tanggal selesai jika masih menjabat</p>
                        </div>

                        <div class="help-item">
                            <h6 class="small mb-1"><i class="bi bi-image"></i> Foto Profil</h6>
                            <p class="small text-muted">Gunakan foto formal dengan resolusi minimal 300x300px</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Image Preview Functionality
                const imageInput = document.getElementById('image');
                const photoPreview = document.getElementById('photoPreview');

                if (imageInput) {
                    imageInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];

                        if (file) {
                            // Validate file size (2MB)
                            if (file.size > 2 * 1024 * 1024) {
                                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                                this.value = '';
                                return;
                            }

                            // Validate file type
                            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                            if (!validTypes.includes(file.type)) {
                                alert('Format file tidak valid. Gunakan JPG, PNG, atau GIF.');
                                this.value = '';
                                return;
                            }

                            // Show preview
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                photoPreview.src = e.target.result;
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                }

                // NIK Input Validation (only numbers, max 16 digits)
                const nikInput = document.getElementById('nik');
                if (nikInput) {
                    nikInput.addEventListener('input', function(e) {
                        this.value = this.value.replace(/\D/g, '').substring(0, 16);
                    });
                }

                // Phone Input Validation (only numbers and +)
                const teleponInput = document.getElementById('telepon');
                if (teleponInput) {
                    teleponInput.addEventListener('input', function(e) {
                        this.value = this.value.replace(/[^\d+]/g, '');
                    });
                }

                // Form Validation
                const form = document.getElementById('strukturDesaForm');
                const submitBtn = document.getElementById('submitBtn');

                if (form) {
                    form.addEventListener('submit', function(e) {
                        // Debug: Log form data
                        const formData = new FormData(this);
                        console.log('=== FORM SUBMIT DEBUG ===');
                        console.log('Form action:', this.action);
                        console.log('Form method:', this.method);
                        console.log('Form enctype:', this.enctype);

                        // Check if image file is selected
                        const imageFile = formData.get('image');
                        console.log('Image file:', imageFile);
                        if (imageFile && imageFile.size > 0) {
                            console.log('Image filename:', imageFile.name);
                            console.log('Image size:', imageFile.size, 'bytes');
                            console.log('Image type:', imageFile.type);
                        } else {
                            console.log('No image file selected');
                        }

                        // Log all form fields
                        for (let [key, value] of formData.entries()) {
                            console.log(key + ':', value);
                        }

                        // Show loading state
                        submitBtn.innerHTML =
                            '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
                        submitBtn.disabled = true;

                        // Basic validation
                        const requiredFields = ['nama', 'posisi', 'kategori', 'urutan'];
                        let isValid = true;

                        requiredFields.forEach(field => {
                            const input = document.getElementById(field);
                            if (!input.value.trim()) {
                                isValid = false;
                                input.classList.add('is-invalid');
                            } else {
                                input.classList.remove('is-invalid');
                            }
                        });

                        if (!isValid) {
                            e.preventDefault();
                            submitBtn.innerHTML = '<i class="bi bi-check-circle"></i> Simpan Pejabat';
                            submitBtn.disabled = false;
                            alert('Mohon lengkapi semua field yang wajib diisi!');
                        }
                    });
                }

                // Date validation (selesai_menjabat should be after mulai_menjabat)
                const mulaiMenjabat = document.getElementById('mulai_menjabat');
                const selesaiMenjabat = document.getElementById('selesai_menjabat');

                if (mulaiMenjabat && selesaiMenjabat) {
                    function validateDates() {
                        if (mulaiMenjabat.value && selesaiMenjabat.value) {
                            const mulai = new Date(mulaiMenjabat.value);
                            const selesai = new Date(selesaiMenjabat.value);

                            if (selesai <= mulai) {
                                selesaiMenjabat.setCustomValidity('Tanggal selesai harus setelah tanggal mulai');
                            } else {
                                selesaiMenjabat.setCustomValidity('');
                            }
                        }
                    }

                    mulaiMenjabat.addEventListener('change', validateDates);
                    selesaiMenjabat.addEventListener('change', validateDates);
                }

                // Auto-hide alerts after 5 seconds
                setTimeout(function() {
                    const alerts = document.querySelectorAll('.alert');
                    alerts.forEach(alert => {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    });
                }, 5000);
            });
        </script>
    @endpush

    @push('style')
        <style>
            .required::after {
                content: " *";
                color: #dc3545;
            }

            .form-section {
                border-left: 4px solid var(--accent-orange);
                padding-left: 20px;
                margin-left: 10px;
            }

            .section-title {
                color: var(--primary-green);
                font-weight: 600;
                margin-bottom: 20px;
                font-size: 1rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            [data-theme="dark"] .section-title {
                color: var(--light-green);
            }

            .form-control:focus,
            .form-select:focus {
                border-color: var(--accent-orange);
                box-shadow: 0 0 0 0.2rem rgba(255, 140, 66, 0.25);
            }

            .input-group-text {
                background-color: var(--cream);
                border-color: var(--cream);
                color: var(--soft-gray);
            }

            [data-theme="dark"] .input-group-text {
                background-color: var(--warm-white);
                border-color: var(--warm-white);
            }

            .breadcrumb-item a {
                color: var(--primary-green);
                text-decoration: none;
            }

            .breadcrumb-item a:hover {
                color: var(--accent-orange);
            }

            .breadcrumb-item.active {
                color: var(--soft-gray);
            }

            .help-content .help-item {
                padding: 10px;
                background: var(--cream);
                border-radius: 8px;
                border-left: 3px solid var(--accent-orange);
            }

            [data-theme="dark"] .help-content .help-item {
                background: rgba(255, 255, 255, 0.05);
            }

            .photo-preview {
                position: relative;
            }

            .photo-preview::after {
                content: '';
                position: absolute;
                bottom: 10px;
                right: 10px;
                width: 30px;
                height: 30px;
                background: var(--accent-orange);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 0.8rem;
                opacity: 0.8;
            }

            .btn-success {
                background: linear-gradient(135deg, var(--secondary-green), var(--primary-green));
                border: none;
            }

            .btn-success:hover {
                background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(45, 80, 22, 0.3);
            }

            .spinner-border-sm {
                width: 1rem;
                height: 1rem;
            }

            .form-text {
                color: var(--soft-gray);
                font-size: 0.825rem;
            }

            .activity-card {
                transition: all 0.3s ease;
            }

            .activity-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
            }

            .is-invalid {
                animation: shake 0.3s ease-in-out;
            }

            @keyframes shake {

                0%,
                100% {
                    transform: translateX(0);
                }

                25% {
                    transform: translateX(-5px);
                }

                75% {
                    transform: translateX(5px);
                }
            }
        </style>
    @endpush
@endsection
