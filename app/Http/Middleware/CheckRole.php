<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * Penggunaan: ->middleware('role:admin') atau ->middleware('role:admin,nonadmin')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {

            if($request->wantsJson()) {
                return response()->json([
                    'message' => 'Anda belum login.'
                ], 401);
            }

            return redirect()->route('auth.login')
                ->with('error', 'Silakan masuk terlebih dahulu untuk mengakses halaman ini.');
        }

        if (! in_array($user->role, $roles, true)) {


            if($request->wantsJson()){
                return response()->json([
                    'message' => 'Anda tidak memiliki hak akses untuk membuka halaman ini.'
                ], 403);
            }

            abort(403, 'Anda tidak memiliki hak akses untuk membuka halaman ini.');
        }

        return $next($request);
    }
}