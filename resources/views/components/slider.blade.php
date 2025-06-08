{{-- slider.blade.php --}}
<div class="hero-slider">
    <div class="slider-container">
        <div class="slide active">
            <div class="slide-content">
                <div class="slide-text">
                    <h2>LEAFGUARD TOMATO</h2>
                    <p>LEAFGUARD-TOMATO adalah sistem klasifikasi otomatis berbasis deep learning yang dirancang khusus untuk membantu petani tomat di Indonesia dalam mengidentifikasi dan mengatasi penyakit daun tomat secara cepat, akurat, dan mudah.</p>
                    <button class="swipe-btn">SWIPE</button>
                </div>
                <div class="slide-image">
                    <img src="{{ asset('assets/images/foto.png') }}" alt="Tomato">
                </div>
            </div>
        </div>

        <div class="slide">
            <div class="slide-content">
                <div class="slide-text">
                    <h2>DETEKSI PENYAKIT AKURAT</h2>
                    <p>Menggunakan teknologi deep learning terdepan untuk mendeteksi berbagai jenis penyakit pada daun tomat dengan tingkat akurasi tinggi dan hasil yang dapat diandalkan.</p>
                    <button class="swipe-btn">SWIPE</button>
                </div>
                <div class="slide-image">
                    <img src="{{ asset('assets/images/foto1.jpeg') }}" alt="Tomato Plant">
                </div>
            </div>
        </div>
    </div>
    <button class="slider-nav prev"><i class="fas fa-chevron-left"></i></button>
    <button class="slider-nav next"><i class="fas fa-chevron-right"></i></button>
</div>
