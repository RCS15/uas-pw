@props(['product', 'isAdmin' => false])

@php
    $stock = $product['stok'] ?? 0;
    $stockBadge = 'text-emerald-700 bg-emerald-50 border-emerald-200';
    $stockLabel = 'Stok Tersedia (' . $stock . ' Pcs)';

    if ($stock == 0) {
        $stockBadge = 'text-red-700 bg-red-50 border-red-200';
        $stockLabel = 'Stok Habis / Kosong';
    } elseif ($stock < 10) {
        $stockBadge = 'text-amber-700 bg-amber-50 border-amber-200';
        $stockLabel = 'Stok Hampir Habis (' . $stock . ' Pcs)';
    }

    // Menentukan route kembali secara dinamis berdasarkan role
    $backRoute = $isAdmin ? route('admin.products.index') : route('nonadmin.products.index');

    $stock = $product['stok'] ?? 0;
    $stockBadge = 'text-emerald-700 bg-emerald-50 border-emerald-200';
    $stockLabel = 'Stok Tersedia (' . $stock . ' Pcs)';

    if ($stock == 0) {
        $stockBadge = 'text-red-700 bg-red-50 border-red-200';
        $stockLabel = 'Stok Habis / Kosong';
    } elseif ($stock < 10) {
        $stockBadge = 'text-amber-700 bg-amber-50 border-amber-200';
        $stockLabel = 'Stok Hampir Habis (' . $stock . ' Pcs)';
    }

    $canEdit = $isAdmin || $product->user_id == Auth::id();
@endphp

<div>
    {{-- Header Section --}}
    <div class="mb-8">
        <a href="{{ $backRoute }}"
            class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-500 hover:text-emerald-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Kembali ke Katalog
        </a>
        <h1 class="text-2xl font-bold text-gray-900 mt-2">Informasi Produk</h1>
        <p class="text-sm text-gray-500">Rincian barang, harga, dan ketersediaan stok barang.</p>
    </div>

    {{-- Detail Card Section --}}
    <div class="max-w-4xl bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/20 overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-5 divide-y md:divide-y-0 md:divide-x divide-gray-100">

            <div
                class="md:col-span-2 bg-gradient-to-br from-emerald-500/5 to-teal-500/5 flex flex-col items-center justify-center  relative min-h-64 md:min-h-auto">
                <div class="absolute -top-10 -right-10 w-28 h-28 rounded-full bg-emerald-500/5"></div>
                <div class="absolute -bottom-10 -left-10 w-32 h-32 rounded-full bg-teal-500/5"></div>


                @if (!empty($product['foto_produk']))
                    <img src="{{ asset('storage/' . $product['foto_produk']) }}" alt="{{ $product['nama_barang'] }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @else
                    <img src="https://loremflickr.com/600/440/{{ urlencode($product->category->nama_kategori ?? 'product') }}/all?grayscale"
                        alt="{{ $product['nama_barang'] }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @endif

               <span class="absolute bottom-3 text-xs font-semibold px-3 py-1.5 rounded-full border {{ $stockBadge }} z-10">
                    {{ $stockLabel }}
                </span>

            </div>

            <div class="md:col-span-3 p-6 sm:p-8 flex flex-col justify-between space-y-6">
                <div>
                    <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest block">
                        {{ $product->category->nama_kategori ?? 'Kategori Umum' }}
                    </span>
                    <p class="text-gray-500 text-sm leading-relaxed mb-2">
                        {{ $product->category->deskripsi ?? 'Tidak ada deskripsi lengkap mengenai produk ini.' }}
                    </p>
                    <h2 class="text-2xl font-extrabold text-gray-900 leading-snug mb-3">
                        {{ $product['nama_barang'] }}
                    </h2>

                    <div class="grid grid-cols-2 gap-4 border-t border-b border-gray-100 py-4">
                        <div>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">ID
                                PRODUK</span>
                            <span
                                class="text-sm font-bold text-gray-800">#PROD-{{ str_pad($product['id'] ?? 0, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">KONDISI
                                STOK</span>
                            <span class="text-sm font-bold text-gray-800">
                                @if ($stock > 0)
                                    Baik (Terjual Terus)
                                @else
                                    Perlu Restock
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-4">
                    <div>
                        <span class="text-xs font-semibold text-gray-400 block uppercase tracking-wider">Harga
                            Jual</span>
                        <span class="text-2xl font-black text-emerald-700">
                            Rp {{ number_format($product['harga'] ?? 0, 0, ',', '.') }}
                        </span>
                    </div>

                    <a href="{{ $backRoute }}"
                        class="px-5 py-2.5 bg-gray-50 border border-gray-200 hover:bg-gray-100 text-gray-700 font-semibold rounded-xl text-sm transition-colors shadow-sm">
                        Kembali ke Katalog
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
