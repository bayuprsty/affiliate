<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Lead;
use App\ServiceCommission;

class Transaction extends Model
{
    protected $fillable = ['lead_id', 'service_commission_id', 'transaction_date', 'amount', 'commission'];

    public function lead() {
        return $this->belongsTo(Lead::class);
    }

    public function service_commission() {
        return $this->belongsTo(ServiceCommission::class);
    }
}
