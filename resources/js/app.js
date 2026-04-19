import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    // 1. Scroll Reveal Logic
    const revealElements = document.querySelectorAll('.reveal');
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.1 });

    revealElements.forEach(el => revealObserver.observe(el));

    // 2. Mouse Parallax for Glass Cards
    const glassCards = document.querySelectorAll('.stat-card, .card, .stat-card');
    document.addEventListener('mousemove', (e) => {
        const { clientX, clientY } = e;
        const centerX = window.innerWidth / 2;
        const centerY = window.innerHeight / 2;
        
        glassCards.forEach(card => {
            const rect = card.getBoundingClientRect();
            const cardCenterX = rect.left + rect.width / 2;
            const cardCenterY = rect.top + rect.height / 2;
            
            const mouseX = (clientX - cardCenterX) / 40;
            const mouseY = (clientY - cardCenterY) / 40;
            
            card.style.transform = `translateY(-5px) perspective(1000px) rotateX(${-mouseY}deg) rotateY(${mouseX}deg)`;
        });
    });

    // 3. Dynamic Greeting for Admin Panel
    const greetingText = document.querySelector('[data-key="greetingWelcomeBack"]');
    if (greetingText) {
        const hour = new Date().getHours();
        let greeting = 'Good Morning';
        if (hour >= 12 && hour < 17) greeting = 'Good Afternoon';
        if (hour >= 17) greeting = 'Good Evening';
        
        // Only update if it's the standard welcome back text
        if (greetingText.innerText.includes('Welcome back')) {
            greetingText.innerText = `${greeting},`;
        }
    }

    // 4. Liquid Header Scroll Effect
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

    // 5. Sidebar Active State Polish
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-links a');
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });
});
