<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeafGuard Tomato - Sistem Deteksi Penyakit Tanaman Tomat</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
</head>
<body>
    <!-- Header -->
    <header class="header" id="header">
        <div class="container">
            <a href="#" class="logo">
                <i class="fas fa-leaf"></i>
                <span>LEAFGUARD TOMATO</span>
            </a>
            
            <nav class="nav-menu" id="navMenu">
                <div class="nav-item">
                    <a href="#" class="nav-link active">BERANDA</a>
                </div>
                <div class="nav-item">
                    <a href="#" class="nav-link" id="klasifikasiLink">KLASIFIKASI</a>
                </div>
            </nav>
            
            <div class="auth-buttons">
                <a href="/login" class="btn-login">LOGIN</a>
                <a href="/register" class="btn-register">REGISTER</a>
            </div>
            
            <div class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
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
                    <a href="#" class="btn-primary" id="mulaiKlasifikasi">
                        <i class="fas fa-camera" style="margin-right: 8px;"></i>
                        MULAI DETEKSI
                    </a>
                    <a href="#features" class="btn-secondary">
                        <i class="fas fa-info-circle" style="margin-right: 8px;"></i>
                        PELAJARI LEBIH LANJUT
                    </a>
                </div>
            </div>
            
            <div class="hero-visual">
                <div class="hero-image">
                    <div class="floating-elements">
                        <div class="floating-element">🍅</div>
                        <div class="floating-element">🌱</div>
                        <div class="floating-element">🔬</div>
                    </div>
                    <i class="fas fa-seedling plant-icon"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
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

    <!-- Disease Types Section -->
    <section class="diseases">
        <div class="diseases-container">
            <h2 class="section-title">Jenis Penyakit yang Dapat Dideteksi</h2>
            <p class="section-subtitle">Sistem kami dapat mendeteksi berbagai jenis penyakit daun tomat yang umum ditemukan</p>
            
            <div class="diseases-grid">
                <div class="disease-card">
                    <div class="disease-icon">
                        <i class="fas fa-bug"></i>
                    </div>
                    <h3 class="disease-title">Early Blight</h3>
                    <p class="disease-description">
                        Penyakit bercak daun yang disebabkan oleh jamur Alternaria solani, ditandai dengan bercak coklat dengan lingkaran konsentris.
                    </p>
                </div>
                
                <div class="disease-card">
                    <div class="disease-icon">
                        <i class="fas fa-microscope"></i>
                    </div>
                    <h3 class="disease-title">Late Blight</h3>
                    <p class="disease-description">
                        Penyakit busuk daun yang disebabkan Phytophthora infestans, menyebabkan bercak gelap yang cepat menyebar.
                    </p>
                </div>
                
                <div class="disease-card">
                    <div class="disease-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <h3 class="disease-title">Leaf Mold</h3>
                    <p class="disease-description">
                        Jamur yang menyerang daun tomat, menyebabkan bercak kuning pada permukaan atas dan lapisan jamur di bawah daun.
                    </p>
                </div>
                
                <div class="disease-card">
                    <div class="disease-icon">
                        <i class="fas fa-circle"></i>
                    </div>
                    <h3 class="disease-title">Septoria Leaf Spot</h3>
                    <p class="disease-description">
                        Penyakit bercak daun yang ditandai dengan bercak kecil bulat berwarna coklat dengan pusat abu-abu.
                    </p>
                </div>
                
                <div class="disease-card">
                    <div class="disease-icon">
                        <i class="fas fa-spider"></i>
                    </div>
                    <h3 class="disease-title">Spider Mites</h3>
                    <p class="disease-description">
                        Serangan tungau laba-laba yang menyebabkan bercak kuning kecil dan jaring halus pada daun tomat.
                    </p>
                </div>
                
                <div class="disease-card">
                    <div class="disease-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 class="disease-title">Healthy</h3>
                    <p class="disease-description">
                        Daun tomat yang sehat tanpa tanda-tanda penyakit, berwarna hijau segar dengan struktur normal.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Auth Required Modal -->
    <div class="auth-modal" id="authModal">
        <div class="modal-content">
            <div class="modal-icon">
                <i class="fas fa-lock"></i>
            </div>
            <h3 class="modal-title">Login Diperlukan</h3>
            <p class="modal-text">
                Untuk menggunakan fitur deteksi penyakit tanaman, Anda perlu login terlebih dahulu. 
                Silakan login atau daftar jika belum memiliki akun.
            </p>
            <div class="modal-buttons">
                <a href="/login" class="modal-btn primary">
                    <i class="fas fa-sign-in-alt" style="margin-right: 5px;"></i>
                    LOGIN
                </a>
                <button class="modal-btn secondary" onclick="closeAuthModal()">
                    BATAL
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-content">
            <div class="mobile-menu-header">
                <div class="mobile-logo">
                    <i class="fas fa-leaf"></i>
                    <span>LEAFGUARD TOMATO</span>
                </div>
                <button class="close-mobile-menu" id="closeMobileMenu">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="mobile-nav">
                <a href="#" class="mobile-nav-link active">BERANDA</a>
                <a href="#" class="mobile-nav-link" id="mobileKlasifikasiLink">KLASIFIKASI</a>
                <div class="mobile-auth-buttons">
                    <a href="/login" class="mobile-btn-login">LOGIN</a>
                    <a href="/register" class="mobile-btn-register">REGISTER</a>
                </div>
            </nav>
        </div>
    </div>

    <style>/* Reset and Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: #333;
    background-color: #f8fffe;
    overflow-x: hidden;
}

/* Container */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Header Styles */
.header {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    box-shadow: 0 2px 20px rgba(0,0,0,0.1);
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    transition: all 0.3s ease;
}

