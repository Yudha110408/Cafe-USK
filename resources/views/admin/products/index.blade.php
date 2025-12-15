@extends('layouts.app')
@section('title', 'Kelola Produk')

@section('content')
<div style="padding: 20px;">
    <a href="{{ route('admin.dashboard') }}" style="background: #f0f0f0; color: #333; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; margin-bottom: 20px; transition: background 0.3s;" onmouseover="this.style.background='#e0e0e0'" onmouseout="this.style.background='#f0f0f0'">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
    <style>
        body.dark-mode [data-section='header'] { background: #2d2d2d; }
        body.dark-mode [data-section='header'] h2 { color: #e0e0e0; }
        body.dark-mode [data-section='header'] p { color: #b0b0b0; }
        body.dark-mode [data-section='table'] { background: #2d2d2d; }
        body.dark-mode [data-section='table'] td { color: #e0e0e0; }
        body.dark-mode [data-section='table'] tr { border-color: #404040; }
    </style>
    <div style="background: #f5f5f5; padding: 20px; border-radius: 8px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <div data-section="header">
            <h2 style="color: #2d3748; margin-bottom: 5px; font-weight: bold; font-size: 24px;">
                <i class="fas fa-box-open me-2" style="color: #007bff;"></i>Kelola Produk
            </h2>
            <p style="color: #999; margin-bottom: 0;">Manajemen produk & inventori</p>
        </div>
        <a href="{{ route('admin.products.create') }}" style="background: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 600; transition: background 0.3s; white-space: nowrap;" onmouseover="this.style.background='#0056b3'" onmouseout="this.style.background='#007bff'">
            <i class="fas fa-plus-circle me-2"></i>Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #28a745;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div data-section="table" style="background: #f5f5f5; border-radius: 8px; overflow: hidden;">
        <div style="padding: 0;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; margin-bottom: 0; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #007bff; color: white;">
                            <th style="width: 60px; padding: 15px; text-align: left; font-weight: 600; border: none;">No</th>
                            <th style="width: 100px; padding: 15px; text-align: left; font-weight: 600; border: none;">Gambar</th>
                            <th style="padding: 15px; text-align: left; font-weight: 600; border: none;">Nama Produk</th>
                            <th style="width: 140px; padding: 15px; text-align: left; font-weight: 600; border: none;">Kategori</th>
                            <th style="width: 150px; padding: 15px; text-align: left; font-weight: 600; border: none;">Harga</th>
                            <th style="width: 120px; padding: 15px; text-align: left; font-weight: 600; border: none;">Stok</th>
                            <th style="width: 200px; padding: 15px; text-align: center; font-weight: 600; border: none;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $i => $product)
                        <tr style="border-bottom: 1px solid #e0e0e0;">
                            <td style="padding: 15px; font-weight: bold; color: #007bff;">{{ $i + 1 }}</td>
                            <td style="padding: 15px;">
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                                @else
                                    <div style="width: 50px; height: 50px; background: #e3f2fd; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-image" style="color: #007bff;"></i>
                                    </div>
                                @endif
                            </td>
                            <td style="padding: 15px; font-weight: 500;">{{ $product->name }}</td>
                            <td style="padding: 15px;">
                                @if($product->category)
                                    <span style="background: #007bff; color: white; padding: 4px 10px; border-radius: 4px; font-size: 12px;">{{ $product->category->name }}</span>
                                @else
                                    <span style="background: #999; color: white; padding: 4px 10px; border-radius: 4px; font-size: 12px;">Tanpa Kategori</span>
                                @endif
                            </td>
                            <td style="padding: 15px; font-weight: bold; color: #28a745;">Rp {{ number_format($product->price) }}</td>
                            <td style="padding: 15px;">
                                <span style="background: {{ $product->stock > 0 ? '#28a745' : '#dc3545' }}; color: white; padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                    <i class="fas fa-box me-1"></i>{{ $product->stock }} pcs
                                </span>
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <a href="{{ route('admin.products.edit', $product) }}" style="background: #f5576c; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 600; display: inline-block; margin-right: 5px; transition: background 0.3s;" onmouseover="this.style.background='#d63447'" onmouseout="this.style.background='#f5576c'">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display: inline;">
                                    @csrf @method('DELETE')
                                    <button style="background: #dc3545; color: white; padding: 6px 12px; border: none; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 600; cursor: pointer; transition: background 0.3s;" onmouseover="this.style.background='#c82333'" onmouseout="this.style.background='#dc3545'" onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                        <i class="fas fa-trash me-1"></i>Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="padding: 40px; text-align: center;">
                                <i class="fas fa-inbox fa-3x" style="color: #ccc; margin-bottom: 15px; display: block;"></i>
                                <p style="color: #999; margin: 0;">Belum ada produk. Mulai tambahkan produk pertama Anda!</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
