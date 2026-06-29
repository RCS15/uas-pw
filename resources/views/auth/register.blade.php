@extends('layouts.auth')

@section('title', 'Buat Akun UMKM')

@section('content')
    <div class="text-center mb-6">
        <h1 class="text-gray-900 font-extrabold text-2xl tracking-tight">Buat Akun UMKM</h1>
        <p class="text-sm text-gray-500 mt-1">Silahkan Daftarkan Akun Anda</p>
    </div>

    <!-- Form Register -->
    <form action="{{ route('register') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Owner Name Input --}}
        <div>
            <label for="name" class="block text-xs font-semibold text-gray-600 mb-1.5">Nama Pemilik</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </span>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="block w-full pl-9 pr-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800" 
                    placeholder="Nama Lengkap Anda">
            </div>
            @error('name')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email Input --}}
        <div>
            <label for="email" class="block text-xs font-semibold text-gray-600 mb-1.5">Alamat Email</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </span>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="block w-full pl-9 pr-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800" 
                    placeholder="nama@email.com">
            </div>
            @error('email')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password Input --}}
        <div>
            <label for="password" class="block text-xs font-semibold text-gray-600 mb-1.5">Kata Sandi</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </span>
                <input type="password" name="password" id="password" required
                    class="block w-full pl-9 pr-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800" 
                    placeholder="Minimal 8 karakter">
            </div>
            @error('password')
                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Konfirmasi Kata Sandi Input --}}
        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-gray-600 mb-1.5">Konfirmasi Kata Sandi</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </span>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="block w-full pl-9 pr-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800" 
                    placeholder="Ulangi kata sandi">
            </div>
        </div>

        {{-- Terms Checkbox --}}
        <div class="flex items-start">
            <input type="checkbox" id="terms" name="terms" required class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500/20 focus:ring-2 mt-0.5">
            <label for="terms" class="ml-2 text-xs font-medium text-gray-500 select-none">Saya menyetujui seluruh <a href="#" class="text-emerald-600 font-semibold hover:underline">Syarat & Ketentuan</a> yang berlaku</label>
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white rounded-xl text-sm font-bold shadow-md shadow-emerald-600/15 hover:shadow-lg hover:shadow-emerald-600/25 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 mt-2">
            Buat Akun UMKM
        </button>
    </form>

    {{-- Login Link --}}
    <div class="text-center mt-6">
        <p class="text-xs text-gray-500">
            Sudah memiliki akun? 
            <a href="{{ route('auth.login') }}" class="font-bold text-emerald-600 hover:text-emerald-700 ml-1">Masuk Aplikasi</a>
        </p>
    </div>
@endsection
