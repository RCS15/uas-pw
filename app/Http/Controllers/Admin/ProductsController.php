<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductsController extends Controller
{
    /**
     * Tampilkan katalog seluruh produk.
     */
    public function index(): View
    {
        $products = Product::with('category')->latest()->get();

        return view('admin.products.index', [
            'products' => $products,
        ]);
    }

    /**
     * Tampilkan form tambah produk baru.
     */
    public function create(): View
    {
        return view('admin.products.form', [
            'categories' => Category::orderBy('nama_kategori')->get(),
        ]);
    }

    /**
     * Simpan produk baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProduct($request);

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk baru berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit produk.
     */
    public function edit(Product $product): View
    {
        return view('admin.products.form', [
            'product' => $product,
            'categories' => Category::orderBy('nama_kategori')->get(),
        ]);
    }

    /**
     * Perbarui data produk.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $this->validateProduct($request);

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus produk dari database.
     */
    public function destroy(Product $product): RedirectResponse
    {
        if ($product->transactionDetails()->exists() || $product->transactions()->exists()) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Produk tidak bisa dihapus karena sudah memiliki riwayat transaksi.');
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Validasi input form produk.
     *
     * @return array<string, mixed>
     */
    private function validateProduct(Request $request): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'nama_barang' => ['required', 'string', 'max:100'],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
        ]);
    }
}