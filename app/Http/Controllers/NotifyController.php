<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotifyController extends Controller
{
    public function show_all(){
        $userUnread = auth()->user()->unreadNotifications;
        if($userUnread){
            $userUnread->markAsRead();
            return back();
        }
    }
}
