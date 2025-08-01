{{-- 
    File ini akan redirect ke halaman login dengan tab register aktif
    Karena kita menggunakan single page untuk login dan register
--}}

@extends('auth.layout')

@section('title', 'Daftar - Website Resmi Desa Kilwaru')

@section('content')
    <div class="fade-in">
        <!-- Toggle Login/Register -->
        <div class="auth-toggle">
            <button type="button" class="auth-toggle-btn" id="loginTab">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
            </button>
            <button type="button" class="auth-toggle-btn active" id="registerTab">
                <i class="bi bi-person-plus me-2"></i>Daftar
            </button>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('status') }}
            </div>
        @endif

        <!-- Login Form (Hidden by default) -->
        <div id="loginForm" style="display: none;">
            <div class="text-center mb-4">
                <h1 class="h3 fw-bold mb-2" style="color: var(--primary-green);">Selamat Datang Kembali</h1>
                <p class="text-muted">Masuk untuk mengakses layanan desa</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class="bi bi-envelope me-1"></i>Email
                    </label>
                    <input id="email" class="form-control" type="email" name="email" required autofocus
                        autocomplete="username" placeholder="Masukkan email Anda">
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="bi bi-lock me-1"></i>Password
                    </label>
                    <div class="position-relative">
                        <input id="password" class="form-control" type="password" name="password" required
                            autocomplete="current-password" placeholder="Masukkan password Anda">
                        <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y pe-3"
                            onclick="togglePassword('password')">
                            <i class="bi bi-eye" id="passwordIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                        <label class="form-check-label" for="remember_me">
                            Ingat saya
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                    </button>
                </div>

                <!-- Forgot Password -->
                <div class="text-center">
                    @if (Route::has('password.request'))
                        <a class="text-link" href="{{ route('password.request') }}">
                            <i class="bi bi-question-circle me-1"></i>Lupa password?
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Register Form (Shown by default) -->
        <div id="registerForm">
            <div class="text-center mb-4">
                <h1 class="h3 fw-bold mb-2" style="color: var(--primary-green);">Daftar Akun Baru</h1>
                <p class="text-muted">Bergabung dengan platform digital desa</p>
            </div>

            <form method="POST" action="{{ route('register') }}" id="registerFormElement">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label for="register_name" class="form-label">
                        <i class="bi bi-person me-1"></i>Nama Lengkap
                    </label>
                    <input id="register_name" class="form-control @error('name') is-invalid @enderror" type="text"
                        name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                        placeholder="Masukkan nama lengkap Anda">
                    @error('name')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="register_email" class="form-label">
                        <i class="bi bi-envelope me-1"></i>Email
                    </label>
                    <input id="register_email" class="form-control @error('email') is-invalid @enderror" type="email"
                        name="email" value="{{ old('email') }}" required autocomplete="username"
                        placeholder="Masukkan email Anda">
                    @error('email')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="register_password" class="form-label">
                        <i class="bi bi-lock me-1"></i>Password
                    </label>
                    <div class="position-relative">
                        <input id="register_password" class="form-control @error('password') is-invalid @enderror"
                            type="password" name="password" required autocomplete="new-password"
                            placeholder="Masukkan password Anda">
                        <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y pe-3"
                            onclick="togglePassword('register_password')">
                            <i class="bi bi-eye" id="registerPasswordIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">
                        <i class="bi bi-lock-fill me-1"></i>Konfirmasi Password
                    </label>
                    <div class="position-relative">
                        <input id="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror" type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Konfirmasi password Anda">
                        <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y pe-3"
                            onclick="togglePassword('password_confirmation')">
                            <i class="bi bi-eye" id="confirmPasswordIcon"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Terms & Conditions -->
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">
                            Saya setuju dengan <a href="{{ route('terms') }}" target="_blank" class="text-link">syarat
                                dan ketentuan</a>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                    </button>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <span class="text-muted">Sudah punya akun? </span>
                    <button type="button" class="btn btn-link text-link p-0" onclick="switchToLogin()">
                        Masuk di sini
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // Toggle between login and register forms
            document.getElementById('loginTab').addEventListener('click', function() {
                switchToLogin();
            });

            document.getElementById('registerTab').addEventListener('click', function() {
                switchToRegister();
            });

            function switchToLogin() {
                document.getElementById('loginTab').classList.add('active');
                document.getElementById('registerTab').classList.remove('active');
                document.getElementById('loginForm').style.display = 'block';
                document.getElementById('registerForm').style.display = 'none';

                // Focus first input
                setTimeout(() => {
                    document.getElementById('email').focus();
                }, 100);
            }

            function switchToRegister() {
                document.getElementById('registerTab').classList.add('active');
                document.getElementById('loginTab').classList.remove('active');
                document.getElementById('registerForm').style.display = 'block';
                document.getElementById('loginForm').style.display = 'none';

                // Focus first input
                setTimeout(() => {
                    document.getElementById('register_name').focus();
                }, 100);
            }

            // Toggle password visibility
            function togglePassword(inputId) {
                const input = document.getElementById(inputId);
                const icon = document.getElementById(inputId + 'Icon') || document.getElementById('passwordIcon');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            }

            // Auto-hide alerts after 5 seconds
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
                    }, 5000);
                });

                // Focus on first input field
                document.getElementById('register_name').focus();
            });

            // Form validation feedback
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.innerHTML =
                            '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Memproses...';
                        submitBtn.disabled = true;
                    }
                });
            });

            // Enhanced form interactions
            document.querySelectorAll('.form-control').forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentNode.classList.add('focused');
                });

                input.addEventListener('blur', function() {
                    this.parentNode.classList.remove('focused');
                });
            });
        </script>
    @endpush
@endsection
