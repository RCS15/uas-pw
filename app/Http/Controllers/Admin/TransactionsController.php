<?php

namespace App\Http\Controllers\Admin;

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
     * Tampilkan seluruh transaksi (admin dapat melihat semua transaksi).
     */
    public function index(): View
    {
        $transactions = Transaction::with('product')
            ->latest('tanggal')
            ->latest('id')
            ->get();

        return view('admin.transactions.index', [
            'transactions' => $transactions,
            'products' => Product::orderBy('nama_barang')->get(),
        ]);
    }

    /**
     * Tampilkan form catat transaksi baru.
     */
    public function create(): View
    {
        return view('admin.transactions.form', [
            'products' => Product::orderBy('nama_barang')->get(),
        ]);
    }

    /**
     * Simpan transaksi baru. Jika produk & quantity diisi, baris transaction_details juga dibuat.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateTransaction($request);

        DB::transaction(function () use ($validated) {
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'tanggal' => $validated['tanggal'],
                'jenis_transaksi' => $validated['jenis_transaksi'],
                'description' => $validated['description'],
                'total_harga' => $validated['amount'],
                'product_id' => $validated['product_id'] ?? null,
            ]);

            $this->syncDetail($transaction, $validated);
        });

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil disimpan.');
    }

    /**
     * Tampilkan form edit transaksi.
     */
    public function edit(Transaction $transaction): View
    {
        return view('admin.transactions.form', [
            'transaction' => $transaction->load('details'),
            'products' => Product::orderBy('nama_barang')->get(),
        ]);
    }

    /**
     * Perbarui data transaksi.
     */
    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        $validated = $this->validateTransaction($request);

        DB::transaction(function () use ($validated, $transaction) {
            $transaction->update([
                'tanggal' => $validated['tanggal'],
                'jenis_transaksi' => $validated['jenis_transaksi'],
                'description' => $validated['description'],
                'total_harga' => $validated['amount'],
                'product_id' => $validated['product_id'] ?? null,
            ]);

            $transaction->details()->delete();
            $this->syncDetail($transaction, $validated);
        });

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Hapus transaksi dari database.
     */
    public function destroy(Transaction $transaction): RedirectResponse
    {
        $transaction->delete();

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * Validasi input form transaksi.
     *
     * @return array<string, mixed>
     */
    private function validateTransaction(Request $request): array
    {
        return $request->validate([
            'tanggal' => ['required', 'date'],
            'jenis_transaksi' => ['required', 'in:income,expense'],
            'description' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:1'],
            'product_id' => ['nullable', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);
    }

    /**
     * Buat baris transaction_details jika produk & quantity diisi pada form.
     *
     * @param  array<string, mixed>  $validated
     */
    private function syncDetail(Transaction $transaction, array $validated): void
    {
        if (empty($validated['product_id']) || empty($validated['quantity'])) {
            return;
        }

        $product = Product::find($validated['product_id']);

        if (! $product) {
            return;
        }

        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'quantity' => $validated['quantity'],
            'unit_price' => $product->harga,
            'subtotal' => $validated['quantity'] * (float) $product->harga,
        ]);
    }
}