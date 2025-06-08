// Global state
let currentSlide = 0;

// Initialize the app
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on the classification page
    if (document.getElementById('klasifikasi')) {
        // Initialize classification-specific functionality
        initClassificationPage();
    } else {
        // Initialize general page functionality
        initNavigation();
        initSlider();
        initHamburgerMenu();
        addInteractiveAnimations();
    }
});

// Classification page initialization
function initClassificationPage() {
    console.log('Initializing classification page...');
    
    // Initialize tab functionality
    initClassificationTabs();
    
    // Initialize upload functionality
    initUploadFunctionality();
    
    // Check API health
    checkApiHealth();
}

// Tab functionality for classification page
function initClassificationTabs() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            tabButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Handle tab content switching if needed
            const tabType = this.getAttribute('data-tab');
            handleTabSwitch(tabType);
        });
    });
}

// Handle tab switching
function handleTabSwitch(tabType) {
    console.log(`Switching to tab: ${tabType}`);
    
    switch(tabType) {
        case 'upload':
            // Show upload area, hide results
            showUploadArea();
            break;
        case 'klasifikasi-tab':
            // Show classification process
            showClassificationProcess();
            break;
        case 'hasil':
            // Show results
            showResults();
            break;
    }
}

// Show upload area
function showUploadArea() {
    const uploadArea = document.querySelector('.upload-area');
    const resultContainer = document.getElementById('resultContainer');
    
    if (uploadArea) {
        uploadArea.style.display = 'block';
    }
    
    if (resultContainer) {
        resultContainer.style.display = 'none';
    }
}

// Show classification process
function showClassificationProcess() {
    // This would be called when user clicks classify button
    const selectedFile = window.selectedFile;
    
    if (selectedFile) {
        // Trigger classification
        if (window.classifyImage) {
            window.classifyImage();
        }
    } else {
        showError('Silakan pilih gambar terlebih dahulu');
        // Switch back to upload tab
        const uploadTab = document.querySelector('.tab-btn[data-tab="upload"]');
        if (uploadTab) {
            uploadTab.click();
        }
    }
}

// Show results
function showResults() {
    const resultContainer = document.getElementById('resultContainer');
    
    if (resultContainer && resultContainer.style.display !== 'none') {
        resultContainer.scrollIntoView({ behavior: 'smooth' });
    } else {
        showError('Belum ada hasil klasifikasi');
        // Switch back to upload tab
        const uploadTab = document.querySelector('.tab-btn[data-tab="upload"]');
        if (uploadTab) {
            uploadTab.click();
        }
    }
}

// Initialize upload functionality
function initUploadFunctionality() {
    let selectedFile = null;
    let isProcessing = false;
    
    // Make selectedFile globally accessible
    window.selectedFile = selectedFile;
    
    const uploadBtn = document.getElementById('uploadBtn');
    const fileInput = document.getElementById('fileInput');
    const uploadBox = document.getElementById('uploadBox');

    // Upload button click
    if (uploadBtn) {
        uploadBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (fileInput) {
                fileInput.click();
            }
        });
    }

    // File input change
    if (fileInput) {
        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file && validateFile(file)) {
                selectedFile = file;
                window.selectedFile = selectedFile;
                displaySelectedImage(file);
            }
        });
    }

    // Drag and drop functionality
    if (uploadBox) {
        uploadBox.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.style.background = 'rgba(76, 175, 80, 0.2)';
            this.style.borderColor = '#4CAF50';
        });

        uploadBox.addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.style.background = 'rgba(76, 175, 80, 0.05)';
            this.style.borderColor = '#ddd';
        });

        uploadBox.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.style.background = 'rgba(76, 175, 80, 0.05)';
            this.style.borderColor = '#ddd';
            
            if (e.dataTransfer.files.length > 0) {
                const file = e.dataTransfer.files[0];
                if (validateFile(file)) {
                    selectedFile = file;
                    window.selectedFile = selectedFile;
                    displaySelectedImage(file);
                }
            }
        });
    }
}

