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
                <div class="stat-number">2,847</div>
                <div class="stat-change positive">
                    <i class="bi bi-arrow-up"></i>
                    +2.5% dari bulan lalu
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Kepala Keluarga</div>
                    <div class="stat-icon families">
                        <i class="bi bi-house-door"></i>
                    </div>
                </div>
                <div class="stat-number">847</div>
                <div class="stat-change positive">
                    <i class="bi bi-arrow-up"></i>
                    +1.8% dari bulan lalu
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Layanan Aktif</div>
                    <div class="stat-icon services">
                        <i class="bi bi-gear"></i>
                    </div>
                </div>
                <div class="stat-number">12</div>
                <div class="stat-change">
                    <i class="bi bi-dash"></i>
                    Tidak ada perubahan
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Berita Bulan Ini</div>
                    <div class="stat-icon news">
                        <i class="bi bi-newspaper"></i>
                    </div>
                </div>
                <div class="stat-number">23</div>
                <div class="stat-change positive">
                    <i class="bi bi-arrow-up"></i>
                    +15.4% dari bulan lalu
                </div>
            </div>
        </div>

        <!-- Activity Section -->
        <div class="activity-section">
            <div class="activity-card">
                <h3 class="chart-title mb-3">Aktivitas Terbaru</h3>
                <div class="activity-item">
                    <div class="activity-icon success">
                        <i class="bi bi-check-lg"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Surat Keterangan Usaha - Approved</div>
                        <div class="activity-time">2 jam yang lalu</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon warning">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Permohonan KTP Baru - Pending</div>
                        <div class="activity-time">4 jam yang lalu</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon info">
                        <i class="bi bi-info-lg"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Berita Baru Dipublikasi</div>
                        <div class="activity-time">6 jam yang lalu</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon success">
                        <i class="bi bi-check-lg"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Surat Domisili - Completed</div>
                        <div class="activity-time">8 jam yang lalu</div>
                    </div>
                </div>
            </div>

            <div class="activity-card">
                <h3 class="chart-title mb-3">Layanan Populer</h3>
                <div class="activity-item">
                    <div class="activity-icon success">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Surat Keterangan Usaha</div>
                        <div class="activity-time">45 permohonan bulan ini</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon info">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Pembuatan KTP</div>
                        <div class="activity-time">32 permohonan bulan ini</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon warning">
                        <i class="bi bi-house"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Surat Domisili</div>
                        <div class="activity-time">28 permohonan bulan ini</div>
                    </div>
                </div>
                <div class="activity-item">
                    <div class="activity-icon info">
                        <i class="bi bi-heart-pulse"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title">Layanan Kesehatan</div>
                        <div class="activity-time">21 kunjungan bulan ini</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="#" class="action-btn">
                <i class="bi bi-plus-circle"></i>
                <span>Tambah Penduduk</span>
            </a>
            <a href="#" class="action-btn">
                <i class="bi bi-newspaper"></i>
                <span>Buat Berita</span>
            </a>
            <a href="#" class="action-btn">
                <i class="bi bi-file-earmark-plus"></i>
                <span>Proses Surat</span>
            </a>
            <a href="#" class="action-btn">
                <i class="bi bi-bar-chart"></i>
                <span>Lihat Laporan</span>
            </a>
        </div>
    </div>
@endsection
