<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class FooterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Seed footers
        $footers = [
            [
                'name' => 'Company',
                'created_at' => now(),
                'updated_at' => now(),
                'subfooters' => [
                    ['name' => 'About Us', 'link' => '/about', 'created_at' => now(), 'updated_at' => now()],
                    ['name' => 'Careers', 'link' => '/careers', 'created_at' => now(), 'updated_at' => now()],
                ],
            ],
            [
                'name' => 'Support',
                'created_at' => now(),
                'updated_at' => now(),
                'subfooters' => [
                    ['name' => 'Contact Us', 'link' => '/contact', 'created_at' => now(), 'updated_at' => now()],
                    ['name' => 'FAQs', 'link' => '/faqs', 'created_at' => now(), 'updated_at' => now()],
                ],
            ],
            [
                'name' => 'Legal',
                'created_at' => now(),
                'updated_at' => now(),
                'subfooters' => [
                    ['name' => 'Privacy Policy', 'link' => '/privacy', 'created_at' => now(), 'updated_at' => now()],
                    ['name' => 'Terms of Service', 'link' => '/terms', 'created_at' => now(), 'updated_at' => now()],
                ],
            ],
        ];

        // Insert footers and related subfooters
        foreach ($footers as $footer) {
            $footerId = DB::table('footers')->insertGetId([
                'name' => $footer['name'],
                'created_at' => $footer['created_at'],
                'updated_at' => $footer['updated_at'],
            ]);

            foreach ($footer['subfooters'] as $subfooter) {
                DB::table('sub_footers')->insert([
                    'footer_id' => $footerId,
                    'name' => $subfooter['name'],
                    'link' => $subfooter['link'],
                    'created_at' => $subfooter['created_at'],
                    'updated_at' => $subfooter['updated_at'],
                ]);
            }
        }
    }
}
