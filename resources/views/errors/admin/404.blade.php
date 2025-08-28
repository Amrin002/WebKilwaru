@extends('layouts.main')
@section('titleHeader', '404 Halaman Tidak Ditemukan - Admin')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-lg-6 col-md-8">
                <div class="text-center">
                    <!-- Error Number -->
                    <div class="error-number mb-4">
                        <h1 class="display-1 fw-bold text-danger">404</h1>
                    </div>

                    <!-- Error Message -->
                    <div class="error-message mb-5">
                        <h2 class="h3 mb-3" style="color: var(--primary-green);">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Halaman Tidak Ditemukan
                        </h2>
                        <p class="text-muted mb-4">
                            Maaf, halaman admin yang Anda cari tidak dapat ditemukan.
                            Mungkin halaman telah dipindahkan atau URL tidak valid.
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="error-actions">
                        <a href="{{ route('admin.index') }}" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Kembali ke Dashboard
                        </a>
                        <button onclick="history.back()" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>
                            Halaman Sebelumnya
                        </button>
                    </div>

                    <!-- Quick Links -->
                    <div class="quick-links mt-5">
                        <h5 class="mb-3" style="color: var(--primary-green);">Menu Cepat:</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <a href="{{ route('admin.berita.index') }}" class="text-decoration-none">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-newspaper fa-2x mb-2 text-primary"></i>
                                            <h6>Kelola Berita</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('admin.galeri.index') }}" class="text-decoration-none">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-images fa-2x mb-2 text-success"></i>
                                            <h6>Kelola Galeri</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('admin.penduduk.index') }}" class="text-decoration-none">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-users fa-2x mb-2 text-info"></i>
                                            <h6>Data Penduduk</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('style')
        <style>
            .min-vh-100 {
                min-height: 100vh !important;
            }

            .error-number h1 {
                font-size: 8rem;
                line-height: 1;
                text-shadow: 0 10px 30px rgba(220, 53, 69, 0.3);
            }

            .quick-links .card {
                transition: all 0.3s ease;
                cursor: pointer;
            }

            .quick-links .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
            }

            @media (max-width: 768px) {
                .error-number h1 {
                    font-size: 5rem;
                }

                .btn-lg {
                    margin-bottom: 10px;
                    display: block;
                    width: 100%;
                }
            }
        </style>
    @endpush
@endsection
