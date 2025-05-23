@extends('layouts.app')

@section('title', 'Klasifikasi - LeafGuard Tomato')

@section('content')
<div id="klasifikasi" class="page active">
    <div class="page-title">
        <h1>KLASIFIKASI</h1>
        <div class="title-underline"></div>
    </div>
    
    <div class="classification-container">
        <div class="classification-tabs">
            <button class="tab-btn active" data-tab="upload">UPLOAD</button>
            <button class="tab-btn" data-tab="klasifikasi-tab">KLASIFIKASI</button>
            <button class="tab-btn" data-tab="hasil">HASIL</button>
        </div>
        
        <div class="upload-area">
            <div class="upload-box">
                <i class="fas fa-image"></i>
                <h3>DRAG & DROP</h3>
                <p>Atau masukkan file foto daun tomat</p>
                <button class="upload-btn" id="uploadBtn">UPLOAD</button>
                <input type="file" id="fileInput" accept="image/*" style="display: none;">
            </div>
        </div>
        
        <div class="feature-icons">
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <span>JARAK OPTIMAL</span>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-seedling"></i>
                </div>
                <span>PENCAHAYAAN</span>
            </div>
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-home"></i>
                </div>
                <span>SUDUT</span>
            </div>
        </div>
        
        <div class="warning-message">
            <i class="fas fa-exclamation-triangle"></i>
            <span>Pastikan daun terlihat jelas dan tidak tertutup bayangan</span>
            <i class="fas fa-exclamation-triangle"></i>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Script khusus untuk halaman klasifikasi
document.getElementById('uploadBtn').addEventListener('click', function() {
    document.getElementById('fileInput').click();
});

// Tambahkan event listeners untuk drag and drop
const uploadBox = document.querySelector('.upload-box');
uploadBox.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.style.background = 'rgba(76, 175, 80, 0.2)';
});

uploadBox.addEventListener('dragleave', function() {
    this.style.background = 'rgba(76, 175, 80, 0.05)';
});

uploadBox.addEventListener('drop', function(e) {
    e.preventDefault();
    this.style.background = 'rgba(76, 175, 80, 0.05)';
    
    if (e.dataTransfer.files.length) {
        document.getElementById('fileInput').files = e.dataTransfer.files;
        handleFileSelect(e);
    }
});

function handleFileSelect(event) {
    const file = event.target.files[0] || (event.dataTransfer && event.dataTransfer.files[0]);
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            uploadBox.innerHTML = `
                <img src="${e.target.result}" style="max-width: 300px; max-height: 200px; border-radius: 10px; margin-bottom: 15px;">
                <h3>File berhasil diupload!</h3>
                <p>${file.name}</p>
                <button class="upload-btn" onclick="classifyImage()">KLASIFIKASI</button>
            `;
        };
        reader.readAsDataURL(file);
    }
}

function classifyImage() {
    // Implementasi klasifikasi gambar
    const uploadBox = document.querySelector('.upload-box');
    uploadBox.innerHTML = `
        <div style="text-align: center;">
            <div class="spinner"></div>
            <h3>Sedang menganalisis...</h3>
            <p>Mohon tunggu sebentar</p>
        </div>
    `;
    
    // Simulasi proses klasifikasi
    setTimeout(() => {
        showClassificationResult();
    }, 3000);
}

function showClassificationResult() {
    // Hasil acak untuk demo
    const results = [
        { name: 'Early Blight', confidence: 95, status: 'Terinfeksi', color: '#f44336', icon: 'fa-exclamation' },
        { name: 'Daun Sehat', confidence: 98, status: 'Sehat', color: '#4CAF50', icon: 'fa-check' }
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
            <button class="upload-btn" onclick="resetUpload()">UPLOAD LAGI</button>
        </div>
    `;
}

function resetUpload() {
    const uploadBox = document.querySelector('.upload-box');
    uploadBox.innerHTML = `
        <i class="fas fa-image"></i>
        <h3>DRAG & DROP</h3>
        <p>Atau masukkan file foto daun tomat</p>
        <button class="upload-btn" id="uploadBtn">UPLOAD</button>
        <input type="file" id="fileInput" accept="image/*" style="display: none;">
    `;
    // Re-init event listeners
    document.getElementById('uploadBtn').addEventListener('click', function() {
        document.getElementById('fileInput').click();
    });
}
</script>
@endsection