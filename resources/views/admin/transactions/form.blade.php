@extends('layouts.app')

@php
    $isEdit = isset($transaction);
    $title = $isEdit ? 'Edit Catatan Transaksi' : 'Catat Transaksi Baru';
    $actionUrl = $isEdit ? route('admin.transactions.index') : route('admin.transactions.index');
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
        <form action="{{ $actionUrl }}" method="GET" class="p-6 sm:p-8 space-y-6">
            @if ($isEdit)
                <input type="hidden" name="id" value="{{ $transaction['id'] }}">
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Transaction Date -->
                <div>
                    <label for="date" class="block text-xs font-semibold text-gray-600 mb-2">Tanggal Transaksi <span class="text-red-500">*</span></label>
                    <input type="date" name="date" id="date" required
                        value="{{ old('date', $isEdit ? date('Y-m-d', strtotime($transaction['date'])) : date('Y-m-d')) }}"
                        class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800">
                    @error('date')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Transaction Type -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-2">Tipe Transaksi <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 hover:bg-gray-100 cursor-pointer select-none transition-all duration-150 text-sm font-semibold has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-300 has-[:checked]:text-emerald-700">
                            <input type="radio" name="type" value="income" class="sr-only" required
                                {{ old('type', $isEdit ? $transaction['type'] : 'income') === 'income' ? 'checked' : '' }}>
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            Pemasukan
                        </label>
                        <label class="flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 hover:bg-gray-100 cursor-pointer select-none transition-all duration-150 text-sm font-semibold has-[:checked]:bg-rose-50 has-[:checked]:border-rose-300 has-[:checked]:text-rose-700">
                            <input type="radio" name="type" value="expense" class="sr-only"
                                {{ old('type', $isEdit ? $transaction['type'] : 'income') === 'expense' ? 'checked' : '' }}>
                            <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                            Pengeluaran
                        </label>
                    </div>
                    @error('type')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-semibold text-gray-600 mb-2">Keterangan Transaksi <span class="text-red-500">*</span></label>
                <input type="text" name="description" id="description" required
                    value="{{ old('description', $isEdit ? $transaction['description'] : '') }}"
                    class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800"
                    placeholder="Contoh: Penjualan Kopi 50 Cup / Pembelian Gula Pasir">
                @error('description')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Category Select -->
                <div>
                    <label for="category_id" class="block text-xs font-semibold text-gray-600 mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select name="category_id" id="category_id" required
                        class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories ?? [] as $cat)
                            <option value="{{ $cat['id'] }}" 
                                {{ old('category_id', $isEdit ? ($transaction['category_id'] ?? $transaction['category']['id'] ?? '') : '') == $cat['id'] ? 'selected' : '' }}>
                                {{ $cat['name'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Amount -->
                <div>
                    <label for="amount" class="block text-xs font-semibold text-gray-600 mb-2">Jumlah Nominal (Rp) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-sm font-bold text-gray-400">
                            Rp
                        </span>
                        <input type="number" name="amount" id="amount" required min="1"
                            value="{{ old('amount', $isEdit ? $transaction['amount'] : '') }}"
                            class="block w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800 font-bold"
                            placeholder="0">
                    </div>
                    @error('amount')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Notes (Optional) -->
            <div>
                <label for="notes" class="block text-xs font-semibold text-gray-600 mb-2">Catatan Tambahan (Opsional)</label>
                <textarea name="notes" id="notes" rows="3"
                    class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800"
                    placeholder="Catatan tambahan mengenai transaksi ini...">{{ old('notes', $isEdit ? ($transaction['notes'] ?? '') : '') }}</textarea>
                @error('notes')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
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
