@extends('layouts.app')

@section('title', 'Input Transaksi Kasir')
@section('header_title', 'Transaksi Kasir')

@section('content')
    <div class="pb-32 font-sans">
        <div class="mb-8">
            <a href="{{ route('nonadmin.dashboard') }}"
                class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-500 hover:text-emerald-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Kembali ke Dashboard
            </a>
            <h1 class="text-2xl font-bold text-gray-900 mt-2">Input Transaksi Penjualan</h1>
            <p class="text-sm text-gray-500">Pilih produk langsung pada menu, kelola jumlah pesanan, dan proses transaksi
                dengan cepat.</p>
        </div>

        <form action="{{ route('nonadmin.transactions.store') }}" method="POST" id="main-transaction-form">
            @csrf

            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="jenis_transaksi" value="income">
            <input type="hidden" name="tipe_transaksi" value="penjualan">
            <input type="hidden" name="total_harga" id="total_harga_input" value="0">

            <div id="dynamic-inputs-container"></div>

            <div class="max-w-5xl bg-white rounded-3xl border border-gray-100 p-6 shadow-sm mb-8">
                <h2 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-4">Informasi Transaksi</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="tanggal" class="block text-xs font-semibold text-gray-600 mb-2">Tanggal Transaksi <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" id="tanggal" required value="{{ date('Y-m-d') }}"
                            class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all text-gray-800">
                        @error('tanggal')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="deskripsi" class="block text-xs font-semibold text-gray-600 mb-2">Catatan Transaksi
                            <span class="text-red-500">*</span></label>
                        <input type="text" name="deskripsi" id="deskripsi" required
                            class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all text-gray-800"
                            placeholder="Contoh: Penjualan shift pagi">
                        @error('deskripsi')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 p-5 rounded-xl border border-gray-100 shadow-sm">
                <h2 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-4">Daftar Menu Produk</h2>

                @if (empty($products))
                    <div
                        class="bg-gray-50 rounded-2xl p-12 text-center border border-dashed border-gray-200 text-gray-400 text-sm">
                        Belum ada data produk yang terdaftar di sistem.
                    </div>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-5">
                        @foreach ($products as $product)
                            <div
                                class="bg-white rounded-2xl border border-gray-100 hover:border-emerald-500/30 hover:shadow-xl hover:shadow-emerald-500/5 transition-all duration-300 flex flex-col overflow-hidden group">

                                {{-- Card Header Image --}}
                                <div
                                    class="h-44 bg-gray-100 flex items-center justify-center relative overflow-hidden group">
                                    {{-- GAMBAR DARI INTERNET --}}
                                    <img src="https://loremflickr.com/600/440/{{ urlencode($product->category->nama_kategori ?? 'product') }}/all?grayscale"
                                        alt="{{ $product->nama_barang }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

                                    {{-- Efek Overlay Gelap Tipis saat Hover --}}
                                    <div
                                        class="absolute inset-0 bg-black/5 group-hover:bg-black/10 transition-colors duration-300">
                                    </div>
                                </div>

                                <div class="relative w-full overflow-hidden mb-1 mt-1 flex items-center justify-center">
                                    @if ($product->stok == 0)
                                        <span class="text-red-500 text-xs">Stok Habis</span>
                                    @elseif($product->stok < 10)
                                        <span class="text-red-500 text-xs">Stok menipis ({{ $product->stok }})
                                        </span>
                                    @else
                                        <span class="text-emerald-500 text-xs">Stok Tersedia ({{ $product->stok }})
                                        </span>
                                    @endif
                                </div>

                                <div class="flex flex-col justify-between flex-1 p-2">
                                    <div>
                                        <h3
                                            class="text-xs font-bold text-gray-700 uppercase tracking-wide line-clamp-2 min-h-[2rem] leading-tight">
                                            {{ $product['nama_barang'] }}
                                        </h3>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-600 line-clamp-2">
                                            {{ $product->category->deskripsi }}
                                        </p>
                                    </div>

                                    <div class="mt-1 pt-1 border-t border-gray-50">
                                        <p class="text-sm font-black text-emerald-600 mb-2.5">
                                            Rp {{ number_format($product['harga'] ?? 0, 0, ',', '.') }}
                                        </p>

                                        <div class="product-action-zone h-8 flex items-center justify-center"
                                            data-id="{{ $product['id'] }}" data-name="{{ $product['nama_barang'] }}"
                                            data-price="{{ $product['harga'] ?? 0 }}"
                                            data-stock="{{ $product['stok'] ?? 0 }}">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div id="checkout-sticky-bar"
                class="fixed bottom-0 left-0 right-0 p-4 bg-white border-t border-gray-100 shadow-[0_-4px_20px_rgba(0,0,0,0.04)] hidden z-50 transition-transform duration-300">
                <div
                    class="max-w-4xl mx-auto bg-emerald-600 rounded-2xl p-3 flex items-center justify-between text-white shadow-lg shadow-emerald-600/20">

                    <div class="flex items-center space-x-5">
                        <div class="relative p-2 bg-emerald-700/60 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <span id="badge-total-qty"
                                class="absolute -top-1.5 -right-1.5 bg-white text-emerald-700 text-[10px] font-black px-1.5 py-0.5 rounded-full shadow">
                                0
                            </span>
                        </div>
                        <div>
                            <p class="text-[10px] text-emerald-100 font-semibold uppercase tracking-wider">Total Pembayaran
                            </p>
                            <p class="text-lg font-black tracking-wide">Rp <span id="grand-total-display">0</span></p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" id="reset-cart-btn"
                            class="text-xs text-emerald-100 font-medium hover:text-white px-2 py-1 transition-colors">
                            Clear
                        </button>
                        <button type="submit"
                            class="bg-white text-emerald-700 font-bold text-xs tracking-wider px-6 py-3 rounded-xl shadow-sm hover:bg-emerald-50 active:scale-95 transition-all flex items-center gap-1">
                            PROSES TRANSAKSI <span id="btn-count-display">(0)</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let cart = [];

            // Format Helper Rupiah (.toLocaleString)
            function formatRupiah(number) {
                return new Intl.NumberFormat('id-ID').format(number);
            }

            // 1. Sinkronisasi Data Ke Element Input Form Hidden untuk Laravel Request
            function syncFormInputs() {
                const container = document.getElementById('dynamic-inputs-container');
                container.innerHTML = ''; // bersihkan data lama

                let grandTotal = 0;
                let totalQty = 0;

                cart.forEach(item => {
                    grandTotal += item.price * item.qty;
                    totalQty += item.qty;

                    // Input ID Produk
                    const inputId = document.createElement('input');
                    inputId.type = 'hidden';
                    inputId.name = 'product_id[]';
                    inputId.value = item.id;
                    container.appendChild(inputId);

                    // Input Qty Produk
                    const inputQty = document.createElement('input');
                    inputQty.type = 'hidden';
                    inputname = 'qty[]'; // support framework mapping data array
                    inputQty.name = 'qty[]';
                    inputQty.value = item.qty;
                    container.appendChild(inputQty);
                });

                // Update display bar bawah
                document.getElementById('grand-total-display').textContent = formatRupiah(grandTotal);
                document.getElementById('total_harga_input').value = grandTotal;
                document.getElementById('badge-total-qty').textContent = totalQty;
                document.getElementById('btn-count-display').textContent = `(${totalQty})`;

                // Kontrol visibilitas Sticky Bar
                const stickyBar = document.getElementById('checkout-sticky-bar');
                if (cart.length > 0) {
                    stickyBar.classList.remove('hidden');
                } else {
                    stickyBar.classList.add('hidden');
                }
            }

            // 2. Render UI Tombol "Tambah" atau "Counter" pada Tiap Card Produk
            function renderInterfaceControls() {
                const zones = document.querySelectorAll('.product-action-zone');

                zones.forEach(zone => {
                    const id = zone.getAttribute('data-id');
                    const name = zone.getAttribute('data-name');
                    const price = parseInt(zone.getAttribute('data-price')) || 0;
                    const stock = parseInt(zone.getAttribute('data-stock')) || 0;

                    // Jika stok produk 0, kosongkan zona kontrol
                    if (stock <= 0) {
                        zone.innerHTML =
                            `<span class="text-xs text-gray-400 font-medium">Stok Tidak Tersedia</span>`;
                        return;
                    }

                    // Cari tahu apakah item ini sudah masuk cart atau belum
                    const cartItem = cart.find(item => item.id === id);

                    if (!cartItem) {
                        // KONDISI 1: Tampilkan tombol Tambah murni
                        zone.innerHTML = `
                        <button type="button" class="btn-add-to-cart w-full py-1.5 border border-emerald-300 text-emerald-600 font-bold rounded-xl text-xs hover:bg-emerald-50 active:scale-95 transition-all">
                            Tambah
                        </button>
                    `;

                        // Trigger click pasang di button baru
                        zone.querySelector('.btn-add-to-cart').addEventListener('click', () => {
                            cart.push({
                                id,
                                name,
                                price,
                                stock,
                                qty: 1
                            });
                            updateLayoutState();
                        });
                    } else {
                        // KONDISI 2: Tampilkan Counter minus, text, plus
                        zone.innerHTML = `
                        <div class="flex items-center justify-between w-full max-w-[110px] mx-auto bg-gray-50 border border-gray-100 rounded-xl p-0.5">
                            <button type="button" class="btn-dec-qty w-7 h-7 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-gray-600 shadow-sm hover:bg-gray-50 active:scale-95 transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" /></svg>
                            </button>
                            <span class="text-xs font-black text-gray-800 text-center w-6">${cartItem.qty}</span>
                            <button type="button" class="btn-inc-qty w-7 h-7 flex items-center justify-center rounded-lg bg-white border border-gray-200 text-gray-600 shadow-sm hover:bg-gray-50 active:scale-95 transition-all">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                            </button>
                        </div>
                    `;

                        // Event listener tombol kurangi kuantitas
                        zone.querySelector('.btn-dec-qty').addEventListener('click', () => {
                            cartItem.qty -= 1;
                            if (cartItem.qty <= 0) {
                                cart = cart.filter(item => item.id !==
                                    id); // tendang dari cart jika 0
                            }
                            updateLayoutState();
                        });

                        // Event listener tombol tambah kuantitas
                        zone.querySelector('.btn-inc-qty').addEventListener('click', () => {
                            if (cartItem.qty < stock) {
                                cartItem.qty += 1;
                            } else {
                                alert('Batas maksimal pembelian sesuai ketersediaan stok!');
                            }
                            updateLayoutState();
                        });
                    }
                });
            }

            // Bundling fungsi pembaharuan state global
            function updateLayoutState() {
                renderInterfaceControls();
                syncFormInputs();
            }

            // Bersihkan seluruh isi keranjang
            document.getElementById('reset-cart-btn').addEventListener('click', () => {
                if (confirm('Apakah Anda ingin mengosongkan keranjang transaksi?')) {
                    cart = [];
                    updateLayoutState();
                }
            });

            // Inisialisasi awal UI sesaat setelah web selesai diload
            updateLayoutState();
        });
    </script>
@endsection
