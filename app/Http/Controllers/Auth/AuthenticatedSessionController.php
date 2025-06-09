<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller {
    /**
    * Display the login view.
    */

    public function create(): View {
        return view( 'auth.login' );
    }

    /**
    * Handle an incoming authentication request.
    */

    public function store( LoginRequest $request ): RedirectResponse {
        $request->authenticate();
        $request->session()->regenerate();
        // Ambil user yang sudah terautentikasi
        $user = $request->user();

        // Cek apakah user tidak aktif
        if ( !$user->is_active ) {
            // Logout dan hapus sesi
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Kembali ke halaman login dengan pesan error
            return redirect()->route( 'login' )->withErrors( [
                'email' => 'Akun Anda belum aktif. Silakan hubungi admin.',
            ] );
        }

        //    arahkan ke dashboard
        return redirect()->intended( route( 'dashboard', absolute: false ) );
    }

    /**
    * Destroy an authenticated session.
    */

    public function destroy( Request $request ): RedirectResponse {
        Auth::guard( 'web' )->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect( '/' );
    }
}
