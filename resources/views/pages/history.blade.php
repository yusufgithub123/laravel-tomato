{{-- history.blade.php --}}
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
    <div class="solution-toggle">
        <i class="fas fa-lightbulb"></i>
        <span>Lihat Solusi</span>
        <i class="fas fa-chevron-down toggle-icon"></i>
    </div>
    <div class="solution-content">
        @if($history->treatment)
            <div class="solution-section" data-type="treatment">
                <div class="solution-header">
                    <i class="fas fa-medkit"></i>
                    <strong>Pengobatan:</strong>
                </div>
                <p>{{ $history->treatment }}</p>
            </div>
        @endif
        
        @if($history->prevention)
            <div class="solution-section" data-type="prevention">
                <div class="solution-header">
                    <i class="fas fa-shield-alt"></i>
                    <strong>Pencegahan:</strong>
                </div>
                <p>{{ $history->prevention }}</p>
            </div>
        @endif
        
        @if($history->solution && !$history->treatment && !$history->prevention)
            <div class="solution-section">
                <div class="solution-header">
                    <i class="fas fa-lightbulb"></i>
                    <strong>Solusi:</strong>
                </div>
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
@endsection
