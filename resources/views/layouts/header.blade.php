{{-- header.blade.php --}}
<header class="header">
    <div class="container">
        <div class="logo">
            <i class="fas fa-leaf"></i>
            <span>LEAFGUARD TOMATO</span>
        </div>
        
        <button class="hamburger-menu" id="hamburgerBtn">
            <span></span>
            <span></span>
            <span></span>
        </button>
        
        <div class="auth-buttons">
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-masuk">LOGOUT</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-masuk">MASUK</a>
                <a href="{{ route('register') }}" class="btn-daftar">DAFTAR</a>
            @endauth
        </div>
    </div>
</header>

<nav class="nav-container">
    <div class="nav-pills" id="navMenu">
        <a href="{{ route('home') }}" class="nav-pill {{ request()->routeIs('home') ? 'active' : '' }}" data-page="beranda">BERANDA</a>
        <a href="{{ route('classification') }}" class="nav-pill {{ request()->routeIs('classification') ? 'active' : '' }}" data-page="klasifikasi">KLASIFIKASI</a>
        <a href="{{ route('diseases') }}" class="nav-pill {{ request()->routeIs('diseases') ? 'active' : '' }}" data-page="penyakit">PENYAKIT</a>
        <a href="{{ route('guide') }}" class="nav-pill {{ request()->routeIs('guide') ? 'active' : '' }}" data-page="panduan">PANDUAN</a>
        <a href="{{ route('history') }}" class="nav-pill {{ request()->routeIs('history') ? 'active' : '' }}" data-page="riwayat">RIWAYAT</a>
        <a href="{{ route('about') }}" class="nav-pill {{ request()->routeIs('about') ? 'active' : '' }}" data-page="tentang">TENTANG</a>
        <a href="{{ route('contact') }}" class="nav-pill {{ request()->routeIs('contact') ? 'active' : '' }}" data-page="kontak">KONTAK</a>
    </div>
    
    <!-- Mobile auth section will be added dynamically by JavaScript -->
</nav>
