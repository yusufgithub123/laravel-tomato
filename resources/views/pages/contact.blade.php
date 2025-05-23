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
            
            <div class="contact-form">
                <div class="form-header">
                    <h2>Kirim Pesan</h2>
                    <p>Sampaikan pertanyaan atau masukan Anda kepada kami</p>
                </div>
                
                <form class="modern-form" method="POST" action="{{ route('contact.submit') }}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Nama Lengkap" required>
                            <label>Nama Lengkap</label>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Email" required>
                            <label>Email</label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="subject" placeholder="Subjek" required>
                        <label>Subjek</label>
                    </div>
                    
                    <div class="form-group">
                        <textarea name="message" placeholder="Pesan Anda" rows="5" required></textarea>
                        <label>Pesan Anda</label>
                    </div>
                    
                    <button type="submit" class="submit-btn">
                        <span>Kirim Pesan</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.querySelector('.modern-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const submitBtn = form.querySelector('.submit-btn');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<span>Mengirim...</span>';
    submitBtn.disabled = true;
    
    // Simpan data form
    const formData = new FormData(form);
    
    // Kirim data ke server (simulasi)
    setTimeout(() => {
        alert('Pesan berhasil dikirim! Kami akan segera menghubungi Anda.');
        form.reset();
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 2000);
    
    // Untuk implementasi nyata, gunakan fetch API atau AJAX
    /*
    fetch(form.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        form.reset();
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    })
    .catch(error => {
        console.error('Error:', error);
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
    */
});
</script>
@endsection