.header.scrolled {
    background: rgba(255, 255, 255, 0.98);
    box-shadow: 0 4px 30px rgba(0,0,0,0.15);
}

.header .container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 70px;
}

.logo {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #2d5a2d;
    font-size: 24px;
    font-weight: bold;
    text-decoration: none;
    transition: all 0.3s ease;
}

.logo:hover {
    transform: scale(1.05);
}

.logo i {
    font-size: 28px;
    color: #4CAF50;
}

.nav-menu {
    display: flex;
    list-style: none;
    gap: 30px;
    align-items: center;
}

.nav-item {
    position: relative;
}

.nav-link {
    text-decoration: none;
    color: #2d5a2d;
    font-weight: 600;
    font-size: 16px;
    padding: 10px 15px;
    border-radius: 25px;
    transition: all 0.3s ease;
    position: relative;
}

.nav-link:hover {
    color: #4CAF50;
    transform: translateY(-2px);
}

.nav-link.active {
    color: #4CAF50;
    background: rgba(76, 175, 80, 0.1);
}

.auth-buttons {
    display: flex;
    gap: 15px;
}

.btn-login, .btn-register {
    padding: 12px 25px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: bold;
    transition: all 0.3s ease;
    border: 2px solid #4CAF50;
}

.btn-login {
    color: #4CAF50;
    background: transparent;
}

.btn-login:hover {
    background: #4CAF50;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
}

.btn-register {
    background: #4CAF50;
    color: white;
}

.btn-register:hover {
    background: #45a049;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(76, 175, 80, 0.4);
}

/* Mobile Menu */
.hamburger {
    display: none;
    flex-direction: column;
    cursor: pointer;
    padding: 5px;
}

.hamburger span {
    width: 25px;
    height: 3px;
    background: #2d5a2d;
    margin: 3px 0;
    transition: 0.3s;
    border-radius: 2px;
}

.hamburger.active span:nth-child(1) {
    transform: rotate(-45deg) translate(-5px, 6px);
}

.hamburger.active span:nth-child(2) {
    opacity: 0;
}

