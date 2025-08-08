@extends('layouts.main')

@section('content')
    <div class="dashboard-content">
        <!-- Page Header -->
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.struktur-desa.index') }}">Struktur Desa</a></li>
                    <li class="breadcrumb-item active">{{ $titleHeader }}</li>
                </ol>
            </nav>
            <h1 class="page-title">{{ $titleHeader }}</h1>
            <p class="page-subtitle">Perbarui informasi data pejabat <strong>{{ $struktur_desa->nama }}</strong></p>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('admin.struktur-desa.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>Kembali ke Daftar
            </a>
            <a href="{{ route('admin.struktur-desa.show', $struktur_desa) }}" class="btn btn-outline-info">
                <i class="bi bi-eye"></i>Lihat Detail
            </a>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Changes Summary -->
        <div class="changes-summary" id="changesSummary">
            <div class="changes-header">
                <i class="bi bi-exclamation-triangle text-warning"></i>
                <strong>Perubahan Terdeteksi</strong>
            </div>
            <ul id="changesList"></ul>
        </div>

        <!-- Main Form Container -->
        <div class="form-container">
            <div class="form-header">
                <div class="form-icon">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <h2 class="form-title">Edit Data Pejabat Desa</h2>
                <p class="form-subtitle">Perbarui informasi pejabat dengan data yang akurat</p>
            </div>

            <form action="{{ route('admin.struktur-desa.update', $struktur_desa) }}" method="POST"
                enctype="multipart/form-data" id="editForm" novalidate>
                @csrf
                @method('PUT')

                <!-- Section 1: Identitas Pribadi -->
                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        Identitas Pribadi
                    </h4>

                    <div class="input-group-identity">
                        <div class="mb-3">
                            <label for="nama" class="form-label">
                                Nama Lengkap <span class="required">*</span>
                            </label>
                            <input type="text" class="form-control change-indicator @error('nama') is-invalid @enderror"
                                id="nama" name="nama" value="{{ old('nama', $struktur_desa->nama) }}"
                                data-original="{{ $struktur_desa->nama }}" placeholder="Nama lengkap pejabat" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="posisi" class="form-label">
                                Posisi/Jabatan <span class="required">*</span>
                            </label>
                            <input type="text"
                                class="form-control change-indicator @error('posisi') is-invalid @enderror" id="posisi"
                                name="posisi" value="{{ old('posisi', $struktur_desa->posisi) }}"
                                data-original="{{ $struktur_desa->posisi }}" placeholder="Contoh: Kepala Desa" required>
                            @error('posisi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="input-group-identity">
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control change-indicator @error('nik') is-invalid @enderror"
                                id="nik" name="nik" value="{{ old('nik', $struktur_desa->nik) }}"
                                data-original="{{ $struktur_desa->nik }}" placeholder="16 digit NIK" maxlength="16">
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" class="form-control change-indicator @error('nip') is-invalid @enderror"
                                id="nip" name="nip" value="{{ old('nip', $struktur_desa->nip) }}"
                                data-original="{{ $struktur_desa->nip }}" placeholder="Nomor Induk Pegawai">
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control change-indicator @error('alamat') is-invalid @enderror" id="alamat" name="alamat"
                            rows="3" data-original="{{ $struktur_desa->alamat }}" placeholder="Alamat lengkap tempat tinggal">{{ old('alamat', $struktur_desa->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="pendidikan_terakhir" class="form-label">Pendidikan Terakhir</label>
                        <input type="text"
                            class="form-control change-indicator @error('pendidikan_terakhir') is-invalid @enderror"
                            id="pendidikan_terakhir" name="pendidikan_terakhir"
                            value="{{ old('pendidikan_terakhir', $struktur_desa->pendidikan_terakhir) }}"
                            data-original="{{ $struktur_desa->pendidikan_terakhir }}"
                            placeholder="Contoh: S1 Administrasi Negara">
                        @error('pendidikan_terakhir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Section 2: Informasi Jabatan -->
                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-award"></i>
                        </div>
                        Informasi Jabatan
                    </h4>

                    <div class="input-group-identity">
                        <div class="mb-3">
                            <label for="kategori" class="form-label">
                                Kategori Jabatan <span class="required">*</span>
                            </label>
                            <select class="form-select change-indicator @error('kategori') is-invalid @enderror"
                                id="kategori" name="kategori" data-original="{{ $struktur_desa->kategori }}" required>
                                <option value="">Pilih Kategori Jabatan</option>
                                @foreach ($kategoriList as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ old('kategori', $struktur_desa->kategori) == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="urutan" class="form-label">
                                Urutan Tampil <span class="required">*</span>
                            </label>
                            <input type="number"
                                class="form-control change-indicator @error('urutan') is-invalid @enderror" id="urutan"
                                name="urutan" value="{{ old('urutan', $struktur_desa->urutan) }}"
                                data-original="{{ $struktur_desa->urutan }}" min="0" max="999" required>
                            <div class="form-text">Urutan untuk menampilkan dalam struktur organisasi</div>
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="input-group-identity">
                        <div class="mb-3">
                            <label for="mulai_menjabat" class="form-label">Mulai Menjabat</label>
                            <input type="date"
                                class="form-control change-indicator @error('mulai_menjabat') is-invalid @enderror"
                                id="mulai_menjabat" name="mulai_menjabat"
                                value="{{ old('mulai_menjabat', $struktur_desa->mulai_menjabat?->format('Y-m-d')) }}"
                                data-original="{{ $struktur_desa->mulai_menjabat?->format('Y-m-d') }}">
                            @error('mulai_menjabat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="selesai_menjabat" class="form-label">Selesai Menjabat</label>
                            <input type="date"
                                class="form-control change-indicator @error('selesai_menjabat') is-invalid @enderror"
                                id="selesai_menjabat" name="selesai_menjabat"
                                value="{{ old('selesai_menjabat', $struktur_desa->selesai_menjabat?->format('Y-m-d')) }}"
                                data-original="{{ $struktur_desa->selesai_menjabat?->format('Y-m-d') }}">
                            <div class="form-text">Kosongkan jika masih menjabat</div>
                            @error('selesai_menjabat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi/Tugas Pokok</label>
                        <textarea class="form-control change-indicator @error('deskripsi') is-invalid @enderror" id="deskripsi"
                            name="deskripsi" rows="4" data-original="{{ $struktur_desa->deskripsi }}"
                            placeholder="Deskripsi singkat tentang tugas dan tanggung jawab">{{ old('deskripsi', $struktur_desa->deskripsi) }}</textarea>
                        <div class="char-counter">
                            <span id="deskripsiCount">0</span>/500 karakter
                        </div>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input change-indicator" type="checkbox" id="aktif"
                                name="aktif" value="1" data-original="{{ $struktur_desa->aktif ? '1' : '0' }}"
                                {{ old('aktif', $struktur_desa->aktif) ? 'checked' : '' }}>
                            <label class="form-check-label" for="aktif">
                                Pejabat sedang aktif menjabat
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Informasi Kontak -->
                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-telephone"></i>
                        </div>
                        Informasi Kontak
                    </h4>

                    <div class="input-group-identity">
                        <div class="mb-3">
                            <label for="telepon" class="form-label">Nomor Telepon</label>
                            <input type="tel"
                                class="form-control change-indicator @error('telepon') is-invalid @enderror"
                                id="telepon" name="telepon" value="{{ old('telepon', $struktur_desa->telepon) }}"
                                data-original="{{ $struktur_desa->telepon }}" placeholder="08xxxxxxxxxx">
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input type="email"
                                class="form-control change-indicator @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email', $struktur_desa->email) }}"
                                data-original="{{ $struktur_desa->email }}" placeholder="nama@example.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="input-group-social">
                        <div class="mb-3">
                            <label for="twitter" class="form-label">Twitter</label>
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <input type="text"
                                    class="form-control change-indicator @error('twitter') is-invalid @enderror"
                                    id="twitter" name="twitter" value="{{ old('twitter', $struktur_desa->twitter) }}"
                                    data-original="{{ $struktur_desa->twitter }}" placeholder="username">
                            </div>
                            @error('twitter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="facebook" class="form-label">Facebook</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-facebook"></i></span>
                                <input type="url"
                                    class="form-control change-indicator @error('facebook') is-invalid @enderror"
                                    id="facebook" name="facebook"
                                    value="{{ old('facebook', $struktur_desa->facebook) }}"
                                    data-original="{{ $struktur_desa->facebook }}"
                                    placeholder="https://facebook.com/username">
                            </div>
                            @error('facebook')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="instagram" class="form-label">Instagram</label>
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <input type="text"
                                    class="form-control change-indicator @error('instagram') is-invalid @enderror"
                                    id="instagram" name="instagram"
                                    value="{{ old('instagram', $struktur_desa->instagram) }}"
                                    data-original="{{ $struktur_desa->instagram }}" placeholder="username">
                            </div>
                            @error('instagram')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 4: Upload Foto -->
                <div class="form-section">
                    <h4 class="section-title">
                        <div class="section-icon">
                            <i class="bi bi-camera"></i>
                        </div>
                        Foto Profil
                    </h4>

                    <div class="photo-upload-container">
                        <div class="current-photo">
                            <img src="{{ $struktur_desa->image ? asset('storage/struktur-desa/' . $struktur_desa->image) : asset('images/default-avatar.png') }}"
                                alt="Foto Saat Ini" id="currentPhoto" class="current-photo-img">
                            <div class="current-photo-label">Foto Saat Ini</div>
                        </div>

                        <div class="upload-controls">
                            <label for="image" class="form-label">Upload Foto Baru</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                id="image" name="image" accept="image/*">
                            <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="preview-photo" id="previewContainer" style="display: none;">
                            <img id="photoPreview" alt="Preview" class="preview-photo-img">
                            <div class="preview-photo-label">Preview Foto Baru</div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('admin.struktur-desa.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    <a href="{{ route('admin.struktur-desa.show', $struktur_desa) }}" class="btn btn-outline-danger">
                        <i class="bi bi-eye me-2"></i>Lihat Detail
                    </a>
                    <button type="submit" class="btn btn-primary" id="saveBtn">
                        <i class="bi bi-check-lg me-2"></i>Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('editForm');
                const changesSummary = document.getElementById('changesSummary');
                const changesList = document.getElementById('changesList');
                const saveBtn = document.getElementById('saveBtn');
                let hasChanges = false;

                // Track changes
                const changeIndicators = document.querySelectorAll('.change-indicator');

                changeIndicators.forEach(input => {
                    input.addEventListener('input', function() {
                        checkForChanges();
                    });

                    input.addEventListener('change', function() {
                        checkForChanges();
                    });
                });

                function checkForChanges() {
                    const changes = [];
                    hasChanges = false;

                    changeIndicators.forEach(input => {
                        let currentValue = input.type === 'checkbox' ? (input.checked ? '1' : '0') : input
                            .value;
                        let originalValue = input.dataset.original || '';

                        if (currentValue !== originalValue) {
                            hasChanges = true;
                            changes.push({
                                field: getFieldName(input.name),
                                from: originalValue,
                                to: currentValue
                            });
                        }
                    });

                    updateChangesSummary(changes);
                    updateSaveButton();
                }

                function getFieldName(name) {
                    const fieldNames = {
                        'nama': 'Nama Lengkap',
                        'posisi': 'Posisi/Jabatan',
                        'nik': 'NIK',
                        'nip': 'NIP',
                        'alamat': 'Alamat',
                        'pendidikan_terakhir': 'Pendidikan Terakhir',
                        'kategori': 'Kategori Jabatan',
                        'urutan': 'Urutan Tampil',
                        'mulai_menjabat': 'Mulai Menjabat',
                        'selesai_menjabat': 'Selesai Menjabat',
                        'deskripsi': 'Deskripsi',
                        'aktif': 'Status Aktif',
                        'telepon': 'Nomor Telepon',
                        'email': 'Email',
                        'twitter': 'Twitter',
                        'facebook': 'Facebook',
                        'instagram': 'Instagram'
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

                // Photo preview functionality
                const imageInput = document.getElementById('image');
                const previewContainer = document.getElementById('previewContainer');
                const photoPreview = document.getElementById('photoPreview');

                if (imageInput) {
                    imageInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];

                        if (file) {
                            // Validate file size (2MB)
                            if (file.size > 2 * 1024 * 1024) {
                                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                                this.value = '';
                                previewContainer.style.display = 'none';
                                return;
                            }

                            // Validate file type
                            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                            if (!validTypes.includes(file.type)) {
                                alert('Format file tidak valid. Gunakan JPG, PNG, atau GIF.');
                                this.value = '';
                                previewContainer.style.display = 'none';
                                return;
                            }

                            // Show preview
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                photoPreview.src = e.target.result;
                                previewContainer.style.display = 'block';
                            };
                            reader.readAsDataURL(file);
                        } else {
                            previewContainer.style.display = 'none';
                        }
                    });
                }

                // Character counter for deskripsi
                const deskripsiInput = document.getElementById('deskripsi');
                const deskripsiCount = document.getElementById('deskripsiCount');

                if (deskripsiInput && deskripsiCount) {
                    function updateCharCount() {
                        const count = deskripsiInput.value.length;
                        deskripsiCount.textContent = count;

                        if (count > 450) {
                            deskripsiCount.parentElement.style.color = '#dc3545';
                        } else if (count > 400) {
                            deskripsiCount.parentElement.style.color = '#ffc107';
                        } else {
                            deskripsiCount.parentElement.style.color = 'var(--soft-gray)';
                        }
                    }

                    updateCharCount();
                    deskripsiInput.addEventListener('input', updateCharCount);
                }

                // Input formatting
                // NIK (only numbers, max 16 digits)
                const nikInput = document.getElementById('nik');
                if (nikInput) {
                    nikInput.addEventListener('input', function(e) {
                        e.target.value = e.target.value.replace(/\D/g, '').substring(0, 16);
                    });
                }

                // Phone number formatting
                const teleponInput = document.getElementById('telepon');
                if (teleponInput) {
                    teleponInput.addEventListener('input', function(e) {
                        e.target.value = e.target.value.replace(/[^\d+]/g, '');
                    });
                }

                // Name formatting (letters and spaces only)
                const namaInput = document.getElementById('nama');
                if (namaInput) {
                    namaInput.addEventListener('input', function(e) {
                        e.target.value = e.target.value.replace(/[^a-zA-Z\s]/g, '');
                        // Capitalize first letter of each word
                        e.target.value = e.target.value.replace(/\b\w/g, l => l.toUpperCase());
                    });
                }

                // Date validation
                const mulaiMenjabat = document.getElementById('mulai_menjabat');
                const selesaiMenjabat = document.getElementById('selesai_menjabat');

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

                if (mulaiMenjabat && selesaiMenjabat) {
                    mulaiMenjabat.addEventListener('change', validateDates);
                    selesaiMenjabat.addEventListener('change', validateDates);
                }

                // Form validation
                form.addEventListener('submit', function(e) {
                    const nama = document.getElementById('nama').value;
                    const posisi = document.getElementById('posisi').value;
                    const kategori = document.getElementById('kategori').value;
                    const urutan = document.getElementById('urutan').value;

                    // Basic validation
                    if (!nama.trim()) {
                        e.preventDefault();
                        alert('Nama lengkap wajib diisi!');
                        return false;
                    }

                    if (nama.length < 2) {
                        e.preventDefault();
                        alert('Nama lengkap harus minimal 2 karakter!');
                        return false;
                    }

                    if (!posisi.trim()) {
                        e.preventDefault();
                        alert('Posisi/jabatan wajib diisi!');
                        return false;
                    }

                    if (!kategori) {
                        e.preventDefault();
                        alert('Kategori jabatan wajib dipilih!');
                        return false;
                    }

                    if (!urutan || urutan < 0) {
                        e.preventDefault();
                        alert('Urutan tampil harus diisi dengan angka valid!');
                        return false;
                    }

                    // NIK validation if provided
                    const nik = document.getElementById('nik').value;
                    if (nik && nik.length !== 16) {
                        e.preventDefault();
                        alert('NIK harus 16 digit!');
                        return false;
                    }

                    // Email validation if provided
                    const email = document.getElementById('email').value;
                    if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                        e.preventDefault();
                        alert('Format email tidak valid!');
                        return false;
                    }

                    if (hasChanges) {
                        const confirmMessage = 'Apakah Anda yakin ingin menyimpan perubahan data ini?';
                        if (!confirm(confirmMessage)) {
                            e.preventDefault();
                            return false;
                        }
                    }

                    // Show loading state
                    saveBtn.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
                    saveBtn.disabled = true;
                });

                // Auto-hide alerts after 5 seconds
                setTimeout(function() {
                    const alerts = document.querySelectorAll('.alert');
                    alerts.forEach(alert => {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    });
                }, 5000);

                // Keyboard shortcuts
                document.addEventListener('keydown', function(e) {
                    if (e.ctrlKey && e.key === 's') {
                        e.preventDefault();
                        form.submit();
                    }

                    if (e.key === 'Escape') {
                        window.location.href = '{{ route('admin.struktur-desa.show', $struktur_desa) }}';
                    }
                });

                // Initial check for changes
                checkForChanges();
            });
        </script>
    @endpush

    @push('style')
        <style>
            /* Page Header Styles */
            .page-header {
                margin-bottom: 2rem;
            }

            .breadcrumb-item a {
                color: var(--primary-green);
                text-decoration: none;
            }

            .breadcrumb-item a:hover {
                color: var(--accent-orange);
            }

            .page-title {
                font-size: 1.8rem;
                font-weight: 700;
                color: var(--primary-green);
                margin-bottom: 0.5rem;
            }

            [data-theme="dark"] .page-title {
                color: var(--light-green);
            }

            .page-subtitle {
                color: var(--soft-gray);
                font-size: 1rem;
            }

            /* Action Buttons */
            .action-buttons {
                display: flex;
                gap: 1rem;
                margin-bottom: 1.5rem;
                flex-wrap: wrap;
            }

            /* Changes Summary */
            .changes-summary {
                background: linear-gradient(135deg, #fff3cd, #ffeaa7);
                border: 1px solid #ffc107;
                border-radius: 15px;
                padding: 1rem 1.5rem;
                margin-bottom: 1.5rem;
                opacity: 0;
                max-height: 0;
                overflow: hidden;
                transition: all 0.4s ease;
            }

            .changes-summary.show {
                opacity: 1;
                max-height: 300px;
                margin-bottom: 1.5rem;
            }

            [data-theme="dark"] .changes-summary {
                background: linear-gradient(135deg, #2d2d2d, #3d3d3d);
                border-color: #ffc107;
            }

            .changes-header {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-weight: 600;
                color: #856404;
                margin-bottom: 0.5rem;
            }

            [data-theme="dark"] .changes-header {
                color: #ffc107;
            }

            .changes-summary ul {
                margin: 0;
                padding-left: 1.5rem;
                list-style-type: disc;
            }

            .changes-summary li {
                color: #856404;
                font-size: 0.9rem;
                margin-bottom: 0.25rem;
            }

            [data-theme="dark"] .changes-summary li {
                color: #e9ecef;
            }

            /* Form Container */
            .form-container {
                background: var(--warm-white);
                border-radius: 20px;
                padding: 2rem;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
                border: 1px solid rgba(0, 0, 0, 0.05);
            }

            /* Form Header */
            .form-header {
                text-align: center;
                margin-bottom: 2rem;
                padding-bottom: 1.5rem;
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
                margin: 0 auto 1rem;
                font-size: 2rem;
                color: white;
                box-shadow: 0 8px 25px rgba(255, 140, 66, 0.3);
            }

            .form-title {
                font-size: 1.8rem;
                font-weight: 700;
                color: var(--primary-green);
                margin-bottom: 0.5rem;
            }

            [data-theme="dark"] .form-title {
                color: var(--light-green);
            }

            .form-subtitle {
                color: var(--soft-gray);
                font-size: 1rem;
            }

            /* Form Sections */
            .form-section {
                margin-bottom: 2rem;
                padding-bottom: 2rem;
                border-bottom: 1px solid var(--cream);
            }

            .form-section:last-of-type {
                border-bottom: none;
                margin-bottom: 0;
            }

            .section-title {
                font-size: 1.2rem;
                font-weight: 600;
                color: var(--primary-green);
                margin-bottom: 1.5rem;
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            [data-theme="dark"] .section-title {
                color: var(--light-green);
            }

            .section-icon {
                width: 40px;
                height: 40px;
                border-radius: 12px;
                background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.1rem;
            }

            /* Input Groups */
            .input-group-identity {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1.5rem;
            }

            .input-group-social {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 1rem;
            }

            /* Form Controls */
            .form-label {
                font-weight: 600;
                color: var(--primary-green);
                margin-bottom: 0.5rem;
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
                padding: 0.75rem 1rem;
                transition: all 0.3s ease;
                background: var(--warm-white);
                font-size: 0.95rem;
            }

            .form-control:focus,
            .form-select:focus {
                border-color: var(--accent-orange);
                box-shadow: 0 0 0 0.2rem rgba(255, 140, 66, 0.25);
                background: var(--warm-white);
            }

            .form-control.change-indicator.changed,
            .form-select.change-indicator.changed {
                border-color: var(--accent-orange);
                background: rgba(255, 140, 66, 0.05);
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
                margin-top: 0.25rem;
            }

            .invalid-feedback {
                font-size: 0.8rem;
                color: #dc3545;
                margin-top: 0.25rem;
            }

            .input-group-text {
                background: var(--cream);
                border-color: rgba(0, 0, 0, 0.1);
                color: var(--soft-gray);
                border-radius: 12px 0 0 12px;
            }

            .input-group .form-control {
                border-radius: 0 12px 12px 0;
            }

            [data-theme="dark"] .input-group-text {
                background: rgba(255, 255, 255, 0.1);
                border-color: rgba(255, 255, 255, 0.2);
                color: #e9ecef;
            }

            /* Character Counter */
            .char-counter {
                text-align: right;
                font-size: 0.75rem;
                color: var(--soft-gray);
                margin-top: 0.25rem;
                transition: color 0.3s ease;
            }

            /* Photo Upload */
            .photo-upload-container {
                display: grid;
                grid-template-columns: auto 1fr auto;
                gap: 2rem;
                align-items: center;
                padding: 1.5rem;
                background: var(--cream);
                border-radius: 15px;
                border: 2px dashed var(--accent-orange);
            }

            [data-theme="dark"] .photo-upload-container {
                background: rgba(255, 255, 255, 0.05);
            }

            .current-photo,
            .preview-photo {
                text-align: center;
            }

            .current-photo-img,
            .preview-photo-img {
                width: 120px;
                height: 120px;
                border-radius: 15px;
                object-fit: cover;
                border: 3px solid var(--accent-orange);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease;
            }

            .current-photo-img:hover,
            .preview-photo-img:hover {
                transform: scale(1.05);
            }

            .current-photo-label,
            .preview-photo-label {
                font-size: 0.8rem;
                font-weight: 600;
                color: var(--primary-green);
                margin-top: 0.5rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            [data-theme="dark"] .current-photo-label,
            [data-theme="dark"] .preview-photo-label {
                color: var(--light-green);
            }

            .upload-controls {
                flex: 1;
            }

            /* Form Actions */
            .form-actions {
                background: var(--cream);
                margin: 2rem -2rem -2rem -2rem;
                padding: 1.5rem 2rem;
                border-radius: 0 0 20px 20px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 1rem;
                flex-wrap: wrap;
            }

            [data-theme="dark"] .form-actions {
                background: rgba(255, 255, 255, 0.05);
            }

            /* Button Styles */
            .btn {
                padding: 0.75rem 1.5rem;
                border-radius: 12px;
                font-weight: 600;
                transition: all 0.3s ease;
                border: 2px solid transparent;
            }

            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            }

            .btn-primary {
                background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
                border-color: var(--primary-green);
                color: white;
            }

            .btn-primary:hover {
                background: linear-gradient(135deg, var(--secondary-green), var(--primary-green));
            }

            .btn-warning {
                background: linear-gradient(135deg, #ffc107, #ffb300);
                border-color: #ffc107;
                color: #212529;
            }

            .btn-warning:hover {
                background: linear-gradient(135deg, #ffb300, #ffc107);
                color: #212529;
            }

            .btn-outline-secondary {
                border-color: var(--soft-gray);
                color: var(--soft-gray);
            }

            .btn-outline-secondary:hover {
                background: var(--soft-gray);
                color: white;
            }

            .btn-outline-info {
                border-color: #17a2b8;
                color: #17a2b8;
            }

            .btn-outline-info:hover {
                background: #17a2b8;
                color: white;
            }

            .btn-outline-danger {
                border-color: #dc3545;
                color: #dc3545;
            }

            .btn-outline-danger:hover {
                background: #dc3545;
                color: white;
            }

            /* Loading State */
            .spinner-border-sm {
                width: 1rem;
                height: 1rem;
            }

            /* Form Check */
            .form-check {
                padding: 1rem;
                background: var(--cream);
                border-radius: 12px;
                border-left: 4px solid var(--primary-green);
            }

            [data-theme="dark"] .form-check {
                background: rgba(255, 255, 255, 0.05);
            }

            .form-check-input:checked {
                background-color: var(--primary-green);
                border-color: var(--primary-green);
            }

            .form-check-input:focus {
                border-color: var(--accent-orange);
                box-shadow: 0 0 0 0.25rem rgba(255, 140, 66, 0.25);
            }

            .form-check-label {
                font-weight: 600;
                color: var(--primary-green);
                cursor: pointer;
            }

            [data-theme="dark"] .form-check-label {
                color: var(--light-green);
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .form-container {
                    padding: 1.5rem;
                }

                .input-group-identity,
                .input-group-social {
                    grid-template-columns: 1fr;
                    gap: 1rem;
                }

                .photo-upload-container {
                    grid-template-columns: 1fr;
                    gap: 1.5rem;
                    text-align: center;
                }

                .form-actions {
                    flex-direction: column;
                    align-items: stretch;
                }

                .form-actions .btn {
                    width: 100%;
                    margin-bottom: 0.5rem;
                }

                .action-buttons {
                    flex-direction: column;
                }
            }

            /* Animation for form elements */
            .form-section {
                opacity: 0;
                transform: translateY(20px);
                animation: slideInUp 0.6s ease forwards;
            }

            .form-section:nth-child(1) {
                animation-delay: 0.1s;
            }

            .form-section:nth-child(2) {
                animation-delay: 0.2s;
            }

            .form-section:nth-child(3) {
                animation-delay: 0.3s;
            }

            .form-section:nth-child(4) {
                animation-delay: 0.4s;
            }

            @keyframes slideInUp {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Focus indicators */
            .form-control:focus,
            .form-select:focus {
                position: relative;
                z-index: 2;
            }

            /* Error state animation */
            .is-invalid {
                animation: shake 0.5s ease-in-out;
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

            /* Success state for changed fields */
            .change-indicator.changed {
                position: relative;
            }

            .change-indicator.changed::after {
                content: '●';
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                color: var(--accent-orange);
                font-size: 0.8rem;
                z-index: 10;
            }
        </style>
    @endpush
@endsection
