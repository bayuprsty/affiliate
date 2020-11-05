<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Validator;

use App\Lead;

class ApiController extends Controller
{
    public function setDataLead(Request $request) {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required',
            'email' => 'required|email|unique:leads',
            'no_telepon' => 'required'
        ], [
            'customer_name.required' => 'Customer Name required',
            'email.required' => 'Email required',
            'email.email' => 'Email not valid',
            'email.unique' => 'Email has been registered',
            'no_telepon' => 'Nomor Telepon harus diisi'
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->messages() as $value) {
                $error[] = $value[0];
            }

            $stringError = implode(', ', $error);

            return $this->sendResponse($stringError, '', 221);
        }

        $dataLead = Lead::findOrfail($request->lead_id);

        if (!empty($dataLead)) {
            $data = [
                'customer_name' => $request->customer_name,
                'email' => $request->email,
                'no_telepon' => $request->no_telepon,
                'date' => Carbon::now(),
                'status' => Lead::ON_PROCESS,
            ];

            $updated = $dataLead->update($data);

            if ($updated) {
                $this->sendResponse('Lead Created', $updated[0]);
            }
        }
    }

    public function setDataTransaction(Request $request) {
        $validator = Validator::make($request->all(), [
            'service_commission_id' => 'required',
            'email' => 'required|email'
        ], [
            'service_commission_id.required' => 'Product/Service tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid'
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->messages() as $value) {
                $error[] = $value[0];
            }

            $stringError = implode(', ', $error);;

            return $this->sendResponse($stringError, '', 221);
        }

        $lead = Lead::where('email', $request->email)->get();

        if (count($lead) > 0) {
            $data = [
                'lead_id' => $lead->id,
                'transaction_date' => $request->transaction_date,
                'amount' => $request->amount,
                'commission' => !empty($request->commission) ? $request->commission : NULL,
            ];

            $transactionCreated = Transaction::create($data);

            if ($transactionCreated) {
                return $this->sendResponse('Transaction Created', $transactionCreated[0]);
            }
        }
    }
}
