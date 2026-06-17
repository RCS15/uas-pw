@extends('layouts.app')

@section('title', 'Detail Produk')
@section('header_title', 'Katalog Produk')

@section('content')
    <div class="mb-8">
        <a href="{{ route('nonadmin.products.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-500 hover:text-emerald-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Katalog
        </a>
        <h1 class="text-2xl font-bold text-gray-900 mt-2">Informasi Produk</h1>
        <p class="text-sm text-gray-500">Rincian spesifikasi, harga, dan ketersediaan stok barang.</p>
    </div>

    @php
        $stock = $product['stock'] ?? 0;
        $stockBadge = 'text-emerald-700 bg-emerald-50 border-emerald-200';
        $stockLabel = 'Stok Tersedia (' . $stock . ' Pcs)';
        
        if ($stock == 0) {
            $stockBadge = 'text-red-700 bg-red-50 border-red-200';
            $stockLabel = 'Stok Habis / Kosong';
        } elseif ($stock < 10) {
            $stockBadge = 'text-amber-700 bg-amber-50 border-amber-200';
            $stockLabel = 'Stok Hampir Habis (' . $stock . ' Pcs)';
        }
    @endphp

    <div class="max-w-4xl bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/20 overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-5 divide-y md:divide-y-0 md:divide-x divide-gray-100">
            
            <!-- Product Graphics/Illustration (2 Columns) -->
            <div class="md:col-span-2 bg-gradient-to-br from-emerald-500/5 to-teal-500/5 flex flex-col items-center justify-center p-8 text-center relative min-h-64 md:min-h-auto">
                <div class="absolute -top-10 -right-10 w-28 h-28 rounded-full bg-emerald-500/5"></div>
                <div class="absolute -bottom-10 -left-10 w-32 h-32 rounded-full bg-teal-500/5"></div>

                <div class="p-6 bg-white rounded-2xl shadow-md shadow-gray-200/20 border border-gray-50 mb-4 z-10">
                    <svg class="w-20 h-20 text-emerald-600/90" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <span class="text-xs font-semibold px-3 py-1.5 rounded-full border {{ $stockBadge }} z-10">
                    {{ $stockLabel }}
                </span>
            </div>

            <!-- Product Data Details (3 Columns) -->
            <div class="md:col-span-3 p-6 sm:p-8 flex flex-col justify-between space-y-6">
                <div>
                    <!-- Category -->
                    <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest block mb-2">
                        {{ $product['category']['name'] ?? $product['category_name'] ?? 'Kategori Umum' }}
                    </span>
                    <!-- Name -->
                    <h2 class="text-2xl font-extrabold text-gray-900 leading-snug mb-3">
                        {{ $product['name'] }}
                    </h2>
                    <!-- Description -->
                    <p class="text-gray-500 text-sm leading-relaxed mb-6">
                        {{ $product['description'] ?? 'Tidak ada deskripsi lengkap mengenai produk ini.' }}
                    </p>

                    <!-- Details Stats -->
                    <div class="grid grid-cols-2 gap-4 border-t border-b border-gray-100 py-4">
                        <div>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">ID PRODUK</span>
                            <span class="text-sm font-bold text-gray-800">#PROD-{{ str_pad($product['id'] ?? 0, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">KONDISI STOK</span>
                            <span class="text-sm font-bold text-gray-800">
                                @if($stock > 0)
                                    Baik (Terjual Terus)
                                @else
                                    Perlu Restock
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Price and Actions -->
                <div class="flex items-center justify-between pt-4">
                    <div>
                        <span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider">Harga Jual Kasir</span>
                        <span class="text-2xl font-black text-emerald-700">
                            Rp {{ number_format($product['price'] ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                    
                    <a href="{{ route('nonadmin.products.index') }}" class="px-5 py-2.5 bg-gray-50 border border-gray-200 hover:bg-gray-100 text-gray-700 font-semibold rounded-xl text-sm transition-colors shadow-sm">
                        Kembali ke Katalog
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
