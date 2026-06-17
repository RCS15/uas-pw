@props(['product', 'isAdmin' => false])

@php
    $stock = $product['stock'] ?? 0;
    $stockColor = 'text-emerald-700 bg-emerald-50 border-emerald-200';
    $stockText = 'Stok Tersedia (' . $stock . ')';
    
    if ($stock == 0) {
        $stockColor = 'text-red-700 bg-red-50 border-red-200';
        $stockText = 'Stok Habis';
    } elseif ($stock < 10) {
        $stockColor = 'text-amber-700 bg-amber-50 border-amber-200';
        $stockText = 'Stok Menipis (' . $stock . ')';
    }
    
    $detailUrl = $isAdmin 
        ? route('admin.products.edit', $product['id']) 
        : route('nonadmin.products.show', $product['id']);
@endphp

<div class="bg-white rounded-2xl border border-gray-100 hover:border-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/5 transition-all duration-300 flex flex-col overflow-hidden group">
    {{-- Card Header Image --}}
    <div class="h-44 bg-gradient-to-br from-emerald-500/10 to-teal-500/5 flex items-center justify-center relative overflow-hidden">
        {{-- Geometric decoration --}}
        <div class="absolute -top-10 -right-10 w-24 h-24 rounded-full bg-emerald-500/10 group-hover:scale-125 transition-transform duration-500"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 rounded-full bg-teal-500/10 group-hover:scale-125 transition-transform duration-500"></div>
        
        <svg class="w-16 h-16 text-emerald-600/80 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
        </svg>

        <span class="absolute top-3 left-3 text-xs font-semibold px-2.5 py-1 rounded-full border {{ $stockColor }}">
            {{ $stockText }}
        </span>
    </div>

    {{-- Card Body --}}
    <div class="p-5 flex-1 flex flex-col justify-between">
        <div>
            <div class="text-xs font-medium text-emerald-600 mb-1.5 uppercase tracking-wider">
                {{ $product['category']['name'] ?? $product['category_name'] ?? 'Kategori Umum' }}
            </div>
            <h3 class="text-gray-800 font-semibold text-base line-clamp-1 mb-2 group-hover:text-emerald-700 transition-colors duration-200">
                {{ $product['name'] }}
            </h3>
            <p class="text-gray-500 text-xs line-clamp-2 mb-4">
                {{ $product['description'] ?? 'Tidak ada deskripsi produk.' }}
            </p>
        </div>

        <div>
            <div class="flex items-center justify-between mt-auto pt-3 border-t border-gray-100">
                <div>
                    <span class="text-gray-400 text-[10px] block font-medium uppercase tracking-wider">Harga Jual</span>
                    <span class="text-emerald-700 font-bold text-lg">
                        Rp {{ number_format($product['price'] ?? 0, 0, ',', '.') }}
                    </span>
                </div>
                
                <a href="{{ $detailUrl }}" class="p-2.5 bg-gray-50 hover:bg-emerald-600 hover:text-white rounded-xl transition-all duration-200 text-gray-600 border border-gray-100 hover:border-emerald-600 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
