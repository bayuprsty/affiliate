<?php

use Illuminate\Database\Seeder;
use App\User;

class UserApiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'affiliateapi',
            'email' => 'affiliateapi@gmail.com',
            'password' => bcrypt('affiliatedvnt101112'),
            'role' => 'admin',
        ]);
    }
}
