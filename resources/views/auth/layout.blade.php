<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Masuk - Website Resmi Desa Kilwaru')</title>
    <meta name="description" content="Halaman login Website Resmi Desa Kilwaru">

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
        rel="stylesheet">

    <style>
        :root {
            --primary-green: #2d5016;
            --secondary-green: #4a7c59;
            --light-green: #8fbc8f;
            --cream: #f8f6f0;
            --warm-white: #fefefe;
            --soft-gray: #6c757d;
            --accent-orange: #ff8c42;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .auth-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            margin: 20px;
        }

        .auth-form-section {
            padding: 60px 50px;
            background: white;
        }

        .auth-info-section {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            padding: 60px 50px 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .auth-info-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><path d="M0,300 C300,200 700,400 1000,300 L1000,1000 L0,1000 Z" fill="%23ffffff08"/></svg>');
            opacity: 0.3;
        }

        .auth-info-content {
            position: relative;
            z-index: 2;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 15px 18px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            border-color: var(--accent-orange);
            box-shadow: 0 0 0 0.2rem rgba(255, 140, 66, 0.25);
            background: white;
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-green);
            margin-bottom: 8px;
            font-size: 14px;
        }

        .btn-primary {
            background: var(--accent-orange);
            border: none;
            border-radius: 12px;
            padding: 15px 30px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-primary:hover {
            background: #e07a35;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 140, 66, 0.3);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-green);
            color: var(--primary-green);
            border-radius: 12px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--primary-green);
            border-color: var(--primary-green);
            color: white;
            transform: translateY(-1px);
        }

        .auth-toggle {
            display: flex;
            background: #f8f9fa;
            border-radius: 12px;
            padding: 4px;
            margin-bottom: 30px;
        }

        .auth-toggle-btn {
            flex: 1;
            padding: 12px;
            border: none;
            background: transparent;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: var(--soft-gray);
        }

        .auth-toggle-btn.active {
            background: white;
            color: var(--primary-green);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .form-check-input:checked {
            background-color: var(--accent-orange);
            border-color: var(--accent-orange);
        }

        .form-check-input:focus {
            border-color: var(--accent-orange);
            box-shadow: 0 0 0 0.25rem rgba(255, 140, 66, 0.25);
        }

        .text-link {
            color: var(--primary-green);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .text-link:hover {
            color: var(--accent-orange);
            text-decoration: underline;
        }

        .brand-logo {
            font-size: 2.5rem;
            color: var(--accent-orange);
            margin-bottom: 20px;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 25px;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
        }

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .floating-shapes::before,
        .floating-shapes::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .floating-shapes::before {
            width: 150px;
            height: 150px;
            top: 20%;
            left: -75px;
            animation-delay: -3s;
        }

        .floating-shapes::after {
            width: 100px;
            height: 100px;
            bottom: 20%;
            right: -50px;
            animation-delay: -1s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .back-to-home {
            position: absolute;
            top: 30px;
            left: 30px;
            z-index: 10;
        }

        .back-to-home .btn {
            background: rgba(0, 0, 0, 0.6);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 50px;
            padding: 10px 20px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .back-to-home .btn:hover {
            background: rgba(0, 0, 0, 0.8);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 768px) {
            .auth-container {
                margin: 10px;
                border-radius: 15px;
            }

            .auth-form-section,
            .auth-info-section {
                padding: 40px 30px;
            }

            .auth-info-section {
                order: -1;
                text-align: center;
            }

            .brand-logo {
                font-size: 2rem;
            }

            .back-to-home {
                top: 20px;
                left: 20px;
            }

            .floating-shapes::before,
            .floating-shapes::after {
                display: none;
            }
        }

        @media (max-width: 576px) {

            .auth-form-section,
            .auth-info-section {
                padding: 30px 20px;
            }

            .form-control {
                padding: 12px 15px;
                font-size: 14px;
            }

            .btn-primary {
                padding: 12px 25px;
                font-size: 14px;
            }
        }

        /* Pastikan container bisa scroll di mobile */
        @media (max-width: 768px) {
            .container-fluid {
                padding: 0;
                height: auto;
                min-height: 100vh;
            }

            .row.justify-content-center {
                margin: 0;
                min-height: 100vh;
            }

            .col-12 {
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Back to Home Button -->
    <div class="back-to-home">
        <a href="{{ url('/') }}" class="btn">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Beranda
        </a>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="auth-container mx-auto">
                    <div class="row g-0">
                        <!-- Form Section -->
                        <div class="col-lg-6">
                            <div class="auth-form-section">
                                @yield('content')
                            </div>
                        </div>

                        <!-- Info Section -->
                        <div class="col-lg-6">
                            <div class="auth-info-section">
                                <div class="floating-shapes"></div>
                                <div class="auth-info-content">
                                    <div class="brand-logo">
                                        <i class="bi bi-house-heart-fill"></i>
                                    </div>
                                    <h2 class="h1 fw-bold mb-4">Website Resmi Desa Kilwaru</h2>
                                    <p class="lead mb-4">
                                        Bergabunglah dengan platform digital kami untuk mengakses layanan desa yang
                                        lebih mudah, cepat, dan transparan.
                                    </p>
                                    <div class="row text-center mt-5">
                                        <div class="col-4">
                                            <div class="h3 fw-bold">2.8K+</div>
                                            <small>Penduduk</small>
                                        </div>
                                        <div class="col-4">
                                            <div class="h3 fw-bold">847</div>
                                            <small>Kepala Keluarga</small>
                                        </div>
                                        <div class="col-4">
                                            <div class="h3 fw-bold">12</div>
                                            <small>Layanan</small>
                                        </div>
                                    </div>
                                    <div class="mt-5">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="bi bi-shield-check text-warning me-3"
                                                style="font-size: 1.5rem;"></i>
                                            <span>Keamanan data terjamin</span>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="bi bi-clock text-warning me-3" style="font-size: 1.5rem;"></i>
                                            <span>Layanan 24/7</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-people text-warning me-3" style="font-size: 1.5rem;"></i>
                                            <span>Transparansi penuh</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
