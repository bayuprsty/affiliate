<?php

use Illuminate\Database\Seeder;
use App\Click;

class DummyClickSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Click::create([
            'user_id' => 2,
            'media_id' => 1,
            'vendor_id' => 1,
            'click' => 1
        ]);

        Click::create([
            'user_id' => 2,
            'media_id' => 2,
            'vendor_id' => 1,
            'click' => 2
        ]);

        Click::create([
            'user_id' => 2,
            'media_id' => 4,
            'vendor_id' => 1,
            'click' => 3
        ]);

        Click::create([
            'user_id' => 2,
            'media_id' => 5,
            'vendor_id' => 1,
            'click' => 2
        ]);

        Click::create([
            'user_id' => 2,
            'media_id' => 5,
            'vendor_id' => 2,
            'click' => 3
        ]);

        Click::create([
            'user_id' => 3,
            'media_id' => 2,
            'vendor_id' => 1,
            'click' => 4
        ]);

        Click::create([
            'user_id' => 3,
            'media_id' => 3,
            'vendor_id' => 2,
            'click' => 2
        ]);

        Click::create([
            'user_id' => 3,
            'media_id' => 5,
            'vendor_id' => 2,
            'click' => 1
        ]);

        Click::create([
            'user_id' => 4,
            'media_id' => 3,
            'vendor_id' => 1,
            'click' => 6
        ]);

        Click::create([
            'user_id' => 4,
            'media_id' => 5,
            'vendor_id' => 2,
            'click' => 3
        ]);

        Click::create([
            'user_id' => 5,
            'media_id' => 3,
            'vendor_id' => 1,
            'click' => 2
        ]);

        Click::create([
            'user_id' => 5,
            'media_id' => 5,
            'vendor_id' => 2,
            'click' => 3
        ]);
    }
}
