<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function allNotification()
    {
        $notifications = auth()->user()->notifications;

        return view('notification.all_notification', compact('notifications'));
    }
}
