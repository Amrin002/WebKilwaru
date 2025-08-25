@extends('layouts.main')

@section('content')
    <!-- Dashboard Content -->
    <div class="dashboard-content">
        <!-- Statistics Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Total Penduduk</div>
                    <div class="stat-icon population">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
                <div class="stat-number">{{ number_format($totalPenduduk, 0, ',', '.') }}</div>
                <div class="stat-change {{ $persenPendudukChange >= 0 ? 'positive' : 'negative' }}">
                    <i class="bi bi-arrow-{{ $persenPendudukChange >= 0 ? 'up' : 'down' }}"></i>
                    {{ number_format(abs($persenPendudukChange), 1) }}% dari bulan lalu
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Kepala Keluarga</div>
                    <div class="stat-icon families">
                        <i class="bi bi-house-door"></i>
                    </div>
                </div>
                <div class="stat-number">{{ number_format($kepalaKeluarga, 0, ',', '.') }}</div>
                <div class="stat-change {{ $persenKkChange >= 0 ? 'positive' : 'negative' }}">
                    <i class="bi bi-arrow-{{ $persenKkChange >= 0 ? 'up' : 'down' }}"></i>
                    {{ number_format(abs($persenKkChange), 1) }}% dari bulan lalu
                </div>
            </div>



            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">UMKM</div>
                    <div class="stat-icon news">
                        <i class="bi bi-shop"></i>
                    </div>
                </div>
                <div class="stat-number">{{ number_format($totalUmkm, 0, ',', '.') }}</div>
                <div class="stat-change {{ $persenUmkmChange >= 0 ? 'positive' : 'negative' }}">
                    <i class="bi bi-arrow-{{ $persenUmkmChange >= 0 ? 'up' : 'down' }}"></i>
                    {{ number_format(abs($persenUmkmChange), 1) }}% dari bulan lalu
                </div>
            </div>


            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Berita Bulan Ini</div>
                    <div class="stat-icon news">
                        <i class="bi bi-newspaper"></i>
                    </div>
                </div>
                <div class="stat-number">{{ number_format($totalBeritaBulanIni, 0, ',', '.') }}</div>
                <div class="stat-change {{ $persenBeritaChange >= 0 ? 'positive' : 'negative' }}">
                    <i class="bi bi-arrow-{{ $persenBeritaChange >= 0 ? 'up' : 'down' }}"></i>
                    {{ number_format(abs($persenBeritaChange), 1) }}% dari bulan lalu
                </div>
            </div>
        </div>

        <!-- Activity Section -->
        <div class="activity-section">
            <div class="activity-card">
                <h3 class="chart-title mb-3">Aktivitas Terbaru</h3>
                @if ($latestActivities->isEmpty())
                    <p>Tidak ada aktivitas terbaru.</p>
                @else
                    @foreach ($latestActivities as $activity)
                        <div class="activity-item">
                            <div class="activity-icon info">
                                <i class="{{ $activity->icon_class }}"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">{{ $activity->jenis_aktivitas }}</div>
                                <div class="activity-time">{{ $activity->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="activity-card">
                <h3 class="chart-title mb-3">Layanan Populer</h3>
                @foreach ($popularServices as $service)
                    <div class="activity-item">
                        <div class="activity-icon {{ $service['status_class'] }}">
                            <i class="bi {{ $service['icon_class'] }}"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">{{ $service['title'] }}</div>
                            <div class="activity-time">{{ $service['count'] }} permohonan bulan ini</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="quick-actions">
            <a href="{{ route('admin.penduduk.create') }}" class="action-btn">
                <i class="bi bi-plus-circle"></i>
                <span>Tambah Penduduk</span>
            </a>
            <a href="{{ route('admin.berita.index') }}" class="action-btn">
                <i class="bi bi-newspaper"></i>
                <span>Buat Berita</span>
            </a>
            <a href="{{ route('admin.arsip-surat.index') }}" class="action-btn">
                <i class="bi bi-file-earmark-plus"></i>
                <span>Proses Surat</span>
            </a>
            <a href="{{ route('admin.umkm.index') }}" class="action-btn">
                <i class="bi bi-shop"></i>
                <span>Kelola UMKM</span>
            </a>
        </div>
    </div>
@endsection
