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
            ['kategori' => 'Elektronik', 'nama_barang' => 'Kabel Data USB-C', 'harga' => 35000, 'stok' => 50],
            ['kategori' => 'Elektronik', 'nama_barang' => 'Powerbank 10000mAh', 'harga' => 175000, 'stok' => 20],
            ['kategori' => 'Elektronik', 'nama_barang' => 'Earphone Kabel', 'harga' => 45000, 'stok' => 35],
            ['kategori' => 'Minuman', 'nama_barang' => 'Air Mineral 600ml', 'harga' => 4000, 'stok' => 200],
            ['kategori' => 'Minuman', 'nama_barang' => 'Teh Botol 450ml', 'harga' => 6500, 'stok' => 150],
            ['kategori' => 'Minuman', 'nama_barang' => 'Kopi Susu Kemasan', 'harga' => 9000, 'stok' => 100],
            ['kategori' => 'Makanan', 'nama_barang' => 'Roti Tawar', 'harga' => 15000, 'stok' => 40],
            ['kategori' => 'Makanan', 'nama_barang' => 'Mie Instan', 'harga' => 3500, 'stok' => 300],
            ['kategori' => 'ATK', 'nama_barang' => 'Buku Tulis 38 Lembar', 'harga' => 5000, 'stok' => 3],
            ['kategori' => 'ATK', 'nama_barang' => 'Pulpen Standar', 'harga' => 2500, 'stok' => 250],
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
