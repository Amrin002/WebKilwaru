@extends('template.main')

@section('title', $umkm->nama_umkm . ' - ' . config('app.village_name'))
@section('description', 'Detail produk ' . $umkm->nama_produk . ' dari UMKM ' . $umkm->nama_umkm . ' di ' .
    config('app.village_name'))

    @push('styles')
        <style>
            .umkm-hero {
                background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 89, 0.8)),
                    url('{{ $umkm->foto_produk_url }}') center/cover;
                color: white;
                padding: 100px 0 50px;
                margin-top: -80px;
                padding-top: 160px;
            }

            .product-detail-container {
                background: white;
                border-radius: 20px;
                padding: 40px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                position: relative;
                z-index: 10;
                margin-top: -50px;
            }

            .product-image {
                width: 100%;
                height: auto;
                max-height: 500px;
                object-fit: cover;
                border-radius: 15px;
            }

            .product-title h1 {
                font-weight: 700;
                color: var(--primary-green);
            }

            .product-meta {
                color: var(--soft-gray);
                font-size: 0.9rem;
            }

            .product-description h4 {
                font-weight: 600;
                color: var(--primary-green);
                margin-top: 2rem;
                padding-bottom: 10px;
                border-bottom: 2px solid var(--accent-orange);
            }

            .contact-section h4 {
                font-weight: 600;
                color: var(--primary-green);
                margin-top: 2rem;
                padding-bottom: 10px;
                border-bottom: 2px solid var(--accent-orange);
            }

            .contact-card {
                background: #f8f9fa;
                border-radius: 15px;
                padding: 25px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            }

            .contact-item {
                display: flex;
                align-items: center;
                margin-bottom: 10px;
                font-size: 1rem;
                gap: 15px;
            }

            .contact-item .contact-label {
                display: flex;
                align-items: center;
                gap: 10px;
                flex-shrink: 0;
                color: #333;
            }

            .contact-item i {
                font-size: 1.2rem;
                width: 30px;
                flex-shrink: 0;
            }

            .btn-whatsapp-primary {
                background: var(--accent-orange);
                color: white;
                font-weight: 600;
                border-radius: 10px;
                padding: 12px;
                text-decoration: none;
                transition: all 0.3s ease;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
            }

            .btn-whatsapp-primary:hover {
                background-color: #e07a35;
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(255, 140, 66, 0.4);
            }

            /* Gaya untuk tombol media sosial yang diperbarui */
            .social-link-btn {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 10px;
                border-radius: 10px;
                text-decoration: none;
                color: white;
                transition: all 0.3s ease;
                font-weight: 600;
                gap: 8px;
            }

            .social-link-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }

            .btn-facebook {
                background-color: #3b5998;
            }

            .btn-instagram {
                background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
            }

            .btn-tiktok {
                background-color: #000000;
            }
        </style>
    @endpush

@section('content')
    <section class="umkm-hero"
        style="background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 89, 0.8)), url('{{ $umkm->foto_produk_url }}') center/cover no-repeat;">
        <div class="container">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-4">{{ $umkm->nama_umkm }}</h1>
                <p class="lead">{{ $umkm->nama_produk }}</p>
                <div class="mt-4">
                    <span class="badge rounded-pill bg-primary" style="background-color: var(--accent-orange) !important;">
                        <i class="bi bi-tag me-1"></i> {{ $umkm->kategori_label }}
                    </span>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="product-detail-container">
                        @if ($umkm->foto_produk)
                            <div class="text-center mb-4">
                                <img src="{{ $umkm->foto_produk_url }}" alt="Foto Produk {{ $umkm->nama_umkm }}"
                                    class="product-image">
                            </div>
                        @endif

                        <div class="product-title-section mb-4">
                            <h1 class="product-title">{{ $umkm->nama_produk }}</h1>
                            <p class="product-meta">
                                Dari: **{{ $umkm->nama_umkm }}** | Pemilik: **{{ $umkm->nama_pemilik }}**
                            </p>
                        </div>

                        <div class="product-description">
                            <h4>Deskripsi Produk / Jasa</h4>
                            <p>{{ $umkm->deskripsi_produk }}</p>
                        </div>

                        <div class="contact-section mt-5">
                            <h4>Hubungi Penjual</h4>
                            <div class="contact-card">
                                <div class="row g-3">
                                    {{-- Tombol WhatsApp --}}
                                    <div class="col-12">
                                        <a href="{{ $umkm->whatsapp_url }}" target="_blank" class="btn-whatsapp-primary">
                                            <i class="bi bi-whatsapp"></i>Pesan Sekarang
                                        </a>
                                    </div>

                                    {{-- Tombol media sosial lainnya --}}
                                    @if ($umkm->link_facebook || $umkm->link_instagram || $umkm->link_tiktok)
                                        <div class="col-12">
                                            <div class="row g-3">
                                                @if ($umkm->link_facebook)
                                                    <div class="col-md-6">
                                                        <a href="{{ $umkm->link_facebook }}" target="_blank"
                                                            class="social-link-btn btn-facebook w-100">
                                                            <i class="fab fa-facebook-f"></i> Facebook
                                                        </a>
                                                    </div>
                                                @endif
                                                @if ($umkm->link_instagram)
                                                    <div class="col-md-6">
                                                        <a href="{{ $umkm->link_instagram }}" target="_blank"
                                                            class="social-link-btn btn-instagram w-100">
                                                            <i class="fab fa-instagram"></i> Instagram
                                                        </a>
                                                    </div>
                                                @endif
                                                @if ($umkm->link_tiktok)
                                                    <div class="col-md-6">
                                                        <a href="{{ $umkm->link_tiktok }}" target="_blank"
                                                            class="social-link-btn btn-tiktok w-100">
                                                            <i class="fab fa-tiktok"></i> TikTok
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
