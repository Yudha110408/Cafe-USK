@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">
        Riwayat Transaksi - {{ auth()->user()->name }}
    </h2>

    @if($transactions->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Tanggal</th>
                        <th>Jumlah Item</th>
                        <th>Total</th>
                        <th>Bayar</th>
                        <th>Kembali</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $t)
                    <tr>
                        <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $t->items->count() }} item</td>
                        <td>Rp {{ number_format($t->total_amount) }}</td>
                        <td>Rp {{ number_format($t->paid_amount) }}</td>
                        <td>Rp {{ number_format($t->change_amount) }}</td>
                        <td>
                            <a href="{{ route('kasir.receipt', $t->id) }}"
                               target="_blank" class="btn btn-sm btn-success btn-sm">
                                Cetak Struk
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $transactions->links() }}
    @else
        <div class="text-center py-5">
            <i class="fas fa-history fa-5x text-muted mb-3"></i>
            <h4 class="text-muted">Belum ada transaksi</h4>
        </div>
    @endif

    <a href="{{ route('kasir.pos.index') }}" class="btn btn-primary mt-3">
        Kembali ke POS
    </a>
</div>
@endsection
