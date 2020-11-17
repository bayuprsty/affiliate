<?php

use Illuminate\Database\Seeder;

use App\Models\Payout;

class MinimumPayoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Payout::create([
            'minimum_payout' => 100000
        ]);
    }
}