// Validate file function
function validateFile(file) {
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    const maxSize = 2 * 1024 * 1024; // 2MB

    if (!allowedTypes.includes(file.type)) {
        showError('Format file tidak didukung. Gunakan JPG, PNG, atau GIF.');
        return false;
    }

    if (file.size > maxSize) {
        showError('Ukuran file terlalu besar. Maksimal 2MB.');
        return false;
    }

    return true;
}

// Display selected image
function displaySelectedImage(file) {
    const reader = new FileReader();
    reader.onload = function(e) {
        const uploadBox = document.getElementById('uploadBox');
        uploadBox.innerHTML = `
            <div class="selected-image-container">
                <img src="${e.target.result}" 
                     style="max-width: 300px; max-height: 200px; border-radius: 10px; margin-bottom: 15px; object-fit: cover;">
                <h3 style="color: #4CAF50;">✓ File berhasil dipilih!</h3>
                <p style="color: #666;">${file.name}</p>
                <p style="color: #999; font-size: 0.9em;">Ukuran: ${(file.size / 1024).toFixed(1)} KB</p>
                <div class="action-buttons" style="margin-top: 20px;">
                    <button class="classify-btn" id="classifyBtn" style="
                        background: #4CAF50; 
                        color: white; 
                        padding: 12px 30px; 
                        border: none; 
                        border-radius: 25px; 
                        font-size: 16px; 
                        font-weight: bold; 
                        cursor: pointer; 
                        margin-right: 10px;
                        transition: all 0.3s ease;
                    ">KLASIFIKASI</button>
                    <button class="change-btn" id="changeBtn" style="
                        background: transparent; 
                        color: #666; 
                        padding: 12px 30px; 
                        border: 2px solid #ddd; 
                        border-radius: 25px; 
                        font-size: 16px; 
                        cursor: pointer;
                        transition: all 0.3s ease;
                    ">GANTI GAMBAR</button>
                </div>
            </div>
        `;

        // Add event listeners to new buttons
        const classifyBtn = document.getElementById('classifyBtn');
        const changeBtn = document.getElementById('changeBtn');

        if (classifyBtn) {
            classifyBtn.addEventListener('click', function() {
                // Switch to classification tab and start classification
                const classificationTab = document.querySelector('.tab-btn[data-tab="klasifikasi-tab"]');
                if (classificationTab) {
                    classificationTab.click();
                }
            });
        }

        if (changeBtn) {
            changeBtn.addEventListener('click', resetUpload);
        }
    };
    reader.readAsDataURL(file);
}

// Reset upload function
function resetUpload() {
    window.selectedFile = null;
    const uploadBox = document.getElementById('uploadBox');
    const fileInput = document.getElementById('fileInput');
    
    if (fileInput) {
        fileInput.value = '';
    }

    if (uploadBox) {
        uploadBox.innerHTML = `
            <i class="fas fa-image"></i>
            <h3>DRAG & DROP</h3>
            <p>Atau masukkan file foto daun tomat</p>
            <button class="upload-btn" id="uploadBtn">UPLOAD</button>
            <input type="file" id="fileInput" accept="image/*" style="display: none;">
        `;

        // Reinitialize upload functionality
        initUploadFunctionality();
    }

    // Clear results
    const resultContainer = document.getElementById('resultContainer');
    if (resultContainer) {
        resultContainer.style.display = 'none';
    }
    
    // Switch back to upload tab
    const uploadTab = document.querySelector('.tab-btn[data-tab="upload"]');
    if (uploadTab) {
        uploadTab.click();
    }
}

