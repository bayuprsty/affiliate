<?php

use Illuminate\Database\Seeder;
use App\Models\CommissionType;

class CommissionTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CommissionType::create([
            'name' => 'Fixed',
        ]);

        CommissionType::create([
            'name' => 'Presentase',
        ]);
    }
}
