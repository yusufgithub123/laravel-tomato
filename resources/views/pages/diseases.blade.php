@extends('layouts.app')

@section('title', 'Penyakit - LeafGuard Tomato')

@section('content')
<div id="penyakit" class="page active">
    <div class="page-title">
        <h1>PENYAKIT</h1>
        <div class="title-underline"></div>
    </div>
    
    <div class="disease-grid">
        <div class="disease-card" onclick="openModal('early-blight')">
            <img src="{{ asset('assets/images/v1.jpeg') }}" alt="Early Blight">
            <h3>Early Blight</h3>
            <p>Penyakit yang disebabkan oleh jamur Alternaria solani, ditandai dengan bercak coklat gelap dengan cincin konsentris.</p>
        </div>
        
        <div class="disease-card" onclick="openModal('late-blight')">
            <img src="{{ asset('assets/images/v2.jpeg') }}" alt="Late Blight">
            <h3>Late Blight</h3>
            <p>Disebabkan oleh Phytophthora infestans, menyebabkan bercak coklat kehitaman yang cepat menyebar.</p>
        </div>
        
        <!-- Tambahkan penyakit lainnya dengan pola yang sama -->
    </div>
</div>

<!-- Modal untuk detail penyakit -->
<div id="diseaseModal" class="modal">
    <div class="modal-content">
        <span class="close-modal" onclick="closeModal()">&times;</span>
        <div id="modalContent"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function openModal(diseaseId) {
    const modal = document.getElementById('diseaseModal');
    const modalContent = document.getElementById('modalContent');
    
    // Data penyakit (bisa juga diambil dari backend)
    const diseases = {
        'early-blight': {
            title: 'Early Blight',
            image: '{{ asset("assets/images/v1.jpeg") }}',
            description: 'Penyakit yang disebabkan oleh jamur Alternaria solani...',
            treatment: 'Pengobatan: Gunakan fungisida yang sesuai...'
        },
        'late-blight': {
            title: 'Late Blight',
            image: '{{ asset("assets/images/v2.jpeg") }}',
            description: 'Disebabkan oleh Phytophthora infestans...',
            treatment: 'Pengobatan: Gunakan fungisida sistemik...'
        }
        // Tambahkan data penyakit lainnya
    };
    
    const disease = diseases[diseaseId];
    modalContent.innerHTML = `
        <h2>${disease.title}</h2>
        <img src="${disease.image}" alt="${disease.title}" style="max-width: 100%; height: auto; border-radius: 10px; margin: 15px 0;">
        <p>${disease.description}</p>
        <p><strong>${disease.treatment}</strong></p>
    `;
    
    modal.style.display = 'block';
}

function closeModal() {
    document.getElementById('diseaseModal').style.display = 'none';
}

// Tutup modal ketika klik di luar konten modal
window.onclick = function(event) {
    const modal = document.getElementById('diseaseModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>

<style>
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.7);
}

.modal-content {
    background-color: #fff;
    margin: 5% auto;
    padding: 30px;
    border-radius: 15px;
    width: 80%;
    max-width: 700px;
    box-shadow: 0 5px 30px rgba(0,0,0,0.3);
    position: relative;
}

.close-modal {
    position: absolute;
    right: 20px;
    top: 10px;
    font-size: 28px;
    font-weight: bold;
    color: #aaa;
    cursor: pointer;
}

.close-modal:hover {
    color: #333;
}
</style>
@endsection