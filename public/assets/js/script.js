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

function showClassificationResult() {
    // Hasil acak untuk demo
    const results = [
        { 
            name: 'Early Blight', 
            confidence: 95, 
            status: 'Terinfeksi', 
            color: '#f44336', 
            icon: 'fa-exclamation',
            isHealthy: false,
            solution: 'Gunakan fungisida yang mengandung chlorothalonil atau copper-based. Hindari penyiraman dari atas tanaman.'
        },
        { 
            name: 'Daun Sehat', 
            confidence: 98, 
            status: 'Sehat', 
            color: '#4CAF50', 
            icon: 'fa-check',
            isHealthy: true,
            solution: null
        }
    ];
    const result = results[Math.floor(Math.random() * results.length)];
    
    const uploadBox = document.querySelector('.upload-box');
    uploadBox.innerHTML = `
        <div style="text-align: center;">
            <div style="width: 100px; height: 100px; background: ${result.color}; 
                border-radius: 50%; display: flex; align-items: center; 
                justify-content: center; margin: 0 auto 20px; color: white; font-size: 2em;">
                <i class="fas ${result.icon}"></i>
            </div>
            <h3 style="color: ${result.color};">${result.name}</h3>
            <p>Tingkat kepercayaan: ${result.confidence}%</p>
            <p style="margin: 20px 0;">Status: <strong style="color: ${result.color};">${result.status}</strong></p>
            ${result.solution ? `<p><strong>Solusi:</strong> ${result.solution}</p>` : ''}
            <button class="upload-btn" onclick="saveHistory()">SIMPAN RIWAYAT</button>
            <button class="upload-btn" onclick="resetUpload()" style="background: #f44336; margin-top: 10px;">UPLOAD LAGI</button>
        </div>
    `;
    
    // Simpan data hasil untuk disimpan ke riwayat
    uploadBox.dataset.result = JSON.stringify(result);
}

function saveHistory() {
    const uploadBox = document.querySelector('.upload-box');
    const result = JSON.parse(uploadBox.dataset.result);
    const fileInput = document.getElementById('fileInput');
    
    if (!fileInput.files.length) {
        alert('Tidak ada gambar yang diupload');
        return;
    }
    
    const formData = new FormData();
    formData.append('image', fileInput.files[0]);
    formData.append('disease_name', result.name);
    formData.append('accuracy', result.confidence);
    formData.append('is_healthy', result.isHealthy);
    if (result.solution) {
        formData.append('solution', result.solution);
    }
    
    fetch('/save-history', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Hasil klasifikasi berhasil disimpan ke riwayat');
            window.location.href = '/riwayat';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Gagal menyimpan riwayat');
    });
}