<?php

namespace App\Http\Controllers\NonAdmin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReportsController extends Controller
{
    /**
     * Tampilkan laporan harian milik kasir yang login (hari ini).
     */
    public function daily(): View
    {
        $todaysTransactions = Transaction::where('user_id', Auth::id())
            ->whereDate('tanggal', today())
            ->get();

        $totalPemasukan = (float) $todaysTransactions->where('jenis_transaksi', 'income')->sum('total_harga');
        $totalPengeluaran = (float) $todaysTransactions->where('jenis_transaksi', 'expense')->sum('total_harga');

        return view('nonadmin.reports.daily', [
            'total_pemasukan' => $totalPemasukan,
            'total_pengeluaran' => $totalPengeluaran,
            'total_bersih' => $totalPemasukan - $totalPengeluaran,
            'transaction_count' => $todaysTransactions->count(),
        ]);
    }
}