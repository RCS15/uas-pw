@extends('layouts.app')

@php
    $isEdit = isset($product);
    $title = $isEdit ? 'Edit Informasi Produk' : 'Tambah Produk Baru';
    $actionUrl = $isEdit ? route('admin.products.update', $product) : route('admin.products.store');
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
        <form action="{{ $actionUrl }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <!-- Product Name -->
            <div>
                <label for="nama_barang" class="block text-xs font-semibold text-gray-600 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" name="nama_barang" id="nama_barang" required
                    value="{{ old('nama_barang', $isEdit ? $product['nama_barang'] : '') }}"
                    class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800"
                    placeholder="Contoh: Kopi Arabika Lintong 250gr">
                @error('nama_barang')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Price -->
                <div>
                    <label for="harga" class="block text-xs font-semibold text-gray-600 mb-2">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-sm font-bold text-gray-400">
                            Rp
                        </span>
                        <input type="number" name="harga" id="harga" required min="0"
                            value="{{ old('harga', $isEdit ? $product['harga'] : '') }}"
                            class="block w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800 font-bold"
                            placeholder="0">
                    </div>
                    @error('harga')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock -->
                <div>
                    <label for="stok" class="block text-xs font-semibold text-gray-600 mb-2">Stok Awal <span class="text-red-500">*</span></label>
                    <input type="number" name="stok" id="stok" required min="0"
                        value="{{ old('stok', $isEdit ? $product['stok'] : '0') }}"
                        class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800"
                        placeholder="0">
                    @error('stok')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Category Select -->
            <div>
                <label for="category_id" class="block text-xs font-semibold text-gray-600 mb-2">Kategori Produk <span class="text-red-500">*</span></label>
                <select name="category_id" id="category_id" required
                    class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $isEdit ? $product['category_id'] : '') == $category->id ? 'selected' : '' }}>
                            {{ $category->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
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
