@extends('layouts.app')

@section('title', 'Laporan Laba Rugi')
@section('header_title', 'Laporan Laba Rugi')

@section('content')
    <!-- Report Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 print:hidden">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan Laba & Rugi</h1>
            <p class="text-sm text-gray-500">Analisis pendapatan dan beban operasional UMKM Anda secara periodik</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:border-emerald-500 text-gray-700 hover:text-emerald-700 rounded-xl text-sm font-semibold shadow-sm transition-all duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak Laporan
            </button>
        </div>
    </div>

    <!-- Filter Periode (Print Hidden) -->
    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20 mb-8 flex flex-wrap gap-4 items-center justify-between print:hidden">
        <div class="flex items-center gap-3">
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Pilih Bulan</label>
                <select class="text-xs bg-gray-50 border border-gray-200 rounded-xl p-2.5 focus:outline-none focus:border-emerald-500 w-40 font-semibold">
                    <option value="06" selected>Juni</option>
                    <option value="05">Mei</option>
                    <option value="04">April</option>
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Pilih Tahun</label>
                <select class="text-xs bg-gray-50 border border-gray-200 rounded-xl p-2.5 focus:outline-none focus:border-emerald-500 w-32 font-semibold">
                    <option value="2026" selected>2026</option>
                    <option value="2025">2025</option>
                </select>
            </div>
        </div>
        <button class="px-5 py-2.5 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-sm transition-colors">
            Tampilkan Laporan
        </button>
    </div>

    <!-- Printable Report Sheet -->
    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/25 p-6 sm:p-10 max-w-4xl mx-auto print:border-0 print:shadow-none print:p-0">
        
        <!-- Header Laporan Cetak -->
        <div class="text-center pb-8 border-b border-gray-100 mb-8">
            <h2 class="text-xl font-extrabold text-gray-900 tracking-tight">FinBiz UMKM</h2>
            <p class="text-sm font-semibold text-emerald-600">LAPORAN LABA & RUGI</p>
            <p class="text-xs text-gray-400 mt-1">Periode: Juni 2026</p>
        </div>

        <!-- Ringkasan Singkat Box -->
        <div class="grid grid-cols-3 gap-4 mb-8 bg-gray-50/50 p-5 rounded-2xl border border-gray-100 print:bg-white print:border-gray-300">
            <div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Total Pendapatan</span>
                <span class="text-base font-bold text-emerald-600">Rp 48.250.000</span>
            </div>
            <div class="border-l border-gray-200/60 pl-4">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Total Beban</span>
                <span class="text-base font-bold text-rose-600">Rp 18.400.000</span>
            </div>
            <div class="border-l border-gray-200/60 pl-4">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Laba Bersih</span>
                <span class="text-base font-bold text-gray-900">Rp 29.850.000</span>
            </div>
        </div>

        <!-- Detailed Breakdown -->
        <div class="space-y-8 text-sm">
            {{-- Pendapatan Segment --}}
            <div>
                <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-3 tracking-wide flex justify-between">
                    <span>1. PENDAPATAN</span>
                    <span class="text-xs font-medium text-gray-400">Kode Akun: 4000</span>
                </h3>
                <div class="space-y-2.5">
                    <div class="flex justify-between items-center text-gray-600">
                        <span class="pl-4">Pendapatan Penjualan Produk</span>
                        <span class="font-medium">Rp 42.100.000</span>
                    </div>
                    <div class="flex justify-between items-center text-gray-600">
                        <span class="pl-4">Pendapatan Jasa / Lain-lain</span>
                        <span class="font-medium">Rp 6.150.000</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-gray-100/60 font-bold text-gray-800">
                        <span>Total Pendapatan Operasional</span>
                        <span class="text-emerald-700">Rp 48.250.000</span>
                    </div>
                </div>
            </div>

            {{-- Beban Segment --}}
            <div>
                <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-3 tracking-wide flex justify-between">
                    <span>2. BEBAN OPERASIONAL</span>
                    <span class="text-xs font-medium text-gray-400">Kode Akun: 5000</span>
                </h3>
                <div class="space-y-2.5">
                    <div class="flex justify-between items-center text-gray-600">
                        <span class="pl-4">Beban Gaji Karyawan</span>
                        <span class="font-medium">Rp 8.000.000</span>
                    </div>
                    <div class="flex justify-between items-center text-gray-600">
                        <span class="pl-4">Beban Bahan Baku & Logistik</span>
                        <span class="font-medium">Rp 6.500.000</span>
                    </div>
                    <div class="flex justify-between items-center text-gray-600">
                        <span class="pl-4">Beban Listrik, Air & Internet</span>
                        <span class="font-medium">Rp 1.400.000</span>
                    </div>
                    <div class="flex justify-between items-center text-gray-600">
                        <span class="pl-4">Beban Sewa & Pemeliharaan</span>
                        <span class="font-medium">Rp 2.500.000</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-gray-100/60 font-bold text-gray-800">
                        <span>Total Beban Operasional</span>
                        <span class="text-rose-700">Rp 18.400.000</span>
                    </div>
                </div>
            </div>

            {{-- Net Income Segment --}}
            <div class="pt-6 border-t-2 border-double border-gray-200">
                <div class="flex justify-between items-center text-base font-extrabold text-gray-900">
                    <span>LABA BERSIH (NET PROFIT)</span>
                    <span class="text-emerald-700 px-4 py-1.5 bg-emerald-50 rounded-xl border border-emerald-100 print:bg-white print:border-0 print:p-0">
                        Rp 29.850.000
                    </span>
                </div>
            </div>
        </div>

        <!-- Footer Tanda Tangan Cetak -->
        <div class="hidden print:flex items-center justify-between mt-20 text-xs">
            <div class="text-center w-36">
                <p class="text-gray-400 mb-16">Dibuat Oleh,</p>
                <div class="border-b border-gray-400 w-full mb-1"></div>
                <p class="font-bold text-gray-700">Staf Keuangan</p>
            </div>
            
            <div class="text-center w-36">
                <p class="text-gray-400 mb-16">Disetujui Oleh,</p>
                <div class="border-b border-gray-400 w-full mb-1"></div>
                <p class="font-bold text-gray-700">Pemilik UMKM</p>
            </div>
        </div>

    </div>
@endsection
