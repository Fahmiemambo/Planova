import './bootstrap';
import anime from 'animejs/lib/anime.es.js';

// Expose anime to window so it can be used inline if needed
window.anime = anime;

document.addEventListener('DOMContentLoaded', () => {
    // 1. Initial Page Load Animations
    // Memudar masuk seluruh container utama agar transisi terasa smooth
    anime({
        targets: 'body',
        opacity: [0, 1],
        duration: 800,
        easing: 'easeInOutSine'
    });

    // Staggered Cards (seperti daftar task, menu, dll)
    anime({
        targets: '.animate-stagger-card',
        translateY: [30, 0],
        opacity: [0, 1],
        delay: anime.stagger(120, {start: 100}),
        easing: 'easeOutElastic(1, .8)',
        duration: 900
    });

    // Simple Fade In
    anime({
        targets: '.animate-fade-in',
        opacity: [0, 1],
        easing: 'easeOutQuad',
        duration: 600
    });

    // Animasi Khusus untuk Form Login/Register (muncul dari bawah)
    if (document.querySelector('#login-form') || document.querySelector('#register-form')) {
        anime({
            targets: '.animate-fade-in-up',
            translateY: [40, 0],
            opacity: [0, 1],
            easing: 'easeOutCubic',
            duration: 800
        });
    }

    // 2. Interactive Buttons (Hover & Click effect)
    document.querySelectorAll('.btn-planova, .p-interactive').forEach(el => {
        // Efek saat ditekan
        el.addEventListener('mousedown', () => {
            anime({
                targets: el,
                scale: 0.95,
                duration: 150,
                easing: 'easeOutQuad'
            });
        });
        
        // Efek dilepas
        el.addEventListener('mouseup', () => {
            anime({
                targets: el,
                scale: 1,
                duration: 400,
                easing: 'easeOutElastic(1, .6)'
            });
        });

        // Hover effect khusus untuk tombol (sedikit membesar)
        if(el.classList.contains('btn-planova')) {
            el.addEventListener('mouseenter', () => {
                anime({
                    targets: el,
                    scale: 1.03,
                    duration: 300,
                    easing: 'easeOutQuad'
                });
            });
            el.addEventListener('mouseleave', () => {
                anime({
                    targets: el,
                    scale: 1,
                    duration: 400,
                    easing: 'easeOutElastic(1, .6)'
                });
            });
        }
    });

    // 3. Dark Mode Toggle setup
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-toggle-icon');

    if (themeToggleBtn) {
        // Initialize theme based on local storage or system preference
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            if(themeIcon) themeIcon.classList.replace('bi-moon', 'bi-sun');
        } else {
            document.documentElement.classList.remove('dark');
            if(themeIcon) themeIcon.classList.replace('bi-sun', 'bi-moon');
        }

        themeToggleBtn.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            const isDark = document.documentElement.classList.contains('dark');
            
            // Animation for toggle icon rotation and scale
            if(themeIcon) {
                anime({
                    targets: themeIcon,
                    rotate: isDark ? '360deg' : '-360deg',
                    scale: [0.2, 1.2, 1],
                    duration: 800,
                    easing: 'easeOutElastic(1, .5)'
                });
            }

            // Animasikan body background color
            anime({
                targets: 'body',
                backgroundColor: isDark ? '#191919' : '#f7f7f5',
                color: isDark ? '#eaeaeb' : '#1a1a18',
                duration: 400,
                easing: 'easeInOutQuad'
            });

            if (isDark) {
                localStorage.theme = 'dark';
                if(themeIcon) {
                    setTimeout(() => themeIcon.classList.replace('bi-moon', 'bi-sun'), 150);
                }
            } else {
                localStorage.theme = 'light';
                if(themeIcon) {
                    setTimeout(() => themeIcon.classList.replace('bi-sun', 'bi-moon'), 150);
                }
            }
        });
    }

    // 4. Global SPA Form Handler
    window.showConfirmDialog = function(message) {
        return new Promise(resolve => {
            const modal = document.getElementById('confirm-modal');
            const messageEl = document.getElementById('confirm-modal-message');
            const confirmButton = document.getElementById('confirm-modal-confirm');
            const cancelButton = document.getElementById('confirm-modal-cancel');

            if (!modal || !messageEl || !confirmButton || !cancelButton) {
                resolve(window.confirm(message));
                return;
            }

            const resetModal = () => {
                modal.classList.add('hidden');
                confirmButton.removeEventListener('click', onConfirm);
                cancelButton.removeEventListener('click', onCancel);
                document.removeEventListener('keydown', onKeyDown);
            };

            const onConfirm = () => {
                resetModal();
                resolve(true);
            };

            const onCancel = () => {
                resetModal();
                resolve(false);
            };

            const onKeyDown = e => {
                if (e.key === 'Escape') {
                    onCancel();
                }
            };

            messageEl.textContent = message;
            modal.classList.remove('hidden');
            confirmButton.focus();

            confirmButton.addEventListener('click', onConfirm);
            cancelButton.addEventListener('click', onCancel);
            document.addEventListener('keydown', onKeyDown);
        });
    };

    // Show a centered alert dialog with single OK button
    window.showAlertDialog = function(message) {
        return new Promise(resolve => {
            const modal = document.getElementById('confirm-modal');
            const messageEl = document.getElementById('confirm-modal-message');
            const confirmButton = document.getElementById('confirm-modal-confirm');
            const cancelButton = document.getElementById('confirm-modal-cancel');

            if (!modal || !messageEl || !confirmButton || !cancelButton) {
                alert(message);
                resolve();
                return;
            }

            // Backup
            const prevConfirmText = confirmButton.innerHTML;
            const prevCancelDisplay = cancelButton.style.display;

            const cleanup = () => {
                modal.classList.add('hidden');
                confirmButton.innerHTML = prevConfirmText;
                cancelButton.style.display = prevCancelDisplay;
                confirmButton.removeEventListener('click', onOk);
            };

            const onOk = () => {
                cleanup();
                resolve();
            };

            // Configure for alert: hide cancel, set OK text
            messageEl.textContent = message;
            cancelButton.style.display = 'none';
            confirmButton.innerHTML = 'OK';

            modal.classList.remove('hidden');
            confirmButton.focus();

            confirmButton.addEventListener('click', onOk);
        });
    };

    const ajaxForms = document.querySelectorAll('form[data-ajax="true"]');

    const removeFormContainer = (form) => {
        const targetSelectors = (form.dataset.removeTarget || '.workspace-item, tr, .pcard, .document-card, .note-card')
            .split(',')
            .map(s => s.trim());

        for (const selector of targetSelectors) {
            const container = form.closest(selector);
            if (container) {
                container.remove();
                return true;
            }
        }
        return false;
    };

    const redirectOverlay = document.getElementById('redirect-loader-overlay');
    const redirectCountdownEl = document.getElementById('redirect-countdown');
    let redirectInterval;

    const isEconomyNewsPage = document.body.classList.contains('page-economy-news');

    if (redirectOverlay) {
        redirectOverlay.classList.add('hidden');
        redirectOverlay.style.display = 'none';
    }

    const showRedirectOverlay = (seconds) => {
        if (!redirectOverlay || !redirectCountdownEl) return;
        redirectCountdownEl.textContent = seconds.toString();
        redirectOverlay.style.display = 'flex';
        redirectOverlay.classList.remove('hidden');
        redirectOverlay.style.opacity = '0';
        redirectOverlay.style.transition = 'opacity 0.3s ease';
        requestAnimationFrame(() => redirectOverlay.style.opacity = '1');
    };

    const hideRedirectOverlay = () => {
        if (!redirectOverlay) return;
        redirectOverlay.style.opacity = '0';
        clearInterval(redirectInterval);
        setTimeout(() => {
            redirectOverlay.classList.add('hidden');
            redirectOverlay.style.display = 'none';
        }, 300);
    };

    const startRedirectCountdown = (href) => {
        let secondsLeft = 5;
        showRedirectOverlay(secondsLeft);

        redirectInterval = setInterval(() => {
            secondsLeft -= 1;
            if (secondsLeft >= 0) {
                redirectCountdownEl.textContent = secondsLeft.toString();
            }
            if (secondsLeft <= 0) {
                clearInterval(redirectInterval);
                window.location.href = href;
            }
        }, 1000);
    };

    if (isEconomyNewsPage) {
        document.querySelectorAll('.economy-news-link').forEach(link => {
            link.addEventListener('click', (event) => {
                event.preventDefault();
                const href = link.getAttribute('href');
                if (!href) return;
                startRedirectCountdown(href);
            });
        });
    }

    ajaxForms.forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(form);
            let method = form.method.toUpperCase();

            if (formData.has('_method')) {
                method = formData.get('_method').toUpperCase();
            }

            if (method === 'DELETE') {
                const message = form.dataset.confirmMessage || 'Apakah Anda yakin ingin menghapus item ini?';
                const confirmed = await window.showConfirmDialog(message);
                if (!confirmed) return;
            }

            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnHtml = submitBtn ? submitBtn.innerHTML : '';

            if (submitBtn) {
                submitBtn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin"></i> Menyimpan...';
                submitBtn.disabled = true;
            }

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    },
                    body: formData,
                    redirect: 'follow'
                });

                const contentType = response.headers.get('content-type') || '';
                let data = null;

                if (contentType.includes('application/json')) {
                    data = await response.json();
                }

                if (response.ok) {
                    // If a redirect target is provided for POST (create), navigate there regardless of JSON
                    if (method !== 'DELETE' && form.dataset.redirectUrl) {
                        window.location = form.dataset.redirectUrl;
                        return;
                    }

                    if (data && data.success) {
                        // If this was a delete, remove from DOM and show centered alert
                        if (method === 'DELETE') {
                            const removed = removeFormContainer(form);
                            await window.showAlertDialog(data.message || 'Item berhasil dihapus.');
                            if (!removed && form.dataset.redirectUrl) {
                                window.location = form.dataset.redirectUrl;
                                return;
                            }
                        } else {
                            showPlanovaToast(data.message || 'Berhasil.');
                        }
                    } else {
                        // No JSON response: if DELETE, still remove and show generic alert; otherwise show generic toast
                        if (method === 'DELETE') {
                            const removed = removeFormContainer(form);
                            await window.showAlertDialog('Item berhasil dihapus.');
                            if (!removed && form.dataset.redirectUrl) {
                                window.location = form.dataset.redirectUrl;
                                return;
                            }
                        } else {
                            showPlanovaToast('Berhasil.');
                        }
                    }

                    if (method === 'POST' && form.dataset.resetOnSuccess === 'true') {
                        form.reset();
                    }

                    form.querySelectorAll('.validation-error').forEach(el => el.remove());
                } else if (response.status === 422 && data) {
                    showPlanovaToast('Gagal menyimpan. Periksa input Anda.', 'error');
                    form.querySelectorAll('.validation-error').forEach(el => el.remove());
                    for (const key in data.errors) {
                        const input = form.querySelector(`[name="${key}"]`);
                        if (input) {
                            const errorEl = document.createElement('div');
                            errorEl.className = 'text-sm text-red-500 mt-1 validation-error animate-fade-in';
                            errorEl.innerText = data.errors[key][0];
                            input.parentNode.appendChild(errorEl);
                        }
                    }
                } else {
                    showPlanovaToast('Terjadi kesalahan sistem.', 'error');
                }
            } catch (err) {
                console.error(err);
                showPlanovaToast('Koneksi gagal.', 'error');
            } finally {
                if (submitBtn) {
                    submitBtn.innerHTML = originalBtnHtml;
                    submitBtn.disabled = false;
                }
            }
        });
    });

});

