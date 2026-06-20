@extends('layouts.app')

@section('title', 'Kelola Transaksi')
@section('header_title', 'Kelola Transaksi')

@section('content')
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Daftar Transaksi</h1>
            <p class="text-sm text-gray-500">Kelola catatan pemasukan dan pengeluaran UMKM secara berkala</p>
        </div>
        <a href="{{ route('admin.transactions.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow-sm shadow-emerald-600/10 transition-colors self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Catat Transaksi Baru
        </a>
    </div>

    <div
        class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20 mb-6 flex flex-col md:flex-row gap-4 items-center justify-between">
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">

            {{-- Tambahkan tag <form> di sini --}}
            <form id="filterForm" action="{{ route('admin.transactions.index') }}" method="GET"
                class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20 mb-6 flex flex-col md:flex-row gap-4 items-center justify-between">

                <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                    <div class="relative w-full sm:w-64">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>
                        {{-- PERBAIKAN: Tambahkan name="search" dan value request --}}
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari keterangan..."
                            class="block w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white rounded-xl text-xs transition-all duration-150">
                    </div>

                    {{-- PERBAIKAN: Tambahkan name="type" --}}
                    <select name="type" onchange="document.getElementById('filterForm').submit()"
                        class="text-xs bg-gray-50 border border-gray-200 rounded-xl py-2 px-7 focus:outline-none focus:border-emerald-500 w-full sm:w-auto">
                        <option value="">Jenis Transaksi</option>
                        {{-- PERBAIKAN: Cek kondisi selected berdasarkan request URL --}}
                        <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>

                    {{-- Filter berdasarkan tipe transaksi --}}
                    <select name="transaction_type" onchange="document.getElementById('filterForm').submit()" class="text-xs bg-gray-50 border border-gray-200 rounded-xl py-2 px-7 focus:outline-none focus:border-emerald-500 w-full sm:w-auto">
                        <option value="">Tipe Transaksi</option>
                        <option value="penjualan" {{ request('transaction_type') == 'penjualan' ? 'selected' : '' }}>Penjualan
                        </option>
                        <option value="pendapatan_lain" {{ request('transaction_type') == 'pendapatan_lain' ? 'selected' : '' }}>Pendapatan Lain
                        </option>
                        <option value="pembelian" {{ request('transaction_type') == 'pembelian' ? 'selected' : '' }}>Pembelian
                        </option>
                        <option value="operasional" {{ request('transaction_type') == 'operasional' ? 'selected' : '' }}>Operasional
                        </option>
                        <option value="modal" {{ request('transaction_type') == 'modal' ? 'selected' : '' }}>Modal
                        </option>
                    </select>
                </div>

                <div class="flex items-center gap-2 w-full md:w-auto justify-end">
                    {{-- PERBAIKAN: Ubah menjadi tag <a> yang mengarah ke halaman index tanpa query string --}}
                    <a href="{{ route('admin.transactions.index') }}"
                        class="px-3.5 py-2 text-xs font-semibold text-gray-500 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 rounded-xl transition-colors text-center">
                        Reset
                    </a>

                    {{-- PERBAIKAN: Pastikan type="submit" agar form terkirim --}}
                    <button type="submit"
                        class="px-3.5 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-sm transition-colors">
                        Terapkan
                    </button>
                </div>
            </form>

        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-gray-50 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100">
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
                    {{-- PERBAIKAN: Mengubah pemanggilan data array $t[''] menjadi object $t-> --}}
                    @forelse ($transactions as $t)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-gray-400">
                                #{{ $t->id }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-400">
                                <div class="flex items-center gap-2">
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-gray-800 text-sm">{{ $t->user->name }}</span>
                                        <span class="text-xs text-gray-500">{{ $t->user->email }}</span>
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
                                    <span>Tidak ada transaksi yang cocok dengan filter Anda.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between">
            <span class="text-xs text-gray-500 font-medium">Menampilkan 1 - {{ count($transactions) }} dari
                {{ count($transactions) }} data</span>
            <div class="flex items-center gap-1">
                <button disabled
                    class="p-1 px-3 bg-white border border-gray-200 rounded-lg text-xs font-medium text-gray-400 cursor-not-allowed">Sebelumnya</button>
                <button
                    class="p-1 px-3 bg-emerald-600 border border-emerald-600 rounded-lg text-xs font-medium text-white shadow-sm shadow-emerald-600/10">1</button>
                <button disabled
                    class="p-1 px-3 bg-white border border-gray-200 rounded-lg text-xs font-medium text-gray-400 cursor-not-allowed">Selanjutnya</button>
            </div>
        </div>
    </div>
@endsection
