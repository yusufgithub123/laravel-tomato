{{-- about.blade.php --}}
@extends('layouts.app')

@section('title', 'Tentang - LeafGuard Tomato')

@section('content')
<div id="tentang" class="page active">
    <div class="page-title">
        <h1>TENTANG</h1>
        <div class="title-underline"></div>
    </div>
    
    <div class="about-content">
        <!-- Main About Section -->
        <div class="about-card main-about">
            <div class="card-icon">
                <i class="fas fa-leaf"></i>
            </div>
            <h2>Tentang LeafGuard Tomato</h2>
            <p>LEAFGUARD-TOMATO adalah sistem klasifikasi otomatis berbasis deep learning yang dirancang khusus untuk membantu petani Indonesia mengidentifikasi penyakit pada daun tomat secara cepat, akurat, dan mudah diakses.</p>
            <p>Sistem ini menggunakan teknologi Convolutional Neural Network (CNN) dengan framework TensorFlow untuk mengenali berbagai jenis penyakit umum pada daun tomat seperti early blight (Alternaria solani), late blight (Phytophthora infestans), dan leaf mold (Fulvia fulva).</p>
            <p>Melalui aplikasi web responsif yang dibangun dengan Laravel dan Vue.js, petani dapat mengunggah foto daun tomat menggunakan perangkat mobile mereka dan mendapatkan diagnosis serta rekomendasi penanganan dalam hitungan detik.</p>
        </div>

        <!-- Vision & Mission Cards -->
        <div class="vision-mission-grid">
            <div class="about-card vision-card">
                <div class="card-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <h3>Visi Kami</h3>
                <p>Menjadi solusi teknologi terdepan dalam bidang pertanian digital yang membantu meningkatkan produktivitas dan kualitas hasil panen tomat di Indonesia melalui sistem deteksi penyakit berbasis kecerdasan buatan yang mudah diakses oleh seluruh lapisan petani.</p>
            </div>
            
            <div class="about-card mission-card">
                <div class="card-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3>Misi Kami</h3>
                <div class="mission-list">
                    <div class="mission-item">
                        <i class="fas fa-robot"></i>
                        <span>Menyediakan teknologi AI yang mudah diakses untuk petani</span>
                    </div>
                    <div class="mission-item">
                        <i class="fas fa-chart-line"></i>
                        <span>Meningkatkan efisiensi deteksi penyakit tanaman</span>
                    </div>
                    <div class="mission-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Membantu mengurangi kerugian hasil panen akibat penyakit</span>
                    </div>
                    <div class="mission-item">
                        <i class="fas fa-seedling"></i>
                        <span>Mendukung pertanian berkelanjutan di Indonesia</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="about-card stats-card">
            <div class="card-icon">
                <i class="fas fa-chart-bar"></i>
            </div>
            <h3>Dampak & Statistik</h3>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">40-60%</div>
                    <div class="stat-label">Kerugian Panen yang Dapat Dicegah</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">3</div>
                    <div class="stat-label">Jenis Penyakit Terdeteksi</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">< 5 detik</div>
                    <div class="stat-label">Waktu Diagnosis</div>
                </div>
            </div>
        </div>
        
        <!-- Team Section -->
        <div class="about-card team-section">
            <div class="card-icon">
                <i class="fas fa-users"></i>
            </div>
            <h2>Tim Pengembang</h2>
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4>Muhammad Ihsan</h4>
                    <p>Front-End Developer</p>
                    <div class="member-role-badge frontend">Frontend</div>
                </div>
                <div class="team-member">
                    <div class="member-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4>Yusuf Alfarabi Natawiyanta</h4>
                    <p>Back-End Developer</p>
                    <div class="member-role-badge backend">Backend</div>
                </div>
                <div class="team-member">
                    <div class="member-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4>Anwar</h4>
                    <p>Full Stack Developer</p>
                    <div class="member-role-badge fullstack">Full Stack</div>
                </div>
                <div class="team-member">
                    <div class="member-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4>Christofel A Simbolon</h4>
                    <p>Machine Learning</p>
                    <div class="member-role-badge ml">ML Engineer</div>
                </div>
                <div class="team-member">
                    <div class="member-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4>Henry Dwi Prana Sitepu</h4>
                    <p>Machine Learning</p>
                    <div class="member-role-badge ml">ML Engineer</div>
                </div>
                <div class="team-member">
                    <div class="member-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4>Andika Syarif Hidayatullah</h4>
                    <p>Machine Learning</p>
                    <div class="member-role-badge ml">ML Engineer</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection