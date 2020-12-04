<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use App\Helpers\ApiResponse;

use Validator;
use Mail;
use Hash;

use App\Models\Lead;
use App\Models\ServiceCommission;
use App\Models\Transaction;
use App\Models\Vendor;

class ApiController extends Controller
{
    public function getAccessToken(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'secret_id' => 'required',
                'username' => 'required',
                'password' => 'required',
            ], [
                'secret_id.required' => 'secret_id Required',
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
                $vendor = Vendor::where('secret_id', $request->secret_id)->first();
                
                if (is_null($vendor)) {
                    return ApiResponse::send('Vendor Tidak Terdaftar', [], 401);
                }

                if ($vendor->active == false) {
                    return ApiResponse::send('Vendor tidak aktif', [], 401);
                }
    
                $token = Str::random(60);
                
                $vendor->api_token = Hash::make($token);
                $vendor->token_expired_at = Carbon::now()->addDays(1);
    
                if ($vendor->save()) {
                    $data = [
                        'secret_id' => $vendor->secret_id,
                        'token' => $token,
                        'token_expired' => Carbon::parse($vendor->token_expired_at)->format('d-m-Y H:i:s'),
                    ];
    
                    return ApiResponse::send('OK', $data);
                }
            } else {
                return ApiResponse::send('Unauthorized. Data User Not Found', $dataLogin, 401);
            }
        } catch (Exception $e) {
            return ApiResponse::send("Error in exception handler: " . $e->getMessage() . " (Line " . $e->getLine() . ")", array(), 501);
        }
        
    }

    public function setDataLead(Request $request) {
        try {
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
            $vendor = Vendor::where('secret_id', $request->header('SECRET-ID'))->first();

            if ($dataLead->status == Lead::SUCCESS) {
                return APiResponse::send('Lead sudah digunakan', [], 401);
            }

            if ($vendor->active == false) {
                return ApiResponse::send('Vendor tidak aktif', [], 401);
            }

            if ((string) $dataLead->vendor_id !== (string) $vendor->id) {
                return ApiResponse::send('Vendor tidak sesuai dengan data Lead', [], 500);
            }
    
            if (!empty($dataLead)) {
                $data = [
                    'customer_name' => $request->customer_name,
                    'email' => $request->email,
                    'no_telepon' => $request->no_telepon,
                    'date' => Carbon::NOW(),
                    'status' => Lead::ON_PROCESS,
                ];
    
                $updated = $dataLead->update($data);
    
                if ($updated) {
                    $responseUpdate = [
                        'lead_id' => $request->lead_id,
                        'customer_name' => $request->customer_name,
                        'email' => $request->email,
                        'no_telepon' => $request->no_telepon,
                        'date' => $dataLead->date,
                        'status' => 'ON PROCESS',
                    ];
    
                    return ApiResponse::send('Lead Created', $responseUpdate);
                }
            }
        } catch (Exception $e) {
            return ApiResponse::send("Error in exception handler: " . $e->getMessage() . " (Line " . $e->getLine() . ")", array(), 501);
        }
        
    }

    public function setDataTransaction(Request $request) {
        try {
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
    
            $lead = Lead::where('email', $request->email)->first();
            $vendor = Vendor::where('secret_id', $request->header('SECRET-ID'))->first();

            if (is_null($lead)) {
                return ApiResponse::send('Email Not Found', [], 500);
            }

            if ($lead->status == Lead::SUCCESS) {
                return ApiResponse::send('Transaksi Gagal. Lead sudah digunakan', [], 401);
            }

            if ($vendor->active == false) {
                return APiResponse::send('Vendor tidak aktif', [], 401);
            }

            if ((string) $lead->vendor_id !== (string) $vendor->id) {
                return ApiResponse::send('Vendor tidak sesuai dengan data Lead', [], 500);
            }

            $service = ServiceCommission::where('id', $request->service_commission_id)->first();

            if ((string) $service->vendor_id !== (string) $vendor->id) {
                return ApiResponse::send('Service / Product tidak sesuai dengan Vendor', [], 500);
            }
    
            DB::beginTransaction();

            $data = [
                'lead_id' => $lead->id,
                'service_commission_id' => $request->service_commission_id,
                'transaction_date' => Carbon::parse($request->transaction_date)->format('Y-m-d'),
                'amount' => $request->amount,
                'commission' => !empty($request->commission) ? $request->commission : Transaction::getCommissionValue($request->service_commission_id, $request->amount),
            ];

            $transactionCreated = Transaction::create($data);

            if ($transactionCreated) {
                $lead->update(['status' => Lead::SUCCESS]);
                
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
        } catch (Exception $e) {
            DB::rollback();
            return ApiResponse::send("Error in exception handler: " . $e->getMessage() . " (Line " . $e->getLine() . ")", array(), 501);
        }
    }
}
