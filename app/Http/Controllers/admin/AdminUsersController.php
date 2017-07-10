<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use Auth;
use Illuminate\Support\Facades\Session;
use App\User;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        //
        return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
