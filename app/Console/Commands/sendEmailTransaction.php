<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

use Mail;

use App\User;
use App\Transaction;
use App\Lead;

class sendEmailTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthly:transaction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email TO All User Affiliate';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::where('role', 'affiliator')->where('email_confirmed', 1)->get();
        $month = date('m');
        
        foreach ($user as $key => $value) {
            $transaction = Transaction::leftJoin('leads', 'leads.id', '=', 'transactions.lead_id')->where('user_id', $value->id)->whereMonth('transactions.transaction_date', '=', $month)->get();
            $lead = Lead::where('user_id', $value->id)->whereMonth('date', '=', $month)->get();

            $totalLead = $lead->count();
            $totalTransaction = $transaction->count();
            $totalCommission = $transaction->sum('commission');

            $data = [
                'nama_lengkap' => $value->nama_depan.' '.$value->nama_belakang,
                'lead' => $totalLead,
                'transaction' => $totalTransaction,
                'commission' => $totalCommission,
                'month' => date('F')
            ];

            Mail::send('admin.transaction._monthly_email', $data, function($message) use ($value) {
                $message->to($value->email)->subject('Monthly Transaction Report');
            });
        }

        return 0;
    }
}
