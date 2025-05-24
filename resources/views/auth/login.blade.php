<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - LeafGuard Tomato</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #a8e6a3 0%, #88d682 25%, #7dd87a 50%, #6bb66e 75%, #5a9c5a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background elements */
        .bg-decoration {
            position: absolute;
            opacity: 0.1;
            pointer-events: none;
        }

        .leaf1 {
            top: 10%;
            left: 10%;
            font-size: 60px;
            color: #2d5a2d;
            animation: float 6s ease-in-out infinite;
        }

        .leaf2 {
            top: 20%;
            right: 15%;
            font-size: 40px;
            color: #2d5a2d;
            animation: float 8s ease-in-out infinite reverse;
        }

        .leaf3 {
            bottom: 15%;
            left: 20%;
            font-size: 50px;
            color: #2d5a2d;
            animation: float 7s ease-in-out infinite;
        }

        .tomato1 {
            top: 60%;
            right: 10%;
            font-size: 35px;
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

        /* Navigation */
        .nav-container {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 100;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #2d5a2d;
            font-size: 24px;
            font-weight: bold;
        }

        .logo i {
            font-size: 28px;
            color: #4CAF50;
        }

        .nav-buttons {
            display: flex;
            gap: 15px;
        }

        .nav-btn {
            padding: 10px 20px;
            border: 2px solid #2d5a2d;
            background: transparent;
            color: #2d5a2d;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .nav-btn:hover {
            background: #2d5a2d;
            color: white;
            transform: translateY(-2px);
        }

        .nav-btn.active {
            background: #4CAF50;
            border-color: #4CAF50;
            color: white;
        }

        /* Login Container */
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            padding: 50px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 
                0 20px 40px rgba(0,0,0,0.1),
                0 0 0 1px rgba(255,255,255,0.2);
            position: relative;
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
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

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #4CAF50, #7dd87a, #4CAF50);
            animation: shimmer 2s linear infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200% center; }
            100% { background-position: 200% center; }
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header h1 {
            color: #2d5a2d;
            font-size: 2.2em;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #666;
            font-size: 1em;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 25px;
            position: relative;
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

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 25px;
        }

        .remember-me input[type="checkbox"] {
            width: auto;
            margin: 0;
            padding: 0;
        }

        .remember-me label {
            margin: 0;
            font-size: 0.9em;
            color: #666;
            cursor: pointer;
        }

        .login-btn {
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
            margin-top: 10px;
            position: relative;
            overflow: hidden;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .auth-links {
            margin-top: 25px;
            text-align: center;
        }

        .auth-links a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .auth-links a:hover {
            color: #2d5a2d;
            text-decoration: underline;
        }

        .divider {
            margin: 30px 0;
            text-align: center;
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

        /* Error messages */
        .auth-error, .alert-danger {
            background: #ffebee;
            color: #c62828;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            border-left: 4px solid #f44336;
            animation: shake 0.5s ease-in-out;
        }

        .field-error {
            color: #c62828;
            font-size: 0.85em;
            margin-top: 5px;
            display: block;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* Success messages */
        .alert-success {
            background: #e8f5e8;
            color: #2d5a2d;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            border-left: 4px solid #4CAF50;
            animation: fadeInDown 0.5s ease-out;
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
            .nav-container {
                padding: 15px;
            }
            
            .logo {
                font-size: 20px;
            }
            
            .nav-buttons {
                gap: 10px;
            }
            
            .nav-btn {
                padding: 8px 15px;
                font-size: 0.9em;
            }
            
            .login-container {
                margin: 20px;
                padding: 40px 30px;
            }
            
            .login-header h1 {
                font-size: 1.8em;
            }
            
            .bg-decoration {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 25px;
            }
            
            .form-group input {
                padding: 12px 15px 12px 45px;
            }
            
            .input-icon {
                left: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Background Decorations -->
    <div class="bg-decoration leaf1">🍃</div>
    <div class="bg-decoration leaf2">🌿</div>
    <div class="bg-decoration leaf3">🍃</div>
    <div class="bg-decoration tomato1">🍅</div>

    <!-- Navigation -->
    <div class="nav-container">
        <div class="logo">
            <i class="fas fa-leaf"></i>
            LEAFGUARD TOMATO
        </div>
        <div class="nav-buttons">
            <a href="{{ route('login') }}" class="nav-btn active">MASUK</a>
            <a href="{{ route('register') }}" class="nav-btn">DAFTAR</a>
        </div>
    </div>

    <!-- Login Form -->
    <div class="login-container">
        <div class="login-header">
            <h1>Masuk</h1>
            <p>Masuk ke akun LeafGuard Anda</p>
        </div>

        @if ($errors->any())
            <div class="alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div class="alert-success">
                <p><i class="fas fa-check-circle" style="margin-right: 8px;"></i>{{ session('success') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
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

            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">Ingat saya</label>
            </div>

            <button type="submit" class="login-btn">
                <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>
                MASUK
            </button>
        </form>

        <div class="divider">
            <span>atau</span>
        </div>

        <div class="auth-links">
            <a href="{{ route('register') }}">
                <i class="fas fa-user-plus" style="margin-right: 5px;"></i>
                Belum punya akun? Daftar di sini
            </a>
        </div>
    </div>

    <script>
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add focus animation to inputs
            const inputs = document.querySelectorAll('input[type="text"], input[type="email"], input[type="password"]');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });

            // Add ripple effect to button
            const button = document.querySelector('.login-btn');
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

            // Auto-hide success message after 5 seconds
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