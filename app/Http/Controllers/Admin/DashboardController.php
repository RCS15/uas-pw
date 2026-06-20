<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin dengan ringkasan KPI keuangan.
     */
    public function index(): View
    {
        $totalPendapatan = (float) Transaction::where('jenis_transaksi', 'income')->sum('total_harga');
        $totalPengeluaran = (float) Transaction::where('jenis_transaksi', 'expense')->sum('total_harga');
        $labaBersih = $totalPendapatan - $totalPengeluaran;

        $recentTransactions = Transaction::with(['user'])
            ->latest('tanggal')
            ->latest('id')
            ->take(5)
            ->get();

        $lowStockCount = Product::where('stok', '<', 10)->count();
        $totalTransaksi = Transaction::count();

        // Data Grafik 7 Hari Terakhir
        $chartData = [];
        $chartLabels = [];
        $maxValue = 0;
        $daysIndo = ['Sun' => 'Min', 'Mon' => 'Sen', 'Tue' => 'Sel', 'Wed' => 'Rab', 'Thu' => 'Kam', 'Fri' => 'Jum', 'Sat' => 'Sab'];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $daysIndo[$date->format('D')];

            $income = (float) Transaction::where('jenis_transaksi', 'income')
                ->whereDate('tanggal', $date->format('Y-m-d'))
                ->sum('total_harga');

            $chartData[] = $income;
            if ($income > $maxValue) {
                $maxValue = $income;
            }
        }

        $points = [];
        $xStep = 100 / 6;
        foreach ($chartData as $index => $value) {
            $x = $index * $xStep;
            $y = $maxValue > 0 ? 35 - (($value / $maxValue) * 30) : 35;
            $points[] = ['x' => $x, 'y' => $y];
        }

        $pathD = '';
        if (count($points) > 0) {
            $pathD .= "M {$points[0]['x']} {$points[0]['y']} ";
            for ($i = 1; $i < count($points); $i++) {
                // Menggunakan garis lurus (L) agar lebih presisi sesuai data aslinya
                $pathD .= "L {$points[$i]['x']} {$points[$i]['y']} ";
            }
        }
        $areaPathD = $pathD . " L 100 40 L 0 40 Z";

        return view('admin.dashboard', [
            'total_pendapatan' => $totalPendapatan,
            'total_pengeluaran' => $totalPengeluaran,
            'laba_bersih' => $labaBersih,
            'recent_transactions' => $recentTransactions,
            'low_stock_count' => $lowStockCount,
            'total_transaksi' => $totalTransaksi,
            'chartLabels' => $chartLabels,
            'pathD' => $pathD,
            'areaPathD' => $areaPathD,
        ]);
    }
}