@extends('layout.auth.app')
@section('content')
    <div class="login-container">
        <div class="login-card">
            <!-- Header dengan Gradient Biru -->
            <div class="card-header">
                <div class="header-icon">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <h1>Sistem Informasi Posyandu</h1>
                <p>Masuk untuk mengelola data kesehatan masyarakat</p>
            </div>

            <!-- Body Form -->
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <ul class="mb-0" style="list-style: none; padding-left: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('auth.login') }}" method="POST">
                    @csrf
                    
                    <!-- Email Input -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2"></i>Alamat Email
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   class="form-control" 
                                   placeholder="Masukkan email Anda"
                                   value="{{ old('email') }}"
                                   required 
                                   autofocus>
                        </div>
                    </div>
                    
                    <!-- Password Input -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Kata Sandi
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-key"></i>
                            </span>
                            <input type="password" 
                                   name="password" 
                                   id="password" 
                                   class="form-control" 
                                   placeholder="Masukkan kata sandi"
                                   required>
                            <span class="input-group-text password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Remember Me & Forgot Password -->
                    <div class="form-check">
                        <div class="form-check-content">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                Ingat saya
                            </label>
                        </div>
                        <a href="#" class="forgot-password">Lupa kata sandi?</a>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Masuk ke Sistem
                    </button>
                </form>

                <!-- Divider -->
                <div class="divider">
                    <span>atau</span>
                </div>

                <!-- Social Login -->
                <div class="social-login">
                    <a href="#" class="social-btn social-btn-facebook" title="Login dengan Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-btn social-btn-twitter" title="Login dengan Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-btn social-btn-github" title="Login dengan GitHub">
                        <i class="fab fa-github"></i>
                    </a>
                </div>

                <!-- Register Link -->
                <div class="register-link">
                    Belum punya akun? <a href="#">Daftar sekarang</a>
                </div>
            </div>

            <!-- Footer -->
            <div class="card-footer">
                <p>&copy; 2024 Sistem Informasi Posyandu. All rights reserved.</p>
                <div class="footer-links">
                    <a href="#">Kebijakan Privasi</a>
                    <a href="#">Syarat & Ketentuan</a>
                    <a href="#">Bantuan</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }



        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if (!email || !password) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang diperlukan');
            }
        });
    </script>
@endsection