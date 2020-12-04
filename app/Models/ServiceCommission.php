<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Vendor;

class ServiceCommission extends Model
{
    const FIXED = 1;
    const PERCENTASE = 2;
    
    protected $fillable = [
        'vendor_id',
        'title',
        'description',
        'service_link',
        'commission_type_id',
        'commission_value'
    ];

    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }
}
