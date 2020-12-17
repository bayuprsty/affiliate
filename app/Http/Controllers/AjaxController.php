<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Models\ServiceCommission;
use App\Models\Notification;
use App\Models\WithdrawalStatus;

use App\Models\Click;
use App\Models\User;
use App\Models\Lead;

class AjaxController extends Controller
{
    public function setCommission(Request $request) {
        if(request()->ajax()) {
            $service = ServiceCommission::findOrfail($request->service_id);
            
            if ($service->commission_type_id === 1) {
                $commission = $service->commission_value;
            } else {
                $commission = ($request->amount * $service->commission_value) / 100;
                if (!is_null($service->max_commission)) {
                    if ($commission > $service->max_commission) {
                        $commission = $service->max_commission;
                    }
                }
            }

            return response()->json(['commission' => $commission]);
        }
    }

    public function getProductService(Request $request) {
        if ($request->ajax()) {
            $service = '<option value="">-- Select Product/Service --</option>';
            
            $dataService = ServiceCommission::where('vendor_id', $request->id_vendor)->get();
            foreach ($dataService as $key => $value) {
                $service .= "<option value='".$value->id."'>".$value->title."</option>";
            }

            return response()->json([
                'service' => $service
            ]);
        }
    }

    public function loadUserAffiliate(Request $request) {
        if ($request->has('q')) {
            $name = $request->q;
            $user = User::select('id', DB::raw('CONCAT(nama_depan, " ", nama_belakang) as nama'))
                        ->where(function($query) use ($name) {
                            $query->where('id', 'LIKE', '%'.$name.'%')->orWhere(DB::raw('CONCAT(nama_depan, " ", nama_belakang)'), 'LIKE', '%'.$name.'%');
                        })->where('role', 'affiliator')->take(5)->get();
        } else {
            $user = User::select('id', DB::raw('CONCAT(nama_depan, " ", nama_belakang) as nama'))->where('role', 'affiliator')->take(5)->get();
        }

        return response()->json($user);
    }

    public function getNotification() {
        if (Auth::user()->role == 'admin') {
            $notification = Notification::where('admin_read', 0)->latest()->get();
        } else {
            $notification = Notification::leftJoin('leads', 'leads.id', '=', 'notifications.lead_id')
                                        ->leftJoin('withdrawals', 'withdrawals.id', '=', 'notifications.withdraw_id')
                                        ->where('notifications.user_read', 0)
                                        ->where('withdrawals.withdrawal_status_id', WithdrawalStatus::APPROVE)
                                        ->where('notifications.user_id', Auth::id())
                                        ->get();
        }

        $arrayNotification = '';
        if (isset($notification)) {
            foreach ($notification as $key => $value) {
                if (isset($value->withdraw_id) && Auth::user()->role == 'admin') {
                    $arrayNotification .= '<a class="dropdown-item d-flex align-items-center" href="'.route('withdraw.request').'">
                                                <div class="mr-3">
                                                    <div class="icon-circle bg-success">
                                                        <i class="fas fa-money-bill text-white"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="small text-gray-500">'.$this->convertDateView($value->withdraw->date).'</div>
                                                    <span class="font-weight-bold">Withdraw Request from '.$value->withdraw->user->username.'</span>
                                                </div>
                                            </a>';
                } else {
                    $arrayNotification .= '<a class="dropdown-item d-flex align-items-center" href="'.route('affiliate.wallet').'">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-success">
                                                    <i class="fas fa-money-bill text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500">'.$this->convertDateView($value->withdraw->date_approve).'</div>
                                                <span class="font-weight-bold">Withdraw Request Transaction ID '.$value->withdraw->id.' Approved</span>
                                            </div>
                                        </a>';
                }
            }
        }

        if (Auth::user()->role == 'admin') {
            $arrayNotification .= '<a class="dropdown-item text-center small text-gray-500" href="'.route('all.notification').'">Show All Notification</a>';
        } else {
            $arrayNotification .= '<a class="dropdown-item text-center small text-gray-500" href="'.route('user.notification').'">Show All Notification User</a>';
        }

        return response()->json(['notification' => $arrayNotification, 'count' => $notification->count()]);
    }

