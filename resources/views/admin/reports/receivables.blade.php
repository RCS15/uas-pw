@extends('layouts.app')

@section('title', 'Laporan Piutang Pelanggan')
@section('header_title', 'Laporan Piutang')

@section('content')
    <!-- Report Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 print:hidden">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan Piutang</h1>
            <p class="text-sm text-gray-500">Kelola dan pantau catatan tagihan pelanggan yang belum terselesaikan</p>
        </div>
        <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:border-emerald-500 text-gray-700 hover:text-emerald-700 rounded-xl text-sm font-semibold shadow-sm transition-all duration-150">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Cetak Laporan
        </button>
    </div>

    <!-- Summary Widgets -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8 print:grid-cols-3">
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Total Piutang Aktif</span>
            <span class="text-xl font-bold text-gray-900">Rp 5.700.000</span>
            <span class="text-[10px] text-gray-500 block mt-2">Akumulasi seluruh tagihan belum lunas</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Jatuh Tempo Pekan Ini</span>
            <span class="text-xl font-bold text-red-600">Rp 2.100.000</span>
            <span class="text-[10px] text-red-500 font-semibold block mt-2">Segera hubungi 2 pelanggan</span>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Berhasil Tertagih (Bulan Ini)</span>
            <span class="text-xl font-bold text-emerald-600">Rp 6.150.000</span>
            <span class="text-[10px] text-emerald-600 font-semibold block mt-2">Dana berhasil dicairkan masuk kas</span>
        </div>
    </div>

    <!-- Detailed Receivables Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex items-center justify-between print:hidden">
            <div>
                <h3 class="text-base font-bold text-gray-900">Detail Piutang Pelanggan</h3>
                <p class="text-xs text-gray-500">Rincian status tagihan dan tenggat waktu bayar</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100">
                        <th class="px-6 py-4">Nama Pelanggan</th>
                        <th class="px-6 py-4">Tanggal Piutang</th>
                        <th class="px-6 py-4">Jatuh Tempo</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Sisa Tagihan</th>
                        <th class="px-6 py-4 text-center print:hidden">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-600">
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-800">Toko Roti Sejahtera</div>
                            <span class="text-[10px] text-gray-400">CP: Bpk. Budi - 0812345678</span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-500">10 Mei 2026</td>
                        <td class="px-6 py-4 font-medium text-gray-500">10 Jun 2026</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2 py-0.5 rounded-md bg-red-50 text-red-700 border border-red-100">
                                Terlambat / Jatuh Tempo
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-gray-800">Rp 1.500.000</td>
                        <td class="px-6 py-4 text-center print:hidden">
                            <a href="#" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 mr-3">Kirim Pengingat</a>
                            <a href="#" class="text-xs font-bold text-gray-600 hover:text-emerald-600">Lunasi</a>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-800">Warung Makan Bu Ani</div>
                            <span class="text-[10px] text-gray-400">CP: Ibu Ani - 0822998877</span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-500">25 Mei 2026</td>
                        <td class="px-6 py-4 font-medium text-gray-500">25 Jun 2026</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 border border-amber-100">
                                Belum Lunas
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-gray-800">Rp 2.200.000</td>
                        <td class="px-6 py-4 text-center print:hidden">
                            <a href="#" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 mr-3">Kirim Pengingat</a>
                            <a href="#" class="text-xs font-bold text-gray-600 hover:text-emerald-600">Lunasi</a>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-800">Kantin Karyawan Nusantara</div>
                            <span class="text-[10px] text-gray-400">CP: Bpk. Joko - 0857332211</span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-500">01 Jun 2026</td>
                        <td class="px-6 py-4 font-medium text-gray-500">01 Jul 2026</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 border border-amber-100">
                                Belum Lunas
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-gray-800">Rp 2.000.000</td>
                        <td class="px-6 py-4 text-center print:hidden">
                            <a href="#" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 mr-3">Kirim Pengingat</a>
                            <a href="#" class="text-xs font-bold text-gray-600 hover:text-emerald-600">Lunasi</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
