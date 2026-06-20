<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Carbon;

class ReportsController extends Controller
{
    /**
     * Laporan Laba Rugi.
     *
     * Profit = Total Penjualan (jenis_transaksi = income) - Total Modal (jenis_transaksi = expense).
     */
    public function profitLoss()
    {
        // 1. Hitung Detail Pendapatan (jenis_transaksi = income)
        $inflowPenjualan = Transaction::where('jenis_transaksi', 'income')
            ->where('tipe_transaksi', 'penjualan')->sum('total_harga');
        $inflowPendapatanLain = Transaction::where('jenis_transaksi', 'income')
            ->where('tipe_transaksi', 'pendapatan_lain')->sum('total_harga');

        // Total Pendapatan (Mengisi variabel $total_penjualan di blade)
        $total_penjualan = $inflowPenjualan + $inflowPendapatanLain;

        // 2. Hitung Detail Beban/Biaya (jenis_transaksi = expense)
        $outflowPembelian = Transaction::where('jenis_transaksi', 'expense')
            ->where('tipe_transaksi', 'pembelian')->sum('total_harga');
        $outflowOperasional = Transaction::where('jenis_transaksi', 'expense')
            ->where('tipe_transaksi', 'operasional')->sum('total_harga');

        // Total Beban/Pengeluaran (Mengisi variabel $total_modal di blade)
        $total_modal = $outflowPembelian + $outflowOperasional;

        // 3. Rumus Laba Bersih
        $laba_bersih = $total_penjualan - $total_modal;

        // Helper teks periode bulan berjalan
        $bulanPeriode = Carbon::now()->translatedFormat('F Y');

        return view('admin.reports.profit-loss', compact(
            'inflowPenjualan', 'inflowPendapatanLain', 'total_penjualan',
            'outflowPembelian', 'outflowOperasional', 'total_modal',
            'laba_bersih', 'bulanPeriode'
        ));
    }

    /**
     * Laporan Arus Kas.
     *
     * Cash Flow = Total Pemasukan (jenis_transaksi = income) - Total Pengeluaran (jenis_transaksi = expense).
     */
    public function cashFlow()
    {
        // Jika Anda membuat fitur filter bulan/tahun, where() nya bisa disesuaikan.
        // Ini contoh mengambil keseluruhan data:

        // 1. Saldo Awal (Diambil dari transaksi bertipe 'modal')
        $modalAwal = Transaction::where('tipe_transaksi', 'modal')->sum('total_harga');

        // 2. Arus Kas Masuk (jenis_transaksi = 'income')
        $inflowPenjualan = Transaction::where('jenis_transaksi', 'income')
            ->where('tipe_transaksi', 'penjualan')->sum('total_harga');
        $inflowPendapatanLain = Transaction::where('jenis_transaksi', 'income')
            ->where('tipe_transaksi', 'pendapatan_lain')->sum('total_harga');
        $totalKasMasuk = $inflowPenjualan + $inflowPendapatanLain;

        // 3. Arus Kas Keluar (jenis_transaksi = 'expense')
        $outflowPembelian = Transaction::where('jenis_transaksi', 'expense')
            ->where('tipe_transaksi', 'pembelian')->sum('total_harga');
        $outflowOperasional = Transaction::where('jenis_transaksi', 'expense')
            ->where('tipe_transaksi', 'operasional')->sum('total_harga');
        $totalKasKeluar = $outflowPembelian + $outflowOperasional;

        // 4. Kenaikan/Penurunan Kas & Saldo Akhir
        $kenaikanPenurunanKas = $totalKasMasuk - $totalKasKeluar;
        $saldoAkhir = $modalAwal + $kenaikanPenurunanKas;

        // Tanggal cetak untuk footer laporan
        $tanggalCetak = Carbon::now()->translatedFormat('d F Y');
        $bulanPeriode = Carbon::now()->translatedFormat('F Y');

        return view('admin.reports.cash-flow', compact(
            'modalAwal', 'inflowPenjualan', 'inflowPendapatanLain', 'totalKasMasuk',
            'outflowPembelian', 'outflowOperasional', 'totalKasKeluar',
            'kenaikanPenurunanKas', 'saldoAkhir', 'tanggalCetak', 'bulanPeriode'
        ));
    }
}
