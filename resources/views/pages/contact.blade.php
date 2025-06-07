@extends('layouts.app')

@section('title', 'Kontak - LeafGuard Tomato')

@section('content')
<div id="kontak" class="page active">
    <div class="page-title">
        <h1>KONTAK</h1>
        <div class="title-underline"></div>
    </div>
    
    <div class="contact-wrapper">
        <div class="contact-content">
            <div class="contact-info">
                <div class="info-header">
                    <h2>Hubungi Kami</h2>
                    <p>Kami siap membantu Anda dengan segala kebutuhan terkait deteksi penyakit tanaman</p>
                </div>
                
                <div class="contact-items">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <span class="contact-label">Email</span>
                            <span class="contact-value">leafguardtomato@gmail.com</span>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-details">
                            <span class="contact-label">Telepon</span>
                            <span class="contact-value">+62 831-1431-6390</span>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <span class="contact-label">Lokasi</span>
                            <span class="contact-value">Banjarmasin, Indonesia</span>
                        </div>
                    </div>
                </div>
                
                <div class="social-media">
                    <h3>Ikuti Kami</h3>
                    <div class="social-links">
                        <a href="#" class="social-link whatsapp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="social-link facebook">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="social-link instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Animasi dan efek interaktif
document.addEventListener('DOMContentLoaded', function() {
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
});
</script>
@endsection