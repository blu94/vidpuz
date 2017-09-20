@extends('layouts.user')

@section('page_title')
  USERS
@endsection

@section('content')
  <div class="body_container">
    @include('layouts.includes.message')
    <div class="user_profile_container col-md-12 col-sm-12">
      <div class="profile_img col-md-2 col-sm-12">
        @if ($user->profileimage() == NULL)
          <img src="http://via.placeholder.com/150x150" class="edit_profile_image" alt="">
        @elseif ($user->profileimage() != NULL)
          <img src="{{asset($user->profileimage()->path)}}" class="edit_profile_image" alt="">
        @endif

        {{-- upload button --}}
        @if ($user->id == Auth::user()->id)
          <button class="ui button upload_profile_btn">
            <i class="cloud upload icon"></i>
            Upload
          </button>
        @endif

      </div>
      <div class="user_detail_container col-md-10 col-sm-10">
        {{-- edit button --}}
        @if ($user->id == Auth::user()->id)
          <button class="ui inverted blue button edit_profile_btn">Edit Profile</button>
        @endif


        <span class="user_detail_username font_size20 col-md-12 col-sm-12">{{$user->username}}</span>
        <div class="user_detail_item font_size12 col-md-12 col-sm-12">
          <span class="detail_title font_size11 color_grey">Fullname</span>
          <span class="detail_value">{{$user->surname}} {{$user->givenname}}</span>
        </div>
        <div class="user_detail_item font_size12 col-md-12 col-sm-12">
          <span class="detail_title font_size11 color_grey">Gender</span>
          <span class="detail_value font_size12">
            @if ($user->gender == 'M')
              Male
            @elseif ($user->gender == 'F')
              Female
            @endif
          </span>
        </div>
        <div class="user_detail_item font_size12 col-md-12 col-sm-12">
          <span class="detail_title font_size11 color_grey">Birthday</span>
          <span class="detail_value font_size12">{{date('Y-m-d', strtotime($user->birthday))}}</span>
        </div>
        <div class="user_detail_item font_size12 col-md-12 col-sm-12">
          <span class="detail_title font_size11 color_grey">Bio</span>
          <span class="detail_value font_size12">{{$user->bio}}</span>
        </div>
      </div>
    </div>
  </div>

  {{-- edit user profile lightbox --}}
  @if ($user->id == Auth::user()->id)
    <div class="lightbox edit_user_detail_lightbox special_close">
      <div class="lightbox_content not_to_close">
        <div class="edit_profile_lightbox_wrapper">
          {{-- edit detail --}}
          {!! Form::open(['method' => 'PATCH', 'action' => ['user\UserUsersController@update', $user->id], 'class' => 'ui form']) !!}
            <h4 class="ui dividing header margin_top0">User Detail</h4>
            <div class="field">
              <div class="two fields">
                <div class="field">
                  <label>Surname</label>
                  {!! Form::text('surname', $user->surname, ['class' => 'user_detail_surname', 'required' => 'required', 'placeholder' => 'Surname']) !!}
                </div>
                <div class="field">
                  <label>Givenname</label>
                  {!! Form::text('givenname', $user->givenname, ['class' => 'user_detail_givenname', 'required' => 'required', 'placeholder' => 'Givenname']) !!}
                </div>
              </div>
            </div>
            <div class="field">
              <div class="two fields">
                <div class="field">
                  <label>Gender</label>
                  {!! Form::select('gender', ['' => 'Please select a gender', 'M' => 'Male', 'F' => 'Female'], $user->gender, ['class' => 'ui fluid dropdown user_detail_gender', 'required' => 'required']) !!}
                </div>
                <div class="field">
                  <label>Birthday</label>
                  {!! Form::date('birthday', date('Y-m-d',strtotime($user->birthday)), ['class' => 'user_detail_birthday', 'required' => 'required']) !!}
                </div>

              </div>
            </div>
            <div class="field">
              <label>Bio</label>
              {!! Form::textarea('bio', $user->bio, ['rows' => '3', 'required' => 'required']) !!}
            </div>
            @if ($user->id != Auth::user()->id && $user->role_id != 1)
              <div class="ui segment">
                <div class="field">
                  <div class="ui toggle checkbox">
                    @php
                      $check_status = '';
                      if ($user->is_active == 1) {
                        $check_status = 'checked';
                      }

                    @endphp
                    {!! Form::checkbox('status', $user->status, null, ['class' => 'hidden', 'tabindex' => '0', $check_status]) !!}
                    <label>Status</label>
                  </div>
                </div>
              </div>
            @endif


            {!! Form::submit('Update', ['class' => 'ui button update_user_detail_submit_btn']) !!}

          {!! Form::close() !!}
          {{-- edit detail --}}

          {{-- edit password --}}
          @if ($user->id == Auth::user()->id && count($user->socialProviders) == 0)
            {!! Form::open(['method' => 'POST', 'class' => 'ui form']) !!}

              <h4 class="ui dividing header">Edit Password</h4>
              <div class="field">
                <label>Password</label>
                {!! Form::text('password', null, ['class' => '', 'required' => 'required', 'placeholder' => 'Password']) !!}
              </div>

              <div class="field">
                <label>New Password</label>
                {!! Form::text('new_password', null, ['class' => '', 'required' => 'required', 'placeholder' => 'New Password']) !!}
              </div>

              <div class="field">
                <label>Retype Password</label>
                {!! Form::text('retype_password', null, ['class' => '', 'required' => 'required', 'placeholder' => 'Retype Password']) !!}
              </div>

              {!! Form::submit('Update', ['class' => 'ui button change_password_submit_btn']) !!}

            {!! Form::close() !!}
          @elseif ($user->id == Auth::user()->id && count($user->socialProviders) > 0)
            <div class="ui icon message">
              <i class="lock icon"></i>
              <div class="content">
                <div class="header">
                  Change Password?
                </div>
                <p>Please use forget password function.</p>
              </div>
            </div>
          @endif

          {{-- edit password --}}
        </div>
      </div>
    </div>
  @endif

