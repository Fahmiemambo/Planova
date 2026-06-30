/**
 * Planova — Global JavaScript
 * Initializes Bootstrap components and app-wide utilities
 */

document.addEventListener('DOMContentLoaded', function () {
    // Initialize Bootstrap tooltips
    const tooltipEls = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipEls.forEach(el => new bootstrap.Tooltip(el, { trigger: 'hover' }));

    // Initialize Bootstrap dropdowns
    const dropdownEls = document.querySelectorAll('[data-bs-toggle="dropdown"]');
    dropdownEls.forEach(el => new bootstrap.Dropdown(el));

    // Auto-dismiss flash alerts
    const flashAlerts = document.querySelectorAll('.alert-p[data-auto-dismiss]');
    flashAlerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 400ms ease, transform 400ms ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-8px)';
            setTimeout(() => alert.remove(), 400);
        }, 4000);
    });

    // Animate page content on load
    const pageContent = document.querySelector('.page-content');
    if (pageContent) {
        pageContent.style.animation = 'fadeInUp 250ms ease both';
    }
});

/**
 * Flash message helper — call from anywhere
 * @param {string} message
 * @param {'success'|'danger'|'warning'|'info'} type
 */
window.showFlash = function (message, type = 'success') {
    const container = document.getElementById('flash-container');
    if (!container) return;

    const icons = {
        success: 'bi-check-circle-fill',
        danger:  'bi-exclamation-circle-fill',
        warning: 'bi-exclamation-triangle-fill',
        info:    'bi-info-circle-fill'
    };

    const el = document.createElement('div');
    el.className = `alert-p alert-p-${type} animate-fadeInUp`;
    el.setAttribute('data-auto-dismiss', '');
    el.innerHTML = `<i class="bi ${icons[type] || icons.info}"></i><span>${message}</span>`;
    container.appendChild(el);

    // Auto-remove
    setTimeout(() => {
        el.style.transition = 'opacity 400ms ease, transform 400ms ease';
        el.style.opacity = '0';
        el.style.transform = 'translateY(-8px)';
        setTimeout(() => el.remove(), 400);
    }, 4000);
};

/**
 * AJAX helper with CSRF token
 * @param {string} url
 * @param {string} method
 * @param {object} data
 * @returns {Promise}
 */
window.apiRequest = function (url, method = 'GET', data = null) {
    const options = {
        method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            'Accept': 'application/json'
        }
    };
    if (data && method !== 'GET') {
        options.body = JSON.stringify(data);
    }
    return fetch(url, options).then(res => {
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        return res.json();
    });
};
