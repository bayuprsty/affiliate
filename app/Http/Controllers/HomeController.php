<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gate;
use App\Models\Click;

use App\Models\Lead;
use App\Models\Transaction;
use App\Models\Vendor;
use App\Models\User;
use App\Models\Withdrawal;
use App\Models\WithdrawalPayout;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $vendor = Vendor::all()->count();

        $affiliate = User::where('role', 'affiliator')->count();

        $commission = Transaction::all()->sum('commission');
        $lead = Lead::all()->count();
        $click = Click::all()->sum('click');
        $conversion = $click > 0 ? round($lead / $click * 100, 2) : 0;

        $withdrawal['count_request'] = Withdrawal::all()->count();
        $withdrawal['request_amount'] = Withdrawal::all()->sum('total');

        $withdrawal['count_paid'] = Withdrawal::where('withdrawal_status_id', 2)->count();
        $withdrawal['paid_amount'] = Withdrawal::where('withdrawal_status_id', 2)->sum('total');
        
        $withdrawal['count_unpaid'] = Withdrawal::where('withdrawal_status_id', 1)->count();
        $withdrawal['unpaid_amount'] = Withdrawal::where('withdrawal_status_id', 1)->sum('total');
        
        return view('admin.dashboard', compact('vendor', 'affiliate', 'withdrawal', 'lead', 'commission', 'click', 'conversion'));
    }
}