// Helper for task completion animation
window.animateTaskCompletion = function(element) {
    anime({
        targets: element,
        scale: [1, 1.05, 1],
        backgroundColor: ['rgba(0,0,0,0)', 'rgba(34, 197, 94, 0.2)', 'rgba(0,0,0,0)'],
        duration: 800,
        easing: 'easeInOutQuad'
    });
};

// Helper Function: Toast Notification
window.showPlanovaToast = function(message, type = 'success') {
    const toastId = 'toast-' + Date.now();
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
    const icon = type === 'success' ? 'bi-check-circle' : 'bi-exclamation-triangle';
    
    const html = `
        <div id="${toastId}" class="fixed bottom-5 right-5 ${bgColor} text-white px-4 py-3 rounded-xl shadow-lg flex items-center gap-3 z-[100] opacity-0" style="transform: translateY(20px);">
            <i class="bi ${icon} text-xl"></i>
            <span class="font-medium text-sm">${message}</span>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', html);
    const toastEl = document.getElementById(toastId);
    
    // Animate in
    if (window.anime) {
        window.anime({
            targets: toastEl,
            translateY: [20, 0],
            opacity: [0, 1],
            easing: 'easeOutElastic(1, .6)',
            duration: 800
        });
        
        // Animate out after 3s
        setTimeout(() => {
            window.anime({
                targets: toastEl,
                translateY: [0, 20],
                opacity: [1, 0],
                easing: 'easeInQuad',
                duration: 400,
                complete: () => toastEl.remove()
            });
        }, 3000);
    } else {
        toastEl.style.opacity = '1';
        toastEl.style.transform = 'translateY(0)';
        setTimeout(() => toastEl.remove(), 3000);
    }
};
