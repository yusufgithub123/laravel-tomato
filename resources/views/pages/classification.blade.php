@extends('layouts.app')

@section('content')

<div class="container">
    
    <h2 class="mb-4">🩺 Klasifikasi Penyakit Daun Tomat</h2>

    <form id="classificationForm" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="imageInput" class="form-label">Upload Gambar Daun Tomat</label>
            <input class="form-control" type="file" id="imageInput" name="image" accept="image/*" required>
            <div class="form-text">Format yang diterima: JPG, PNG, GIF (maksimal 16MB)</div>
        </div>
        <button type="submit" class="btn btn-success">Klasifikasi Sekarang</button>
    </form>

    <div id="preview" class="mt-4"></div>

    <div id="result" class="mt-4">
        {{-- Hasil klasifikasi akan muncul di sini --}}
    </div>
</div>

<script>
    document.getElementById('classificationForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const imageInput = document.getElementById('imageInput');
        const resultDiv = document.getElementById('result');
        const previewDiv = document.getElementById('preview');

        // Clear previous results
        resultDiv.innerHTML = '';
        previewDiv.innerHTML = '';

        if (imageInput.files.length === 0) {
            resultDiv.innerHTML = `<div class="alert alert-danger">❌ Silakan pilih gambar terlebih dahulu.</div>`;
            return;
        }

        const selectedFile = imageInput.files[0];
        
        // Validate file size (16MB limit)
        if (selectedFile.size > 16 * 1024 * 1024) {
            resultDiv.innerHTML = `<div class="alert alert-danger">❌ Ukuran file terlalu besar. Maksimal 16MB.</div>`;
            return;
        }

        // Show file preview
        const reader = new FileReader();
        reader.onload = function(e) {
            previewDiv.innerHTML = `
                <div class="mb-3">
                    <h5>Preview Gambar:</h5>
                    <img src="${e.target.result}" class="img-fluid rounded shadow-sm" style="max-width: 300px;" alt="Preview">
                </div>
            `;
        };
        reader.readAsDataURL(selectedFile);

        // Prepare form data
        const formData = new FormData();
        formData.append('image', selectedFile);

        // Show loading message
        resultDiv.innerHTML = `
            <div class="alert alert-info">
                <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                ⏳ Mengirim gambar dan memproses klasifikasi...
            </div>
        `;

        try {
            console.log('Sending request to API...');
            const response = await fetch('http://localhost:5000/predict', {
                method: 'POST',
                body: formData,
                // Don't set Content-Type header, let browser set it with boundary
            });

            console.log('Response status:', response.status);
            const data = await response.json();
            console.log('Response data:', data);

            if (data.success) {
                const result = data.data;
                
                // Display classification results
                resultDiv.innerHTML = `
                    <div class="card shadow">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">✅ Hasil Klasifikasi</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>📊 Hasil Prediksi:</h6>
                                    <p><strong>Kelas:</strong> <code>${result.classification.class}</code></p>
                                    <p><strong>Nama Penyakit:</strong> <span class="badge ${result.classification.is_healthy ? 'bg-success' : 'bg-warning'}">${result.classification.class_name}</span></p>
                                    <p><strong>Kepercayaan:</strong> <strong>${result.classification.confidence_percentage}%</strong></p>
                                    <p><strong>Status:</strong> ${result.classification.is_healthy ? '<span class="text-success">✓ Tanaman Sehat</span>' : '<span class="text-warning">⚠️ Terdeteksi Penyakit</span>'}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>🦠 Informasi Penyakit:</h6>
                                    <p><strong>Gejala:</strong> ${result.disease_info.symptoms}</p>
                                    <p><strong>Penyebab:</strong> ${result.disease_info.causes}</p>
                                    <p><strong>Tingkat Keparahan:</strong> 
                                        <span class="badge ${getSeverityBadgeClass(result.disease_info.severity)}">${result.disease_info.severity}</span>
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>🛡️ Pencegahan:</h6>
                                    <p>${result.disease_info.prevention}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>💊 Pengobatan:</h6>
                                    <p>${result.disease_info.treatment}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                resultDiv.innerHTML = `
                    <div class="alert alert-danger">
                        <h5>❌ Klasifikasi Gagal</h5>
                        <p><strong>Error:</strong> ${data.error}</p>
                        <small class="text-muted">Pastikan API Python sedang berjalan di localhost:5000</small>
                    </div>
                `;
            }

        } catch (error) {
            console.error('Error:', error);
            resultDiv.innerHTML = `
                <div class="alert alert-danger">
                    <h5>❌ Koneksi Error</h5>
                    <p><strong>Error:</strong> ${error.message}</p>
                    <small class="text-muted">
                        Pastikan:
                        <ul class="mt-2">
                            <li>API Python berjalan di <code>localhost:5000</code></li>
                            <li>CORS sudah dikonfigurasi dengan benar</li>
                            <li>Tidak ada firewall yang memblokir koneksi</li>
                        </ul>
                    </small>
                </div>
            `;
        }
    });

    function getSeverityBadgeClass(severity) {
        switch(severity) {
            case 'high': return 'bg-danger';
            case 'medium': return 'bg-warning';
            case 'low': return 'bg-info';
            case 'none': return 'bg-success';
            default: return 'bg-secondary';
        }
    }

    // Test API connection on page load
    window.addEventListener('load', async function() {
        try {
            const response = await fetch('http://localhost:5000/health');
            const data = await response.json();
            
            if (data.success && data.model_loaded) {
                console.log('✅ API connection successful, model loaded');
            } else {
                console.warn('⚠️ API connected but model not loaded');
            }
        } catch (error) {
            console.error('❌ Cannot connect to API:', error);
        }
    });
</script>

@endsection