<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Vendor;

class Lead extends Model
{
    const ON_PROCESS = 1;
    const SUCCESS = 2;
    const CANCELED = 3;
    
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }
}
