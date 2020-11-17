<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Withdrawal extends Model
{
    protected $fillable = ['date', 'user_id', 'total', 'withdrawal_status_id', 'date_approve'];

    public function user () {
        return $this->belongsTo(User::class);
    }
}
