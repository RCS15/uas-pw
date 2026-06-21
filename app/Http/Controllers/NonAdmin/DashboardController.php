<?php

namespace App\Http\Controllers\NonAdmin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
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

        // ✅ Gunakan query agregat langsung — tidak perlu load semua baris ke memory
        $summaryHariIni = Transaction::where('user_id', $userId)
            ->whereDate('tanggal', today())
            ->selectRaw('
                COUNT(*) as jumlah_transaksi,
                COALESCE(SUM(total_harga), 0) as omzet_hari_ini
            ')
            ->first();

        // ✅ Hitung item terjual via join langsung, tidak perlu flatMap di PHP
        $itemTerjual = DB::table('transaction_details')
            ->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->where('transactions.user_id', $userId)
            ->whereDate('transactions.tanggal', today())
            ->sum('transaction_details.jumlah');

        // ✅ Popular products: tambahkan filter rentang tanggal yang wajar (misal 30 hari)
        //    agar query tidak makin lambat seiring bertambahnya data historis.
        //    Uncomment ->where('transactions.user_id', $userId) jika ingin per-kasir.
        $popularProducts = Product::join('transaction_details', 'products.id', '=', 'transaction_details.product_id')
            ->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->whereDate('transactions.tanggal', '>=', now()->subDays(30)) // ✅ Batasi rentang data
            // ->where('transactions.user_id', $userId) // Aktifkan jika ingin per-kasir
            ->select(
                'products.id',
                'products.nama_barang',
                'products.harga',
                'products.stok',
                DB::raw('SUM(transaction_details.jumlah) as total_terjual'),
                DB::raw('SUM(transaction_details.subtotal) as total_pendapatan')
            )
            ->groupBy('products.id', 'products.nama_barang', 'products.harga', 'products.stok')
            ->orderByDesc('total_terjual')
            ->take(3) // ✅ Konsisten: ambil top 3
            ->get();

        // ✅ Recent transactions: sudah efisien, hanya ambil 4 terakhir
        $recentTransactions = Transaction::where('user_id', $userId)
            ->with('details.product')
            ->latest('tanggal')
            ->latest('id')
            ->take(4)
            ->get();

        return view('nonadmin.dashboard', [
            'omzet_hari_ini'       => (float) ($summaryHariIni->omzet_hari_ini ?? 0),
            'jumlah_transaksi'     => (int) ($summaryHariIni->jumlah_transaksi ?? 0),
            'total_barang_terjual' => (int) $itemTerjual,
            'recent_transactions'  => $recentTransactions,
            'popular_products'     => $popularProducts,
        ]);
    }
}