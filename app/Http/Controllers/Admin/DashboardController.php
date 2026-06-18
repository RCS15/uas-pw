<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin dengan ringkasan KPI keuangan.
     */
    public function index(): View
    {
        $totalPendapatan = (float) Transaction::where('jenis_transaksi', 'income')->sum('total_harga');
        $totalPengeluaran = (float) Transaction::where('jenis_transaksi', 'expense')->sum('total_harga');
        $labaBersih = $totalPendapatan - $totalPengeluaran;

        $recentTransactions = Transaction::with(['user', 'product'])
            ->latest('tanggal')
            ->latest('id')
            ->take(5)
            ->get();

        $lowStockCount = Product::where('stok', '<', 10)->count();

        return view('admin.dashboard', [
            'total_pendapatan' => $totalPendapatan,
            'total_pengeluaran' => $totalPengeluaran,
            'laba_bersih' => $labaBersih,
            'recent_transactions' => $recentTransactions,
            'low_stock_count' => $lowStockCount,
        ]);
    }
}