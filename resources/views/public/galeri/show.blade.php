@extends('template.main')

@section('title', $galeri->nama_kegiatan . ' - Galeri Foto - ' . config('app.village_name', 'Desa Kilwaru'))
@section('description', $galeri->keterangan ? Str::limit($galeri->keterangan, 150) : 'Foto kegiatan ' .
    $galeri->nama_kegiatan . ' di ' . config('app.village_name', 'Desa Kilwaru'))

    @push('styles')
        <style>
            .galeri-detail-hero {
                background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 89, 0.8)),
                    url('{{ $galeri->foto_url }}') center/cover;
                color: white;
                padding: 100px 0 50px;
                margin-top: -80px;
                padding-top: 160px;
                position: relative;
            }

            .galeri-detail-hero::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.3);
            }

            .galeri-detail-hero .container {
                position: relative;
                z-index: 2;
            }

            .breadcrumb-custom {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border-radius: 50px;
                padding: 10px 20px;
                margin-bottom: 30px;
            }

            .breadcrumb-custom a {
                color: rgba(255, 255, 255, 0.8);
                text-decoration: none;
            }

            .breadcrumb-custom .active {
                color: white;
            }

            .main-photo-container {
                background: white;
                border-radius: 20px;
                padding: 20px;
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
                margin-bottom: 30px;
                position: relative;
            }

            .main-photo {
                width: 100%;
                max-height: 600px;
                object-fit: contain;
                border-radius: 15px;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .main-photo:hover {
                transform: scale(1.02);
            }

            .photo-actions {
                position: absolute;
                top: 30px;
                right: 30px;
                display: flex;
                gap: 10px;
            }

            .photo-action-btn {
                background: rgba(0, 0, 0, 0.7);
                color: white;
                border: none;
                width: 45px;
                height: 45px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
                backdrop-filter: blur(10px);
            }

            .photo-action-btn:hover {
                background: var(--accent-orange);
                color: white;
                transform: scale(1.1);
            }

            .photo-info-card {
                background: white;
                border-radius: 20px;
                padding: 30px;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
                margin-bottom: 30px;
            }

            .photo-title {
                font-size: 2rem;
                font-weight: 700;
                color: var(--primary-green);
                margin-bottom: 20px;
                line-height: 1.3;
            }

            .photo-meta {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                margin-bottom: 20px;
                padding-bottom: 20px;
                border-bottom: 2px solid #f0f0f0;
            }

            .meta-item {
                display: flex;
                align-items: center;
                gap: 8px;
                color: var(--soft-gray);
                font-size: 0.95rem;
            }

            .meta-item i {
                color: var(--accent-orange);
            }

            .photo-description {
                font-size: 1.1rem;
                line-height: 1.7;
                color: #555;
                margin-bottom: 25px;
            }

            .share-buttons {
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
            }

            .share-btn {
                padding: 10px 20px;
                border-radius: 50px;
                border: none;
                color: white;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                font-size: 0.9rem;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .share-btn:hover {
                transform: translateY(-2px);
                color: white;
            }

            .share-facebook {
                background: #3b5998;
            }

            .share-facebook:hover {
                background: #2d4373;
            }

            .share-twitter {
                background: #1da1f2;
            }

            .share-twitter:hover {
                background: #0d8bd9;
            }

            .share-whatsapp {
                background: #25d366;
            }

            .share-whatsapp:hover {
                background: #1ebe57;
            }

            .share-copy {
                background: var(--soft-gray);
            }

            .share-copy:hover {
                background: var(--accent-orange);
            }

            .related-photos {
                background: white;
                border-radius: 20px;
                padding: 30px;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            }

            .related-photo-card {
                transition: all 0.3s ease;
                border-radius: 15px;
                overflow: hidden;
                margin-bottom: 20px;
            }

            .related-photo-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            }

            .related-photo-img {
                width: 100%;
                height: 200px;
                object-fit: cover;
                cursor: pointer;
            }

            .related-photo-body {
                padding: 15px;
                background: white;
            }

            .related-photo-title {
                font-size: 1rem;
                font-weight: 600;
                color: var(--primary-green);
                margin-bottom: 8px;
                line-height: 1.3;
            }

            .related-photo-date {
                font-size: 0.85rem;
                color: var(--soft-gray);
            }

            .navigation-buttons {
                display: flex;
                justify-content: space-between;
                margin: 30px 0;
                gap: 15px;
            }

            .nav-btn {
                flex: 1;
                max-width: 300px;
                padding: 15px 20px;
                background: white;
                border: 2px solid var(--primary-green);
                color: var(--primary-green);
                text-decoration: none;
                border-radius: 15px;
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .nav-btn:hover {
                background: var(--primary-green);
                color: white;
                transform: translateY(-3px);
            }

            .nav-btn.disabled {
                opacity: 0.5;
                pointer-events: none;
            }

            /* Lightbox Modal */
            .lightbox-modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.95);
                z-index: 9999;
                align-items: center;
                justify-content: center;
            }

            .lightbox-modal.show {
                display: flex;
            }

            .lightbox-image {
                max-width: 95%;
                max-height: 95%;
                border-radius: 10px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            }

            .lightbox-close {
                position: absolute;
                top: 20px;
                right: 30px;
                color: white;
                font-size: 2.5rem;
                cursor: pointer;
                background: rgba(255, 255, 255, 0.2);
                width: 60px;
                height: 60px;
                border-radius: 30px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
                backdrop-filter: blur(10px);
            }

            .lightbox-close:hover {
                background: rgba(255, 255, 255, 0.3);
            }

            .lightbox-info {
                position: absolute;
                bottom: 30px;
                left: 30px;
                color: white;
                background: rgba(0, 0, 0, 0.8);
                padding: 20px 25px;
                border-radius: 15px;
                max-width: 500px;
                backdrop-filter: blur(10px);
            }

            .lightbox-title {
                font-size: 1.3rem;
                font-weight: 600;
                margin-bottom: 8px;
            }

            .lightbox-meta {
                font-size: 1rem;
                opacity: 0.9;
            }

            /* Download progress */
            .download-progress {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: white;
                padding: 20px 30px;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                z-index: 10000;
                display: none;
            }

            .download-progress.show {
                display: block;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .photo-title {
                    font-size: 1.5rem;
                }

                .photo-meta {
                    flex-direction: column;
                    gap: 10px;
                }

                .main-photo-container {
                    padding: 15px;
                }

                .photo-actions {
                    top: 25px;
                    right: 25px;
                }

                .photo-action-btn {
                    width: 40px;
                    height: 40px;
                }

                .navigation-buttons {
                    flex-direction: column;
                }

                .nav-btn {
                    max-width: 100%;
                }

                .related-photo-img {
                    height: 150px;
                }

                .lightbox-info {
                    bottom: 20px;
                    left: 20px;
                    right: 20px;
                    max-width: none;
                }
            }
        </style>
    @endpush

