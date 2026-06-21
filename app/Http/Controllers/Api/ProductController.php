<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * INDEX: Menampilkan semua produk
     * URL: GET /api/products
     */
    public function index()
    {
        $products = Product::with('category')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data produk berhasil diambil',
            'data' => $products
        ], 200);
    }

    /**
     * SHOW: Menampilkan detail 1 produk
     * URL: GET /api/products/{id}
     */
    public function show(string $id)
    {
        $product = Product::with('category')->find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Produk tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detail Produk Ditemukan',
            'data' => $product
        ], 200);
    }

    /**
     * STORE: Membuat produk baru
     * URL: POST /api/products
     * Body (JSON/Form-Data): category_id, nama_barang, harga, stok
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'nama_barang' => ['required', 'string', 'max:100'],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
        ]);

        $product = Product::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Produk Berhasil Ditambahkan',
            'data' => $product
        ], 201);
    }

    /**
     * UPDATE: Memperbarui data produk
     * URL: PUT/PATCH /api/products/{id}
     * Body (JSON/Form-Data): category_id, nama_barang, harga, stok
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Produk tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'nama_barang' => ['required', 'string', 'max:100'],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
        ]);

        $product->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Produk Berhasil Diperbarui',
            'data' => $product
        ], 200);
    }

    /**
     * DESTROY: Menghapus produk
     * URL: DELETE /api/products/{id}
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Produk tidak ditemukan',
            ], 404);
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Produk Berhasil Dihapus',
        ], 200);
    }
}
