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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <meta name="version" content="{{$version}}">
    <meta name="wide_style" content="{{asset('css/main_wide.css')}}">
    <meta name="medium_style" content="{{asset('css/main_medium.css')}}">
    <meta name="small_style" content="{{asset('css/main_small.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link rel="stylesheet" id='responsive_stylesheet' href="{{asset('css/main_wide.css?v='.$version)}}">

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
    <header class="header_section">
      <span class="title font_size18 color_white">
        VIDEO PUZZLE
      </span>
      <div class="operation_div sidebar_icon sidebar_trigger">
        <div class="clear-menu-btn">
          <input type="checkbox">
          <span class="top"></span>
          <span class="middle"></span>
          <span class="bottom"></span>
          <span class="circle"></span>
        </div>
      </div>
    </header>
    {{-- header --}}

    {{-- sidebar --}}
    <div class="sidebar">
      <div class="profile_div">
        <img src="http://via.placeholder.com/150x150" alt="">
      </div>
      <div class="nav_container">
        <ul class="nav_ul">
          <a href="#">
            <li>
              <img src="{{asset('icon/notification_neon_blue.svg')}}" alt="">
              <span class="title">NOTIFICATION</span>
            </li>
          </a>
        </ul>
      </div>
    </div>
    {{-- sidebar --}}

    @yield('content')
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="{{asset('js/main.js')}}" charset="utf-8"></script>
    @yield('scripts')
  </body>
</html>
