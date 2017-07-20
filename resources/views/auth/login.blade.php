@extends('layouts.landing')

@section('page_title')
  Login
@endsection

@section('header_section_content')
  <meta name="_token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="login_page_container container">

  <div class="login_form_wrapper">
    <form class="ui form @if (count($errors) > 0) error @endif" method="POST" action="{{ route('login') }}">
      {{ csrf_field() }}
      <div class="ui attached segments">
        <div class="ui segment" style="padding:40px;">
          <h4 class="ui horizontal divider header">
            <i class="sign in icon"></i>
            Login
          </h4>

          <div class="field">
            <label>E-Mail Address</label>
            <div class="ui left icon input">
              <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="E-Mail Address" required autofocus>
              <i class="mail outline icon"></i>
            </div>


            @if ($errors->has('email'))
              <div class="ui error message">
                <p>These credentials do not match our records.</p>
              </div>
            @endif
          </div>
          <div class="field">
            <label>Password</label>
            <div class="ui left icon input">
              <input id="password" type="password" class="form-control" name="password"  placeholder="Password" required>
              <i class="lock icon"></i>
            </div>

            @if ($errors->has('password'))
              <div class="ui error message">
                <p>These credentials do not match our records.</p>
              </div>
            @endif
          </div>
          <div class="field">
            <div class="ui checkbox">
              <input id='rmbme' type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
              <label for='rmbme'>
                   Remember Me
              </label>
            </div>
          </div>
          <div class="field">
            <button class="ui button" type="submit">Login</button>
            <a class="btn btn-link" href="{{ route('password.request') }}">
                Forgot Your Password?
            </a>
          </div>
          <div class="ui clearing divider"></div>
          <div class="field">
            <button class="large fluid ui facebook button">
              <i class="facebook icon"></i>
              Facebook
            </button>
          </div>
          <div class="field">
            <button class="large fluid ui google plus button">
              <i class="google plus icon"></i>
              Google Plus
            </button>
          </div>
        </div>

      </div>
    </form>
  </div>


    {{-- <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
</div>
@endsection

@section('scripts')
  <script type="text/javascript">
    $('.ui.checkbox').checkbox();
  </script>
@endsection
