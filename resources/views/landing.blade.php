<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeafGuard Tomato - Sistem Deteksi Penyakit Tanaman Tomat</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}"> {{-- Pastikan ini terhubung ke file CSS eksternal --}}
</head>
<body id="page-body"> {{-- Tambahkan id="page-body" di sini --}}
    <nav class="navbar" id="main-navbar"> {{-- Tambahkan id="main-navbar" di sini --}}
        <div class="navbar-container">
            <div class="navbar-brand">
                <i class="fas fa-leaf"></i>
                <span>LEAFGUARD TOMATO</span>
            </div>
            
            <div class="navbar-menu" id="navbarMenu">
                <a href="#" class="nav-item active">BERANDA</a>
                <a href="#" class="nav-item auth-required">KLASIFIKASI</a>
            </div>
            
            <div class="navbar-auth">
                <a href="/login" class="btn-login">LOGIN</a>
                <a href="/register" class="btn-register">REGISTER</a>
            </div>
            
            <button class="mobile-toggle" id="mobileToggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
        
        <div class="mobile-menu" id="mobileMenu">
            <a href="#" class="mobile-nav-item active">BERANDA</a>
            <a href="#" class="mobile-nav-item auth-required">KLASIFIKASI</a>
            <div class="mobile-auth-buttons">
                <a href="/login" class="mobile-btn-login">LOGIN</a>
                <a href="/register" class="mobile-btn-register">REGISTER</a>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <h1 class="hero-title">LEAFGUARD TOMATO</h1>
                <p class="hero-subtitle">Sistem Klasifikasi Otomatis Berbasis Deep Learning</p>
                <p class="hero-description">
                    LEAFGUARD-TOMATO adalah sistem klasifikasi otomatis berbasis deep learning yang dirancang 
                    khusus untuk membantu petani tomat di Indonesia dalam mengidentifikasi dan mengatasi 
                    penyakit daun tomat secara cepat, akurat, dan mudah.
                </p>
                <div class="hero-buttons">
                    <button class="btn-primary auth-required">
                        <i class="fas fa-camera"></i>
                        MULAI DETEKSI
                    </button>
                    <a href="#features" class="btn-secondary">
                        <i class="fas fa-info-circle"></i>
                        PELAJARI LEBIH LANJUT
                    </a>
                </div>
            </div>
            
            <div class="hero-visual">
                <div class="hero-image">
                    <img src="/assets/images/tomat.jpg" alt="Daun Tomat" class="tomato-image"> {{-- Pastikan jalur gambar benar --}}
                    <div class="floating-elements">
                        {{-- <i class="fas fa-seedling floating-element"></i>
                        <i class="fas fa-leaf floating-element"></i>
                        <i class="fas fa-cloud floating-element"></i> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features" id="features">
        <div class="features-container">
            <h2 class="section-title">Mengapa Memilih LeafGuard Tomato?</h2>
            <p class="section-subtitle">Teknologi Deep Learning terdepan untuk deteksi penyakit tanaman tomat yang akurat dan terpercaya</p>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3 class="feature-title">Deep Learning</h3>
                    <p class="feature-description">
                        Menggunakan teknologi Deep Learning terdepan untuk menganalisis gambar daun tomat dan mendeteksi berbagai jenis penyakit dengan akurasi tinggi.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="feature-title">Akurasi Tinggi</h3>
                    <p class="feature-description">
                        Sistem kami telah dilatih dengan ribuan gambar daun tomat dan mencapai tingkat akurasi tinggi dalam mendeteksi berbagai penyakit tanaman.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3 class="feature-title">Mudah Digunakan</h3>
                    <p class="feature-description">
                        Cukup ambil foto daun tomat dengan smartphone atau kamera, upload ke sistem, dan dapatkan hasil diagnosis dalam hitungan detik.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="feature-title">Hasil Instan</h3>
                    <p class="feature-description">
                        Dapatkan hasil deteksi penyakit dalam waktu singkat dengan rekomendasi penanganan yang tepat untuk setiap jenis penyakit.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <h3 class="feature-title">Riwayat Deteksi</h3>
                    <p class="feature-description">
                        Simpan dan akses riwayat deteksi Anda untuk monitoring kesehatan tanaman tomat secara berkelanjutan dan analisis pola penyakit.
                    </p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="feature-title">Untuk Petani Indonesia</h3>
                    <p class="feature-description">
                        Dirancang khusus untuk membantu petani tomat di Indonesia dengan interface yang mudah dipahami dan panduan dalam bahasa Indonesia.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="diseases">
        <div class="diseases-container">
            <h2 class="section-title">Jenis Penyakit yang Dapat Dideteksi</h2>
            <p class="section-subtitle">Sistem kami dapat mendeteksi berbagai jenis penyakit daun tomat yang umum ditemukan</p>
            
            <div class="diseases-grid">
                <div class="disease-card">
                    <div class="disease-icon">
                        <i class="fas fa-bug"></i>
                    </div>
                    <h3 class="disease-title">Bercak Daun</h3>
                    <p class="disease-description">
                        Penyakit bercak daun yang disebabkan oleh jamur Alternaria solani, ditandai dengan bercak coklat dengan lingkaran konsentris.
                    </p>
                </div>
                
                <div class="disease-card">
                    <div class="disease-icon">
                        <i class="fas fa-microscope"></i>
                    </div>
                    <h3 class="disease-title">Busuk Daun</h3>
                    <p class="disease-description">
                        Penyakit busuk daun yang disebabkan Phytophthora infestans, menyebabkan bercak gelap yang cepat menyebar.
                    </p>
                </div>
                
                <div class="disease-card">
                    <div class="disease-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3 class="disease-title">Jamur Daun</h3>
                    <p class="disease-description">
                        Jamur yang menyerang daun tomat, menyebabkan bercak kuning pada permukaan atas dan lapisan jamur di bawah daun.
                    </p>
                </div>
                
                <div class="disease-card">
                    <div class="disease-icon">
                        <i class="fas fa-circle"></i>
                    </div>
                    <h3 class="disease-title">Bercak Daun Septoria</h3>
                    <p class="disease-description">
                        Penyakit bercak daun yang ditandai dengan bercak kecil bulat berwarna coklat dengan pusat abu-abu.
                    </p>
                </div>
                
                <div class="disease-card">
                    <div class="disease-icon">
                        <i class="fas fa-spider"></i>
                    </div>
                    <h3 class="disease-title">Tungau Dua Bercak</h3>
                    <p class="disease-description">
                        Serangan tungau laba-laba yang menyebabkan bercak kuning kecil dan jaring halus pada daun tomat.
                    </p>
                </div>
                
                <div class="disease-card">
                    <div class="disease-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 class="disease-title">Sehat</h3>
                    <p class="disease-description">
                        Daun tomat yang sehat tanpa tanda-tanda penyakit, berwarna hijau segar dengan struktur normal.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <div class="auth-modal" id="authModal">
        <div class="modal-content">
            <div class="modal-icon">
                <i class="fas fa-lock"></i>
            </div>
            <h3 class="modal-title">Login Diperlukan</h3>
            <p class="modal-text">
                Untuk menggunakan fitur LeafGuard Tomato, Anda perlu login terlebih dahulu. 
                Silakan login atau daftar jika belum memiliki akun.
            </p>
            <div class="modal-buttons">
                <a href="/login" class="modal-btn primary">
                    <i class="fas fa-sign-in-alt"></i>
                    LOGIN
                </a>
                <button class="modal-btn secondary" onclick="closeAuthModal()">
                    BATAL
                </button>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/landing.js') }}"></script> {{-- Pastikan ini terhubung ke file JS eksternal --}}
</body>
</html>
