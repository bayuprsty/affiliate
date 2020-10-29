<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'name',
        'link',
        'link_embed',
        'marketing_text',
        'no_telepon',
        'email',
        'jalan',
        'provinsi',
        'kabupaten_kota',
        'kecamatan',
        'kodepos',
        'nomor_rekening'
    ];
}
