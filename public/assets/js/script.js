// Global state
let currentSlide = 0;

// Initialize the app
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded');
    
    // Initialize general functionality
    initNavigation();
    initSlider();
    initHamburgerMenu();
    addInteractiveAnimations();
    
    // Check if we're on specific pages and initialize accordingly
    if (document.getElementById('klasifikasi') || window.location.pathname.includes('classification')) {
        initClassificationPage();
    }
    
    if (document.getElementById('penyakit') || window.location.pathname.includes('diseases')) {
        initDiseaseModal();
    }
    
    if (document.getElementById('riwayat') || window.location.pathname.includes('history')) {
        initHistoryPage();
    }
    
    if (document.getElementById('kontak') || window.location.pathname.includes('contact')) {
        initContactPage();
    }
});

// ===== NAVIGATION FUNCTIONALITY =====
function initNavigation() {
    const navPills = document.querySelectorAll('.nav-pill');
    navPills.forEach(pill => {
        pill.addEventListener('click', function(e) {
            // Remove active class from all pills
            navPills.forEach(p => p.classList.remove('active'));
            // Add active class to clicked pill
            this.classList.add('active');
        });
    });
}

// ===== HAMBURGER MENU FUNCTIONALITY =====
function initHamburgerMenu() {
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const navContainer = document.querySelector('.nav-container');
    
    // Create overlay if it doesn't exist
    let overlay = document.querySelector('.nav-overlay');
    if (!overlay) {
        overlay = document.createElement('div');
        overlay.className = 'nav-overlay';
        document.body.appendChild(overlay);
    }
    
    if (hamburgerBtn && navContainer) {
        // Add mobile auth section to navigation
        addMobileAuthSection();
        
        hamburgerBtn.addEventListener('click', function() {
            this.classList.toggle('active');
            navContainer.classList.toggle('active');
            overlay.classList.toggle('active');
            document.body.style.overflow = navContainer.classList.contains('active') ? 'hidden' : '';
        });
        
        // Close menu when overlay is clicked
        overlay.addEventListener('click', function() {
            hamburgerBtn.classList.remove('active');
            navContainer.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        });
        
        // Close menu when nav item is clicked (mobile)
        const navPills = document.querySelectorAll('.nav-pill');
        navPills.forEach(pill => {
            pill.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    hamburgerBtn.classList.remove('active');
                    navContainer.classList.remove('active');
                    overlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });
    }
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            if (hamburgerBtn) hamburgerBtn.classList.remove('active');
            if (navContainer) navContainer.classList.remove('active');
            if (overlay) overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
}

function addMobileAuthSection() {
    const navContainer = document.querySelector('.nav-container');
    if (!navContainer) return;
    
    // Check if mobile auth section already exists
    if (navContainer.querySelector('.mobile-auth-section')) return;
    
    // Check if user is authenticated
    const isAuthenticated = document.querySelector('meta[name="user-authenticated"]')?.getAttribute('content') === 'true';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    // Create mobile auth section
    const mobileAuthSection = document.createElement('div');
    mobileAuthSection.className = 'mobile-auth-section';
    
    if (isAuthenticated) {
        // Show logout button for authenticated users
        mobileAuthSection.innerHTML = `
            <div class="mobile-auth-buttons">
                <form method="POST" action="/logout" class="mobile-logout-form">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <button type="submit" class="btn-masuk">
                        <i class="fas fa-sign-out-alt"></i> LOGOUT
                    </button>
                </form>
            </div>
        `;
    } else {
        // Show login and register buttons for guests
        mobileAuthSection.innerHTML = `
            <div class="mobile-auth-buttons">
                <a href="/login" class="btn-masuk">
                    <i class="fas fa-sign-in-alt"></i> MASUK
                </a>
                <a href="/register" class="btn-daftar">
                    <i class="fas fa-user-plus"></i> DAFTAR
                </a>
            </div>
        `;
    }
    
    // Append to nav container
    navContainer.appendChild(mobileAuthSection);
}

