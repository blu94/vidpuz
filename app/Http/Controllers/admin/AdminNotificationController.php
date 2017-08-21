<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminNotificationController extends Controller
{
    //
    public function index()
    {
      return view('admin.notifications.index');
    }
}