.hamburger.active span:nth-child(3) {
    transform: rotate(45deg) translate(-5px, -6px);
}

.mobile-menu {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 2000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.mobile-menu.show {
    display: flex;
    opacity: 1;
    visibility: visible;
}

.mobile-menu-content {
    background: white;
    width: 280px;
    height: 100%;
    transform: translateX(-100%);
    transition: transform 0.3s ease;
    box-shadow: 5px 0 15px rgba(0,0,0,0.1);
}

.mobile-menu.show .mobile-menu-content {
    transform: translateX(0);
}

.mobile-menu-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #eee;
}

.mobile-logo {
    display: flex;
    align-items: center;
    gap: 10px;
    color: #2d5a2d;
    font-size: 18px;
    font-weight: bold;
}

.mobile-logo i {
    color: #4CAF50;
}

.close-mobile-menu {
    background: none;
    border: none;
    font-size: 20px;
    color: #666;
    cursor: pointer;
    padding: 5px;
}

.mobile-nav {
    padding: 20px;
}

.mobile-nav-link {
    display: block;
    padding: 15px 0;
    text-decoration: none;
    color: #2d5a2d;
    font-weight: 600;
    border-bottom: 1px solid #eee;
    transition: color 0.3s ease;
}

.mobile-nav-link:hover,
.mobile-nav-link.active {
    color: #4CAF50;
}

.mobile-auth-buttons {
    margin-top: 30px;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.mobile-btn-login,
.mobile-btn-register {
    padding: 12px 20px;
    text-align: center;
    text-decoration: none;
    border-radius: 25px;
    font-weight: bold;
    transition: all 0.3s ease;
}

.mobile-btn-login {
    color: #4CAF50;
    border: 2px solid #4CAF50;
    background: transparent;
}

.mobile-btn-register {
    background: #4CAF50;
    color: white;
    border: 2px solid #4CAF50;
}

/* Hero Section */
.hero {
    background: linear-gradient(135deg, #a8e6a3 0%, #88d682 25%, #7dd87a 50%, #6bb66e 75%, #5a9c5a 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
    padding-top: 70px;
}

.hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="80" cy="80" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="40" cy="60" r="1" fill="%23ffffff" opacity="0.1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grain)"/></svg>') repeat;
    opacity: 0.3;
}

.hero-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
    position: relative;
    z-index: 2;
}

.hero-content {
    animation: slideInLeft 1s ease-out;
}

.hero-title {
    font-size: 3.5em;
    font-weight: 800;
    color: #2d5a2d;
    margin-bottom: 20px;
    line-height: 1.2;
}

.hero-subtitle {
    font-size: 1.3em;
    color: #2d5a2d;
    margin-bottom: 30px;
    opacity: 0.9;
    font-weight: 600;
}

.hero-description {
    font-size: 1.1em;
    color: #2d5a2d;
    margin-bottom: 40px;
    opacity: 0.8;
    line-height: 1.6;
}

.hero-buttons {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.btn-primary, .btn-secondary {
    padding: 16px 32px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: bold;
    font-size: 1.1em;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-primary {
    background: linear-gradient(135deg, #4CAF50, #66BB6A);
    color: white;
    box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
}

.btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(76, 175, 80, 0.4);
}

.btn-secondary {
    background: transparent;
    color: #2d5a2d;
    border: 2px solid #2d5a2d;
}

.btn-secondary:hover {
    background: #2d5a2d;
    color: white;
    transform: translateY(-3px);
}

/* Hero Visual */
.hero-visual {
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    animation: slideInRight 1s ease-out;
}

.hero-image {
    width: 100%;
    max-width: 500px;
    height: 400px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    position: relative;
    overflow: hidden;
}

.hero-image::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(255,255,255,0.1), transparent);
}

.plant-icon {
    font-size: 120px;
    color: #2d5a2d;
    animation: plantGrow 2s ease-in-out infinite;
    position: relative;
    z-index: 2;
}

