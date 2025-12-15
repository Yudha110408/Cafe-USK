<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        // Data untuk admin
        $totalSales     = Transaction::sum('total_amount');
        $todaySales     = Transaction::whereDate('created_at', today())->sum('total_amount');
        $totalProducts  = Product::count();
        $recentTransactions = Transaction::with('user')->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'totalSales',
            'todaySales',
            'totalProducts',
            'recentTransactions'
        ));
    }

    public function kasirDashboard()
    {
        // Data untuk kasir - hanya transaksi mereka sendiri
        $myTransactionsToday = Transaction::where('user_id', auth()->id())
            ->whereDate('created_at', today())
            ->count();

        $mySalesToday = Transaction::where('user_id', auth()->id())
            ->whereDate('created_at', today())
            ->sum('total_amount');

        $recentTransactions = Transaction::where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return view('kasir.dashboard', compact(
            'myTransactionsToday',
            'mySalesToday',
            'recentTransactions'
        ));
    }
}
