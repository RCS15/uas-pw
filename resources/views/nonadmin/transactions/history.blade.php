@extends('layouts.app')

@section('title', 'Riwayat Transaksi Penjualan')
@section('header_title', 'Riwayat Transaksi')

@section('content')
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Riwayat Penjualan Anda</h1>
            <p class="text-sm text-gray-500">Catatan seluruh nota penjualan yang diinput oleh Anda selama bertugas</p>
        </div>
        <a href="{{ route('nonadmin.transactions.create') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow-sm shadow-emerald-600/10 transition-colors self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Input Penjualan Baru
        </a>
    </div>

    {{-- <div
        class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20 mb-6 flex flex-col sm:flex-row gap-4 items-center justify-between">
        <div class="relative w-full sm:w-80">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input name="sear" type="text" placeholder="Cari nota atau keterangan penjualan..."
                class="block w-full pl-9 pr-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white rounded-xl text-xs transition-all duration-150">
        </div>
        <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
            <select
                class="text-xs bg-gray-50 border border-gray-200 rounded-xl p-2.5 focus:outline-none focus:border-emerald-500">
                <option value="today">Hari Ini</option>
                <option value="yesterday">Kemarin</option>
            </select>
        </div>
    </div> --}}

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-gray-50 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100">
                        <th class="px-6 py-4">ID Nota</th>
                        <th class="px-6 py-4">Waktu Input</th>
                        <th class="px-6 py-4">Keterangan / Catatan</th>
                        <th class="px-6 py-4">Jenis</th>
                        <th class="px-6 py-4 text-right">Total Pendapatan</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-600">
                    {{-- DIUBAH: Menggunakan variabel $transactions dari controller dan memanggilnya sebagai objek Eloquent -> bukan array [''] --}}
                    @forelse ($transactions ?? [] as $t)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-gray-800">
                                #{{ $t->id }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-500">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-800">
                                        {{ date('H:i', strtotime($t->created_at)) }}
                                    </span>
                                    <span class="text-xs font-medium text-gray-500 mt-0.5">
                                        {{ date('d M Y', strtotime($t->created_at)) }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                <div class="font-bold text-gray-900 mb-1">
                                    {{ $t->deskripsi }}
                                </div>
                                <div class="space-y-1 bg-gray-50 p-2 rounded-xl border border-gray-100 text-xs">
                                    @foreach ($t->details as $detail)
                                        <div class="flex justify-between items-center w-full">
                                            <span>
                                                • {{ $detail->product->nama_barang ?? 'Produk Dihapus' }}
                                                <strong class="text-gray-900"> x ({{ $detail->jumlah }})</strong>
                                            </span>
                                            <span class="text-gray-400">
                                                (Rp {{ number_format($detail->subtotal, 0, ',', '.') }})
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <span
                                        class="text-xs bg-emerald-50 text-emerald-800 border border-emerald-100 px-2.5 py-1 rounded-full font-semibold capitalize text-center">
                                        {{ $t->jenis_transaksi }}
                                    </span>
                                    <span
                                        class="text-xs bg-emerald-50 text-emerald-800 border border-emerald-100 px-2.5 py-1 rounded-full font-semibold capitalize text-center">
                                        {{ $t->tipe_transaksi }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right font-bold text-emerald-600">
                                Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="px-12 py-4 text-center">
                                <a href="#"
                                    class="text-xs font-bold text-gray-500 hover:text-emerald-600 border border-gray-200 hover:border-emerald-500 px-3 py-1.5 rounded-lg bg-white transition-all shadow-sm">
                                    Cetak Struk
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400 font-medium">
                                Belum ada riwayat penjualan yang tercatat pada shift ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between">
            <span class="text-xs text-gray-500 font-medium">Menampilkan 1 - {{ count($transactions ?? []) }} dari
                {{ count($transactions ?? []) }} data</span>
            <div class="flex items-center gap-1">
                <button disabled
                    class="p-1 px-3 bg-white border border-gray-200 rounded-lg text-xs font-medium text-gray-400 cursor-not-allowed">Sebelumnya</button>
                <button
                    class="p-1 px-3 bg-emerald-600 border border-emerald-600 rounded-lg text-xs font-medium text-white shadow-sm shadow-emerald-600/10">1</button>
                <button disabled
                    class="p-1 px-3 bg-white border border-gray-200 rounded-lg text-xs font-medium text-gray-400 cursor-not-allowed">Selanjutnya</button>
            </div>
        </div>
    </div>  x
@endsection
