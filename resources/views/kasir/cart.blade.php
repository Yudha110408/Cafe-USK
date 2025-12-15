@extends('layouts.app')
@section('title', 'Keranjang Belanja • POS Kasir')

@section('content')
<div style="background: #f5f5f5; min-height: 100vh; padding: 20px;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <!-- Header -->
        <div style="background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <h2 style="margin: 0; font-weight: 700; color: #333; font-size: 1.5rem;">
                    <i class="fas fa-shopping-cart" style="margin-right: 8px; color: #007bff;"></i>Keranjang Belanja
                </h2>
                <a href="{{ route('kasir.pos.index') }}" style="background: #f8f9fa; border: 1px solid #ddd; color: #333; padding: 10px 20px; border-radius: 6px; text-decoration: none; font-weight: 500;">
                    <i class="fas fa-arrow-left" style="margin-right: 6px;"></i>Kembali
                </a>
            </div>
        </div>

        @if(session('cart'))
            <!-- Cart Table -->
            <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px;">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #007bff; color: white;">
                                <th style="padding: 16px; text-align: left; font-weight: 600;">Produk</th>
                                <th style="padding: 16px; text-align: center; font-weight: 600; width: 120px;">Harga</th>
                                <th style="padding: 16px; text-align: center; font-weight: 600; width: 150px;">Jumlah</th>
                                <th style="padding: 16px; text-align: center; font-weight: 600; width: 120px;">Subtotal</th>
                                <th style="padding: 16px; text-align: center; font-weight: 600; width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(session('cart') as $id => $item)
                            <tr id="row-{{ $id }}" style="border-bottom: 1px solid #e0e0e0;">
                                <!-- Produk -->
                                <td style="padding: 16px;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        @if($item['image'])
                                            <img src="{{ asset('storage/'.$item['image']) }}"
                                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px; background: #f0f0f0;">
                                        @else
                                            <div style="width: 60px; height: 60px; background: #f0f0f0; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-box" style="color: #999; font-size: 1.5rem;"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 style="margin: 0 0 4px 0; font-weight: 600; color: #333;">{{ $item['name'] }}</h6>
                                            @if(isset($item['category']))
                                                <small style="color: #999;">{{ $item['category'] }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <!-- Harga -->
                                <td style="padding: 16px; text-align: center; color: #28a745; font-weight: 600;">
                                    Rp {{ number_format($item['price']) }}
                                </td>
                                <!-- Jumlah -->
                                <td style="padding: 16px; text-align: center;">
                                    <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                        <button onclick="updateQty({{ $id }}, -1)"
                                                style="background: #dc3545; color: white; border: none; border-radius: 4px; width: 32px; height: 32px; cursor: pointer; font-size: 1rem; font-weight: bold; padding: 0;">
                                            −
                                        </button>
                                        <span style="font-weight: 600; min-width: 40px; text-align: center;">{{ $item['quantity'] }}</span>
                                        <button onclick="updateQty({{ $id }}, 1)"
                                                style="background: #28a745; color: white; border: none; border-radius: 4px; width: 32px; height: 32px; cursor: pointer; font-size: 1rem; font-weight: bold; padding: 0;">
                                            +
                                        </button>
                                    </div>
                                </td>
                                <!-- Subtotal -->
                                <td style="padding: 16px; text-align: center; color: #007bff; font-weight: 600;">
                                    Rp {{ number_format($item['price'] * $item['quantity']) }}
                                </td>
                                <!-- Aksi -->
                                <td style="padding: 16px; text-align: center;">
                                    <button onclick="removeFromCart({{ $id }})"
                                            style="background: #dc3545; color: white; border: none; border-radius: 4px; padding: 8px 12px; cursor: pointer; font-weight: 500; font-size: 0.85rem;">
                                        <i class="fas fa-trash" style="margin-right: 4px;"></i>Hapus
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Summary & Actions -->
            <div style="background: white; padding: 24px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="margin: 0 0 4px 0; color: #666; font-size: 0.9rem;">Total Belanja</p>
                        <h3 style="margin: 0; font-weight: 700; color: #28a745; font-size: 1.8rem;">
                            Rp <span id="grandTotal">{{ number_format(collect(session('cart'))->sum(fn($i)=>$i['price']*$i['quantity'])) }}</span>
                        </h3>
                        <small style="color: #999;">{{ count(session('cart')) }} item</small>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <button onclick="clearCart()"
                                style="background: white; border: 1px solid #dc3545; color: #dc3545; padding: 12px 24px; border-radius: 6px; cursor: pointer; font-weight: 600;">
                            <i class="fas fa-trash" style="margin-right: 6px;"></i>Kosongkan
                        </button>
                        <a href="{{ route('kasir.pos.checkout.show') }}"
                           style="background: #28a745; color: white; padding: 12px 30px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; cursor: pointer;">
                            <i class="fas fa-credit-card" style="margin-right: 6px;"></i>LANJUT BAYAR
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Keranjang Kosong -->
            <div style="background: white; padding: 60px 20px; border-radius: 8px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <i class="fas fa-shopping-cart" style="font-size: 4rem; color: #ddd; margin-bottom: 20px; display: block;"></i>
                <h3 style="color: #666; margin: 0 0 12px 0; font-weight: 600;">Keranjang Anda Kosong</h3>
                <p style="color: #999; margin: 0 0 24px 0;">Tambahkan produk untuk memulai transaksi</p>
                <a href="{{ route('kasir.pos.index') }}"
                   style="background: #007bff; color: white; padding: 12px 30px; border-radius: 6px; text-decoration: none; font-weight: 600; display: inline-block; cursor: pointer;">
                    <i class="fas fa-arrow-left" style="margin-right: 6px;"></i>Kembali ke POS
                </a>
            </div>
        @endif
    </div>
</div>

<script>
// Hapus 1 item
function removeFromCart(id) {
    if(confirm('Hapus item ini dari keranjang?')) {
        fetch("{{ route('kasir.pos.remove') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ product_id: id })
        })
        .then(() => {
            document.getElementById('row-' + id).remove();
            updateTotal();
            checkEmptyCart();
        });
    }
}

// Update jumlah (+ / -)
function updateQty(id, change) {
    fetch("{{ route('kasir.pos.add') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ product_id: id, quantity: change })
    })
    .then(() => location.reload());
}

// Kosongkan seluruh keranjang
function clearCart() {
    if(confirm('Kosongkan seluruh keranjang?')) {
        fetch("{{ route('kasir.pos.clear') }}", {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(() => location.reload());
    }
}

// Update total otomatis
function updateTotal() {
    const total = {{ collect(session('cart', []))->sum(fn($i)=>$i['price']*$i['quantity']) }};
    document.getElementById('grandTotal').textContent = total.toLocaleString('id-ID');
}

function checkEmptyCart() {
    if({{ count(session('cart', [])) }} <= 0) {
        location.reload();
    }
}
</script>
@endsection