// ===== SLIDER FUNCTIONALITY =====
function initSlider() {
    const slides = document.querySelectorAll('.slide');
    const prevBtn = document.querySelector('.slider-nav.prev');
    const nextBtn = document.querySelector('.slider-nav.next');
    
    if (slides.length === 0) return;
    
    // Auto slide every 5 seconds
    setInterval(nextSlide, 5000);
    
    // Navigation buttons
    if (prevBtn) prevBtn.addEventListener('click', prevSlide);
    if (nextBtn) nextBtn.addEventListener('click', nextSlide);
    
    // Swipe buttons
    const swipeButtons = document.querySelectorAll('.swipe-btn');
    swipeButtons.forEach(btn => {
        btn.addEventListener('click', nextSlide);
    });
}

function showSlide(index) {
    const slides = document.querySelectorAll('.slide');
    slides.forEach((slide, i) => {
        slide.classList.toggle('active', i === index);
    });
}

function nextSlide() {
    const slides = document.querySelectorAll('.slide');
    currentSlide = (currentSlide + 1) % slides.length;
    showSlide(currentSlide);
}

function prevSlide() {
    const slides = document.querySelectorAll('.slide');
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    showSlide(currentSlide);
}

// ===== CLASSIFICATION PAGE FUNCTIONALITY =====
function initClassificationPage() {
    console.log('Initializing classification page...');
    
    // Initialize upload functionality
    initUploadFunctionality();
    
    // Check API health
    checkApiHealth();
}

