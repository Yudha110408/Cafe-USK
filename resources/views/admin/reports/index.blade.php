@extends('layouts.app')
@section('title', 'Laporan Penjualan')

@push('styles')
<style>
    .filter-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 25px;
        border: 1px solid #e9ecef;
    }

    .stats-card {
        background: #007bff;
        color: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.2);
    }

    .table-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border: 1px solid #e9ecef;
        overflow: hidden;
    }

    .btn-export {
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <h2 class="fw-bold mb-2" style="color: #2d3748;">
                <i class="fas fa-chart-bar me-2" style="color: #007bff;"></i>Laporan Penjualan
            </h2>
            <p class="text-muted mb-0">Laporan transaksi dan penjualan</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="filter-card">
        <h5 class="fw-bold mb-3">Filter Laporan</h5>
        <form method="GET" action="{{ route('admin.reports.index') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Tanggal Akhir</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search me-2"></i>Tampilkan
                </button>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-redo me-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Total Penjualan -->
    <div class="stats-card">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h6 class="mb-2 opacity-75">Total Penjualan</h6>
                <h2 class="mb-0 fw-bold">Rp {{ number_format($totalSales) }}</h2>
                <small class="opacity-75">{{ $transactions->count() }} transaksi</small>
            </div>
            <div>
                <i class="fas fa-money-bill-wave fa-4x opacity-25"></i>
            </div>
        </div>
    </div>

    <!-- Export Buttons -->
    <div class="mb-3">
        <form method="GET" action="{{ route('admin.reports.pdf') }}" class="d-inline">
            @if($startDate)
                <input type="hidden" name="start_date" value="{{ $startDate }}">
            @endif
            @if($endDate)
                <input type="hidden" name="end_date" value="{{ $endDate }}">
            @endif
            <!-- <button type="submit" class="btn btn-danger btn-export me-2">
                <i class="fas fa-file-pdf me-2"></i>Export PDF
            </button> -->
        </form>

        <form method="GET" action="{{ route('admin.reports.excel') }}" class="d-inline">
            @if($startDate)
                <input type="hidden" name="start_date" value="{{ $startDate }}">
            @endif
            @if($endDate)
                <input type="hidden" name="end_date" value="{{ $endDate }}">
            @endif
            <!-- <button type="submit" class="btn btn-success btn-export">
                <i class="fas fa-file-excel me-2"></i>Export Excel
            </button> -->
        </form>
    </div>

    <!-- Tabel Transaksi -->
    <div class="table-card">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>No. Transaksi</th>
                        <th>Kasir</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $i => $trx)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d/m/Y H:i') }}</td>
                        <td><strong>#{{ str_pad($trx->id, 6, '0', STR_PAD_LEFT) }}</strong></td>
                        <td>{{ $trx->user->name }}</td>
                        <td>{{ $trx->items->count() }} item</td>
                        <td class="fw-bold text-success">Rp {{ number_format($trx->total_amount) }}</td>
                        <td>
                            <a href="{{ route('admin.transactions.receipt', $trx) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-receipt"></i> Struk
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p class="mb-0">Tidak ada data transaksi</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
