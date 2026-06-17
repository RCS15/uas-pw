@extends('layouts.app')

@section('title', 'Daftar Produk')
@section('header_title', 'Kelola Produk')

@section('content')
    <!-- Products Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Katalog Produk & Stok</h1>
            <p class="text-sm text-gray-500">Pantau dan kelola persediaan barang/produk UMKM Anda</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow-sm shadow-emerald-600/10 transition-colors self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Produk Baru
        </a>
    </div>

    <!-- Products Grid using Reusable Component -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($products ?? [] as $p)
            @include('shared.product-card', ['product' => $p, 'isAdmin' => true])
        @empty
            <div class="col-span-full bg-white border border-gray-100 rounded-3xl p-12 text-center text-gray-400 font-medium">
                <div class="flex flex-col items-center justify-center gap-3">
                    <svg class="w-16 h-16 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span>Belum ada produk terdaftar. Mulai tambahkan produk baru!</span>
                    <a href="{{ route('admin.products.create') }}" class="mt-2 text-sm font-bold text-emerald-600 hover:underline">Tambah Produk</a>
                </div>
            </div>
        @endforelse
    </div>
@endsection
