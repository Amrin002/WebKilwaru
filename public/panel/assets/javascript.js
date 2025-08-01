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

        // Navigation functionality
        function initNavigation() {
            const navLinks = document.querySelectorAll('.nav-link');
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

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remove active class from all links
                    navLinks.forEach(l => l.classList.remove('active'));

                    // Add active class to clicked link
                    this.classList.add('active');

                    // Update header title
                    const page = this.dataset.page;
                    headerTitle.textContent = pageNames[page] || 'Dashboard Admin';

                    // Close sidebar on mobile after selection
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
            document.getElementById('profileBtn').addEventListener('click', function(e) {
                e.preventDefault();
                profileDropdown.classList.remove('show');
                alert('Menuju halaman profil...');
            });

            document.getElementById('settingsBtn').addEventListener('click', function(e) {
                e.preventDefault();
                profileDropdown.classList.remove('show');
                alert('Menuju halaman pengaturan...');
            });

            document.getElementById('logoutBtn').addEventListener('click', function(e) {
                e.preventDefault();
                profileDropdown.classList.remove('show');
                if (confirm('Apakah Anda yakin ingin logout?')) {
                    alert('Logout berhasil!');
                }
            });
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
            document.querySelector('.notification-btn').addEventListener('click', function() {
                const notifications = [
                    'Ada 3 permohonan surat baru',
                    'Laporan bulanan siap dilihat',
                    'Update sistem berhasil'
                ];
                alert(notifications.join('\n'));
            });
        }

        // Initialize all components
        function initDashboard() {
            initSidebar();
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