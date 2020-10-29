<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WithdrawalPayout extends Model
{
    protected $fillable = ['withdrawal_id', 'payout'];
}
