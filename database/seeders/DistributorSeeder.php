<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistributorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('distributors')->insert([
            ['name' => 'Multiplus Medilab, PT', 'province' => 'Aceh', 'island' => 'Sumatera', 'color' => '#005131', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Multiplus Medilab, PT', 'province' => 'Sumatera Utara', 'island' => 'Sumatera', 'color' => '#005131', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Multiplus Medilab, PT', 'province' => 'Sumatera Barat', 'island' => 'Sumatera', 'color' => '#F68621', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Emiindo Jaya Bersama, PT', 'province' => 'Riau', 'island' => 'Sumatera', 'color' => '#F68621', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Emiindo Jaya Bersama, PT', 'province' => 'Kepulauan Riau', 'island' => 'Sumatera', 'color' => '#F68621', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sinarindo Multi Medika, PT', 'province' => 'Jambi', 'island' => 'Sumatera', 'color' => '#7A2226', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Emiindo Jaya Bersama, PT', 'province' => 'Sumatera Selatan', 'island' => 'Sumatera', 'color' => '#F68621', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Emiindo Jaya Bersama, PT', 'province' => 'Bengkulu', 'island' => 'Sumatera', 'color' => '#F68621', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Emiindo Jaya Bersama, PT', 'province' => 'Bangka-Belitung', 'island' => 'Sumatera', 'color' => '#F68621', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Emiindo Jaya Bersama, PT', 'province' => 'Lampung', 'island' => 'Sumatera', 'color' => '#F68621', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Emiindo Jaya Bersama, PT', 'province' => 'Banten', 'island' => 'Jawa', 'color' => '#F68621', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Emiindo Jaya Bersama, PT', 'province' => 'Jawa Barat', 'island' => 'Jawa', 'color' => '#F68621', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pradana Sirona Persada, PT', 'province' => 'Jakarta Raya', 'island' => 'Jawa', 'color' => '#F05682', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Daya Prima Kartika Multisarana, PT', 'province' => 'Jawa Tengah', 'island' => 'Jawa', 'color' => '#8358A5', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Daya Prima Kartika Multisarana, PT', 'province' => 'Yogyakarta', 'island' => 'Jawa', 'color' => '#8358A5', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Alkesmart Indonesia, PT', 'province' => 'Jawa Timur', 'island' => 'Jawa', 'color' => '#593520', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Cahaya Murni Cemerlang, PT', 'province' => 'Bali', 'island' => 'Bali & Nusa Tenggara', 'color' => '#242850', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bintang Mandiri Medica, PT', 'province' => 'Nusa Tenggara Barat', 'island' => 'Bali & Nusa Tenggara', 'color' => '#ED1D24', 'created_at' => now(), 'updated_at' => now()],
            // Data lain hingga Papua
        ]);
    }
}
