@extends('layouts.main')

@push('style')
    <style>
        /* CSS umum untuk tampilan detail */
        .card-detail {
            background: var(--warm-white);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .detail-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--cream);
        }

        .detail-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 10px;
        }

        .detail-subtitle {
            color: var(--soft-gray);
            font-size: 1rem;
            margin-bottom: 0;
        }

        .detail-section {
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

        .detail-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .detail-list li {
            padding: 10px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .detail-list li:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: var(--primary-green);
        }

        .detail-value {
            color: var(--soft-gray);
            text-align: right;
        }

        .image-preview {
            max-width: 300px;
            height: auto;
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-content">
        <div class="page-header">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.umkm.index') }}">Kelola UMKM</a></li>
                    <li class="breadcrumb-item active">{{ $titleHeader }}</li>
                </ol>
            </nav>
            <h1 class="page-title">{{ $titleHeader }}</h1>
            <p class="page-subtitle">Detail lengkap data UMKM: {{ $umkm->nama_umkm }}</p>
        </div>

        <div class="card-detail">
            <div class="detail-header">
                <h2 class="detail-title">{{ $umkm->nama_umkm }}</h2>
                <p class="detail-subtitle">
                    <span
                        class="badge rounded-pill bg-{{ $umkm->status === 'approved' ? 'success' : ($umkm->status === 'rejected' ? 'danger' : 'warning') }} text-white">
                        {{ ucfirst($umkm->status) }}
                    </span>
                    @if ($umkm->isApproved())
                        <span class="text-secondary ms-2">oleh {{ $umkm->approvedBy->name ?? 'Admin' }} pada
                            {{ \Carbon\Carbon::parse($umkm->approved_at)->format('d M Y H:i') }}</span>
                    @endif
                </p>
            </div>

            <div class="detail-section">
                <h4 class="section-title">
                    <div class="section-icon"><i class="bi bi-person-fill"></i></div>
                    Data Pemilik
                </h4>
                <ul class="detail-list">
                    <li>
                        <span class="detail-label">Nama Pemilik:</span>
                        <span class="detail-value">{{ $umkm->penduduk->nama_lengkap ?? 'Tidak Ditemukan' }}</span>
                    </li>
                    <li>
                        <span class="detail-label">NIK:</span>
                        <span class="detail-value">{{ $umkm->nik }}</span>
                    </li>
                    <li>
                        <span class="detail-label">Nomor Telepon/WA:</span>
                        <span class="detail-value">{{ $umkm->nomor_telepon }}</span>
                    </li>
                </ul>
            </div>

            <div class="detail-section">
                <h4 class="section-title">
                    <div class="section-icon"><i class="bi bi-box-seam"></i></div>
                    Detail Usaha & Produk
                </h4>
                <ul class="detail-list">
                    <li>
                        <span class="detail-label">Nama Usaha:</span>
                        <span class="detail-value">{{ $umkm->nama_umkm }}</span>
                    </li>
                    <li>
                        <span class="detail-label">Kategori:</span>
                        <span class="detail-value">{{ $kategoriOptions[$umkm->kategori] ?? $umkm->kategori }}</span>
                    </li>
                    <li>
                        <span class="detail-label">Nama Produk/Jasa:</span>
                        <span class="detail-value">{{ $umkm->nama_produk }}</span>
                    </li>
                    <li>
                        <span class="detail-label">Deskripsi:</span>
                        <span class="detail-value">{{ $umkm->deskripsi_produk }}</span>
                    </li>
                </ul>
            </div>

            <div class="detail-section">
                <h4 class="section-title">
                    <div class="section-icon"><i class="bi bi-link-45deg"></i></div>
                    Media Sosial
                </h4>
                <ul class="detail-list">
                    <li>
                        <span class="detail-label">Facebook:</span>
                        <span class="detail-value">
                            @if ($umkm->link_facebook)
                                <a href="{{ $umkm->link_facebook }}" target="_blank">{{ $umkm->link_facebook }}</a>
                            @else
                                -
                            @endif
                        </span>
                    </li>
                    <li>
                        <span class="detail-label">Instagram:</span>
                        <span class="detail-value">
                            @if ($umkm->link_instagram)
                                <a href="{{ $umkm->link_instagram }}" target="_blank">{{ $umkm->link_instagram }}</a>
                            @else
                                -
                            @endif
                        </span>
                    </li>
                    <li>
                        <span class="detail-label">TikTok:</span>
                        <span class="detail-value">
                            @if ($umkm->link_tiktok)
                                <a href="{{ $umkm->link_tiktok }}" target="_blank">{{ $umkm->link_tiktok }}</a>
                            @else
                                -
                            @endif
                        </span>
                    </li>
                </ul>
            </div>

            <div class="detail-section">
                <h4 class="section-title">
                    <div class="section-icon"><i class="bi bi-image"></i></div>
                    Foto Produk
                </h4>
                @if ($umkm->foto_produk)
                    <img src="{{ asset('storage/umkm-photos/' . $umkm->foto_produk) }}" alt="Foto Produk"
                        class="img-fluid image-preview">
                @else
                    <p class="text-muted">Tidak ada foto produk yang diunggah.</p>
                @endif
            </div>

            @if ($umkm->catatan_admin)
                <div class="detail-section">
                    <h4 class="section-title">
                        <div class="section-icon" style="background: var(--dark-red);"><i class="bi bi-journal-text"></i>
                        </div>
                        Catatan Admin
                    </h4>
                    <div class="alert alert-danger">
                        {{ $umkm->catatan_admin }}
                    </div>
                </div>
            @endif


            <div class="action-buttons">
                <a href="{{ route('admin.umkm.edit', $umkm->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square me-2"></i>Edit UMKM
                </a>
                @if ($umkm->isPending() || $umkm->isRejected())
                    <form action="{{ route('admin.umkm.approve', $umkm->id) }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menyetujui UMKM ini?');">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i>Setujui
                        </button>
                    </form>
                @endif
                @if ($umkm->isPending() || $umkm->isApproved())
                    <a href="{{ route('admin.umkm.reject.form', $umkm->id) }}" class="btn btn-danger">
                        <i class="bi bi-x-circle me-2"></i>Tolak
                    </a>
                @endif
                <form action="{{ route('admin.umkm.destroy', $umkm->id) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus UMKM ini? Data akan hilang permanen!');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="bi bi-trash me-2"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
