@extends('layouts.app')

@section('title', 'Manajemen Kategori')
@section('header_title', 'Kelola Kategori')

@section('content')
    <!-- Categories Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kategori Transaksi & Produk</h1>
            <p class="text-sm text-gray-500">Kelola kategori pengelompokan produk dan pencatatan keuangan Anda</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow-sm shadow-emerald-600/10 transition-colors self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Kategori Baru
        </a>
    </div>

    <!-- Main Table Container -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b border-gray-100">
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Nama Kategori</th>
                        <th class="px-6 py-4">Deskripsi</th>
                        <th class="px-6 py-4">Tipe Kategori</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-600">
                    @forelse ($categories ?? [] as $cat)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-gray-400">
                                #{{ $cat['id'] }}
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-800">
                                {{ $cat['name'] }}
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $cat['description'] ?? 'Tidak ada deskripsi.' }}
                            </td>
                            <td class="px-6 py-4">
                                @if (($cat['type'] ?? 'product') === 'income')
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        Pemasukan Keuangan
                                    </span>
                                @elseif (($cat['type'] ?? 'product') === 'expense')
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-rose-50 text-rose-700 border border-rose-100">
                                        Pengeluaran Keuangan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full bg-teal-50 text-teal-700 border border-teal-100">
                                        Produk Jualan
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('admin.categories.edit', $cat['id']) }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 transition-colors">Edit</a>
                                    <span class="text-gray-200">|</span>
                                    <form action="{{ route('admin.categories.index') }}" method="GET" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')" class="inline">
                                        <button type="submit" class="text-xs font-bold text-red-600 hover:text-red-700 transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400 font-medium">
                                Tidak ada data kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
