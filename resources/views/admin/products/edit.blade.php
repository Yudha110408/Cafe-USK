@extends('layouts.app')
@section('title', 'Edit Produk')

@section('content')
<div style="padding: 20px; max-width: 600px; margin: 0 auto;">
    <style>
        body.dark-mode [data-form='container'] { background: #2d2d2d; }
        body.dark-mode [data-form='container'] input,
        body.dark-mode [data-form='container'] select {
            background: #404040 !important;
            color: #e0e0e0 !important;
            border-color: #555 !important;
        }
        body.dark-mode [data-form='container'] label { color: #e0e0e0; }
    </style>
    <a href="{{ route('admin.products.index') }}" style="background: #f0f0f0; color: #333; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; margin-bottom: 20px; transition: background 0.3s;" onmouseover="this.style.background='#e0e0e0'" onmouseout="this.style.background='#f0f0f0'">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>

    <div data-form="container" style="background: #f5f5f5; border-radius: 8px; overflow: hidden;">
        <div style="background: #007bff; color: white; padding: 20px; font-size: 18px; font-weight: 600;">
            <i class="fas fa-edit me-2"></i>Edit Produk
        </div>
        <div style="padding: 30px;">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 20px;">
                    <label for="category_id" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Kategori</label>
                    <select name="category_id" id="category_id" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; background: white;">
                        <option value="">Pilih Kategori (Opsional)</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="name" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Nama Produk</label>
                    <input type="text" name="name" id="name" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; box-sizing: border-box;" placeholder="Masukkan nama produk"
                           value="{{ old('name', $product->name) }}" required>
                    @error('name')
                        <div style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="price_display" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Harga</label>
                    <input type="text" id="price_display" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; box-sizing: border-box;" placeholder="Contoh: 12.000"
                           value="{{ old('price', $product->price) ? number_format(old('price', $product->price)) : '' }}">
                    <input type="hidden" name="price" id="price">
                    <small style="color: #999; display: block; margin-top: 5px;">Format: 12.000 (akan disimpan sebagai 12000)</small>
                    @error('price')
                        <div style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="stock" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Stok</label>
                    <input type="number" name="stock" id="stock" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; box-sizing: border-box;" placeholder="0"
                           value="{{ old('stock', $product->stock) }}" required>
                    @error('stock')
                        <div style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="image" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Gambar (Opsional)</label>
                    <input type="file" name="image" id="image" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; box-sizing: border-box;"
                           accept="image/*">
                    @if($product->image)
                        <div style="margin-top: 15px;">
                            <small style="display: block; color: #999; margin-bottom: 10px;">
                                <i class="fas fa-check-circle"></i> Gambar saat ini:
                            </small>
                            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}"
                                 style="max-height: 120px; border-radius: 6px;">
                        </div>
                    @endif
                    @error('image')
                        <div style="color: #dc3545; font-size: 13px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display: flex; gap: 10px; margin-top: 30px;">
                    <button type="submit" style="background: #007bff; color: white; padding: 10px 25px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; transition: background 0.3s;" onmouseover="this.style.background='#0056b3'" onmouseout="this.style.background='#007bff'">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                    <a href="{{ route('admin.products.index') }}" style="background: #f0f0f0; color: #333; padding: 10px 25px; border: none; border-radius: 6px; font-weight: 600; text-decoration: none; transition: background 0.3s;" onmouseover="this.style.background='#e0e0e0'" onmouseout="this.style.background='#f0f0f0'">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('price_display').addEventListener('input', function(e) {
        // Hapus semua karakter yang bukan angka
        let value = e.target.value.replace(/\D/g, '');

        // Format dengan titik setiap 3 digit
        let formatted = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

        // Tampilkan di input display
        e.target.value = formatted;

        // Simpan nilai asli (tanpa titik) ke hidden input
        document.getElementById('price').value = value;
    });

    // Saat form di-submit, pastikan nilai price terisi
    document.querySelector('form').addEventListener('submit', function(e) {
        const price = document.getElementById('price').value;
        if (!price) {
            e.preventDefault();
            alert('Harga harus diisi!');
            return false;
        }
    });
</script>
@endsection
