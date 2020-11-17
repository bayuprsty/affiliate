<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function allNotification() {
        return view('notification.index_admin');
    }

    public function userNotification() {
        return view('notification.index_user');
    }
}
