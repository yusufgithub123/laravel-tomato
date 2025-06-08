{{-- diseases.blade.php --}}
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
        
        <div class="disease-card" onclick="openModal('bacterial-spot')">
            <img src="{{ asset('assets/images/v3.jpeg') }}" alt="Bacterial Spot">
            <h3>Bacterial Spot</h3>
            <p>Infeksi bakteri yang menyebabkan bercak kecil berwarna coklat tua dengan halo kuning di sekitarnya.</p>
        </div>
        
        <div class="disease-card" onclick="openModal('septoria-leaf-spot')">
            <img src="{{ asset('assets/images/v4.jpeg') }}" alt="Septoria Leaf Spot">
            <h3>Septoria Leaf Spot</h3>
            <p>Bercak kecil bulat dengan pusat berwarna abu-abu dan tepi coklat gelap, disebabkan oleh jamur Septoria.</p>
        </div>
        
        <div class="disease-card" onclick="openModal('tylcv')">
            <img src="{{ asset('assets/images/v5.jpeg') }}" alt="TYLCV">
            <h3>Tomato Yellow Leaf Curl Virus</h3>
            <p>Virus yang ditularkan oleh kutu kebul (Bemisia tabaci), menyebabkan daun menguning dan menggulung.</p>
        </div>
        
        <div class="disease-card" onclick="openModal('target-spot')">
            <img src="{{ asset('assets/images/v6.jpeg') }}" alt="Target Spot">
            <h3>Target Spot</h3>
            <p>Penyakit jamur yang menyebabkan bercak dengan pola cincin konsentris seperti target.</p>
        </div>
        
        <div class="disease-card" onclick="openModal('tomato-mosaic')">
            <img src="{{ asset('assets/images/v7.jpeg') }}" alt="Tomato Mosaic Virus">
            <h3>Tomato Mosaic Virus</h3>
            <p>Virus yang menyebabkan pola mozaik pada daun dengan warna hijau muda dan hijau tua.</p>
        </div>
        
        <div class="disease-card" onclick="openModal('leaf-mold')">
            <img src="{{ asset('assets/images/v8.jpeg') }}" alt="Leaf Mold">
            <h3>Leaf Mold</h3>
            <p>Jamur yang menyerang daun bagian bawah, menyebabkan lapisan berbulu dan bercak kuning.</p>
        </div>
        
        <div class="disease-card" onclick="openModal('spider-mites')">
            <img src="{{ asset('assets/images/v9.jpeg') }}" alt="Spider Mites">
            <h3>Spider Mites Two-spotted</h3>
            <p>Tungau kecil yang menyebabkan bintik-bintik kuning pada daun dan jaring halus.</p>
        </div>
        
        <div class="disease-card" onclick="openModal('powdery-mildew')">
            <img src="{{ asset('assets/images/v10.jpeg') }}" alt="Powdery Mildew">
            <h3>Powdery Mildew</h3>
            <p>Jamur yang membentuk lapisan putih seperti tepung pada permukaan daun.</p>
        </div>
        
        <div class="disease-card" onclick="openModal('healthy')">
            <img src="{{ asset('assets/images/v12.jpeg') }}" alt="Healthy">
            <h3>Daun Sehat</h3>
            <p>Daun tomat yang sehat menunjukkan warna hijau segar dan pertumbuhan normal.</p>
        </div>
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