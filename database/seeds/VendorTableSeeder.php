<?php

use Illuminate\Database\Seeder;
use App\Vendor;

class VendorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vendor::create([
            'name' => 'Higi',
            'link' => 'https://higilab.com',
            'link_embed' => 'https://higilab.com',
            'marketing_text' => 'https://higilab.com',
            'no_telepon' => '+6231 599 5042',
            'email' => 'info@higilab.com',
            'jalan' => 'Galaxi Klampis Asri Selatan VIII Blok L4-12',
            'provinsi' => 'Jawa Timur',
            'kabupaten_kota' => 'Surabaya',
            'kecamatan' => 'Sukolilo',
            'kodepos' => '60119',
            'nomor_rekening' => '141093875623'
        ]);

        Vendor::create([
            'name' => 'Picodio',
            'link' => 'https://picodio.com/id/',
            'link_embed' => 'https://picodio.com/id/',
            'marketing_text' => 'https://picodio.com/id/',
            'no_telepon' => '+62 21 806 04289',
            'email' => 'info@picodio.com',
            'jalan' => 'Galaxi Klampis Asri Selatan VIII Blok L4-12',
            'provinsi' => 'Jawa Timur',
            'kabupaten_kota' => 'Surabaya',
            'kecamatan' => 'Sukolilo',
            'kodepos' => '60119',
            'nomor_rekening' => '141092187651'
        ]);
    }
}
