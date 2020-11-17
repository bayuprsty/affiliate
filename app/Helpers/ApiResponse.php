<?php
namespace App\Helpers;

class ApiResponse {
    public static function send($message = '', $data = [], $status = 200, $start_time = 0) {
        try {
            $start_time = ($start_time == 0) ? microtime(true) : $start_time;
            if ($status == 200) {
                // status 200
                return response()->json([
                    "status" => (string) $status,
                    "message" => $message,
                    "elapsed_time" => (microtime(true) - $start_time),
                    "data" => $data,
                ]);
            } elseif ($status == 400) {
                // status 400 (error validasi input)
                return response()->json([
                    "status" => (string) $status,
                    "message" => $message." (".$data.")",
                ]);
            } else {
                // status 401, 500, 501, 502, etc
                return response()->json([
                    "status" => (string) $status,
                    "message" => $message,
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => "501",
                "message" => $e->getMessage(),
            ]);
        }
    }
}

?>