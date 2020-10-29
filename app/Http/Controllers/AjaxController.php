<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\ServiceCommission;
use App\Notification;
use App\WithdrawalStatus;

use App\Click;

class AjaxController extends Controller
{
    public function setCommission(Request $request) {
        if(request()->ajax()) {
            $service = ServiceCommission::findOrfail($request->service_id);
            
            if ($service->commission_type_id === 1) {
                $commission = $service->commission_value;
            } else {
                $commission = ($request->amount * $service->commission_value) / 100;
            }

            return response()->json(['commission' => $commission]);
        }
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
                                                <div class="small text-gray-500">'.$this->convertDateView($value->withdraw->date).'</div>
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
            $value = explode('.', $request->value);

            $ipaddress = $this->getIpAddress();
            dd($ipaddress);

            // [0] vendor, [1] id user, [2] media
            $click = Click::where(['vendor_id' => $value[0], 'user_id' => $value[1], 'media_id' => $value[2]])->get();

            if (count($click) > 0) {
                $updateClick = $click[0]->click + 1;
                $click[0]->click = $updateClick;

                $update = $click[0]->save();

                if ($update) {
                    $ipaddress = $this->getIpAddress();
                    // $data = [
                    //     'user_id' => 
                    // ]
                }

                return response()->json(['url' => $click[0]->vendor->link]);
            } else {
                $data = [
                    'user_id' => $value[1],
                    'vendor_id' => $value[0],
                    'media_id' => $value[2],
                    'click' => 1
                ];

                $createSuccess = Click::create($data);

                if ($createSuccess) {
                    return response()->json(['url' => $createSuccess->vendor->link]);
                }
            }
        }
    }
}
