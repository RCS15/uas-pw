@extends('layouts.app')

@php
    $isEdit = isset($transaction);
    $title = $isEdit ? 'Edit Catatan Transaksi' : 'Catat Transaksi Baru';
    $actionUrl = $isEdit ? route('admin.transactions.update', $transaction['id']) : route('admin.transactions.store');
@endphp

@section('title', $title)
@section('header_title', 'Transaksi')

@section('content')
    <div class="mb-8">
        <a href="{{ route('admin.transactions.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-500 hover:text-emerald-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Transaksi
        </a>
        <h1 class="text-2xl font-bold text-gray-900 mt-2">{{ $title }}</h1>
        <p class="text-sm text-gray-500">Isi formulir pembukuan dengan informasi yang benar.</p>
    </div>

    <div class="max-w-2xl bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/20 overflow-hidden">
        <form action="{{ $actionUrl }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf
            
            @if ($isEdit)
                <input type="hidden" name="id" value="{{ $transaction['id'] }}">
                @method("PUT")
            @endif

            <input type="hidden" name="user_id" value="{{ old('user_id', $isEdit ? $transaction['user_id'] : auth()->id()) }}">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="tanggal" class="block text-xs font-semibold text-gray-600 mb-2">Tanggal Transaksi <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" id="tanggal" required
                        value="{{ old('tanggal', $isEdit ? $transaction['tanggal'] : date('Y-m-d')) }}"
                        class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800">
                    @error('tanggal')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jenis_transaksi" class="block text-xs font-semibold text-gray-600 mb-2">Jenis Transaksi <span class="text-red-500">*</span></label>
                    <select name="jenis_transaksi" id="jenis_transaksi" required
                        class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800">
                        <option value="">-- Pilih Jenis --</option>
                        <option value="income" {{ old('jenis_transaksi', $isEdit ? $transaction['jenis_transaksi'] : '') == 'income' ? 'selected' : '' }}>
                            Pemasukan
                        </option>
                        <option value="expense" {{ old('jenis_transaksi', $isEdit ? $transaction['jenis_transaksi'] : '') == 'expense' ? 'selected' : '' }}>
                            Pengeluaran
                        </option>
                    </select>
                    @error('jenis_transaksi')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="deskripsi" class="block text-xs font-semibold text-gray-600 mb-2">Keterangan Transaksi <span class="text-red-500">*</span></label>
                <input type="text" name="deskripsi" id="deskripsi" required
                    value="{{ old('deskripsi', $isEdit ? $transaction['deskripsi'] : '') }}"
                    class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800"
                    placeholder="Contoh: Penjualan Kopi 50 Cup / Pembelian Gula Pasir">
                @error('deskripsi')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="tipe_transaksi" class="block text-xs font-semibold text-gray-600 mb-2">Tipe Transaksi <span class="text-red-500">*</span></label>
                    <select name="tipe_transaksi" id="tipe_transaksi" required
                        class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800">
                        <option value="">-- Pilih Tipe Transaksi --</option>
                        @php
                            $tipeOptions = [
                                'penjualan' => 'Penjualan',
                                'pendapatan_lain' => 'Pendapatan Lain',
                                'pembelian' => 'Pembelian',
                                'operasional' => 'Operasional',
                                'modal' => 'Modal'
                            ];
                        @endphp
                        @foreach ($tipeOptions as $value => $label)
                            <option value="{{ $value }}" 
                                {{ old('tipe_transaksi', $isEdit ? $transaction['tipe_transaksi'] : '') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('tipe_transaksi')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="total_harga" class="block text-xs font-semibold text-gray-600 mb-2">Jumlah Nominal (Rp) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-sm font-bold text-gray-400">
                            Rp
                        </span>
                        <input type="number" name="total_harga" id="total_harga" required min="1" step="0.01"
                            value="{{ old('total_harga', $isEdit ? $transaction['total_harga'] : '') }}"
                            class="block w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800 font-bold"
                            placeholder="0">
                    </div>
                    @error('total_harga')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.transactions.index') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-500 hover:text-gray-700 hover:bg-gray-50 rounded-xl transition-all duration-150">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow-sm shadow-emerald-600/10 transition-colors">
                    {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Transaksi' }}
                </button>
            </div>
        </form>
    </div>
@endsection