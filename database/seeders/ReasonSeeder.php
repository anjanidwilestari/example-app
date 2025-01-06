<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('reasons')->insert([
            [
                'title' => 'Garansi 2 Tahun',
                'description' => 'Setiap produk kami akan kami garansi 2 tahun, tanpa terkecuali. Ditambah dengan ketersediaan sparepart selama 5 tahun.',
                'icon' => 'icons/garansi.png', // Path to the icon file
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Aftersales',
                'description' => 'Butuh bantuan pengoperasian dan proses klaim garansi? Kami akan tersedia 7x24 jam.',
                'icon' => 'icons/aftersales.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Legalitas',
                'description' => 'Kami menjamin legalitas dari semua produk kami.',
                'icon' => 'icons/legalitas.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => '>10 Tahun R&D',
                'description' => 'Dengan pengalaman R&D di atas 10 tahun, kami akan selalu berkomitmen menjual produk yang durable dan reliable.',
                'icon' => 'icons/rnd.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Engineering',
                'description' => 'Kami menyediakan tenaga teknisi yang berpengalaman di bidangnya.',
                'icon' => 'icons/engineering.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Lab Kalibrasi',
                'description' => 'Semua alat yang sampai ke pengguna, sudah melalui uji lab kalibrasi. Jangan khawatir tentang ke-laik an produk kami.',
                'icon' => 'icons/lab_kalibrasi.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
