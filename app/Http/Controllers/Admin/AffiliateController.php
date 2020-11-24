<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Transaction;
use App\Models\Click;
use App\Models\Lead;
use App\Models\User;
use App\Models\Withdrawal;
use App\Models\WithdrawalStatus;

class AffiliateController extends Controller
{
    public function index() {
        return view('admin.affiliate.index');
    }

    public function vendor() {
        return view('admin.affiliate.vendor');
    }

    public function detail(Request $request) {
        if ($request->ajax()) {
            $transaction = Transaction::leftJoin('leads', 'leads.id', '=', 'transactions.lead_id')->where('leads.user_id', $request->user_id)->get();
            
            $user = User::findOrfail($request->user_id);
            
            $lead = Lead::where('user_id', $request->user_id);

            $click = Click::where(['user_id' => $request->user_id])->get();
            
            $withdrawal = Withdrawal::where(['user_id' => $request->user_id, 'withdrawal_status_id' => WithdrawalStatus::APPROVE])->get();
            
            $data = [
                'user_id' => $request->user_id,
                'username_aff' => $user->username,
                'no_telepon' => $user->no_telepon,
                'email' => $user->email,
                'balance' => $this->currencyView($user->saldo_awal + $transaction->sum('commission') - $withdrawal->sum('total')),
                'commission' => $this->currencyView($transaction->sum('commission')),
                'transaction_count' => $transaction->count(),
                'click' => count($click) > 0 ? $click->sum('click') : 0,
                'signup' => $lead->count(),
                'conversion' => count($click) > 0 ? round($lead->count() / $click->sum('click') * 100, 2) : 0 .'%'
            ];

            return response()->json(['detail' => $data]);
        }
    }

    public function detailVendor(Request $request) {
        if ($request->ajax()) {
            $transaction = Transaction::leftJoin('leads', 'leads.id', '=', 'transactions.lead_id')->where(['leads.user_id' => $request->user_id, 'leads.vendor_id' => $request->vendor_id])->get();
            
            $user = User::findOrfail($request->user_id);
            
            $lead = Lead::where(['user_id' => $request->user_id, 'vendor_id' => $request->vendor_id]);

            $click = Click::where(['user_id' => $request->user_id, 'vendor_id' => $request->vendor_id])->get();
            
            $withdrawal = Withdrawal::where(['user_id' => $request->user_id, 'withdrawal_status_id' => WithdrawalStatus::APPROVE])->get();
            
            $data = [
                'user_id' => $request->user_id,
                'username_aff' => $user->username,
                'no_telepon' => $user->no_telepon,
                'email' => $user->email,
                'balance' => !empty($transaction) ? $user->saldo_awal + $this->currencyView($transaction->sum('commission') - $withdrawal->sum('total')) : $user->saldo_awal,
                'commission' => $this->currencyView($transaction->sum('commission')),
                'transaction_count' => $transaction->count(),
                'click' => count($click) > 0 ? $click->sum('click') : 0,
                'signup' => $lead->count(),
                'conversion' => count($click) > 0 ? round($lead->count() / $click->sum('click') * 100, 2) : 0 .'%'
            ];

            return response()->json(['detail' => $data]);
        }
    }
}
