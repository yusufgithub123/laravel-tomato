{{-- classification.blade.php --}}
@extends('layouts.app')

@section('title', 'Klasifikasi - LeafGuard Tomato')

@section('content')
<div id="klasifikasi" class="page active">
    <div class="page-title">
        <h1>KLASIFIKASI</h1>
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
</div>
@endsection
