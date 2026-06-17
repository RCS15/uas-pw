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
        $totalPendapatan = (float) Transaction::where('status', 'paid')->sum('total_amount');

        $totalModal = (float) Transaction::where('status', 'paid')
            ->with('details')
            ->get()
            ->flatMap(fn (Transaction $t) => $t->details)
            ->sum(function ($detail) {
                return $detail->quantity * (float) $detail->product?->purchase_price;
            });

        $labaBersih = $totalPendapatan - $totalModal;

        $totalPiutang = (float) Transaction::whereIn('status', ['unpaid', 'pending'])->sum('total_amount');

        $recentTransactions = Transaction::with(['user', 'details.product'])
            ->latest('transaction_date')
            ->take(5)
            ->get();

        $lowStockCount = Product::where('stock', '<', 10)->count();

        return view('admin.dashboard', [
            'total_pendapatan' => $totalPendapatan,
            'total_modal' => $totalModal,
            'laba_bersih' => $labaBersih,
            'total_piutang' => $totalPiutang,
            'recent_transactions' => $recentTransactions,
            'low_stock_count' => $lowStockCount,
        ]);
    }
}