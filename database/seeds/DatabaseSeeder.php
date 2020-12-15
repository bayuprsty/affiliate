<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(CommissionTypeTableSeeder::class);
        $this->call(MediaSeeder::class);
        $this->call(WithdrawalStatusSeeder::class);
        $this->call(GenderTableSeeder::class);
        $this->call(MinimumPayoutSeeder::class);
    }
}
