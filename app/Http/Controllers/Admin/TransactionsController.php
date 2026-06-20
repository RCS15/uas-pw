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
     * Tampilkan seluruh transaksi.
     */
    public function index(Request $request): View
    {

        // Diubah dari 'product' menjadi 'details.product' karena transaksi tidak punya product_id langsung
        $transactions = Transaction::with(['details.product', 'user'])
            ->filterSearch($request->search)
            ->filterType($request->type)
            ->filterTransactionType($request->transaction_type)
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
     * Simpan transaksi baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateTransaction($request);

        DB::transaction(function () use ($validated) {
            // Menghapus 'product_id' karena tidak ada di schema tabel transactions
            $transaction = Transaction::create([
                'user_id'         => Auth::id(), // Sesuai dengan pengisian otomatis user_id hidden
                'tanggal'         => $validated['tanggal'],
                'jenis_transaksi' => $validated['jenis_transaksi'],
                'tipe_transaksi'  => $validated['tipe_transaksi'],
                'deskripsi'       => $validated['deskripsi'], // Diubah dari 'description' ke 'deskripsi'
                'total_harga'     => $validated['total_harga'],
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
            'products'    => Product::orderBy('nama_barang')->get(),
        ]);
    }

    /**
     * Perbarui data transaksi.
     */
    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        $validated = $this->validateTransaction($request);

        DB::transaction(function () use ($validated, $transaction) {
            // Restore stock based on previous transaction details
            $oldTipe = $transaction->tipe_transaksi;
            foreach ($transaction->details as $detail) {
                if ($oldTipe === 'penjualan') {
                    $detail->product->increment('stok', $detail->jumlah);
                } elseif ($oldTipe === 'pembelian') {
                    $detail->product->decrement('stok', $detail->jumlah);
                }
            }

            $transaction->update([
                'tanggal'         => $validated['tanggal'],
                'jenis_transaksi' => $validated['jenis_transaksi'],
                'tipe_transaksi'  => $validated['tipe_transaksi'],
                'deskripsi'       => $validated['deskripsi'],
                'total_harga'     => $validated['total_harga'],
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
        DB::transaction(function () use ($transaction) {
            // Restore stock before deleting
            foreach ($transaction->details as $detail) {
                if ($transaction->tipe_transaksi === 'penjualan') {
                    $detail->product->increment('stok', $detail->jumlah);
                } elseif ($transaction->tipe_transaksi === 'pembelian') {
                    $detail->product->decrement('stok', $detail->jumlah);
                }
            }
            $transaction->delete();
        });

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
            'tanggal'         => ['required', 'date'],
            'jenis_transaksi' => ['required', 'in:income,expense'],
            'tipe_transaksi'  => ['required', 'in:penjualan,pendapatan_lain,pembelian,operasional,modal'],
            'deskripsi'       => ['required', 'string', 'max:255'],
            'total_harga'     => ['required', 'numeric', 'min:1'],
            'product_id'      => ['nullable', 'exists:products,id'],
            'jumlah'          => ['nullable', 'integer', 'min:1'],
        ]);
    }

    /**
     * Buat baris transaction_details jika produk & quantity diisi pada form.
     */
    private function syncDetail(Transaction $transaction, array $validated): void
    {
        if (empty($validated['product_id']) || empty($validated['jumlah'])) {
            return;
        }

        $product = Product::find($validated['product_id']);

        if (! $product) {
            return;
        }

        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id'     => $product->id,
            'jumlah'         => $validated['jumlah'],
            'harga_satuan'   => $product->harga,
            'total_harga'    => $validated['jumlah'] * (float) $product->harga,
        ]);

        // Adjust stock automatically
        if ($transaction->tipe_transaksi === 'penjualan') {
            $product->decrement('stok', $validated['jumlah']);
        } elseif ($transaction->tipe_transaksi === 'pembelian') {
            $product->increment('stok', $validated['jumlah']);
        }
    }
}