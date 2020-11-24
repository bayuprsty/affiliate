<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Mail;
use PDF;

use App\Models\Lead;
use App\Models\Payout;
use App\Models\ServiceCommission;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use App\Models\WithdrawalStatus;
use App\Models\Click;
use App\Models\Notification;

class AffiliateController extends Controller
{
    public function dashboard () {
        $user = Auth::user();
        $userId = $user->id;
        $minimumPayout = Payout::all();
        $commission = Transaction::leftJoin('leads', 'leads.id', '=', 'transactions.lead_id')->where('leads.user_id', $userId)->sum('transactions.commission');
        $withdrawalApproved = Withdrawal::where('user_id', $userId)
                                ->where('withdrawal_status_id', WithdrawalStatus::APPROVE)
                                ->leftJoin('withdrawal_payouts', 'withdrawal_payouts.withdrawal_id', '=', 'withdrawals.id')
                                ->sum('withdrawal_payouts.payout');

        $balance = $user->saldo_awal + $commission - $withdrawalApproved;
        
        $lead = Lead::where('user_id', $userId)->whereNotNull('email')->count();
        $click = Click::where('user_id', $userId)->sum('click');
        $conversion = $click > 0 ? round($lead / $click * 100, 2) : 0;
        $transaction = Transaction::leftJoin('leads', 'leads.id', '=', 'transactions.lead_id')->where('leads.user_id', $userId)->count();

        return view('affiliate.dashboard', compact('userId', 'minimumPayout', 'withdrawalApproved', 'balance', 'click', 'lead', 'conversion', 'transaction'));
    }

    public function vendorList () {
        $serviceCommission = ServiceCommission::all();
        $userId = Auth::id();

        return view('affiliate.vendor.list', compact('serviceCommission', 'userId'));
    }

    public function transactionList() {
        return view('affiliate.transaction.index');
    }

    public function leadList() {
        return view('affiliate.lead.index');
    }

    public function wallet () {
        $user = Auth::user();
        $userId = $user->id;
        $minimumPayout = Payout::all();
        $commission = Transaction::leftJoin('leads', 'leads.id', '=', 'transactions.lead_id')->where('leads.user_id', $userId)->sum('transactions.commission');

        $withdrawalRequest = Withdrawal::where('user_id', $userId)->get();
        $withdrawalApproved = Withdrawal::where('user_id', $userId)
                                ->where('withdrawal_status_id', WithdrawalStatus::APPROVE)
                                ->leftJoin('withdrawal_payouts', 'withdrawal_payouts.withdrawal_id', '=', 'withdrawals.id')
                                ->sum('withdrawal_payouts.payout');

        $balance = $user->saldo_awal + $commission - $withdrawalApproved;

        Notification::where(['user_read' => 0, 'admin_read' => 1])->whereNotNull('withdraw_id')->update(['user_read' => 1]);

        return view('affiliate.wallet.index', compact('userId', 'minimumPayout', 'withdrawalRequest', 'withdrawalApproved', 'balance'));
    }

    public function withdraw (Request $request) {
        if ($request->ajax()) {
            $this->validate($request, [
                'amount' => 'required|integer'
            ]);

            if ($request->amount > $request->balance) {
                return $this->sendResponse('Withdraw amount too large from Balance', NULL, 222);
            } elseif ($request->amount < $request->minimum) {
                return $this->sendResponse('Minimum Withdraw amount '.$this->currencyView($request->minimum), NULL, 223);
            } else {
                $data = [
                    'date' => Carbon::NOW(),
                    'user_id' => Auth::id(),
                    'total' => $request->amount,
                    'withdrawal_status_id' => WithdrawalStatus::REQUEST
                ];

                $withdrawal = Withdrawal::create($data);
                
                if ($withdrawal) {
                    $notificationData = [
                        'user_id' => Auth::id(),
                        'notification_type' => Notification::WITHDRAW,
                        'withdraw_id' => $withdrawal->id,
                    ];

                    Notification::create($notificationData);

                    return $this->sendResponse('Withdrawal Request Created Succesfully');
                }
            }
    
            
        }

        return redirect(route('affiliate.wallet'))->with(['success' => 'Withdraw Request Berhasil']);
    }

    public function detailWithdraw (Request $request) {
        if ($request->ajax()) {
            $withdrawal = Withdrawal::findOrfail($request->id);

            if ($withdrawal->withdrawal_status_id == WithdrawalStatus::REQUEST) {
                $label = '<span class="badge badge-primary text-uppercase font-weight-bold text-xl">Requested</span>';
            } else {
                $label = '<span class="badge badge-success text-uppercase font-weight-bold text-xl">Approved</span>';
            }

            $withdrawal->date = $this->convertDateView($withdrawal->date);
            $withdrawal->total = $this->currencyView($withdrawal->total);

            return response()->json(['withdrawal' => $withdrawal, 'status' => $label]);
        }
    }

    public function contactAdmin () {
        $userAffiliate = User::findOrfail(Auth::id());

        return view('affiliate.contact-admin.index', compact('userAffiliate'));
    }

    public function sendContact (Request $request) {
        if ($request->ajax()) {
            $data = [
                        'username' => $request->username,
                        'nama_depan' => $request->nama_depan,
                        'nama_belakang' => $request->nama_belakang,
                        'email' => $request->email,
                        'no_telepon' => $request->no_telepon,
                        'body' => $request->message
                    ];
            Mail::send('affiliate.contact-admin._email', $data, function ($message) use ($request) {
                $message->from($request->email);
                $message->to('bayuprsty30@gmail.com', 'Tes 123')
                        ->subject($request->subject);
            });
            
            return $this->sendResponse("Email Sent Successfully. Thank you for contact us");
        }
    }

    public function downloadPdfLead($status, $start_date, $end_date) {
        $lead = Lead::where('user_id', Auth::id())->latest();
        if ($status !== 'all') {
            if ($status == Lead::ON_PROCESS) {
                $lead->where('status', Lead::ON_PROCESS);
            } elseif ($status == Lead::SUCCESS) {
                $lead->where('status', Lead::SUCCESS);
            } else {
                $lead->where('status', Lead::CANCELED);
            }
        }

        if ($start_date !== 'all' && $end_date !== 'all') {
            $lead->whereBetween('date', [$start_date, $end_date]);
        }

        $pdf = PDF::loadView('affiliate.lead._printPdfLead', ['lead' => $lead->get()]);
        return $pdf->setPaper('A4', 'landscape')->stream();
    }

    public function downloadPdfTransaction($status, $start_date, $end_date) {
        $transaction = Transaction::leftJoin('leads', 'leads.id', '=', 'transactions.lead_id');
        if ($status !== 'all') {
            if ($status == Lead::ON_PROCESS) {
                $transaction->where('leads.status', Lead::ON_PROCESS);
            } elseif ($status == Lead::SUCCESS) {
                $transaction->where('leads.status', Lead::SUCCESS);
            } else {
                $transaction->where('leads.status', Lead::CANCELED);
            }
        }

        if ($start_date !== 'all' && $end_date !== 'all') {
            $transaction->whereBetween('transactions.transaction_date', [$start_date, $end_date]);
        }

        $pdf = PDF::loadView('admin.transaction._printPdfTransaction', ['transaction' => $transaction->get()]);
        return $pdf->setPaper('A4', 'landscape')->stream();
    }

    public function shareLink($sharedValue) {
        return view('affiliate.share', compact('sharedValue'));
    }
}