@section('content')
    <!-- Hero Section -->
    <section class="galeri-detail-hero">
        <div class="container">
            <!-- Breadcrumb -->
            <nav class="breadcrumb-custom">
                <a href="{{ route('home') }}">Beranda</a>
                <span class="mx-2">/</span>
                <a href="{{ route('public.galeri.index') }}">Galeri Foto</a>
                <span class="mx-2">/</span>
                <span class="active">{{ $galeri->nama_kegiatan }}</span>
            </nav>

            <div class="text-center">
                <h1 class="display-5 fw-bold mb-3">{{ $galeri->nama_kegiatan }}</h1>
                <p class="lead">
                    <i class="fas fa-calendar"></i> {{ $galeri->created_at->format('d F Y') }}
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Main Photo -->
                <div class="col-lg-8">
                    <div class="main-photo-container">
                        <div class="photo-actions">
                            <button class="photo-action-btn" onclick="downloadPhoto()" title="Download Foto">
                                <i class="fas fa-download"></i>
                            </button>
                            <button class="photo-action-btn" onclick="openLightbox()" title="Lihat Full Screen">
                                <i class="fas fa-expand"></i>
                            </button>
                            <button class="photo-action-btn" onclick="sharePhoto()" title="Bagikan Foto">
                                <i class="fas fa-share-alt"></i>
                            </button>
                        </div>

                        <img src="{{ $galeri->foto_url }}" alt="{{ $galeri->nama_kegiatan }}" class="main-photo"
                            onclick="openLightbox()">
                    </div>

                    <!-- Photo Info -->
                    <div class="photo-info-card">
                        <h2 class="photo-title">{{ $galeri->nama_kegiatan }}</h2>

                        <div class="photo-meta">
                            <div class="meta-item">
                                <i class="fas fa-calendar"></i>
                                <span>{{ $galeri->created_at->format('d F Y') }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-clock"></i>
                                <span>{{ $galeri->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-camera"></i>
                                <span>Foto Kegiatan</span>
                            </div>
                        </div>

                        @if ($galeri->keterangan)
                            <div class="photo-description">
                                {{ $galeri->keterangan }}
                            </div>
                        @endif

                        <!-- Share Buttons -->
                        <div class="share-buttons">
                            <a href="#" class="share-btn share-facebook" onclick="shareToFacebook(event)">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="#" class="share-btn share-twitter" onclick="shareToTwitter(event)">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="#" class="share-btn share-whatsapp" onclick="shareToWhatsApp(event)">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                            <button class="share-btn share-copy" onclick="copyPhotoLink()">
                                <i class="fas fa-link"></i> Copy Link
                            </button>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="navigation-buttons">
                        @php
                            $prevGaleri = \App\Models\Galeri::where('id', '<', $galeri->id)
                                ->orderBy('id', 'desc')
                                ->first();
                            $nextGaleri = \App\Models\Galeri::where('id', '>', $galeri->id)
                                ->orderBy('id', 'asc')
                                ->first();
                        @endphp

                        @if ($prevGaleri)
                            <a href="{{ route('public.galeri.show', $prevGaleri->id) }}" class="nav-btn">
                                <i class="fas fa-arrow-left"></i>
                                <div>
                                    <div style="font-size: 0.8rem; opacity: 0.7;">Foto Sebelumnya</div>
                                    <div>{{ Str::limit($prevGaleri->nama_kegiatan, 30) }}</div>
                                </div>
                            </a>
                        @else
                            <div class="nav-btn disabled">
                                <i class="fas fa-arrow-left"></i>
                                <span>Tidak ada foto sebelumnya</span>
                            </div>
                        @endif

                        @if ($nextGaleri)
                            <a href="{{ route('public.galeri.show', $nextGaleri->id) }}" class="nav-btn text-end">
                                <div>
                                    <div style="font-size: 0.8rem; opacity: 0.7;">Foto Selanjutnya</div>
                                    <div>{{ Str::limit($nextGaleri->nama_kegiatan, 30) }}</div>
                                </div>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        @else
                            <div class="nav-btn disabled text-end">
                                <span>Tidak ada foto selanjutnya</span>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Related Photos -->
                    <div class="related-photos">
                        <h5 class="mb-4">
                            <i class="fas fa-images text-primary me-2"></i>
                            Foto Lainnya
                        </h5>

                        @forelse($galeriLainnya as $related)
                            <div class="related-photo-card">
                                <img src="{{ $related->foto_url }}" alt="{{ $related->nama_kegiatan }}"
                                    class="related-photo-img"
                                    onclick="window.location.href='{{ route('public.galeri.show', $related->id) }}'">
                                <div class="related-photo-body">
                                    <h6 class="related-photo-title">
                                        <a href="{{ route('public.galeri.show', $related->id) }}"
                                            class="text-decoration-none">
                                            {{ Str::limit($related->nama_kegiatan, 50) }}
                                        </a>
                                    </h6>
                                    <div class="related-photo-date">
                                        <i class="fas fa-calendar"></i>
                                        {{ $related->created_at->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted text-center">
                                <i class="fas fa-images fa-2x mb-3 d-block"></i>
                                Belum ada foto lainnya
                            </p>
                        @endforelse

                        <div class="text-center mt-4">
                            <a href="{{ route('public.galeri.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-images"></i> Lihat Semua Foto
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lightbox Modal -->
    <div class="lightbox-modal" id="lightboxModal">
        <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
        <img class="lightbox-image" src="{{ $galeri->foto_url }}" alt="{{ $galeri->nama_kegiatan }}">
        <div class="lightbox-info">
            <div class="lightbox-title">{{ $galeri->nama_kegiatan }}</div>
            <div class="lightbox-meta">
                <i class="fas fa-calendar"></i> {{ $galeri->created_at->format('d F Y') }}
            </div>
        </div>
    </div>

    <!-- Download Progress -->
    <div class="download-progress" id="downloadProgress">
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="mt-2">Mengunduh foto...</div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Lightbox functions
        function openLightbox() {
            const modal = document.getElementById('lightboxModal');
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            const modal = document.getElementById('lightboxModal');
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        // Download photo function
        function downloadPhoto() {
            const progressEl = document.getElementById('downloadProgress');
            progressEl.classList.add('show');

            const link = document.createElement('a');
            link.href = '{{ $galeri->foto_url }}';
            link.download = '{{ Str::slug($galeri->nama_kegiatan) }}.jpg';
            link.target = '_blank';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            // Hide progress after 2 seconds
            setTimeout(() => {
                progressEl.classList.remove('show');
                showToast('Foto berhasil diunduh!', 'success');
            }, 2000);
        }

        // Share functions
        function sharePhoto() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $galeri->nama_kegiatan }}',
                    text: '{{ $galeri->keterangan ?? 'Foto kegiatan ' . $galeri->nama_kegiatan }}',
                    url: window.location.href
                }).catch(console.error);
            } else {
                copyPhotoLink();
            }
        }

        function shareToFacebook(event) {
            event.preventDefault();
            const url = encodeURIComponent(window.location.href);
            const title = encodeURIComponent('{{ $galeri->nama_kegiatan }}');
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}&quote=${title}`,
                '_blank', 'width=600,height=400');
        }

        function shareToTwitter(event) {
            event.preventDefault();
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent(
                '{{ $galeri->nama_kegiatan }} - {{ config('app.village_name', 'Desa Kilwaru') }}');
            window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`,
                '_blank', 'width=600,height=400');
        }

        function shareToWhatsApp(event) {
            event.preventDefault();
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent(
                `{{ $galeri->nama_kegiatan }} - Lihat foto kegiatan di {{ config('app.village_name', 'Desa Kilwaru') }}: ${window.location.href}`
            );
            window.open(`https://wa.me/?text=${text}`, '_blank');
        }

        function copyPhotoLink() {
            const url = window.location.href;

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url).then(function() {
                    showToast('Link foto berhasil disalin!', 'success');
                }).catch(function() {
                    fallbackCopyLink(url);
                });
            } else {
                fallbackCopyLink(url);
            }
        }

        function fallbackCopyLink(text) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.opacity = '0';
            document.body.appendChild(textArea);
            textArea.select();

            try {
                document.execCommand('copy');
                showToast('Link foto berhasil disalin!', 'success');
            } catch (err) {
                showToast('Gagal menyalin link', 'error');
            }

            document.body.removeChild(textArea);
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.textContent = message;
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#28a745' : '#dc3545'};
                color: white;
                padding: 12px 24px;
                border-radius: 10px;
                z-index: 10000;
                font-size: 0.9rem;
                font-weight: 600;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
                animation: slideIn 0.3s ease;
            `;

            document.body.appendChild(toast);
            setTimeout(() => {
                if (document.body.contains(toast)) {
                    document.body.removeChild(toast);
                }
            }, 3000);
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            switch (e.key) {
                case 'Escape':
                    closeLightbox();
                    break;
                case 'f':
                case 'F':
                    if (e.ctrlKey || e.metaKey) {
                        e.preventDefault();
                        openLightbox();
                    }
                    break;
                case 's':
                case 'S':
                    if (e.ctrlKey || e.metaKey) {
                        e.preventDefault();
                        downloadPhoto();
                    }
                    break;
                case 'ArrowLeft':
                    @if ($prevGaleri)
                        window.location.href = '{{ route('public.galeri.show', $prevGaleri->id) }}';
                    @endif
                    break;
                case 'ArrowRight':
                    @if ($nextGaleri)
                        window.location.href = '{{ route('public.galeri.show', $nextGaleri->id) }}';
                    @endif
                    break;
            }
        });

        // Close lightbox when clicking outside image
        document.getElementById('lightboxModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLightbox();
            }
        });

        // Image lazy loading for related photos
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        if (img.dataset.src) {
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                            imageObserver.unobserve(img);
                        }
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }

        // Add slide in animation CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
        `;
        document.head.appendChild(style);

        // Analytics - track photo view (optional)
        // You can add analytics tracking here
        console.log('Photo viewed:', '{{ $galeri->nama_kegiatan }}');
    </script>
@endpush
