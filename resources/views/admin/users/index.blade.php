@extends('layouts.admin')

@section('page_title')
  USERS
@endsection

@section('search_wrapper')
  <div class="search_bar">
    <button type="button" name="button" class="search_btn">
      <img src="{{asset('icon/search_white.svg')}}" alt="">
    </button>
  </div>
  <div class="lightbox search_lightbox special_close">
    <div class="lightbox_content_transparent search_wrapper not_to_close">
      {!! Form::open(['method' => 'GET', 'action' => 'admin\AdminUsersController@index', 'id' => 'search_form']) !!}
        <div class="ui right huge aligned search_video search">
          <div class="ui icon input">
            <input class="prompt" type="text" name="search" placeholder="Search User...">
            <i class="search icon"></i>
          </div>
          <div class="results"></div>
        </div>
      {!! Form::close() !!}

    </div>
  </div>
@endsection

@section('content')
  <div class="body_container">
    <span class="page_title">USERS</span>
    <div class="all_user_wrapper ui four doubling cards">

      {{-- add new member button --}}
      <a href="{{route('admin.users.create')}}" class="card">
        <div class="add_icon_container">
          <span class="add_icon bg_lightblue color_white">&#43;</span>
          <span class="font_size14">Add User</span>
        </div>
      </a>
      @foreach ($users as $user)
        {{-- <a href="{{route('admin.users.edit', $user->id)}}" class="user_item_container">
          <div class="user_item_wrapper">
            @if ($user->profileimage() == NULL)
              <img src="http://via.placeholder.com/150x150" alt="" class="user_item_thumbnail">
            @elseif ($user->profileimage() != NULL)
              <img src="{{$user->profileimage()->path}}" alt="" class="user_item_thumbnail">
            @endif

            <span class="font_size14">{{$user->username}}</span>
          </div>
        </a> --}}

        <div class="card redirect_to_page user_item_card" data-redirect-url='{{route('admin.users.edit', $user->id)}}'>
          <div class="image">
            @if ($user->profileimage() == NULL)
              <img src="http://via.placeholder.com/150x150" alt="" class="">
            @elseif ($user->profileimage() != NULL)
              <img src="{{asset($user->profileimage()->path)}}" alt="" class="">
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

@section('scripts')
  <script type="text/javascript">
  var content = [
    @foreach ($search_options as $option_key => $option)
    {
      'title' : '{{$option->username}}',
      'url' : '{{route('admin.users.index')}}?search={{$option->username}}'
    }
    @if (count($search_options) > $option_key)
    ,
    @endif
    @endforeach
  ];

  $('.search_video').search({
    source: content
  });
  </script>
@endsection
