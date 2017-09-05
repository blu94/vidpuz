<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
          @yield('page_title')
        </title>

        @php
          $version = str_random(20);
        @endphp
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.10/semantic.min.css">
        <meta name="version" content="{{$version}}">
        <meta name="wide_style" content="{{asset('css/main_wide.css')}}">
        <meta name="medium_style" content="{{asset('css/main_medium.css')}}">
        <meta name="small_style" content="{{asset('css/main_small.css')}}">
        <link rel="stylesheet" href="{{asset('css/main.css?v='.$version)}}">
        <link rel="stylesheet" id='responsive_stylesheet' href="{{asset('css/main_wide.css?v='.$version)}}">

        @yield('styles')

    </head>

    @yield('search_wrapper')

    <body class="bg_lightgray">
      <div class="landing_header1">
        <div class="landing_login_bar">
          <div class="landing_navbar_wrapper">
            @yield('search_link')
            <a href="{{ route('landing.video.index') }}" class="header_item color_white">Asset</a>
            @if (Route::has('login'))
              @if (Auth::check())
                @if (Auth::user()->isAdmin())
                  <a href="{{ url('/admin') }}" class="header_item color_white">Home</a>
                @elseif (Auth::user()->isUser())
                  <a href="{{ url('/user') }}" class="header_item color_white">Home</a>
                @endif

              @else
                <a href="{{ url('/login') }}" class="header_item color_white">Login</a>
                <a href="{{ url('/register') }}" class="header_item color_white">Register</a>
              @endif
            @endif
          </div>


        </div>

        <a href="{{ url('/') }}" class="landing_title text_shadow_neon_blue">INTERACTIVE VIDEO PUZZLE</a>


      </div>

      @yield('content')

      <footer class="footer bg_darkgrey color_white">
        <span class="col-md-12 col-sm-12 text-center">
          © 2017 Copyright All rights reserved.
        </span>

      </footer>


    </body>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.10/semantic.min.js" charset="utf-8"></script>

    <script src="{{asset('js/main.js?v='.$version)}}" charset="utf-8"></script>

    @yield('scripts')

</html>