// Check API health
async function checkApiHealth() {
    try {
        const response = await fetch('/api/health', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const result = await response.json();
        
        if (result.success && result.data.model_loaded) {
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

// Hamburger Menu Functionality
function initHamburgerMenu() {
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const navContainer = document.querySelector('.nav-container');
    const overlay = document.createElement('div');
    overlay.className = 'nav-overlay';
    document.body.appendChild(overlay);
    
    if (hamburgerBtn) {
        hamburgerBtn.addEventListener('click', function() {
            this.classList.toggle('active');
            navContainer.classList.toggle('active');
            overlay.classList.toggle('active');
            document.body.style.overflow = navContainer.classList.contains('active') ? 'hidden' : '';
        });
    }
    
    overlay.addEventListener('click', function() {
        hamburgerBtn.classList.remove('active');
        navContainer.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    });
    
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
    
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            if (hamburgerBtn) hamburgerBtn.classList.remove('active');
            if (navContainer) navContainer.classList.remove('active');
            if (overlay) overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
}

// Navigation functionality
function initNavigation() {
    const navPills = document.querySelectorAll('.nav-pill');
    navPills.forEach(pill => {
        pill.addEventListener('click', function() {
            navPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
        });
    });
}

// Slider functionality
function initSlider() {
    const slides = document.querySelectorAll('.slide');
    const prevBtn = document.querySelector('.slider-nav.prev');
    const nextBtn = document.querySelector('.slider-nav.next');
    
    if (slides.length === 0) return;
    
    setInterval(nextSlide, 5000);
    
    if (prevBtn) prevBtn.addEventListener('click', prevSlide);
    if (nextBtn) nextBtn.addEventListener('click', nextSlide);
    
    const swipeButtons = document.querySelectorAll('.swipe-btn');
    swipeButtons.forEach(btn => {
        btn.addEventListener('click', nextSlide);
    });
}

function showSlide(index) {
    const slides = document.querySelectorAll('.slide');
    slides.forEach(slide => slide.classList.remove('active'));
    if (slides[index]) slides[index].classList.add('active');
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

// Add interactive animations
function addInteractiveAnimations() {
    const cards = document.querySelectorAll('.disease-card, .team-member, .history-item');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
}

// Auth buttons functionality
document.addEventListener('DOMContentLoaded', function() {
    const btnMasuk = document.querySelector('.btn-masuk');
    const btnDaftar = document.querySelector('.btn-daftar');
    
    if (btnMasuk) {
        btnMasuk.addEventListener('click', function() {
            window.location.href = "{{ route('login') }}";
        });
    }
    
    if (btnDaftar) {
        btnDaftar.addEventListener('click', function() {
            window.location.href = "{{ route('register') }}";
        });
    }
});

// Save history function to be used by classification page
function saveHistory(resultData) {
    if (!resultData) {
        console.error('No result data provided');
        return;
    }
    
    fetch('/save-history', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            disease_name: resultData.disease_info.name,
            accuracy: resultData.classification.confidence_percentage,
            is_healthy: resultData.classification.is_healthy,
            solution: resultData.disease_info.treatment,
            severity: resultData.disease_info.severity,
            image_url: resultData.image_url
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess('Hasil klasifikasi berhasil disimpan ke riwayat');
        } else {
            showError('Gagal menyimpan riwayat: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showError('Gagal menyimpan riwayat');
    });
}

// Helper function to show success message (compatible with classification.blade.php)
function showSuccess(message) {
    // Remove existing success message
    const existingSuccess = document.getElementById('successMessage');
    if (existingSuccess) {
        existingSuccess.remove();
    }

    const successHtml = `
        <div id="successMessage" style="
            position: fixed;
            top: 20px;
            right: 20px;
            background: #4CAF50;
            color: white;
            padding: 15px 25px;
            border-radius: 5px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.3);
            z-index: 1001;
            max-width: 300px;
        ">
            <strong>✅ Berhasil:</strong> ${message}
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', successHtml);
    
    setTimeout(() => {
        const successElement = document.getElementById('successMessage');
        if (successElement) {
            successElement.remove();
        }
    }, 3000);
}

// Helper function to show error message (compatible with classification.blade.php)
function showError(message) {
    // Remove existing error message
    const existingError = document.getElementById('errorMessage');
    if (existingError) {
        existingError.remove();
    }

    const errorHtml = `
        <div id="errorMessage" style="
            position: fixed;
            top: 20px;
            right: 20px;
            background: #f44336;
            color: white;
            padding: 15px 25px;
            border-radius: 5px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.3);
            z-index: 1001;
            max-width: 300px;
        ">
            <strong>❌ Error:</strong> ${message}
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', errorHtml);
    
    setTimeout(() => {
        const errorElement = document.getElementById('errorMessage');
        if (errorElement) {
            errorElement.remove();
        }
    }, 5000);
}

/*Beranda js*/
