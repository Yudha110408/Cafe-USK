@extends('layouts.app')
@section('title', 'POS Kasir • ' . auth()->user()->name)

@section('content')
<!-- Initialize Global Variables -->
<script>
    let currentProductId = 0;
    let currentQty = 1;
    let currentStock = 0;

    function showQtyModal(id, name, price, stock) {
        currentProductId = id;
        currentQty = 1;
        currentStock = stock;

        document.getElementById('modalProductName').textContent = name;
        document.getElementById('modalQty').textContent = '1';
        document.getElementById('modalStock').textContent = stock;

        const modal = new bootstrap.Modal(document.getElementById('qtyModal'));
        modal.show();
    }

    function changeQty(change) {
        const newQty = currentQty + change;
        if (newQty >= 1 && newQty <= currentStock) {
            currentQty = newQty;
            document.getElementById('modalQty').textContent = currentQty;
        }
    }

    function addToCartConfirm() {
        const audio = document.getElementById('pling');
        if (audio) audio.play();

        fetch("{{ route('kasir.pos.add') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ product_id: currentProductId, quantity: currentQty })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.error || 'Gagal menambahkan ke keranjang');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
</script>

<div style="display: flex; flex-direction: column; min-height: 100vh; background: #f5f5f5;">

    <!-- HEADER -->
    <div style="background: white; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); padding: 20px; border-bottom: 1px solid #e0e0e0;">
        <div style="max-width: 100%; margin: 0 auto; padding: 0 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="margin-bottom: 4px; font-weight: 700; color: #333; font-size: 1.5rem;">
                        <i class="fas fa-cash-register" style="margin-right: 8px; color: #007bff;"></i>POS KASIR
                    </h3>
                    <p style="margin-bottom: 0; color: #666; font-size: 0.85rem;"><i class="fas fa-clock" style="margin-right: 6px;"></i>{{ now()->format('d M Y, H:i') }}</p>
                </div>
                <div style="display: flex; gap: 15px; align-items: center;">
                    <span style="background: #e8f4f8; color: #333; padding: 8px 16px; border-radius: 6px; font-weight: 500; font-size: 0.9rem;">
                        <i class="fas fa-user-circle" style="margin-right: 6px;"></i>{{ auth()->user()->name }}
                    </span>
                    <a href="{{ route('kasir.pos.cart') }}" style="background: #28a745; border: none; border-radius: 6px; padding: 10px 20px; font-weight: 600; color: white; text-decoration: none; position: relative; display: inline-block; cursor: pointer; font-size: 0.9rem;">
                        <i class="fas fa-shopping-cart" style="margin-right: 6px;"></i>Keranjang
                        @if(count(session('cart', [])) > 0)
                            <span style="position: absolute; top: -8px; right: -8px; background: #dc3545; color: white; font-weight: 700; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem;">
                                {{ count(session('cart', [])) }}
                            </span>
                        @endif
                    </a>
                    <a href="{{ route('kasir.history') }}" style="background: #f8f9fa; border: 1px solid #ddd; border-radius: 6px; padding: 10px 16px; color: #333; font-weight: 500; text-decoration: none; cursor: pointer; font-size: 0.9rem;">
                        <i class="fas fa-history"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- SEARCH BAR -->
    <div style="background: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); position: sticky; top: 0; z-index: 100; padding: 15px 20px; border-bottom: 1px solid #e0e0e0;">
        <div style="max-width: 100%; margin: 0 auto; padding: 0 20px;">
            <div style="border: 1px solid #ddd; border-radius: 6px; overflow: hidden; background: white;">
                <div style="display: flex; align-items: center; padding: 0 15px;">
                    <i class="fas fa-search" style="color: #999; font-size: 1rem; margin-right: 10px;"></i>
                    <input type="text" id="searchProduct"
                           style="flex: 1; border: none; background: transparent; font-weight: 500; font-size: 0.95rem; color: #333; padding: 12px 0; outline: none;"
                           placeholder="Cari produk atau scan barcode..." autocomplete="off">
                </div>
            </div>
        </div>
    </div>

    <!-- DAFTAR PRODUK UTAMA -->
    <div style="padding: 20px; flex-grow: 1; overflow-y: auto;">
        <div style="max-width: 100%; margin: 0 auto; padding: 0 20px;">
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 15px;" id="productGrid">
                @foreach($products as $p)
                <div class="product-item" style="position: relative;">
                    <div style="background: white; border-radius: 8px; overflow: hidden; border: 1px solid #e0e0e0; cursor: pointer; height: 100%; display: flex; flex-direction: column; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08); transition: all 0.2s ease;"
                         onclick="showQtyModal({{ $p->id }}, '{{ addslashes($p->name) }}', {{ $p->price }}, {{ $p->stock }})"
                         onmouseover="this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.15)'; this.style.transform='translateY(-2px)';"
                         onmouseout="this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.08)'; this.style.transform='translateY(0)';">

                        <!-- Image -->
                        @if($p->image)
                            <img src="{{ asset('storage/'.$p->image) }}" style="height: 140px; object-fit: cover; width: 100%; background: #f0f0f0;">
                        @else
                            <div style="height: 140px; background: #f5f5f5; display: flex; align-items: center; justify-content: center; width: 100%; color: #999;">
                                <i class="fas fa-box fa-2x"></i>
                            </div>
                        @endif

                        <!-- Stock Badge -->
                        <span style="position: absolute; top: 8px; right: 8px; padding: 4px 10px; border-radius: 4px; font-weight: 600; font-size: 0.7rem; background: {{ $p->stock > 0 ? '#28a745' : '#dc3545' }}; color: white;">
                            {{ $p->stock }} pcs
                        </span>

                        <!-- Content -->
                        <div style="padding: 12px; text-align: center; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                            <h6 style="font-size: 0.85rem; font-weight: 600; color: #333; height: 40px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; margin-bottom: 6px;">
                                {{ $p->name }}
                            </h6>
                            <div>
                                <p style="font-size: 1.1rem; font-weight: 700; color: #28a745; margin-bottom: 6px;">
                                    Rp {{ number_format($p->price) }}
                                </p>
                                @if($p->category)
                                    <span style="display: inline-block; background: #e3f2fd; color: #1976d2; padding: 3px 6px; border-radius: 3px; font-size: 0.7rem; font-weight: 500;">
                                        {{ $p->category->name }}
                                    </span>
                                @else
                                    <span style="display: inline-block; background: #f0f0f0; color: #666; padding: 3px 6px; border-radius: 3px; font-size: 0.7rem; font-weight: 500;">
                                        Tanpa Kategori
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- TOTAL & TOMBOL BAYAR -->
    <div style="background: white; box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.1); padding: 18px 20px; border-top: 1px solid #e0e0e0;">
        <div style="max-width: 100%; margin: 0 auto; padding: 0 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: center;">
                <!-- Left: Total -->
                <div>
                    <p style="margin-bottom: 6px; color: #666; font-weight: 500; font-size: 0.9rem;">Total Belanja:</p>
                    <h1 style="margin-bottom: 2px; font-weight: 700; color: #28a745; font-size: 1.8rem;">
                        Rp <span id="totalAmount">0</span>
                    </h1>
                    <small style="color: #999; font-size: 0.85rem;">
                        <i class="fas fa-shopping-bag" style="margin-right: 4px;"></i>{{ count(session('cart', [])) }} item di keranjang
                    </small>
                </div>

                <!-- Right: Buttons -->
                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <a href="{{ route('kasir.pos.cart') }}"
                       style="background: white; border: 1px solid #007bff; color: #007bff; border-radius: 6px; padding: 12px 24px; font-weight: 600; text-decoration: none; cursor: pointer; transition: all 0.2s ease; font-size: 0.9rem;"
                       onmouseover="this.style.background='#007bff'; this.style.color='white';"
                       onmouseout="this.style.background='white'; this.style.color='#007bff';">
                        <i class="fas fa-shopping-cart" style="margin-right: 6px;"></i>Keranjang
                    </a>
                    <a href="{{ route('kasir.pos.checkout.show') }}"
                       style="background: #28a745; border: none; color: white; border-radius: 6px; padding: 12px 30px; font-weight: 600; text-decoration: none; cursor: pointer; box-shadow: 0 2px 6px rgba(40, 167, 69, 0.2); transition: all 0.2s ease; font-size: 0.9rem;"
                       onmouseover="this.style.boxShadow='0 4px 12px rgba(40, 167, 69, 0.4)';"
                       onmouseout="this.style.boxShadow='0 2px 6px rgba(40, 167, 69, 0.2)';">
                        <i class="fas fa-credit-card" style="margin-right: 6px;"></i>BAYAR
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL JUMLAH -->
<div class="modal fade" id="qtyModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div style="border-radius: 8px; border: none; overflow: hidden; background: white; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);">
            <!-- Modal Header -->
            <div style="background: #007bff; padding: 16px 24px; border: none; display: flex; justify-content: space-between; align-items: center;">
                <h5 style="margin: 0; color: white; font-weight: 600; font-size: 1.1rem;" id="modalProductName"></h5>
                <button type="button" style="background: none; border: none; color: white; font-size: 1.5rem; cursor: pointer; padding: 0;" data-bs-dismiss="modal">×</button>
            </div>

            <!-- Modal Body -->
            <div style="text-align: center; padding: 30px;">
                <p style="color: #666; margin-bottom: 24px; font-weight: 500;">Masukkan Jumlah Pembelian</p>

                <!-- Quantity Controls -->
                <div style="display: flex; align-items: center; justify-content: center; gap: 20px; margin-bottom: 24px;">
                    <button type="button"
                            style="width: 50px; height: 50px; border-radius: 50%; background: #dc3545; border: none; color: white; font-size: 1.3rem; font-weight: bold; cursor: pointer; pointer-events: auto !important; box-shadow: 0 2px 6px rgba(220, 53, 69, 0.2);"
                            onclick="changeQty(-1); return false;">
                        −
                    </button>
                    <h1 id="modalQty" style="margin: 0; width: 100px; font-size: 3rem; font-weight: 700; color: #007bff;">
                        1
                    </h1>
                    <button type="button"
                            style="width: 50px; height: 50px; border-radius: 50%; background: #28a745; border: none; color: white; font-size: 1.3rem; font-weight: bold; cursor: pointer; pointer-events: auto !important; box-shadow: 0 2px 6px rgba(40, 167, 69, 0.2);"
                            onclick="changeQty(1); return false;">
                        +
                    </button>
                </div>

                <!-- Stock Alert -->
                <div style="border-radius: 6px; background: #e8f4f8; border: 1px solid #b3d9e8; padding: 12px 16px;">
                    <i class="fas fa-box" style="margin-right: 6px; color: #0288d1;"></i>
                    <span style="color: #01579b; font-size: 0.9rem;">Stok tersedia: <strong><span id="modalStock">0</span> pcs</strong></span>
                </div>
            </div>

            <!-- Modal Footer -->
            <div style="border-top: 1px solid #e0e0e0; padding: 16px 24px; display: flex; gap: 10px;">
                <button type="button" data-bs-dismiss="modal"
                        style="flex: 1; border-radius: 6px; background: #f0f0f0; color: #333; font-weight: 600; border: none; padding: 10px 16px; cursor: pointer; pointer-events: auto !important; font-size: 0.9rem;">
                    <i class="fas fa-times" style="margin-right: 6px;"></i>Batal
                </button>
                <button type="button"
                        style="flex: 1; border-radius: 6px; background: #28a745; border: none; color: white; font-weight: 600; padding: 10px 16px; cursor: pointer; box-shadow: 0 2px 6px rgba(40, 167, 69, 0.2); pointer-events: auto !important; font-size: 0.9rem;"
                        onclick="addToCartConfirm(); return false;">
                    <i class="fas fa-cart-plus" style="margin-right: 6px;"></i>Tambah
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Dark Mode Styles -->
<style>
    body.dark-mode {
        background: #1a1a1a !important;
    }

    body.dark-mode div[style*="background: white"] {
        background: #2d2d2d !important;
        color: #e0e0e0 !important;
    }

    body.dark-mode h3,
    body.dark-mode h6,
    body.dark-mode p[style*="color: #333"] {
        color: #e0e0e0 !important;
    }

    body.dark-mode input {
        background: #3a3a3a !important;
        color: #e0e0e0 !important;
        border-color: #555 !important;
    }

    body.dark-mode input::placeholder {
        color: #999 !important;
    }

    /* Modal Button Fix */
    .modal-dialog button {
        pointer-events: auto !important;
    }

    .modal button[type="button"] {
        pointer-events: auto !important;
    }
</style>
@endsection

<script>
// Initialize event listeners when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Setup search functionality
    const searchInput = document.getElementById('searchProduct');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const q = this.value.toLowerCase().trim();
            document.querySelectorAll('.product-item').forEach(item => {
                const nameElement = item.querySelector('h6');
                if (nameElement) {
                    const matches = nameElement.textContent.toLowerCase().includes(q);
                    item.style.display = q === '' || matches ? 'block' : 'none';
                }
            });
        });
    }

    // Calculate total
    const cart = @json(session('cart', []));
    let total = 0;
    Object.values(cart).forEach(item => {
        total += item.price * item.quantity;
    });
    const totalElement = document.getElementById('totalAmount');
    if (totalElement) {
        totalElement.innerHTML = total.toLocaleString('id-ID');
    }
});
</script>
<audio id="pling" src="{{ asset('sounds/pling.mp3') }}" preload="auto"></audio>

