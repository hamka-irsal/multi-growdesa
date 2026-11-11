<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login admin.
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Proses login admin dan aparat.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
            ],
        ]);

        if (!Auth::attempt($credentials)) {
            return back()
                ->withInput(
                    $request->only('email')
                )
                ->with(
                    'error',
                    'Email atau password salah.'
                );
        }

        $request->session()->regenerate();

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Akses Admin Panel
        |--------------------------------------------------------------------------
        |
        | Role admin dan aparat dapat masuk ke admin panel.
        |
        */

        if (in_array(
            $user->role,
            ['admin', 'aparat'],
            true
        )) {
            return redirect()
                ->intended(
                    route('admin.dashboard.index')
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Role Selain Admin dan Aparat
        |--------------------------------------------------------------------------
        */

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.login')
            ->with(
                'error',
                'Akun Anda tidak memiliki akses ke Admin Panel.'
            );
    }

    /**
     * Proses logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.login');
    }
}
