@extends('template.main')

@section('title', 'APBDes Tahun ' . $apbdes->tahun . ' - ' . config('app.village_name', 'Desa Kilwaru'))
@section('description', 'Informasi Anggaran Pendapatan dan Belanja Desa (APBDes) tahun ' . $apbdes->tahun . ' ' .
    config('app.village_name', 'Desa Kilwaru'))

    @push('styles')
        <style>
            .apbdes-hero {
                background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 89, 0.8)),
                    url('https://images.unsplash.com/photo-1549880338-65ddcdfd017b?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2070&q=80') center/cover;
                color: white;
                padding: 100px 0 50px;
                margin-top: -80px;
                padding-top: 160px;
            }

            .apbdes-card {
                background: white;
                border-radius: 20px;
                padding: 30px;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
                border: 1px solid rgba(0, 0, 0, 0.05);
                margin-bottom: 25px;
            }

            .apbdes-card-header {
                text-align: center;
                margin-bottom: 30px;
                padding-bottom: 20px;
                border-bottom: 2px solid var(--cream);
            }

            .apbdes-card-title {
                font-size: 2.5rem;
                font-weight: 700;
                color: var(--primary-green);
            }

            .apbdes-meta-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
                margin-bottom: 25px;
            }

            .meta-item {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 15px 20px;
                background: var(--cream);
                border-radius: 12px;
                border: 1px solid rgba(0, 0, 0, 0.05);
            }

            .meta-icon {
                width: 40px;
                height: 40px;
                border-radius: 10px;
                background: linear-gradient(135deg, var(--accent-orange), #ffa726);
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.2rem;
                flex-shrink: 0;
            }

            .meta-content {
                flex: 1;
                min-width: 0;
            }

            .meta-label {
                font-size: 0.8rem;
                color: var(--soft-gray);
                margin-bottom: 2px;
                text-transform: uppercase;
                font-weight: 600;
                letter-spacing: 0.5px;
            }

            .meta-value {
                font-weight: 600;
                color: var(--primary-green);
                word-wrap: break-word;
            }

            .sidebar-widget {
                background: white;
                border-radius: 15px;
                padding: 25px;
                margin-bottom: 30px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            }

            .sidebar-widget h5 {
                color: var(--primary-green);
                margin-bottom: 20px;
                padding-bottom: 10px;
                border-bottom: 2px solid var(--accent-orange);
            }

            .sidebar-item {
                padding: 10px 0;
                border-bottom: 1px solid #f0f0f0;
                transition: all 0.3s ease;
            }

            .sidebar-item:last-child {
                border-bottom: none;
            }

            .sidebar-item:hover {
                padding-left: 10px;
                background: #f8f9fa;
                margin: 0 -10px;
                padding-right: 10px;
            }

            .empty-state {
                text-align: center;
                padding: 80px 20px;
            }

            .empty-state i {
                font-size: 5rem;
                color: var(--soft-gray);
                margin-bottom: 20px;
            }

            .image-preview {
                width: 100%;
                height: auto;
                border-radius: 15px;
                border: 1px solid rgba(0, 0, 0, 0.1);
                margin-bottom: 20px;
            }

            .document-link-card {
                padding: 15px 20px;
                background: var(--cream);
                border-radius: 12px;
                border: 1px solid rgba(0, 0, 0, 0.05);
                display: flex;
                align-items: center;
                gap: 15px;
                transition: all 0.3s ease;
            }

            .document-link-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            }

            .document-link-card .icon-wrapper {
                width: 40px;
                height: 40px;
                border-radius: 8px;
                background: var(--accent-orange);
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.2rem;
                flex-shrink: 0;
            }

            .document-link-card p {
                margin: 0;
                font-weight: 600;
                color: var(--primary-green);
                flex-grow: 1;
            }

            .document-link-card .btn {
                white-space: nowrap;
            }

            .document-link {
                display: inline-block;
                margin-top: 15px;
            }

            @media (max-width: 991px) {
                .order-lg-2 {
                    order: -1;
                }
            }
        </style>
    @endpush

