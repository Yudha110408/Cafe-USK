@extends('layouts.app')
@section('title', 'Tambah Kategori')

@section('content')
<div style="background: #f5f5f5; min-height: 100vh; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto;">

        <!-- Back Button -->
        <a href="{{ route('admin.categories.index') }}"
           style="display: inline-block; color: #007bff; text-decoration: none; font-weight: 500; margin-bottom: 20px;">
            <i class="fas fa-arrow-left" style="margin-right: 6px;"></i>Kembali
        </a>

        <!-- Form Card -->
        <div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden;">

            <!-- Header -->
            <div style="background: #007bff; padding: 24px; color: white;">
                <h2 style="margin: 0; font-weight: 700; font-size: 1.3rem;">
                    <i class="fas fa-plus-circle" style="margin-right: 8px;"></i>Tambah Kategori Baru
                </h2>
            </div>

            <!-- Form Body -->
            <div style="padding: 30px;">
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf

                    <!-- Nama Kategori Input -->
                    <div style="margin-bottom: 24px;">
                        <label for="name" style="display: block; font-weight: 600; color: #333; margin-bottom: 8px; font-size: 0.95rem;">
                            Nama Kategori
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               placeholder="Contoh: Elektronik, Pakaian, Makanan"
                               required
                               autofocus
                               style="width: 100%; padding: 12px 14px; border: 1px solid #ddd; border-radius: 6px; font-size: 1rem; font-family: inherit; transition: all 0.2s ease; box-sizing: border-box;"
                               onfocus="this.style.borderColor='#007bff'; this.style.boxShadow='0 0 0 2px rgba(0, 123, 255, 0.1)';"
                               onblur="this.style.borderColor='#ddd'; this.style.boxShadow='none';"
                               @error('name') style="border-color: #dc3545 !important;" @enderror>

                        @error('name')
                            <div style="color: #dc3545; font-size: 0.85rem; margin-top: 6px;">
                                <i class="fas fa-exclamation-circle" style="margin-right: 4px;"></i>{{ $message }}
                            </div>
                        @enderror

                        <small style="display: block; color: #666; margin-top: 8px; font-size: 0.85rem;">
                            <i class="fas fa-info-circle" style="margin-right: 4px;"></i>Slug akan otomatis di-generate dari nama kategori
                        </small>
                    </div>

                    <!-- Button Group -->
                    <div style="display: flex; gap: 12px; margin-top: 30px;">
                        <button type="submit"
                                style="flex: 1; padding: 12px 20px; background: #007bff; color: white; border: none; border-radius: 6px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: all 0.2s ease;">
                            <i class="fas fa-save" style="margin-right: 6px;"></i>Simpan
                        </button>
                        <a href="{{ route('admin.categories.index') }}"
                           style="flex: 1; padding: 12px 20px; background: #f0f0f0; color: #333; border: none; border-radius: 6px; font-weight: 600; font-size: 0.95rem; cursor: pointer; text-decoration: none; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;"
                           onmouseover="this.style.background='#e0e0e0';"
                           onmouseout="this.style.background='#f0f0f0';">
                            <i class="fas fa-times" style="margin-right: 6px;"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Dark Mode Support -->
<style>
    body.dark-mode div[style*="background: white"] {
        background: #2d2d2d !important;
    }

    body.dark-mode input[style*="border: 1px solid"] {
        background: #3a3a3a !important;
        color: #e0e0e0 !important;
        border-color: #555 !important;
    }

    body.dark-mode input[style*="border: 1px solid"]::placeholder {
        color: #999 !important;
    }

    body.dark-mode label[style*="color: #333"] {
        color: #e0e0e0 !important;
    }

    body.dark-mode small[style*="color: #666"] {
        color: #b0b0b0 !important;
    }
</style>
@endsection
