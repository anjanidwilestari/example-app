<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TestimoniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat instance Faker untuk menghasilkan data palsu
        $faker = Faker::create();

        // Menambahkan beberapa testimoni
        for ($i = 0; $i < 10; $i++) {
            DB::table('testimonis')->insert([
                'name_customer' => $faker->name, // Nama konsumen
                'workplace' => $faker->company, // Asal tempat kerja
                'review' => $faker->paragraph, // Ulasan testimoni
                'photo' => $faker->imageUrl(100, 100, 'people', true), // URL gambar profile (dummy)
                'status' => $faker->boolean(80), // Status aktif (80% kemungkinan aktif)
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}