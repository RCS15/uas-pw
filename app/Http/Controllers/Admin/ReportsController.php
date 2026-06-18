<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\View\View;

class ReportsController extends Controller
{
    /**
     * Laporan Laba Rugi.
     *
     * Profit = Total Penjualan (jenis_transaksi = income) - Total Modal (jenis_transaksi = expense).
     */
    public function profitLoss(): View
    {
        $totalPenjualan = (float) Transaction::where('jenis_transaksi', 'income')->sum('total_harga');
        $totalModal = (float) Transaction::where('jenis_transaksi', 'expense')->sum('total_harga');
        $labaBersih = $totalPenjualan - $totalModal;

        return view('admin.reports.profit-loss', [
            'total_penjualan' => $totalPenjualan,
            'total_modal' => $totalModal,
            'laba_bersih' => $labaBersih,
        ]);
    }

    /**
     * Laporan Arus Kas.
     *
     * Cash Flow = Total Pemasukan (jenis_transaksi = income) - Total Pengeluaran (jenis_transaksi = expense).
     */
    public function cashFlow(): View
    {
        $totalPemasukan = (float) Transaction::where('jenis_transaksi', 'income')->sum('total_harga');
        $totalPengeluaran = (float) Transaction::where('jenis_transaksi', 'expense')->sum('total_harga');
        $arusKasBersih = $totalPemasukan - $totalPengeluaran;

        return view('admin.reports.cash-flow', [
            'total_pemasukan' => $totalPemasukan,
            'total_pengeluaran' => $totalPengeluaran,
            'arus_kas_bersih' => $arusKasBersih,
        ]);
    }
}