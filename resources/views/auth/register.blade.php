{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">surname</label>

                            <div class="col-md-6">
                                <input id="surname" type="text" class="form-control" name="surname" value="{{ old('surname') }}" required autofocus>

                                @if ($errors->has('surname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('surname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('givenname') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">givenname</label>

                            <div class="col-md-6">
                                <input id="givenname" type="text" class="form-control" name="givenname" value="{{ old('givenname') }}" required>

                                @if ($errors->has('givenname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('givenname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">username</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required>

                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

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
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

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
            <i class="user circle outline icon"></i>
            Register
          </h4>
          <div class="field">
            <label>Surname</label>
            <div class="ui left icon input">
              <input id="surname" type="text" name="surname" value="{{ old('surname') }}" placeholder="Surname" required>
              <i class="user icon"></i>
            </div>


            @if ($errors->has('surname'))
              <div class="ui error message">
                <p>{{ $errors->first('surname') }}</p>
              </div>
            @endif
          </div>

          <div class="field">
            <label>Givenname</label>
            <div class="ui left icon input">
              <input id="givenname" type="text" name="givenname" value="{{ old('givenname') }}" placeholder="Givenname" required>
              <i class="user icon"></i>
            </div>


            @if ($errors->has('givenname'))
              <div class="ui error message">
                <p>{{ $errors->first('givenname') }}</p>
              </div>
            @endif
          </div>

          <div class="field">
            <label>Username</label>
            <div class="ui left icon input">
              <input id="username" type="text" name="username" value="{{ old('username') }}" placeholder="Username" required>
              <i class="user icon"></i>
            </div>


            @if ($errors->has('username'))
              <div class="ui error message">
                <p>{{ $errors->first('username') }}</p>
              </div>
            @endif
          </div>

          <div class="field">
            <label>E-Mail Address</label>
            <div class="ui left icon input">
              <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="E-Mail Address" required autofocus>
              <i class="mail outline icon"></i>
            </div>


            @if ($errors->has('email'))
              <div class="ui error message">
                <p>{{ $errors->first('email') }}</p>
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
                <p>{{ $errors->first('password') }}</p>
              </div>
            @endif
          </div>

          <div class="field">
            <label>Confirm Password</label>
            <div class="ui left icon input">
              <input id="password" type="password" class="form-control" name="password_confirmation"  placeholder="Confirm Password" required>
              <i class="lock icon"></i>
            </div>

            @if ($errors->has('password_confirmation'))
              <div class="ui error message">
                <p>{{ $errors->first('password_confirmation') }}</p>
              </div>
            @endif
          </div>
          <div class="field">
            <button class="ui button" type="submit">Register</button>
          </div>
          <div class="ui clearing divider"></div>
          <div class="field">
            <a class="large fluid ui facebook button" href="{{route('social.login', 'facebook')}}">
              <i class="facebook icon"></i>
              Facebook
            </a>
          </div>
          <div class="field">
            <a class="large fluid ui google plus button" href="{{route('social.login', 'google')}}">
              <i class="google plus icon"></i>
              Google Plus
            </a>
          </div>

          @include('layouts.includes.message')

        </div>

      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
  <script type="text/javascript">
    $('.ui.checkbox').checkbox();
  </script>
@endsection
