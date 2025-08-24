<nav class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <i class="bi bi-house-heart-fill me-2"></i>
            <span class="nav-text">Desa Kilwaru</span>
        </div>
    </div>

    <ul class="sidebar-nav">
        <!-- Dashboard -->
        <li class="nav-item">
            <a href="{{ route('admin.index') }}" class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}"
                data-page="dashboard">
                <i class="bi bi-speedometer2"></i>
                <span class="nav-text">Dashboard</span>
            </a>
        </li>

        <!-- Data Penduduk dengan Sub Menu -->
        <li class="nav-item">
            <div class="nav-link has-submenu {{ request()->is('admin/penduduk*') ||
            request()->routeIs('admin.kk.*') ||
            request()->routeIs('admin.penduduk.*') ||
            request()->routeIs('admin.statistik.pertumbuhan*')
                ? 'expanded'
                : '' }}"
                data-page="penduduk">
                <i class="bi bi-people"></i>
                <span class="nav-text">Data Penduduk</span>
                <i class="bi bi-chevron-down dropdown-arrow"></i>
            </div>
            <ul
                class="sub-menu {{ request()->is('admin/penduduk*') ||
                request()->routeIs('admin.kk.*') ||
                request()->routeIs('admin.penduduk.*') ||
                request()->routeIs('admin.statistik.pertumbuhan*')
                    ? 'expanded'
                    : '' }}">
                <li class="sub-menu-item">
                    <a href="{{ route('admin.kk.index') }}"
                        class="sub-menu-link {{ request()->routeIs('admin.kk.*') ? 'active' : '' }}"
                        data-subpage="kelola-kk">
                        <i class="bi bi-house-door"></i>
                        <span>Kelola Kartu Keluarga</span>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="{{ route('admin.penduduk.index') }}"
                        class="sub-menu-link {{ request()->routeIs('admin.penduduk.*') ? 'active' : '' }}"
                        data-subpage="kelola-penduduk">
                        <i class="bi bi-person-plus"></i>
                        <span>Kelola Penduduk</span>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="{{ route('admin.statistik.pertumbuhan') }}"
                        class="sub-menu-link {{ request()->routeIs('admin.statistik.pertumbuhan*') ? 'active' : '' }}"
                        data-subpage="statistik-penduduk">
                        <i class="bi bi-graph-up"></i>
                        <span>Statistik Pertumbuhan</span>
                    </a>
                </li>
            </ul>
        </li>
        <!-- Struktur Desa -->
        <li class="nav-item">
            <a href="{{ route('admin.struktur-desa.index') }}"
                class="nav-link {{ request()->routeIs('admin.struktur-desa.*') ? 'active' : '' }}"
                data-page="struktur-desa">
                <i class="bi bi-diagram-3"></i>
                <span class="nav-text">Struktur Desa</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.umkm.index') }}"
                class="nav-link {{ request()->routeIs('admin.umkm.*') ? 'active' : '' }}" data-page="umkm">
                <i class="bi bi-shop"></i>
                <span class="nav-text">Kelola UMKM</span>
            </a>
        </li>

        <!-- Administrasi dengan Sub Menu -->
        <li class="nav-item">
            <div class="nav-link has-submenu {{ request()->routeIs('admin.surat-ktm.*', 'admin.arsip-surat.*', 'admin.administrasi.*') ? 'active' : '' }}"
                data-page="administrasi">
                <i class="bi bi-file-earmark-text"></i>
                <span class="nav-text">Administrasi</span>
                <i class="bi bi-chevron-down dropdown-arrow"></i>
            </div>
            <ul
                class="sub-menu {{ request()->routeIs('admin.surat-ktm.*', 'admin.arsip-surat.*', 'admin.administrasi.*') ? 'expanded' : '' }}">
                <li class="sub-menu-item">
                    <a href="{{ route('admin.surat-ktm.index') }}"
                        class="sub-menu-link {{ request()->routeIs('admin.surat-ktm.*') ? 'active' : '' }}"
                        data-subpage="surat-ktm">
                        <i class="bi bi-file-earmark-check"></i>
                        <span>Surat Keterangan Tidak Mampu</span>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="#"
                        class="sub-menu-link {{ request()->routeIs('admin.administrasi.surat-domisili.*') ? 'active' : '' }}"
                        data-subpage="surat-domisili">
                        <i class="bi bi-geo-alt"></i>
                        <span>Surat Domisili</span>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="{{ route('admin.surat-ktu.index') }}"
                        class="sub-menu-link {{ request()->routeIs('admin.surat-ktu.*') ? 'active' : '' }}"
                        data-subpage="surat-usaha">
                        <i class="bi bi-briefcase"></i>
                        <span>Surat Usaha</span>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="{{ route('admin.arsip-surat.index') }}"
                        class="sub-menu-link {{ request()->routeIs('admin.arsip-surat.*') ? 'active' : '' }}"
                        data-subpage="arsip-surat">
                        <i class="bi bi-archive"></i>
                        <span>Arsip Surat</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Layanan Publik dengan Sub Menu -->
        <li class="nav-item">
            <div class="nav-link has-submenu {{ request()->routeIs('admin.layanan.*') ? 'expanded' : '' }}"
                data-page="layanan">
                <i class="bi bi-gear"></i>
                <span class="nav-text">Layanan Publik</span>
                <i class="bi bi-chevron-down dropdown-arrow"></i>
            </div>
            <ul class="sub-menu {{ request()->routeIs('admin.layanan.*') ? 'expanded' : '' }}">
                <li class="sub-menu-item">
                    <a href="#"
                        class="sub-menu-link {{ request()->routeIs('admin.layanan.kesehatan.*') ? 'active' : '' }}"
                        data-subpage="layanan-kesehatan">
                        <i class="bi bi-heart-pulse"></i>
                        <span>Layanan Kesehatan</span>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="#"
                        class="sub-menu-link {{ request()->routeIs('admin.layanan.pendidikan.*') ? 'active' : '' }}"
                        data-subpage="layanan-pendidikan">
                        <i class="bi bi-book"></i>
                        <span>Layanan Pendidikan</span>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="#"
                        class="sub-menu-link {{ request()->routeIs('admin.layanan.fasilitas.*') ? 'active' : '' }}"
                        data-subpage="fasilitas-umum">
                        <i class="bi bi-building"></i>
                        <span>Fasilitas Umum</span>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="#"
                        class="sub-menu-link {{ request()->routeIs('admin.layanan.jadwal.*') ? 'active' : '' }}"
                        data-subpage="jadwal-pelayanan">
                        <i class="bi bi-calendar-event"></i>
                        <span>Jadwal Pelayanan</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Berita & Info dengan Sub Menu -->
        <li class="nav-item">
            <div class="nav-link has-submenu {{ request()->routeIs('admin.berita.*') ? 'expanded' : '' }}"
                data-page="berita">
                <i class="bi bi-newspaper"></i>
                <span class="nav-text">Berita & Info</span>
                <i class="bi bi-chevron-down dropdown-arrow"></i>
            </div>
            <ul class="sub-menu {{ request()->routeIs('admin.berita.*') ? 'expanded' : '' }}">
                <li class="sub-menu-item">
                    <a href="{{ route('admin.berita.index') }}"
                        class="sub-menu-link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}"
                        data-subpage="kelola-berita">
                        <i class="bi bi-pencil-square"></i>
                        <span>Kelola Berita</span>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="#"
                        class="sub-menu-link {{ request()->routeIs('admin.berita.pengumuman.*') ? 'active' : '' }}"
                        data-subpage="pengumuman">
                        <i class="bi bi-megaphone"></i>
                        <span>Pengumuman</span>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="{{ route('admin.galeri.index') }}"
                        class="sub-menu-link {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}"
                        data-subpage="galeri">
                        <i class="bi bi-image"></i>
                        <span>Galeri Foto</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Keuangan Desa dengan Sub Menu -->
        <li class="nav-item">
            <div class="nav-link has-submenu {{ request()->routeIs('admin.apbdes.*') ? 'expanded' : '' }}"
                data-page="keuangan">
                <i class="bi bi-cash-stack"></i>
                <span class="nav-text">Keuangan Desa</span>
                <i class="bi bi-chevron-down dropdown-arrow"></i>
            </div>
            <ul class="sub-menu {{ request()->routeIs('admin.apbdes.*') ? 'expanded' : '' }}">
                <li class="sub-menu-item">
                    <a href="{{ route('admin.apbdes.index') }}"
                        class="sub-menu-link {{ request()->routeIs('admin.apbdes.*') ? 'active' : '' }}"
                        data-subpage="apbd">
                        <i class="bi bi-pie-chart"></i>
                        <span>APB Desa</span>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="#"
                        class="sub-menu-link {{ request()->routeIs('admin.keuangan.pemasukan.*') ? 'active' : '' }}"
                        data-subpage="pemasukan">
                        <i class="bi bi-arrow-down-circle"></i>
                        <span>Pemasukan</span>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="#"
                        class="sub-menu-link {{ request()->routeIs('admin.keuangan.pengeluaran.*') ? 'active' : '' }}"
                        data-subpage="pengeluaran">
                        <i class="bi bi-arrow-up-circle"></i>
                        <span>Pengeluaran</span>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="#"
                        class="sub-menu-link {{ request()->routeIs('admin.keuangan.laporan.*') ? 'active' : '' }}"
                        data-subpage="laporan-keuangan">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        <span>Laporan Keuangan</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Infrastruktur dengan Sub Menu -->
        <li class="nav-item">
            <div class="nav-link has-submenu {{ request()->routeIs('admin.infrastruktur.*') ? 'expanded' : '' }}"
                data-page="infrastruktur">
                <i class="bi bi-buildings"></i>
                <span class="nav-text">Infrastruktur</span>
                <i class="bi bi-chevron-down dropdown-arrow"></i>
            </div>
            <ul class="sub-menu {{ request()->routeIs('admin.infrastruktur.*') ? 'expanded' : '' }}">
                <li class="sub-menu-item">
                    <a href="#"
                        class="sub-menu-link {{ request()->routeIs('admin.infrastruktur.jalan.*') ? 'active' : '' }}"
                        data-subpage="jalan-jembatan">
                        <i class="bi bi-signpost-2"></i>
                        <span>Jalan & Jembatan</span>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="#"
                        class="sub-menu-link {{ request()->routeIs('admin.infrastruktur.air.*') ? 'active' : '' }}"
                        data-subpage="air-bersih">
                        <i class="bi bi-droplet"></i>
                        <span>Air Bersih</span>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="#"
                        class="sub-menu-link {{ request()->routeIs('admin.infrastruktur.listrik.*') ? 'active' : '' }}"
                        data-subpage="listrik">
                        <i class="bi bi-lightning"></i>
                        <span>Listrik</span>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="#"
                        class="sub-menu-link {{ request()->routeIs('admin.infrastruktur.proyek.*') ? 'active' : '' }}"
                        data-subpage="proyek-pembangunan">
                        <i class="bi bi-hammer"></i>
                        <span>Proyek Pembangunan</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Laporan dengan Sub Menu -->
        <li class="nav-item">
            <div class="nav-link has-submenu {{ request()->routeIs('admin.laporan.*') ? 'expanded' : '' }}"
                data-page="laporan">
                <i class="bi bi-graph-up"></i>
                <span class="nav-text">Laporan</span>
                <i class="bi bi-chevron-down dropdown-arrow"></i>
            </div>
            <ul class="sub-menu {{ request()->routeIs('admin.laporan.*') ? 'expanded' : '' }}">
                <li class="sub-menu-item">
                    <a href="#"
                        class="sub-menu-link {{ request()->routeIs('admin.laporan.bulanan.*') ? 'active' : '' }}"
                        data-subpage="laporan-bulanan">
                        <i class="bi bi-calendar-month"></i>
                        <span>Laporan Bulanan</span>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="#"
                        class="sub-menu-link {{ request()->routeIs('admin.laporan.tahunan.*') ? 'active' : '' }}"
                        data-subpage="laporan-tahunan">
                        <i class="bi bi-calendar-year"></i>
                        <span>Laporan Tahunan</span>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="#"
                        class="sub-menu-link {{ request()->routeIs('admin.laporan.analisis.*') ? 'active' : '' }}"
                        data-subpage="analisis-data">
                        <i class="bi bi-bar-chart"></i>
                        <span>Analisis Data</span>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="#"
                        class="sub-menu-link {{ request()->routeIs('admin.laporan.export.*') ? 'active' : '' }}"
                        data-subpage="export-data">
                        <i class="bi bi-download"></i>
                        <span>Export Data</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Pengaturan dengan Sub Menu -->
        <li class="nav-item">
            <div class="nav-link has-submenu {{ request()->routeIs('admin.pengaturan.*') ? 'expanded' : '' }}"
                data-page="pengaturan">
                <i class="bi bi-gear-fill"></i>
                <span class="nav-text">Pengaturan</span>
                <i class="bi bi-chevron-down dropdown-arrow"></i>
            </div>
            <ul class="sub-menu {{ request()->routeIs('admin.pengaturan.*') ? 'expanded' : '' }}">
                <li class="sub-menu-item">
                    <a href="#"
                        class="sub-menu-link {{ request()->routeIs('admin.pengaturan.umum.*') ? 'active' : '' }}"
                        data-subpage="pengaturan-umum">
                        <i class="bi bi-sliders"></i>
                        <span>Pengaturan Umum</span>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="#"
                        class="sub-menu-link {{ request()->routeIs('admin.pengaturan.user.*') ? 'active' : '' }}"
                        data-subpage="manajemen-user">
                        <i class="bi bi-people-fill"></i>
                        <span>Manajemen User</span>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="#"
                        class="sub-menu-link {{ request()->routeIs('admin.pengaturan.backup.*') ? 'active' : '' }}"
                        data-subpage="backup-restore">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <span>Backup & Restore</span>
                    </a>
                </li>
                <li class="sub-menu-item">
                    <a href="#"
                        class="sub-menu-link {{ request()->routeIs('admin.pengaturan.log.*') ? 'active' : '' }}"
                        data-subpage="log-aktivitas">
                        <i class="bi bi-clock-history"></i>
                        <span>Log Aktivitas</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
