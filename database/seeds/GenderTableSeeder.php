<?php

use Illuminate\Database\Seeder;
use App\Models\Gender;

class GenderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gender::create([
            'name' => 'Laki-Laki',
        ]);

        Gender::create([
            'name' => 'Perempuan',
        ]);
    }
}
