<?php

namespace App\Http\Controllers\NonAdmin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TransactionsController extends Controller
{
    /**
     * Tampilkan form catat transaksi penjualan baru.
     */
    public function create(): View
    {
        return view('nonadmin.transactions.create', [
            'products' => Product::orderBy('nama_barang')->get(),
        ]);
    }

    /**
     * Simpan transaksi penjualan baru (Multi-Product sesuai Gambar Database).
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi input array dari form (nama input qty dari blade adalah 'qty')
        $validated = $request->validate([
            'tanggal' => ['required', 'date'],
            'deskripsi' => ['required', 'string', 'max:255'],
            'total_harga' => ['required', 'numeric', 'min:1'],
            'product_id' => ['required', 'array', 'min:1'],
            'product_id.*' => ['required', 'exists:products,id'],
            'qty' => ['required', 'array', 'min:1'],
            'qty.*' => ['required', 'integer', 'min:1'],
        ]);

        // 2. Gunakan DB Transaction untuk mengamankan data Master-Detail
        DB::transaction(function () use ($validated) {
            
            // Simpan ke Tabel Master: transactions
            // Kolom 'product_id' di tabel ini kita biarkan null atau abaikan karena pindah ke detail
            $transaction = Transaction::create([
                'user_id' => Auth::id(), 
                'tanggal' => $validated['tanggal'],
                'jenis_transaksi' => 'income',
                'tipe_transaksi' => 'penjualan',
                'deskripsi' => $validated['deskripsi'],
                'total_harga' => $validated['total_harga'],
            ]);

            // Loop seluruh produk di keranjang belanja untuk transaksi detail
            foreach ($validated['product_id'] as $index => $productId) {
                $product = Product::find($productId);

                if ($product) {
                    $qtyMasuk = (int) $validated['qty'][$index];
                    $hargaProduk = (float) $product->harga;

                    // Simpan ke Tabel Detail: transaction_details (Disesuaikan dengan gambar kolom Anda)
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id, // Merujuk ke transactions.id
                        'product_id' => $product->id,         // Merujuk ke products.id
                        'jumlah' => $qtyMasuk,                 // Kolom 'jumlah' sesuai gambar
                        'harga_satuan' => $hargaProduk,        // Kolom 'harga_satuan' sesuai gambar
                        'subtotal' => $qtyMasuk * $hargaProduk, // Kolom 'subtotal' sesuai gambar
                    ]);

                    // Otomatis kurangi stok karena ini adalah transaksi penjualan
                    $product->decrement('stok', $qtyMasuk);
                }
            }
        });

        return redirect()->route('nonadmin.transactions.history')
            ->with('success', 'Transaksi penjualan berhasil disimpan.');
    }

    /**
     * Tampilkan riwayat transaksi milik kasir yang login.
     */
    public function history(): View
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with('details.product')
            ->latest('tanggal')
            ->latest('id')
            ->get();

        return view('nonadmin.transactions.history', [
            'transactions' => $transactions,
        ]);
    }
}