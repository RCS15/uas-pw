<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Kategori: Singkong
            ['kategori' => 'Singkong', 'nama_barang' => 'Keripik Singkong Original (100g)', 'harga' => 10000, 'stok' => 45],
            ['kategori' => 'Singkong', 'nama_barang' => 'Keripik Singkong Balado Pedas (150g)', 'harga' => 13000, 'stok' => 30],
            ['kategori' => 'Singkong', 'nama_barang' => 'Keripik Singkong Barbeque (150g)', 'harga' => 13000, 'stok' => 25],
            ['kategori' => 'Singkong', 'nama_barang' => 'Singkong Karatan / Bal-balan (1kg)', 'harga' => 65000, 'stok' => 4],

            // Kategori: Pisang
            ['kategori' => 'Pisang', 'nama_barang' => 'Keripik Pisang Manis Klasik (120g)', 'harga' => 12000, 'stok' => 40],
            ['kategori' => 'Pisang', 'nama_barang' => 'Keripik Pisang Gurih Asin (120g)', 'harga' => 12000, 'stok' => 35],
            ['kategori' => 'Pisang', 'nama_barang' => 'Keripik Pisang Cokelat Lumer (200g)', 'harga' => 18000, 'stok' => 20],

            // Kategori: Ubi
            ['kategori' => 'Ubi', 'nama_barang' => 'Keripik Ubi Ungu Manis (100g)', 'harga' => 11000, 'stok' => 30],
            ['kategori' => 'Ubi', 'nama_barang' => 'Keripik Ubi Madu Renyah (100g)', 'harga' => 11000, 'stok' => 2],

            // Kategori: Kentang
            ['kategori' => 'Kentang', 'nama_barang' => 'Keripik Kentang Original Salted (80g)', 'harga' => 15000, 'stok' => 20],
            ['kategori' => 'Kentang', 'nama_barang' => 'Keripik Kentang Mustofa Pedas (250g)', 'harga' => 35000, 'stok' => 15],
        ];

        foreach ($products as $product) {
            $category = Category::where('nama_kategori', $product['kategori'])->first();

            if (! $category) {
                continue;
            }

            Product::updateOrCreate(
                ['nama_barang' => $product['nama_barang']],
                [
                    'harga' => $product['harga'],
                    'stok' => $product['stok'],
                    'category_id' => $category->id,
                ]
            );
        }
    }
}
