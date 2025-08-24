@extends('template.main')

@section('title', 'Pendaftaran Berhasil - ' . config('app.village_name', 'Desa Kilwaru'))
@section('description',
    'Konfirmasi pendaftaran UMKM berhasil untuk warga ' .
    config(
    'app.village_name',
    'Desa
    Kilwaru',
    ))

    @push('styles')
        <style>
            /* Gaya konsisten dengan halaman pendaftaran dan surat */
            .umkm-hero {
                background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 89, 0.8)),
                    url('https://images.unsplash.com/photo-1556761175-5973dc0f32e7?ixlib=rb-4.0.3&q=80&fm=jpg') center/cover;
                color: white;
                padding: 100px 0 50px;
                margin-top: -80px;
                padding-top: 160px;
            }

            .success-card {
                background: white;
                border-radius: 20px;
                padding: 40px 30px;
                text-align: center;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
                height: 100%;
                border: none;
                max-width: 700px;
                margin: 0 auto;
            }

            .success-icon {
                font-size: 5rem;
                color: var(--primary-green);
                margin-bottom: 20px;
            }

            .success-title {
                font-weight: 700;
                color: var(--primary-green);
                margin-bottom: 10px;
            }

            .success-description {
                color: var(--soft-gray);
                margin-bottom: 30px;
            }

            .umkm-detail-box {
                background: #f8f9fa;
                border-radius: 15px;
                padding: 20px;
                margin-bottom: 30px;
                text-align: left;
            }

            .umkm-detail-box h6 {
                font-weight: 600;
                color: var(--primary-green);
                margin-bottom: 10px;
            }

            .umkm-detail-box p {
                margin-bottom: 5px;
                color: var(--soft-gray);
            }

            .umkm-detail-box span {
                font-weight: 500;
                color: var(--primary-green);
            }

            .btn-action-group {
                display: flex;
                justify-content: center;
                gap: 15px;
                flex-wrap: wrap;
            }

            .btn-back-to-home,
            .btn-track-status {
                font-weight: 600;
                padding: 12px 30px;
                border-radius: 50px;
                transition: all 0.3s ease;
                text-decoration: none;
            }

            .btn-back-to-home {
                background: transparent;
                border: 2px solid var(--primary-green);
                color: var(--primary-green);
            }

            .btn-back-to-home:hover {
                background: var(--primary-green);
                color: white;
            }

            .btn-track-status {
                background: var(--accent-orange);
                border: none;
                color: white;
            }

            .btn-track-status:hover {
                background: #e07a35;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(255, 140, 66, 0.4);
            }
        </style>
    @endpush

@section('content')
    <section class="umkm-hero">
        <div class="container">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-4">Pendaftaran Berhasil</h1>
                <p class="lead">Terima kasih atas partisipasi Anda!</p>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="success-card">
                <i class="bi bi-check-circle-fill success-icon"></i>
                <h3 class="success-title">Pengajuan UMKM Berhasil Diterima</h3>
                <p class="success-description">
                    Pendaftaran UMKM Anda dengan nama usaha **{{ $umkm->nama_umkm }}** telah berhasil kami terima.
                    Mohon tunggu proses verifikasi dari admin desa. Anda bisa melacak statusnya kapan saja.
                </p>

                <div class="umkm-detail-box">
                    <h6>Detail Pendaftaran Anda:</h6>
                    <p>Nama UMKM: <span>{{ $umkm->nama_umkm }}</span></p>
                    <p>Nama Produk: <span>{{ $umkm->nama_produk }}</span></p>
                    <p>Status: <span>{!! $umkm->status_badge !!}</span></p>
                    <p>Diajukan pada: <span>{{ $umkm->created_at->format('d M Y, H:i') }}</span></p>
                </div>

                <div class="btn-action-group">
                    <a href="{{ route('umkm.index') }}" class="btn btn-back-to-home">
                        <i class="bi bi-house me-2"></i>Kembali ke Halaman UMKM
                    </a>
                    <a href="{{ route('umkm.track', ['nik' => $umkm->nik]) }}" class="btn btn-track-status">
                        <i class="bi bi-binoculars me-2"></i>Lacak Status
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
