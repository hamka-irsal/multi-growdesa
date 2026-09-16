<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login'    => 'required|string',
            'password' => 'required|string|min:6',
        ], [
            'login.required'    => 'Email atau NIK wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $login = $request->login;

        // Cek apakah input berupa email atau NIK
        $field = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'nik';

        $credentials = [
            $field      => $login,
            'password'  => $request->password,
        ];

        // Pengguna tetap boleh login meskipun statusnya
        // masih pending atau ditolak
        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Email/NIK atau Password salah.',
            ], 401);
        }

        $user = Auth::guard('api')->user();

        // Hanya pengguna dengan status "disetujui"
        // yang boleh mengakses fitur Lengkapi Data
        $aksesLengkapiData =
            $user->status_verifikasi === 'disetujui';

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data' => [
                'access_token' => $token,
                'token_type'   => 'Bearer',
                'expires_in'   => Auth::guard('api')
                    ->factory()
                    ->getTTL() * 60,

                'user' => [
                    'id'                  => $user->id,
                    'name'                => $user->name,
                    'email'               => $user->email,
                    'nik'                 => $user->nik,
                    'role'                => $user->role,
                    'status_verifikasi'   => $user->status_verifikasi,
                ],

                'akses_lengkapi_data' => $aksesLengkapiData,
            ]
        ], 200);
    }

    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.'
        ], 200);
    }
}
