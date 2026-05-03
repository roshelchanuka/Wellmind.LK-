function initApp() {
    // 1. Scroll Reveal Logic (PRIORITY)
    const revealElements = document.querySelectorAll('.reveal');
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });

    if (revealElements.length > 0) {
        revealElements.forEach(el => revealObserver.observe(el));
        
        // Failsafe: Activate all reveal elements after 2 seconds if some are stuck
        setTimeout(() => {
            revealElements.forEach(el => {
                if (!el.classList.contains('active')) {
                    el.classList.add('active');
                }
            });
        }, 2000);
    }

    // 2. Image Hover Follower
    try {
        const hoverPopup = document.getElementById('image-hover-popup');
        const popupImg = hoverPopup ? hoverPopup.querySelector('img') : null;
        const hoverableImages = document.querySelectorAll('.feature-card__img, .self-care-item__img, .insight-image, .action-card__img, .support-card__img');

        if (hoverPopup && popupImg && hoverableImages.length > 0) {
            hoverableImages.forEach(img => {
                img.addEventListener('mouseenter', () => {
                    popupImg.src = img.src;
                    hoverPopup.classList.add('visible');
                });

                img.addEventListener('mouseleave', () => {
                    hoverPopup.classList.remove('visible');
                });

                img.addEventListener('mousemove', (e) => {
                    const x = e.clientX + 20;
                    const y = e.clientY + 20;
                    hoverPopup.style.transform = `translate(${x}px, ${y}px)`;
                });
            });
        }
    } catch (err) {
        console.warn('Image Hover Popup initialization failed:', err);
    }

    // 3. History Welcome Modal Logic
    const historyModal = document.getElementById('historyWelcomeOverlay');
    if (historyModal) {
        const closeBtn = document.getElementById('hwCloseBtn');
        const progressBar = document.getElementById('hwProgressBar');
        
        setTimeout(() => {
            historyModal.classList.add('hw-show');
            if (progressBar) progressBar.style.width = '100%';
        }, 800);

        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                historyModal.classList.remove('hw-show');
                historyModal.classList.add('hw-hide');
                setTimeout(() => historyModal.style.display = 'none', 500);
            });
        }
    }

    // 4. Dynamic Greeting for Admin Panel
    const greetingText = document.querySelector('[data-key="greetingWelcomeBack"]');
    if (greetingText) {
        const hour = new Date().getHours();
        let greeting = 'Good Morning';
        if (hour >= 12 && hour < 17) greeting = 'Good Afternoon';
        if (hour >= 17) greeting = 'Good Evening';
        
        if (greetingText.innerText.includes('Welcome back')) {
            greetingText.innerText = `${greeting},`;
        }
    }

    // 5. Liquid Header Scroll Effect
    const header = document.getElementById('header');
    if (header) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    }

    // 6. Sidebar/Nav Active State Polish
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav__link, .nav-links a');
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (href && (currentPath === href || currentPath.endsWith(href))) {
            link.classList.add('active');
        }
    });
}
initApp();
