<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Proses login Superadmin dan Admindesa.
     */
    public function login(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validasi Input
        |--------------------------------------------------------------------------
        */

        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Proses Autentikasi
        |--------------------------------------------------------------------------
        */

        if (!Auth::attempt($credentials)) {
            return back()
                ->withInput($request->only('email'))
                ->with(
                    'error',
                    'Email atau password salah.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Regenerasi Session
        |--------------------------------------------------------------------------
        |
        | Mencegah session fixation setelah login berhasil.
        |
        */

        $request->session()->regenerate();

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Superadmin
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'superadmin') {
            return redirect()->intended(
                route('superadmin.dashboard.index')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Admindesa
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'admindesa') {

            /*
            | Pastikan akun Admindesa sudah terhubung
            | dengan data desa.
            */

            if (empty($user->desa_id)) {

                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()
                    ->route('login')
                    ->with(
                        'error',
                        'Akun Admindesa belum terhubung dengan desa.'
                    );
            }

            return redirect()->intended(
                route('admin.dashboard.index')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Role Tidak Diizinkan
        |--------------------------------------------------------------------------
        */

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
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
        /*
        |--------------------------------------------------------------------------
        | Logout User
        |--------------------------------------------------------------------------
        */

        Auth::logout();

        /*
        |--------------------------------------------------------------------------
        | Hapus Session
        |--------------------------------------------------------------------------
        */

        $request->session()->invalidate();

        /*
        |--------------------------------------------------------------------------
        | Generate CSRF Token Baru
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerateToken();

        /*
        |--------------------------------------------------------------------------
        | Kembali ke Halaman Login
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('login');
    }
}