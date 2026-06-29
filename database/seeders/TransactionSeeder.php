<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Carbon;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Dapatkan atau buat User (sebagai kasir/admin)
        $user = User::first() ?? User::factory()->create();

        // 2. Dapatkan beberapa produk dari database (pastikan ProductSeeder sudah berjalan)
        $products = Product::take(5)->get();
        if ($products->isEmpty()) {
            return; // Jangan lanjutkan jika tidak ada produk
        }

        // ==========================================
        // Skenario 1: Transaksi Penjualan (Income)
        // ==========================================
        $transaksiPenjualan = Transaction::create([
            'tanggal'         => Carbon::now()->subDays(2),
            'jenis_transaksi' => 'income',
            'tipe_transaksi'  => 'penjualan',
            'deskripsi'       => 'Penjualan ke pelanggan (Shift Siang)',
            'total_harga'     => 0, // Akan dihitung ulang
            'user_id'         => $user->id,
        ]);

        $totalPenjualan = 0;
        foreach ($products->take(2) as $product) {
            $qty = rand(1, 5);
            $subtotal = $qty * $product->harga;
            
            TransactionDetail::create([
                'transaction_id' => $transaksiPenjualan->id,
                'product_id'     => $product->id,
                'jumlah'         => $qty,
                'harga_satuan'   => $product->harga,
                'subtotal'       => $subtotal,
            ]);
            $totalPenjualan += $subtotal;
        }

        // Update total harga transaksi
        $transaksiPenjualan->update(['total_harga' => $totalPenjualan]);


        // ==========================================
        // Skenario 2: Transaksi Pembelian (Expense)
        // ==========================================
        $transaksiPembelian = Transaction::create([
            'tanggal'         => Carbon::now()->subDays(1),
            'jenis_transaksi' => 'expense',
            'tipe_transaksi'  => 'pembelian',
            'deskripsi'       => 'Restock barang dari supplier',
            'total_harga'     => 0, // Akan dihitung ulang
            'user_id'         => $user->id,
        ]);

        $totalPembelian = 0;
        foreach ($products->skip(2)->take(3) as $product) {
            $qty = rand(10, 20);
            $hargaBeli = $product->harga * 0.7; // Asumsi harga beli lebih murah 30%
            $subtotal = $qty * $hargaBeli;
            
            TransactionDetail::create([
                'transaction_id' => $transaksiPembelian->id,
                'product_id'     => $product->id,
                'jumlah'         => $qty,
                'harga_satuan'   => $hargaBeli,
                'subtotal'       => $subtotal,
            ]);
            $totalPembelian += $subtotal;
            
            // (Opsional) Update stok karena pembelian
            $product->increment('stok', $qty);
        }

        // Update total harga transaksi pembelian
        $transaksiPembelian->update(['total_harga' => $totalPembelian]);


        // ==========================================
        // Skenario 3: Transaksi Operasional (Expense)
        // ==========================================
        Transaction::create([
            'tanggal'         => Carbon::now(),
            'jenis_transaksi' => 'expense',
            'tipe_transaksi'  => 'operasional',
            'deskripsi'       => 'Membayar listrik dan air',
            'total_harga'     => 150000,
            'user_id'         => $user->id,
        ]);
        
        // ==========================================
        // Skenario 4: Modal Awal
        // ==========================================
        Transaction::create([
            'tanggal'         => Carbon::now()->startOfMonth(),
            'jenis_transaksi' => 'income',
            'tipe_transaksi'  => 'modal',
            'deskripsi'       => 'Setoran modal awal bulan',
            'total_harga'     => 5000000,
            'user_id'         => $user->id,
        ]);
    }
}
