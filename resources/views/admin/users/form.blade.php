@extends('layouts.app')

@php
    $isEdit = isset($user);
    $title = $isEdit ? 'Edit Akun Pengguna' : 'Tambah Pengguna Baru';
    
    // PERBAIKAN: Sesuaikan endpoint URL dan method penanganan form di Laravel
    $actionUrl = $isEdit ? route('admin.users.update', $user->id) : route('admin.users.store');
@endphp

@section('title', $title)
@section('header_title', 'Kelola Pengguna')

@section('content')
    <div class="mb-8">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-500 hover:text-emerald-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Manajemen Pengguna
        </a>
        <h1 class="text-2xl font-bold text-gray-900 mt-2">{{ $title }}</h1>
        <p class="text-sm text-gray-500">Isi formulir berikut untuk mendaftarkan atau mengubah akses akun.</p>
    </div>

    <div class="max-w-2xl bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/20 overflow-hidden">
        {{-- PERBAIKAN: Ubah method menjadi POST --}}
        <form action="{{ $actionUrl }}" method="POST" class="p-6 sm:p-8 space-y-6">
            {{-- PERBAIKAN: Tambahkan @csrf untuk keamanan token Laravel --}}
            @csrf

            {{-- PERBAIKAN: Jika kondisi edit, kirimkan spoofing method PUT --}}
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-xs font-semibold text-gray-600 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    {{-- PERBAIKAN: Ubah array syntax $user['name'] menjadi object syntax $user->name --}}
                    <input type="text" name="name" id="name" required
                        value="{{ old('name', $isEdit ? $user->name : '') }}"
                        class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800"
                        placeholder="Contoh: Budi Santoso">
                    @error('name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-xs font-semibold text-gray-600 mb-2">Alamat Email <span class="text-red-500">*</span></label>
                    {{-- PERBAIKAN: Ubah array syntax menjadi object syntax --}}
                    <input type="email" name="email" id="email" required
                        value="{{ old('email', $isEdit ? $user->email : '') }}"
                        class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800"
                        placeholder="Contoh: budi@finbiz.com">
                    @error('email')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="role" class="block text-xs font-semibold text-gray-600 mb-2">Peran / Hak Akses <span class="text-red-500">*</span></label>
                <select name="role" id="role" required
                    class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800">
                    <option value="">-- Pilih Peran --</option>
                    {{-- PERBAIKAN: Value opsi disesuaikan dengan isi ENUM database yaitu 'admin' dan 'nonadmin' --}}
                    <option value="admin" {{ old('role', $isEdit ? $user->role : '') === 'admin' ? 'selected' : '' }}>Admin (Pengelola Keuangan Utama)</option>
                    <option value="nonadmin" {{ old('role', $isEdit ? $user->role : '') === 'nonadmin' ? 'selected' : '' }}>Non-Admin (Kasir, Karyawan, atau Staf)</option>
                </select>
                @error('role')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 border-t border-gray-50 pt-6">
                <div>
                    <label for="password" class="block text-xs font-semibold text-gray-600 mb-2">
                        Kata Sandi 
                        @if(!$isEdit)<span class="text-red-500">*</span>@else<span class="text-gray-400 font-normal">(Kosongkan jika tidak diubah)</span>@endif
                    </label>
                    <input type="password" name="password" id="password" {{ !$isEdit ? 'required' : '' }}
                        class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800"
                        placeholder="Minimal 8 karakter">
                    @error('password')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-gray-600 mb-2">Konfirmasi Sandi</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" {{ !$isEdit ? 'required' : '' }}
                        class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/10 rounded-xl text-sm transition-all duration-150 text-gray-800"
                        placeholder="Ketik ulang kata sandi">
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-500 hover:text-gray-700 hover:bg-gray-50 rounded-xl transition-all duration-150">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold shadow-sm shadow-emerald-600/10 transition-colors">
                    {{ $isEdit ? 'Simpan Perubahan' : 'Buat Akun' }}
                </button>
            </div>
        </form>
    </div>
@endsection