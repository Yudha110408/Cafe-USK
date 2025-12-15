@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <a href="{{ route('kasir.pos.cart') }}" style="background: #f0f0f0; color: #333; padding: 10px 20px; border: none; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; margin-bottom: 20px; transition: background 0.3s;" onmouseover="this.style.background='#e0e0e0'" onmouseout="this.style.background='#f0f0f0'">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
    <h2>Pembayaran</h2>

    <div class="row">
        <div class="col-md-8">
            <h4>Rincian Belanja</h4>
            <table class="table">
                @foreach($cart as $id => $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>Rp {{ number_format($item['price']) }} × {{ $item['quantity'] }}</td>
                    <td>Rp {{ number_format($item['price'] * $item['quantity']) }}</td>
                </tr>
                @endforeach
                <tr class="table-success">
                    <th colspan="2">Total Belanja</th>
                    <th>Rp {{ number_format($total) }}</th>
                </tr>
            </table>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('kasir.pos.checkout') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Uang Dibayar</label>
                            <input type="number" name="paid_amount" class="form-control form-control-lg text-end"
                                   required min="{{ $total }}" value="{{ $total }}">
                        </div>
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            BAYAR & CETAK STRUK
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
