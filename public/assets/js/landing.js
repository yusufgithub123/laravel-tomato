// Fungsi global agar dapat diakses dari tombol HTML
function showAuthModal() {
    const modal = document.getElementById('authModal');
    if (modal) {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden'; // Mencegah scroll
    }
}

function closeAuthModal() {
    const modal = document.getElementById('authModal');
    if (modal) {
        modal.classList.remove('show');
        document.body.style.overflow = 'auto'; // Mengembalikan scroll
    }
}

// Function untuk set padding body berdasarkan tinggi navbar
function setBodyPadding() {
    const navbar = document.getElementById('main-navbar');
    const body = document.getElementById('page-body');
    if (navbar && body) {
        const navbarHeight = navbar.offsetHeight;
        body.style.paddingTop = `${navbarHeight}px`;

        // Menyesuaikan tinggi hero
        const hero = document.querySelector('.hero');
        if (hero) {
            hero.style.minHeight = `calc(100vh - ${navbarHeight}px)`;
        }
    }
}

// Saat DOM selesai dimuat
document.addEventListener('DOMContentLoaded', function () {
    setBodyPadding();

    const navbar = document.getElementById('main-navbar');
    if (navbar) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }

    // Toggle menu mobile
    const mobileToggle = document.getElementById('mobileToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    if (mobileToggle && mobileMenu) {
        mobileToggle.addEventListener('click', function () {
            this.classList.toggle('active');
            mobileMenu.classList.toggle('show');
        });
    }

    // Klik luar modal = tutup modal
    const authModal = document.getElementById('authModal');
    if (authModal) {
        authModal.addEventListener('click', function (e) {
            if (e.target === this) {
                closeAuthModal();
            }
        });
    }

    // Klik elemen yang butuh login = tampilkan modal
    document.querySelectorAll('.auth-required').forEach(element => {
        element.addEventListener('click', function (e) {
            e.preventDefault();
            if (mobileMenu) {
                mobileMenu.classList.remove('show');
            }
            if (mobileToggle) {
                mobileToggle.classList.remove('active');
            }
            showAuthModal();
        });
    });

    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Tutup mobile menu saat klik nav item
    document.querySelectorAll('.mobile-nav-item').forEach(item => {
        item.addEventListener('click', function () {
            if (!this.classList.contains('auth-required')) {
                if (mobileMenu) {
                    mobileMenu.classList.remove('show');
                }
                if (mobileToggle) {
                    mobileToggle.classList.remove('active');
                }
            }
        });
    });

    // Observer untuk animasi scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.feature-card, .disease-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s ease';
        observer.observe(card);
    });

    // Parallax hero
    window.addEventListener('scroll', function () {
        const scrolled = window.pageYOffset;
        const parallax = document.querySelector('.hero');
        if (parallax && scrolled < window.innerHeight) {
            const speed = scrolled * 0.2;
            parallax.style.transform = `translateY(${speed}px)`;
        }
    });

    // Efek ketik judul hero
    function typeWriter(element, text, speed = 100) {
        let i = 0;
        element.innerHTML = '';
        function type() {
            if (i < text.length) {
                element.innerHTML += text.charAt(i);
                i++;
                setTimeout(type, speed);
            }
        }
        type();
    }

    window.addEventListener('load', function () {
        const heroTitle = document.querySelector('.hero-title');
        const originalText = heroTitle.textContent;
        setTimeout(() => {
            typeWriter(heroTitle, originalText, 80);
        }, 500);
    });

    // Resize = reset padding dan tutup menu mobile
    window.addEventListener('resize', function () {
        setBodyPadding();
        if (window.innerWidth > 768) {
            if (mobileMenu) {
                mobileMenu.classList.remove('show');
            }
            if (mobileToggle) {
                mobileToggle.classList.remove('active');
            }
        }
    });
});