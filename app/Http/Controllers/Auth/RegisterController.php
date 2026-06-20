<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Tampilkan form registrasi.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Proses pendaftaran akun baru.
     *
     * Akun yang mendaftar sendiri lewat halaman publik otomatis diberi
     * role "nonadmin" (staf/kasir). Akun admin hanya dibuat lewat menu
     * Kelola Pengguna oleh admin lain, atau lewat AdminSeeder.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['accepted'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'nonadmin',
        ]);

        Auth::login($user);

        return redirect()->route('auth.login')
            ->with('success', 'Akun berhasil dibuat. Silahkan login!');
    }
}