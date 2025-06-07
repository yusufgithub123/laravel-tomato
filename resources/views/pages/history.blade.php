@extends('layouts.app')

@section('title', 'Riwayat - LeafGuard Tomato')

@section('content')
<div id="riwayat" class="page active">
    <div class="page-title">
        <h1>RIWAYAT</h1>
        <div class="title-underline"></div>
    </div>
    
    <div class="history-container">
        @if(isset($histories) && $histories->count() > 0)
            @foreach($histories as $history)
            <div class="history-card">
                <div class="history-image-container">
                    @if($history->image_path)
                        @if(filter_var($history->image_path, FILTER_VALIDATE_URL))
                            <img src="{{ $history->image_path }}" alt="Scan Result" onerror="this.src='/images/placeholder.jpg'">
                        @else
                            <img src="{{ asset('storage/' . $history->image_path) }}" alt="Scan Result" onerror="this.src='/images/placeholder.jpg'">
                        @endif
                    @else
                        <img src="/images/placeholder.jpg" alt="No image">
                    @endif
                </div>
                
                <div class="history-content">
                    <div class="history-header">
                        <h3 class="disease-name">{{ $history->disease_name ?? 'Unknown Disease' }}</h3>
                        <div class="history-meta">
                            <div class="accuracy-badge">
                                <i class="fas fa-percentage"></i>
                                Akurasi: {{ number_format($history->accuracy ?? 0, 0) }}%
                            </div>
                            <div class="date-info">
                                <i class="fas fa-calendar"></i>
                                {{ $history->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>
                    
                    @if(!$history->is_healthy)
                        <!-- Disease Information -->
                        <div class="disease-details">
                            @if($history->symptoms)
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <strong>Gejala:</strong>
                                    </div>
                                    <p>{{ $history->symptoms }}</p>
                                </div>
                            @endif
                            
                            @if($history->causes)
                                <div class="info-item">
                                    <div class="info-label">
                                        <i class="fas fa-search"></i>
                                        <strong>Penyebab:</strong>
                                    </div>
                                    <p>{{ $history->causes }}</p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Solution Toggle -->
                        @if($history->treatment || $history->prevention || $history->solution)
                            <div class="solution-toggle" onclick="toggleSolution(this)">
                                <i class="fas fa-lightbulb"></i>
                                <span>Lihat Solusi</span>
                                <i class="fas fa-chevron-down toggle-icon"></i>
                            </div>
                            <div class="solution-content">
                                @if($history->treatment)
                                    <div class="solution-section">
                                        <div class="solution-header">
                                            <i class="fas fa-medkit"></i>
                                            <strong>Pengobatan:</strong>
                                        </div>
                                        <p>{{ $history->treatment }}</p>
                                    </div>
                                @endif
                                
                                @if($history->prevention)
                                    <div class="solution-section">
                                        <div class="solution-header">
                                            <i class="fas fa-shield-alt"></i>
                                            <strong>Pencegahan:</strong>
                                        </div>
                                        <p>{{ $history->prevention }}</p>
                                    </div>
                                @endif
                                
                                @if($history->solution && !$history->treatment && !$history->prevention)
                                    <div class="solution-section">
                                        <p>{{ $history->solution }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @else
                        <div class="healthy-info">
                            <div class="healthy-icon">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <div>
                                <strong>Tanaman Sehat!</strong>
                                <p>Tanaman dalam kondisi sehat. Lanjutkan perawatan yang baik.</p>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="history-actions">
                    <div class="status-badge {{ $history->is_healthy ? 'healthy' : 'diseased' }}">
                        <i class="fas {{ $history->is_healthy ? 'fa-check-circle' : 'fa-virus' }}"></i>
                        {{ $history->is_healthy ? 'Sehat' : 'Terinfeksi' }}
                    </div>
                    
                    <button type="button" class="delete-btn" onclick="deleteHistory({{ $history->id }})" title="Hapus Riwayat">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
            @endforeach
            
            <!-- Pagination if needed -->
            @if($histories instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="pagination-wrapper">
                    {{ $histories->links() }}
                </div>
            @endif
        @else
            <!-- Empty state -->
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-history"></i>
                </div>
                <h3>Belum Ada Riwayat</h3>
                <p>Mulai klasifikasi daun tomat untuk melihat riwayat di sini</p>
                <a href="{{ route('classification') }}" class="start-btn">
                    <i class="fas fa-camera"></i>
                    Mulai Klasifikasi
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
    </div>
@endif

<script>
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

document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
});
</script>

<style>
/* Page Styling */
.page {
    min-height: 100vh;
    padding: 20px;
}

.page-title {
    text-align: center;
    margin-bottom: 40px;
}

.page-title h1 {
    font-size: 2.5rem;
    font-weight: bold;
    color: #2d5a27;
    margin-bottom: 10px;
}

.title-underline {
    width: 80px;
    height: 4px;
    background: #4CAF50;
    margin: 0 auto 15px;
    border-radius: 2px;
}

.page-subtitle {
    color: #5a7c5a;
    font-size: 1.1rem;
    margin: 0;
}

/* History Container */
.history-container {
    max-width: 1200px;
    margin: 0 auto;
}

/* History Card */
.history-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    display: flex;
    gap: 20px;
    align-items: flex-start;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.history-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

/* Image Container */
.history-image-container {
    flex-shrink: 0;
    width: 120px;
    height: 120px;
    border-radius: 15px;
    overflow: hidden;
    background: #f0f0f0;
    border: 3px solid rgba(76, 175, 80, 0.2);
}

.history-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* History Content */
.history-content {
    flex: 1;
}

.history-header {
    margin-bottom: 20px;
}

.disease-name {
    font-size: 1.4rem;
    font-weight: bold;
    color: #2d5a27;
    margin: 0 0 10px 0;
}

.history-meta {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.accuracy-badge, .date-info {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
}

.accuracy-badge {
    background: linear-gradient(135deg, #4CAF50, #45a049);
    color: white;
}

.date-info {
    background: rgba(76, 175, 80, 0.1);
    color: #2d5a27;
}

/* Disease Details */
.disease-details {
    margin-bottom: 20px;
}

.info-item {
    margin-bottom: 15px;
}

.info-label {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 5px;
    color: #d32f2f;
}

.info-item p {
    margin: 0;
    color: #555;
    line-height: 1.5;
    padding-left: 25px;
}

/* Solution Toggle */
.solution-toggle {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 20px;
    background: linear-gradient(135deg, #FFC107, #FF9800);
    color: white;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-bottom: 15px;
    font-weight: 500;
}

.solution-toggle:hover {
    background: linear-gradient(135deg, #FF9800, #F57C00);
    transform: translateY(-2px);
}

.solution-toggle.active {
    background: linear-gradient(135deg, #FF9800, #F57C00);
}

.toggle-icon {
    margin-left: auto;
    transition: transform 0.3s ease;
}

/* Solution Content */
.solution-content {
    display: none;
    background: rgba(255, 193, 7, 0.1);
    border-radius: 15px;
    padding: 20px;
    margin-top: 10px;
    border-left: 4px solid #FFC107;
}

.solution-section {
    margin-bottom: 15px;
}

.solution-section:last-child {
    margin-bottom: 0;
}

.solution-header {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
    color: #FF9800;
}

.solution-section p {
    margin: 0;
    color: #555;
    line-height: 1.5;
    padding-left: 25px;
}

/* Healthy Info */
.healthy-info {
    display: flex;
    align-items: center;
    gap: 15px;
    background: linear-gradient(135deg, rgba(76, 175, 80, 0.1), rgba(129, 199, 132, 0.1));
    padding: 20px;
    border-radius: 15px;
    border-left: 4px solid #4CAF50;
}

.healthy-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #4CAF50, #45a049);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.healthy-info strong {
    color: #2d5a27;
    font-size: 1.1rem;
}

.healthy-info p {
    margin: 5px 0 0;
    color: #5a7c5a;
}

/* History Actions */
.history-actions {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
}

.status-badge {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 500;
    font-size: 0.9rem;
    white-space: nowrap;
}

.status-badge.healthy {
    background: linear-gradient(135deg, #4CAF50, #45a049);
    color: white;
}

.status-badge.diseased {
    background: linear-gradient(135deg, #f44336, #d32f2f);
    color: white;
}

.delete-btn {
    width: 45px;
    height: 45px;
    border: none;
    background: linear-gradient(135deg, #f44336, #d32f2f);
    color: white;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.delete-btn:hover {
    background: linear-gradient(135deg, #d32f2f, #b71c1c);
    transform: scale(1.1);
}

.delete-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 20px;
    backdrop-filter: blur(10px);
}

.empty-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 30px;
    background: linear-gradient(135deg, #e0e0e0, #bdbdbd);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: #757575;
}

.empty-state h3 {
    font-size: 1.8rem;
    color: #2d5a27;
    margin-bottom: 15px;
}

.empty-state p {
    color: #666;
    font-size: 1.1rem;
    margin-bottom: 30px;
}

.start-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 30px;
    background: linear-gradient(135deg, #4CAF50, #45a049);
    color: white;
    text-decoration: none;
    border-radius: 25px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.start-btn:hover {
    background: linear-gradient(135deg, #45a049, #388e3c);
    transform: translateY(-2px);
    color: white;
    text-decoration: none;
}

/* Alert Messages */
.alert {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 20px;
    border-radius: 10px;
    color: white;
    z-index: 1000;
    transition: opacity 0.3s ease;
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 300px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.alert-success {
    background: linear-gradient(135deg, #4CAF50, #45a049);
}

.alert-error {
    background: linear-gradient(135deg, #f44336, #d32f2f);
}

/* Pagination */
.pagination-wrapper {
    margin-top: 40px;
    text-align: center;
}

/* Responsive Design */
@media (max-width: 768px) {
    .history-card {
        flex-direction: column;
        text-align: center;
    }
    
    .history-image-container {
        width: 100px;
        height: 100px;
        margin: 0 auto;
    }
    
    .history-actions {
        flex-direction: row;
        justify-content: center;
    }
    
    .history-meta {
        justify-content: center;
    }
    
    .page-title h1 {
        font-size: 2rem;
    }
}

@media (max-width: 480px) {
    .page {
        padding: 15px;
    }
    
    .history-card {
        padding: 20px;
    }
    
    .history-image-container {
        width: 80px;
        height: 80px;
    }
    
    .disease-name {
        font-size: 1.2rem;
    }
}
</style>
@endsection