function initUploadFunctionality() {
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

    let currentFile = null;

    if (!dropArea || !fileInput) {
        console.log('Upload elements not found, skipping upload initialization');
        return;
    }

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
        currentFile = file;
        
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
        if (uploadText) uploadText.style.display = 'none';
        if (fileInfo) fileInfo.classList.add('active');
        
        // Display file name and info
        if (fileName) fileName.textContent = file.name;
        if (fileSize) fileSize.textContent = formatFileSize(file.size);
        if (fileType) fileType.textContent = file.type;
        
        // Display preview
        if (filePreview) {
            const reader = new FileReader();
            reader.onload = function(e) {
                filePreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
        
        // Enable classify button
        if (classifyBtn) classifyBtn.disabled = false;
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function showError(message) {
        if (errorMessage) {
            errorMessage.textContent = message;
            errorMessage.classList.add('active');
        }
        if (classifyBtn) classifyBtn.disabled = true;
        if (fileInfo) fileInfo.classList.remove('active');
        if (uploadText) uploadText.style.display = 'block';
        hideValidationError();
    }

    function hideError() {
        if (errorMessage) {
            errorMessage.classList.remove('active');
        }
    }

    function showValidationError(error, details) {
        hideError();
        
        if (validationMessage) {
            validationMessage.textContent = error;
        }
        
        // Show validation reasons if available
        if (validationReasons) {
            if (details && details.reasons && details.reasons.length > 0) {
                const reasonsList = details.reasons.map(reason => `<li>${reason}</li>`).join('');
                validationReasons.innerHTML = `<strong>Alasan:</strong><ul>${reasonsList}</ul>`;
            } else if (details && details.reason) {
                validationReasons.innerHTML = `<strong>Alasan:</strong> ${details.reason}`;
            } else {
                validationReasons.innerHTML = '';
            }
        }
        
        // Show suggestion
        if (validationSuggestion) {
            if (details && details.suggestion) {
                validationSuggestion.textContent = details.suggestion;
            } else {
                validationSuggestion.textContent = 'Silakan upload gambar daun tomat yang jelas dengan latar belakang yang kontras';
            }
        }
        
        if (validationError) {
            validationError.style.display = 'block';
            validationError.classList.add('active');
        }
        
        // Keep file info visible but disable classify button
        if (classifyBtn) classifyBtn.disabled = true;
    }

    function hideValidationError() {
        if (validationError) {
            validationError.style.display = 'none';
            validationError.classList.remove('active');
        }
    }

    // Handle classification
    if (classifyBtn) {
        classifyBtn.addEventListener('click', async function() {
            if (!fileInput || fileInput.files.length === 0) {
                showError('Silakan pilih gambar terlebih dahulu');
                return;
            }
            
            const file = fileInput.files[0];
            const formData = new FormData();
            formData.append('image', file);
            
            // Show loading spinner
            if (loadingSpinner) loadingSpinner.classList.add('active');
            if (classifyBtn) classifyBtn.disabled = true;
            if (resultContainer) resultContainer.classList.remove('active');
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
                if (loadingSpinner) loadingSpinner.classList.remove('active');
                // Only re-enable button if no validation error
                if (validationError && !validationError.classList.contains('active')) {
                    if (classifyBtn) classifyBtn.disabled = false;
                }
            }
        });
    }

    // Save classification result to history
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
        if (resultBody) {
            resultBody.innerHTML = resultHTML;
        }
        
        // Show the result container
        if (resultContainer) {
            resultContainer.classList.add('active');
        }
        
        // Re-enable classify button for new predictions
        if (classifyBtn) classifyBtn.disabled = false;
        
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
}

// Check API health
async function checkApiHealth() {
    try {
        const response = await fetch('http://localhost:5000/health', {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        });

        const result = await response.json();
        
        if (result.success && result.model_loaded) {
            console.log('✅ AI Model is ready');
            showApiStatus('ready');
        } else {
            console.warn('⚠️ AI Model not loaded');
            showApiStatus('not_ready');
        }
    } catch (error) {
        console.error('❌ API connection failed:', error);
        showApiStatus('error');
    }
}

// Show API status
function showApiStatus(status) {
    const statusMessages = {
        'ready': { text: 'AI Model Siap', color: '#4CAF50', icon: '✅' },
        'not_ready': { text: 'AI Model Tidak Siap', color: '#FF9800', icon: '⚠️' },
        'error': { text: 'Koneksi API Bermasalah', color: '#f44336', icon: '❌' }
    };

    const statusInfo = statusMessages[status];
    
    // Remove existing status
    const existingStatus = document.getElementById('apiStatus');
    if (existingStatus) {
        existingStatus.remove();
    }
    
    // Add status indicator to page
    const statusElement = document.createElement('div');
    statusElement.id = 'apiStatus';
    statusElement.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: ${statusInfo.color};
        color: white;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        z-index: 1000;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    `;
    statusElement.innerHTML = `${statusInfo.icon} ${statusInfo.text}`;
    
    document.body.appendChild(statusElement);
    
    // Auto hide after 5 seconds for ready status
    if (status === 'ready') {
        setTimeout(() => {
            if (statusElement && statusElement.parentNode) {
                statusElement.style.opacity = '0';
                setTimeout(() => {
                    if (statusElement.parentNode) {
                        statusElement.remove();
                    }
                }, 300);
            }
        }, 5000);
    }
}

// ===== DISEASE PAGE FUNCTIONALITY =====
function initDiseaseModal() {
    // Make openModal and closeModal global
    window.openModal = openModal;
    window.closeModal = closeModal;
    
    function openModal(diseaseId) {
        const modal = document.getElementById('diseaseModal');
        const modalContent = document.getElementById('modalContent');
        
        if (!modal || !modalContent) return;
        
        // Data penyakit
        const diseases = {
            'early-blight': {
                title: 'Early Blight',
                image: '/assets/images/v1.jpeg',
                description: 'Penyakit yang disebabkan oleh jamur Alternaria solani, ditandai dengan bercak coklat gelap dengan cincin konsentris pada daun. Penyakit ini umumnya menyerang tanaman tomat yang sudah tua atau stress.',
                symptoms: 'Bercak coklat gelap dengan cincin konsentris, daun menguning dan layu, buah dapat terinfeksi dengan bercak hitam.',
                treatment: 'Gunakan fungisida berbahan aktif mankozeb atau klorotalonil. Pangkas daun yang terinfeksi dan jaga sirkulasi udara yang baik.'
            },
            'late-blight': {
                title: 'Late Blight',
                image: '/assets/images/v2.jpeg',
                description: 'Disebabkan oleh Phytophthora infestans, menyebabkan bercak coklat kehitaman yang cepat menyebar terutama dalam kondisi lembab.',
                symptoms: 'Bercak coklat kehitaman yang cepat menyebar, daun layu dan mati, buah membusuk dengan cepat.',
                treatment: 'Gunakan fungisida sistemik berbahan aktif metalaksil atau dimethomorph. Perbaiki drainase dan kurangi kelembaban.'
            },
            'bacterial-spot': {
                title: 'Bacterial Spot',
                image: '/assets/images/v3.jpeg',
                description: 'Infeksi bakteri yang menyebabkan bercak kecil berwarna coklat tua dengan halo kuning di sekitarnya.',
                symptoms: 'Bercak kecil coklat tua dengan halo kuning, daun berlubang, buah dengan bercak kasar.',
                treatment: 'Gunakan bakterisida berbahan aktif tembaga. Hindari penyiraman dari atas dan jaga kebersihan kebun.'
            },
            'septoria-leaf-spot': {
                title: 'Septoria Leaf Spot',
                image: '/assets/images/v4.jpeg',
                description: 'Bercak kecil bulat dengan pusat berwarna abu-abu dan tepi coklat gelap, disebabkan oleh jamur Septoria.',
                symptoms: 'Bercak kecil bulat dengan pusat abu-abu, daun menguning dan gugur dari bawah ke atas.',
                treatment: 'Aplikasi fungisida berbahan aktif azoxystrobin atau propiconazole. Rotasi tanaman dan sanitasi kebun.'
            },
            'tylcv': {
                title: 'Tomato Yellow Leaf Curl Virus',
                image: '/assets/images/v5.jpeg',
                description: 'Virus yang ditularkan oleh kutu kebul (Bemisia tabaci), menyebabkan daun menguning dan menggulung.',
                symptoms: 'Daun menguning dan menggulung ke atas, pertumbuhan terhambat, produksi buah menurun drastis.',
                treatment: 'Kendalikan kutu kebul dengan insektisida, gunakan mulsa reflektif, dan tanam varietas tahan virus.'
            },
            'target-spot': {
                title: 'Target Spot',
                image: '/assets/images/v6.jpeg',
                description: 'Penyakit jamur yang menyebabkan bercak dengan pola cincin konsentris seperti target.',
                symptoms: 'Bercak dengan pola cincin konsentris seperti target, daun menguning dan gugur.',
                treatment: 'Gunakan fungisida berbahan aktif chlorothalonil atau azoxystrobin. Perbaiki sirkulasi udara.'
            },
            'tomato-mosaic': {
                title: 'Tomato Mosaic Virus',
                image: '/assets/images/v7.jpeg',
                description: 'Virus yang menyebabkan pola mozaik pada daun dengan warna hijau muda dan hijau tua.',
                symptoms: 'Pola mozaik hijau muda dan tua pada daun, daun mengkerut, buah berbintik-bintik.',
                treatment: 'Tidak ada pengobatan langsung. Cabut tanaman terinfeksi, desinfeksi alat, dan gunakan benih bebas virus.'
            },
            'leaf-mold': {
                title: 'Leaf Mold',
                image: '/assets/images/v8.jpeg',
                description: 'Jamur yang menyerang daun bagian bawah, menyebabkan lapisan berbulu dan bercak kuning.',
                symptoms: 'Lapisan berbulu abu-abu di bawah daun, bercak kuning di atas daun, daun layu.',
                treatment: 'Tingkatkan ventilasi, kurangi kelembaban, gunakan fungisida berbahan aktif trifloxystrobin.'
            },
            'spider-mites': {
                title: 'Spider Mites Two-spotted',
                image: '/assets/images/v9.jpeg',
                description: 'Tungau kecil yang menyebabkan bintik-bintik kuning pada daun dan jaring halus.',
                symptoms: 'Bintik-bintik kuning pada daun, jaring halus di bawah daun, daun kering dan gugur.',
                treatment: 'Semprotkan air dengan tekanan tinggi, gunakan predator alami, atau mitisida jika perlu.'
            },
            'powdery-mildew': {
                title: 'Powdery Mildew',
                image: '/assets/images/v10.jpeg',
                description: 'Jamur yang membentuk lapisan putih seperti tepung pada permukaan daun.',
                symptoms: 'Lapisan putih seperti tepung pada daun, daun mengkerut dan menguning.',
                treatment: 'Gunakan fungisida berbahan aktif belerang atau myclobutanil. Perbaiki sirkulasi udara.'
            },
            'healthy': {
                title: 'Daun Sehat',
                image: '/assets/images/v12.jpeg',
                description: 'Daun tomat yang sehat menunjukkan warna hijau segar dan pertumbuhan normal.',
                symptoms: 'Warna hijau segar, pertumbuhan normal, tidak ada bercak atau kelainan.',
                treatment: 'Lanjutkan perawatan yang baik: penyiraman teratur, pemupukan seimbang, dan pemangkasan.'
            }
        };
        
        const disease = diseases[diseaseId];
        if (!disease) return;
        
        modalContent.innerHTML = `
            <h2>${disease.title}</h2>
            <img src="${disease.image}" alt="${disease.title}" style="max-width: 100%; height: auto; border-radius: 10px; margin: 15px 0;">
            <div style="text-align: left;">
                <p><strong>Deskripsi:</strong></p>
                <p style="margin-bottom: 20px;">${disease.description}</p>
                
                <p><strong>Gejala:</strong></p>
                <p style="margin-bottom: 20px;">${disease.symptoms}</p>
                
                <p><strong>Penanganan:</strong></p>
                <p>${disease.treatment}</p>
            </div>
        `;
        
        modal.style.display = 'block';
    }

    function closeModal() {
        const modal = document.getElementById('diseaseModal');
        if (modal) {
            modal.style.display = 'none';
        }
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('diseaseModal');
        if (event.target === modal) {
            closeModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });
}

// ===== HISTORY PAGE FUNCTIONALITY =====
function initHistoryPage() {
    // Initialize solution toggles
    const solutionToggles = document.querySelectorAll('.solution-toggle');
    solutionToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            toggleSolution(this);
        });
    });

    // Make delete function global
    window.deleteHistory = deleteHistory;
    window.toggleSolution = toggleSolution;
}

function toggleSolution(element) {
    const solutionContent = element.nextElementSibling;
    const toggleIcon = element.querySelector('.toggle-icon');
    const textSpan = element.querySelector('span');
    
    if (solutionContent.style.display === 'none' || solutionContent.style.display === '') {
        solutionContent.style.display = 'block';
        toggleIcon.style.transform = 'rotate(180deg)';
        textSpan.textContent = 'Sembunyikan Solusi';
        element.classList.add('active');
    } else {
        solutionContent.style.display = 'none';
        toggleIcon.style.transform = 'rotate(0deg)';
        textSpan.textContent = 'Lihat Solusi';
        element.classList.remove('active');
    }
}

// Function untuk delete history dengan AJAX
function deleteHistory(historyId) {
    if (!confirm('Apakah Anda yakin ingin menghapus riwayat ini?')) {
        return;
    }
    
    const deleteBtn = event.target.closest('.delete-btn');
    const originalContent = deleteBtn.innerHTML;
    deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    deleteBtn.disabled = true;
    
    fetch(`/history/${historyId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            deleteBtn.closest('.history-card').remove();
            showAlert('success', data.message || 'Riwayat berhasil dihapus');
            
            if (document.querySelectorAll('.history-card').length === 0) {
                location.reload();
            }
        } else {
            showAlert('error', data.message || 'Gagal menghapus riwayat');
            deleteBtn.innerHTML = originalContent;
            deleteBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan saat menghapus riwayat');
        deleteBtn.innerHTML = originalContent;
        deleteBtn.disabled = false;
    });
}