@endsection

@section('scripts')
  <script src="{{asset('js/dropzone.js')}}" charset="utf-8"></script>
  <script type="text/javascript">
    $('.ui.dropdown').dropdown();
    $('.ui.checkbox').checkbox();


    Dropzone.autoDiscover = false;
    var login_user_id = '{{Auth::user()->id}}';
    var specific_user_id = '{{$user->id}}';
    $(".upload_profile_btn").dropzone({
      url: '{{route('user.assets.changeprofileimg')}}',
      acceptedFiles: ".png, .jpg, .bmp, .jpeg, .PNG, .JPG, .BMP, .JPEG",
      maxFiles: 1,
      clickable: '.upload_profile_btn',
      addRemoveLinks: true,
      dictDefaultMessage: "",
      previewsContainer: false,
      sending: function(file, xhr, formData) {
        formData.append("_token", "{{ csrf_token() }}");
        formData.append("user_id", {{$user->id}});
        formData.append("usage", "PROFILE");
      },
      init: function(){
        var myDropzone = this;
        this.on("success", function(file, response) {
          // initialise image from storage folder
          var url = '{{asset('%img%')}}';
          url = url.replace('%img%', response);

          // change profile image on edit
          $(".edit_profile_image").fadeOut(400, function() {
            $(".edit_profile_image").attr('src',url);
          }).fadeIn(400);

          // change sidebar profile image if specific user is login user
          if(login_user_id == specific_user_id) {
            $(".sidebar_profile_pic").fadeOut(400, function() {
              $(".sidebar_profile_pic").attr('src',url);
            }).fadeIn(400);

          }
          myDropzone.removeAllFiles();
        });
      }
    });
  </script>
@endsection
