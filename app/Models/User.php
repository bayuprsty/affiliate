<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\Gender;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'username',
        'password',
        'nama_depan',
        'nama_belakang',
        'no_telepon',
        'email',
        'email_confirmed',
        'email_verified_at',
        'gender_id',
        'jalan',
        'provinsi',
        'kabupaten_kota',
        'kecamatan',
        'kodepos',
        'ktp',
        'nama_bank',
        'atasnama_bank',
        'nomor_rekening',
        'avatar',
        'saldo_awal',
        'join_date',
        'code_verify',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function gender() {
        return $this->belongsTo(Gender::class);
    }

    public static function checkUserRelation($user_id) {
        $click = Click::where('user_id', $user_id)->get()->count();
        $lead = Lead::where('user_id', $user_id)->get()->count();
        $withdrawal = Withdrawal::where('user_id', $user_id)->get()->count();
        $notification = Notification::where('user_id', $user_id)->get()->count();

        if ($click > 0 || $lead > 0 || $withdrawal > 0 || $notification > 0) {
            return true;
        }

        return false;
    }
}
