@extends('template.main')

@section('title', 'Lacak Status UMKM - ' . config('app.village_name', 'Desa Kilwaru'))
@section('description', 'Halaman untuk melacak status pendaftaran UMKM berdasarkan NIK di ' . config('app.village_name',
    'Desa Kilwaru'))

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

            .track-card {
                background: white;
                border-radius: 20px;
                padding: 40px 30px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                max-width: 600px;
                margin: 0 auto;
                position: relative;
                z-index: 10;
                margin-top: -50px;
            }

            .track-input {
                border: 2px solid #e0e0e0;
                border-radius: 15px;
                padding: 15px 20px;
                font-size: 16px;
                transition: all 0.3s ease;
            }

            .track-input:focus {
                border-color: var(--accent-orange);
                box-shadow: 0 0 0 0.2rem rgba(255, 140, 66, 0.25);
            }

            .btn-track-submit {
                background: var(--primary-green);
                border: none;
                border-radius: 15px;
                padding: 15px 35px;
                font-weight: 600;
                font-size: 1.1rem;
                transition: all 0.3s ease;
            }

            .btn-track-submit:hover {
                background: var(--secondary-green);
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(45, 80, 22, 0.4);
            }

            .alert-custom {
                border-radius: 15px;
            }
        </style>
    @endpush

@section('content')
    <section class="umkm-hero">
        <div class="container">
            <div class="text-center">
                <h1 class="display-4 fw-bold mb-4">Lacak Status UMKM</h1>
                <p class="lead">Cek status pendaftaran UMKM Anda dengan mudah dan cepat.</p>
            </div>
        </div>
    </section>

    <div class="container my-5">
        @if ($errors->any())
            <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                @foreach ($errors->all() as $error)
                    {{ $error }}
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="track-card">
            <h4 class="mb-3 text-center fw-bold text-primary-green">Formulir Pelacakan Status</h4>
            <p class="text-muted text-center mb-4">Masukkan Nomor Induk Kependudukan (NIK) Anda untuk mencari status
                pendaftaran UMKM.</p>

            <form action="{{ route('umkm.track') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nik" class="form-label visually-hidden">Nomor Induk Kependudukan (NIK)</label>
                    <input type="text" class="form-control track-input @error('nik') is-invalid @enderror" id="nik"
                        name="nik" placeholder="Masukkan 16 digit NIK Anda" required>
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-track-submit text-white">
                        <i class="bi bi-search me-2"></i>Cek Status
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
