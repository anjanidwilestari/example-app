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
        // Aceh (Nanggroe Aceh Darussalam Province) - 3 Entries
        ['name' => 'PT Aceh Sejahtera', 'province' => 'Aceh', 'island' => 'Sumatera', 'color' => '#FF5733', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'PT Multikarya Aceh', 'province' => 'Aceh', 'island' => 'Sumatera', 'color' => '#FF5733', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'PT Nusantara Aceh', 'province' => 'Aceh', 'island' => 'Sumatera', 'color' => '#FF5733', 'created_at' => now(), 'updated_at' => now()],

        // Sumatera Utara - 4 Entries
        ['name' => 'PT Sumatera Utama', 'province' => 'Sumatera Utara', 'island' => 'Sumatera', 'color' => '#33FF8C', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'PT Medica Utara', 'province' => 'Sumatera Utara', 'island' => 'Sumatera', 'color' => '#33FF8C', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'PT Mandiri Medika', 'province' => 'Sumatera Utara', 'island' => 'Sumatera', 'color' => '#33FF8C', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'PT Sejahtera Sumut', 'province' => 'Sumatera Utara', 'island' => 'Sumatera', 'color' => '#33FF8C', 'created_at' => now(), 'updated_at' => now()],

        // Sumatera Barat - 2 Entries
        ['name' => 'PT Minang Sejahtera', 'province' => 'Sumatera Barat', 'island' => 'Sumatera', 'color' => '#FF8C80', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'PT Medika Minang', 'province' => 'Sumatera Barat', 'island' => 'Sumatera', 'color' => '#FF8C80', 'created_at' => now(), 'updated_at' => now()],

        // Riau - 1 Entry
        ['name' => 'PT Riau Sejahtera', 'province' => 'Riau', 'island' => 'Sumatera', 'color' => '#33C1FF', 'created_at' => now(), 'updated_at' => now()],

        // Kepulauan Riau - 5 Entries
        ['name' => 'PT Kepri Sejahtera', 'province' => 'Kepulauan Riau', 'island' => 'Sumatera', 'color' => '#80FF33', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'PT Medika Kepri', 'province' => 'Kepulauan Riau', 'island' => 'Sumatera', 'color' => '#80FF33', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'PT Kepri Mandiri', 'province' => 'Kepulauan Riau', 'island' => 'Sumatera', 'color' => '#80FF33', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'PT Riau Medika', 'province' => 'Kepulauan Riau', 'island' => 'Sumatera', 'color' => '#80FF33', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'PT Mandiri Kepri', 'province' => 'Kepulauan Riau', 'island' => 'Sumatera', 'color' => '#80FF33', 'created_at' => now(), 'updated_at' => now()],

        // Jambi - 3 Entries
        ['name' => 'PT Jambi Sejahtera', 'province' => 'Jambi', 'island' => 'Sumatera', 'color' => '#338CFF', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'PT Medika Jambi', 'province' => 'Jambi', 'island' => 'Sumatera', 'color' => '#338CFF', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'PT Jambi Mandiri', 'province' => 'Jambi', 'island' => 'Sumatera', 'color' => '#338CFF', 'created_at' => now(), 'updated_at' => now()],

        // Lampung - 2 Entries
        ['name' => 'PT Lampung Sejahtera', 'province' => 'Lampung', 'island' => 'Sumatera', 'color' => '#33FFC1', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'PT Medika Lampung', 'province' => 'Lampung', 'island' => 'Sumatera', 'color' => '#33FFC1', 'created_at' => now(), 'updated_at' => now()],

        // Jawa Barat - 4 Entries
        ['name' => 'PT Barat Sejahtera', 'province' => 'Jawa Barat', 'island' => 'Jawa', 'color' => '#3357FF', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'PT Medika Barat', 'province' => 'Jawa Barat', 'island' => 'Jawa', 'color' => '#3357FF', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'PT Barat Mandiri', 'province' => 'Jawa Barat', 'island' => 'Jawa', 'color' => '#3357FF', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'PT Sejahtera Barat', 'province' => 'Jawa Barat', 'island' => 'Jawa', 'color' => '#3357FF', 'created_at' => now(), 'updated_at' => now()],

        // DKI Jakarta - 1 Entry
        ['name' => 'PT Jakarta Sejahtera', 'province' => 'DKI Jakarta', 'island' => 'Jawa', 'color' => '#8C33FF', 'created_at' => now(), 'updated_at' => now()],

        // Jawa Tengah - 3 Entries
        ['name' => 'PT Tengah Sejahtera', 'province' => 'Jawa Tengah', 'island' => 'Jawa', 'color' => '#FF33A1', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'PT Medika Tengah', 'province' => 'Jawa Tengah', 'island' => 'Jawa', 'color' => '#FF33A1', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'PT Tengah Mandiri', 'province' => 'Jawa Tengah', 'island' => 'Jawa', 'color' => '#FF33A1', 'created_at' => now(), 'updated_at' => now()],

        // Bali - 2 Entries
        ['name' => 'PT Bali Sejahtera', 'province' => 'Bali', 'island' => 'Bali & Nusa Tenggara', 'color' => '#3380FF', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'PT Medika Bali', 'province' => 'Bali', 'island' => 'Bali & Nusa Tenggara', 'color' => '#3380FF', 'created_at' => now(), 'updated_at' => now()],

        // Nusa Tenggara Barat - 1 Entry
        ['name' => 'PT Nusa Tenggara Sejahtera', 'province' => 'Nusa Tenggara Barat', 'island' => 'Bali & Nusa Tenggara', 'color' => '#C1FF8C', 'created_at' => now(), 'updated_at' => now()],
    ]);
}


}
