<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - LeafGuard Tomato</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Simple Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <!-- Logo -->
            <a href="/" class="navbar-brand">
                <i class="fas fa-leaf"></i>
                <span class="brand-text">LEAFGUARD TOMATO</span>
            </a>
            
            <!-- Auth Buttons -->
            <div class="navbar-auth">
                <a href="{{ route('login') }}" class="btn-login active">MASUK</a>
                <a href="{{ route('register') }}" class="btn-register">DAFTAR</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-container">
        <!-- Background Decorations -->
        <div class="bg-decoration leaf1">🍃</div>
        <div class="bg-decoration leaf2">🌿</div>
        <div class="bg-decoration leaf3">🍃</div>
        <div class="bg-decoration tomato1">🍅</div>

        <!-- Login Form -->
        <div class="auth-container">
            <div class="auth-header">
                <h1>Masuk</h1>
                <p>Masuk ke akun LeafGuard Anda</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    <p><i class="fas fa-check-circle"></i>{{ session('success') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input id="email" type="email" name="email" 
                               value="{{ old('email') }}" 
                               class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                               placeholder="Masukkan email Anda" 
                               required autofocus>
                    </div>
                    @if ($errors->has('email'))
                        <span class="field-error">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input id="password" type="password" name="password" 
                               class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                               placeholder="Masukkan password Anda" 
                               required>
                    </div>
                    @if ($errors->has('password'))
                        <span class="field-error">{{ $errors->first('password') }}</span>
                    @endif
                </div>

                <div class="form-options">
                    <label class="checkbox-wrapper">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        Ingat saya
                    </label>
                </div>

                <button type="submit" class="auth-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    MASUK
                </button>
            </form>

            <div class="auth-footer">
                <div class="divider">
                    <span>atau</span>
                </div>
                <div class="auth-links">
                    <a href="{{ route('register') }}">
                        <i class="fas fa-user-plus"></i>
                        Belum punya akun? Daftar di sini
                    </a>
                </div>
            </div>
        </div>
    </main>

    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #a8e6a3 0%, #88d682 25%, #7dd87a 50%, #6bb66e 75%, #5a9c5a 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Navbar Styles */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #2d5a2d;
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.05);
            color: #2d5a2d;
        }

        .navbar-brand i {
            font-size: 28px;
            color: #4CAF50;
        }

        .brand-text {
            font-size: 24px;
            font-weight: bold;
            color: #2d5a2d;
        }

        .navbar-auth {
            display: flex;
            gap: 15px;
        }

      .btn-login, .btn-register {
    padding: 12px 25px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: bold;
    font-size: 14px;
    transition: all 0.3s ease;
    border: 2px solid #4CAF50;
}

.btn-login {
    background: #4CAF50;  /* Aktif - hijau */
    color: white;
}

.btn-login:hover {
    background: #45a049;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(76, 175, 80, 0.4);
}

