@extends('layouts.app')

@section('title', 'Tentang - LeafGuard Tomato')

@section('content')
<div id="tentang" class="page active">
    <div class="page-title">
        <h1>TENTANG</h1>
        <div class="title-underline"></div>
    </div>
    
    <div class="about-content">
        <div class="about-section">
            <h2>Tentang LeafGuard Tomato</h2>
            <p>LEAFGUARD-TOMATO adalah sistem klasifikasi otomatis berbasis deep learning yang dirancang khusus untuk membantu petani Indonesia mengidentifikasi penyakit pada daun tomat secara cepat, akurat, dan mudah diakses. Sistem ini menggunakan teknologi Convolutional Neural Network (CNN) dengan framework TensorFlow untuk mengenali berbagai jenis penyakit umum pada daun tomat seperti early blight (Alternaria solani), late blight (Phytophthora infestans), dan leaf mold (Fulvia fulva).</p>
            <p>Melalui aplikasi web responsif yang dibangun dengan Laravel dan Vue.js, petani dapat mengunggah foto daun tomat menggunakan perangkat mobile mereka dan mendapatkan diagnosis serta rekomendasi penanganan dalam hitungan detik. Sistem ini dirancang dengan pendekatan mobile-first dan mendukung Progressive Web App (PWA) untuk memastikan aksesibilitas bahkan di daerah dengan koneksi internet terbatas.</p>
            <p>LEAFGUARD-TOMATO hadir sebagai respons terhadap permasalahan nyata dalam industri pertanian Indonesia, di mana kerugian hasil panen tomat akibat penyakit dapat mencapai 40-60% karena keterlambatan identifikasi dan penanganan yang tidak tepat.</p>
            
            <h3>Visi Kami</h3>
            <p>Menjadi solusi teknologi terdepan dalam bidang pertanian digital yang membantu meningkatkan produktivitas dan kualitas hasil panen tomat di Indonesia melalui sistem deteksi penyakit berbasis kecerdasan buatan yang mudah diakses oleh seluruh lapisan petani.</p>
            
            <h3>Misi Kami</h3>
            <ul>
                <li>Menyediakan teknologi AI yang mudah diakses untuk petani</li>
                <li>Meningkatkan efisiensi deteksi penyakit tanaman</li>
                <li>Membantu mengurangi kerugian hasil panen akibat penyakit</li>
                <li>Mendukung pertanian berkelanjutan di Indonesia</li>
            </ul>
        </div>
        
        <div class="team-section">
            <h2>Tim Pengembang</h2>
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4>Muhammad Ihsan</h4>
                    <p>Front-End Developer</p>
                </div>
                <div class="team-member">
                    <div class="member-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4>Yusuf Alfarabi Natawiyanta</h4>
                    <p>Back-End Developer</p>
                </div>
                <div class="team-member">
                    <div class="member-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4>Anwar</h4>
                    <p>Full Stack Developer</p>
                </div>
                <div class="team-member">
                    <div class="member-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4>Christofel A Simbolon</h4>
                    <p>Machine Learning</p>
                </div>
                <div class="team-member">
                    <div class="member-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4>Henry Dwi Prana Sitepu</h4>
                    <p>Machine Learning</p>
                </div>
                <div class="team-member">
                    <div class="member-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h4>Andika Syarif Hidayatullah</h4>
                    <p>Machine Learning</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection