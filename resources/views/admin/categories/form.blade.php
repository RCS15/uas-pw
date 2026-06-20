@extends('layouts.app')

@php
    $isEdit = isset($category);
    $title = $isEdit ? 'Edit Kategori' : 'Tambah Kategori Baru';
    $actionUrl = $isEdit ? route('admin.categories.update', $category['id']) : route('admin.categories.store');
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
    <form action="{{ $actionUrl }}" method="POST" class="p-6 sm:p-8 space-y-6">
        @if ($isEdit)
            @method('PUT')
        @endif
        @csrf
            <div class="grid grid-cols-1 gap-6">
                <!-- Category Name -->
                <div>
                    <label for="nama_kategori" class="block text-xs font-semibold text-gray-600 mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_kategori" id="nama_kategori" required
                        value="{{ old('nama_kategori', $isEdit ? $category['nama_kategori'] : '') }}"
                        class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800"
                        placeholder="Contoh: Operasional / Makanan / Piutang">
                    @error('nama_kategori')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
                <div>
                    <label for="deskripsi" class="block text-xs font-semibold text-gray-600 mb-2">Deskripsi Kategori (Opsional)</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"
                        class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800"
                        placeholder="Tuliskan keterangan pengelompokan kategori ini...">{{ old('deskripsi', $isEdit ? ($category['deskripsi'] ?? '') : '') }}</textarea>
                    @error('deskripsi')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

            <!-- Form Actions -->
                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200 pt-4">
                    <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold transition-colors shadow-sm shadow-emerald-600/10">
                        {{ $isEdit ? 'Simpan Perubahan' : 'Buat Kategori' }}
                    </button>
                </div>
        </form>
    </div>
@endsection
