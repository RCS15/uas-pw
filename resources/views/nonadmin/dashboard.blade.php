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
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Input Transaksi Penjualan
            </a>
        </div>
    </div>

    <!-- Summary Harian Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        {{-- Total Omzet Hari Ini --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Omzet Hari Ini</span>
                <span class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <div class="text-2xl font-bold text-gray-900">
                Rp {{ number_format($omzet_hari_ini, 0, ',', '.') }}
            </div>
            <div class="mt-2 text-xs font-semibold text-gray-400">Total pemasukan kas masuk shift Anda</div>
        </div>

        {{-- Jumlah Transaksi --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Jumlah Transaksi</span>
                <span class="p-2.5 bg-teal-50 text-teal-600 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </span>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $jumlah_transaksi }} Nota</div>
            <div class="mt-2 text-xs font-semibold text-gray-400">Pelanggan terlayani hari ini</div>
        </div>

        {{-- Item Terjual --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Item Terjual</span>
                <span class="p-2.5 bg-blue-50 text-blue-600 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </span>
            </div>
            <div class="text-2xl font-bold text-gray-900">{{ $total_barang_terjual }} Pcs</div>
            <div class="mt-2 text-xs font-semibold text-gray-400">Jumlah produk terjual hari ini</div>
        </div>
    </div>

    <!-- Main Grid: Recent Transactions & Popular Products -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

        {{-- Recent Transactions --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20 lg:col-span-2 flex flex-col">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-base font-bold text-gray-900">Input Penjualan Terakhir Anda</h3>
                    <p class="text-xs text-gray-500">Daftar nota penjualan terbaru Anda</p>
                </div>
                <a href="{{ route('nonadmin.transactions.history') }}"
                    class="text-xs font-bold text-emerald-600 hover:text-emerald-700">Lihat Semua</a>
            </div>

            <div class="overflow-x-auto -mx-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100">
                            <th class="px-6 py-3">Waktu</th>
                            <th class="px-6 py-3">Keterangan Penjualan</th>
                            <th class="px-6 py-3 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs text-gray-600">
                        @forelse ($recent_transactions as $transaction)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                {{-- ✅ Gunakan kolom 'tanggal' yang memang ada di model, bukan 'created_at' --}}
                                <td class="px-6 py-4 font-medium text-gray-400 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($transaction->tanggal)->format('H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1 bg-gray-50 p-2 rounded-xl border border-gray-100 text-xs">
                                        @foreach ($transaction->details as $detail)
                                            <div class="flex justify-between items-center w-full">
                                                <span>
                                                    {{-- ✅ Akses properti via object (->) bukan array ([]) --}}
                                                    • {{ $detail->product->nama_barang ?? 'Produk Dihapus' }}
                                                    <strong class="text-gray-900">x{{ $detail->jumlah }}</strong>
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                {{-- ✅ Konsisten pakai object access --}}
                                <td class="px-6 py-4 text-right font-bold text-emerald-600 whitespace-nowrap">
                                    Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-10 text-center">
                                    <div class="flex flex-col items-center gap-2 text-gray-400">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <span class="text-sm font-medium">Belum ada penjualan hari ini</span>
                                        <a href="{{ route('nonadmin.transactions.create') }}"
                                            class="text-xs text-emerald-600 font-bold hover:underline">
                                            + Catat transaksi pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Popular Products --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20">
            <h3 class="text-base font-bold text-gray-900 mb-1">Produk Terlaris (30 Hari)</h3>
            <p class="text-xs text-gray-500 mb-6">Klik untuk melihat info produk & stok</p>

            <div class="space-y-3">
                @forelse ($popular_products as $product)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100/50 hover:border-emerald-300 hover:bg-emerald-50/10 transition-all duration-200">
                        <div class="min-w-0 mr-3">
                            <span class="font-bold text-gray-800 text-sm block truncate">
                                {{ $product->nama_barang }}
                            </span>
                            <span class="text-xs text-emerald-700 font-semibold">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="flex flex-col gap-1 shrink-0">
                            {{-- ✅ Akses object property, bukan array --}}
                            <a href="{{ route('nonadmin.products.show', $product->id) }}"
                                class="p-2 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-600 hover:text-emerald-700 hover:border-emerald-500 transition-colors shadow-sm text-center whitespace-nowrap">
                                Stok {{ $product->stok }} Pcs
                            </a>
                            {{-- ✅ Link diarahkan ke detail produk, bukan history transaksi --}}
                            <a href="{{ route('nonadmin.products.show', $product->id) }}"
                                class="p-2 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-600 hover:text-emerald-700 hover:border-emerald-500 transition-colors shadow-sm text-center whitespace-nowrap">
                                Terjual {{ $product->total_terjual }}
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center gap-2 py-8 text-gray-400">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span class="text-xs font-medium">Belum ada data produk terlaris</span>
                    </div>
                @endforelse
            </div>

            <a href="{{ route('nonadmin.products.index') }}"
                class="block text-center mt-6 text-xs font-bold text-emerald-600 hover:text-emerald-700 hover:underline">
                Lihat Katalog Produk Selengkapnya &rarr;
            </a>
        </div>
    </div>
@endsection