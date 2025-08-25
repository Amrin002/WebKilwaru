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
        if (themeSwitch) {
            const isActive = this.currentTheme === 'dark';
            themeSwitch.classList.toggle('active', isActive);
        }
    }
}

// Initialize theme manager
const themeManager = new ThemeManager();

// Sidebar functionality
function initSidebar() {
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('show');
            } else {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            }
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        }
    });

    // Initialize Bootstrap Collapse for sidebar dropdowns
    const sidebarDropdowns = document.querySelectorAll('.sidebar-nav [data-bs-toggle="collapse"]');
    sidebarDropdowns.forEach(dropdown => {
        const targetId = dropdown.getAttribute('data-bs-target');
        const targetElement = document.querySelector(targetId);
        
        if (targetElement) {
            // Initialize Bootstrap Collapse
            new bootstrap.Collapse(targetElement, {
                toggle: false
            });
            
            // Update chevron icon on toggle
            targetElement.addEventListener('show.bs.collapse', () => {
                const icon = dropdown.querySelector('.bi-chevron-down');
                if (icon) icon.style.transform = 'rotate(180deg)';
            });
            
            targetElement.addEventListener('hide.bs.collapse', () => {
                const icon = dropdown.querySelector('.bi-chevron-down');
                if (icon) icon.style.transform = 'rotate(0deg)';
            });
        }
    });

    // Window resize handler
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('show');
        }
    });
}

// Navigation functionality - Updated to work with Laravel routes
function initNavigation() {
    const navLinks = document.querySelectorAll('.nav-link');
    const subItems = document.querySelectorAll('.sub-item');

    // Handle main navigation links (that have href attributes for Laravel routes)
    navLinks.forEach(link => {
        // Only add preventDefault for links with # or no href (not Laravel routes)
        if (link.getAttribute('href') === '#' || !link.getAttribute('href')) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all main nav links that don't have data-bs-toggle
                navLinks.forEach(l => {
                    if (!l.hasAttribute('data-bs-toggle')) {
                        l.classList.remove('active');
                    }
                });
                
                // Remove active class from all sub-items
                subItems.forEach(item => {
                    item.classList.remove('active');
                });

                // Add active class to clicked link
                this.classList.add('active');
                
                // Close sidebar on mobile after selection
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('show');
                }
            });
        } else {
            // For Laravel route links, just handle mobile sidebar closing
            link.addEventListener('click', function() {
                // Close sidebar on mobile after selection
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('show');
                }
            });
        }
    });

    // Handle sub-menu items
    subItems.forEach(item => {
        if (item.getAttribute('href') === '#' || !item.getAttribute('href')) {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all sub-items
                subItems.forEach(subItem => {
                    subItem.classList.remove('active');
                });
                
                // Add active class to clicked sub-item
                this.classList.add('active');
                
                // Close sidebar on mobile after selection
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('show');
                }
            });
        } else {
            // For Laravel route links, just handle mobile sidebar closing
            item.addEventListener('click', function() {
                // Close sidebar on mobile after selection
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('show');
                }
            });
        }
    });
}

// Set active menu based on current URL
function setActiveMenuFromUrl() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link[href]');
    const subItems = document.querySelectorAll('.sub-item[href]');
    
    // Remove all active classes first
    navLinks.forEach(link => link.classList.remove('active'));
    subItems.forEach(item => item.classList.remove('active'));
    
    // Check main navigation links
    navLinks.forEach(link => {
        const linkPath = new URL(link.href, window.location.origin).pathname;
        if (currentPath === linkPath) {
            link.classList.add('active');
        }
    });
    
    // Check sub-menu items
    subItems.forEach(item => {
        const linkPath = new URL(item.href, window.location.origin).pathname;
        if (currentPath === linkPath) {
            item.classList.add('active');
            
            // Also expand the parent dropdown if it's a sub-item
            const parentCollapse = item.closest('.collapse');
            if (parentCollapse) {
                const collapseInstance = new bootstrap.Collapse(parentCollapse, { toggle: false });
                collapseInstance.show();
            }
        }
    });
}

// Profile dropdown functionality
function initProfileDropdown() {
    if (userProfile && profileDropdown) {
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
        if (themeSwitch) {
            themeSwitch.addEventListener('click', function(e) {
                e.stopPropagation();
                themeManager.toggleTheme();
            });
        }

        // Profile actions
        const profileBtn = document.getElementById('profileBtn');
        const settingsBtn = document.getElementById('settingsBtn');
        const logoutBtn = document.getElementById('logoutBtn');

        if (profileBtn) {
            profileBtn.addEventListener('click', function(e) {
                e.preventDefault();
                profileDropdown.classList.remove('show');
                alert('Menuju halaman profil...');
            });
        }

        if (settingsBtn) {
            settingsBtn.addEventListener('click', function(e) {
                e.preventDefault();
                profileDropdown.classList.remove('show');
                alert('Menuju halaman pengaturan...');
            });
        }

        if (logoutBtn) {
            logoutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                profileDropdown.classList.remove('show');
                if (confirm('Apakah Anda yakin ingin logout?')) {
                    alert('Logout berhasil!');
                }
            });
        }
    }
}

// Clock functionality
function initClock() {
    const clockElement = document.getElementById('headerClock');
    if (clockElement) {
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

            if (timeElement) timeElement.textContent = timeString;
            if (dateElement) dateElement.textContent = dateString;
        }

        updateClock();
        setInterval(updateClock, 1000);
    }
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
            // Only prevent default if it's a # link
            if (this.getAttribute('href') === '#') {
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
            }
        });
    });
}

// Notification functionality
function initNotifications() {
    const notificationBtn = document.querySelector('.notification-btn');
    if (notificationBtn) {
        notificationBtn.addEventListener('click', function() {
            const notifications = [
                'Ada 3 permohonan surat baru',
                'Laporan bulanan siap dilihat',
                'Update sistem berhasil'
            ];
            alert(notifications.join('\n'));
        });
    }
}

// Initialize all components
function initDashboard() {
    initSidebar();
    initNavigation();
    initProfileDropdown();
    initClock();
    initQuickActions();
    initNotifications();
    
    // Set active menu based on current URL
    setActiveMenuFromUrl();

    // Add animations with delay if elements exist
    if (document.querySelectorAll('.stat-card, .activity-card').length > 0) {
        setTimeout(() => {
            animateCards();
            setTimeout(animateCounters, 300);
        }, 100);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', initDashboard);

// Performance logging
window.addEventListener('load', function() {
    const loadTime = window.performance.timing.loadEventEnd - window.performance.timing.navigationStart;
    console.log(`Dashboard loaded in ${loadTime}ms`);
});