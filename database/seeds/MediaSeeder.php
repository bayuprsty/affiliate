<?php

use Illuminate\Database\Seeder;
use App\Media;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Media::create([
            'name' => 'Website',
        ]);

        Media::create([
            'name' => 'Facebook',
        ]);

        Media::create([
            'name' => 'Email',
        ]);

        Media::create([
            'name' => 'Telegram',
        ]);

        Media::create([
            'name' => 'Whatsapp',
        ]);

        Media::create([
            'name' => 'LinkedIn',
        ]);

        Media::create([
            'name' => 'Twitter',
        ]);
    }
}
