<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Transaction::query();

        if ($startDate) {
            $query->whereDate('transaction_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('transaction_date', '<=', $endDate);
        }

        $transactions = $query->with('items', 'user')->latest()->get();
        $totalSales = $transactions->sum('total_amount');

        return view('admin.reports.index', compact('transactions', 'totalSales', 'startDate', 'endDate'));
    }

    public function generate(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Transaction::query();

        if ($startDate) {
            $query->whereDate('transaction_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('transaction_date', '<=', $endDate);
        }

        $transactions = $query->with('items', 'user')->latest()->get();

        return view('admin.reports.generate', compact('transactions', 'startDate', 'endDate'));
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Transaction::query();

        if ($startDate) {
            $query->whereDate('transaction_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('transaction_date', '<=', $endDate);
        }

        $transactions = $query->with('items', 'user')->latest()->get();
        $totalSales = $transactions->sum('total_amount');

        $pdf = Pdf::loadView('admin.reports.pdf', compact('transactions', 'totalSales', 'startDate', 'endDate'));
        return $pdf->download('laporan_penjualan.pdf');
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        return Excel::download(new \App\Exports\TransactionExport($startDate, $endDate), 'laporan_penjualan.xlsx');
    }
}
