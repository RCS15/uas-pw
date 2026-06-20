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

        $todaysTransactions = Transaction::where('user_id', $userId)
            ->whereDate('tanggal', today())
            ->with('details')
            ->get();

        $omzetHariIni = (float) $todaysTransactions->sum('total_harga');

        $jumlahTransaksi = $todaysTransactions->count();

        $itemTerjual = $todaysTransactions->flatMap(function ($transaction) {
            return $transaction->details;
        })->sum('jumlah');

        $popularProducts = Product::join('transaction_details', 'products.id', '=', 'transaction_details.product_id')
            ->join('transactions', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->where('transactions.user_id', $userId) // Khusus performa kasir yang login
            ->select(
                'products.id',
                'products.nama_barang',
                'products.harga',
                'products.stok',
                DB::raw('SUM(transaction_details.jumlah) as total_terjual'),
                DB::raw('SUM(transaction_details.subtotal) as total_pendapatan')
            )
            ->groupBy('products.id', 'products.nama_barang', 'products.harga', 'products.stok')
            ->orderByDesc('total_terjual') // Urutkan dari yang paling banyak terjual
            ->take(3) // Ambil top 5 produk teratas
            ->get();

        $recentTransactions = Transaction::where('user_id', $userId)
            ->with('details.product')
            ->latest('tanggal')
            ->latest('id')
            ->take(4)
            ->get();

        return view('nonadmin.dashboard', [
            'omzet_hari_ini' => $omzetHariIni,
            'jumlah_transaksi' => $jumlahTransaksi,
            'total_barang_terjual' => $itemTerjual,
            'recent_transactions' => $recentTransactions,
            'popular_products'     => $popularProducts,
        ]);
    }
}