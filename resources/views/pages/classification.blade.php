@extends('layouts.app')

@section('content')
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

<div id="riwayat" class="page active">
    <div class="page-title">
        <h1>RIWAYAT</h1>
        <div class="title-underline"></div>
    </div>

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
                        
                        <!-- Validation Error Container -->
                        <div class="validation-error" id="validationError" style="display: none;">
                            <h4><i class="fas fa-exclamation-triangle"></i> Gambar Tidak Valid</h4>
                            <p id="validationMessage"></p>
                            <div id="validationReasons"></div>
                            <div class="validation-suggestion">
                                <strong>Saran:</strong>
                                <span id="validationSuggestion"></span>
                            </div>
                        </div>
                        
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
// Fixed JavaScript untuk classification.blade.php
// Ganti seluruh script tag dalam classification.blade.php dengan ini:

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
    const validationError = document.getElementById('validationError');
    const validationMessage = document.getElementById('validationMessage');
    const validationReasons = document.getElementById('validationReasons');
    const validationSuggestion = document.getElementById('validationSuggestion');

    let currentFile = null; // Store current file for saving to history

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
        currentFile = file; // Store current file
        
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
        
        // Clear any previous errors and validations
        hideError();
        hideValidationError();
        
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
        hideValidationError();
    }

    function hideError() {
        errorMessage.classList.remove('active');
    }

    function showValidationError(error, details) {
        hideError();
        
        validationMessage.textContent = error;
        
        // Show validation reasons if available
        if (details && details.reasons && details.reasons.length > 0) {
            const reasonsList = details.reasons.map(reason => `<li>${reason}</li>`).join('');
            validationReasons.innerHTML = `<strong>Alasan:</strong><ul>${reasonsList}</ul>`;
        } else if (details && details.reason) {
            validationReasons.innerHTML = `<strong>Alasan:</strong> ${details.reason}`;
        } else {
            validationReasons.innerHTML = '';
        }
        
        // Show suggestion
        if (details && details.suggestion) {
            validationSuggestion.textContent = details.suggestion;
        } else {
            validationSuggestion.textContent = 'Silakan upload gambar daun tomat yang jelas dengan latar belakang yang kontras';
        }
        
        validationError.style.display = 'block';
        validationError.classList.add('active');
        
        // Keep file info visible but disable classify button
        classifyBtn.disabled = true;
    }

    function hideValidationError() {
        validationError.style.display = 'none';
        validationError.classList.remove('active');
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
        hideError();
        hideValidationError();
        
        try {
            console.log('Sending request to Python API...');
            const response = await fetch('http://localhost:5000/predict', {
                method: 'POST',
                body: formData
            });
            
            console.log('Response received:', response.status);
            const data = await response.json();
            console.log('Response data:', data);
            
            if (data.success) {
                console.log('Classification successful, displaying results...');
                displayResults(data.data);
                
                // Save to history if user is logged in
                if (isUserLoggedIn()) {
                    console.log('User is logged in, saving to history...');
                    await saveToHistory(data.data, file);
                } else {
                    console.log('User not logged in, skipping history save');
                }
            } else {
                console.log('Classification failed:', data.error);
                // Check if it's a validation error (status 400)
                if (response.status === 400) {
                    showValidationError(data.error, data.details);
                } else {
                    showError(data.error || 'Terjadi kesalahan saat memproses gambar');
                }
            }
        } catch (error) {
            console.error('Fetch error:', error);
            showError('Gagal terhubung ke server. Pastikan API berjalan.');
        } finally {
            loadingSpinner.classList.remove('active');
            // Only re-enable button if no validation error
            if (!validationError.classList.contains('active')) {
                classifyBtn.disabled = false;
            }
        }
    });

    // FIXED: Save classification result to history
    async function saveToHistory(classificationData, imageFile) {
        try {
            console.log('Preparing to save to history...');
            console.log('Classification data:', classificationData);
            
            // Prepare FormData for Laravel endpoint
            const formData = new FormData();
            formData.append('image', imageFile);
            formData.append('disease_name', classificationData.disease_info?.name || 'Unknown Disease');
            formData.append('disease_class', classificationData.classification?.class || '');
            formData.append('accuracy', classificationData.classification?.confidence_percentage || 0);
            formData.append('is_healthy', classificationData.classification?.is_healthy ? '1' : '0');
            formData.append('symptoms', classificationData.disease_info?.symptoms || '');
            formData.append('causes', classificationData.disease_info?.causes || '');
            formData.append('prevention', classificationData.disease_info?.prevention || '');
            formData.append('treatment', classificationData.disease_info?.treatment || '');
            formData.append('severity', classificationData.disease_info?.severity || '');

            console.log('Sending to Laravel history endpoint...');
            
            // Send to Laravel history endpoint
            const response = await fetch('/history/store-classification', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });

            console.log('History save response status:', response.status);
            const result = await response.json();
            console.log('History save response:', result);
            
            if (result.success) {
                console.log('✅ History saved successfully');
                showNotification('Hasil klasifikasi berhasil disimpan ke riwayat!', 'success');
            } else {
                console.error('❌ Failed to save history:', result.message);
                showNotification('Gagal menyimpan ke riwayat: ' + (result.message || 'Unknown error'), 'error');
            }
            
        } catch (error) {
            console.error('❌ Error saving to history:', error);
            showNotification('Terjadi kesalahan saat menyimpan riwayat', 'error');
        }
    }

    function displayResults(result) {
        console.log('Displaying results:', result);
        
        // Hide any existing errors
        hideError();
        hideValidationError();
        
        // Get confidence color based on percentage
        const confidenceColor = getConfidenceColor(result.classification.confidence_percentage);
        
        // Create result HTML
        const resultHTML = `
            <div class="result-row">
                <div class="result-label">Status Validasi:</div>
                <div class="result-value">
                    <span class="success-checkmark"><i class="fas fa-check"></i></span>
                    Gambar tervalidasi sebagai daun tomat
                </div>
            </div>
            
            <div class="result-row">
                <div class="result-label">Kelas Penyakit:</div>
                <div class="result-value">
                    <strong>${result.classification.class_name || result.disease_info.name}</strong>
                    <span class="badge ${result.classification.is_healthy ? 'severity-none' : 'severity-tinggi'} ml-2">
                        ${result.classification.is_healthy ? 'Sehat' : 'Sakit'}
                    </span>
                </div>
            </div>
            
            <div class="result-row">
                <div class="result-label">Tingkat Kepercayaan:</div>
                <div class="result-value">
                    ${result.classification.confidence_percentage}%
                    <div class="confidence-meter">
                        <div class="confidence-level" style="width: ${result.classification.confidence_percentage}%; background: ${confidenceColor}"></div>
                    </div>
                </div>
            </div>
            
            <div class="result-row">
                <div class="result-label">Tingkat Keparahan:</div>
                <div class="result-value">
                    <span class="severity-badge ${getSeverityClass(result.disease_info.severity)}">
                        ${formatSeverity(result.disease_info.severity)}
                    </span>
                </div>
            </div>
            
            <hr>
            
            <div class="result-row">
                <div class="result-label">Gejala:</div>
                <div class="result-value">${result.disease_info.symptoms || 'Tidak ada gejala khusus'}</div>
            </div>
            
            <div class="result-row">
                <div class="result-label">Penyebab:</div>
                <div class="result-value">${result.disease_info.causes || 'Tidak diketahui'}</div>
            </div>
            
            <hr>
            
            <div class="result-row">
                <div class="result-label">Pencegahan:</div>
                <div class="result-value">${result.disease_info.prevention || 'Lakukan perawatan rutin'}</div>
            </div>
            
            <div class="result-row">
                <div class="result-label">Pengobatan:</div>
                <div class="result-value">${result.disease_info.treatment || 'Konsultasi dengan ahli'}</div>
            </div>
        `;
        
        // Insert the HTML into the result body
        resultBody.innerHTML = resultHTML;
        
        // Show the result container
        resultContainer.classList.add('active');
        
        // Re-enable classify button for new predictions
        classifyBtn.disabled = false;
        
        console.log('Results displayed successfully');
    }

    function getConfidenceColor(percentage) {
        if (percentage >= 80) return 'linear-gradient(135deg, #28a745 0%, #20c997 100%)';
        if (percentage >= 60) return 'linear-gradient(135deg, #ffc107 0%, #e0a800 100%)';
        return 'linear-gradient(135deg, #fd7e14 0%, #e8590c 100%)';
    }

    function getSeverityClass(severity) {
        if (!severity) return 'severity-none';
        const severityLower = severity.toLowerCase();
        switch(severityLower) {
            case 'tinggi':
            case 'high': 
                return 'severity-tinggi';
            case 'sedang':
            case 'medium': 
                return 'severity-sedang';
            case 'rendah':
            case 'low': 
                return 'severity-rendah';
            case 'tidak ada':
            case 'none': 
                return 'severity-none';
            default: 
                return 'severity-sedang';
        }
    }

    function formatSeverity(severity) {
        if (!severity) return 'Tidak Ada';
        const severityMap = {
            'tinggi': 'Tinggi',
            'sedang': 'Sedang', 
            'rendah': 'Rendah',
            'tidak ada': 'Tidak Ada',
            'high': 'Tinggi',
            'medium': 'Sedang',
            'low': 'Rendah',
            'none': 'Tidak Ada'
        };
        return severityMap[severity.toLowerCase()] || severity;
    }

    function isUserLoggedIn() {
        // Check if user is authenticated from meta tag
        const authMeta = document.querySelector('meta[name="user-authenticated"]');
        return authMeta && authMeta.getAttribute('content') === 'true';
    }

    function showNotification(message, type = 'info') {
        console.log(`Notification: ${message} (${type})`);
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        `;
        
        // Add styles
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#4CAF50' : type === 'error' ? '#f44336' : '#2196F3'};
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideInRight 0.3s ease;
            max-width: 350px;
            word-wrap: break-word;
        `;
        
        document.body.appendChild(notification);
        
        // Remove notification after 5 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 5000);
    }

    // Add CSS for notification animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
});
</script>

@endsection