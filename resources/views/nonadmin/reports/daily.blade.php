@extends('layouts.app')

@section('title', 'Laporan Penjualan Harian')
@section('header_title', 'Laporan Harian')

@section('content')
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 print:hidden">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan Shift Harian</h1>
            <p class="text-sm text-gray-500">Ringkasan transaksi dan pencocokan uang kas untuk setoran shift Anda</p>
        </div>
        <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:border-emerald-500 text-gray-700 hover:text-emerald-700 rounded-xl text-sm font-semibold shadow-sm transition-all duration-150">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Cetak Setoran
        </button>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/25 p-6 sm:p-10 max-w-3xl mx-auto print:border-0 print:shadow-none print:p-0">
        
        <div class="text-center pb-8 border-b border-gray-100 mb-8">
            <h2 class="text-xl font-extrabold text-gray-900 tracking-tight">FinBiz UMKM</h2>
            <p class="text-sm font-semibold text-teal-600 uppercase">Laporan Setoran & Rekonsiliasi Kasir</p>
            <p class="text-xs text-gray-400 mt-1">{{ date('d F Y') }}</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 text-xs text-gray-600 bg-gray-50/50 p-4 rounded-xl border border-gray-100/50 print:bg-white print:border-gray-200">
            <div>
                <span class="text-gray-400 font-medium block">NAMA KASIR</span>
                {{-- DIUBAH: Menampilkan nama user yang sedang login secara dinamis --}}
                <span class="font-bold text-gray-800">{{ Auth::user()->name }}</span>
            </div>
            <div>
                <span class="text-gray-400 font-medium block">SHIFT KERJA</span>
                <span class="font-bold text-gray-800">Aktif (Hari Ini)</span>
            </div>
            <div>
                <span class="text-gray-400 font-medium block">STATUS LAPORAN</span>
                <span class="font-bold text-emerald-700 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-md inline-block">Siap Setor</span>
            </div>
            <div>
                <span class="text-gray-400 font-medium block">TANGGAL CETAK</span>
                <span class="font-bold text-gray-800">{{ date('d/m/Y H:i') }}</span>
            </div>
        </div>

        <div class="space-y-4 mb-8">
            <h3 class="font-bold text-gray-800 text-sm border-b border-gray-100 pb-2">Ringkasan Uang Setoran</h3>
            
            <div class="space-y-2.5 text-sm">
                <div class="flex justify-between items-center text-gray-600">
                    <span>Kas Masuk Penjualan</span>
                    {{-- DIUBAH: Mengambil data jumlah total penjualan hari ini --}}
                    <span class="font-semibold text-gray-800">Rp {{ number_format($total_penjualan ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center text-gray-600">
                    <span>Modal Awal Kas Laci (Default)</span>
                    <span class="font-semibold text-gray-800">Rp 0</span>
                </div>
                <div class="flex justify-between items-center pt-3 border-t-2 border-dashed border-gray-100 font-extrabold text-base text-gray-900">
                    <span>TOTAL UANG HARUS ADA DI LACI KASIR</span>
                    {{-- DIUBAH: Total penjumlahan otomatis --}}
                    <span class="text-emerald-700 bg-emerald-50 px-3 py-1 rounded-lg">Rp {{ number_format($total_penjualan ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-100 pt-8 mt-12">
            <p class="text-xs text-gray-400 mb-8 italic text-center">Dengan menandatangani di bawah ini, kasir menyatakan telah menyerahkan seluruh uang kas fisik di atas kepada pihak pengelola usaha (admin).</p>
            <div class="flex items-center justify-between text-xs">
                <div class="text-center w-36">
                    <p class="text-gray-400 mb-16">Yang Menyerahkan (Kasir),</p>
                    <div class="border-b border-gray-400 w-full mb-1"></div>
                    {{-- DIUBAH: Dinamis mengikuti nama kasir --}}
                    <p class="font-bold text-gray-700">{{ Auth::user()->name }}</p>
                </div>
                
                <div class="text-center w-36">
                    <p class="text-gray-400 mb-16">Yang Menerima (Admin/Owner),</p>
                    <div class="border-b border-gray-400 w-full mb-1"></div>
                    <p class="font-bold text-gray-700">Admin Keuangan</p>
                </div>
            </div>
        </div>

    </div>
@endsection