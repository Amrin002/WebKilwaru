@extends('template.main')

@section('title', 'Detail UMKM - ' . $umkm->nama_umkm)
@section('description', 'Detail lengkap UMKM ' . $umkm->nama_umkm . ' dari desa ' . config('app.village_name'))

@push('styles')
    <style>
        /* Gaya Konsisten dengan halaman Tracking Surat */
        .umkm-hero {
            background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 89, 0.8)),
                url('https://images.unsplash.com/photo-1556761175-5973dc0f32e7?ixlib=rb-4.0.3&q=80&fm=jpg') center/cover no-repeat;
            color: white;
            padding: 100px 0 50px;
            margin-top: -80px;
            padding-top: 160px;
        }

        .hero-content {
            padding-top: 80px;
            /* Menambah padding internal agar teks turun ke bawah */
        }


        .track-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 10;
            margin-top: -50px;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: white;
        }

        .status-pending {
            background-color: #ffc107;
            color: #333;
        }

        .status-approved {
            background-color: var(--primary-green);
        }

        .status-rejected {
            background-color: var(--danger);
        }

        .detail-item {
            margin-bottom: 1rem;
        }

        .detail-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--soft-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
            display: block;
        }

        .detail-value {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--primary-green);
            padding: 8px 0;
            border-bottom: 2px solid var(--cream);
        }

        .umkm-title-section {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .umkm-title-section .icon-wrapper {
            width: 60px;
            height: 60px;
            background: var(--primary-green);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
            margin-right: 20px;
        }

        .umkm-title-section .title-text h4 {
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 0;
        }

        .umkm-title-section .title-text p {
            color: var(--soft-gray);
            margin-bottom: 0;
        }

        .umkm-info-card {
            background: var(--cream);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .umkm-info-card h5 {
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid rgba(0, 0, 0, 0.1);
        }

        .umkm-image-wrapper {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
        }

        .umkm-image-wrapper img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .btn-download-action {
            background: var(--accent-orange);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 15px 35px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 140, 66, 0.3);
        }

        .btn-download-action:hover {
            background: #e07a35;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 140, 66, 0.4);
        }
    </style>
@endpush

@section('content')
    <div class="hero-section"
        style="min-height: 40vh; background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 89, 0.8)), url('https://images.unsplash.com/photo-1556761175-5973dc0f32e7?ixlib=rb-4.0.3') center/cover no-repeat;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="hero-content text-center hero-animation">
                        <h1 class="display-5 fw-bold text-white mb-3">
                            <i class="fas fa-shop me-3"></i>
                            Detail UMKM
                        </h1>
                        <p class="lead text-white mb-4">
                            Informasi lengkap dari pendaftaran UMKM
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="floating-elements"></div>
    </div>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg p-4 fade-in">
                    <div class="umkm-title-section mb-4">
                        <div class="icon-wrapper">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="title-text">
                            <h4>Detail Pendaftaran UMKM</h4>
                            <p class="text-muted">Informasi lengkap terkait pendaftaran usaha Anda.</p>
                        </div>
                    </div>

                    @if ($umkm->isPending())
                        <div class="alert status-pending d-flex align-items-center justify-content-center">
                            <i class="bi bi-clock-fill me-2"></i>Status: Menunggu Verifikasi
                        </div>
                    @elseif ($umkm->isRejected())
                        <div class="alert status-rejected d-flex align-items-center justify-content-center">
                            <i class="bi bi-x-circle-fill me-2"></i>Status: Ditolak
                        </div>
                    @elseif ($umkm->isApproved())
                        <div class="alert status-approved d-flex align-items-center justify-content-center text-white">
                            <i class="bi bi-check-circle-fill me-2"></i>Status: Disetujui
                        </div>
                    @endif

                    <div class="umkm-info-card">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="detail-label">Nama UMKM</label>
                                    <div class="detail-value">{{ $umkm->nama_umkm }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="detail-label">Kategori</label>
                                    <div class="detail-value">{{ $umkm->kategori_label }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="detail-label">Nama Pemilik</label>
                                    <div class="detail-value">{{ $umkm->nama_pemilik }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <label class="detail-label">Nomor Telepon</label>
                                    <div class="detail-value">{{ $umkm->nomor_telepon }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="detail-item">
                                    <label class="detail-label">Nama Produk / Jasa</label>
                                    <div class="detail-value">{{ $umkm->nama_produk }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="detail-item">
                                    <label class="detail-label">Deskripsi Produk</label>
                                    <div class="detail-value">{{ $umkm->deskripsi_produk }}</div>
                                </div>
                            </div>
                            @if ($umkm->link_facebook || $umkm->link_instagram || $umkm->link_tiktok)
                                <div class="col-12">
                                    <div class="detail-item">
                                        <label class="detail-label">Media Sosial</label>
                                        <div class="detail-value">
                                            @if ($umkm->link_facebook)
                                                <a href="{{ $umkm->link_facebook }}" target="_blank"
                                                    class="text-decoration-none me-2"><i
                                                        class="bi bi-facebook me-1"></i>Facebook</a>
                                            @endif
                                            @if ($umkm->link_instagram)
                                                <a href="{{ $umkm->link_instagram }}" target="_blank"
                                                    class="text-decoration-none me-2"><i
                                                        class="bi bi-instagram me-1"></i>Instagram</a>
                                            @endif
                                            @if ($umkm->link_tiktok)
                                                <a href="{{ $umkm->link_tiktok }}" target="_blank"
                                                    class="text-decoration-none me-2"><i
                                                        class="bi bi-tiktok me-1"></i>TikTok</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($umkm->isRejected() && $umkm->catatan_admin)
                                <div class="col-12">
                                    <div class="detail-item">
                                        <label class="detail-label">Catatan Admin</label>
                                        <div class="detail-value text-danger fw-bold">{{ $umkm->catatan_admin }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if ($umkm->foto_produk)
                        <div class="umkm-image-wrapper mt-4">
                            <img src="{{ $umkm->foto_produk_url }}" alt="Foto Produk {{ $umkm->nama_umkm }}"
                                class="img-fluid">
                        </div>
                    @endif

                    <div class="mt-4 text-center">
                        <a href="{{ route('umkm.track') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Lacak Pendaftaran Lain
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
