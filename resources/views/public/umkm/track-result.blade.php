@extends('template.main')

@section('title', 'Hasil Pelacakan UMKM - ' . config('app.village_name', 'Desa Kilwaru'))
@section('description',
    'Hasil pelacakan status pendaftaran UMKM berdasarkan NIK di ' .
    config(
    'app.village_name',
    'Desa
    Kilwaru',
    ))

    @push('styles')
        <style>
            .umkm-hero {
                background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 89, 0.8)),
                    url('https://images.unsplash.com/photo-1556761175-5973dc0f32e7?ixlib=rb-4.0.3&q=80&fm=jpg') center/cover;
                color: white;
                padding: 100px 0 50px;
                margin-top: -80px;
                padding-top: 160px;
            }

            .result-card {
                background: white;
                border-radius: 20px;
                padding: 40px 30px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                position: relative;
                z-index: 10;
                margin-top: -50px;
            }

            .umkm-item {
                display: flex;
                align-items: center;
                padding: 20px;
                border-radius: 15px;
                margin-bottom: 20px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
                transition: all 0.3s ease;
            }

            .umkm-item:hover {
                background-color: var(--cream);
                transform: translateY(-5px);
            }

            .umkm-thumbnail {
                width: 80px;
                height: 60px;
                object-fit: cover;
                border-radius: 8px;
                margin-right: 20px;
                flex-shrink: 0;
            }

            .umkm-details {
                flex-grow: 1;
            }

            .umkm-title {
                font-weight: 700;
                color: var(--primary-green);
                margin-bottom: 5px;
            }

            .umkm-info {
                color: var(--soft-gray);
                font-size: 0.9rem;
            }

            .status-badge {
                font-weight: 600;
                font-size: 0.8rem;
                padding: 5px 10px;
                border-radius: 15px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: white;
                min-width: 120px;
                text-align: center;
            }

            .status-pending {
                background-color: var(--accent-orange);
            }

            .status-approved {
                background-color: var(--primary-green);
            }

            .status-rejected {
                background-color: var(--danger);
            }

            .btn-action-detail {
                background: var(--primary-green);
                color: white;
                border-radius: 50px;
                padding: 8px 20px;
                text-decoration: none;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .btn-action-detail:hover {
                background: var(--secondary-green);
            }

            .empty-state {
                text-align: center;
                padding: 60px 20px;
                color: var(--soft-gray);
            }

            .empty-state i {
                font-size: 4rem;
                margin-bottom: 20px;
                opacity: 0.5;
            }
        </style>
    @endpush

@section('content')
    <section class="umkm-hero">
        <div class="container">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-4">Hasil Pelacakan</h1>
                <p class="lead">Berikut adalah status pendaftaran UMKM untuk NIK yang Anda masukkan.</p>
            </div>
        </div>
    </section>

    <div class="container my-5">
        <div class="result-card">
            <h4 class="mb-4 fw-bold text-primary-green">Ditemukan {{ $umkms->count() }} Pendaftaran</h4>

            @forelse ($umkms as $umkm)
                <div class="umkm-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center flex-grow-1">
                        <img src="{{ $umkm->foto_produk_url }}" alt="{{ $umkm->nama_umkm }}" class="umkm-thumbnail">
                        <div class="umkm-details">
                            <div class="umkm-title">{{ $umkm->nama_umkm }}</div>
                            <div class="umkm-info">
                                {{ $umkm->kategori_label }} | Diajukan pada: {{ $umkm->created_at->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 mt-3 mt-md-0">
                        <span class="status-badge status-{{ strtolower($umkm->status) }}">
                            {{ ucfirst($umkm->status) }}
                        </span>
                        <a href="{{ route('umkm.show', $umkm->id) }}" class="btn btn-action-detail">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-x-circle"></i>
                    <h4>Tidak Ditemukan</h4>
                    <p class="text-muted">Tidak ada pendaftaran UMKM yang ditemukan dengan NIK tersebut. Pastikan NIK yang
                        Anda masukkan benar.</p>
                </div>
            @endforelse

            <div class="mt-4 text-center">
                <a href="{{ route('umkm.track') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Lacak Status Lain
                </a>
            </div>
        </div>
    </div>
@endsection
