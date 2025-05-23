@extends('layouts.app')

@section('title', 'Panduan - LeafGuard Tomato')

@section('content')
<div id="panduan" class="page active">
    <div class="page-title">
        <h1>PANDUAN</h1>
        <div class="title-underline"></div>
    </div>
    
    <div class="guide-content">
        <div class="guide-section">
            <h2>Cara Menggunakan LeafGuard Tomato</h2>
            <div class="guide-steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Persiapan Foto</h3>
                        <p>Ambil foto daun tomat dengan pencahayaan yang cukup dan jarak yang optimal. Pastikan daun terlihat jelas tanpa bayangan.</p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Upload Gambar</h3>
                        <p>Klik tombol upload atau drag & drop gambar ke area yang tersedia di halaman klasifikasi.</p>
                    </div>
                </div>
                <!-- Langkah-langkah lainnya -->
            </div>
        </div>
        
        <div class="guide-section">
            <h2>Tips Pengambilan Foto</h2>
            <ul class="tips-list">
                <li>Gunakan pencahayaan alami atau cahaya yang cukup terang</li>
                <li>Ambil foto dari jarak 15-20 cm dari daun</li>
                <li>Pastikan fokus pada daun yang ingin dianalisis</li>
                <!-- Tips lainnya -->
            </ul>
        </div>
    </div>
</div>
@endsection