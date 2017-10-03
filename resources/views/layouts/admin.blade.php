<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page_title')</title>

    <!-- Bootstrap -->
    @php
      $version = str_random(20);
    @endphp
    <link rel="stylesheet" href="{{asset('bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/semantic.min.css')}}">
    <meta name="version" content="{{$version}}">
    <meta name="wide_style" content="{{asset('css/main_wide.css')}}">
    <meta name="medium_style" content="{{asset('css/main_medium.css')}}">
    <meta name="small_style" content="{{asset('css/main_small.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css?v='.$version)}}">
    <link rel="stylesheet" id='responsive_stylesheet' href="{{asset('css/main_wide.css?v='.$version)}}">

    @yield('header_section_content')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="bg_lightgray">
    @yield('styles')

    {{-- header --}}
    <header class="header_section bg_neonblue">
      @yield('search_wrapper')

      <a href="{{ route('admin.index') }}" class="logo_title text_shadow_neon_blue font_size18 color_white">
        INTERACTIVE VIDEO PUZZLE
      </a>
      <div class="header_operation_div sidebar_icon sidebar_trigger">
        <div class="clear-menu-btn">
          <input type="checkbox">
          <span class="top"></span>
          <span class="middle"></span>
          <span class="bottom"></span>
          <span class="circle"></span>
        </div>
      </div>

      {{-- sidebar --}}
      <div class="sidebar bg_neonblue1">

        <div class="profile_div redirect_to_page" data-redirect-url='{{route('admin.users.edit', Auth::user()->id)}}'>


          @if (Auth::user()->profileimage() == NULL)
            <img src="http://via.placeholder.com/150x150" class='sidebar_profile_pic' alt="">
          @elseif (Auth::user()->profileimage() != NULL)
            <img src="{{asset(Auth::user()->profileimage()->path)}}" class='sidebar_profile_pic' alt="">
          @endif
          {{-- username --}}
          <span class="username font_size12">{{Auth::user()->username}}</span>
        </div>
        <div class="nav_container">
          <ul class="nav_ul">
            <a href="{{ route('admin.index') }}">
              <li>
                <img src="{{asset('icon/dashboard_neon_blue.svg')}}" alt="">
                <span class="title">DASHBOARD</span>
              </li>
            </a>
            <a href="{{route('admin.notifications.index')}}" id="markasread" data-num-notify='{{count(Auth::user()->unreadnotifications)}}'>
              <li>
                <img src="{{asset('icon/notification_neon_blue.svg')}}" alt="">
                <span class="title">NOTIFICATION</span>
                @if (count(Auth::user()->unreadnotifications) > 0)
                  <span class="badge margin_left10">{{count(Auth::user()->unreadnotifications)}}</span>
                @endif

              </li>
            </a>
            <a href="{{route('admin.users.index')}}">
              <li>
                <img src="{{asset('icon/users_neon_blue.svg')}}" alt="">
                <span class="title">USER</span>
              </li>
            </a>
            <a href="{{ route('admin.assets.index') }}">
              <li>
                <img src="{{asset('icon/folder_neon_blue.svg')}}" alt="">
                <span class="title">ASSETS</span>
              </li>
            </a>
            <a href="{{ url('/logout') }}">
              <li>
                <img src="{{asset('icon/exit_neon_blue.svg')}}" alt="">
                <span class="title">LOGOUT</span>
              </li>
            </a>
          </ul>
        </div>
      </div>
      {{-- sidebar --}}
    </header>
    {{-- header --}}



    @yield('content')


    <footer class="footer bg_darkgrey color_white">
      <span class="col-md-12 col-sm-12 text-center">
        © 2017 Copyright All rights reserved.
      </span>

    </footer>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{asset('js/jquery-3.2.1.min.js')}}" charset="utf-8"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{asset('js/umd/popper.min.js')}}" charset="utf-8"></script>
    <script src="{{asset('bootstrap/dist/js/bootstrap.min.js')}}" charset="utf-8"></script>
    <script src="{{asset('js/semantic.min.js')}}" charset="utf-8"></script>

    <script src="{{asset('js/main.js?v='.$version)}}" charset="utf-8"></script>
    @yield('scripts')
  </body>
</html>
