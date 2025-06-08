@extends('layouts.app')

@section('title', 'Beranda - LeafGuard Tomato')

@section('content')
    <div class="page-title">
        <h1>BERANDA</h1>
        <div class="title-underline"></div>
    </div>
    
    @include('components.slider')
    
    <!-- Classification Section -->
    <div class="classification-section">
        <div class="section-header">
            <h2>Mulai Klasifikasi Daun Tomat</h2>
            <p>Identifikasi penyakit daun tomat dengan teknologi AI yang akurat dan mudah digunakan</p>
        </div>
        
        <div class="feature-cards">
            <div class="feature-card">
                <div class="card-icon">
                    <i class="fas fa-camera"></i>
                </div>
                <h3>Upload Foto</h3>
                <p>Ambil atau upload foto daun tomat yang ingin diperiksa</p>
            </div>
            
            <div class="feature-card">
                <div class="card-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h3>Analisis AI</h3>
                <p>Sistem akan menganalisis foto menggunakan teknologi deep learning</p>
            </div>
            
            <div class="feature-card">
                <div class="card-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <h3>Hasil Diagnosis</h3>
                <p>Dapatkan hasil diagnosis penyakit beserta tingkat akurasi</p>
            </div>
        </div>
        
        <div class="cta-section">
            <div class="cta-content">
                <h3>Siap untuk memulai diagnosis?</h3>
                <p>Klik tombol di bawah untuk mulai mengklasifikasi penyakit daun tomat</p>
                <a href="{{ route('classification') }}" class="classification-btn">
                    <i class="fas fa-leaf"></i>
                    Mulai Klasifikasi
                </a>
            </div>
        </div>
    </div>
    
    <!-- Statistics Section -->
    <div class="stats-section">
        <div class="stats-container">
            <div class="stat-item">
                <div class="stat-number">95%</div>
                <div class="stat-label">Akurasi</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">10+</div>
                <div class="stat-label">Jenis Penyakit</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">1000+</div>
                <div class="stat-label">Pengguna</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">24/7</div>
                <div class="stat-label">Tersedia</div>
            </div>
        </div>
    </div>
@endsection