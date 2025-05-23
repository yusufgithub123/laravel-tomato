// Global state
let currentSlide = 0;

// Initialize the app
document.addEventListener('DOMContentLoaded', function() {
    initNavigation();
    initSlider();
    initHamburgerMenu();
    addInteractiveAnimations();
});

// Hamburger Menu Functionality
function initHamburgerMenu() {
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const navContainer = document.querySelector('.nav-container');
    const overlay = document.createElement('div');
    overlay.className = 'nav-overlay';
    document.body.appendChild(overlay);
    
    if (hamburgerBtn) {
        hamburgerBtn.addEventListener('click', function() {
            this.classList.toggle('active');
            navContainer.classList.toggle('active');
            overlay.classList.toggle('active');
            document.body.style.overflow = navContainer.classList.contains('active') ? 'hidden' : '';
        });
    }
    
    overlay.addEventListener('click', function() {
        hamburgerBtn.classList.remove('active');
        navContainer.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    });
    
    const navPills = document.querySelectorAll('.nav-pill');
    navPills.forEach(pill => {
        pill.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                hamburgerBtn.classList.remove('active');
                navContainer.classList.remove('active');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });
    
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            if (hamburgerBtn) hamburgerBtn.classList.remove('active');
            if (navContainer) navContainer.classList.remove('active');
            if (overlay) overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
}

// Navigation functionality
function initNavigation() {
    const navPills = document.querySelectorAll('.nav-pill');
    navPills.forEach(pill => {
        pill.addEventListener('click', function() {
            navPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
        });
    });
}

// Slider functionality
function initSlider() {
    const slides = document.querySelectorAll('.slide');
    const prevBtn = document.querySelector('.slider-nav.prev');
    const nextBtn = document.querySelector('.slider-nav.next');
    
    if (slides.length === 0) return;
    
    setInterval(nextSlide, 5000);
    
    if (prevBtn) prevBtn.addEventListener('click', prevSlide);
    if (nextBtn) nextBtn.addEventListener('click', nextSlide);
    
    const swipeButtons = document.querySelectorAll('.swipe-btn');
    swipeButtons.forEach(btn => {
        btn.addEventListener('click', nextSlide);
    });
}

function showSlide(index) {
    const slides = document.querySelectorAll('.slide');
    slides.forEach(slide => slide.classList.remove('active'));
    if (slides[index]) slides[index].classList.add('active');
}

function nextSlide() {
    const slides = document.querySelectorAll('.slide');
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
}

function prevSlide() {
    const slides = document.querySelectorAll('.slide');
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    showSlide(currentSlide);
}

// Add interactive animations
function addInteractiveAnimations() {
    const cards = document.querySelectorAll('.disease-card, .team-member, .history-item');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
}

// Auth buttons functionality
document.addEventListener('DOMContentLoaded', function() {
    const btnMasuk = document.querySelector('.btn-masuk');
    const btnDaftar = document.querySelector('.btn-daftar');
    
    if (btnMasuk) {
        btnMasuk.addEventListener('click', function() {
            window.location.href = "{{ route('login') }}";
        });
    }
    
    if (btnDaftar) {
        btnDaftar.addEventListener('click', function() {
            window.location.href = "{{ route('register') }}";
        });
    }
});