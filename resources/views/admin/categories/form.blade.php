@extends('layouts.app')

@php
    $isEdit = isset($category);
    $title = $isEdit ? 'Edit Kategori' : 'Tambah Kategori Baru';
    $actionUrl = $isEdit ? route('admin.categories.index') : route('admin.categories.index');
@endphp

@section('title', $title)
@section('header_title', 'Kelola Kategori')

@section('content')
    <div class="mb-8">
        <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-500 hover:text-emerald-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Kategori
        </a>
        <h1 class="text-2xl font-bold text-gray-900 mt-2">{{ $title }}</h1>
        <p class="text-sm text-gray-500">Gunakan kategori untuk merapikan pembukuan dan stok barang.</p>
    </div>

    <div class="max-w-2xl bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/20 overflow-hidden">
        <form action="{{ $actionUrl }}" method="GET" class="p-6 sm:p-8 space-y-6">
            @if ($isEdit)
                <input type="hidden" name="id" value="{{ $category['id'] }}">
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Category Name -->
                <div>
                    <label for="name" class="block text-xs font-semibold text-gray-600 mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" required
                        value="{{ old('name', $isEdit ? $category['name'] : '') }}"
                        class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800"
                        placeholder="Contoh: Operasional / Makanan / Piutang">
                    @error('name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category Type -->
                <div>
                    <label for="type" class="block text-xs font-semibold text-gray-600 mb-2">Tipe Kategori <span class="text-red-500">*</span></label>
                    <select name="type" id="type" required
                        class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="product" {{ old('type', $isEdit ? ($category['type'] ?? 'product') : '') === 'product' ? 'selected' : '' }}>Produk Jualan</option>
                        <option value="income" {{ old('type', $isEdit ? ($category['type'] ?? '') : '') === 'income' ? 'selected' : '' }}>Pemasukan Keuangan</option>
                        <option value="expense" {{ old('type', $isEdit ? ($category['type'] ?? '') : '') === 'expense' ? 'selected' : '' }}>Pengeluaran Keuangan</option>
                    </select>
                    @error('type')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-semibold text-gray-600 mb-2">Deskripsi Kategori (Opsional)</label>
                <textarea name="description" id="description" rows="3"
                    class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800"
                    placeholder="Tuliskan keterangan pengelompokan kategori ini...">{{ old('description', $isEdit ? ($category['description'] ?? '') : '') }}</textarea>
                @error('description')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.categories.index') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-500 hover:text-gray-700 hover:bg-gray-50 rounded-xl transition-all duration-150">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow-sm shadow-emerald-600/10 transition-colors">
                    {{ $isEdit ? 'Simpan Perubahan' : 'Buat Kategori' }}
                </button>
            </div>
        </form>
    </div>
@endsection
