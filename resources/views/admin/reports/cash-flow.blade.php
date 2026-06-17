@extends('layouts.app')

@section('title', 'Laporan Arus Kas')
@section('header_title', 'Laporan Arus Kas')

@section('content')
    <!-- Report Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 print:hidden">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan Arus Kas</h1>
            <p class="text-sm text-gray-500">Pantau perputaran uang kas masuk dan kas keluar usaha Anda secara riil</p>
        </div>
        <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:border-emerald-500 text-gray-700 hover:text-emerald-700 rounded-xl text-sm font-semibold shadow-sm transition-all duration-150">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Cetak Laporan
        </button>
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
            <p class="text-sm font-semibold text-emerald-600">LAPORAN ARUS KAS</p>
            <p class="text-xs text-gray-400 mt-1">Periode: Juni 2026</p>
        </div>

        <!-- Detailed Breakdown -->
        <div class="space-y-8 text-sm">
            {{-- Saldo Awal --}}
            <div class="flex justify-between items-center text-base font-extrabold text-gray-800 bg-gray-50 p-4 rounded-xl border border-gray-100/50 print:bg-white print:border-gray-200">
                <span>SALDO KAS AWAL PERIODE</span>
                <span>Rp 15.000.000</span>
            </div>

            {{-- Kas Masuk --}}
            <div>
                <h3 class="font-bold text-emerald-800 border-b border-emerald-100 pb-2 mb-3 tracking-wide flex justify-between">
                    <span>ARUS KAS DARI AKTIVITAS OPERASIONAL (MASUK)</span>
                    <span class="text-xs font-medium text-emerald-600">KAS INFLOW</span>
                </h3>
                <div class="space-y-2.5">
                    <div class="flex justify-between items-center text-gray-600">
                        <span class="pl-4">Penerimaan Kas dari Pelanggan (Tunai)</span>
                        <span class="font-medium">Rp 42.100.000</span>
                    </div>
                    <div class="flex justify-between items-center text-gray-600">
                        <span class="pl-4">Pelunasan Piutang Dagang</span>
                        <span class="font-medium">Rp 6.150.000</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-gray-100/60 font-bold text-gray-800">
                        <span>Total Kas Masuk</span>
                        <span class="text-emerald-700">Rp 48.250.000</span>
                    </div>
                </div>
            </div>

            {{-- Kas Keluar --}}
            <div>
                <h3 class="font-bold text-rose-800 border-b border-rose-100 pb-2 mb-3 tracking-wide flex justify-between">
                    <span>ARUS KAS UNTUK AKTIVITAS OPERASIONAL (KELUAR)</span>
                    <span class="text-xs font-medium text-rose-600">KAS OUTFLOW</span>
                </h3>
                <div class="space-y-2.5">
                    <div class="flex justify-between items-center text-gray-600">
                        <span class="pl-4">Pembayaran Beban Bahan Baku</span>
                        <span class="font-medium">Rp 6.500.000</span>
                    </div>
                    <div class="flex justify-between items-center text-gray-600">
                        <span class="pl-4">Pembayaran Gaji Karyawan</span>
                        <span class="font-medium">Rp 8.000.000</span>
                    </div>
                    <div class="flex justify-between items-center text-gray-600">
                        <span class="pl-4">Pembayaran Listrik & Telepon</span>
                        <span class="font-medium">Rp 1.400.000</span>
                    </div>
                    <div class="flex justify-between items-center text-gray-600">
                        <span class="pl-4">Pembayaran Biaya Sewa Tempat</span>
                        <span class="font-medium">Rp 2.500.000</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-gray-100/60 font-bold text-gray-800">
                        <span>Total Kas Keluar</span>
                        <span class="text-rose-700">Rp 18.400.000</span>
                    </div>
                </div>
            </div>

            {{-- Net Cash Increase --}}
            <div class="pt-4 border-t border-gray-200">
                <div class="flex justify-between items-center font-bold text-gray-800">
                    <span>Kenaikan Bersih dalam Kas</span>
                    <span class="text-emerald-600">Rp 29.850.000</span>
                </div>
            </div>

            {{-- Saldo Akhir --}}
            <div class="pt-6 border-t-2 border-double border-gray-200">
                <div class="flex justify-between items-center text-base font-extrabold text-gray-900">
                    <span>SALDO KAS AKHIR PERIODE (30 JUNI 2026)</span>
                    <span class="text-emerald-700 px-4 py-1.5 bg-emerald-50 rounded-xl border border-emerald-100 print:bg-white print:border-0 print:p-0">
                        Rp 44.850.000
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
