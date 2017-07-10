@extends('layouts.admin')

@section('page_title')
  USERS
@endsection

@section('content')
  <div class="body_container">
    <span class="page_title">USERS</span>
    <div class="all_user_wrapper">

      @foreach ($users as $user)
        <a href="{{route('admin.users.edit', $user->id)}}" class="user_item_container">
          <div class="user_item_wrapper">
            @if ($user->profileimage() == NULL)
              <img src="http://via.placeholder.com/150x150" alt="" class="user_item_thumbnail">
            @elseif ($user->profileimage() != NULL)
              <img src="{{$user->profileimage()->path}}" alt="" class="user_item_thumbnail">
            @endif

            <span class="font_size14">{{$user->username}}</span>
          </div>
        </a>
      @endforeach
      <a href="{{route('admin.users.create')}}" class="user_item_container">
        <div class="add_icon_container">
          <span class="add_icon bg_lightblue color_white">&#43;</span>
          <span class="font_size14">Add User</span>
        </div>
      </a>
    </div>
  </div>
@endsection
