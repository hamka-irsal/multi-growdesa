<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use App\Models\Dusun;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatistikController extends Controller
{
    public function index()
    {
        // ==================================================
        // DATA KEPENDUDUKAN
        // ==================================================

        $jumlah_laki = Penduduk::where(
            'jenis_kelamin',
            'Laki-laki'
        )->count();

        $jumlah_perempuan = Penduduk::where(
            'jenis_kelamin',
            'Perempuan'
        )->count();

        $jumlah_kepala_keluarga = Penduduk::where(
            'status_hubungan_dalam_keluarga',
            'Kepala Keluarga'
        )->count();

        $jumlah_penduduk = $jumlah_laki + $jumlah_perempuan;


        // ==================================================
        // DATA WILAYAH
        // ==================================================

        $jumlah_dusun = Dusun::count();


        // ==================================================
        // DATA PEKERJAAN
        // ==================================================

        $pekerjaan = DB::table('penduduk')
            ->select(
                'jenis_pekerjaan',
                DB::raw('COUNT(*) as total')
            )
            ->whereNotNull('jenis_pekerjaan')
            ->where('jenis_pekerjaan', '!=', '')
            ->groupBy('jenis_pekerjaan')
            ->orderByDesc('total')
            ->get();

        $pekerjaan_teratas = $pekerjaan->first();


        // ==================================================
        // DATA PENDIDIKAN
        // ==================================================

        $pendidikan = DB::table('penduduk')
            ->select(
                'pendidikan',
                DB::raw('COUNT(*) as total')
            )
            ->whereNotNull('pendidikan')
            ->where('pendidikan', '!=', '')
            ->groupBy('pendidikan')
            ->orderByDesc('total')
            ->get();

        $pendidikan_teratas = $pendidikan->first();


        // ==================================================
        // DATA AGAMA
        // ==================================================

        $agama = DB::table('penduduk')
            ->select(
                'agama',
                DB::raw('COUNT(*) as total')
            )
            ->whereNotNull('agama')
            ->where('agama', '!=', '')
            ->groupBy('agama')
            ->orderByDesc('total')
            ->get();

        $agama_teratas = $agama->first();

        $agama_total = $agama->sum('total');

        $agama_teratas_persen = ($agama_total > 0 && $agama_teratas)
            ? round(($agama_teratas->total / $agama_total) * 100, 1)
            : 0;


        // ==================================================
        // DATA STATUS PERKAWINAN
        // ==================================================

        $perkawinan = DB::table('penduduk')
            ->select(
                'status_perkawinan',
                DB::raw('COUNT(*) as total')
            )
            ->whereNotNull('status_perkawinan')
            ->where('status_perkawinan', '!=', '')
            ->groupBy('status_perkawinan')
            ->orderByDesc('total')
            ->get();

        $perkawinan_teratas = $perkawinan->first();


        // ==================================================
        // DATA KELOMPOK USIA
        // ==================================================

        $pendudukDenganTanggalLahir = Penduduk::whereNotNull('tanggal_lahir')
            ->whereNotNull('jenis_kelamin')
            ->get([
                'tanggal_lahir',
                'jenis_kelamin'
            ]);


        // ==================================================
        // INISIALISASI KELOMPOK USIA
        // ==================================================

        $kelompokUsia = [

            'Balita (0-4 Tahun)' => [
                'Laki-laki' => 0,
                'Perempuan' => 0,
            ],

            'Kanak-Kanak (5-11 Tahun)' => [
                'Laki-laki' => 0,
                'Perempuan' => 0,
            ],

            'Remaja Awal (12-16 Tahun)' => [
                'Laki-laki' => 0,
                'Perempuan' => 0,
            ],

            'Remaja Akhir (17-25 Tahun)' => [
                'Laki-laki' => 0,
                'Perempuan' => 0,
            ],

            'Dewasa Awal (26-35 Tahun)' => [
                'Laki-laki' => 0,
                'Perempuan' => 0,
            ],

            'Dewasa Akhir (36-45 Tahun)' => [
                'Laki-laki' => 0,
                'Perempuan' => 0,
            ],

            'Lansia Awal (46-55 Tahun)' => [
                'Laki-laki' => 0,
                'Perempuan' => 0,
            ],

            'Lansia Akhir (56-65 Tahun)' => [
                'Laki-laki' => 0,
                'Perempuan' => 0,
            ],

            'Manula (> 65 Tahun)' => [
                'Laki-laki' => 0,
                'Perempuan' => 0,
            ],

        ];


        // ==================================================
        // HITUNG KELOMPOK USIA
        // ==================================================

        foreach ($pendudukDenganTanggalLahir as $penduduk) {

            $umur = Carbon::parse(
                $penduduk->tanggal_lahir
            )->age;

            $kelompok = null;


            // 0 - 4
            if ($umur >= 0 && $umur <= 4) {

                $kelompok = 'Balita (0-4 Tahun)';

            // 5 - 11
            } elseif ($umur >= 5 && $umur <= 11) {

                $kelompok = 'Kanak-Kanak (5-11 Tahun)';

            // 12 - 16
            } elseif ($umur >= 12 && $umur <= 16) {

                $kelompok = 'Remaja Awal (12-16 Tahun)';

            // 17 - 25
            } elseif ($umur >= 17 && $umur <= 25) {

                $kelompok = 'Remaja Akhir (17-25 Tahun)';

            // 26 - 35
            } elseif ($umur >= 26 && $umur <= 35) {

                $kelompok = 'Dewasa Awal (26-35 Tahun)';

            // 36 - 45
            } elseif ($umur >= 36 && $umur <= 45) {

                $kelompok = 'Dewasa Akhir (36-45 Tahun)';

            // 46 - 55
            } elseif ($umur >= 46 && $umur <= 55) {

                $kelompok = 'Lansia Awal (46-55 Tahun)';

            // 56 - 65
            } elseif ($umur >= 56 && $umur <= 65) {

                $kelompok = 'Lansia Akhir (56-65 Tahun)';

            // > 65
            } elseif ($umur > 65) {

                $kelompok = 'Manula (> 65 Tahun)';
            }


            // ==================================================
            // MASUKKAN BERDASARKAN JENIS KELAMIN
            // ==================================================

            if (
                $kelompok !== null &&
                isset(
                    $kelompokUsia[$kelompok][$penduduk->jenis_kelamin]
                )
            ) {

                $kelompokUsia[$kelompok][$penduduk->jenis_kelamin]++;
            }
        }


        // ==================================================
        // HITUNG TOTAL SETIAP KELOMPOK USIA
        // ==================================================

        $totalPerKelompokUsia = [];

        foreach ($kelompokUsia as $kelompok => $gender) {

            $totalPerKelompokUsia[$kelompok] =
                $gender['Laki-laki'] +
                $gender['Perempuan'];
        }


        // ==================================================
        // KELOMPOK USIA TERBANYAK
        // ==================================================

        if (!empty($totalPerKelompokUsia)) {

            $kelompok_usia_teratas = max(
                $totalPerKelompokUsia
            );

            $nama_kelompok_usia_teratas = array_search(
                $kelompok_usia_teratas,
                $totalPerKelompokUsia
            );

        } else {

            $kelompok_usia_teratas = 0;
            $nama_kelompok_usia_teratas = '-';
        }


        // ==================================================
        // KIRIM DATA KE VIEW
        // ==================================================

        return view(
            'landing.statistik.index',
            compact(

                // Kependudukan
                'jumlah_laki',
                'jumlah_perempuan',
                'jumlah_penduduk',
                'jumlah_kepala_keluarga',

                // Wilayah
                'jumlah_dusun',

                // Pekerjaan
                'pekerjaan',
                'pekerjaan_teratas',

                // Pendidikan
                'pendidikan',
                'pendidikan_teratas',

                // Agama
                'agama',
                'agama_teratas',
                'agama_teratas_persen',

                // Perkawinan
                'perkawinan',
                'perkawinan_teratas',

                // Kelompok Usia
                'kelompokUsia',
                'kelompok_usia_teratas',
                'nama_kelompok_usia_teratas',
            )
        );
    }
}
