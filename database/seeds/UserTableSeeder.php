<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\User;

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
            'email' => 'adminpico@gmail.com',
            'password' => bcrypt('ciayopico777'),
            'role' => 'admin',
            'nomor_rekening' => '1244241241',
            'join_date' => Carbon::NOW()
        ]);

        User::create([
            'username' => 'userpico',
            'nama_depan' => 'Affiliator 1',
            'email' => 'userpico@gmail.com',
            'password' => bcrypt('userpico777'),
            'role' => 'affiliator',
            'nomor_rekening' => '1522312523',
            'join_date' => Carbon::NOW()
        ]);

        User::create([
            'username' => 'userpico2',
            'nama_depan' => 'Affiliator 2',
            'email' => 'userpico2@gmail.com',
            'password' => bcrypt('userpico777'),
            'role' => 'affiliator',
            'nomor_rekening' => '141009123876',
            'join_date' => Carbon::NOW()
        ]);

        User::create([
            'username' => 'userpico3',
            'nama_depan' => 'Affiliator 3',
            'email' => 'userpico3@gmail.com',
            'password' => bcrypt('userpico777'),
            'role' => 'affiliator',
            'nomor_rekening' => '141009123877',
            'join_date' => Carbon::NOW()
        ]);

        User::create([
            'username' => 'userpico4',
            'nama_depan' => 'Affiliator 4',
            'email' => 'userpico4@gmail.com',
            'password' => bcrypt('userpico777'),
            'role' => 'affiliator',
            'nomor_rekening' => '141009123879',
            'join_date' => Carbon::NOW()
        ]);
    }
}