.floating-elements {
    position: absolute;
    width: 100%;
    height: 100%;
}

.floating-element {
    position: absolute;
    font-size: 30px;
    animation: float 3s ease-in-out infinite;
}

.floating-element:nth-child(1) {
    top: 20%;
    left: 10%;
    animation-delay: 0s;
}

.floating-element:nth-child(2) {
    top: 70%;
    right: 15%;
    font-size: 25px;
    animation-delay: 1s;
}

.floating-element:nth-child(3) {
    bottom: 30%;
    left: 20%;
    font-size: 35px;
    animation-delay: 2s;
}

/* Features Section */
.features {
    padding: 100px 0;
    background: #f8fffe;
    position: relative;
}

.features-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.section-title {
    font-size: 2.5em;
    font-weight: 700;
    color: #2d5a2d;
    text-align: center;
    margin-bottom: 20px;
}

.section-subtitle {
    font-size: 1.2em;
    color: #666;
    text-align: center;
    margin-bottom: 60px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.6;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 40px;
    margin-top: 60px;
}

.feature-card {
    background: white;
    padding: 40px 30px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    text-align: center;
    transition: all 0.3s ease;
    border: 1px solid rgba(76, 175, 80, 0.1);
    position: relative;
    overflow: hidden;
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #4CAF50, #66BB6A);
}

.feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(76, 175, 80, 0.2);
}

.feature-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #4CAF50, #66BB6A);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    box-shadow: 0 10px 20px rgba(76, 175, 80, 0.3);
}

.feature-icon i {
    font-size: 35px;
    color: white;
}

.feature-title {
    font-size: 1.4em;
    font-weight: 600;
    color: #2d5a2d;
    margin-bottom: 15px;
}

.feature-description {
    color: #666;
    line-height: 1.6;
    font-size: 1em;
}

/* Disease Types Section */
.diseases {
    padding: 100px 0;
    background: linear-gradient(135deg, #f0f9f0 0%, #e8f5e8 100%);
}

.diseases-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.diseases-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 60px;
}

.disease-card {
    background: white;
    padding: 30px 25px;
    border-radius: 15px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    text-align: center;
    transition: all 0.3s ease;
    border: 1px solid rgba(76, 175, 80, 0.1);
    position: relative;
}

.disease-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(76, 175, 80, 0.15);
}

.disease-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #4CAF50, #66BB6A);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    box-shadow: 0 8px 16px rgba(76, 175, 80, 0.3);
}

.disease-icon i {
    font-size: 30px;
    color: white;
}

.disease-title {
    font-size: 1.3em;
    font-weight: 600;
    color: #2d5a2d;
    margin-bottom: 12px;
}

.disease-description {
    color: #666;
    line-height: 1.5;
    font-size: 0.95em;
}

/* Auth Modal */
.auth-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    z-index: 3000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.auth-modal.show {
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 1;
    visibility: visible;
}

.modal-content {
    background: white;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    text-align: center;
    max-width: 400px;
    width: 90%;
    margin: 20px;
    transform: scale(0.8);
    transition: transform 0.3s ease;
}

.auth-modal.show .modal-content {
    transform: scale(1);
}

.modal-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #4CAF50, #66BB6A);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    box-shadow: 0 10px 20px rgba(76, 175, 80, 0.3);
}

.modal-icon i {
    font-size: 35px;
    color: white;
}

.modal-title {
    font-size: 1.5em;
    font-weight: 600;
    color: #2d5a2d;
    margin-bottom: 15px;
}

.modal-text {
    color: #666;
    line-height: 1.6;
    margin-bottom: 30px;
}

.modal-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.modal-btn {
    padding: 12px 25px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: bold;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 1em;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.modal-btn.primary {
    background: #4CAF50;
    color: white;
}

.modal-btn.primary:hover {
    background: #45a049;
    transform: translateY(-2px);
}

.modal-btn.secondary {
    background: transparent;
    color: #666;
    border: 2px solid #ddd;
}

.modal-btn.secondary:hover {
    background: #f5f5f5;
    color: #333;
}

/* Animations */
@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-20px);
    }
}

