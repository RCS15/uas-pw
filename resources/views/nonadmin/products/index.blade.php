@extends('layouts.app')

@section('title', 'Katalog Produk')
@section('header_title', 'Katalog Produk')

@section('content')
    <!-- Products Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Katalog Produk & Cek Stok</h1>
            <p class="text-sm text-gray-500">Cek harga barang dan sisa stok gudang secara real-time saat bertugas</p>
        </div>
    </div>

    <!-- Search / Filter Section -->
    <form action="{{ request()->url() }}" method="GET"
        class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20 mb-8 flex flex-col sm:flex-row gap-4 items-center justify-between">

        <div class="relative w-full sm:w-80">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama produk lalu tekan Enter..."
                class="block w-full pl-9 pr-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white rounded-xl text-xs transition-all duration-150">
        </div>

        <div class="flex w-full sm:w-auto gap-2">
            <select name="category_id" onchange="this.form.submit()"
                class="text-xs bg-gray-50 border border-gray-200 rounded-xl p-2.5 focus:outline-none focus:border-emerald-500 w-full sm:w-auto">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request()->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->nama_kategori }}
                    </option>
                @endforeach
            </select>

            @if (request('search') || request('category_id'))
                <a href="{{ request()->url() }}"
                    class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl p-2.5 flex items-center justify-center transition-all">
                    Reset
                </a>
            @endif
        </div>
    </form>

    <!-- Products Grid using Reusable Component -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($products ?? [] as $p)
            @include('shared.product-card', ['product' => $p, 'isAdmin' => false])
        @empty
            <div
                class="col-span-full bg-white border border-gray-100 rounded-3xl p-12 text-center text-gray-400 font-medium">
                <div class="flex flex-col items-center justify-center gap-3">
                    <svg class="w-16 h-16 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span>Katalog produk masih kosong. Hubungi admin untuk memasukkan produk.</span>
                </div>
            </div>
        @endforelse
    </div>

    @if ($products->hasPages())
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @endif
@endsection
