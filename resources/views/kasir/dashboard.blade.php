@extends('layouts.app')

@section('title', 'Dashboard Kasir')

@push('styles')
<style>
    .hero-section {
        min-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .hero-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 40px;
        padding: 60px;
        box-shadow: 0 30px 90px rgba(0, 0, 0, 0.2);
        text-align: center;
        max-width: 800px;
        border: none;
    }

    .icon-pulse {
        animation: pulse 2s infinite;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        width: 180px;
        height: 180px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 40px;
        box-shadow: 0 20px 60px rgba(102, 126, 234, 0.4);
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .welcome-title {
        font-size: 3rem;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 20px;
    }

    .btn-start {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border: none;
        padding: 25px 60px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.3rem;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 15px 40px rgba(17, 153, 142, 0.4);
        text-decoration: none;
        display: inline-block;
    }

    .btn-start:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 50px rgba(17, 153, 142, 0.6);
        color: white;
    }

    .quick-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-top: 40px;
    }

    .stat-card {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        padding: 25px;
        border-radius: 20px;
        border: 2px solid rgba(102, 126, 234, 0.2);
    }

    .stat-card h4 {
        font-size: 2rem;
        font-weight: 800;
        color: #667eea;
        margin-bottom: 5px;
    }

    .tips-box {
        background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
        padding: 20px;
        border-radius: 20px;
        margin-top: 40px;
    }

    .tips-box kbd {
        background: white;
        padding: 5px 10px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@section('content')
<div class="hero-section animate-fade-in">
    <div class="hero-card">
        <div class="icon-pulse">
            <i class="fas fa-cash-register fa-5x text-white"></i>
        </div>

        <h1 class="welcome-title">
            Selamat Datang, {{ auth()->user()->name }}!
        </h1>

        <p class="text-muted fs-5 mb-4">
            <i class="fas fa-calendar-alt me-2"></i>{{ now()->format('l, d F Y') }}
            <span class="mx-2">•</span>
            <i class="fas fa-clock me-2"></i>{{ now()->format('H:i') }} WIB
        </p>

        <a href="{{ route('kasir.pos.index') }}" class="btn-start">
            <i class="fas fa-rocket me-3"></i>MULAI TRANSAKSI
        </a>

        <div class="quick-stats">
            <div class="stat-card">
                <h4><i class="fas fa-box"></i></h4>
                <p class="mb-0 fw-semibold">Produk Ready</p>
            </div>
            <div class="stat-card">
                <h4><i class="fas fa-shopping-cart"></i></h4>
                <p class="mb-0 fw-semibold">Siap Melayani</p>
            </div>
            <div class="stat-card">
                <h4><i class="fas fa-bolt"></i></h4>
                <p class="mb-0 fw-semibold">Super Cepat</p>
            </div>
        </div>

        <div class="tips-box">
            <p class="mb-2 fw-bold"><i class="fas fa-lightbulb me-2"></i>Tips Cepat:</p>
            <p class="mb-0 small">
                Tekan <kbd>F2</kbd> untuk fokus pencarian produk
                <span class="mx-2">•</span>
                <kbd>Esc</kbd> untuk kosongkan keranjang
                <span class="mx-2">•</span>
                Scan barcode untuk input cepat
            </p>
        </div>
    </div>
</div>
@endsection
