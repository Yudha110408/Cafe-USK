@extends('layouts.app')
@section('title', 'Kelola User')

@push('styles')
<style>
    .page-header {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 25px;
        border: 1px solid #e9ecef;
    }

    .users-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border: 1px solid #e9ecef;
        overflow: hidden;
    }

    .btn-add {
        background: #007bff;
        border: none;
        padding: 12px 24px;
        border-radius: 6px;
        font-weight: 600;
        color: white;
        transition: all 0.2s ease;
    }

    .btn-add:hover {
        background: #0056b3;
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary mb-3">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <h2 class="mb-2 fw-bold" style="color: #2d3748;">
                    <i class="fas fa-users me-2" style="color: #007bff;"></i>Kelola User
                </h2>
                <p class="text-muted mb-0">Manajemen user & kasir</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="btn-add">
                <i class="fas fa-plus-circle me-2"></i>Tambah User
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card users-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th style="width: 120px;">Role</th>
                            <th style="width: 200px;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $i => $user)
                        <tr>
                            <td class="fw-bold">{{ $i + 1 }}</td>
                            <td class="fw-semibold">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-{{ $user->role == 'admin' ? 'primary' : 'success' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                        <i class="fas fa-trash me-1"></i>Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="fas fa-users fa-3x mb-3"></i>
                                <p class="mb-0">Belum ada user</p>
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
