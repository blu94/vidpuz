<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view('home');
        if ( Auth::user()->isAdmin() ) {
          return redirect('/admin');
        }
        else if ( Auth::user()->isUser() ) {
          return redirect('/user');
        }
        return redirect('/user');
    }
}
