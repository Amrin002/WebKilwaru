@extends('template.main')

@section('title', 'Arsip Berita - ' . config('app.village_name', 'Desa Kilwaru'))
@section('description', 'Arsip berita dan informasi dari ' . config('app.village_name', 'Desa Kilwaru'))

@push('styles')
    <style>
        .archive-hero {
            background: linear-gradient(rgba(45, 80, 22, 0.8), rgba(74, 124, 89, 0.8)),
                url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3') center/cover;
            color: white;
            padding: 120px 0 60px;
            margin-top: -80px;
        }

        .calendar-nav {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .year-selector {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .year-btn {
            padding: 8px 20px;
            border: 2px solid #e0e0e0;
            background: white;
            color: #333;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .year-btn:hover {
            border-color: var(--primary-green);
            color: var(--primary-green);
        }

        .year-btn.active {
            background: var(--primary-green);
            border-color: var(--primary-green);
            color: white;
        }

        .month-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 10px;
        }

        .month-btn {
            padding: 10px;
            text-align: center;
            border: 1px solid #e0e0e0;
            background: white;
            color: #333;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .month-btn:hover {
            background: var(--accent-orange);
            border-color: var(--accent-orange);
            color: white;
            transform: translateY(-2px);
        }

        .month-btn.active {
            background: var(--accent-orange);
            border-color: var(--accent-orange);
            color: white;
        }

        .month-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .archive-summary {
            background: #f8f9fa;
            border-left: 4px solid var(--accent-orange);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
    </style>
@endpush

@section('content')
    <!-- Archive Hero -->
    <section class="archive-hero">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">Arsip Berita</h1>
            <p class="lead">Jelajahi koleksi berita dan informasi berdasarkan waktu publikasi</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Calendar Navigation -->
                <div class="col-lg-4 mb-4">
                    <div class="calendar-nav sticky-top" style="top: 100px;">
                        <h5 class="mb-4">Pilih Periode</h5>

                        <!-- Year Selector -->
                        <div class="year-selector">
                            @foreach ($availableYears as $availableYear)
                                <a href="{{ route('berita.archive', ['year' => $availableYear]) }}"
                                    class="year-btn {{ $year == $availableYear ? 'active' : '' }}">
                                    {{ $availableYear }}
                                </a>
                            @endforeach
                        </div>

                        @if ($year)
                            <hr>
                            <h6 class="mb-3">Bulan di Tahun {{ $year }}</h6>
                            <div class="month-grid">
                                @php
                                    $months = [
                                        1 => 'Jan',
                                        2 => 'Feb',
                                        3 => 'Mar',
                                        4 => 'Apr',
                                        5 => 'Mei',
                                        6 => 'Jun',
                                        7 => 'Jul',
                                        8 => 'Agu',
                                        9 => 'Sep',
                                        10 => 'Okt',
                                        11 => 'Nov',
                                        12 => 'Des',
                                    ];
                                    $availableMonthNumbers = $availableMonths->pluck('month')->toArray();
                                @endphp

                                @foreach ($months as $monthNum => $monthName)
                                    @if (in_array($monthNum, $availableMonthNumbers))
                                        <a href="{{ route('berita.archive', ['year' => $year, 'month' => $monthNum]) }}"
                                            class="month-btn {{ $month == $monthNum ? 'active' : '' }}">
                                            {{ $monthName }}
                                        </a>
                                    @else
                                        <span class="month-btn disabled">{{ $monthName }}</span>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        <hr>
                        <a href="{{ route('berita.index') }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-arrow-left"></i> Kembali ke Berita
                        </a>
                    </div>
                </div>

                <!-- Archive Content -->
                <div class="col-lg-8">
                    <!-- Archive Summary -->
                    <div class="archive-summary">
                        <h4>
                            @if ($month)
                                {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}
                            @else
                                Tahun {{ $year }}
                            @endif
                        </h4>
                        <p class="mb-0">
                            Menampilkan <strong>{{ $beritas->total() }}</strong> berita
                            @if ($month)
                                pada bulan {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}
                            @else
                                pada tahun {{ $year }}
                            @endif
                        </p>
                    </div>

                    <!-- Articles List -->
                    <div class="row">
                        @forelse($beritas as $berita)
                            <div class="col-12 mb-4">
                                <div class="card berita-card">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}"
                                                class="img-fluid h-100"
                                                style="object-fit: cover; border-radius: 15px 0 0 15px;">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <div>
                                                        @if ($berita->kategoriBeri)
                                                            <span class="category-badge"
                                                                style="background-color: {{ $berita->kategoriBeri->warna }}; color: white; font-size: 0.75rem; padding: 4px 12px; border-radius: 20px;">
                                                                {{ $berita->kategoriBeri->nama }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <small class="text-muted">
                                                        {{ $berita->published_at->format('d F Y') }}
                                                    </small>
                                                </div>
                                                <h5 class="card-title">
                                                    <a href="{{ route('berita.show', $berita->slug) }}"
                                                        class="text-decoration-none text-dark">
                                                        {{ $berita->judul }}
                                                    </a>
                                                </h5>
                                                <p class="card-text">{{ $berita->excerpt_formatted }}</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="berita-meta">
                                                        <i class="bi bi-eye"></i> {{ $berita->views }} views |
                                                        <i class="bi bi-clock"></i> {{ $berita->published_at_relative }}
                                                    </div>
                                                    <a href="{{ route('berita.show', $berita->slug) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        Baca <i class="bi bi-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="empty-state text-center py-5">
                                    <i class="bi bi-archive" style="font-size: 5rem; color: var(--soft-gray);"></i>
                                    <h4 class="mt-3">Tidak Ada Berita</h4>
                                    <p class="text-muted">
                                        Tidak ada berita yang dipublikasikan pada periode ini
                                    </p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if ($beritas->hasPages())
                        <div class="d-flex justify-content-center mt-5">
                            {{ $beritas->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Smooth scroll for archive navigation
        document.querySelectorAll('.calendar-nav a').forEach(link => {
            link.addEventListener('click', function(e) {
                if (this.getAttribute('href').startsWith('#')) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });
    </script>
@endpush
