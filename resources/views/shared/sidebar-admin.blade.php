@php
    $currentRoute = request()->route()->getName();
@endphp

<div class="flex flex-col h-full bg-white border-r border-gray-100 w-64 flex-shrink-0">
    <!-- Brand Logo -->
    <div class="flex items-center gap-3 px-6 py-6 border-b border-gray-50">
        <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-md shadow-emerald-500/20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div>
            <h1 class="text-gray-800 font-bold text-lg leading-tight tracking-tight">FinBiz UMKM</h1>
            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">ADMIN</span>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="flex-1 overflow-y-auto px-4 py-6 space-y-7">
        <!-- Main Area -->
        <div>
            <span class="px-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-3">Main</span>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.transactions.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        Transaksi
                    </a>
                </li>
            </ul>
        </div>

        <!-- Reports Section -->
        <div>
            <span class="px-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-3">Laporan Keuangan</span>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.reports.profit-loss') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.reports.profit-loss') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"></path>
                        </svg>
                        Laba & Rugi
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reports.cash-flow') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.reports.cash-flow') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                        Arus Kas
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reports.receivables') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.reports.receivables') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Laporan Piutang
                    </a>
                </li>
            </ul>
        </div>

        <!-- Master Data Section -->
        <div>
            <span class="px-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-3">Master Data</span>
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Produk & Stok
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Kategori
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-emerald-50 text-emerald-700 font-semibold' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-800' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Kelola Pengguna
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Bottom Actions / User Profile Summary -->
    <div class="p-4 border-t border-gray-50 bg-gray-50/50">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-sm shadow-sm">
                AD
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate">Admin Keuangan</p>
                <p class="text-[11px] text-gray-500 truncate">admin@finbiz.com</p>
            </div>
        </div>
        <form action="{{ route('auth.login') }}" method="GET">
            <button type="submit" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-white border border-gray-200 hover:border-red-200 text-gray-600 hover:text-red-600 rounded-xl text-sm font-medium transition-all duration-150 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Keluar Aplikasi
            </button>
        </form>
    </div>
</div>
