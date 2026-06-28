<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    /**
     * Laporan Laba Rugi.
     *
     * Profit = Total Penjualan (jenis_transaksi = income) - Total Modal (jenis_transaksi = expense).
     */
    public function profitLoss(Request $request)
    {
        // 1. Ambil input filter dari request, jika tidak ada, default ke bulan & tahun saat ini
        $currentMonth = $request->input('month', Carbon::now()->month);
        $currentYear = $request->input('year', Carbon::now()->year);

        // 2. Hitung Detail Pendapatan (Berdasarkan filter)
        $inflowPenjualan = Transaction::where('jenis_transaksi', 'income')
            ->where('tipe_transaksi', 'penjualan')
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->sum('total_harga');

        $inflowPendapatanLain = Transaction::where('jenis_transaksi', 'income')
            ->where('tipe_transaksi', 'pendapatan_lain')
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->sum('total_harga');

        $total_pendapatan = $inflowPenjualan + $inflowPendapatanLain;

        // 3. Hitung Detail Beban/Biaya Pengeluaran (Berdasarkan filter)
        $outflowPembelian = Transaction::where('jenis_transaksi', 'expense')
            ->where('tipe_transaksi', 'pembelian')
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->sum('total_harga');

        $outflowOperasional = Transaction::where('jenis_transaksi', 'expense')
            ->where('tipe_transaksi', 'operasional')
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->sum('total_harga');

        $total_pengeluaran = $outflowPembelian + $outflowOperasional;

        // 4. Rumus Perhitungan Keuntungan
        $laba_kotor = $inflowPenjualan - $outflowPembelian;
        $laba_bersih = $total_pendapatan - $total_pengeluaran;

        // 5. Helper teks periode bulan (Contoh: "Juni 2026")
        // Kita buat instance carbon berdasarkan bulan dan tahun yang difilter
        $bulanPeriode = Carbon::createFromDate($currentYear, $currentMonth, 1)->translatedFormat('F Y');

        // Kirim data ke view (Tambahkan $currentMonth dan $currentYear agar opsi dropdown di view tetap bertahan)
        return view('admin.reports.profit-loss', compact(
            'inflowPenjualan', 'inflowPendapatanLain', 'total_pendapatan',
            'outflowPembelian', 'outflowOperasional', 'total_pengeluaran',
            'laba_kotor', 'laba_bersih', 'bulanPeriode',
            'currentMonth', 'currentYear'
        ));
    }

    /**
     * Laporan Arus Kas.
     *
     * Cash Flow = Total Pemasukan (jenis_transaksi = income) - Total Pengeluaran (jenis_transaksi = expense).
     */
    public function cashFlow(Request $request)
    {
        // 1. Ambil input filter dari request, jika tidak ada, default ke bulan & tahun saat ini
        $currentMonth = $request->input('month', Carbon::now()->month);
        $currentYear = $request->input('year', Carbon::now()->year);

        // 2. Hitung Modal Awal (Diambil dari transaksi bertipe 'modal')
        $modalAwal = Transaction::where('tipe_transaksi', 'modal')
            ->sum('total_harga');

        // 3. Hitung Arus Kas Masuk (jenis_transaksi = 'income')
        $inflowPenjualan = Transaction::where('jenis_transaksi', 'income')
            ->where('tipe_transaksi', 'penjualan')
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->sum('total_harga');
        $inflowPendapatanLain = Transaction::where('jenis_transaksi', 'income')
            ->where('tipe_transaksi', 'pendapatan_lain')
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->sum('total_harga');
        $totalKasMasuk = $inflowPenjualan + $inflowPendapatanLain;

        // 4. Hitung Arus Kas Keluar (jenis_transaksi = 'expense')
        $outflowPembelian = Transaction::where('jenis_transaksi', 'expense')
            ->where('tipe_transaksi', 'pembelian')
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->sum('total_harga');
        $outflowOperasional = Transaction::where('jenis_transaksi', 'expense')
            ->where('tipe_transaksi', 'operasional')
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->sum('total_harga');
        $totalKasKeluar = $outflowPembelian + $outflowOperasional;

        // 5. Hitung Kenaikan/Penurunan Kas & Saldo Akhir
        $kenaikanPenurunanKas = $totalKasMasuk - $totalKasKeluar;
        $saldoAkhir = $modalAwal + $kenaikanPenurunanKas;

        // Tanggal cetak untuk footer laporan
        $tanggalCetak = Carbon::now()->translatedFormat('d F Y');
        $bulanPeriode = Carbon::createFromDate($currentYear, $currentMonth, 1)->translatedFormat('F Y');

        return view('admin.reports.cash-flow', compact(
            'modalAwal', 'inflowPenjualan', 'inflowPendapatanLain', 'totalKasMasuk',
            'outflowPembelian', 'outflowOperasional', 'totalKasKeluar',
            'kenaikanPenurunanKas', 'saldoAkhir', 'tanggalCetak', 'bulanPeriode',
            'currentMonth', 'currentYear'
        ));
    }
}