@keyframes plantGrow {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .hamburger {
        display: flex;
    }
    
    .nav-menu,
    .auth-buttons {
        display: none;
    }
    
    .hero-container {
        grid-template-columns: 1fr;
        gap: 40px;
        text-align: center;
    }
    
    .hero-title {
        font-size: 2.5em;
    }
    
    .hero-subtitle {
        font-size: 1.1em;
    }
    
    .hero-description {
        font-size: 1em;
    }
    
    .hero-buttons {
        justify-content: center;
    }
    
    .btn-primary,
    .btn-secondary {
        padding: 14px 28px;
        font-size: 1em;
    }
    
    .section-title {
        font-size: 2em;
    }
    
    .features-grid,
    .diseases-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .feature-card,
    .disease-card {
        padding: 30px 20px;
    }
    
    .modal-content {
        padding: 30px 20px;
    }
    
    .modal-buttons {
        flex-direction: column;
    }
    
    .modal-btn {
        width: 100%;
    }
}

@media (max-width: 480px) {
    .hero {
        padding-top: 70px;
        min-height: calc(100vh - 70px);
    }
    
    .hero-title {
        font-size: 2em;
    }
    
    .hero-image {
        height: 300px;
    }
    
    .plant-icon {
        font-size: 80px;
    }
    
    .floating-element {
        font-size: 20px;
    }
    
    .features,
    .diseases {
        padding: 60px 0;
    }
    
    .section-title {
        font-size: 1.8em;
    }
    
    .feature-icon,
    .disease-icon {
        width: 60px;
        height: 60px;
    }
    
    .feature-icon i,
    .disease-icon i {
        font-size: 25px;
    }
}</style>

    <script>
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Smooth scrolling for anchor links
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

        // Auth modal functions
        function showAuthModal() {
            const modal = document.getElementById('authModal');
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeAuthModal() {
            const modal = document.getElementById('authModal');
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.getElementById('authModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAuthModal();
            }
        });

        // Handle classification links
        document.getElementById('klasifikasiLink').addEventListener('click', function(e) {
            e.preventDefault();
            showAuthModal();
        });

        document.getElementById('mulaiKlasifikasi').addEventListener('click', function(e) {
            e.preventDefault();
            showAuthModal();
        });

        // Mobile menu functions
        function showMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        // Hamburger menu toggle
        document.getElementById('hamburger').addEventListener('click', function() {
            this.classList.toggle('active');
            showMobileMenu();
        });

        document.getElementById('closeMobileMenu').addEventListener('click', function() {
            closeMobileMenu();
            document.getElementById('hamburger').classList.remove('active');
        });

        // Mobile classification link
        document.getElementById('mobileKlasifikasiLink').addEventListener('click', function(e) {
            e.preventDefault();
            closeMobileMenu();
            showAuthModal();
        });

        // Close mobile menu when clicking outside
        document.getElementById('mobileMenu').addEventListener('click', function(e) {
            if (e.target === this) {
                closeMobileMenu();
            }
        });

        // Add intersection observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe cards for animation
        document.querySelectorAll('.feature-card, .disease-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'all 0.6s ease';
            observer.observe(card);
        });

        // Add parallax effect to hero background
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.hero');
            if (parallax && scrolled < window.innerHeight) {
                const speed = scrolled * 0.3;
                parallax.style.transform = `translateY(${speed}px)`;
            }
        });

        // Add typing effect to hero title
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

        // Initialize typing effect when page loads
        window.addEventListener('load', function() {
            const heroTitle = document.querySelector('.hero-title');
            const originalText = heroTitle.textContent;
            setTimeout(() => {
                typeWriter(heroTitle, originalText, 80);
            }, 500);
        });
    </script>
</body>
</html>