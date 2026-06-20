<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Proses autentikasi login dan redirect berdasarkan role.
     */
public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials)) {
            return back()
                ->withErrors(['email' => 'Email atau kata sandi yang Anda masukkan salah.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // ============================================
        // LOGIKA REDIRECT BERDASARKAN ROLE
        // ============================================

        // 1. Jika user adalah Admin
        if ($user->isAdmin() || $user->role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        // 2. Jika user adalah Non-Admin
        if ($user->role === 'nonadmin') {
            return redirect()->route('nonadmin.dashboard')
                ->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        // 3. Fallback pengaman (opsional)
        // Jika karena alasan tertentu ada user dengan role selain admin/nonadmin di database
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login')
            ->withErrors(['email' => 'Akun Anda tidak memiliki role yang valid untuk login.']);
    }

    /**
     * Proses logout dan hancurkan session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login')
            ->with('success', 'Anda telah keluar dari aplikasi.');
    }
}