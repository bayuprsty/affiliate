<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'adminpico',
            'nama_depan' => 'Administrator',
            'nama_belakang' => 'System',
            'email' => 'affiliate.system.dvnt@gmail.com',
            'password' => bcrypt('ciayopico777'),
            'role' => 'admin',
            'join_date' => Carbon::NOW(),
            'email_confirmed' => true,
            'email_verified_at' => Carbon::NOW(),
        ]);

        User::create([
            'username' => 'affiliateapi',
            'nama_depan' => 'Admin API',
            'nama_belakang' => 'System',
            'email' => 'affiliate.api@gmail.com',
            'password' => bcrypt('affiliatedvnt101112'),
            'role' => 'admin',
            'join_date' => Carbon::NOW(),
            'email_confirmed' => true,
            'email_verified_at' => Carbon::NOW(),
        ]);
    }
}
