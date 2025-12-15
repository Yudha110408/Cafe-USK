<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;

class TransactionController extends Controller
{
    public function pos()
    {
        $products = Product::with('category')->where('stock', '>', 0)->latest()->get();
        return view('kasir.pos', compact('products'));
    }

    public function cart()
    {
        $cart = session('cart', []);
        return view('kasir.cart', compact('cart'));
    }

    public function showCheckout()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('kasir.pos.index')->with('error', 'Keranjang kosong!');
        }

        $total = $this->calculateTotal($cart);
        return view('kasir.checkout', compact('cart', 'total'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart    = session('cart', []);
        $current = $cart[$product->id]['quantity'] ?? 0;
        $newQty  = $current + $request->quantity;

        if ($product->stock < $newQty) {
            return response()->json([
                'error' => "Stok {$product->name} tidak cukup! Tersisa {$product->stock}"
            ], 400);
        }

        $cart[$product->id] = [
            'name'     => $product->name,
            'price'    => $product->price,
            'quantity' => $newQty,
            'image'    => $product->image
        ];

        session(['cart' => $cart]);

        return response()->json([
            'success' => true,
            'message' => "Ditambahkan!",
            'total'   => $this->calculateTotal($cart),
            'count'   => count($cart)
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        $cart = session('cart', []);
        unset($cart[$request->product_id]);
        session(['cart' => $cart]);
        return response()->json(['success' => true]);
    }

    public function clearCart()
    {
        session()->forget('cart');
        return response()->json(['success' => true]);
    }

    public function checkout(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('kasir.pos.index')->with('error', 'Keranjang kosong!');
        }

        $total = $this->calculateTotal($cart);
        $paid  = (int)($request->paid_amount ?? 0);

        if ($paid < $total) {
            return back()->with('error', 'Uang tidak cukup! Kurang Rp ' . number_format($total - $paid));
        }

        $transaction = Transaction::create([
            'user_id'       => auth()->id(),
            'total_amount'   => $total,
            'paid_amount'    => $paid,
            'change_amount'  => $paid - $total,
            'transaction_date' => now(),
        ]);

        foreach ($cart as $id => $item) {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id'     => $id,
                'quantity'       => $item['quantity'],
                'price_at_sale'  => $item['price'],
                'subtotal'       => $item['price'] * $item['quantity']
            ]);
            Product::where('id', $id)->decrement('stock', $item['quantity']);
        }

        session()->forget('cart');

        return redirect()->route('kasir.receipt', $transaction->id)
                 ->with('success', 'Transaksi berhasil!');
    }

    public function receipt($id)
    {
        $transaction = Transaction::with('items.product')->findOrFail($id);
        return view('kasir.receipt', compact('transaction'));
    }

    public function history()
    {
        $transactions = Transaction::with('items.product')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        return view('kasir.history', compact('transactions'));
    }

    public function scanBarcode(Request $request)
    {
        $barcode = trim($request->barcode);
        $product = Product::where('slug', $barcode)
                          ->orWhere('name', 'like', "%{$barcode}%")
                          ->first();

        if (!$product) return response()->json(['error' => 'Produk tidak ditemukan!'], 404);
        if ($product->stock < 1) return response()->json(['error' => 'Stok habis!'], 400);

        return response()->json(['success' => true, 'product' => $product]);
    }

    private function calculateTotal($cart)
    {
        return collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
    }
}
