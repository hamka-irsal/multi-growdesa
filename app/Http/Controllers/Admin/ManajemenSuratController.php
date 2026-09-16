<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;

class ManajemenSuratController extends Controller
{
    /**
     * Menampilkan daftar jenis surat.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $query = JenisSurat::query();

        if (!empty($search)) {
            $query->where('nama_jenis', 'like', "%{$search}%");
        }

        $jenisSurat = $query->paginate($perPage);

        return view('admin.surat.manajemen', compact('jenisSurat', 'perPage', 'search'));
    }

    public function search(Request $request)
    {
        try {
            $query = $request->input('query');

            $jenisSurat = JenisSurat::where(function ($q) use ($query) {
                $q->where('nama_jenis', 'like', '%' . $query . '%')
                    ->orWhere('format_nomor', 'like', '%' . $query . '%');
            })
                ->orderBy('id', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $jenisSurat
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Kesalahan saat pencarian Jenis Surat:', ['message' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat pencarian!'
            ], 500);
        }
    }

    public function paginate(Request $request)
    {
        try {
            $perPage = $request->input('perPage', 10);
            $search = $request->input('query');

            $query = JenisSurat::query();

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_jenis', 'like', "%{$search}%")
                        ->orWhere('format_nomor', 'like', "%{$search}%");
                });
            }

            $jenisSurat = $query->orderBy('id', 'desc')->paginate($perPage);

            return response()->json($jenisSurat);
        } catch (\Exception $e) {
            Log::error('❌ Kesalahan saat memuat data Jenis Surat:', ['message' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memuat data!'
            ], 500);
        }
    }

    /**
     * Menyimpan jenis surat baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jenis' => 'required|string|unique:jenis_surat,nama_jenis',
            'format_nomor' => 'required|string',
            'nama_tabel' => [
                'required',
                'string',
                'unique:jenis_surat,nama_tabel',
                function ($attribute, $value, $fail) {
                    // Memeriksa apakah nama tabel ada di database
                    try {
                        if (!Schema::hasTable($value)) {
                            $fail("Nama tabel '$value' tidak ditemukan dalam database.");
                        }
                    } catch (\Exception $e) {
                        $fail("Terjadi kesalahan saat memeriksa nama tabel: " . $e->getMessage());
                    }
                }
            ],
        ]);

        JenisSurat::create($validated);

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);

        $data = [
            'id' => $jenisSurat->id,
            'nama_jenis' => $jenisSurat->nama_jenis,
            'format_nomor' => $jenisSurat->format_nomor,
            'nama_tabel' => $jenisSurat->nama_tabel,
        ];

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        Log::info('Request update jenis surat masuk:', ['id' => $id, 'data' => $request->all()]);

        $validator = Validator::make($request->all(), [
            'nama_jenis' => 'required|string|max:255',
            'format_nomor' => 'required|string|max:255',
            'nama_tabel' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            Log::error('Validasi gagal saat update jenis surat:', $validator->errors()->toArray());
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $jenisSurat = JenisSurat::findOrFail($id);

            $jenisSurat->nama_jenis = $request->nama_jenis;
            $jenisSurat->format_nomor = $request->format_nomor;
            $jenisSurat->nama_tabel = $request->nama_tabel;

            $jenisSurat->save();

            Log::info('Data jenis surat berhasil diperbarui:', ['id' => $jenisSurat->id]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Kesalahan saat update jenis surat:', ['message' => $e->getMessage()]);
            return response()->json([
                'errors' => ['general' => ['Terjadi kesalahan, coba lagi!']]
            ], 500);
        }
    }

    /**
     * Menghapus jenis surat berdasarkan ID.
     */
    public function destroy($id)
    {
        $jenisSurat = JenisSurat::findOrFail($id);
        $jenisSurat->delete();

        return response()->json(['success' => 'Jenis surat berhasil dihapus.']);
    }
}
