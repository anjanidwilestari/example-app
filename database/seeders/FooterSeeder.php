<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Footer;
use App\Models\SubFooter;
use App\Models\IsiSubFooter;

class FooterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create Footer
        $footer = Footer::create([
            'name' => 'Footer Utama',
        ]);

        // Create Sub-footer
        $subFooter1 = SubFooter::create([
            'footer_id' => $footer->id,
            'name' => 'Layanan Pelanggan',
        ]);
        $subFooter2 = SubFooter::create([
            'footer_id' => $footer->id,
            'name' => 'Sosial Media',
        ]);

        // Create Isi Sub-footer
        IsiSubFooter::create([
            'sub_footer_id' => $subFooter1->id,
            'name' => 'Call Center',
            'link' => 'https://callcenter.com',
        ]);
        IsiSubFooter::create([
            'sub_footer_id' => $subFooter2->id,
            'name' => 'Facebook',
            'link' => 'https://facebook.com',
        ]);
    }
}
