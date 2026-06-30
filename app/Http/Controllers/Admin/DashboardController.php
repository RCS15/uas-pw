<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        // ── 1. Tentukan Rentang Waktu ─────────────────────────────────────
        $period = $request->input('period', 'bulan_ini');
        $dateStart = null;
        $dateEnd   = Carbon::today();

        switch ($period) {
            case 'hari_ini':
                $dateStart = Carbon::today();
                break;
            case 'minggu_ini':
                $dateStart = Carbon::now()->startOfWeek();
                break;
            case 'tahun_ini':
                $dateStart = Carbon::now()->startOfYear();
                break;
            case 'custom':
                $dateStart = $request->filled('date_start')
                    ? Carbon::parse($request->input('date_start'))->startOfDay()
                    : Carbon::now()->startOfMonth();
                $dateEnd = $request->filled('date_end')
                    ? Carbon::parse($request->input('date_end'))->endOfDay()
                    : Carbon::today()->endOfDay();
                break;
            case 'bulan_ini':
            default:
                $period    = 'bulan_ini';
                $dateStart = Carbon::now()->startOfMonth();
                break;
        }

        // ── 2. Base Query dengan Filter Tanggal ──────────────────────────
        $baseQuery = fn() => Transaction::whereBetween('tanggal', [
            $dateStart->toDateString(),
            $dateEnd->toDateString(),
        ]);

        // ── 3. KPI Cards ─────────────────────────────────────────────────
        $totalPendapatan  = (float) $baseQuery()->where('jenis_transaksi', 'income')->sum('total_harga');
        $totalPengeluaran = (float) $baseQuery()->where('jenis_transaksi', 'expense')->sum('total_harga');
        $labaBersih       = $totalPendapatan - $totalPengeluaran;
        $totalTransaksi   = $baseQuery()->count();
        $totalTransaksiPenjualan = $baseQuery()->where('tipe_transaksi', 'penjualan')->count();

        // Pemasukan hari ini (selalu hari ini, tidak terpengaruh filter)
        $pemasukanHariIni = (float) Transaction::where('tipe_transaksi', 'penjualan')
            ->whereDate('tanggal', Carbon::today())
            ->sum('total_harga');

        // Modal usaha (semua waktu, tidak perlu difilter)
        $modalUsaha = (float) Transaction::where('tipe_transaksi', 'modal')->sum('total_harga');

        // Tambahan KPI:
        $totalProduk = Product::count();
        $rataRataPenjualan = $totalTransaksiPenjualan > 0 
            ? (float) $baseQuery()->where('tipe_transaksi', 'penjualan')->avg('total_harga') 
            : 0;

        // ── 4. Transaksi Terbaru (5 terbaru dalam periode) ───────────────
        $recentTransactions = $baseQuery()
            ->with('user')
            ->latest('tanggal')
            ->latest('id')
            ->take(3)
            ->get();

        // ── 5. Stok Rendah ────────────────────────────────────────────────
        $lowStockCount    = Product::where('stok', '<', 10)->count();
        $lowStockProducts = Product::where('stok', '<', 10)->orderBy('stok', 'asc')->take(5)->get();

        // ── 6. Data Grafik (dinamis sesuai periode) ───────────────────────
        [
            $chartLabels, 
            $pathD_income, $areaPathD_income,
            $pathD_expense, $areaPathD_expense,
            $pathD_profit, $areaPathD_profit
        ] = $this->buildChartData($period, $dateStart, $dateEnd);

        // ── 7. Label Periode untuk Tampilan ──────────────────────────────
        $periodLabels = [
            'hari_ini'   => 'Hari Ini',
            'minggu_ini' => 'Minggu Ini',
            'bulan_ini'  => 'Bulan Ini',
            'tahun_ini'  => 'Tahun Ini',
            'custom'     => 'Custom: ' . $dateStart->format('d M Y') . ' – ' . $dateEnd->format('d M Y'),
        ];

        return view('admin.dashboard', [
            'total_pendapatan'    => $totalPendapatan,
            'total_pengeluaran'   => $totalPengeluaran,
            'laba_bersih'         => $labaBersih,
            'total_transaksi'     => $totalTransaksi,
            'total_transaksi_penjualan' => $totalTransaksiPenjualan,
            'pemasukan_hari_ini'  => $pemasukanHariIni,
            'modal_usaha'         => $modalUsaha,
            'total_produk'        => $totalProduk,
            'rata_rata_penjualan' => $rataRataPenjualan,
            'recent_transactions' => $recentTransactions,
            'low_stock_count'     => $lowStockCount,
            'low_stock_products'  => $lowStockProducts,
            'chartLabels'         => $chartLabels,
            'pathD_income'        => $pathD_income,
            'areaPathD_income'    => $areaPathD_income,
            'pathD_expense'       => $pathD_expense,
            'areaPathD_expense'   => $areaPathD_expense,
            'pathD_profit'        => $pathD_profit,
            'areaPathD_profit'    => $areaPathD_profit,
            // Filter state
            'activePeriod'        => $period,
            'periodLabel'         => $periodLabels[$period] ?? 'Bulan Ini',
            'dateStart'           => $request->input('date_start', ''),
            'dateEnd'             => $request->input('date_end', ''),
        ]);
    }

    // ── Helper: Bangun Data Grafik ────────────────────────────────────────
    private function buildChartData(string $period, Carbon $dateStart, Carbon $dateEnd): array
    {
        $chartDataIncome   = [];
        $chartDataExpense  = [];
        $chartDataProfit   = [];
        $chartLabels = [];
        $daysIndo    = [
            'Sun' => 'Min', 'Mon' => 'Sen', 'Tue' => 'Sel',
            'Wed' => 'Rab', 'Thu' => 'Kam', 'Fri' => 'Jum', 'Sat' => 'Sab',
        ];

        if ($period === 'hari_ini') {
            // Per jam (0–23)
            for ($h = 0; $h < 24; $h += 3) {
                $chartLabels[] = sprintf('%02d:00', $h);
                
                $income = (float) Transaction::where('jenis_transaksi', 'income')
                    ->whereDate('tanggal', Carbon::today())
                    ->whereRaw('HOUR(created_at) >= ? AND HOUR(created_at) < ?', [$h, $h + 3])
                    ->sum('total_harga');
                $expense = (float) Transaction::where('jenis_transaksi', 'expense')
                    ->whereDate('tanggal', Carbon::today())
                    ->whereRaw('HOUR(created_at) >= ? AND HOUR(created_at) < ?', [$h, $h + 3])
                    ->sum('total_harga');

                $chartDataIncome[] = $income;
                $chartDataExpense[] = $expense;
                $chartDataProfit[] = $income - $expense;
            }
        } elseif ($period === 'minggu_ini') {
            // Per hari (7 hari)
            for ($i = 6; $i >= 0; $i--) {
                $date          = Carbon::now()->startOfWeek()->addDays(6 - $i);
                $chartLabels[] = $daysIndo[$date->format('D')];
                
                $income = (float) Transaction::where('jenis_transaksi', 'income')
                    ->whereDate('tanggal', $date->toDateString())
                    ->sum('total_harga');
                $expense = (float) Transaction::where('jenis_transaksi', 'expense')
                    ->whereDate('tanggal', $date->toDateString())
                    ->sum('total_harga');

                $chartDataIncome[] = $income;
                $chartDataExpense[] = $expense;
                $chartDataProfit[] = $income - $expense;
            }
        } elseif ($period === 'tahun_ini') {
            // Per bulan (Jan–Des)
            $bulanIndo = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
            for ($m = 1; $m <= 12; $m++) {
                $chartLabels[] = $bulanIndo[$m - 1];
                
                $income = (float) Transaction::where('jenis_transaksi', 'income')
                    ->whereYear('tanggal', Carbon::now()->year)
                    ->whereMonth('tanggal', $m)
                    ->sum('total_harga');
                $expense = (float) Transaction::where('jenis_transaksi', 'expense')
                    ->whereYear('tanggal', Carbon::now()->year)
                    ->whereMonth('tanggal', $m)
                    ->sum('total_harga');

                $chartDataIncome[] = $income;
                $chartDataExpense[] = $expense;
                $chartDataProfit[] = $income - $expense;
            }
        } elseif ($period === 'custom') {
            // Otomatis pilih granularitas
            $diffDays = $dateStart->diffInDays($dateEnd);
            if ($diffDays <= 14) {
                // Per hari
                for ($i = 0; $i <= $diffDays; $i++) {
                    $date          = $dateStart->copy()->addDays($i);
                    $chartLabels[] = $date->format('d/m');
                    
                    $income = (float) Transaction::where('jenis_transaksi', 'income')
                        ->whereDate('tanggal', $date->toDateString())
                        ->sum('total_harga');
                    $expense = (float) Transaction::where('jenis_transaksi', 'expense')
                        ->whereDate('tanggal', $date->toDateString())
                        ->sum('total_harga');

                    $chartDataIncome[] = $income;
                    $chartDataExpense[] = $expense;
                    $chartDataProfit[] = $income - $expense;
                }
            } else {
                // Per minggu
                $cursor = $dateStart->copy()->startOfWeek();
                while ($cursor->lte($dateEnd)) {
                    $weekEnd       = $cursor->copy()->endOfWeek();
                    $chartLabels[] = $cursor->format('d/m');
                    
                    $income = (float) Transaction::where('jenis_transaksi', 'income')
                        ->whereBetween('tanggal', [$cursor->toDateString(), $weekEnd->toDateString()])
                        ->sum('total_harga');
                    $expense = (float) Transaction::where('jenis_transaksi', 'expense')
                        ->whereBetween('tanggal', [$cursor->toDateString(), $weekEnd->toDateString()])
                        ->sum('total_harga');

                    $chartDataIncome[] = $income;
                    $chartDataExpense[] = $expense;
                    $chartDataProfit[] = $income - $expense;
                    
                    $cursor->addWeek();
                }
            }
        } else {
            // bulan_ini — per hari dalam bulan berjalan
            $daysInMonth = Carbon::now()->daysInMonth;
            for ($d = 1; $d <= $daysInMonth; $d++) {
                $date          = Carbon::now()->startOfMonth()->addDays($d - 1);
                $chartLabels[] = (string) $d;
                
                $income = (float) Transaction::where('jenis_transaksi', 'income')
                    ->whereDate('tanggal', $date->toDateString())
                    ->sum('total_harga');
                $expense = (float) Transaction::where('jenis_transaksi', 'expense')
                    ->whereDate('tanggal', $date->toDateString())
                    ->sum('total_harga');

                $chartDataIncome[] = $income;
                $chartDataExpense[] = $expense;
                $chartDataProfit[] = $income - $expense;
            }
        }

        // ── Helper Internal: Bangun SVG Path ──────────────────────────────
        // Hitung global min dan max agar semua chart punya skala yang sama
        $allData = array_merge($chartDataIncome, $chartDataExpense, $chartDataProfit);
        $globalMin = !empty($allData) ? min($allData) : 0;
        $globalMax = !empty($allData) ? max($allData) : 1;
        if ($globalMin == $globalMax) {
            $globalMin = 0;
            if ($globalMax == 0) $globalMax = 1;
        }

        $buildPath = function ($data) use ($globalMin, $globalMax) {
            if ($globalMin >= 0) {
                $range = $globalMax > 0 ? $globalMax : 1;
            } else {
                $range = $globalMax - $globalMin;
                $range = $range > 0 ? $range : 1;
            }

            $count    = count($data);
            $points   = [];

            foreach ($data as $i => $value) {
                $x = $count > 1 ? ($i / ($count - 1)) * 100 : 50;
                
                if ($globalMin >= 0) {
                    $y = 35 - (($value / $range) * 30);
                } else {
                    $y = 35 - ((($value - $globalMin) / $range) * 30);
                }
                
                $points[] = compact('x', 'y');
            }

            $pathD = '';
            if ($points) {
                $pathD = "M {$points[0]['x']} {$points[0]['y']} ";
                for ($i = 1; $i < count($points); $i++) {
                    $pathD .= "L {$points[$i]['x']} {$points[$i]['y']} ";
                }
            }

            // Untuk area chart agar turun ke baseY (0-line)
            $baseY = 40;
            if ($globalMin < 0) {
                $baseY = 35 - (((0 - $globalMin) / $range) * 30);
            }
            $areaPathD = $pathD . "L 100 {$baseY} L 0 {$baseY} Z";
            
            return [$pathD, $areaPathD];
        };

        [$pathD_income, $areaPathD_income] = $buildPath($chartDataIncome);
        [$pathD_expense, $areaPathD_expense] = $buildPath($chartDataExpense);
        [$pathD_profit, $areaPathD_profit] = $buildPath($chartDataProfit);

        return [
            $chartLabels, 
            $pathD_income, $areaPathD_income,
            $pathD_expense, $areaPathD_expense,
            $pathD_profit, $areaPathD_profit
        ];
    }
}