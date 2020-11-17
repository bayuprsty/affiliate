<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Helpers\ApiResponse;

use Validator;
use Mail;

use App\Lead;
use App\Transaction;

class ApiController extends Controller
{
    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Username Required',
            'password.required' => 'Password Required'
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->messages() as $value) {
                $error[] = $value[0];
            }

            $stringError = implode(', ', $error);

            return ApiResponse::send($stringError, '', 221);
        }

        $username = 'affiliateapi';
        $password = 'affiliatedvnt101112';

        if ($request->username !== $username && $request->password !== $password) {
            return ApiResponse::send('Username dan Paswword Salah', $request->all(), 400);
        }

        $dataLogin = [
            'username' => $request->username,
            'password' => $request->password,
        ];
        
        if (Auth::attempt($dataLogin)) {
            $user = Auth::user();
            $token = $user->createToken('Personal Access Token');

            $data['grant_type'] = 'Bearer';
            $data['access_token'] = $token->accessToken;
            $data['token_id'] = $token->token->id;
            $data['expired_at'] = $token->token->expires_at;

            return ApiResponse::send('OK', $data);
        } else {
            return ApiResponse::send('Unauthorized. Data User Not Found', $dataLogin, 401);
        }
    }

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

            return ApiResponse::send($stringError, '', 422);
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
                return ApiResponse::send('Lead Created', $updated);
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

            return ApiResponse::send($stringError, '', 422);
        }

        $lead = Lead::where('email', $request->email)->get();

        DB::beginTransaction();

        try {
            if (count($lead) > 0) {
                $data = [
                    'lead_id' => $lead[0]->id,
                    'service_commission_id' => $request->service_commission_id,
                    'transaction_date' => date('m-d-Y', strtotime($request->transaction_date)),
                    'amount' => $request->amount,
                    'commission' => !empty($request->commission) ? $request->commission : Transaction::getCommissionValue($request->service_commission_id, $request->amount),
                ];
    
                $transactionCreated = Transaction::create($data);
    
                if ($transactionCreated) {
                    $lead[0]->update(['status' => Lead::SUCCESS]);
                    
                    $dataEmail = [
                        'customer_name' => $transactionCreated->lead->customer_name,
                        'email' => $this->hideEmail($transactionCreated->lead->email),
                        'no_telepon' => $this->hidePhoneNumber($transactionCreated->lead->no_telepon),
                        'transaction_date' => $this->convertDateView($transactionCreated->transaction_date),
                        'amount' => $this->currencyView($transactionCreated->amount),
                        'commission' => $this->currencyView($transactionCreated->commission)
                    ];

                    $affiliateEmail = $transactionCreated->lead->user->email;

                    Mail::send('admin.transaction._email', $dataEmail, function($message) use ($affiliateEmail) {
                        $message->to($affiliateEmail)->subject('Affiliate Transaction Success');
                    });

                    DB::commit();
                    return ApiResponse::send('Transaction Created', $transactionCreated);
                }
            }
        } catch (Exception $e) {
            DB::rollback();
            return ApiResponse::send($e->getMessage(), [], 500);
        }

        
    }
}
