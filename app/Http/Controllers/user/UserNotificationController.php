<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class UserNotificationController extends Controller
{
    //
    public function index()
    {
      return view('user.notifications.index');
    }
}
