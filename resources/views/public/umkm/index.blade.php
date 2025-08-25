@extends('template.main')

@section('title', 'UMKM Desa - ' . config('app.village_name', 'Desa Kilwaru'))
@section('description', 'Daftar UMKM warga ' . config('app.village_name', 'Desa Kilwaru') . ' yang telah disetujui.')

@push('styles')
    <style>
        /* Gaya konsisten dengan halaman SKTM */
        .umkm-hero {
            background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 89, 0.8)),
                url('https://images.unsplash.com/photo-1556761175-5973dc0f32e7?ixlib=rb-4.0.3&q=80&fm=jpg') center/cover;
            color: white;
            padding: 100px 0 50px;
            margin-top: -80px;
            padding-top: 160px;
        }

        .service-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            height: 100%;
            border: none;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .service-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--accent-orange), #ff6b1a);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 25px;
            transition: all 0.3s ease;
        }

        .service-card:hover .service-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .btn-service {
            background: var(--primary-green);
            border: none;
            border-radius: 50px;
            padding: 15px 35px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(45, 80, 22, 0.3);
            width: 100%;
            margin-top: 20px;
        }

        .btn-service:hover {
            background: var(--secondary-green);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(45, 80, 22, 0.4);
        }

        .btn-track {
            background: var(--accent-orange);
            border: none;
            border-radius: 50px;
            padding: 15px 35px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 140, 66, 0.3);
            width: 100%;
            margin-top: 20px;
        }

        .btn-track:hover {
            background: #e07a35;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 140, 66, 0.4);
        }

        .track-form {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 30px auto 0;
        }

        .track-input {
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            padding: 15px 20px;
            font-size: 16px;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .track-input:focus {
            border-color: var(--accent-orange);
            box-shadow: 0 0 0 0.2rem rgba(255, 140, 66, 0.25);
        }

        .info-section {
            background: var(--cream);
            padding: 80px 0;
        }

        .info-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .info-icon {
            width: 60px;
            height: 60px;
            background: var(--light-green);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 20px;
        }

        .step-number {
            width: 50px;
            height: 50px;
            background: var(--accent-orange);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            margin: 0 auto 15px;
        }

        .requirements-list {
            list-style: none;
            padding: 0;
        }

        .requirements-list li {
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
            position: relative;
            padding-left: 30px;
        }

        .requirements-list li:before {
            content: '✓';
            position: absolute;
            left: 0;
            color: var(--primary-green);
            font-weight: bold;
        }

        .requirements-list li:last-child {
            border-bottom: none;
        }

        .modal-content {
            border-radius: 20px;
            border: none;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            border-radius: 20px 20px 0 0;
        }

        .stats-counter {
            text-align: center;
            padding: 20px;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-green);
            display: block;
        }

        .stat-label {
            color: var(--soft-gray);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }

        /* Gaya khusus UMKM */
        .umkm-content {
            background: var(--warm-white);
            padding: 3rem 0;
        }

        .umkm-content-box {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
        }

        .umkm-header-tools {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .umkm-header-tools h4 {
            margin-bottom: 0;
            font-weight: 600;
            color: var(--primary-green);
        }

        .umkm-actions-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 15px;
        }

        .umkm-actions-buttons .btn {
            font-weight: 600;
            padding: 8px 20px;
            border-radius: 50px;
        }

        .umkm-search-bar {
            position: relative;
            flex-grow: 1;
        }

        .umkm-search-bar input {
            width: 100%;
            padding: 12px 50px 12px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 50px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .umkm-search-bar input:focus {
            border-color: var(--accent-orange);
            box-shadow: 0 0 0 0.2rem rgba(255, 140, 66, 0.25);
        }

        .umkm-search-bar button {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--accent-orange);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .umkm-search-bar button:hover {
            background: #e07a35;
        }

        .filter-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .filter-btn {
            background: white;
            border: 2px solid var(--primary-green);
            color: var(--primary-green);
            padding: 8px 20px;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: var(--primary-green);
            color: white;
            transform: translateY(-2px);
        }

        /* Card UMKM */
        .umkm-card {
            height: 100%;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            text-decoration: none;
            color: inherit;
        }

        .umkm-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .umkm-card .card-img-top {
            height: 220px;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .umkm-card:hover .card-img-top {
            transform: scale(1.05);
        }

        .umkm-card .card-title {
            color: var(--primary-green);
        }

        .umkm-meta {
            font-size: 0.875rem;
            color: var(--soft-gray);
        }

        .umkm-meta strong {
            color: var(--primary-green);
        }

        .category-badge {
            font-size: 0.75rem;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: white;
            background-color: var(--primary-green) !important;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: var(--soft-gray);
        }

        .empty-state i {
            font-size: 5rem;
            margin-bottom: 20px;
            color: var(--soft-gray);
        }

        /* Modal Style */
        .modal-content {
            border-radius: 20px;
            border: none;
        }

        .modal-header,
        .modal-footer {
            border: none;
        }

        .btn-modal-primary {
            background: var(--primary-green);
            color: white;
            border-radius: 10px;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .umkm-hero {
                padding: 80px 0 40px;
                padding-top: 140px;
            }

            .service-card {
                padding: 30px 20px;
                margin-bottom: 20px;
            }

            .btn-service,
            .btn-track {
                padding: 12px 25px;
                font-size: 1rem;
            }
        }
    </style>
@endpush

@section('content')
    <section class="umkm-hero">
        <div class="container">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-4">UMKM Desa</h1>
                <p class="lead">Temukan berbagai produk dan jasa kreatif dari UMKM warga
                    {{ config('app.village_name', 'Desa Kilwaru') }}</p>
            </div>
        </div>
    </section>

    <section class="py-5 umkm-content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="umkm-content-box">
                        <div class="umkm-header-tools mb-4">
                            <h4 class="mb-3 mb-md-0">Daftar Produk & Jasa</h4>
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <form action="{{ route('umkm.index') }}" method="GET" class="d-flex gap-2">
                                    <div class="umkm-search-bar">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Cari UMKM atau produk..." value="{{ request('search') }}">
                                        <button type="submit">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                    <a href="{{ route('umkm.create') }}" class="btn btn-primary d-none d-md-block">
                                        <i class="bi bi-person-plus-fill me-2"></i>Daftarkan UMKM
                                    </a>
                                    <button type="button" class="btn btn-outline-secondary d-none d-md-block"
                                        data-bs-toggle="modal" data-bs-target="#trackStatusModal">
                                        <i class="bi bi-search me-2"></i>Cek Status
                                    </button>
                                </form>
                                <a href="{{ route('umkm.create') }}" class="btn btn-primary d-block d-md-none w-100 mt-2">
                                    <i class="bi bi-person-plus-fill me-2"></i>Daftarkan UMKM
                                </a>
                                <button type="button" class="btn btn-outline-secondary d-block d-md-none w-100 mt-2"
                                    data-bs-toggle="modal" data-bs-target="#trackStatusModal">
                                    <i class="bi bi-search me-2"></i>Cek Status
                                </button>
                            </div>
                        </div>

                        <div class="filter-buttons">
                            @foreach ($kategoriOptions as $key => $value)
                                <a href="{{ route('umkm.index', ['kategori' => $key, 'search' => request('search')]) }}"
                                    class="filter-btn {{ request('kategori', 'semua') == $key ? 'active' : '' }}">
                                    {{ $value }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @forelse($umkms as $umkm)
                    <div class="col-md-4 col-lg-3 mb-4">
                        <a href="{{ route('umkm.productShow', $umkm->id) }}" class="umkm-card card h-100">
                            <div class="overflow-hidden">
                                <img src="{{ $umkm->foto_produk_url }}" class="card-img-top" alt="{{ $umkm->nama_umkm }}">
                            </div>
                            <div class="card-body">
                                <span class="category-badge mb-2 d-inline-block">{{ $umkm->kategori_label }}</span>
                                <h5 class="card-title mt-2">{{ Str::limit($umkm->nama_umkm, 25) }}</h5>
                                <p class="card-text text-muted">{{ $umkm->deskripsi_singkat }}</p>
                            </div>
                            <div class="card-footer bg-transparent border-top-0">
                                <div class="umkm-meta">
                                    <i class="bi bi-person-circle"></i>
                                    <strong>{{ $umkm->nama_pemilik ?? 'N/A' }}</strong>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="bi bi-shop"></i>
                            <h4>Belum Ada UMKM Ditemukan</h4>
                            <p class="text-muted">
                                @if (request('search') || request('kategori') != 'semua')
                                    Tidak ditemukan UMKM dengan kriteria yang Anda cari.
                                @else
                                    Belum ada UMKM yang terdaftar di desa ini.
                                @endif
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($umkms->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $umkms->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </section>

    <div class="modal fade" id="trackStatusModal" tabindex="-1" aria-labelledby="trackStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="trackStatusModalLabel">Cek Status Pendaftaran UMKM</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('umkm.track') }}" method="POST" id="trackForm">
                    @csrf
                    <div class="modal-body">
                        <p class="text-muted">
                            Masukkan Nomor Induk Kependudukan (NIK) Anda untuk melihat status pendaftaran UMKM.
                        </p>
                        <div class="mb-3">
                            <label for="nikInput" class="form-label">Nomor Induk Kependudukan (NIK)</label>
                            <input type="text" class="form-control" id="nikInput" name="nik" required
                                placeholder="Masukkan 16 digit NIK Anda" pattern="[0-9]{16}"
                                title="NIK harus 16 digit angka">
                        </div>
                        @if ($errors->has('nik'))
                            <div class="alert alert-danger mt-3">{{ $errors->first('nik') }}</div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-modal-primary">Cek Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function filterByCategory(slug) {
            const url = new URL(window.location);
            if (slug === 'semua') {
                url.searchParams.delete('kategori');
            } else {
                url.searchParams.set('kategori', slug);
            }
            url.searchParams.delete('page');
            window.location.href = url;
        }

        // Tampilkan modal jika ada error validasi NIK
        window.addEventListener('DOMContentLoaded', (event) => {
            @if ($errors->has('nik'))
                const trackModal = new bootstrap.Modal(document.getElementById('trackStatusModal'));
                trackModal.show();
            @endif
        });
    </script>
@endpush
