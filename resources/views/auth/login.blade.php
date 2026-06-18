@extends('layouts.auth')

@section('title', 'Masuk Aplikasi')

@section('content')
    <div class="text-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Selamat Datang Kembali</h2>
        <p class="text-xs text-gray-500 mt-1">Silakan masuk untuk mengakses pembukuan UMKM Anda</p>
    </div>

    <!-- Form Login -->
    <form action="{{ route('login') }}" method="POST" id="loginForm" class="space-y-4">
        @csrf
        {{-- Username/Email Input --}}
        <div>
            <label for="email" class="block text-xs font-semibold text-gray-600 mb-1.5">Alamat Email</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </span>
                <input type="email" name="email" id="email" value="{{ old('email', 'admin@example.com') }}" required
                    class="block w-full pl-9 pr-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800" 
                    placeholder="nama@email.com">
            </div>
            @error('email')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password Input --}}
        <div>
            <div class="flex justify-between items-center mb-1.5">
                <label for="password" class="block text-xs font-semibold text-gray-600">Kata Sandi</label>
                <a href="#" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700">Lupa Sandi?</a>
            </div>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </span>
                <input type="password" name="password" id="password" value="password" required
                    class="block w-full pl-9 pr-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800" 
                    placeholder="••••••••">
            </div>
            @error('password')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Developer Testing Helper: Role Selection --}}
        <div class="p-3 bg-emerald-50/50 rounded-xl border border-emerald-100/50">
            <label for="role_select" class="block text-xs font-bold text-emerald-800 mb-1">Pilih Role Demo (Akses Dashboard)</label>
            <select id="role_select" class="block w-full bg-white border border-emerald-200 focus:border-emerald-500 text-xs font-semibold text-emerald-800 rounded-lg py-1.5 px-2 focus:ring-2 focus:ring-emerald-500/10"
                onchange="updateAction(this.value)">
                <option value="admin">Masuk Sebagai: Admin Keuangan</option>
                <option value="staff">Masuk Sebagai: Staf Kasir</option>
            </select>
        </div>

        {{-- Remember Me Checkbox --}}
        <div class="flex items-center">
            <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500/20 focus:ring-2">
            <label for="remember" class="ml-2 text-xs font-medium text-gray-500 select-none">Ingat perangkat ini</label>
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-xl text-sm font-bold shadow-md shadow-emerald-600/15 hover:shadow-lg hover:shadow-emerald-600/25 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 mt-2">
            Masuk Aplikasi
        </button>
    </form>

    {{-- Register Link --}}
    <div class="text-center mt-6">
        <p class="text-xs text-gray-500">
            Belum punya akun UMKM? 
            <a href="{{ route('auth.register') }}" class="font-bold text-emerald-600 hover:text-emerald-700 ml-1">Daftar Sekarang</a>
        </p>
    </div>

    <!-- Script to dynamically change action depending on demo selection -->
    <script>
        function updateAction(role) {
            const emailInput = document.getElementById('email');
            
            if (role === 'admin') {
                emailInput.value = "admin@example.com";
            } else {
                emailInput.value = "kasir@example.com";
            }
        }
    </script>
@endsection
