@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
<div style="background: #f5f5f5; min-height: 100vh; padding: 20px;">
    <div style="max-width: 1400px; margin: 0 auto;">

        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h1 style="margin: 0 0 8px 0; font-weight: 700; color: #333; font-size: 2rem;">
                    <i class="fas fa-crown" style="margin-right: 12px; color: #ffc107;"></i>Dashboard Admin
                </h1>
                <p style="margin: 0; color: #666; font-size: 0.9rem;">
                    <i class="fas fa-calendar-check" style="margin-right: 6px;"></i>{{ now()->format('l, d F Y • H:i') }} WIB
                </p>
            </div>
            <span style="background: #007bff; color: white; padding: 10px 24px; border-radius: 50px; font-weight: 600; font-size: 0.9rem;">
                ADMIN
            </span>
        </div>

        <!-- Statistik Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 30px;">

            <!-- Card 1: Total Penjualan -->
            <div style="background: white; border-radius: 8px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid #28a745;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <p style="margin: 0 0 8px 0; color: #666; font-size: 0.9rem; font-weight: 500;">Total Penjualan</p>
                        <h2 style="margin: 0 0 4px 0; font-weight: 700; color: #28a745; font-size: 1.8rem;">
                            Rp {{ number_format($totalSales ?? 0) }}
                        </h2>
                        <small style="color: #999; font-size: 0.85rem;">
                            <i class="fas fa-infinity" style="margin-right: 4px;"></i>Semua waktu
                        </small>
                    </div>
                    <div style="background: #e8f5e9; border-radius: 8px; padding: 12px 16px;">
                        <i class="fas fa-wallet" style="color: #28a745; font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>

            <!-- Card 2: Penjualan Hari Ini -->
            <div style="background: white; border-radius: 8px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid #007bff;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <p style="margin: 0 0 8px 0; color: #666; font-size: 0.9rem; font-weight: 500;">Penjualan Hari Ini</p>
                        <h2 style="margin: 0 0 4px 0; font-weight: 700; color: #007bff; font-size: 1.8rem;">
                            Rp {{ number_format($todaySales ?? 0) }}
                        </h2>
                        <small style="color: #999; font-size: 0.85rem;">
                            <i class="fas fa-calendar-check" style="margin-right: 4px;"></i>{{ now()->format('d M Y') }}
                        </small>
                    </div>
                    <div style="background: #e3f2fd; border-radius: 8px; padding: 12px 16px;">
                        <i class="fas fa-calendar-day" style="color: #007bff; font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>

            <!-- Card 3: Total Produk -->
            <div style="background: white; border-radius: 8px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-left: 4px solid #dc3545;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <p style="margin: 0 0 8px 0; color: #666; font-size: 0.9rem; font-weight: 500;">Total Produk</p>
                        <h2 style="margin: 0 0 4px 0; font-weight: 700; color: #dc3545; font-size: 1.8rem;">
                            {{ $totalProducts ?? 0 }}
                        </h2>
                        <small style="color: #999; font-size: 0.85rem;">
                            <i class="fas fa-box" style="margin-right: 4px;"></i>item terdaftar
                        </small>
                    </div>
                    <div style="background: #ffebee; border-radius: 8px; padding: 12px 16px;">
                        <i class="fas fa-boxes" style="color: #dc3545; font-size: 1.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Utama -->
        <h3 style="margin: 0 0 20px 0; font-weight: 700; color: #333; font-size: 1.3rem;">
            <i class="fas fa-grip-horizontal" style="margin-right: 8px; color: #007bff;"></i>Menu Utama
        </h3>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">

            <!-- Menu 1: Kelola Produk -->
            <a href="{{ route('admin.products.index') }}" style="text-decoration: none;">
                <div style="background: white; border-radius: 8px; padding: 30px 20px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.2s ease; cursor: pointer;"
                     onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)'; this.style.transform='translateY(-2px)';"
                     onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'; this.style.transform='translateY(0)';">
                    <div style="background: #e3f2fd; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto;">
                        <i class="fas fa-box-open" style="font-size: 2rem; color: #007bff;"></i>
                    </div>
                    <h5 style="margin: 0 0 8px 0; font-weight: 600; color: #333;">Kelola Produk</h5>
                    <p style="margin: 0; color: #666; font-size: 0.9rem;">Tambah, Edit & Hapus Produk</p>
                </div>
            </a>

            <!-- Menu 2: Kategori Produk -->
            <a href="{{ route('admin.categories.index') }}" style="text-decoration: none;">
                <div style="background: white; border-radius: 8px; padding: 30px 20px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.2s ease; cursor: pointer;"
                     onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)'; this.style.transform='translateY(-2px)';"
                     onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'; this.style.transform='translateY(0)';">
                    <div style="background: #fff3e0; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto;">
                        <i class="fas fa-list" style="font-size: 2rem; color: #ff9800;"></i>
                    </div>
                    <h5 style="margin: 0 0 8px 0; font-weight: 600; color: #333;">Kategori Produk</h5>
                    <p style="margin: 0; color: #666; font-size: 0.9rem;">Kelola Kategori</p>
                </div>
            </a>

            <!-- Menu 3: Laporan Penjualan -->
            <a href="{{ route('admin.reports.index') }}" style="text-decoration: none;">
                <div style="background: white; border-radius: 8px; padding: 30px 20px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.2s ease; cursor: pointer;"
                     onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)'; this.style.transform='translateY(-2px)';"
                     onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'; this.style.transform='translateY(0)';">
                    <div style="background: #e8f5e9; border-radius: 50%; width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto;">
                        <i class="fas fa-file-invoice-dollar" style="font-size: 2rem; color: #28a745;"></i>
                    </div>
                    <h5 style="margin: 0 0 8px 0; font-weight: 600; color: #333;">Laporan Penjualan</h5>
                    <p style="margin: 0; color: #666; font-size: 0.9rem;">Click Untuk Melihat </p>
                </div>
            </a>
        </div>

    </div>
</div>
@endsection
