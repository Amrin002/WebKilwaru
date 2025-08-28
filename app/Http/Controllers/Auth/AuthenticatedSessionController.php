<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\KK;
use App\Models\Penduduk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $dataPenduduk = Penduduk::all()->count();
        $dataKk = KK::all()->count();
        $layanan = 3;
        return view('auth.login', compact('dataPenduduk', 'dataKk', 'layanan'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Redirect berdasarkan role user
        $user = $request->user();

        // Debug: Log user information
        Log::info('User Login Debug', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_roles' => $user->roles,
            'is_admin_method_exists' => method_exists($user, 'isAdmin'),
            'is_admin_result' => method_exists($user, 'isAdmin') ? $user->isAdmin() : 'method not found'
        ]);

        if ($user && $user->roles === 'admin') {
            return redirect()->intended(route('admin.index', absolute: false))
                ->with('success', 'Selamat Datang Admin! Anda Berhasil Masuk');
        } else {
            return redirect()->intended(route('dashboard', absolute: false))
                ->with('success', 'Selamat Datang! Anda Berhasil Masuk');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    }
}
