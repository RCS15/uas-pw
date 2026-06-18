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
     * Simpan transaksi penjualan baru milik kasir yang login.
     *
     * Transaksi yang dicatat staf/kasir selalu bertipe "income" (pemasukan dari penjualan).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal' => ['required', 'date'],
            'description' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:1'],
            'product_id' => ['nullable', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        DB::transaction(function () use ($validated) {
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'tanggal' => $validated['tanggal'],
                'jenis_transaksi' => 'income',
                'description' => $validated['description'],
                'total_harga' => $validated['amount'],
                'product_id' => $validated['product_id'] ?? null,
            ]);

            if (! empty($validated['product_id']) && ! empty($validated['quantity'])) {
                $product = Product::find($validated['product_id']);

                if ($product) {
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $product->id,
                        'quantity' => $validated['quantity'],
                        'unit_price' => $product->harga,
                        'subtotal' => $validated['quantity'] * (float) $product->harga,
                    ]);
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
            ->with('product')
            ->latest('tanggal')
            ->latest('id')
            ->get();

        return view('nonadmin.transactions.history', [
            'transactions' => $transactions,
        ]);
    }
}