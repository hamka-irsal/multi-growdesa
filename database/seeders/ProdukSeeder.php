<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Produk::create([
            'nama_produk' => 'Madu Hutan Alami Suku Baduy',
            'deskripsi'   => 'Madu Hutan Alami Suku Baduy dipanen secara tradisional dari masyarakat adat dari lebah Apis dorsata yang mengumpulkan di dataran pohon-pohon tinggi di pedalaman hutan lindung.',
            'harga'       => 85000,
            'stok'        => 20,
            'foto'        => null,
            'kategori'    => 'Madu Alami',
            'asal_desa'   => 'Desa Galesong',
            'kontak'      => '08123456789',
        ]);

        Produk::create([
            'nama_produk' => 'Tas Anyaman Bambu',
            'deskripsi'   => 'Tas anyaman bambu handmade khas desa, cocok untuk keperluan belanja sehari-hari maupun sebagai oleh-oleh.',
            'harga'       => 120000,
            'stok'        => 15,
            'foto'        => null,
            'kategori'    => 'Kerajinan',
            'asal_desa'   => 'Desa Galesong',
            'kontak'      => '08198765432',
        ]);

        Produk::create([
            'nama_produk' => 'Paket Sayur Organik',
            'deskripsi'   => 'Paket sayur organik segar langsung dari kebun petani desa. Berisi kangkung, bayam, dan tomat.',
            'harga'       => 45000,
            'stok'        => 50,
            'foto'        => null,
            'kategori'    => 'Sayuran Organik',
            'asal_desa'   => 'Desa Galesong Timur',
            'kontak'      => '08112345678',
        ]);

        Produk::create([
            'nama_produk' => 'Kopi Robusta Pilihan',
            'deskripsi'   => 'Kopi robusta pilihan yang ditanam di dataran tinggi desa. Rasa kuat dan aroma khas.',
            'harga'       => 60000,
            'stok'        => 30,
            'foto'        => null,
            'kategori'    => 'Madu Alami',
            'asal_desa'   => 'Desa Galesong',
            'kontak'      => '08156789012',
        ]);

        Produk::create([
            'nama_produk' => 'Gula Semut Aren',
            'deskripsi'   => 'Gula semut aren asli buatan tangan dari nira pohon aren. Cocok untuk campuran kopi dan masakan.',
            'harga'       => 35000,
            'stok'        => 40,
            'foto'        => null,
            'kategori'    => 'Sayuran Organik',
            'asal_desa'   => 'Desa Galesong Timur',
            'kontak'      => '08167890123',
        ]);

        Produk::create([
            'nama_produk' => 'Keripik Pisang Coklat',
            'deskripsi'   => 'Keripik pisang renyah dengan lapisan coklat premium. Cemilan favorit keluarga.',
            'harga'       => 15000,
            'stok'        => 100,
            'foto'        => null,
            'kategori'    => 'Kerajinan',
            'asal_desa'   => 'Desa Galesong',
            'kontak'      => '08178901234',
        ]);
    }
}
