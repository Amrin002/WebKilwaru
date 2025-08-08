{{-- Edit Kategori Berita --}}
@extends('layouts.main')

@push('style')
    <style>
        /* Edit Kategori Berita Styles */
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

        .form-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        [data-theme="dark"] .form-title {
            color: var(--light-green);
        }

        /* Form Styles */
        .form-label {
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        [data-theme="dark"] .form-label {
            color: var(--light-green);
        }

        .form-label.required::after {
            content: " *";
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

        [data-theme="dark"] .form-control:focus,
        [data-theme="dark"] .form-select:focus {
            background: var(--warm-white);
            color: #333;
        }

        .form-text {
            font-size: 0.8rem;
            color: var(--soft-gray);
            margin-top: 5px;
        }

        /* Color Picker Styles */
        .color-picker-container {
            position: relative;
        }

        .color-input-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .color-preview {
            width: 50px;
            height: 50px;
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .color-preview:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .color-preview::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path fill="white" d="M12.5 6a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 .5-.5h9z"/></svg>') center/contain no-repeat;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .color-preview:hover::after {
            opacity: 1;
        }

        .color-input {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .predefined-colors {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            gap: 8px;
            margin-top: 10px;
        }

        .color-option {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            position: relative;
        }

        .color-option:hover {
            transform: scale(1.1);
            border-color: var(--accent-orange);
        }

        .color-option.selected {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 2px rgba(45, 80, 22, 0.3);
        }

        /* Icon Picker Styles */
        .icon-picker-container {
            position: relative;
        }

        .icon-input-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .icon-preview {
            width: 50px;
            height: 50px;
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--primary-green);
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .icon-preview:hover {
            transform: scale(1.05);
            background: var(--accent-orange);
        }

        .icon-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--warm-white);
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            max-height: 200px;
            overflow-y: auto;
            display: none;
        }

        .icon-dropdown.show {
            display: block;
        }

        .icon-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 8px;
        }

        .icon-option {
            width: 35px;
            height: 35px;
            border: 2px solid transparent;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: var(--cream);
            color: var(--primary-green);
        }

        .icon-option:hover {
            background: var(--accent-orange);
            color: white;
            transform: scale(1.1);
        }

        .icon-option.selected {
            background: var(--primary-green);
            color: white;
            border-color: var(--accent-orange);
        }

        /* Slug Preview */
        .slug-preview {
            background: var(--cream);
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 12px 16px;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
            color: var(--soft-gray);
            margin-top: 8px;
        }

        .slug-url {
            color: var(--primary-green);
            font-weight: 600;
        }

        [data-theme="dark"] .slug-url {
            color: var(--light-green);
        }

        /* Switch Styles */
        .form-switch {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 0;
        }

        .switch-container {
            position: relative;
            width: 60px;
            height: 30px;
            background: #ccc;
            border-radius: 15px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .switch-container.active {
            background: var(--primary-green);
        }

        .switch-container::before {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 24px;
            height: 24px;
            background: white;
            border-radius: 50%;
            transition: transform 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .switch-container.active::before {
            transform: translateX(30px);
        }

        .switch-label {
            font-weight: 600;
            color: var(--primary-green);
        }

        [data-theme="dark"] .switch-label {
            color: var(--light-green);
        }

        /* Action Buttons */
        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            align-items: center;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        [data-theme="dark"] .form-actions {
            border-top-color: rgba(255, 255, 255, 0.1);
        }

        .btn {
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45, 80, 22, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #8e9297);
            color: white;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
        }

        .btn-outline-secondary {
            background: transparent;
            border: 2px solid var(--soft-gray);
            color: var(--soft-gray);
        }

        .btn-outline-secondary:hover {
            background: var(--soft-gray);
            color: white;
            transform: translateY(-2px);
        }

        /* Loading State */
        .btn-loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: 8px;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Alert Messages */
        .alert {
            border: none;
            border-radius: 15px;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-left: 4px solid;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.1);
            border-left-color: #28a745;
            color: #155724;
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

        .alert-dismissible .btn-close {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 1.2rem;
            opacity: 0.7;
            cursor: pointer;
        }

        /* Validation Styles */
        .is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }

        .invalid-feedback {
            display: block;
            font-size: 0.8rem;
            color: #dc3545;
            margin-top: 5px;
        }

        /* Character Counter */
        .char-counter {
            font-size: 0.8rem;
            color: var(--soft-gray);
            text-align: right;
            margin-top: 5px;
        }

        .char-counter.warning {
            color: #ffc107;
        }

        .char-counter.danger {
            color: #dc3545;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
                margin: 15px;
            }

            .form-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .predefined-colors {
                grid-template-columns: repeat(6, 1fr);
            }

            .icon-grid {
                grid-template-columns: repeat(4, 1fr);
            }

            .color-input-wrapper,
            .icon-input-wrapper {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }

        @media (max-width: 576px) {
            .page-header {
                padding: 20px;
                margin: 15px;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .form-title {
                font-size: 1.1rem;
            }

            .predefined-colors {
                grid-template-columns: repeat(4, 1fr);
            }

            .icon-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>
@endpush

@push('script')
    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });

            // Initialize form functionality
            initEditForm();
        });

        function initEditForm() {
            // Character counters
            initCharacterCounters();

            // Slug generation
            initSlugGeneration();

            // Color picker
            initColorPicker();

            // Icon picker
            initIconPicker();

            // Status switch
            initStatusSwitch();

            // Form validation
            initFormValidation();
        }

        // Character counters
        function initCharacterCounters() {
            const namaInput = document.getElementById('nama');
            const namaCounter = document.getElementById('namaCounter');
            const deskripsiInput = document.getElementById('deskripsi');
            const deskripsiCounter = document.getElementById('deskripsiCounter');

            function updateCounter(input, counter, maxLength) {
                const currentLength = input.value.length;
                counter.textContent = currentLength;

                // Update counter styling
                counter.parentElement.classList.remove('warning', 'danger');
                if (currentLength > maxLength * 0.8) {
                    counter.parentElement.classList.add('warning');
                }
                if (currentLength > maxLength * 0.9) {
                    counter.parentElement.classList.remove('warning');
                    counter.parentElement.classList.add('danger');
                }
            }

            // Initialize counters
            updateCounter(namaInput, namaCounter, 255);
            updateCounter(deskripsiInput, deskripsiCounter, 500);

            // Add event listeners
            namaInput.addEventListener('input', () => updateCounter(namaInput, namaCounter, 255));
            deskripsiInput.addEventListener('input', () => updateCounter(deskripsiInput, deskripsiCounter, 500));
        }

        // Slug generation
        function initSlugGeneration() {
            const namaInput = document.getElementById('nama');
            const slugInput = document.getElementById('slug');
            const slugPreview = document.getElementById('slugPreview');

            function generateSlug(text) {
                return text
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
                    .replace(/\s+/g, '-') // Replace spaces with hyphens
                    .replace(/-+/g, '-') // Replace multiple hyphens with single
                    .trim();
            }

            function updateSlugPreview() {
                const slugValue = slugInput.value || generateSlug(namaInput.value);
                slugPreview.textContent = slugValue || 'kategori-slug';
            }

            // Auto-generate slug from nama if slug is empty
            namaInput.addEventListener('input', function() {
                if (!slugInput.value) {
                    const generatedSlug = generateSlug(this.value);
                    slugInput.value = generatedSlug;
                }
                updateSlugPreview();
            });

            // Update preview when slug changes
            slugInput.addEventListener('input', updateSlugPreview);

            // Initialize preview
            updateSlugPreview();
        }

        // Color picker functionality
        function initColorPicker() {
            const colorInput = document.getElementById('warna');
            const colorText = document.getElementById('warnaText');
            const colorPreview = document.querySelector('.color-preview');
            const colorOptions = document.querySelectorAll('.color-option');

            function updateColor(color) {
                if (!/^#[0-9A-F]{6}$/i.test(color)) {
                    return false;
                }

                colorInput.value = color;
                colorText.value = color;
                colorPreview.style.backgroundColor = color;

                // Update selected color option
                colorOptions.forEach(option => {
                    option.classList.remove('selected');
                    if (option.dataset.color === color) {
                        option.classList.add('selected');
                    }
                });

                return true;
            }

            // Color input change
            colorInput.addEventListener('change', function() {
                updateColor(this.value);
            });

            // Text input change
            colorText.addEventListener('input', function() {
                if (this.value.length === 7 && this.value.startsWith('#')) {
                    updateColor(this.value);
                }
            });

            // Predefined color options
            colorOptions.forEach(option => {
                option.addEventListener('click', function() {
                    updateColor(this.dataset.color);
                });
            });

            // Initialize with current color
            updateColor(colorInput.value);
        }

        // Icon picker functionality
        function initIconPicker() {
            const iconInput = document.getElementById('icon');
            const iconPreview = document.getElementById('iconPreview');
            const iconDisplay = document.getElementById('iconDisplay');
            const iconDropdown = document.getElementById('iconDropdown');
            const iconOptions = document.querySelectorAll('.icon-option');

            function updateIcon(iconClass) {
                iconInput.value = iconClass;
                iconDisplay.className = iconClass || 'bi bi-tag';

                // Update selected icon option
                iconOptions.forEach(option => {
                    option.classList.remove('selected');
                    if (option.dataset.icon === iconClass) {
                        option.classList.add('selected');
                    }
                });
            }

            // Toggle dropdown
            iconPreview.addEventListener('click', function(e) {
                e.stopPropagation();
                iconDropdown.classList.toggle('show');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!iconPreview.contains(e.target) && !iconDropdown.contains(e.target)) {
                    iconDropdown.classList.remove('show');
                }
            });

            // Icon input change
            iconInput.addEventListener('input', function() {
                updateIcon(this.value);
            });

            // Icon options click
            iconOptions.forEach(option => {
                option.addEventListener('click', function() {
                    updateIcon(this.dataset.icon);
                    iconDropdown.classList.remove('show');
                });
            });

            // Initialize with current icon
            updateIcon(iconInput.value);
        }

        // Status switch functionality
        function initStatusSwitch() {
            const statusSwitch = document.getElementById('statusSwitch');
            const statusLabel = document.getElementById('statusLabel');
            const isActiveInput = document.getElementById('isActiveInput');

            statusSwitch.addEventListener('click', function() {
                const isActive = !this.classList.contains('active');

                this.classList.toggle('active', isActive);
                isActiveInput.value = isActive ? '1' : '0';
                statusLabel.textContent = isActive ? 'Aktif' : 'Non-Aktif';
            });
        }

        // Form validation
        function initFormValidation() {
            const form = document.getElementById('editKategoriForm');
            const submitBtn = document.getElementById('submitBtn');

            form.addEventListener('submit', function(e) {
                // Add loading state
                submitBtn.classList.add('btn-loading');
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Memperbarui...';
                submitBtn.disabled = true;

                // Basic validation
                const nama = document.getElementById('nama').value.trim();
                const warna = document.getElementById('warna').value;
                const urutan = document.getElementById('urutan').value;

                if (!nama) {
                    e.preventDefault();
                    alert('Nama kategori harus diisi!');
                    resetSubmitButton();
                    return;
                }

                if (!warna || !/^#[0-9A-F]{6}$/i.test(warna)) {
                    e.preventDefault();
                    alert('Pilih warna yang valid!');
                    resetSubmitButton();
                    return;
                }

                if (!urutan || urutan < 0) {
                    e.preventDefault();
                    alert('Urutan harus berupa angka positif!');
                    resetSubmitButton();
                    return;
                }

                // If validation passes, show confirmation
                if (!confirm('Apakah Anda yakin ingin memperbarui kategori ini?')) {
                    e.preventDefault();
                    resetSubmitButton();
                    return;
                }
            });

            function resetSubmitButton() {
                submitBtn.classList.remove('btn-loading');
                submitBtn.innerHTML = '<i class="bi bi-check-lg"></i> Perbarui Kategori';
                submitBtn.disabled = false;
            }

            // Reset button if there's an error on page load
            if (document.querySelector('.alert-danger')) {
                resetSubmitButton();
            }
        }

        // Preview functionality
        function previewKategori() {
            const nama = document.getElementById('nama').value;
            const deskripsi = document.getElementById('deskripsi').value;
            const warna = document.getElementById('warna').value;
            const icon = document.getElementById('icon').value;
            const isActive = document.getElementById('isActiveInput').value === '1';

            if (!nama) {
                alert('Isi nama kategori terlebih dahulu!');
                return;
            }

            // Create preview modal (you can customize this)
            const previewContent = `
                <div style="padding: 20px; text-align: center;">
                    <div style="width: 60px; height: 60px; background: ${warna}; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; margin-bottom: 15px;">
                        <i class="${icon || 'bi bi-tag'}"></i>
                    </div>
                    <h4 style="margin-bottom: 10px; color: ${warna};">${nama}</h4>
                    <p style="color: #666; margin-bottom: 15px;">${deskripsi || 'Tidak ada deskripsi'}</p>
                    <span style="padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; background: ${isActive ? '#28a745' : '#6c757d'}; color: white;">
                        ${isActive ? 'Aktif' : 'Non-Aktif'}
                    </span>
                </div>
            `;

            // Show in a simple alert (you can replace with a proper modal)
            const previewWindow = window.open('', '_blank', 'width=400,height=300');
            previewWindow.document.write(`
                <html>
                    <head>
                        <title>Preview Kategori</title>
                        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
                    </head>
                    <body style="margin: 0; padding: 20px; font-family: 'Segoe UI', sans-serif;">
                        <h3 style="text-align: center; margin-bottom: 20px;">Preview Kategori</h3>
                        ${previewContent}
                        <div style="text-align: center; margin-top: 20px;">
                            <button onclick="window.close()" style="padding: 10px 20px; background: #6c757d; color: white; border: none; border-radius: 6px; cursor: pointer;">Tutup</button>
                        </div>
                    </body>
                </html>
            `);
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + S to save
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                document.getElementById('submitBtn').click();
            }

            // Escape to go back
            if (e.key === 'Escape') {
                if (confirm('Apakah Anda yakin ingin kembali? Perubahan yang belum disimpan akan hilang.')) {
                    window.location.href = '{{ route('admin.kategori-berita.index') }}';
                }
            }
        });

        // Auto-save draft functionality (optional)
        let autoSaveTimeout;

        function autoSaveDraft() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                const formData = {
                    nama: document.getElementById('nama').value,
                    slug: document.getElementById('slug').value,
                    deskripsi: document.getElementById('deskripsi').value,
                    warna: document.getElementById('warna').value,
                    icon: document.getElementById('icon').value,
                    urutan: document.getElementById('urutan').value,
                    is_active: document.getElementById('isActiveInput').value
                };

                // Save to localStorage
                localStorage.setItem('edit_kategori_draft_{{ $kategori->id }}', JSON.stringify(formData));

                // Show save indicator (optional)
                console.log('Draft disimpan otomatis');
            }, 2000);
        }

        // Add auto-save listeners to form inputs
        document.addEventListener('DOMContentLoaded', function() {
            const formInputs = document.querySelectorAll('#editKategoriForm input, #editKategoriForm textarea');
            formInputs.forEach(input => {
                input.addEventListener('input', autoSaveDraft);
            });

            // Load draft if exists (optional)
            const savedDraft = localStorage.getItem('edit_kategori_draft_{{ $kategori->id }}');
            if (savedDraft && confirm('Ditemukan draft yang tersimpan. Muat draft tersebut?')) {
                const draftData = JSON.parse(savedDraft);
                Object.keys(draftData).forEach(key => {
                    const element = document.getElementById(key);
                    if (element) {
                        element.value = draftData[key];
                        // Trigger events to update UI
                        element.dispatchEvent(new Event('input'));
                    }
                });
            }
        });

        // Clear draft on successful submission
        window.addEventListener('beforeunload', function(e) {
            const form = document.getElementById('editKategoriForm');
            if (form.dataset.submitted !== 'true') {
                // Only show warning if form has been modified
                const inputs = form.querySelectorAll('input, textarea');
                let isModified = false;
                inputs.forEach(input => {
                    if (input.defaultValue !== input.value) {
                        isModified = true;
                    }
                });

                if (isModified) {
                    e.preventDefault();
                    e.returnValue =
                        'Anda memiliki perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
                    return e.returnValue;
                }
            }
        });

        // Mark form as submitted to prevent beforeunload warning
        document.getElementById('editKategoriForm').addEventListener('submit', function() {
            this.dataset.submitted = 'true';
            // Clear draft on submission
            localStorage.removeItem('edit_kategori_draft_{{ $kategori->id }}');
        });
    </script>
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
                    <li class="breadcrumb-item active">Edit Kategori</li>
                </ol>
            </nav>
            <h1 class="page-title">Edit Kategori Berita</h1>
            <p class="page-subtitle">Perbarui informasi kategori berita</p>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i>
                <div>
                    <strong>Terdapat kesalahan pada form:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Edit Form -->
        <div class="form-container">
            <h4 class="form-title">
                <i class="bi bi-pencil-square"></i>
                Form Edit Kategori
            </h4>

            <form action="{{ route('admin.kategori-berita.update', $kategori->slug) }}" method="POST"
                id="editKategoriForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Nama Kategori -->
                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label required">Nama Kategori</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                            name="nama" value="{{ old('nama', $kategori->nama) }}" required maxlength="255"
                            placeholder="Masukkan nama kategori">
                        <div class="char-counter">
                            <span id="namaCounter">0</span>/255 karakter
                        </div>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Nama kategori akan ditampilkan di frontend</div>
                    </div>

                    <!-- Slug -->
                    <div class="col-md-6 mb-3">
                        <label for="slug" class="form-label">Slug URL</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug"
                            name="slug" value="{{ old('slug', $kategori->slug) }}" maxlength="255"
                            placeholder="otomatis-dibuat">
                        <div class="slug-preview">
                            <span class="slug-url">{{ url('kategori') }}/</span><span
                                id="slugPreview">{{ $kategori->slug }}</span>
                        </div>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Kosongkan untuk membuat otomatis dari nama</div>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3"
                        maxlength="500" placeholder="Deskripsi singkat tentang kategori ini">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                    <div class="char-counter">
                        <span id="deskripsiCounter">0</span>/500 karakter
                    </div>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Deskripsi akan ditampilkan sebagai penjelasan kategori</div>
                </div>

                <div class="row">
                    <!-- Warna -->
                    <div class="col-md-6 mb-3">
                        <label for="warna" class="form-label required">Warna Kategori</label>
                        <div class="color-picker-container">
                            <div class="color-input-wrapper">
                                <div class="color-preview"
                                    style="background-color: {{ old('warna', $kategori->warna) }}">
                                    <input type="color" class="color-input @error('warna') is-invalid @enderror"
                                        id="warna" name="warna" value="{{ old('warna', $kategori->warna) }}"
                                        required>
                                </div>
                                <input type="text" class="form-control" id="warnaText"
                                    value="{{ old('warna', $kategori->warna) }}" placeholder="#000000" maxlength="7">
                            </div>

                            <!-- Predefined Colors -->
                            <div class="predefined-colors">
                                <div class="color-option" style="background-color: #2d5016" data-color="#2d5016"></div>
                                <div class="color-option" style="background-color: #4a7c59" data-color="#4a7c59"></div>
                                <div class="color-option" style="background-color: #8fbc8f" data-color="#8fbc8f"></div>
                                <div class="color-option" style="background-color: #ff8c42" data-color="#ff8c42"></div>
                                <div class="color-option" style="background-color: #ffa726" data-color="#ffa726"></div>
                                <div class="color-option" style="background-color: #28a745" data-color="#28a745"></div>
                                <div class="color-option" style="background-color: #dc3545" data-color="#dc3545"></div>
                                <div class="color-option" style="background-color: #17a2b8" data-color="#17a2b8"></div>
                            </div>
                        </div>
                        @error('warna')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Pilih warna yang akan mewakili kategori ini</div>
                    </div>

                    <!-- Icon -->
                    <div class="col-md-6 mb-3">
                        <label for="icon" class="form-label">Icon Kategori</label>
                        <div class="icon-picker-container">
                            <div class="icon-input-wrapper">
                                <div class="icon-preview" id="iconPreview">
                                    <i class="{{ old('icon', $kategori->icon ?: 'bi bi-tag') }}" id="iconDisplay"></i>
                                </div>
                                <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                    id="icon" name="icon" value="{{ old('icon', $kategori->icon) }}"
                                    placeholder="bi bi-tag" maxlength="100">
                            </div>

                            <!-- Icon Dropdown -->
                            <div class="icon-dropdown" id="iconDropdown">
                                <div class="icon-grid">
                                    <div class="icon-option" data-icon="bi bi-tag"><i class="bi bi-tag"></i></div>
                                    <div class="icon-option" data-icon="bi bi-newspaper"><i class="bi bi-newspaper"></i>
                                    </div>
                                    <div class="icon-option" data-icon="bi bi-megaphone"><i class="bi bi-megaphone"></i>
                                    </div>
                                    <div class="icon-option" data-icon="bi bi-calendar-event"><i
                                            class="bi bi-calendar-event"></i></div>
                                    <div class="icon-option" data-icon="bi bi-trophy"><i class="bi bi-trophy"></i></div>
                                    <div class="icon-option" data-icon="bi bi-briefcase"><i class="bi bi-briefcase"></i>
                                    </div>
                                    <div class="icon-option" data-icon="bi bi-house"><i class="bi bi-house"></i></div>
                                    <div class="icon-option" data-icon="bi bi-people"><i class="bi bi-people"></i></div>
                                    <div class="icon-option" data-icon="bi bi-gear"><i class="bi bi-gear"></i></div>
                                    <div class="icon-option" data-icon="bi bi-heart"><i class="bi bi-heart"></i></div>
                                    <div class="icon-option" data-icon="bi bi-star"><i class="bi bi-star"></i></div>
                                    <div class="icon-option" data-icon="bi bi-flag"><i class="bi bi-flag"></i></div>
                                </div>
                            </div>
                        </div>
                        @error('icon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Gunakan Bootstrap Icons class (contoh: bi bi-tag)</div>
                    </div>
                </div>

                <div class="row">
                    <!-- Urutan -->
                    <div class="col-md-6 mb-3">
                        <label for="urutan" class="form-label required">Urutan Tampil</label>
                        <input type="number" class="form-control @error('urutan') is-invalid @enderror" id="urutan"
                            name="urutan" value="{{ old('urutan', $kategori->urutan) }}" required min="0"
                            max="9999" placeholder="1">
                        @error('urutan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Semakin kecil angka, semakin di atas urutannya</div>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status Kategori</label>
                        <div class="form-switch">
                            <div class="switch-container {{ old('is_active', $kategori->is_active) ? 'active' : '' }}"
                                id="statusSwitch">
                                <input type="hidden" name="is_active" id="isActiveInput"
                                    value="{{ old('is_active', $kategori->is_active) ? '1' : '0' }}">
                            </div>
                            <span class="switch-label" id="statusLabel">
                                {{ old('is_active', $kategori->is_active) ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </div>
                        <div class="form-text">Kategori aktif akan ditampilkan di frontend</div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('admin.kategori-berita.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                    <a href="{{ route('admin.kategori-berita.show', $kategori->slug) }}" class="btn btn-secondary">
                        <i class="bi bi-eye"></i>
                        Lihat Detail
                    </a>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="bi bi-check-lg"></i>
                        Perbarui Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
