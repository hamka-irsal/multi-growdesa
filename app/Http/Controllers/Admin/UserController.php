<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Menampilkan halaman data user.
     */
    public function index(Request $request)
    {
        $perPage = $request->integer('perPage', 10);
        $search = $request->input('search');

        $users = $this->userQuery($search)
            ->with('permissions')
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        $permissions = Permission::query()
            ->where('guard_name', 'api')
            ->orderBy('name')
            ->get();

        return view('admin.user.index', compact(
            'users',
            'permissions',
            'perPage',
            'search'
        ));
    }

    /**
     * Mengambil data user untuk pagination AJAX.
     */
    public function paginate(Request $request)
    {
        $perPage = $request->integer('perPage', 10);
        $search = $request->input('search');

        $users = $this->userQuery($search)
            ->with('permissions')
            ->latest()
            ->paginate($perPage);

        return response()->json($users);
    }

    /**
     * Menyimpan data user baru beserta permission.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            $this->storeRules(),
            $this->validationMessages()
        );

        if ($validator->fails()) {
            return $this->validationErrorResponse(
                $validator->errors()
            );
        }

        try {
            DB::transaction(function () use ($validator) {
                $data = $validator->validated();

                /*
                |--------------------------------------------------------------------------
                | Ambil Permission
                |--------------------------------------------------------------------------
                */

                $permissions = $data['permissions'] ?? [];

                unset($data['permissions']);

                /*
                |--------------------------------------------------------------------------
                | Password
                |--------------------------------------------------------------------------
                */

                $data['password'] = Hash::make(
                    $data['password']
                );

                /*
                |--------------------------------------------------------------------------
                | Default Status Verifikasi
                |--------------------------------------------------------------------------
                */

                $data['status_verifikasi'] = 'disetujui';

                /*
                |--------------------------------------------------------------------------
                | Buat User
                |--------------------------------------------------------------------------
                */

                $user = User::create($data);

                /*
                |--------------------------------------------------------------------------
                | Simpan Permission
                |--------------------------------------------------------------------------
                */

                $user->syncPermissions($permissions);
            });

            return response()->json([
                'status' => true,
                'message' => 'Operator berhasil ditambahkan.',
            ], 201);
        } catch (\Throwable $e) {
            Log::error('Gagal menambahkan user.', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->serverErrorResponse(
                'Terjadi kesalahan saat menambahkan operator.'
            );
        }
    }

    /**
     * Mengambil data user untuk form edit.
     */
    /**
     * Mengambil data user untuk form edit.
     */
    public function edit(User $user)
    {
        $user->load('permissions');

        return response()->json([
            'status' => true,
            'message' => 'Data user ditemukan.',

            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],

            'permissions' => $user->permissions
                ->pluck('name')
                ->values()
                ->toArray(),
        ]);
    }

    /**
     * Memperbarui data user beserta permission.
     */
    public function update(
        Request $request,
        User $user
    ) {
        $validator = Validator::make(
            $request->all(),
            $this->updateRules($user->id),
            $this->validationMessages()
        );

        if ($validator->fails()) {
            return $this->validationErrorResponse(
                $validator->errors()
            );
        }

        try {
            DB::transaction(function () use (
                $user,
                $validator
            ) {
                $data = $validator->validated();

                /*
                |--------------------------------------------------------------------------
                | Ambil Permission
                |--------------------------------------------------------------------------
                */

                $permissions = $data['permissions'] ?? [];

                unset($data['permissions']);

                /*
                |--------------------------------------------------------------------------
                | Password
                |--------------------------------------------------------------------------
                */

                if (!empty($data['password'])) {
                    $data['password'] = Hash::make(
                        $data['password']
                    );
                } else {
                    unset($data['password']);
                }

                /*
                |--------------------------------------------------------------------------
                | Update User
                |--------------------------------------------------------------------------
                */

                $user->update($data);

                /*
                |--------------------------------------------------------------------------
                | Update Permission
                |--------------------------------------------------------------------------
                */

                $user->syncPermissions($permissions);
            });

            return response()->json([
                'status' => true,
                'message' => 'Operator berhasil diperbarui.',
            ]);
        } catch (\Throwable $e) {
            Log::error('Gagal memperbarui user.', [
                'user_id' => $user->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->serverErrorResponse(
                'Terjadi kesalahan saat memperbarui operator.'
            );
        }
    }

    /**
     * Menghapus data user.
     */
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return response()->json([
                'status' => false,
                'message' => 'Anda tidak dapat menghapus akun sendiri.',
            ], 403);
        }

        try {
            $user->delete();

            return response()->json([
                'status' => true,
                'message' => 'Operator berhasil dihapus.',
            ]);
        } catch (\Throwable $e) {
            Log::error('Gagal menghapus user.', [
                'user_id' => $user->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->serverErrorResponse(
                'Terjadi kesalahan saat menghapus operator.'
            );
        }
    }

    /**
     * Query user dengan fitur pencarian.
     */
    private function userQuery(?string $search)
    {
        return User::query()
            ->whereIn('role', [
                'admin',
                'aparat',
            ])
            ->when(
                $search,
                function ($query, $search) {
                    $query->where(
                        function ($query) use ($search) {
                            $query
                                ->where(
                                    'name',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'email',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'role',
                                    'like',
                                    "%{$search}%"
                                );
                        }
                    );
                }
            );
    }

    /**
     * Aturan validasi saat menambahkan user.
     */
    private function storeRules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
            ],

            'role' => [
                'required',
                'in:admin,aparat',
            ],

            'permissions' => [
                'nullable',
                'array',
            ],

            'permissions.*' => [
                'string',
                'exists:permissions,name',
            ],
        ];
    }

    /**
     * Aturan validasi saat memperbarui user.
     */
    private function updateRules(
        int $userId
    ): array {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                "unique:users,email,{$userId}",
            ],

            'password' => [
                'nullable',
                'string',
                'min:6',
            ],

            'role' => [
                'required',
                'in:admin,aparat',
            ],

            'permissions' => [
                'nullable',
                'array',
            ],

            'permissions.*' => [
                'string',
                'exists:permissions,name',
            ],
        ];
    }

    /**
     * Pesan validasi.
     */
    private function validationMessages(): array
    {
        return [
            'name.required' =>
            'Nama lengkap wajib diisi.',

            'email.required' =>
            'Email wajib diisi.',

            'email.email' =>
            'Format email tidak valid.',

            'email.unique' =>
            'Email sudah digunakan.',

            'password.required' =>
            'Password wajib diisi.',

            'password.min' =>
            'Password minimal 6 karakter.',

            'role.required' =>
            'Level wajib dipilih.',

            'role.in' =>
            'Level yang dipilih tidak valid.',

            'permissions.array' =>
            'Format permission tidak valid.',

            'permissions.*.exists' =>
            'Permission yang dipilih tidak tersedia.',
        ];
    }

    /**
     * Response ketika validasi gagal.
     */
    private function validationErrorResponse(
        $errors
    ) {
        return response()->json([
            'status' => false,
            'message' => 'Validasi data gagal.',
            'errors' => $errors,
        ], 422);
    }

    /**
     * Response ketika terjadi kesalahan server.
     */
    private function serverErrorResponse(
        string $message
    ) {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], 500);
    }
}
