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
    document.querySelectorAll('.btn-planova, .p-interactive, .pcard').forEach(el => {
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
    document.querySelectorAll('form').forEach(form => {
        // Abaikan form login, register, dan logout
        if(form.id === 'login-form' || form.id === 'register-form' || form.action.includes('logout')) return;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnHtml = submitBtn ? submitBtn.innerHTML : '';
            
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin"></i> Menyimpan...';
                submitBtn.disabled = true;
            }

            try {
                const formData = new FormData(form);
                let method = form.method.toUpperCase();
                
                // Cek override method laravel
                if(formData.has('_method')) {
                    method = formData.get('_method').toUpperCase();
                }

                // Jangan ubah method di FormData, fetch akan kirim POST dengan _method=PUT (standar Laravel API)
                // Kita selalu pakai POST di fetch untuk form laravel dengan FormData
                const fetchMethod = 'POST'; 

                const response = await fetch(form.action, {
                    method: fetchMethod,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    },
                    body: formData
                });

                if (response.ok) {
                    const data = await response.json();
                    
                    // Show custom Toast notification
                    showPlanovaToast(data.message || 'Tersimpan sukses!');
                    
                    // Kosongkan form jika ini adalah form pembuatan (method asli form adalah POST, bukan update/PUT)
                    if (method === 'POST') {
                        form.reset();
                    }
                    
                    // Hilangkan pesan error validasi sebelumnya jika ada
                    form.querySelectorAll('.validation-error').forEach(el => el.remove());
                } else if (response.status === 422) {
                    const data = await response.json();
                    showPlanovaToast('Gagal menyimpan. Periksa input Anda.', 'error');
                    
                    // Tampilkan error
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