function showAlert(type, message) {
    document.querySelectorAll('.alert').forEach(alert => alert.remove());
    
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    alert.innerHTML = `
        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
        ${message}
    `;
    
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 300);
    }, 5000);
}

// ===== CONTACT PAGE FUNCTIONALITY =====
function initContactPage() {
    // Parallax effect untuk background
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const contactInfo = document.querySelector('.contact-info');
        if (contactInfo) {
            contactInfo.style.transform = `translateY(${scrolled * 0.1}px)`;
        }
    });
    
    // Hover effect untuk contact items
    const contactItems = document.querySelectorAll('.contact-item');
    contactItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(10px)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
    
    // Animasi untuk social links
    const socialLinks = document.querySelectorAll('.social-link');
    socialLinks.forEach((link, index) => {
        link.style.animationDelay = `${index * 0.1}s`;
    });
}

// ===== INTERACTIVE ANIMATIONS =====
function addInteractiveAnimations() {
    // Add hover animations to cards
    const cards = document.querySelectorAll('.disease-card, .team-member, .history-item, .feature-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            if (!this.style.transform.includes('translateY')) {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Add scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'fadeInUp 0.6s ease-out forwards';
            }
        });
    }, observerOptions);

    // Observe elements for scroll animations
    const animateElements = document.querySelectorAll('.feature-card, .step-card, .tip-card, .about-card, .history-card');
    animateElements.forEach(el => {
        observer.observe(el);
    });
}

