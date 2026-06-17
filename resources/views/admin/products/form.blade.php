@extends('layouts.app')

@php
    $isEdit = isset($product);
    $title = $isEdit ? 'Edit Informasi Produk' : 'Tambah Produk Baru';
    $actionUrl = $isEdit ? route('admin.products.index') : route('admin.products.index');
@endphp

@section('title', $title)
@section('header_title', 'Kelola Produk')

@section('content')
    <div class="mb-8">
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-500 hover:text-emerald-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Katalog Produk
        </a>
        <h1 class="text-2xl font-bold text-gray-900 mt-2">{{ $title }}</h1>
        <p class="text-sm text-gray-500">Formulir untuk memasukkan data inventaris barang/produk.</p>
    </div>

    <div class="max-w-2xl bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/20 overflow-hidden">
        <form action="{{ $actionUrl }}" method="GET" class="p-6 sm:p-8 space-y-6">
            @if ($isEdit)
                <input type="hidden" name="id" value="{{ $product['id'] }}">
            @endif

            <!-- Product Name -->
            <div>
                <label for="name" class="block text-xs font-semibold text-gray-600 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" required
                    value="{{ old('name', $isEdit ? $product['name'] : '') }}"
                    class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800"
                    placeholder="Contoh: Kopi Arabika Lintong 250gr">
                @error('name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Price -->
                <div>
                    <label for="price" class="block text-xs font-semibold text-gray-600 mb-2">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-sm font-bold text-gray-400">
                            Rp
                        </span>
                        <input type="number" name="price" id="price" required min="0"
                            value="{{ old('price', $isEdit ? $product['price'] : '') }}"
                            class="block w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800 font-bold"
                            placeholder="0">
                    </div>
                    @error('price')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock -->
                <div>
                    <label for="stock" class="block text-xs font-semibold text-gray-600 mb-2">Stok Awal <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" id="stock" required min="0"
                        value="{{ old('stock', $isEdit ? $product['stock'] : '0') }}"
                        class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800"
                        placeholder="0">
                    @error('stock')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Category Select -->
            <div>
                <label for="category_name" class="block text-xs font-semibold text-gray-600 mb-2">Kategori Produk <span class="text-red-500">*</span></label>
                <select name="category_name" id="category_name" required
                    class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Makanan" {{ old('category_name', $isEdit ? ($product['category_name'] ?? $product['category']['name'] ?? '') : '') === 'Makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="Minuman" {{ old('category_name', $isEdit ? ($product['category_name'] ?? $product['category']['name'] ?? '') : '') === 'Minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="Bahan Baku" {{ old('category_name', $isEdit ? ($product['category_name'] ?? $product['category']['name'] ?? '') : '') === 'Bahan Baku' ? 'selected' : '' }}>Bahan Baku</option>
                </select>
                @error('category_name')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-semibold text-gray-600 mb-2">Deskripsi Produk (Opsional)</label>
                <textarea name="description" id="description" rows="4"
                    class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800"
                    placeholder="Tuliskan spesifikasi produk, rasa, ukuran kemasan, dll...">{{ old('description', $isEdit ? ($product['description'] ?? '') : '') }}</textarea>
                @error('description')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-500 hover:text-gray-700 hover:bg-gray-50 rounded-xl transition-all duration-150">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow-sm shadow-emerald-600/10 transition-colors">
                    {{ $isEdit ? 'Simpan Perubahan' : 'Buat Produk' }}
                </button>
            </div>
        </form>
    </div>
@endsection
