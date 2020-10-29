<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Withdrawal extends Model
{
    protected $fillable = ['date', 'user_id', 'total', 'withdrawal_status_id'];

    public function user () {
        return $this->belongsTo(User::class);
    }
}
