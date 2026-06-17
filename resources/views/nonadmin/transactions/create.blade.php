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
        <p class="text-sm text-gray-500">Gunakan form ini untuk mencatat kas masuk atau penjualan baru dari pelanggan.</p>
    </div>

    <div class="max-w-2xl bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/20 overflow-hidden">
        <form action="{{ route('nonadmin.dashboard') }}" method="GET" class="p-6 sm:p-8 space-y-6">
            {{-- Quick action switch: Preselected to Pemasukan since cashier's main job is registering sales --}}
            <input type="hidden" name="type" value="income">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Date -->
                <div>
                    <label for="date" class="block text-xs font-semibold text-gray-600 mb-2">Tanggal Transaksi <span class="text-red-500">*</span></label>
                    <input type="date" name="date" id="date" required
                        value="{{ date('Y-m-d') }}"
                        class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800">
                    @error('date')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category Select (Usually Penjualan/Jasa for cashiers) -->
                <div>
                    <label for="category_id" class="block text-xs font-semibold text-gray-600 mb-2">Kategori Transaksi <span class="text-red-500">*</span></label>
                    <select name="category_id" id="category_id" required
                        class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories ?? [] as $cat)
                            @if (($cat['type'] ?? 'income') === 'income')
                                <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-semibold text-gray-600 mb-2">Keterangan / Item Penjualan <span class="text-red-500">*</span></label>
                <input type="text" name="description" id="description" required
                    class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800"
                    placeholder="Contoh: Penjualan Kopi Arabika + Roti Bakar">
                @error('description')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Amount -->
            <div>
                <label for="amount" class="block text-xs font-semibold text-gray-600 mb-2">Total Penerimaan Uang / Nominal (Rp) <span class="text-red-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-sm font-bold text-gray-400">
                        Rp
                    </span>
                    <input type="number" name="amount" id="amount" required min="1"
                        class="block w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800 font-bold"
                        placeholder="0">
                </div>
                @error('amount')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Additional Notes -->
            <div>
                <label for="notes" class="block text-xs font-semibold text-gray-600 mb-2">Catatan Penjualan / Nomor Meja / Nama Pelanggan (Opsional)</label>
                <textarea name="notes" id="notes" rows="3"
                    class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800"
                    placeholder="Contoh: Meja 05, Pelanggan Bpk. Dani"></textarea>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('nonadmin.dashboard') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-500 hover:text-gray-700 hover:bg-gray-50 rounded-xl transition-all duration-150">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow-sm shadow-emerald-600/10 transition-colors">
                    Simpan & Cetak Struk
                </button>
            </div>
        </form>
    </div>
@endsection
