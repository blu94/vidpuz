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

    public function update(Request $request, $id)
    {
        //
        $user = User::findOrFail($id);

        $user_detail = [];
        if ($user->id != Auth::user()->id && $user->role_id != 1) {
          $is_active = 0;
          if(!empty($request->is_active)) {
            $is_active = 1;
          }

          $user_detail = [
            'surname' => $request->surname,
            'givenname' => $request->givenname,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'bio' => $request->bio,
            'is_active' => $is_active
          ];
        }
        else {
          $user_detail = [
            'surname' => $request->surname,
            'givenname' => $request->givenname,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'bio' => $request->bio
          ];
        }

        $user->update($user_detail);

        Session::flash('success_message', 'User detail update sucessfully.');
        return redirect()->back();
    }
}
