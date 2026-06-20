@extends('layouts.app')

@section('title', 'Input Transaksi Kasir')
@section('header_title', 'Transaksi Kasir')

@section('content')
    <div class="mb-8">
        <a href="{{ route('nonadmin.dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-500 hover:text-emerald-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Dashboard
        </a>
        <h1 class="text-2xl font-bold text-gray-900 mt-2">Input Transaksi Penjualan</h1>
        <p class="text-sm text-gray-500">Pilih produk, tentukan jumlah pesanan, dan sistem akan menghitung total belanjaan secara otomatis.</p>
    </div>

    <div class="max-w-4xl bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/20 overflow-hidden">
        <form action="{{ route('nonadmin.transactions.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf

            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="jenis_transaksi" value="income">
            <input type="hidden" name="tipe_transaksi" value="penjualan">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="tanggal" class="block text-xs font-semibold text-gray-600 mb-2">Tanggal Transaksi <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" id="tanggal" required value="{{ date('Y-m-d') }}"
                        class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800">
                    @error('tanggal')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="deskripsi" class="block text-xs font-semibold text-gray-600 mb-2">Catatan Transaksi<span class="text-red-500">*</span></label>
                    <input type="text" name="deskripsi" id="deskripsi" required
                        class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800"
                        placeholder="Contoh: Penjualan hari ini">
                    @error('deskripsi')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100 flex flex-col sm:flex-row gap-4 items-end">
                <div class="flex-1 w-full">
                    <label class="block text-xs font-semibold text-gray-600 mb-2">Pilih Produk untuk Ditambahkan</label>
                    <select id="product-select" class="block w-full px-4 py-2.5 bg-white border border-gray-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800">
                        <option value="">-- Pilih Produk --</option>
                        @foreach ($products ?? [] as $product)
                            <option value="{{ $product['id'] }}" data-price="{{ $product['harga'] ?? 0 }}" data-stock="{{ $product['stok'] ?? 0 }}">{{ $product['nama_barang'] }} - Stok: {{ $product['stok'] ?? 0 }} (Rp {{ number_format($product['harga'] ?? 0, 0, ',', '.') }})</option>
                        @endforeach
                    </select>
                </div>
                <button type="button" id="add-product-btn" class="w-full sm:w-auto px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow-sm transition-colors flex items-center justify-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Item
                </button>
            </div>

            <div class="overflow-x-auto border border-gray-100 rounded-2xl">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 uppercase text-[10px] font-bold tracking-wider border-b border-gray-100">
                            <th class="py-3 px-4">Nama Produk</th>
                            <th class="py-3 px-4 w-32">Harga Satuan</th>
                            <th class="py-3 px-4 w-24">Jumlah</th>
                            <th class="py-3 px-4 w-32">Subtotal</th>
                            <th class="py-3 px-4 w-16 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="cart-table-body" class="divide-y divide-gray-50 text-sm text-gray-700">
                        <tr id="empty-cart-row">
                            <td colspan="5" class="py-8 text-center text-gray-400 text-xs italic">Belum ada produk yang dipilih. Silakan tambah produk di atas.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end items-center pt-4">
                <div class="text-right">
                    <span class="block text-xs font-semibold text-gray-500 mb-1">Total Yang Harus Dibayar:</span>
                    <div class="text-2xl font-black text-gray-950 flex items-center justify-end gap-1">
                        <span>Rp</span>
                        <span id="grand-total-display">0</span>
                    </div>
                    <input type="hidden" name="total_harga" id="total_harga_input" value="0">
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('nonadmin.dashboard') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-500 hover:text-gray-700 hover:bg-gray-50 rounded-xl transition-all duration-150">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow-sm shadow-emerald-600/10 transition-colors">
                    Proses Transaksi
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productSelect = document.getElementById('product-select');
            const addProductBtn = document.getElementById('add-product-btn');
            const cartTableBody = document.getElementById('cart-table-body');
            const emptyCartRow = document.getElementById('empty-cart-row');
            const grandTotalDisplay = document.getElementById('grand-total-display');
            const totalHargaInput = document.getElementById('total_harga_input');

            let cart = [];

            // Fungsi Format Rupiah Ke Tampilan
            function formatRupiah(number) {
                return new Intl.NumberFormat('id-ID').format(number);
            }

            // Fungsi Hitung Ulang Total Belanjaan
            function calculateGrandTotal() {
                let grandTotal = 0;
                cart.forEach(item => {
                    grandTotal += item.price * item.qty;
                });
                grandTotalDisplay.textContent = formatRupiah(grandTotal);
                totalHargaInput.value = grandTotal;
            }

            // Fungsi Render Ulang Isi Tabel Berdasarkan Array Cart
            function renderCart() {
                if (cart.length === 0) {
                    emptyCartRow.style.display = '';
                    // Hapus baris produk lama jika ada
                    document.querySelectorAll('.product-row').forEach(row => row.remove());
                    calculateGrandTotal();
                    return;
                }

                emptyCartRow.style.display = 'none';
                
                // Hapus semua baris produk yang ada sebelum di-render ulang
                document.querySelectorAll('.product-row').forEach(row => row.remove());

                cart.forEach((item, index) => {
                    const subtotal = item.price * item.qty;
                    const tr = document.createElement('tr');
                    tr.className = 'product-row hover:bg-gray-50/50 transition-colors';
                    tr.innerHTML = `
                        <td class="py-3.5 px-4 font-medium text-gray-900">
                            ${item.name}
                            <input type="hidden" name="product_id[]" value="${item.id}">
                        </td>
                        <td class="py-3.5 px-4 text-gray-500">Rp ${formatRupiah(item.price)}</td>
                        <td class="py-3.5 px-4">
                            <input type="number" name="qty[]" value="${item.qty}" min="1" max="${item.stock}" data-index="${index}" 
                                class="qty-input block w-full px-2 py-1.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/10 rounded-lg text-sm transition-all text-center font-semibold">
                        </td>
                        <td class="py-3.5 px-4 font-bold text-gray-800">Rp ${formatRupiah(subtotal)}</td>
                        <td class="py-3.5 px-4 text-center">
                            <button type="button" data-index="${index}" class="delete-btn text-gray-400 hover:text-red-500 transition-colors p-1 rounded-lg hover:bg-red-50 inline-flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </td>
                    `;
                    cartTableBody.appendChild(tr);
                });

                calculateGrandTotal();
            }

            // Aksi Klik Tombol Tambah Produk
            addProductBtn.addEventListener('click', function () {
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                const productId = selectedOption.value;
                
                if (!productId) {
                    alert('Silakan pilih produk terlebih dahulu!');
                    return;
                }

                const productName = selectedOption.text.split(' - Stok:')[0]; // Ambil nama bersihnya saja
                const productPrice = parseInt(selectedOption.getAttribute('data-price')) || 0;
                const productStock = parseInt(selectedOption.getAttribute('data-stock')) || 0;

                if (productStock < 1) {
                    alert('Maaf, stok produk ini habis!');
                    return;
                }

                // Cek apakah produk sudah ada di keranjang
                const existingProductIndex = cart.findIndex(item => item.id === productId);

                if (existingProductIndex > -1) {
                    // Jika ada, tambahkan kuantitasnya (+1) dengan batas maksimum stok
                    if (cart[existingProductIndex].qty < productStock) {
                        cart[existingProductIndex].qty += 1;
                    } else {
                        alert('Kuantitas melebihi stok yang tersedia!');
                    }
                } else {
                    // Jika belum ada, masukkan data baru ke array
                    cart.push({
                        id: productId,
                        name: productName,
                        price: productPrice,
                        stock: productStock,
                        qty: 1
                    });
                }

                renderCart();
                productSelect.value = ''; // Reset dropdown selektor kembali kosong
            });

            // Deteksi Perubahan Kuantitas (Qty) di Tabel
            cartTableBody.addEventListener('input', function (e) {
                if (e.target.classList.contains('qty-input')) {
                    const index = e.target.getAttribute('data-index');
                    let newQty = parseInt(e.target.value) || 1;
                    
                    if(newQty < 1) newQty = 1; // Mencegah angka minus atau 0
                    if(newQty > cart[index].stock) {
                        newQty = cart[index].stock;
                        alert('Kuantitas disesuaikan dengan batas maksimum stok!');
                    }
                    
                    cart[index].qty = newQty;
                    renderCart();
                    
                    // Kembalikan fokus kursor ke input yang sedang diketik agar tidak lepas focus setelah render
                    const inputs = document.querySelectorAll('.qty-input');
                    if(inputs[index]) {
                        inputs[index].focus();
                        inputs[index].setSelectionRange(inputs[index].value.length, inputs[index].value.length);
                    }
                }
            });

            // Aksi Hapus Item dari Keranjang
            cartTableBody.addEventListener('click', function (e) {
                // Cari elemen tombol delete terdekat (jika kasir mengklik icon SVG di dalam button)
                const deleteBtn = e.target.closest('.delete-btn');
                if (deleteBtn) {
                    const index = deleteBtn.getAttribute('data-index');
                    cart.splice(index, 1); // Hapus data dari array index tersebut
                    renderCart();
                }
            });
        });
    </script>
@endsection