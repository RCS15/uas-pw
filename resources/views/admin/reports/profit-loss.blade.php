@extends('layouts.app')

@section('title', 'Laporan Laba Rugi')
@section('header_title', 'Laporan Laba Rugi')

@section('content')
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 print:hidden">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan Laba & Rugi</h1>
            <p class="text-sm text-gray-500">Analisis pendapatan dan beban operasional UMKM Anda secara periodik</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" onclick="printNota()"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:border-emerald-500 text-gray-700 hover:text-emerald-700 rounded-xl text-sm font-semibold shadow-sm hover:shadow transition-all duration-150 cursor-pointer print:hidden">
                <svg class="w-4 h-4 text-gray-500 hover:text-emerald-600" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                    </path>
                </svg>
                Cetak Laporan
            </button>
        </div>
    </div>

    {{-- Form Filter --}}
    <form action="" method="GET"
        class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm shadow-gray-200/20 mb-8 flex flex-wrap gap-4 items-end justify-between print:hidden">
        <div class="flex items-center gap-3">
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Pilih Bulan</label>
                <select name="month"
                    class="text-xs bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-4 focus:outline-none focus:border-emerald-500 w-40 font-semibold">
                    @foreach (['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'] as $key => $value)
                        <option value="{{ $key }}" {{ $currentMonth == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Pilih Tahun</label>
                <select name="year"
                    class="text-xs bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-4 focus:outline-none focus:border-emerald-500 w-32 font-semibold">
                    @php
                        $tahunSekarang = date('Y');
                        $tahunMulai = $tahunSekarang - 3; // Menampilkan pilihan tahun dari 3 tahun lalu sampai tahun ini
                    @endphp
                    @for ($i = $tahunSekarang; $i >= $tahunMulai; $i--)
                        <option value="{{ $i }}" {{ $currentYear == $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="flex gap-2">
            <a href="{{ url()->current() }}"
                class="px-5 py-2.5 text-xs font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl shadow-sm transition-colors text-center">
                Reset
            </a>
            <button type="submit"
                class="px-5 py-2.5 text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-sm transition-colors">
                Tampilkan Laporan
            </button>
        </div>
    </form>

    {{-- Kertas Laporan --}}
    <div id="area-cetak"
        class="bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/25 p-6 sm:p-10 max-w-4xl mx-auto print:border-0 print:shadow-none print:p-0">

        <div class="text-center pb-8 border-b border-gray-100 mb-8">
            <h2 class="text-xl font-extrabold text-gray-900 tracking-tight">FinBiz UMKM</h2>
            <p class="text-sm font-semibold text-emerald-600">LAPORAN LABA & RUGI</p>
            <p class="text-xs text-gray-400 mt-1">Periode: {{ $bulanPeriode }}</p>
        </div>

        {{-- Top Grid Info --}}
        {{-- <div class="grid grid-cols-3 gap-4 mb-8 bg-gray-50/50 p-5 rounded-2xl border border-gray-100 print:bg-white print:border-gray-300">
            <div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Total Pendapatan</span>
                <span class="text-base font-bold text-emerald-600">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</span>
            </div>
            <div class="border-l border-gray-200/60 pl-4">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Total Pengeluaran</span>
                <span class="text-base font-bold text-rose-600">Rp {{ number_format($total_pengeluaran, 0, ',', '.') }}</span>
            </div>
            <div class="border-l border-gray-200/60 pl-4">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">Laba Bersih</span>
                <span class="text-base font-bold {{ $laba_bersih >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                    Rp {{ number_format(abs($laba_bersih), 0, ',', '.') }}
                </span>
            </div>
        </div> --}}

        {{-- Detail Transaksi --}}
        <div class="space-y-8 text-sm">
            {{-- Segment 1: Pendapatan --}}
            <div class="mb-4">
                <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-3 tracking-wide flex justify-between">
                    <span>1. PENDAPATAN OPERASIONAL</span>
                </h3>
                <div class="space-y-2.5">
                    <div class="flex justify-between items-center text-gray-600">
                        <span class="pl-4">Pendapatan dari Penjualan Produk</span>
                        <span class="font-medium">Rp {{ number_format($inflowPenjualan, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-gray-600">
                        <span class="pl-4">Pendapatan Lain-lain</span>
                        <span class="font-medium">Rp {{ number_format($inflowPendapatanLain, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-gray-100/60 font-bold text-gray-800">
                        <span>Total Pendapatan Bersih</span>
                        <span class="text-emerald-700">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Segment 2: Beban & Pengeluaran --}}
            <div>
                <h3 class="font-bold text-gray-800 border-b border-gray-100 pb-2 mb-3 tracking-wide flex justify-between">
                    <span>2. BEBAN & PENGELUARAN</span>
                </h3>
                <div class="space-y-2.5">
                    <div class="flex justify-between items-center text-gray-600">
                        <span class="pl-4">Beban Pembelian (Bahan Baku / Stok)</span>
                        <span class="font-medium">Rp {{ number_format($outflowPembelian, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-gray-600">
                        <span class="pl-4">Beban Operasional Toko (Gaji, Listrik, Sewa)</span>
                        <span class="font-medium">Rp {{ number_format($outflowOperasional, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-2 border-t border-gray-100/60 font-bold text-gray-800">
                        <span>Total Pengeluaran</span>
                        <span class="text-rose-700">Rp {{ number_format($total_pengeluaran, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Segment 3: Kesimpulan Laba --}}
            <div class="pt-6 border-t-2 border-double border-gray-200 space-y-4">

                {{-- Laba Kotor --}}
                <div class="flex justify-between items-center text-sm font-bold text-gray-700">
                    <span>
                        LABA KOTOR (GROSS PROFIT)
                        <span class="text-[10px] font-normal text-gray-400 ml-2 hidden sm:inline-block">
                        </span></span>
                    <span class="{{ $laba_kotor >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                        Rp {{ number_format($laba_kotor, 0, ',', '.') }}
                    </span>
                </div>

                {{-- Laba Bersih --}}
                <div
                    class="flex justify-between items-center text-base font-extrabold text-gray-900 pt-3 border-t border-gray-100/70">
                    <span>{{ $laba_bersih >= 0 ? 'LABA BERSIH (NET PROFIT)' : 'RUGI BERSIH (NET LOSS)' }}</span>
                    <span
                        class="{{ $laba_bersih >= 0 ? 'text-emerald-700 bg-emerald-50 border-emerald-100' : 'text-rose-700 bg-rose-50 border-rose-100' }} px-4 py-1.5 rounded-xl border print:bg-white print:border-0 print:p-0">
                        Rp {{ number_format(abs($laba_bersih), 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Kolom Tanda Tangan (Khusus Print) --}}
        <div class="hidden print:flex items-center justify-between mt-24 text-xs">
            <div class="text-center w-40">
                <p class="text-gray-400 mb-16">Dibuat Oleh,</p>
                <div class="border-b border-gray-400 w-full mb-1"></div>
                <p class="font-bold text-gray-700">Staf Keuangan</p>
            </div>

            <div class="text-center w-40">
                <p class="text-gray-400 mb-16">Disetujui Oleh,</p>
                <div class="border-b border-gray-400 w-full mb-1"></div>
                <p class="font-bold text-gray-700">Pemilik UMKM</p>
            </div>
        </div>

    </div>

    {{-- Javascript untuk nota --}}
    <script>
        function printNota() {
            // 1. Simpan isi seluruh halaman web saat ini (termasuk navbar/sidebar)
            var originalContent = document.body.innerHTML;

            // 2. Ambil hanya bagian yang ingin di-print (div nota)
            var printArea = document.getElementById('area-cetak').innerHTML;

            // 3. Ganti isi body web hanya dengan bagian nota
            document.body.innerHTML = printArea;

            // 4. Lakukan proses print browser
            window.print();

            // 5. Kembalikan tampilan web seperti semula setelah dialog print ditutup
            document.body.innerHTML = originalContent;

            // 6. Reload halaman ringan agar fungsionalitas tombol/javascript lain tidak mati
            window.location.reload();
        }
    </script>

@endsection
