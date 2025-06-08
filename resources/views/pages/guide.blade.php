{{-- guide.blade.php --}}
@extends('layouts.app')

@section('title', 'Panduan - LeafGuard Tomato')

@section('content')
<div id="panduan" class="page active">
    <div class="page-title">
        <h1>PANDUAN</h1>
        <div class="title-underline"></div>
    </div>
    
    <div class="guide-content">
        <div class="guide-header">
            <h2>Cara Menggunakan LeafGuard Tomato</h2>
            <p class="guide-subtitle">Ikuti langkah-langkah mudah ini untuk mendapatkan hasil deteksi penyakit tanaman yang akurat</p>
        </div>
        
        <div class="guide-steps">
            <div class="step-card">
                <div class="step-icon">
                    <div class="step-number">1</div>
                </div>
                <div class="step-content">
                    <h3>Persiapan Foto</h3>
                    <p>Ambil foto daun tomat dengan pencahayaan yang cukup dan jarak yang optimal. Pastikan daun terlihat jelas tanpa bayangan.</p>
                </div>
            </div>
            
            <div class="step-card">
                <div class="step-icon">
                    <div class="step-number">2</div>
                </div>
                <div class="step-content">
                    <h3>Upload Gambar</h3>
                    <p>Klik tombol upload atau drag & drop gambar ke area yang tersedia di halaman klasifikasi.</p>
                </div>
            </div>
            
            <div class="step-card">
                <div class="step-icon">
                    <div class="step-number">3</div>
                </div>
                <div class="step-content">
                    <h3>Proses Klasifikasi</h3>
                    <p>Sistem akan menganalisis gambar menggunakan AI untuk mendeteksi jenis penyakit atau kondisi daun.</p>
                </div>
            </div>
            
            <div class="step-card">
                <div class="step-icon">
                    <div class="step-number">4</div>
                </div>
                <div class="step-content">
                    <h3>Lihat Hasil</h3>
                    <p>Dapatkan hasil klasifikasi beserta rekomendasi penanganan yang sesuai.</p>
                </div>
            </div>
        </div>
        
        <div class="tips-section">
            <div class="tips-header">
                <h2>Tips Pengambilan Foto</h2>
                <p class="tips-subtitle">Untuk hasil yang optimal, perhatikan hal-hal berikut saat mengambil foto</p>
            </div>
            
            <div class="tips-grid">
                <div class="tip-card">
                    <div class="tip-icon">💡</div>
                    <h4>Pencahayaan</h4>
                    <p>Gunakan pencahayaan alami atau cahaya yang cukup terang</p>
                </div>
                
                <div class="tip-card">
                    <div class="tip-icon">📏</div>
                    <h4>Jarak Optimal</h4>
                    <p>Ambil foto dari jarak 15-20 cm dari daun</p>
                </div>
                
                <div class="tip-card">
                    <div class="tip-icon">🎯</div>
                    <h4>Fokus</h4>
                    <p>Pastikan fokus pada daun yang ingin dianalisis</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