    public function allNotification() {
        $notification = Notification::latest()->get();

        $arrayNotification = '';
        if (isset($notification)) {
            foreach ($notification as $key => $value) {
                $arrayNotification .= '<a class="p-2 d-flex align-items-center bg-light" href="'.route('withdraw.request').'">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-success">
                                                    <i class="fas fa-money-bill text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500">'.$this->convertDateView($value->withdraw->date).'</div>
                                                <span class="font-weight-bold">Withdraw Request from '.$value->withdraw->user->username.'</span>
                                            </div>
                                        </a>';
            }
        }

        return response()->json(['notification' => $arrayNotification]);
    }

    public function userNotification() {
        $notification = Notification::leftJoin('leads', 'leads.id', '=', 'notifications.lead_id')
                                    ->leftJoin('withdrawals', 'withdrawals.id', '=', 'notifications.withdraw_id')
                                    ->where('notifications.admin_read', 1)
                                    ->where('withdrawals.withdrawal_status_id', WithdrawalStatus::APPROVE)
                                    ->where('notifications.user_id', Auth::id())
                                    ->latest('notifications.created_at')->get();

        $arrayNotification = '';
        if (isset($notification)) {
            foreach ($notification as $key => $value) {
                $arrayNotification .= '<a class="p-2 d-flex align-items-center bg-light" href="'.route('affiliate.wallet').'">
                                            <div class="mr-3">
                                                <div class="icon-circle bg-success">
                                                    <i class="fas fa-money-bill text-white"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="small text-gray-500">'.$this->convertDateView($value->withdraw->date).'</div>
                                                <span class="font-weight-bold">Withdraw Request Transaction ID '.$value->withdraw->id.' Approved</span>
                                            </div>
                                        </a>';
            }
        }

        return response()->json(['notification' => $arrayNotification]);
    }

    public function setClick(Request $request) {
        if ($request->ajax()) {
            $value      = explode('.', $request->value);

            $service_id  = $value[0];
            $user_id     = $value[1];
            $media_id    = $value[2];

            $service = ServiceCommission::where('id', $service_id)->first();

            $click = Click::where(['vendor_id' => $service->vendor_id, 'user_id' => $user_id, 'media_id' => $media_id])->get();

            DB::beginTransaction();

            try {
                if (count($click) > 0) {

                    $dataClick = $click[0];
    
                    $updateClick      = $dataClick->click + 1;
                    $dataClick->click = $updateClick;
    
                    $update = $dataClick->save();
    
                    if ($update) {
                        $ipaddress = $this->getIpAddress();
    
                        $leadByIp = Lead::where('ip_address', $ipaddress)->where('status', '<>', Lead::SUCCESS)->get();
    
                        if (count($leadByIp) > 0) {
                            DB::commit();
                            $dataOldLead = $leadByIp[0];
                            return response()->json(['url' => $service->service_link.'/?leadid='.$dataOldLead->id]);
                        }
    
                        $dataLead = [
                            'user_id'       => $user_id,
                            'vendor_id'     => $service->vendor_id,
                            'ip_address'    => $ipaddress
                        ];
    
                        $success = Lead::create($dataLead);
    
                        if ($success) {
                            DB::commit();
                            return response()->json(['url' => $service->service_link.'/?leadid='.$success->id]);
                        }
                    }
                } else {
                    $dataClick = [
                        'user_id' => $user_id,
                        'vendor_id' => $service->vendor_id,
                        'media_id' => $media_id,
                        'click' => 1
                    ];
    
                    $clickSuccess = Click::create($dataClick);
    
                    if ($clickSuccess) {
                        $ipaddress = $this->getIpAddress();
                        $dataLead = [
                            'user_id'       => $user_id,
                            'vendor_id'     => $service->vendor_id,
                            'ip_address'    => $ipaddress,
                        ];
    
                        $leadSuccess = Lead::create($dataLead);
    
                        if ($leadSuccess) {
                            DB::commit();
                            return response()->json(['url' => $service->service_link.'/?leadid='.$leadSuccess->id]);
                        }
                    }
                }
            } catch (Exception $e) {
                dd($e);
            }
            
        }
    }
}
