@props(['product', 'isAdmin' => false])

@php
    $stock = $product['stok'] ?? 0;
    $stockColor = 'text-emerald-700 bg-emerald-50 border-emerald-200';
    $stockText = 'Stok Tersedia (' . $stock . ')';

    if ($stock == 0) {
        $stockColor = 'text-red-700 bg-red-50 border-red-200';
        $stockText = 'Stok Habis';
    } elseif ($stock < 10) {
        $stockColor = 'text-amber-700 bg-amber-50 border-amber-200';
        $stockText = 'Stok Menipis (' . $stock . ')';
    }
@endphp

<div
    class="bg-white rounded-2xl border border-gray-100 hover:border-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/5 transition-all duration-300 flex flex-col overflow-hidden group">
    {{-- Card Header Image --}}
    <div class="h-44 bg-gray-100 flex items-center justify-center relative overflow-hidden group">
        {{-- GAMBAR DARI INTERNET --}}
        <img src="https://loremflickr.com/600/440/{{ urlencode($product->category->nama_kategori ?? 'product') }}/all?grayscale"
            alt="{{ $product->nama_barang }}"
            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

        {{-- Efek Overlay Gelap Tipis saat Hover --}}
        <div class="absolute inset-0 bg-black/5 group-hover:bg-black/10 transition-colors duration-300"></div>

        {{-- Badge Status Stok --}}
        <span
            class="absolute top-3 left-3 text-xs font-semibold px-2.5 py-1 rounded-full border shadow-sm backdrop-blur-md {{ $stockColor }}">
            {{ $stockText }}
        </span>
    </div>

    {{-- Card Body --}}
    <div class="p-5 flex-1 flex flex-col justify-between">
        <div>
            <div class="text-xs font-medium text-emerald-600 mb-1.5 uppercase tracking-wider">
                {{ $product->category->nama_kategori ?? 'Kategori Umum' }}
            </div>
            <h3
                class="text-gray-800 font-semibold text-base line-clamp-1 mb-2 group-hover:text-emerald-700 transition-colors duration-200">
                {{ $product['nama_barang'] }}
            </h3>
            <p class="text-gray-500 text-xs line-clamp-2 mb-4">
                {{ $product->category->deskripsi ?? '' }}
            </p>
        </div>

        <div>
            <div class="flex items-center justify-between mt-auto pt-3 border-t border-gray-100">
                <div>
                    <span class="text-gray-400 text-[10px] block font-medium uppercase tracking-wider">Harga Jual</span>
                    <span class="text-emerald-700 font-bold text-lg">
                        Rp {{ number_format($product['harga'] ?? 0, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex gap-2 items-center">
                    @if ($isAdmin)
                        {{-- Tombol Edit --}}
                        <a href="{{ route('admin.products.edit', $product['id']) }}"
                            class="p-2.5 bg-gray-50 hover:bg-emerald-600 hover:text-white rounded-xl transition-all duration-200 text-gray-600 border border-gray-100 hover:border-emerald-600 shadow-sm"
                            title="Edit Produk">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </a>

                        {{-- Tombol Hapus (Menggunakan Form Berwarna Merah/Rose) --}}
                        <form action="{{ route('admin.products.destroy', $product['id']) }}" method="POST" 
                            class="inline" 
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk {{ $product['nama_barang'] }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="p-2.5 bg-gray-50 hover:bg-emerald-600 hover:text-white rounded-xl transition-all duration-200 text-gray-600 border border-gray-100 hover:border-emerald-600 shadow-sm"
                                title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" 
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </form>
                    @endif

                    {{-- Tombol Detail --}}
                    <a href="{{ $isAdmin ? route('admin.products.show', $product['id']) : route('nonadmin.products.show', $product['id']) }}"
                        class="p-2.5 bg-gray-50 hover:bg-emerald-600 hover:text-white rounded-xl transition-all duration-200 text-gray-600 border border-gray-100 hover:border-emerald-600 shadow-sm"
                        title="Lihat Detail">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>