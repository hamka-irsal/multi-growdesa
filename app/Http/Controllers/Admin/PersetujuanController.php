<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Persetujuan;
use App\Models\JenisSurat;
use App\Models\Aparat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class PersetujuanController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');

        $query = Persetujuan::with(['jenisSurat', 'aparat']);

        if (!empty($search)) {
            $query->whereHas('jenisSurat', function ($q) use ($search) {
                $q->where('nama_jenis', 'like', "%{$search}%");
            });
        }

        $persetujuan = $query->paginate($perPage);

        $jenisSuratList = JenisSurat::all();
        $aparatList = Aparat::all();

        return view(
            'admin.persetujuan.index',
            compact(
                'persetujuan',
                'perPage',
                'search',
                'jenisSuratList',
                'aparatList'
            )
        );
    }

    public function search(Request $request)
    {
        try {
            $query = $request->input('query');

            $jensisSurat = JenisSurat::where('nama_jenis', 'like', '%' . $query . '%')
                ->orWhere('format_surat', 'like', '%' . $query . '%')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $jensisSurat
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Kesalahan saat pencarian Jensis Surat:', ['message' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat pencarian!'
            ], 500);
        }
    }

    public function paginate(Request $request)
    {
        try {
            $search = $request->input('query');

            $query = Persetujuan::with('jenisSurat'); // sesuaikan nama model & relasi kamu

            if (!empty($search)) {
                $query->where('jabatan', 'like', "%{$search}%")
                    ->orWhereHas('jenisSurat', function ($q) use ($search) {
                        $q->where('nama_jenis', 'like', "%{$search}%");
                    });
            }

            $persetujuan = $query->orderBy('id', 'desc')->paginate(10);

            return response()->json($persetujuan);
        } catch (\Exception $e) {
            Log::error('❌ Kesalahan saat memuat data persetujuan:', ['message' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memuat data!'
            ], 500);
        }
    }

    public function show($id)
    {
        $data = Persetujuan::with(['jenisSurat', 'aparat'])->find($id);

        if (!$data) {

            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function create()
    {
        $jenisSurat = JenisSurat::all();
        $aparat = Aparat::all();

        return view(
            'admin.persetujuan.create',
            compact('jenisSurat', 'aparat')
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
            'aparat_id' => 'required|exists:aparat,id',
            'file_ttd' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ], [
            'jenis_surat_id.required' => 'Jenis surat wajib dipilih.',
            'jenis_surat_id.exists' => 'Jenis surat tidak valid.',

            'aparat_id.required' => 'Penandatangan wajib dipilih.',
            'aparat_id.exists' => 'Penandatangan tidak valid.',

            'file_ttd.required' => 'File tanda tangan wajib diupload.',
            'file_ttd.image' => 'File tanda tangan harus berupa gambar.',
            'file_ttd.mimes' => 'File tanda tangan harus berupa PNG, JPG, atau JPEG.',
            'file_ttd.max' => 'Ukuran file tanda tangan maksimal 2MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {

            // Ambil aparat yang dipilih
            $aparat = Aparat::findOrFail($request->aparat_id);

            // Upload file TTD
            $path = $request->file('file_ttd')->store('ttd', 'public');

            // Simpan persetujuan
            $persetujuan = Persetujuan::create([
                'jenis_surat_id' => $request->jenis_surat_id,
                'aparat_id' => $aparat->id,
                'jabatan' => $aparat->jabatan,
                'file_ttd' => $path,
            ]);

            DB::commit();

            Log::info('Persetujuan berhasil ditambahkan', [
                'id' => $persetujuan->id,
                'jenis_surat_id' => $persetujuan->jenis_surat_id,
                'aparat_id' => $persetujuan->aparat_id,
                'nama_aparat' => $aparat->nama,
                'jabatan' => $aparat->jabatan,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data persetujuan berhasil disimpan.',
                'data' => $persetujuan->load([
                    'jenisSurat',
                    'aparat'
                ]),
            ], 201);
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Gagal menyimpan persetujuan', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data persetujuan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        $data = Persetujuan::with('aparat')->find($id);

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $data->id,
                'jenis_surat_id' => $data->jenis_surat_id,
                'aparat_id' => $data->aparat_id,

                'aparat' => $data->aparat ? [
                    'id' => $data->aparat->id,
                    'nama' => $data->aparat->nama,
                    'jabatan' => $data->aparat->jabatan,
                ] : null,

                'file_ttd_url' => $data->file_ttd
                    ? asset('storage/' . $data->file_ttd)
                    : null,
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = Persetujuan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
            'aparat_id' => 'required|exists:aparat,id',
            'file_ttd' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ], [
            'jenis_surat_id.required' => 'Jenis surat wajib dipilih.',
            'jenis_surat_id.exists' => 'Jenis surat tidak valid.',

            'aparat_id.required' => 'Penandatangan wajib dipilih.',
            'aparat_id.exists' => 'Penandatangan tidak valid.',

            'file_ttd.image' => 'File tanda tangan harus berupa gambar.',
            'file_ttd.mimes' => 'File tanda tangan harus PNG, JPG, atau JPEG.',
            'file_ttd.max' => 'Ukuran file tanda tangan maksimal 2MB.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {

            // Ambil aparat yang dipilih
            $aparat = Aparat::findOrFail($request->aparat_id);

            // Update jenis surat dan aparat
            $data->jenis_surat_id = $request->jenis_surat_id;
            $data->aparat_id = $aparat->id;

            // Jika ada file TTD baru
            if ($request->hasFile('file_ttd')) {

                // Hapus file TTD lama
                if (
                    $data->file_ttd &&
                    Storage::disk('public')->exists($data->file_ttd)
                ) {
                    Storage::disk('public')->delete($data->file_ttd);
                }

                // Simpan file TTD baru
                $data->file_ttd = $request->file('file_ttd')
                    ->store('ttd', 'public');
            }

            $data->save();

            DB::commit();

            Log::info('Persetujuan berhasil diperbarui', [
                'persetujuan_id' => $data->id,
                'jenis_surat_id' => $data->jenis_surat_id,
                'aparat_id' => $aparat->id,
                'nama_aparat' => $aparat->nama,
                'jabatan' => $aparat->jabatan,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data persetujuan berhasil diperbarui.',
                'data' => $data->load([
                    'jenisSurat',
                    'aparat'
                ])
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Gagal memperbarui persetujuan', [
                'id' => $id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data persetujuan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        $data = Persetujuan::find($id);
        if (!$data) {
            return response()->json(['error' => 'Data tidak ditemukan!'], 404);
        }

        if ($data->file_ttd && Storage::disk('public')->exists($data->file_ttd)) {
            Storage::disk('public')->delete($data->file_ttd);
        }

        $data->delete();
        return response()->json(['success' => 'Data berhasil dihapus!']);
    }
}