@section('content')
    <section class="apbdes-hero">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">Transparansi APBDes</h1>
            <p class="lead">Informasi Anggaran Pendapatan dan Belanja Desa (APBDes)
                {{ config('app.village_name', 'Desa Kilwaru') }}</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                {{-- Sidebar (Dropdown Tahun) --}}
                <div class="col-lg-4 order-lg-2">
                    <div class="sidebar-widget">
                        <h5>Pilih Tahun Anggaran</h5>
                        <form action="{{ route('apbdes.show', 'tahun') }}" method="GET" id="yearForm">
                            <select class="form-select" name="tahun" onchange="submitYearForm(this.value)">
                                @if ($availableYears)
                                    @foreach ($availableYears as $tahun)
                                        <option value="{{ $tahun }}"
                                            {{ $apbdes->tahun == $tahun ? 'selected' : '' }}>
                                            Tahun {{ $tahun }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="" selected disabled>Tidak ada tahun tersedia</option>
                                @endif
                            </select>
                        </form>
                    </div>
                </div>

                {{-- Main Content --}}
                <div class="col-lg-8 order-lg-1">
                    <div class="apbdes-card">
                        <div class="apbdes-card-header">
                            <h2 class="apbdes-card-title">{{ $apbdes->tahun }}</h2>
                            <h3 class="fw-bold text-success">{{ $apbdes->total_anggaran_formatted }}</h3>
                        </div>

                        {{-- Rincian Anggaran --}}
                        <div class="mb-4">
                            <h4 class="fw-bold mb-3">Rincian Anggaran</h4>
                            <div class="row g-3">
                                <div class="col-md-6 col-lg-4">
                                    <div class="meta-item">
                                        <div class="meta-content">
                                            <div class="meta-label">Pemerintahan Desa</div>
                                            <div class="meta-value">{{ $apbdes->pemerintahan_desa_formatted }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="meta-item">
                                        <div class="meta-content">
                                            <div class="meta-label">Pembangunan Desa</div>
                                            <div class="meta-value">{{ $apbdes->pembangunan_desa_formatted }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="meta-item">
                                        <div class="meta-content">
                                            <div class="meta-label">Pembinaan Kemasyarakatan</div>
                                            <div class="meta-value">{{ $apbdes->kemasyarakatan_formatted }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="meta-item">
                                        <div class="meta-content">
                                            <div class="meta-label">Pemberdayaan Masyarakat</div>
                                            <div class="meta-value">{{ $apbdes->pemberdayaan_formatted }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="meta-item">
                                        <div class="meta-content">
                                            <div class="meta-label">Bencana, Darurat & Mendesak</div>
                                            <div class="meta-value">{{ $apbdes->bencana_darurat_formatted }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Baliho Section --}}
                        @if ($apbdes->baliho_image)
                            <div class="mb-4">
                                <h4 class="fw-bold mb-3">Transparansi Visual</h4>
                                <img src="{{ Storage::url($apbdes->baliho_image) }}"
                                    alt="Baliho APBDes Tahun {{ $apbdes->tahun }}" class="image-preview">
                            </div>
                        @endif

                        {{-- Dokumen Section --}}
                        @if ($apbdes->pdf_dokumen)
                            <div class="mb-4">
                                <h4 class="fw-bold mb-3">Dokumen APBDes</h4>
                                <a href="{{ route('apbdes.download-pdf', $apbdes->tahun) }}" class="text-decoration-none">
                                    <div class="document-link-card">
                                        <div class="icon-wrapper" style="background: #17a2b8;">
                                            <i class="bi bi-file-earmark-pdf-fill"></i>
                                        </div>
                                        <p class="mb-0">Unduh Dokumen APBDes Tahun {{ $apbdes->tahun }}</p>
                                        <span class="btn btn-info btn-sm">
                                            <i class="bi bi-download me-1"></i> Unduh
                                        </span>
                                    </div>
                                </a>
                            </div>
                        @endif

                        @if ($kepalaDesa)
                            <div class="text-end border-top pt-4">
                                <p class="mb-1 text-muted">Disahkan oleh:</p>
                                <h5 class="fw-bold text-success mb-0">{{ $kepalaDesa->nama }}</h5>
                                <p class="text-muted">{{ $kepalaDesa->jabatan_formatted }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function submitYearForm(tahun) {
            if (tahun) {
                const url = `{{ route('apbdes.show', 'TAHUN_PLACEHOLDER') }}`.replace('TAHUN_PLACEHOLDER', tahun);
                window.location.href = url;
            }
        }
    </script>
@endpush
