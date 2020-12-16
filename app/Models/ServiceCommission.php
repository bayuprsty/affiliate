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
        'marketing_text',
        'img_upload',
        'commission_type_id',
        'commission_value',
        'max_commission'
    ];

    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }
}
