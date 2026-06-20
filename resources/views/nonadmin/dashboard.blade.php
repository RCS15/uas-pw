@extends('layouts.app')

@section('title', 'Dashboard Kasir')
@section('header_title', 'Dashboard Kasir')

@section('content')
    <!-- Welcome Header Section -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Selamat Bekerja, {{ auth()->user()->name ?? 'Staf Kasir' }}</h1>
            <p class="text-sm text-gray-500">Catat transaksi penjualan hari ini secara teliti dan cepat.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('nonadmin.transactions.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow-sm shadow-emerald-600/10 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Input Transaksi Penjualan
            </a>
        </div>
    </div>

    <!-- Summary Harian Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        {{-- Total Penjualan Hari Ini --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Omzet Hari Ini</span>
                <span class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </span>
            </div>
            <div class="text-2xl font-bold text-gray-900">Rp {{ number_format($omzet_hari_ini ?? 0, 0, ',', '.') }}</div>
            <div class="mt-2 text-xs font-semibold text-gray-400">Total pemasukan kas masuk shift Anda</div>
        </div>

        {{-- Jumlah Transaksi --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Jumlah Transaksi</span>
                <span class="p-2.5 bg-teal-50 text-teal-600 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                        </path>
                    </svg>
                </span>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $jumlah_transaksi ?? 0 }} Nota</div>
            <div class="mt-2 text-xs font-semibold text-gray-400">Pelanggan terlayani hari ini</div>
        </div>

        {{-- Produk Terjual --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Item Terjual</span>
                <span class="p-2.5 bg-blue-50 text-blue-600 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </span>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $total_barang_terjual ?? 0 }} Pcs</div>
            <div class="mt-2 text-xs font-semibold text-gray-400">Jumlah produk terjual</div>
        </div>
    </div>

    <!-- Main Grid: Recent Transactions & Popular Product Shortcuts -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Recent Transactions entered by this staff --}}
        <div
            class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20 lg:col-span-2 overflow-hidden flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Input Penjualan Terakhir Anda</h3>
                        <p class="text-xs text-gray-500">Daftar nota penjualan shift hari ini</p>
                    </div>
                    <a href="{{ route('nonadmin.transactions.history') }}"
                        class="text-xs font-bold text-emerald-600 hover:text-emerald-700">Lihat Semua</a>
                </div>

                <div class="overflow-x-auto -mx-6">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-gray-50 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100">
                                <th class="px-6 py-3">Waktu</th>
                                <th class="px-6 py-3">Keterangan Penjualan</th>
                                <th class="px-6 py-3 text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-xs text-gray-600">
                            @forelse ($recent_transactions ?? [] as $transaction)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-400">
                                        {{ Carbon\Carbon::parse($transaction['created_at'])->format('H:i') }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-800">
                                        <div class="space-y-1 bg-gray-50 p-2 rounded-xl border border-gray-100 text-xs">
                                            @foreach ($transaction->details as $detail)
                                                <div class="flex justify-between items-center w-full">
                                                    <span>
                                                        • {{ $detail->product->nama_barang ?? 'Produk Dihapus' }}
                                                        <strong class="text-gray-900"> x ({{ $detail->jumlah }})</strong>
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-emerald-600">
                                        Rp {{ number_format($transaction['total_harga'], 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-gray-400 font-medium">
                                        Belum memasukkan penjualan hari ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Popular Products / Quick Shortcuts --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20">
            <h3 class="text-base font-bold text-gray-900 mb-1">Shortcut Menu Terlaris</h3>
            <p class="text-xs text-gray-500 mb-6">Klik untuk melihat info produk & stok secara instan</p>

            <div class="space-y-3">
                @forelse ($popular_products ?? [] as $product)
                    <div
                        class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100/50 hover:border-emerald-300 hover:bg-emerald-50/10 transition-all duration-200">
                        <div>
                            <span class="font-bold text-gray-800 text-sm block">{{ $product['nama_barang'] }}</span>
                            <span class="text-xs text-emerald-700 font-semibold">Rp
                                {{ number_format($product['harga'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <a href="{{ route('nonadmin.products.show', $product['id']) }}"
                                class="p-2 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-600 hover:text-emerald-700 hover:border-emerald-500 transition-colors shadow-sm text-center">
                                Stok {{ $product['stok'] }} Pcs
                            </a>
                            <a href="{{ route('nonadmin.transactions.history') }}"
                                class="p-2 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-600 hover:text-emerald-700 hover:border-emerald-500 transition-colors shadow-sm text-center">
                                Terjual {{ $product['total_terjual'] }}
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 text-center py-6">Katalog produk belum terisi.</p>
                @endforelse
            </div>

            <a href="{{ route('nonadmin.products.index') }}"
                class="block text-center mt-6 text-xs font-bold text-emerald-600 hover:text-emerald-700 hover:underline">
                Lihat Katalog Produk Selengkapnya &rarr;
            </a>
        </div>
    </div>
@endsection
