@extends('layouts.user')

@section('page_title')
  USERS
@endsection

@section('content')
  <div class="body_container">
    <span class="page_title">USERS</span>
    <div class="all_user_wrapper ui link cards">

      {{-- add new member button --}}
      <a href="{{route('user.users.create')}}" class="card">
        <div class="add_icon_container">
          <span class="add_icon bg_lightblue color_white">&#43;</span>
          <span class="font_size14">Add User</span>
        </div>
      </a>
      @foreach ($users as $user)

        <div class="card redirect_to_page" data-redirect-url='{{route('user.users.edit', $user->id)}}'>
          <div class="image">
            @if ($user->profileimage() == NULL)
              <img src="http://via.placeholder.com/150x150" alt="" class="">
            @elseif ($user->profileimage() != NULL)
              <img src="{{$user->profileimage()->path}}" alt="" class="">
            @endif
          </div>
          <div class="content">
            <div class="header ellipsis_content">{{$user->username}}</div>
            <div class="meta">
              {{$user->username}} {{$user->givenname}}
              {{-- <a>{{$user->role->name}}</a> --}}
            </div>
            {{-- <div class="description">
              {{$user->username}} {{$user->givenname}}
            </div> --}}
          </div>
          {{-- <div class="extra content">
            <span class="right floated">
              Joined in 2013
            </span>
            <span>
              <i class="user icon"></i>
              75 Friends
            </span>
          </div> --}}
        </div>
      @endforeach

    </div>
  </div>
@endsection
