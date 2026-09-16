<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserVerification
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 401);
        }

        if ($user->status_verifikasi !== 'disetujui') {
            $message = match ($user->status_verifikasi) {
                'pending' => 'Akun Anda masih menunggu verifikasi admin.',
                'ditolak' => 'Akun Anda ditolak oleh admin.',
                default => 'Akun Anda belum dapat mengakses fitur ini.',
            };

            return response()->json([
                'success' => false,
                'message' => $message,
                'status_verifikasi' => $user->status_verifikasi,
            ], 403);
        }

        return $next($request);
    }
}
