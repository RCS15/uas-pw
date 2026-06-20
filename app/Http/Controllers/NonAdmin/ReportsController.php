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
        // Ambil semua transaksi milik kasir yang sedang login khusus hari ini
        $todaysTransactions = Transaction::where('user_id', Auth::id())
            ->whereDate('tanggal', today())
            ->get();

        // Hitung pemasukan (income) dan pengeluaran (expense) dari database
        $totalPemasukan = (float) $todaysTransactions->where('jenis_transaksi', 'income')->sum('total_harga');
        $totalPengeluaran = (float) $todaysTransactions->where('jenis_transaksi', 'expense')->sum('total_harga');

        return view('nonadmin.reports.daily', [
            // UTAMA: Variabel ini yang dibaca di dalam file Blade Anda
            'total_penjualan'   => $totalPemasukan, 
            
            // TAMBAHAN: Tetap dikirimkan jika sewaktu-waktu ingin ditambahkan ke UI laporan
            'total_pengeluaran' => $totalPengeluaran,
            'total_bersih'      => $totalPemasukan - $totalPengeluaran,
            'transaction_count' => $todaysTransactions->count(),
        ]);
    }
}