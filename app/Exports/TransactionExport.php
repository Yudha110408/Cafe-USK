<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Transaction::with('items', 'user');

        if ($this->startDate) {
            $query->whereDate('transaction_date', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('transaction_date', '<=', $this->endDate);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No. Transaksi',
            'Tanggal',
            'Kasir',
            'Jumlah Item',
            'Total Penjualan',
            'Dibayar',
            'Kembalian',
        ];
    }

    public function map($transaction): array
    {
        return [
            '#' . str_pad($transaction->id, 6, '0', STR_PAD_LEFT),
            \Carbon\Carbon::parse($transaction->transaction_date)->format('d/m/Y H:i'),
            $transaction->user->name,
            $transaction->items->count() . ' item',
            'Rp ' . number_format($transaction->total_amount, 0, ',', '.'),
            'Rp ' . number_format($transaction->paid_amount, 0, ',', '.'),
            'Rp ' . number_format($transaction->change_amount, 0, ',', '.'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
