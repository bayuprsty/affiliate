<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Carbon\Carbon;

use App\Lead;
use App\ServiceCommission;
use App\User;
use App\Transaction;

class LeadController extends Controller
{
    public function index(Request $request) {
        $lead = Lead::paginate(10);
        return view('admin.lead.index', compact('lead'));
    }

    public function prosesLead(Request $request) {
        $service = '<option value="">-- Select Product/Service --</option>';
        if($request->ajax()) {
            $lead = Lead::findOrfail($request->id);

            $user = User::findOrfail($lead->user_id);

            $dataService = ServiceCommission::where('vendor_id', $lead->vendor_id)->get();

            foreach ($dataService as $key => $value) {
                $service .= "<option value='".$value->id."'>".$value->title."</option>";
            }

            return response()->json([
                'lead' => $lead,
                'user' => $user,
                'service' => $service
            ]);
        }
    }

    public function saveProses (Request $request) {
        if (request()->ajax()) {
            $this->validate($request, [
                'transaction_date' => 'required|string',
                'amount' => 'required|string',
                'service_commission_id' => 'required'
            ]);
    
            $service = ServiceCommission::findOrfail($request->service_commission_id);
    
            if ($service->commission_type_id == 1) {
                $commission = $service->commission_value;
            } else {
                $commission = ($request->amount * $service->commission_value) / 100;
            }
    
            $transaction = Transaction::create([
                'lead_id' => $request->lead_id,
                'service_commission_id' => $request->service_commission_id,
                'transaction_date' => $this->convertDateSave($request->transaction_date),
                'amount' => $request->amount,
                'commission' => $commission
            ]);
    
            if ($transaction) {
                Lead::where('id', $request->lead_id)->update(['status' => Lead::SUCCESS]);
                return $this->sendResponse("Lead Processed Successfully");
            } else {
                return $this->sendResponse("Lead Processed Fail", "", 221);
            }
        }
    }

    public function cancel($id) {
        Lead::where('id', $id)->update(['status' => Lead::CANCELED]);
        
        return back()->with(['success' => 'Lead Canceled']);
    }

    public function downloadPdf($status, $start_date, $end_date) {
        $lead = Lead::latest();
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

        $pdf = PDF::loadView('admin.lead._printPdfLead', ['lead' => $lead->get()]);
        return $pdf->setPaper('A4', 'landscape')->stream();
    }
}