.btn-register {
    color: #4CAF50;       /* Tidak aktif - putih dengan border hijau */
    background: transparent;
}

    .btn-register:hover {
    background: #4CAF50;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
}

        /* Main Container */
        .main-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 90px 20px 20px;
            position: relative;
        }

        /* Background Decorations */
        .bg-decoration {
            position: absolute;
            opacity: 0.1;
            pointer-events: none;
            font-size: 50px;
            color: #2d5a2d;
            animation: float 6s ease-in-out infinite;
        }

        .leaf1 {
            top: 15%;
            left: 10%;
            animation-delay: 0s;
        }

        .leaf2 {
            top: 25%;
            right: 15%;
            font-size: 35px;
            animation-delay: 2s;
        }

        .leaf3 {
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        .tomato1 {
            top: 60%;
            right: 10%;
            font-size: 30px;
            color: #ff6b6b;
            animation: bounce 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }

        /* Auth Container */
        .auth-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 
                0 20px 40px rgba(0,0,0,0.1),
                0 0 0 1px rgba(255,255,255,0.2);
            position: relative;
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        .auth-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #4CAF50, #7dd87a, #4CAF50);
            background-size: 200% 100%;
            animation: shimmer 2s linear infinite;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }

        /* Header */
        .auth-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .auth-header h1 {
            color: #2d5a2d;
            font-size: 2.2em;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .auth-header p {
            color: #666;
            font-size: 1em;
        }

        /* Form Styles */
        .auth-form {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2d5a2d;
            font-weight: 600;
            font-size: 0.95em;
        }

        .input-wrapper {
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 15px 20px 15px 50px;
            border: 2px solid #e8f5e8;
            border-radius: 15px;
            font-size: 1em;
            background: #fafffe;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-group input:focus {
            border-color: #4CAF50;
            background: white;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        .form-group input.is-invalid {
            border-color: #f44336;
            background: #ffebee;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #4CAF50;
            font-size: 1.1em;
        }

        /* Form Options */
        .form-options {
            margin-bottom: 25px;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-size: 0.9em;
            color: #666;
        }

        .checkbox-wrapper input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin: 0;
            padding: 0;
        }

        /* Auth Button */
        .auth-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #4CAF50, #66BB6A);
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .auth-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .auth-btn:hover::before {
            left: 100%;
        }

        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.3);
        }

        .auth-btn:active {
            transform: translateY(0);
        }

        /* Auth Footer */
        .auth-footer {
            text-align: center;
        }

        .divider {
            margin: 25px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e8f5e8;
        }

        .divider span {
            background: white;
            padding: 0 20px;
            color: #666;
            font-size: 0.9em;
        }

        .auth-links a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .auth-links a:hover {
            color: #2d5a2d;
            text-decoration: underline;
        }

        /* Alert Messages */
        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid;
            animation: fadeInDown 0.5s ease-out;
        }

        .alert-danger {
            background: #ffebee;
            color: #c62828;
            border-left-color: #f44336;
        }

        .alert-success {
            background: #e8f5e8;
            color: #2d5a2d;
            border-left-color: #4CAF50;
        }

        .alert i {
            margin-right: 8px;
        }

        .field-error {
            color: #c62828;
            font-size: 0.85em;
            margin-top: 5px;
            display: block;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar-container {
                padding: 0 15px;
            }
            
            .navbar-brand {
                font-size: 20px;
            }
            
            .navbar-brand i {
                font-size: 24px;
            }
            
            .brand-text {
                font-size: 20px;
            }
            
            .navbar-auth {
                gap: 10px;
            }
            
            .btn-login, .btn-register {
                padding: 10px 20px;
                font-size: 13px;
            }
            
            .main-container {
                padding: 90px 15px 15px;
            }
            
            .auth-container {
                padding: 30px 25px;
                max-width: 400px;
            }
            
            .auth-header h1 {
                font-size: 1.8em;
            }
            
            .bg-decoration {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .navbar-brand {
                font-size: 18px;
            }
            
            .navbar-brand i {
                font-size: 22px;
            }
            
            .brand-text {
                font-size: 16px;
            }
            
            .btn-login, .btn-register {
                padding: 8px 16px;
                font-size: 12px;
            }
            
            .auth-container {
                padding: 25px 20px;
            }
            
            .auth-header h1 {
                font-size: 1.6em;
            }
            
            .form-group input {
                padding: 12px 15px 12px 45px;
            }
            
            .input-icon {
                left: 15px;
            }
            
            .auth-btn {
                padding: 14px;
                font-size: 1em;
            }
        }

        @media (max-width: 360px) {
            .navbar-container {
                padding: 0 10px;
            }
            
            .navbar-brand {
                font-size: 16px;
            }
            
            .brand-text {
                font-size: 14px;
            }
            
            .btn-login, .btn-register {
                padding: 6px 12px;
                font-size: 11px;
            }
            
            .main-container {
                padding: 80px 10px 10px;
            }
            
            .auth-container {
                padding: 20px 15px;
            }
        }

        @media (max-width: 320px) {
            .brand-text {
                display: none;
            }
            
            .navbar-brand i {
                font-size: 24px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add focus animation to inputs
            const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });

            // Add ripple effect to button
            const button = document.querySelector('.auth-btn');
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.style.position = 'absolute';
                ripple.style.borderRadius = '50%';
                ripple.style.background = 'rgba(255,255,255,0.3)';
                ripple.style.transform = 'scale(0)';
                ripple.style.animation = 'ripple 0.6s linear';
                ripple.style.pointerEvents = 'none';
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });

            // Auto-hide success message
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                setTimeout(() => {
                    successAlert.style.transition = 'opacity 0.5s ease';
                    successAlert.style.opacity = '0';
                    setTimeout(() => {
                        successAlert.remove();
                    }, 500);
                }, 5000);
            }
        });

        // Add CSS for ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>