// ===== UTILITY FUNCTIONS =====
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

// Helper function to show success message
function showSuccess(message) {
    showNotification(message, 'success');
}

// Helper function to show error message
function showError(message) {
    showNotification(message, 'error');
}

// ===== AUTO-HIDE ALERTS =====
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
});

// ===== ADD NOTIFICATION ANIMATIONS CSS =====
function addNotificationStyles() {
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
    `;
    document.head.appendChild(style);
}

// Initialize notification styles
addNotificationStyles();

// ===== SMOOTH SCROLLING =====
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scrolling to all links with hash
    const links = document.querySelectorAll('a[href^="#"]');
    links.forEach(link => {
        link.addEventListener('click', function(e) {
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
});

// ===== FORM VALIDATION =====
function validateForm(form) {
    const inputs = form.querySelectorAll('input[required], textarea[required]');
    let isValid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            showError(`Field ${input.name || input.id} harus diisi`);
            isValid = false;
        }
    });
    
    return isValid;
}

// ===== LAZY LOADING IMAGES =====
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
});

// ===== PERFORMANCE MONITORING =====
window.addEventListener('load', function() {
    // Log page load time
    const loadTime = performance.now();
    console.log(`Page loaded in ${loadTime.toFixed(2)}ms`);
    
    // Monitor long tasks
    if ('PerformanceObserver' in window) {
        const observer = new PerformanceObserver((list) => {
            for (const entry of list.getEntries()) {
                if (entry.duration > 50) {
                    console.warn(`Long task detected: ${entry.duration.toFixed(2)}ms`);
                }
            }
        });
        observer.observe({entryTypes: ['longtask']});
    }
});

// ===== ERROR HANDLING =====
window.addEventListener('error', function(e) {
    console.error('JavaScript Error:', e.error);
    // Optionally send to error tracking service
});

window.addEventListener('unhandledrejection', function(e) {
    console.error('Unhandled Promise Rejection:', e.reason);
    // Optionally send to error tracking service
});

// ===== ACCESSIBILITY IMPROVEMENTS =====
document.addEventListener('DOMContentLoaded', function() {
    // Add keyboard navigation for custom elements
    const customButtons = document.querySelectorAll('[role="button"]:not(button)');
    customButtons.forEach(btn => {
        btn.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });
    
    // Add focus indicators
    const focusableElements = document.querySelectorAll('button, a, input, textarea, [tabindex]');
    focusableElements.forEach(el => {
        el.addEventListener('focus', function() {
            this.style.outline = '2px solid #4CAF50';
            this.style.outlineOffset = '2px';
        });
        
        el.addEventListener('blur', function() {
            this.style.outline = '';
            this.style.outlineOffset = '';
        });
    });
});

// ===== PROGRESSIVE WEB APP FEATURES =====
// Service Worker Registration
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then((registration) => {
                console.log('SW registered: ', registration);
            })
            .catch((registrationError) => {
                console.log('SW registration failed: ', registrationError);
            });
    });
}

// ===== ANALYTICS AND TRACKING =====
function trackEvent(eventName, eventData = {}) {
    // Send event to analytics service
    console.log('Event tracked:', eventName, eventData);
    
    // Example: Google Analytics
    if (typeof gtag !== 'undefined') {
        gtag('event', eventName, eventData);
    }
}

// Track page views
window.addEventListener('load', function() {
    trackEvent('page_view', {
        page_title: document.title,
        page_location: window.location.href
    });
});

// Track interactions
document.addEventListener('click', function(e) {
    if (e.target.matches('.classify-btn')) {
        trackEvent('classification_started');
    }
    
    if (e.target.matches('.disease-card')) {
        trackEvent('disease_info_viewed', {
            disease_id: e.target.dataset.diseaseId || 'unknown'
        });
    }
});

// ===== EXPORT FUNCTIONS FOR TESTING =====
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        showSlide,
        nextSlide,
        prevSlide,
        formatFileSize: (bytes) => {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        },
        showNotification,
        trackEvent
    };
}