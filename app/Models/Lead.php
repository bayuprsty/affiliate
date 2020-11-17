<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Vendor;

class Lead extends Model
{
    const ON_PROCESS = 1;
    const SUCCESS = 2;
    const CANCELED = 3;

    protected $fillable = ['user_id', 'vendor_id', 'customer_name', 'email', 'no_telepon', 'date', 'status', 'ip_address'];
    
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }
}
