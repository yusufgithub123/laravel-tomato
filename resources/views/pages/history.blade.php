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
            <div class="history-item">
                <div class="history-image">
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
                <div class="history-info">
                    <h3>{{ $history->disease_name ?? 'Unknown Disease' }}</h3>
                    <p>Tingkat Akurasi: {{ number_format($history->accuracy ?? 0, 0) }}%</p>
                    <span class="history-date">{{ $history->created_at->format('d M Y, H:i') }}</span>
                    
                    @if(!$history->is_healthy)
                        <!-- Display disease information if not healthy -->
                        @if($history->symptoms)
                            <div class="disease-info">
                                <strong>Gejala:</strong> {{ $history->symptoms }}
                            </div>
                        @endif
                        
                        @if($history->causes)
                            <div class="disease-info">
                                <strong>Penyebab:</strong> {{ $history->causes }}
                            </div>
                        @endif
                        
                        <!-- Solution -->
                        @if($history->treatment || $history->prevention || $history->solution)
                            <div class="solution-toggle" onclick="toggleSolution(this)">
                                <i class="fas fa-lightbulb"></i> Lihat Solusi
                            </div>
                            <div class="solution-content" style="display: none;">
                                @if($history->treatment)
                                    <div class="solution-section">
                                        <strong>Pengobatan:</strong>
                                        <p>{{ $history->treatment }}</p>
                                    </div>
                                @endif
                                
                                @if($history->prevention)
                                    <div class="solution-section">
                                        <strong>Pencegahan:</strong>
                                        <p>{{ $history->prevention }}</p>
                                    </div>
                                @endif
                                
                                @if($history->solution && !$history->treatment && !$history->prevention)
                                    <p>{{ $history->solution }}</p>
                                @endif
                            </div>
                        @endif
                    @else
                        <div class="healthy-info">
                            <p><i class="fas fa-leaf text-green"></i> Tanaman dalam kondisi sehat! Lanjutkan perawatan yang baik.</p>
                        </div>
                    @endif
                </div>
                <div class="history-status">
    <span class="status-badge {{ $history->is_healthy ? 'healthy' : 'diseased' }}">
        {{ $history->is_healthy ? 'Sehat' : 'Terinfeksi' }}
    </span>
    
    {{-- Opsi 1: Menggunakan AJAX untuk delete (Recommended) --}}
    <button type="button" class="delete-history" onclick="deleteHistory({{ $history->id }})">
        <i class="fas fa-trash"></i>
    </button>
    
    {{-- Opsi 2: Form dengan redirect yang benar --}}
    {{-- 
    <form method="POST" action="{{ route('history.destroy', $history->id) }}" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus riwayat ini?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="delete-history">
            <i class="fas fa-trash"></i>
        </button>
    </form>
    --}}
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
            <div class="empty-history">
                <i class="fas fa-history"></i>
                <h3>Belum ada riwayat</h3>
                <p>Mulai klasifikasi daun tomat untuk melihat riwayat di sini</p>
                <a href="{{ route('classification') }}" class="btn-primary">Mulai Klasifikasi</a>
            </div>
        @endif
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
@endif

<script>
    function toggleSolution(element) {
    const solutionContent = element.nextElementSibling;
    if (solutionContent.style.display === 'none') {
        solutionContent.style.display = 'block';
        element.innerHTML = '<i class="fas fa-lightbulb"></i> Sembunyikan Solusi';
    } else {
        solutionContent.style.display = 'none';
        element.innerHTML = '<i class="fas fa-lightbulb"></i> Lihat Solusi';
    }
}

// Function untuk delete history dengan AJAX
function deleteHistory(historyId) {
    if (!confirm('Apakah Anda yakin ingin menghapus riwayat ini?')) {
        return;
    }
    
    // Show loading state
    const deleteBtn = event.target.closest('.delete-history');
    const originalContent = deleteBtn.innerHTML;
    deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    deleteBtn.disabled = true;
    
    // Send AJAX request
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
            // Remove the history item from DOM
            deleteBtn.closest('.history-item').remove();
            
            // Show success message
            showAlert('success', data.message || 'Riwayat berhasil dihapus');
            
            // Check if no more history items
            if (document.querySelectorAll('.history-item').length === 0) {
                location.reload(); // Reload to show empty state
            }
        } else {
            // Show error message
            showAlert('error', data.message || 'Gagal menghapus riwayat');
            
            // Restore button
            deleteBtn.innerHTML = originalContent;
            deleteBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan saat menghapus riwayat');
        
        // Restore button
        deleteBtn.innerHTML = originalContent;
        deleteBtn.disabled = false;
    });
}

// Function untuk show alert
function showAlert(type, message) {
    // Remove existing alerts
    document.querySelectorAll('.alert').forEach(alert => alert.remove());
    
    // Create new alert
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    alert.textContent = message;
    
    // Add to page
    document.body.appendChild(alert);
    
    // Auto hide after 5 seconds
    setTimeout(() => {
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 300);
    }, 5000);
}

// Auto-hide messages after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
});
function toggleSolution(element) {
    const solutionContent = element.nextElementSibling;
    if (solutionContent.style.display === 'none') {
        solutionContent.style.display = 'block';
        element.innerHTML = '<i class="fas fa-lightbulb"></i> Sembunyikan Solusi';
    } else {
        solutionContent.style.display = 'none';
        element.innerHTML = '<i class="fas fa-lightbulb"></i> Lihat Solusi';
    }
}

// Auto-hide messages after 5 seconds
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
.alert {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 20px;
    border-radius: 5px;
    color: white;
    z-index: 1000;
    transition: opacity 0.3s ease;
}

.alert-success {
    background-color: #4CAF50;
}

.alert-error {
    background-color: #f44336;
}

.text-green {
    color: #4CAF50;
}

.healthy-info {
    background-color: #e8f5e8;
    padding: 10px;
    border-radius: 5px;
    margin-top: 10px;
}

.pagination-wrapper {
    margin-top: 30px;
    text-align: center;
}
</style>
@endsection