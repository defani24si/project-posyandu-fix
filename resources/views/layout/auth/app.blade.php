<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Sistem Informasi Posyandu</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ===== VARIABLES POSYANDU - TEMA BIRU ===== */
        :root {
            --posyandu-primary: #007bff; /* Biru utama sesuai AdminLTE */
            --posyandu-primary-dark: #0056b3; /* Biru gelap */
            --posyandu-primary-light: #cce5ff; /* Biru muda untuk sidebar */
            --posyandu-secondary: #6c757d;
            --posyandu-success: #28a745;
            --posyandu-light: #f8f9fa;
            --posyandu-white: #ffffff;
            --posyandu-shadow: rgba(0, 123, 255, 0.15);
        }

        /* ===== RESET & BASE ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', 'Roboto', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e3f2fd 50%, #bbdefb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            line-height: 1.6;
            color: #333;
            font-size: 14px;
            position: relative;
            overflow-x: hidden;
        }

        /* Background Pattern */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(0, 123, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(0, 123, 255, 0.05) 0%, transparent 50%);
            z-index: -1;
        }

        /* ===== LOGIN CONTAINER ===== */
        .login-container {
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
            z-index: 1;
        }

        /* ===== LOGIN CARD ===== */
        .login-card {
            background: var(--posyandu-white);
            border-radius: 16px;
            box-shadow: 
                0 20px 40px rgba(0, 0, 0, 0.1),
                0 8px 16px rgba(0, 123, 255, 0.1);
            overflow: hidden;
            transition: all 0.4s ease;
            border: 1px solid rgba(0, 123, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.15),
                0 12px 24px rgba(0, 123, 255, 0.2);
        }

        /* ===== CARD HEADER - GRADIENT BIRU ===== */
        .card-header {
            background: linear-gradient(135deg, var(--posyandu-primary) 0%, var(--posyandu-primary-dark) 100%);
            color: white;
            padding: 2.5rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            opacity: 0.6;
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .header-icon {
            position: relative;
            z-index: 2;
            font-size: 3rem;
            margin-bottom: 1rem;
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            width: 90px;
            height: 90px;
            line-height: 90px;
            border-radius: 50%;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .card-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 2;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            letter-spacing: -0.5px;
        }

        .card-header p {
            font-size: 1rem;
            opacity: 0.95;
            position: relative;
            z-index: 2;
            font-weight: 400;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* ===== CARD BODY ===== */
        .card-body {
            padding: 2.5rem 2rem;
        }

        /* ===== FORM ===== */
        .form-group {
            margin-bottom: 1.75rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.75rem;
            font-weight: 600;
            color: #495057;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
        }

        .form-label i {
            color: var(--posyandu-primary);
            margin-right: 0.5rem;
        }

        .input-group {
            display: flex;
            border-radius: 10px;
            overflow: hidden;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            background: white;
            position: relative;
        }

        .input-group:focus-within {
            border-color: var(--posyandu-primary);
            box-shadow: 0 0 0 4px var(--posyandu-shadow);
            transform: translateY(-2px);
        }

        .input-group-text {
            background: #f8f9fa;
            border: none;
            padding: 1rem;
            color: var(--posyandu-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 50px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .input-group:focus-within .input-group-text {
            background: var(--posyandu-primary-light);
            color: var(--posyandu-primary-dark);
        }

        .form-control {
            flex: 1;
            border: none;
            padding: 1rem 1.25rem;
            font-size: 1rem;
            outline: none;
            background: white;
            color: #495057;
            font-weight: 500;
        }

        .form-control::placeholder {
            color: #adb5bd;
            font-weight: 400;
        }

        .password-toggle {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .password-toggle:hover {
            background: var(--posyandu-primary-light);
            color: var(--posyandu-primary-dark);
        }

        /* ===== CHECKBOX & FORGOT PASSWORD ===== */
        .form-check {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            padding: 0.5rem 0;
        }

        .form-check-content {
            display: flex;
            align-items: center;
        }

        .form-check-input {
            margin-right: 0.75rem;
            width: 1.2rem;
            height: 1.2rem;
            cursor: pointer;
            accent-color: var(--posyandu-primary);
            border-radius: 4px;
        }

        .form-check-label {
            font-size: 0.95rem;
            color: #6c757d;
            cursor: pointer;
            font-weight: 500;
        }

        .forgot-password {
            font-size: 0.9rem;
            color: var(--posyandu-primary);
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
        }

        .forgot-password:hover {
            color: var(--posyandu-primary-dark);
            background: var(--posyandu-primary-light);
            text-decoration: none;
        }

        /* ===== BUTTON - GRADIENT BIRU ===== */
        .btn {
            display: block;
            width: 100%;
            padding: 1rem 1.5rem;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--posyandu-primary) 0%, var(--posyandu-primary-dark) 100%);
            color: white;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 1rem;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--posyandu-primary-dark) 0%, #003d82 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4);
        }

        .btn-primary:active {
            transform: translateY(-1px);
        }

        /* ===== DIVIDER ===== */
        .divider {
            display: flex;
            align-items: center;
            margin: 2rem 0;
            color: #6c757d;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 2px;
            background: linear-gradient(90deg, transparent, #e9ecef, transparent);
        }

        .divider span {
            padding: 0 1.5rem;
            background: white;
            color: var(--posyandu-primary);
            font-weight: 600;
        }

        /* ===== SOCIAL LOGIN ===== */
        .social-login {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .social-btn {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .social-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .social-btn:hover::before {
            opacity: 1;
        }

        .social-btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .social-btn-facebook {
            background: linear-gradient(135deg, #1877f2, #0d5dbf);
        }

        .social-btn-twitter {
            background: linear-gradient(135deg, #1da1f2, #0d8bd9);
        }

        .social-btn-github {
            background: linear-gradient(135deg, #333, #1a1a1a);
        }

        /* ===== REGISTER LINK ===== */
        .register-link {
            text-align: center;
            font-size: 1rem;
            color: #6c757d;
            margin-top: 2rem;
            font-weight: 500;
        }

        .register-link a {
            color: var(--posyandu-primary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
        }

        .register-link a:hover {
            color: var(--posyandu-primary-dark);
            background: var(--posyandu-primary-light);
            text-decoration: none;
        }

        /* ===== ALERTS ===== */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            font-size: 0.95rem;
            border: 1px solid transparent;
            font-weight: 500;
            display: flex;
            align-items: flex-start;
        }

        .alert i {
            margin-right: 0.75rem;
            margin-top: 0.1rem;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da, #f1aeb5);
            border-color: #f5c6cb;
            color: #721c24;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            border-color: #c3e6cb;
            color: #155724;
        }



        /* ===== FOOTER ===== */
        .card-footer {
            padding: 2rem;
            border-top: 1px solid #e9ecef;
            text-align: center;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            font-size: 0.85rem;
            color: #6c757d;
        }

        .card-footer p {
            margin-bottom: 0.75rem;
            font-weight: 500;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-top: 0.75rem;
        }

        .footer-links a {
            color: #6c757d;
            text-decoration: none;
            font-size: 0.8rem;
            transition: all 0.3s ease;
            font-weight: 500;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
        }

        .footer-links a:hover {
            color: var(--posyandu-primary);
            background: var(--posyandu-primary-light);
            text-decoration: none;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 480px) {
            body {
                padding: 0.5rem;
            }
            
            .login-container {
                max-width: 100%;
            }
            
            .card-body {
                padding: 2rem 1.5rem;
            }
            
            .card-header {
                padding: 2rem 1.5rem;
            }
            
            .card-header h1 {
                font-size: 1.5rem;
            }
            
            .header-icon {
                width: 70px;
                height: 70px;
                line-height: 70px;
                font-size: 2.2rem;
            }

            .social-login {
                gap: 0.75rem;
            }

            .footer-links {
                flex-direction: column;
                gap: 0.5rem;
            }
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-card {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-8px);
            }
        }

        /* ===== UTILITY CLASSES ===== */
        .text-center { text-align: center; }
        .mb-3 { margin-bottom: 1rem; }
        .mb-4 { margin-bottom: 1.5rem; }
        .mt-3 { margin-top: 1rem; }
        .mt-4 { margin-top: 1.5rem; }
        .me-2 { margin-right: 0.5rem; }
    </style>
</head>

<body>
    <main>
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Smooth animations on load
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading animation
            document.body.style.opacity = '0';
            setTimeout(() => {
                document.body.style.transition = 'opacity 0.5s ease';
                document.body.style.opacity = '1';
            }, 100);

            // Add focus animations to inputs
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
        });

        // Particle effect on background (optional)
        function createParticle() {
            const particle = document.createElement('div');
            particle.style.position = 'fixed';
            particle.style.width = '4px';
            particle.style.height = '4px';
            particle.style.background = 'rgba(0, 123, 255, 0.3)';
            particle.style.borderRadius = '50%';
            particle.style.pointerEvents = 'none';
            particle.style.zIndex = '-1';
            
            const x = Math.random() * window.innerWidth;
            const y = Math.random() * window.innerHeight;
            
            particle.style.left = x + 'px';
            particle.style.top = y + 'px';
            
            document.body.appendChild(particle);
            
            // Animate particle
            particle.animate([
                { transform: 'translateY(0px)', opacity: 1 },
                { transform: 'translateY(-100px)', opacity: 0 }
            ], {
                duration: 3000,
                easing: 'ease-out'
            }).onfinish = () => particle.remove();
        }

        // Create particles periodically
        setInterval(createParticle, 2000);
    </script>
</body>
</html>