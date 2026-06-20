@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('header_title', 'Dashboard Admin')

@section('content')
    <!-- Welcome Header Section -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Halo, {{ Auth::user()->name }}!</h1>
            <p class="text-sm text-gray-500">Berikut adalah rangkuman keuangan usaha Anda hari ini.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs font-semibold text-gray-500 bg-white border border-gray-200 px-3.5 py-2 rounded-xl shadow-sm flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Sistem Online
            </span>
            <a href="{{ route('admin.transactions.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow-sm shadow-emerald-600/10 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Transaksi Baru
            </a>
        </div>
    </div>

    <!-- KPI Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Total Pendapatan Card --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pendapatan</span>
                <span class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-2xl font-bold text-gray-900">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</span>
            </div>
            <div class="mt-2 text-xs font-medium text-emerald-600 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                </svg>
                <span>Seluruh pemasukan tercatat</span>
            </div>
        </div>

        {{-- Total Pengeluaran Card --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pengeluaran</span>
                <span class="p-2.5 bg-rose-50 text-rose-600 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path>
                    </svg>
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-2xl font-bold text-gray-900">Rp {{ number_format($total_pengeluaran, 0, ',', '.') }}</span>
            </div>
            <div class="mt-2 text-xs font-medium text-red-600 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z" clip-rule="evenodd"></path>
                </svg>
                <span>Seluruh pengeluaran tercatat</span>
            </div>
        </div>

        {{-- Saldo Bersih Card --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Saldo Bersih</span>
                <span class="p-2.5 bg-blue-50 text-blue-600 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-2xl font-bold {{ $laba_bersih >= 0 ? 'text-gray-900' : 'text-rose-600' }}">Rp {{ number_format($laba_bersih, 0, ',', '.') }}</span>
            </div>
            <div class="mt-2 text-xs font-medium {{ $laba_bersih >= 0 ? 'text-emerald-600' : 'text-rose-600' }} flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ $laba_bersih >= 0 ? 'Laba' : 'Rugi' }} bersih usaha</span>
            </div>
        </div>

        {{-- Total Transaksi & Stok Rendah Card --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Transaksi</span>
                <span class="p-2.5 bg-amber-50 text-amber-600 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-2xl font-bold text-gray-900">{{ $total_transaksi }}</span>
                <span class="text-sm text-gray-400">transaksi</span>
            </div>
            <div class="mt-2 text-xs font-medium {{ $low_stock_count > 0 ? 'text-amber-600' : 'text-emerald-600' }} flex items-center gap-1">
                <span>{{ $low_stock_count > 0 ? $low_stock_count . ' produk stok rendah' : 'Semua stok aman' }}</span>
            </div>
        </div>
    </div>

    <!-- Chart and Quick Actions Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Revenue Trends Chart --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20 lg:col-span-2">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-base font-bold text-gray-900 mb-1">Tren Pendapatan</h3>
                    <p class="text-xs text-gray-500">7 Hari Terakhir</p>
                </div>
            </div>
            
            {{-- SVG Chart Placeholder --}}
            <div class="h-64 flex items-end justify-between relative mt-4">
                <!-- Background Gridlines -->
                <div class="absolute inset-x-0 top-0 border-b border-gray-100/80 h-0"></div>
                <div class="absolute inset-x-0 top-1/4 border-b border-gray-100/80 h-0"></div>
                <div class="absolute inset-x-0 top-2/4 border-b border-gray-100/80 h-0"></div>
                <div class="absolute inset-x-0 top-3/4 border-b border-gray-100/80 h-0"></div>
                <div class="absolute inset-x-0 bottom-0 border-b border-gray-100 h-0"></div>

                <!-- Custom SVG Graph representing dynamic trends -->
                <svg class="absolute inset-0 w-full h-full" viewBox="0 0 100 40" preserveAspectRatio="none">
                    <defs>
                        <linearGradient id="gradient-chart" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#10b981" stop-opacity="0.2"/>
                            <stop offset="100%" stop-color="#10b981" stop-opacity="0.0"/>
                        </linearGradient>
                    </defs>
                    <!-- Area Path -->
                    <path d="{{ $areaPathD }}" fill="url(#gradient-chart)"></path>
                    <!-- Line Path -->
                    <path d="{{ $pathD }}" fill="none" stroke="#10b981" stroke-width="1.5" stroke-linecap="round"></path>
                </svg>

                <!-- Label X-Axis -->
                <div class="absolute inset-x-0 bottom-[-24px] flex justify-between text-[10px] text-gray-400 font-semibold">
                    @foreach($chartLabels as $label)
                        <span>{{ $label }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20 flex flex-col justify-between">
            <div>
                <h3 class="text-base font-bold text-gray-900 mb-1">Aksi Cepat</h3>
                <p class="text-xs text-gray-500 mb-6">Pintasan menu administrasi aplikasi</p>
                
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('admin.transactions.create') }}" class="flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 hover:border-emerald-500 hover:bg-emerald-50/10 group transition-all duration-200 text-center">
                        <span class="p-2 bg-emerald-50 text-emerald-600 rounded-lg group-hover:bg-emerald-500 group-hover:text-white transition-colors mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </span>
                        <span class="text-xs font-semibold text-gray-700">Catat Keuangan</span>
                    </a>

                    <a href="{{ route('admin.reports.profit-loss') }}" class="flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 hover:border-emerald-500 hover:bg-emerald-50/10 group transition-all duration-200 text-center">
                        <span class="p-2 bg-emerald-50 text-emerald-600 rounded-lg group-hover:bg-emerald-500 group-hover:text-white transition-colors mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </span>
                        <span class="text-xs font-semibold text-gray-700">Laporan L/R</span>
                    </a>

                    <a href="{{ route('admin.products.create') }}" class="flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 hover:border-emerald-500 hover:bg-emerald-50/10 group transition-all duration-200 text-center">
                        <span class="p-2 bg-emerald-50 text-emerald-600 rounded-lg group-hover:bg-emerald-500 group-hover:text-white transition-colors mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </span>
                        <span class="text-xs font-semibold text-gray-700">Tambah Produk</span>
                    </a>

                    <a href="{{ route('admin.users.create') }}" class="flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 hover:border-emerald-500 hover:bg-emerald-50/10 group transition-all duration-200 text-center">
                        <span class="p-2 bg-emerald-50 text-emerald-600 rounded-lg group-hover:bg-emerald-500 group-hover:text-white transition-colors mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </span>
                        <span class="text-xs font-semibold text-gray-700">Tambah Staff</span>
                    </a>
                </div>
            </div>
            
            <div class="mt-4 p-3.5 bg-emerald-50/50 rounded-xl border border-emerald-100/50 flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-[11px] text-emerald-800">
                    <p class="font-bold">Tips Hari Ini</p>
                    <p>Unduh laporan bulanan untuk melihat analisis piutang secara rinci.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20 overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b border-gray-50">
            <div>
                <h3 class="text-base font-bold text-gray-900">Transaksi Terbaru</h3>
                <p class="text-xs text-gray-500">Daftar transaksi yang baru saja dicatat</p>
            </div>
            <a href="{{ route('admin.transactions.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">Lihat Semua</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100">
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Waktu - Tanggal</th>
                        <th class="px-6 py-4">Deskripsi</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4 text-right">Jumlah</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-600">
                    @forelse ($recent_transactions as $t)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-gray-400">
                                #{{ $t->id }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-400">
                                <div class="flex items-center gap-2">
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-gray-800 text-sm">{{ $t->user->name ?? '-' }}</span>
                                        <span class="text-xs text-gray-500">{{ $t->user->email ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-500 flex flex-col">
                                <span class="font-bold text-gray-800">
                                    {{ date('H:i', strtotime($t->created_at)) }}
                                </span>
                                <span>
                                    {{ date('d M Y', strtotime($t->created_at)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                {{ $t->deskripsi ?? 'Keterangan' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <span
                                        class="text-xs border px-2.5 py-1 rounded-full font-semibold capitalize text-center 
                                        {{ $t->jenis_transaksi === 'income'
                                            ? 'bg-emerald-50 text-emerald-800 border-emerald-100'
                                            : 'bg-rose-50 text-rose-800 border-rose-100' }}">
                                        {{ $t->jenis_transaksi }}
                                    </span>
                                    <span
                                        class="text-xs bg-blue-50 text-blue-800 border border-blue-100 px-2.5 py-1 rounded-full font-semibold capitalize text-center">
                                        {{ $t->tipe_transaksi }}
                                    </span>
                                </div>
                            </td>
                            <td
                                class="px-6 py-4 text-right font-bold {{ $t->jenis_transaksi === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $t->jenis_transaksi === 'income' ? '+' : '-' }} Rp
                                {{ number_format($t->total_harga ?? ($t->amount ?? 0), 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <a href="{{ route('admin.transactions.edit', $t->id) }}"
                                        class="text-xs font-bold text-emerald-600 hover:text-emerald-700 transition-colors">Edit</a>
                                    <form action="{{ route('admin.transactions.destroy', $t->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-xs font-bold text-red-600 hover:text-red-700 transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400 font-medium">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                    <span>Belum ada transaksi tercatat.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
