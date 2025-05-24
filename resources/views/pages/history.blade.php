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
                    <img src="{{ asset('storage/' . $history->image_path) }}" alt="Scan Result">
                </div>
                <div class="history-info">
                    <h3>{{ $history->disease_name }}</h3>
                    <p>Tingkat Akurasi: {{ number_format($history->accuracy, 0) }}%</p>
                    <span class="history-date">{{ $history->created_at->format('d M Y, H:i') }}</span>
                    @if(!$history->is_healthy && $history->solution)
                        <div class="solution-toggle" onclick="toggleSolution(this)">
                            <i class="fas fa-lightbulb"></i> Lihat Solusi
                        </div>
                        <div class="solution-content" style="display: none;">
                            <p>{{ $history->solution }}</p>
                        </div>
                    @endif
                </div>
                <div class="history-status">
                    <span class="status-badge {{ $history->is_healthy ? 'status-healthy' : 'status-diseased' }}">
                        {{ $history->is_healthy ? 'Sehat' : 'Terinfeksi' }}
                    </span>
                    <form method="POST" action="{{ route('history.destroy', $history->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-history" onclick="return confirm('Apakah Anda yakin ingin menghapus riwayat ini?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        @else
            <!-- Data contoh jika belum ada data dari database -->
            <div class="history-item">
                <div class="history-image">
                    <img src="{{ asset('assets/images/v1.jpeg') }}" alt="Scan Result">
                </div>
                <div class="history-info">
                    <h3>Early Blight</h3>
                    <p>Tingkat Akurasi: 95%</p>
                    <span class="history-date">23 Mei 2025, 14:30</span>
                    <div class="solution-toggle" onclick="toggleSolution(this)">
                        <i class="fas fa-lightbulb"></i> Lihat Solusi
                    </div>
                    <div class="solution-content" style="display: none;">
                        <p>Gunakan fungisida yang sesuai dan kurangi kelembaban di sekitar tanaman.</p>
                    </div>
                </div>
                <div class="history-status">
                    <span class="status-badge status-diseased">Terinfeksi</span>
                    <button class="delete-history" onclick="deleteHistory(1)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            
            <div class="history-item">
                <div class="history-image">
                    <img src="{{ asset('assets/images/v11.jpeg') }}" alt="Scan Result">
                </div>
                <div class="history-info">
                    <h3>Daun Sehat</h3>
                    <p>Tingkat Akurasi: 98%</p>
                    <span class="history-date">22 Mei 2025, 09:15</span>
                </div>
                <div class="history-status">
                    <span class="status-badge status-healthy">Sehat</span>
                    <button class="delete-history" onclick="deleteHistory(2)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            
            <div class="history-item">
                <div class="history-image">
                    <img src="{{ asset('assets/images/v3.jpeg') }}" alt="Scan Result">
                </div>
                <div class="history-info">
                    <h3>Bacterial Spot</h3>
                    <p>Tingkat Akurasi: 87%</p>
                    <span class="history-date">21 Mei 2025, 16:45</span>
                    <div class="solution-toggle" onclick="toggleSolution(this)">
                        <i class="fas fa-lightbulb"></i> Lihat Solusi
                    </div>
                    <div class="solution-content" style="display: none;">
                        <p>Gunakan bakterisida tembaga dan hindari penyiraman dari atas.</p>
                    </div>
                </div>
                <div class="history-status">
                    <span class="status-badge status-diseased">Terinfeksi</span>
                    <button class="delete-history" onclick="deleteHistory(3)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        @endif

        @if(isset($histories) && $histories->count() == 0)
            <div class="empty-history">
                <i class="fas fa-history"></i>
                <h3>Belum ada riwayat</h3>
                <p>Mulai klasifikasi daun tomat untuk melihat riwayat di sini</p>
                <a href="{{ route('classification') }}" class="btn-classify">Mulai Klasifikasi</a>
            </div>
        @endif
    </div>
</div>

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

function deleteHistory(id) {
    if (confirm('Apakah Anda yakin ingin menghapus riwayat ini?')) {
        // Simulasi penghapusan untuk data contoh
        const item = document.querySelector(`.history-item button[onclick="deleteHistory(${id})"]`).closest('.history-item');
        item.style.animation = 'fadeOut 0.5s ease';
        setTimeout(() => item.remove(), 500);
    }
}
</script>

<style>
.history-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.history-item {
    display: flex;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
    overflow: hidden;
    transition: all 0.3s ease;
    animation: fadeIn 0.5s ease;
}

.history-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.history-image {
    width: 150px;
    height: 150px;
    overflow: hidden;
    flex-shrink: 0;
}

.history-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.history-info {
    flex-grow: 1;
    padding: 15px;
}

.history-info h3 {
    margin: 0 0 5px 0;
    color: #2d5a2d;
}

.history-info p {
    margin: 5px 0;
    color: #666;
}

.history-date {
    font-size: 0.9em;
    color: #888;
}

.history-status {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 15px;
    min-width: 100px;
}

.status-badge {
    display: inline-block !important;
    padding: 6px 12px !important;
    border-radius: 20px !important;
    font-size: 0.85em !important;
    font-weight: bold !important;
    color: white !important;
    text-align: center !important;
    white-space: nowrap !important;
    margin-bottom: 10px !important;
    min-width: 70px !important;
}

.status-badge.status-healthy {
    background-color: #4CAF50 !important;
}

.status-badge.status-diseased {
    background-color: #f44336 !important;
}

.solution-toggle {
    color: #4CAF50;
    cursor: pointer;
    margin-top: 10px;
    font-weight: bold;
    display: flex;
    align-items: center;
    gap: 8px;
}

.solution-toggle:hover {
    color: #45a049;
}

.solution-content {
    background: rgba(76, 175, 80, 0.1);
    padding: 15px;
    border-radius: 10px;
    margin-top: 10px;
    border-left: 4px solid #4CAF50;
}

.delete-history {
    background: transparent !important;
    border: none !important;
    color: #f44336 !important;
    cursor: pointer !important;
    font-size: 1.2em !important;
    padding: 5px !important;
    border-radius: 3px !important;
    transition: all 0.3s ease !important;
}

.delete-history:hover {
    background-color: rgba(244, 67, 54, 0.1) !important;
    transform: scale(1.1) !important;
}

.empty-history {
    text-align: center;
    padding: 60px 20px;
    color: #666;
}

.empty-history i {
    font-size: 4em;
    color: #ddd;
    margin-bottom: 20px;
}

.empty-history h3 {
    color: #2d5a2d;
    margin-bottom: 10px;
}

.btn-classify {
    display: inline-block;
    padding: 12px 24px;
    background: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 25px;
    margin-top: 20px;
    transition: all 0.3s ease;
}

.btn-classify:hover {
    background: #45a049;
    transform: translateY(-2px);
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeOut {
    from { opacity: 1; transform: translateY(0); }
    to { opacity: 0; transform: translateY(-10px); }
}

/* Media Query untuk responsivitas */
@media (max-width: 768px) {
    .history-item {
        flex-direction: column;
    }
    
    .history-image {
        width: 100%;
        height: 200px;
    }
    
    .history-status {
        flex-direction: row;
        justify-content: space-between;
        padding: 10px 15px;
    }
}
</style>
@endsection