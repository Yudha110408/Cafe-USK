@extends('layouts.app')

@push('styles')
<style>
    .register-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .register-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 30px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        border: none;
    }

    .register-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 40px;
        text-align: center;
        color: white;
    }

    .register-header h2 {
        font-weight: 800;
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .register-body {
        padding: 40px;
    }

    .form-control-modern {
        border: 2px solid #e0e0e0;
        border-radius: 15px;
        padding: 15px 20px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control-modern:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .input-icon {
        position: relative;
    }

    .input-icon i {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
        z-index: 10;
    }

    .input-icon input {
        padding-left: 50px;
    }

    .btn-register {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 15px;
        border-radius: 15px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-register:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(102, 126, 234, 0.6);
    }

    .login-link {
        text-align: center;
        margin-top: 20px;
    }

    .login-link a {
        color: #667eea;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .login-link a:hover {
        color: #764ba2;
    }
</style>
@endpush

@section('content')
<div class="register-container animate-fade-in">
    <div class="row justify-content-center w-100">
        <div class="col-md-6">
            <div class="register-card">
                <div class="register-header">
                    <i class="fas fa-user-plus fa-3x mb-3"></i>
                    <h2>Create Account</h2>
                    <p class="mb-0 opacity-75">Join Saturn Mart POS System</p>
                </div>

                <div class="register-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">Full Name</label>
                            <div class="input-icon">
                                <i class="fas fa-user"></i>
                                <input id="name" type="text"
                                       class="form-control form-control-modern @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name') }}"
                                       placeholder="Enter your full name"
                                       required autocomplete="name" autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <div class="input-icon">
                                <i class="fas fa-envelope"></i>
                                <input id="email" type="email"
                                       class="form-control form-control-modern @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}"
                                       placeholder="Enter your email"
                                       required autocomplete="email">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="input-icon">
                                <i class="fas fa-lock"></i>
                                <input id="password" type="password"
                                       class="form-control form-control-modern @error('password') is-invalid @enderror"
                                       name="password"
                                       placeholder="Create a password"
                                       required autocomplete="new-password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-semibold">Confirm Password</label>
                            <div class="input-icon">
                                <i class="fas fa-lock"></i>
                                <input id="password-confirm" type="password"
                                       class="form-control form-control-modern"
                                       name="password_confirmation"
                                       placeholder="Confirm your password"
                                       required autocomplete="new-password">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-register w-100 text-white">
                            <i class="fas fa-user-plus me-2"></i>CREATE ACCOUNT
                        </button>

                        <div class="login-link">
                            Already have an account? <a href="{{ route('login') }}">Login Here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
