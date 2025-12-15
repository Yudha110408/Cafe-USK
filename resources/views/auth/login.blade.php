@extends('layouts.app')

@push('styles')
<style>
    .login-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
    }

    .login-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: 1px solid #e9ecef;
        width: 100%;
        max-width: 420px;
    }

    .login-header {
        background: #007bff;
        padding: 30px;
        text-align: center;
        color: white;
    }

    .login-header h2 {
        font-weight: 700;
        font-size: 1.8rem;
        margin-bottom: 8px;
    }

    .login-body {
        padding: 30px;
    }

    .form-control-modern {
        border: 1px solid #dee2e6;
        border-radius: 6px;
        padding: 12px 15px;
        font-size: 1rem;
        transition: all 0.2s ease;
    }

    .form-control-modern:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.15);
    }

    .input-icon {
        position: relative;
    }

    .input-icon i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #adb5bd;
        z-index: 10;
    }

    .input-icon input {
        padding-left: 45px;
    }

    .btn-login {
        background: #007bff;
        border: none;
        padding: 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.2s ease;
    }

    .btn-login:hover {
        background: #0056b3;
    }

    .register-link {
        text-align: center;
        margin-top: 20px;
    }

    .register-link a {
        color: #007bff;
        font-weight: 600;
        text-decoration: none;
    }

    .register-link a:hover {
        text-decoration: underline;
    }
</style>
@endpush

@section('content')
<div class="login-container">
    <div class="row justify-content-center w-100">
        <div class="col-md-5">
            <div class="login-card">
                <div class="login-header">
                    <i class="fas fa-store-alt fa-2x mb-2"></i>
                    <h2>Login</h2>
                    <p class="mb-0 opacity-75">Saturn Mart POS System</p>
                </div>

                <div class="login-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <div class="input-icon">
                                <i class="fas fa-envelope"></i>
                                <input id="email" type="email"
                                       class="form-control form-control-modern @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}"
                                       placeholder="Masukkan email"
                                       required autocomplete="email" autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="input-icon">
                                <i class="fas fa-lock"></i>
                                <input id="password" type="password"
                                       class="form-control form-control-modern @error('password') is-invalid @enderror"
                                       name="password"
                                       placeholder="Masukkan password"
                                       required autocomplete="current-password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Ingat saya
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-login w-100 text-white">
                            <i class="fas fa-sign-in-alt me-2"></i>LOGIN
                        </button>

                        @if (Route::has('password.request'))
                        <div class="text-center mt-3">
                            <a href="{{ route('password.request') }}" class="text-muted small">
                                Lupa password?
                            </a>
                        </div>
                        @endif

                        <div class="register-link">
                            Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
