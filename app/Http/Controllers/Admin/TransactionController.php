<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;

use App\Transaction;

class TransactionController extends Controller
{
    public function index() {
        return view('admin.transaction.index');
    }

    public function downloadPdf($status, $start_date, $end_date) {
        $transaction = Transaction::leftJoin('leads', 'leads.id', '=', 'transactions.lead_id')->where('leads.user_id', Auth::id());
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
            $transaction->whereBetween('transactions.date', [$start_date, $end_date]);
        }

        $pdf = PDF::loadView('admin.transaction._printPdfTransaction', ['transaction' => $transaction->get()]);
        return $pdf->setPaper('A4', 'landscape')->stream();
    }
}
