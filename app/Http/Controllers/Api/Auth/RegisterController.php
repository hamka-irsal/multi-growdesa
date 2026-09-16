<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Penduduk;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'nik'                   => 'required|digits:16|unique:users,nik|unique:penduduk,nik',
            'no_hp'                 => 'required|string|min:10|max:15',
            'password'              => 'required|string|min:8|confirmed',
        ], [
            'name.required'         => 'Nama lengkap wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email sudah terdaftar.',

            'nik.required'          => 'NIK wajib diisi.',
            'nik.digits'            => 'NIK harus terdiri dari 16 digit.',
            'nik.unique'            => 'NIK sudah terdaftar.',

            'no_hp.required'        => 'Nomor HP wajib diisi.',
            'no_hp.min'             => 'Nomor HP tidak valid.',

            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal 8 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak sesuai.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {

            // Simpan User
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'nik'       => $request->nik,
                'password'  => Hash::make($request->password),
                'role'      => 'penduduk',
            ]);

            // Simpan Penduduk
            Penduduk::create([
                'user_id'      => $user->id,
                'nik'          => $request->nik,
                'nama_lengkap' => $request->name,
                'no_hp'        => $request->no_hp,

                'jenis_kelamin'=> null,
                'pendidikan'   => '',
                'tempat_lahir' => '',
                'jenis_pekerjaan' => '',
                'tanggal_lahir'=> null,
                'agama'        => '',
                'status_perkawinan' => '',
                'status_hubungan_dalam_keluarga' => '',
                'alamat'       => '',
                'desa_kelurahan'=> '',
                'kecamatan'    => '',
                'kabupaten_kota'=> '',
                'provinsi'     => '',
                'kewarganegaraan'=> '',
                'ayah'         => '',
                'ibu'          => '',
            ]);

            // Generate JWT
            $token = JWTAuth::fromUser($user);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil.',
                'data' => [
                    'token' => $token,
                    'user' => [
                        'id'      => $user->id,
                        'name'    => $user->name,
                        'email'   => $user->email,
                        'nik'     => $user->nik,
                        'role'    => $user->role,
                    ]
                ]
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Register Error', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Registrasi gagal.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
