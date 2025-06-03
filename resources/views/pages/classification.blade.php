@extends('layouts.app')

@section('content')
<link href="{{ asset('css/classification.css') }}" rel="stylesheet">

<div class="classification-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="classification-card">
                    <div class="card-header">
                        <h2><i class="fas fa-leaf"></i> Klasifikasi Penyakit Daun Tomat</h2>
                    </div>
                    
                    <div class="upload-container">
                        <div class="upload-area" id="dropArea">
                            <div class="upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <div class="upload-text" id="uploadText">
                                Seret & lepas gambar daun tomat di sini atau klik untuk memilih file
                            </div>
                            <input type="file" id="fileInput" class="file-input" accept="image/*">
                            <div class="file-info" id="fileInfo">
    <div class="file-preview-container">
        <img src="" class="file-preview" id="filePreview">
    </div>
    <div>
        <strong>Nama File:</strong> <span id="fileName"></span><br>
        <strong>Ukuran:</strong> <span id="fileSize"></span><br>
        <strong>Tipe:</strong> <span id="fileType"></span>
    </div>
</div>
                        </div>
                        
                        <div class="text-center">
                            <button id="classifyBtn" class="classify-btn" disabled>
                                <i class="fas fa-search mr-2"></i> Klasifikasi Sekarang
                            </button>
                        </div>
                        
                        <div class="loading-spinner" id="loadingSpinner">
                            <div class="spinner"></div>
                            <p>Memproses gambar...</p>
                        </div>
                        
                        <div class="error-message" id="errorMessage"></div>
                        
                        <div class="result-container" id="resultContainer">
                            <div class="result-card">
                                <div class="result-header">
                                    <i class="fas fa-clipboard-check mr-2"></i> Hasil Klasifikasi
                                </div>
                                <div class="result-body" id="resultBody">
                                    <!-- Results will be inserted here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropArea = document.getElementById('dropArea');
    const fileInput = document.getElementById('fileInput');
    const uploadText = document.getElementById('uploadText');
    const fileInfo = document.getElementById('fileInfo');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const fileType = document.getElementById('fileType');
    const classifyBtn = document.getElementById('classifyBtn');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const resultContainer = document.getElementById('resultContainer');
    const resultBody = document.getElementById('resultBody');
    const errorMessage = document.getElementById('errorMessage');

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // Highlight drop area when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });

    function highlight() {
        dropArea.classList.add('active');
    }

    function unhighlight() {
        dropArea.classList.remove('active');
    }

    // Handle dropped files
    dropArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }

    // Handle click to select files
    dropArea.addEventListener('click', () => {
        fileInput.click();
    });

    // Handle file selection
    fileInput.addEventListener('change', function() {
        handleFiles(this.files);
    });

    function handleFiles(files) {
        if (files.length === 0) return;
        
        const file = files[0];
        
        // Validate file type
        if (!file.type.match('image.*')) {
            showError('File harus berupa gambar (JPG, PNG, GIF)');
            return;
        }
        
        // Validate file size (16MB max)
        if (file.size > 16 * 1024 * 1024) {
            showError('Ukuran file terlalu besar. Maksimal 16MB.');
            return;
        }
        
        // Clear any previous errors
        hideError();
        
        // Display file info
        uploadText.style.display = 'none';
        fileInfo.classList.add('active');
        
        // Display file name and info
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        fileType.textContent = file.type;
        
        // Display preview
        const reader = new FileReader();
        reader.onload = function(e) {
            filePreview.src = e.target.result;
        };
        reader.readAsDataURL(file);
        
        // Enable classify button
        classifyBtn.disabled = false;
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function showError(message) {
        errorMessage.textContent = message;
        errorMessage.classList.add('active');
        classifyBtn.disabled = true;
        fileInfo.classList.remove('active');
        uploadText.style.display = 'block';
    }

    function hideError() {
        errorMessage.classList.remove('active');
    }

    // Handle classification
    classifyBtn.addEventListener('click', async function() {
        if (fileInput.files.length === 0) {
            showError('Silakan pilih gambar terlebih dahulu');
            return;
        }
        
        const file = fileInput.files[0];
        const formData = new FormData();
        formData.append('image', file);
        
        // Show loading spinner
        loadingSpinner.classList.add('active');
        classifyBtn.disabled = true;
        resultContainer.classList.remove('active');
        
        try {
            const response = await fetch('http://localhost:5000/predict', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                displayResults(data.data);
            } else {
                showError(data.error || 'Terjadi kesalahan saat memproses gambar');
            }
        } catch (error) {
            console.error('Error:', error);
            showError('Gagal terhubung ke server. Pastikan API berjalan.');
        } finally {
            loadingSpinner.classList.remove('active');
            classifyBtn.disabled = false;
        }
    });

    function displayResults(result) {
        // Clear previous results
        resultBody.innerHTML = '';
        
        // Create result HTML
        const resultHTML = `
            <div class="result-row">
                <div class="result-label">Kelas Penyakit:</div>
                <div class="result-value">
                    <strong>${result.classification.class_name}</strong>
                    <span class="badge ${result.classification.is_healthy ? 'severity-none' : 'severity-high'} ml-2">
                        ${result.classification.is_healthy ? 'Sehat' : 'Sakit'}
                    </span>
                </div>
            </div>
            
            <div class="result-row">
                <div class="result-label">Tingkat Kepercayaan:</div>
                <div class="result-value">
                    ${result.classification.confidence_percentage}%
                    <div class="confidence-meter">
                        <div class="confidence-level" style="width: ${result.classification.confidence_percentage}%"></div>
                    </div>
                </div>
            </div>
            
            <div class="result-row">
                <div class="result-label">Tingkat Keparahan:</div>
                <div class="result-value">
                    <span class="severity-badge ${getSeverityClass(result.disease_info.severity)}">
                        ${result.disease_info.severity}
                    </span>
                </div>
            </div>
            
            <hr>
            
            <div class="result-row">
                <div class="result-label">Gejala:</div>
                <div class="result-value">${result.disease_info.symptoms}</div>
            </div>
            
            <div class="result-row">
                <div class="result-label">Penyebab:</div>
                <div class="result-value">${result.disease_info.causes}</div>
            </div>
            
            <hr>
            
            <div class="result-row">
                <div class="result-label">Pencegahan:</div>
                <div class="result-value">${result.disease_info.prevention}</div>
            </div>
            
            <div class="result-row">
                <div class="result-label">Pengobatan:</div>
                <div class="result-value">${result.disease_info.treatment}</div>
            </div>
        `;
        
        resultBody.innerHTML = resultHTML;
        resultContainer.classList.add('active');
    }

    function getSeverityClass(severity) {
        switch(severity.toLowerCase()) {
            case 'high': return 'severity-high';
            case 'medium': return 'severity-medium';
            case 'low': return 'severity-low';
            case 'none': return 'severity-none';
            default: return '';
        }
    }
});
</script>

@endsection