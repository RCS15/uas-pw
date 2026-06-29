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

        // Pemasukan hari ini (selalu hari ini, tidak terpengaruh filter)
        $pemasukanHariIni = (float) Transaction::where('tipe_transaksi', 'penjualan')
            ->whereDate('tanggal', Carbon::today())
            ->sum('total_harga');

        // Modal usaha (semua waktu, tidak perlu difilter)
        $modalUsaha = (float) Transaction::where('tipe_transaksi', 'modal')->sum('total_harga');

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
        [$chartLabels, $pathD, $areaPathD] = $this->buildChartData($period, $dateStart, $dateEnd);

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
            'pemasukan_hari_ini'  => $pemasukanHariIni,
            'modal_usaha'         => $modalUsaha,
            'recent_transactions' => $recentTransactions,
            'low_stock_count'     => $lowStockCount,
            'low_stock_products'  => $lowStockProducts,
            'chartLabels'         => $chartLabels,
            'pathD'               => $pathD,
            'areaPathD'           => $areaPathD,
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
        $chartData   = [];
        $chartLabels = [];
        $daysIndo    = [
            'Sun' => 'Min', 'Mon' => 'Sen', 'Tue' => 'Sel',
            'Wed' => 'Rab', 'Thu' => 'Kam', 'Fri' => 'Jum', 'Sat' => 'Sab',
        ];

        if ($period === 'hari_ini') {
            // Per jam (0–23)
            for ($h = 0; $h < 24; $h += 3) {
                $chartLabels[] = sprintf('%02d:00', $h);
                $chartData[]   = (float) Transaction::where('jenis_transaksi', 'income')
                    ->whereDate('tanggal', Carbon::today())
                    ->whereRaw('HOUR(created_at) >= ? AND HOUR(created_at) < ?', [$h, $h + 3])
                    ->sum('total_harga');
            }
        } elseif ($period === 'minggu_ini') {
            // Per hari (7 hari)
            for ($i = 6; $i >= 0; $i--) {
                $date          = Carbon::now()->startOfWeek()->addDays(6 - $i);
                $chartLabels[] = $daysIndo[$date->format('D')];
                $chartData[]   = (float) Transaction::where('jenis_transaksi', 'income')
                    ->whereDate('tanggal', $date->toDateString())
                    ->sum('total_harga');
            }
        } elseif ($period === 'tahun_ini') {
            // Per bulan (Jan–Des)
            $bulanIndo = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
            for ($m = 1; $m <= 12; $m++) {
                $chartLabels[] = $bulanIndo[$m - 1];
                $chartData[]   = (float) Transaction::where('jenis_transaksi', 'income')
                    ->whereYear('tanggal', Carbon::now()->year)
                    ->whereMonth('tanggal', $m)
                    ->sum('total_harga');
            }
        } elseif ($period === 'custom') {
            // Otomatis pilih granularitas
            $diffDays = $dateStart->diffInDays($dateEnd);
            if ($diffDays <= 14) {
                // Per hari
                for ($i = 0; $i <= $diffDays; $i++) {
                    $date          = $dateStart->copy()->addDays($i);
                    $chartLabels[] = $date->format('d/m');
                    $chartData[]   = (float) Transaction::where('jenis_transaksi', 'income')
                        ->whereDate('tanggal', $date->toDateString())
                        ->sum('total_harga');
                }
            } else {
                // Per minggu
                $cursor = $dateStart->copy()->startOfWeek();
                while ($cursor->lte($dateEnd)) {
                    $weekEnd       = $cursor->copy()->endOfWeek();
                    $chartLabels[] = $cursor->format('d/m');
                    $chartData[]   = (float) Transaction::where('jenis_transaksi', 'income')
                        ->whereBetween('tanggal', [$cursor->toDateString(), $weekEnd->toDateString()])
                        ->sum('total_harga');
                    $cursor->addWeek();
                }
            }
        } else {
            // bulan_ini — per hari dalam bulan berjalan
            $daysInMonth = Carbon::now()->daysInMonth;
            for ($d = 1; $d <= $daysInMonth; $d++) {
                $date          = Carbon::now()->startOfMonth()->addDays($d - 1);
                $chartLabels[] = (string) $d;
                $chartData[]   = (float) Transaction::where('jenis_transaksi', 'income')
                    ->whereDate('tanggal', $date->toDateString())
                    ->sum('total_harga');
            }
        }

        // ── Bangun SVG Path ───────────────────────────────────────────────
        $maxValue = max($chartData) ?: 1;
        $count    = count($chartData);
        $points   = [];

        foreach ($chartData as $i => $value) {
            $x        = $count > 1 ? ($i / ($count - 1)) * 100 : 50;
            $y        = 35 - (($value / $maxValue) * 30);
            $points[] = compact('x', 'y');
        }

        $pathD = '';
        if ($points) {
            $pathD = "M {$points[0]['x']} {$points[0]['y']} ";
            for ($i = 1; $i < count($points); $i++) {
                $pathD .= "L {$points[$i]['x']} {$points[$i]['y']} ";
            }
        }

        $areaPathD = $pathD . "L 100 40 L 0 40 Z";

        return [$chartLabels, $pathD, $areaPathD];
    }
}