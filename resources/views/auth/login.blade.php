@extends('layouts.app')

@section('title', 'Login Akun')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white text-center py-4 position-relative">
                    <h4 class="fw-bold mb-0">Selamat Datang Kembali!</h4>
                    <p class="mb-0 small text-white-50">Silakan login untuk mengelola pesanan ikanmu</p>
                    
                    {{-- Hiasan Visual Saja --}}
                    <div class="position-absolute top-0 end-0 p-3 opacity-25">
                        <i class="mdi mdi-fish mdi-48px text-white"></i>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5 bg-white">
                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf

                        {{-- Input Email --}}
                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold text-muted small text-uppercase">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="mdi mdi-email-outline text-primary"></i>
                                </span>
                                <input id="email" type="email" 
                                       class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" 
                                       required autocomplete="email" autofocus
                                       placeholder="contoh@email.com">
                            </div>
                            @error('email')
                                <span class="text-danger small mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Input Password dengan Fitur Show/Hide --}}
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="password" class="form-label fw-bold text-muted small text-uppercase">Password</label>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link btn-sm p-0 text-decoration-none" href="{{ route('password.request') }}">
                                        Lupa Password?
                                    </a>
                                @endif
                            </div>
                            
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="mdi mdi-lock-outline text-primary"></i>
                                </span>
                                <input id="password" type="password" 
                                       class="form-control border-start-0 border-end-0 ps-0 @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="current-password"
                                       placeholder="••••••••">
                                <span class="input-group-text bg-white border-start-0" style="cursor: pointer;" onclick="togglePassword()">
                                    <i class="mdi mdi-eye-off-outline text-muted" id="toggleIcon"></i>
                                </span>
                            </div>
                            @error('password')
                                <span class="text-danger small mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Checkbox Remember Me --}}
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted" for="remember">
                                    Ingat Saya di perangkat ini
                                </label>
                            </div>
                        </div>

                        {{-- Tombol Login --}}
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm" id="btnSubmit">
                                <i class="mdi mdi-login me-2"></i> Masuk Sekarang
                            </button>
                        </div>

                        {{-- Register Link --}}
                        <div class="text-center">
                            <p class="text-muted mb-0">Belum punya akun? 
                                <a href="{{ route('register') }}" class="fw-bold text-primary text-decoration-none">Daftar Disini</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
            
            {{-- Footer Kecil Login --}}
            <div class="text-center mt-4">
                <small class="text-muted">
                    &copy; {{ date('Y') }} Vans Aquatic. Aman & Terpercaya.
                </small>
            </div>
        </div>
    </div>
</div>

{{-- Script Khusus Halaman Login --}}
<script>
    function togglePassword() {
        var passwordInput = document.getElementById("password");
        var icon = document.getElementById("toggleIcon");
        
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove("mdi-eye-off-outline");
            icon.classList.add("mdi-eye-outline");
            icon.classList.add("text-primary");
        } else {
            passwordInput.type = "password";
            icon.classList.remove("mdi-eye-outline");
            icon.classList.remove("text-primary");
            icon.classList.add("mdi-eye-off-outline");
        }
    }

    // Efek Loading saat tombol diklik
    document.getElementById('loginForm').addEventListener('submit', function() {
        var btn = document.getElementById('btnSubmit');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Memproses...';
        btn.disabled = true;
    });
</script>
@endsection