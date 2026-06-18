<?php

namespace App\Http\Controllers\NonAdmin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard nonadmin (staf/kasir) dengan ringkasan transaksi miliknya hari ini.
     */
    public function index(): View
    {
        $userId = Auth::id();

        $todaysTransactions = Transaction::where('user_id', $userId)
            ->whereDate('tanggal', today())
            ->get();

        $omzetHariIni = (float) $todaysTransactions->where('jenis_transaksi', 'income')->sum('total_harga');
        $jumlahTransaksi = $todaysTransactions->count();

        $recentTransactions = Transaction::where('user_id', $userId)
            ->with('product')
            ->latest('tanggal')
            ->latest('id')
            ->take(5)
            ->get();

        return view('nonadmin.dashboard', [
            'omzet_hari_ini' => $omzetHariIni,
            'jumlah_transaksi' => $jumlahTransaksi,
            'recent_transactions' => $recentTransactions,
        ]);
    }
}