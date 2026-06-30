/**
 * Planova — Sidebar Toggle
 * Collapse/expand sidebar. State stored in sessionStorage.
 */

(function () {
    const STORAGE_KEY = 'planova_sidebar_collapsed';
    const MOBILE_KEY  = 'planova_sidebar_mobile_open';

    const sidebar    = document.getElementById('app-sidebar');
    const overlay    = document.getElementById('sidebar-overlay');
    const toggleBtns = document.querySelectorAll('.sidebar-toggle-btn');

    if (!sidebar) return;

    // ── Restore state on load ──────────────────────────────
    const isCollapsed = sessionStorage.getItem(STORAGE_KEY) === 'true';
    const isMobile    = window.innerWidth <= 768;

    if (!isMobile && isCollapsed) {
        sidebar.classList.add('collapsed');
    }

    // ── Toggle handler ─────────────────────────────────────
    function toggleSidebar() {
        if (window.innerWidth <= 768) {
            // Mobile: slide in/out
            const isOpen = sidebar.classList.toggle('mobile-open');
            if (overlay) overlay.classList.toggle('active', isOpen);
        } else {
            // Desktop: collapse/expand
            const nowCollapsed = sidebar.classList.toggle('collapsed');
            sessionStorage.setItem(STORAGE_KEY, nowCollapsed);
        }
    }

    toggleBtns.forEach(btn => btn.addEventListener('click', toggleSidebar));

    // Close sidebar when clicking overlay (mobile)
    if (overlay) {
        overlay.addEventListener('click', function () {
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
        });
    }

    // Handle window resize — reset classes on breakpoint change
    let lastWidth = window.innerWidth;
    window.addEventListener('resize', function () {
        const currentWidth = window.innerWidth;
        if (lastWidth !== currentWidth) {
            if (currentWidth > 768) {
                sidebar.classList.remove('mobile-open');
                if (overlay) overlay.classList.remove('active');
                // Re-apply collapse state from storage
                const saved = sessionStorage.getItem(STORAGE_KEY) === 'true';
                sidebar.classList.toggle('collapsed', saved);
            } else {
                sidebar.classList.remove('collapsed');
            }
            lastWidth = currentWidth;
        }
    });

    // ── Active nav item highlight ──────────────────────────
    const currentPath = window.location.pathname;
    const navLinks = sidebar.querySelectorAll('.sidebar-item[href]');
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href && href !== '/' && currentPath.startsWith(href)) {
            link.classList.add('active');
        } else if (href === '/' && currentPath === '/') {
            link.classList.add('active');
        }
    });
})();
