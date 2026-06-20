<?php

namespace App\Http\Controllers\NonAdmin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductsController extends Controller
{
    /**
     * Tampilkan katalog produk (hanya melihat, tanpa hak ubah).
     */
    public function index(Request $request): View
    {
        // Prepare filters for the Product model
        $filters = $request->only(['search', 'category_id']);

        $products = Product::latest()
            ->filter($filters)
            ->paginate(12)
            ->withQueryString();

        return view('nonadmin.products.index', [
            'products' => $products,
            'categories' => Category::all()
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