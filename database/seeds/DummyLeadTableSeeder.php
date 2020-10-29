<?php

use Illuminate\Database\Seeder;
use App\Lead;
use Carbon\Carbon;

class DummyLeadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Lead::create([
            'customer_name' => 'Sisca Cendana',
            'email' => 'cencen74@gmail.com',
            'no_telepon' => '085612095673',
            'date' => Carbon::create('2020','02','01'),
            'user_id' => 2,
            'vendor_id' => 1,
            'status' => 1
        ]);

        Lead::create([
            'customer_name' => 'Halim Santoso',
            'email' => 'halimsans@gmail.com',
            'no_telepon' => '087744123412',
            'date' => Carbon::create('2020','03','20'),
            'user_id' => 2,
            'vendor_id' => 1,
            'status' => 1
        ]);

        Lead::create([
            'customer_name' => 'Reyno Handoko',
            'email' => 'Reyhan22@gmail.com',
            'no_telepon' => '082109651122',
            'date' => Carbon::create('2020','04','17'),
            'user_id' => 2,
            'vendor_id' => 2,
            'status' => 1
        ]);

        Lead::create([
            'customer_name' => 'Hainun Rofifah',
            'email' => 'hainun.rofifah@gmail.com',
            'no_telepon' => '087756198621',
            'date' => Carbon::create('2020','05','10'),
            'user_id' => 3,
            'vendor_id' => 1,
            'status' => 1
        ]);

        Lead::create([
            'customer_name' => 'Dino Anggoro',
            'email' => 'anggoro.d@gmail.com',
            'no_telepon' => '085612098657',
            'date' => Carbon::create('2020','05','27'),
            'user_id' => 3,
            'vendor_id' => 2,
            'status' => 1
        ]);

        Lead::create([
            'customer_name' => 'Maimun Humairah',
            'email' => 'm.humairah@gmail.com',
            'no_telepon' => '085677091243',
            'date' => Carbon::create('2020','06','15'),
            'user_id' => 4,
            'vendor_id' => 1,
            'status' => 1
        ]);

        Lead::create([
            'customer_name' => 'Reno Sanjaya',
            'email' => 'reyno44@gmail.com',
            'no_telepon' => '081208768090',
            'date' => Carbon::create('2020','06','29'),
            'user_id' => 4,
            'vendor_id' => 1,
            'status' => 1
        ]);

        Lead::create([
            'customer_name' => 'Mahfud Junjungan',
            'email' => 'mahfud.j@gmail.com',
            'no_telepon' => '081244219080',
            'date' => Carbon::create('2020','07','15'),
            'user_id' => 5,
            'vendor_id' => 2,
            'status' => 1
        ]);
    }
}
