<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Lead;
use App\Models\ServiceCommission;

class Transaction extends Model
{
    protected $fillable = ['lead_id', 'service_commission_id', 'transaction_date', 'amount', 'commission', 'cancel', 'cancel_date', 'cancel_reason', 'created_by_system'];

    public function lead() {
        return $this->belongsTo(Lead::class);
    }

    public function service_commission() {
        return $this->belongsTo(ServiceCommission::class);
    }

    public static function getCommissionValue($service_id, $amount) {
        $service = ServiceCommission::findOrfail($service_id);

        if ($service->commission_type_id === 1) {
            $commission = $service->commission_value;
        } else {
            $commission = ($amount * $service->commission_value) / 100;
        }

        return $commission;
    }
}
