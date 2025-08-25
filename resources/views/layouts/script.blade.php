<script>
    // Global variables
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const userProfile = document.getElementById('userProfile');
    const profileDropdown = document.getElementById('profileDropdown');
    const themeSwitch = document.getElementById('themeSwitch');

    // Theme management
    class ThemeManager {
        constructor() {
            this.currentTheme = localStorage.getItem('theme') || 'light';
            this.init();
        }

        init() {
            this.applyTheme(this.currentTheme);
            this.updateThemeSwitch();
        }

        applyTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            this.currentTheme = theme;
            localStorage.setItem('theme', theme);
        }

        toggleTheme() {
            const newTheme = this.currentTheme === 'light' ? 'dark' : 'light';
            this.applyTheme(newTheme);
            this.updateThemeSwitch();
        }

        updateThemeSwitch() {
            const isActive = this.currentTheme === 'dark';
            themeSwitch.classList.toggle('active', isActive);
        }
    }

    // Initialize theme manager
    const themeManager = new ThemeManager();

    // Sidebar functionality
    function initSidebar() {
        sidebarToggle.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('show');
            } else {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            }
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });

        // Window resize handler
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
            }
        });
    }

    // Sub menu functionality
    function initSubMenus() {
        const menuItems = document.querySelectorAll('.nav-link.has-submenu');

        menuItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();

                // Don't toggle if sidebar is collapsed
                if (sidebar.classList.contains('collapsed')) {
                    return;
                }

                const subMenu = this.nextElementSibling;
                const isExpanded = this.classList.contains('expanded');

                // Close all other sub menus
                menuItems.forEach(otherItem => {
                    if (otherItem !== this) {
                        otherItem.classList.remove('expanded');
                        const otherSubMenu = otherItem.nextElementSibling;
                        if (otherSubMenu) {
                            otherSubMenu.classList.remove('expanded');
                        }
                    }
                });

                // Toggle current sub menu
                this.classList.toggle('expanded');
                if (subMenu) {
                    subMenu.classList.toggle('expanded');
                }
            });
        });
    }

    // Navigation functionality
    function initNavigation() {
        const navLinks = document.querySelectorAll('.nav-link:not(.has-submenu)');
        const subMenuLinks = document.querySelectorAll('.sub-menu-link');
        const headerTitle = document.querySelector('.header-title');

        const pageNames = {
            'dashboard': 'Dashboard Admin',
            'penduduk': 'Data Penduduk',
            'administrasi': 'Administrasi',
            'layanan': 'Layanan Publik',
            'berita': 'Berita & Info',
            'keuangan': 'Keuangan Desa',
            'infrastruktur': 'Infrastruktur',
            'laporan': 'Laporan',
            'pengaturan': 'Pengaturan'
        };

        const subPageNames = {
            'kelola-kk': 'Kelola Kartu Keluarga',
            'kelola-penduduk': 'Kelola Penduduk',
            'statistik-penduduk': 'Statistik Pertumbuhan Penduduk',
            'surat-keterangan': 'Surat Keterangan',
            'surat-domisili': 'Surat Domisili',
            'surat-usaha': 'Surat Usaha',
            'template-surat': 'Template Surat',
            'layanan-kesehatan': 'Layanan Kesehatan',
            'layanan-pendidikan': 'Layanan Pendidikan',
            'fasilitas-umum': 'Fasilitas Umum',
            'jadwal-pelayanan': 'Jadwal Pelayanan',
            'kelola-berita': 'Kelola Berita',
            'pengumuman': 'Pengumuman',
            'galeri': 'Galeri Foto',
            'apbd': 'APB Desa',
            'pemasukan': 'Pemasukan',
            'pengeluaran': 'Pengeluaran',
            'laporan-keuangan': 'Laporan Keuangan',
            'jalan-jembatan': 'Jalan & Jembatan',
            'air-bersih': 'Air Bersih',
            'listrik': 'Listrik',
            'proyek-pembangunan': 'Proyek Pembangunan',
            'laporan-bulanan': 'Laporan Bulanan',
            'laporan-tahunan': 'Laporan Tahunan',
            'analisis-data': 'Analisis Data',
            'export-data': 'Export Data',
            'pengaturan-umum': 'Pengaturan Umum',
            'manajemen-user': 'Manajemen User',
            'backup-restore': 'Backup & Restore',
            'log-aktivitas': 'Log Aktivitas'
        };

        // Handle main navigation
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href && href !== '#' && href !== 'javascript:void(0)') {
                    navLinks.forEach(l => l.classList.remove('active'));
                    subMenuLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');

                    if (window.innerWidth <= 768) {
                        sidebar.classList.remove('show');
                    }
                    return;
                }
                e.preventDefault();
                navLinks.forEach(l => l.classList.remove('active'));
                subMenuLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
                const page = this.dataset.page;
                headerTitle.textContent = pageNames[page] || 'Dashboard Admin';
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('show');
                }
            });
        });

        // Handle sub menu navigation
        subMenuLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href && href !== '#' && href !== 'javascript:void(0)') {
                    navLinks.forEach(l => l.classList.remove('active'));
                    subMenuLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                    if (window.innerWidth <= 768) {
                        sidebar.classList.remove('show');
                    }
                    return;
                }
                e.preventDefault();
                navLinks.forEach(l => l.classList.remove('active'));
                subMenuLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
                const subpage = this.dataset.subpage;
                headerTitle.textContent = subPageNames[subpage] || 'Dashboard Admin';
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('show');
                }
            });
        });
    }

    // Profile dropdown functionality
    function initProfileDropdown() {
        // Toggle dropdown
        userProfile.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('show');
            // Close notification dropdown if open
            const notificationDropdown = document.getElementById('notificationDropdown');
            if (notificationDropdown) {
                notificationDropdown.classList.remove('show');
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userProfile.contains(e.target)) {
                profileDropdown.classList.remove('show');
            }
        });

        // Theme toggle
        themeSwitch.addEventListener('click', function(e) {
            e.stopPropagation();
            themeManager.toggleTheme();
        });

        // Profile actions
        // Menghapus event listener lama yang tidak terpakai
    }

    // Clock functionality
    function initClock() {
        const clockElement = document.getElementById('headerClock');
        const timeElement = clockElement.querySelector('.clock-time');
        const dateElement = clockElement.querySelector('.clock-date');

        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            const dateString = now.toLocaleDateString('id-ID', {
                weekday: 'short',
                day: 'numeric',
                month: 'short'
            });

            timeElement.textContent = timeString;
            dateElement.textContent = dateString;
        }

        updateClock();
        setInterval(updateClock, 1000);
    }

    // Counter animation
    function animateCounters() {
        const counters = document.querySelectorAll('.stat-number');

        counters.forEach(counter => {
            const target = parseInt(counter.textContent.replace(/,/g, ''));
            let current = 0;
            const increment = target / 60;

            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    counter.textContent = target.toLocaleString();
                    clearInterval(timer);
                } else {
                    counter.textContent = Math.floor(current).toLocaleString();
                }
            }, 25);
        });
    }

    // Card animations
    function animateCards() {
        const cards = document.querySelectorAll('.stat-card, .activity-card');

        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';

            setTimeout(() => {
                card.style.transition = 'all 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    }

    // Quick actions functionality
    function initQuickActions() {
        document.querySelectorAll('.action-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const action = this.querySelector('span').textContent;

                // Add loading effect
                const originalContent = this.innerHTML;
                this.innerHTML = '<i class="bi bi-hourglass-split"></i><span>Loading...</span>';
                this.style.pointerEvents = 'none';

                setTimeout(() => {
                    this.innerHTML = originalContent;
                    this.style.pointerEvents = 'auto';
                    alert(`Fitur "${action}" akan segera tersedia!`);
                }, 1000);
            });
        });
    }

    // Notification functionality
    function initNotifications() {
        const notificationBtn = document.getElementById('notificationBtn');
        const notificationDropdown = document.getElementById('notificationDropdown');

        if (notificationBtn && notificationDropdown) {
            notificationBtn.addEventListener('click', function(event) {
                event.stopPropagation();
                notificationDropdown.classList.toggle('show');

                // Close profile dropdown if open
                const profileDropdown = document.getElementById('profileDropdown');
                if (profileDropdown) {
                    profileDropdown.classList.remove('show');
                }
            });

            // Hide dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!notificationDropdown.contains(event.target) && !notificationBtn.contains(event.target)) {
                    notificationDropdown.classList.remove('show');
                }
            });

            // Prevent dropdown from closing when clicking inside
            notificationDropdown.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        }
    }

    // Initialize all components
    function initDashboard() {
        initSidebar();
        initSubMenus();
        initNavigation();
        initProfileDropdown();
        initClock();
        initQuickActions();
        initNotifications();

        // Add animations with delay
        setTimeout(() => {
            animateCards();
            setTimeout(animateCounters, 300);
        }, 100);
    }

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', initDashboard);

    // Performance logging
    window.addEventListener('load', function() {
        const loadTime = window.performance.timing.loadEventEnd - window.performance.timing.navigationStart;
        console.log(`Dashboard loaded in ${loadTime}ms`);
    });
</script>
