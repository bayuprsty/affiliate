<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Withdrawal;
use App\Lead;

class Notification extends Model
{
    const WITHDRAW = 1;
    const LEAD = 2;

    protected $fillable = [
        'user_id', 'notification_type', 'withdraw_id', 'lead_id', 'admin_read', 'user_read'
    ];

    public function withdraw() {
        return $this->belongsTo(Withdrawal::class);
    }

    public function lead() {
        return $this->belongsTo(Lead::class);
    }
}
