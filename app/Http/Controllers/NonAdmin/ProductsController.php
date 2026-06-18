<?php

namespace App\Http\Controllers\NonAdmin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\View\View;

class ProductsController extends Controller
{
    /**
     * Tampilkan katalog produk (hanya melihat, tanpa hak ubah).
     */
    public function index(): View
    {
        $products = Product::with('category')->orderBy('nama_barang')->get();

        return view('nonadmin.products.index', [
            'products' => $products,
        ]);
    }

    /**
     * Tampilkan detail satu produk.
     */
    public function show(Product $product): View
    {
        return view('nonadmin.products.show', [
            'product' => $product->load('category'),
        ]);
    }
}