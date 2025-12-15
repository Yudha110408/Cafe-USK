@extends('layouts.app')
@section('title', 'Kelola Kategori')

@section('content')
<div style="background: #f5f5f5; min-height: 100vh; padding: 20px;">
    <div style="max-width: 1200px; margin: 0 auto;">

        <!-- Back Button -->
        <a href="{{ route('admin.dashboard') }}" style="display: inline-block; background: #f8f9fa; border: 1px solid #ddd; color: #333; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 500; margin-bottom: 20px;">
            <i class="fas fa-arrow-left" style="margin-right: 6px;"></i>Kembali
        </a>

        <!-- Header -->
        <div style="background: white; border-radius: 8px; padding: 24px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h2 style="margin: 0 0 6px 0; font-weight: 700; color: #333; font-size: 1.5rem;">
                        <i class="fas fa-list" style="margin-right: 8px; color: #007bff;"></i>Kelola Kategori
                    </h2>
                    <p style="margin: 0; color: #666; font-size: 0.9rem;">Manajemen kategori produk</p>
                </div>
                <a href="{{ route('admin.categories.create') }}" style="background: #007bff; color: white; padding: 10px 24px; border-radius: 6px; text-decoration: none; font-weight: 600; cursor: pointer; display: inline-block;">
                    <i class="fas fa-plus-circle" style="margin-right: 6px;"></i>Tambah Kategori
                </a>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 16px; border-radius: 6px; margin-bottom: 20px;">
                <i class="fas fa-check-circle" style="margin-right: 8px;"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 16px; border-radius: 6px; margin-bottom: 20px;">
                <i class="fas fa-exclamation-circle" style="margin-right: 8px;"></i>{{ session('error') }}
            </div>
        @endif

        <!-- Table Card -->
        <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #007bff; color: white;">
                            <th style="padding: 16px; text-align: left; font-weight: 600;">No</th>
                            <th style="padding: 16px; text-align: left; font-weight: 600;">Nama Kategori</th>
                            <th style="padding: 16px; text-align: left; font-weight: 600;">Slug</th>
                            <th style="padding: 16px; text-align: center; font-weight: 600;">Jumlah Produk</th>
                            <th style="padding: 16px; text-align: center; font-weight: 600;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $i => $category)
                        <tr style="border-bottom: 1px solid #e0e0e0;">
                            <td style="padding: 16px; color: #333;">{{ ($categories->currentPage() - 1) * $categories->perPage() + $i + 1 }}</td>
                            <td style="padding: 16px; color: #333; font-weight: 600;">{{ $category->name }}</td>
                            <td style="padding: 16px; color: #666; font-family: monospace; font-size: 0.9rem;">{{ $category->slug }}</td>
                            <td style="padding: 16px; text-align: center;">
                                <span style="background: #007bff; color: white; padding: 4px 12px; border-radius: 20px; font-weight: 600; font-size: 0.85rem;">
                                    {{ $category->products()->count() }}
                                </span>
                            </td>
                            <td style="padding: 16px; text-align: center;">
                                <a href="{{ route('admin.categories.edit', $category) }}" style="background: #dc3545; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none; font-weight: 600; font-size: 0.85rem; display: inline-block; margin-right: 8px;">
                                    <i class="fas fa-edit" style="margin-right: 4px;"></i>Edit
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: #dc3545; color: white; padding: 8px 16px; border-radius: 4px; border: none; font-weight: 600; font-size: 0.85rem; cursor: pointer;">
                                        <i class="fas fa-trash" style="margin-right: 4px;"></i>Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="padding: 40px 16px; text-align: center;">
                                <i class="fas fa-inbox" style="font-size: 3rem; color: #ddd; display: block; margin-bottom: 12px;"></i>
                                <p style="margin: 0; color: #999; font-weight: 500;">Tidak ada kategori</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div style="margin-top: 20px;">
            {{ $categories->links() }}
        </div>

    </div>
</div>
@endsection
