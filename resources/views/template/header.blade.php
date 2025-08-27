<!-- Navigation -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('asset/img/logo_sbt.png') }}" alt="Logo SBT" class="me-2"
                style="width: 32px; height: 32px; object-fit: contain;">
            Website Resmi Desa Kilwaru
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    @if (request()->routeIs('home'))
                        <a class="nav-link" href="#home">Beranda</a>
                    @else
                        <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                    @endif
                </li>
                <li class="nav-item">
                    @if (request()->routeIs('home'))
                        <a class="nav-link" href="#about">Tentang</a>
                    @else
                        <a class="nav-link" href="{{ route('home') }}#about">Tentang</a>
                    @endif
                </li>
                <li class="nav-item">
                    @if (request()->routeIs('home'))
                        <a class="nav-link" href="#services">Layanan</a>
                    @else
                        <a class="nav-link" href="{{ route('home') }}#services">Layanan</a>
                    @endif
                </li>
                <li class="nav-item">
                    @if (request()->routeIs('home'))
                        <a class="nav-link" href="#news">Berita</a>
                    @else
                        <a class="nav-link" href="{{ route('berita.index') }}">Berita</a>
                    @endif
                </li>
                <li class="nav-item">
                    @if (request()->routeIs('home'))
                        <a class="nav-link" href="#contact">Kontak</a>
                    @else
                        <a class="nav-link" href="{{ route('home') }}#contact">Kontak</a>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</nav>
