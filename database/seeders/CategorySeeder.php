<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['nama_kategori' => 'Elektronik', 'deskripsi' => 'Perangkat dan aksesoris elektronik.'],
            ['nama_kategori' => 'Minuman', 'deskripsi' => 'Beragam minuman kemasan dan segar.'],
            ['nama_kategori' => 'Makanan', 'deskripsi' => 'Makanan ringan maupun berat.'],
            ['nama_kategori' => 'ATK', 'deskripsi' => 'Alat tulis kantor dan perlengkapan sekolah.'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['nama_kategori' => $category['nama_kategori']],
                $category
            );
        }
    }
}