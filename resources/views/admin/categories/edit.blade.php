@extends('layouts.app')
@section('title', 'Edit Kategori')

@section('content')
<div class="container-fluid px-4 py-4">
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary mb-3">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
    <div class="card" style="max-width: 600px; margin: 0 auto; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Kategori</h5>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.categories.update', $category->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nama Kategori</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           id="name" name="name" value="{{ old('name', $category->name) }}" required autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label fw-semibold">Slug</label>
                    <input type="text" class="form-control" id="slug" value="{{ $category->slug }}" disabled>
                    <small class="form-text text-muted">Slug akan otomatis di-update saat disimpan</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
