<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use Auth;
use Illuminate\Support\Facades\Session;
use App\User;

class UserUsersController extends Controller
{
    //
    public function edit($id)
    {
        //
        $user = User::findOrFail($id);
        return view('user.users.edit', compact('user'));
    }
}
