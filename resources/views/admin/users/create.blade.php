@extends('layouts.admin')

@section('page_title')
  CREATE USER
@endsection

@section('content')
  <div class="body_container">
    <span class="page_title">CREATE USER</span>

    @include('layouts.includes.error')
    <div class="register_user_wrapper col-md-8 col-sm-12">
      {!! Form::open(['method' => 'POST', 'action' => 'admin\AdminUsersController@store', 'class' => 'ui form']) !!}
        <div class="field">
          <label>Username</label>
          {!! Form::text('username', null, ['class' => '', 'placeholder'=>'Username']) !!}
        </div>
        <div class="field">
          <label>Email</label>
          {!! Form::email('email', null, ['class' => '', 'placeholder' => 'Email']) !!}
        </div>
        <div class="field">
          <div class="two fields">
            <div class="field">
              <label>Surname</label>
              {!! Form::text('surname', null, ['class' => '', 'placeholder'=>'Surname']) !!}
            </div>
            <div class="field">
              <label>Givenname</label>
              {!! Form::text('givenname', null, ['class' => '', 'placeholder'=>'Givenname']) !!}
            </div>
          </div>
        </div>

        <div class="field">
          <div class="two fields">
            <div class="field">
              <label>Gender</label>
              {!! Form::select('gender', [''=>'Please select a gender', 'M'=>'Male', 'F'=>'Female'], null, ['class' => 'ui fluid dropdown']) !!}
            </div>
            <div class="field">
              <label>Birthday</label>
              {!! Form::date('birthday', null, ['class' => '', 'placeholder'=>'Birthday']) !!}
            </div>
          </div>
        </div>

        <div class="field">
          <label>Password</label>
          {!! Form::password('password', ['class' => '', 'placeholder' => 'Password']) !!}
        </div>
        <div class="field">
          <label>Retype Password</label>
          {!! Form::password('password_confirmation', ['class' => '', 'placeholder' => 'Retype Password']) !!}
        </div>

        {!! Form::submit('Save User', ['class' => 'ui primary button pull-right save_user_btn']) !!}
        <a href="{{route('admin.users.index')}}" class="ui button pull-right">Cancel</a>
      {!! Form::close() !!}

    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    $('.ui.dropdown').dropdown();
  </script>
@endsection
