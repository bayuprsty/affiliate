<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getIpAddress() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
    
        return $ipaddress;
    }
    
    public function convertDateView ($date) {
        // return date('d-m-Y', strtotime($date));
        return Carbon::parse($date)->format('d/m/Y');
    }

    public function convertDateSave ($date) {
        return date('Y-m-d', strtotime($date));
    }

    public function currencyView($value) {
        return "Rp. ".number_format($value, 0, ',', '.');
    }

    public function percentageView($value) {
        return $value."%";
    }

    public function sendResponse($message, $data = NULL, $code = 200) {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'code' => $code
        ]);
    }
}
