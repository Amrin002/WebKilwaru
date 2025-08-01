@extends('auth.layout')

@section('title', 'Lupa Password - Website Resmi Desa Kilwaru')

@section('content')
    <div class="fade-in">
        <div class="text-center mb-4">
            <h1 class="h3 fw-bold mb-2" style="color: var(--primary-green);">Lupa Password?</h1>
            <p class="text-muted">Masukkan email Anda dan kami akan mengirimkan link untuk mereset password</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">
                    <i class="bi bi-envelope me-1"></i>Email
                </label>
                <input id="email" class="form-control @error('email') is-invalid @enderror" type="email"
                    name="email" value="{{ old('email') }}" required autofocus
                    placeholder="Masukkan email yang terdaftar">
                @error('email')
                    <div class="invalid-feedback">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="mb-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-envelope-arrow-up me-2"></i>Kirim Link Reset Password
                </button>
            </div>

            <!-- Back to Login -->
            <div class="text-center">
                <a class="text-link" href="{{ route('login') }}">
                    <i class="bi bi-arrow-left me-1"></i>Kembali ke halaman login
                </a>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            // Form submission feedback
            document.querySelector('form').addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML =
                        '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Mengirim...';
                    submitBtn.disabled = true;
                }
            });

            // Auto-hide alerts
            document.addEventListener('DOMContentLoaded', function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.style.transition = 'opacity 0.5s ease';
                            alert.style.opacity = '0';
                            setTimeout(() => {
                                alert.remove();
                            }, 500);
                        }
                    }, 10000); // Hide after 10 seconds for forgot password
                });
            });
        </script>
    @endpush
@endsection
