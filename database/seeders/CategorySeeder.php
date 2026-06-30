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
            ['nama_kategori' => 'Singkong', 'deskripsi' => 'Keripik singkong legendaris yang super renyah dan tipis, bikin nggak bisa berhenti ngunyah!'],
            ['nama_kategori' => 'Pisang', 'deskripsi' => 'Manis dan gurih alami dari pisang pilihan. Cocok banget buat teman santai bareng kopi.'],
            ['nama_kategori' => 'Ubi', 'deskripsi' => 'Keripik ubi manis alami dengan warna yang cantik. Cemilan sehat, renyah, dan kaya serat.'],
            ['nama_kategori' => 'Kentang', 'deskripsi' => 'Cemilan premium dari kentang asli berkualitas. Gurihnya pas, kriuknya juara!'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['nama_kategori' => $category['nama_kategori']],
                $category
            );
        }
    }
}